<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Consultation;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class LiveChat extends Component
{
    public $consultationId;
    public $messages;
    public $messageText = '';
    public $chatEnded = false;
    public $remainingSeconds = 0;
    public $totalDurationSeconds = 0;
    public $isDokter = false; // Tetap gunakan isDokter di PHP
    public $chatStarted = false;
    public $currentUserMessageCount = 0; 
    public $currentDokterMessageCount = 0; // Database: tetap dokter
    public $timerStarted = false;

    public function mount($consultationId)
    {
        $this->consultationId = $consultationId;
        $this->initializeMessageCounts();
        $this->checkInitialTimerStatus();
    }

    public function checkInitialTimerStatus()
    {
        $consultation = Consultation::findOrFail($this->consultationId);
        $this->timerStarted = $consultation->chat_started_at !== null;
        $this->chatStarted = $this->timerStarted;
    }

    public function initializeMessageCounts()
    {
        // Hitung pesan user (klien)
        $consultation = Consultation::findOrFail($this->consultationId);
        $this->currentUserMessageCount = Message::where('consultation_id', $this->consultationId)
            ->where('sender_id', $consultation->user_id)
            ->count();
            
        // Hitung pesan ahli hukum (dokter di database)
        $this->currentDokterMessageCount = Message::where('consultation_id', $this->consultationId)
            ->where('sender_id', $consultation->dokter_id)
            ->count();
    }

    public function formatDuration($seconds)
    {
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        
        if ($hours > 0 && $minutes > 0) {
            return $hours . ' jam ' . $minutes . ' menit';
        } elseif ($hours > 0) {
            return $hours . ' jam';
        } elseif ($minutes > 0) {
            return $minutes . ' menit';
        } else {
            return 'Kurang dari 1 menit';
        }
    }

    public function sendMessage()
    {
        if (trim($this->messageText) === '') return;

        $consultation = Consultation::findOrFail($this->consultationId);
        $senderId = Auth::id();
        $receiverId = $senderId === $consultation->user_id
            ? $consultation->dokter_id
            : $consultation->user_id;

        // Cek apakah ini pesan pertama dari klien
        $isFirstUserMessage = false;
        if ($senderId === $consultation->user_id) {
            $userMessageCount = Message::where('consultation_id', $this->consultationId)
                ->where('sender_id', $consultation->user_id)
                ->count();
            $isFirstUserMessage = $userMessageCount === 0;
        }

        // Kirim pesan klien
        Message::create([
            'consultation_id' => $this->consultationId,
            'sender_id' => $senderId,
            'receiver_id' => $receiverId,
            'message' => $this->messageText,
        ]);

        $this->messageText = '';

        // Jika ini pesan pertama dari klien, kirim pesan otomatis dari ahli hukum
        if ($isFirstUserMessage) {
            $welcomeMessage = "⚖️ Selamat datang di HILAW - Konsultasi Hukum Online!

Terima kasih telah mempercayakan masalah hukum Anda kepada kami. Saya adalah konsultan hukum yang akan membantu memberikan solusi terbaik untuk kasus Anda.

Untuk memberikan konsultasi yang efektif, mohon ceritakan:

📋 **Informasi yang dibutuhkan:**
• Jenis masalah hukum yang dihadapi
• Kronologi atau detail kejadian
• Dokumen/bukti yang dimiliki
• Langkah yang sudah ditempuh (jika ada)
• Target atau hasil yang diharapkan

💡 **Catatan Penting:**
- Semua informasi akan dijaga kerahasiaan
- Konsultasi ini bersifat advisory/saran hukum
- Untuk tindakan hukum formal, diperlukan konsultasi lanjutan

Mari kita mulai konsultasi untuk menemukan solusi hukum yang tepat! 📝";

            Message::create([
                'consultation_id' => $this->consultationId,
                'sender_id' => $consultation->dokter_id, // Ahli hukum (dokter_id di database)
                'receiver_id' => $consultation->user_id,
                'message' => $welcomeMessage,
                'is_system_message' => true
            ]);
        }

        // Update counter pesan
        $this->initializeMessageCounts();

        // Cek apakah timer harus dimulai (kedua pihak sudah kirim 6 pesan)
        $wasTimerStarted = $this->timerStarted;
        
        if ($this->currentUserMessageCount >= 6 && $this->currentDokterMessageCount >= 6 && !$this->timerStarted) {
            $consultation->chat_started_at = now('Asia/Jakarta');
            $consultation->save();
            
            $this->timerStarted = true;
            $this->chatStarted = true;
            
            // Dispatch event untuk update frontend
            $this->dispatch('timer-started');
            $this->dispatch('timer-status-updated', timerStarted: true);
        }

        // Jika timer baru saja dimulai, re-render component
        if (!$wasTimerStarted && $this->timerStarted) {
            $this->render();
        }
    }

    public function endChat()
    {
        $consultation = Consultation::findOrFail($this->consultationId);

        // Hanya ahli hukum yang bisa mengakhiri konsultasi
        if (Auth::id() === $consultation->dokter_id && !$consultation->chat_ended_at) {
            $consultation->chat_ended_at = now('Asia/Jakarta');
            $consultation->save();
            
            // Update status lokal
            $this->chatEnded = true;
            $this->timerStarted = false;
            
            // Dispatch event untuk stop timer di frontend
            $this->dispatch('timer-stopped');
            $this->dispatch('chat-ended-by-ahli');
        }
    }

    public function render()
    {
        $consultation = Consultation::findOrFail($this->consultationId);
        
        // Set status dokter
        $this->isDokter = Auth::id() === $consultation->dokter_id;
        
        $this->initializeMessageCounts();
        
        $this->totalDurationSeconds = $consultation->duration_minutes * 60;
        $this->chatEnded = $consultation->chat_ended_at !== null;
        $this->chatStarted = $consultation->chat_started_at !== null;
        $this->timerStarted = $this->chatStarted && !$this->chatEnded; // Timer hanya aktif jika chat dimulai tapi belum diakhiri

        $chatEndTimestamp = null;

        if ($this->chatStarted && !$this->chatEnded) {
            $start = Carbon::parse($consultation->chat_started_at)->timezone('Asia/Jakarta');
            $now = now('Asia/Jakarta');
            $elapsed = $now->diffInSeconds($start);
            $this->remainingSeconds = max($this->totalDurationSeconds - $elapsed, 0);

            $chatEndTimestamp = $start->addSeconds($this->totalDurationSeconds)->timestamp;

            if ($this->remainingSeconds <= 0) {
                $consultation->chat_ended_at = now('Asia/Jakarta');
                $consultation->save();
                $this->chatEnded = true;
                $this->timerStarted = false;
                $this->dispatch('timer-stopped');
            }
        } else {
            // Jika chat belum dimulai, set remaining seconds ke total duration
            // Jika chat sudah diakhiri, set remaining seconds ke 0
            $this->remainingSeconds = $this->chatEnded ? 0 : $this->totalDurationSeconds;
        }

        $this->messages = Message::where('consultation_id', $this->consultationId)
            ->with('sender')
            ->orderBy('created_at', 'asc')
            ->get();

        // Debug log
        \Log::info('LiveChat Legal Consultation Debug', [
            'timerStarted' => $this->timerStarted,
            'chatStarted' => $this->chatStarted,
            'remainingSeconds' => $this->remainingSeconds,
            'chatEndTimestamp' => $chatEndTimestamp,
            'klienMessages' => $this->currentUserMessageCount,
            'dokterMessages' => $this->currentDokterMessageCount,
            'isDokter' => $this->isDokter
        ]);

        return view('livewire.live-chat', [
            'chatEndTimestamp' => $chatEndTimestamp,
        ]);
    }

    public function checkChatStatus()
    {
        $consultation = Consultation::find($this->consultationId);

        if (!$consultation) return;

        $this->chatEnded = $consultation->chat_ended_at !== null;
        
        // Jika chat sudah diakhiri, hentikan timer dan keluar
        if ($this->chatEnded) {
            $this->timerStarted = false;
            $this->dispatch('timer-stopped'); // Dispatch event untuk stop timer di frontend
            return;
        }

        $this->initializeMessageCounts();

        // Sync status dokter
        $this->isDokter = Auth::id() === $consultation->dokter_id;

        // Cek apakah timer harus dimulai
        $wasTimerStarted = $this->timerStarted;
        
        if ($this->currentUserMessageCount >= 6 && $this->currentDokterMessageCount >= 6 && !$consultation->chat_started_at) {
            $consultation->chat_started_at = now('Asia/Jakarta');
            $consultation->save();
            
            $this->timerStarted = true;
            $this->chatStarted = true;
            
            // Dispatch event untuk update frontend
            $this->dispatch('timer-started');
        }

        // Update status dari database
        $this->chatStarted = $consultation->chat_started_at !== null;
        $this->timerStarted = $this->chatStarted && !$this->chatEnded; // Timer hanya aktif jika chat dimulai tapi belum diakhiri

        // Jika status berubah, re-render untuk update JavaScript variables
        if ($wasTimerStarted !== $this->timerStarted) {
            // Force re-render component
            $this->skipRender = false;
        }

        if ($this->chatStarted && !$this->chatEnded) {
            $this->totalDurationSeconds = $consultation->duration_minutes * 60;
            $start = Carbon::parse($consultation->chat_started_at)->timezone('Asia/Jakarta');
            $now = now('Asia/Jakarta');
            $elapsed = $now->diffInSeconds($start);
            $this->remainingSeconds = max(0, $this->totalDurationSeconds - $elapsed);
            
            if ($this->remainingSeconds <= 0) {
                $consultation->chat_ended_at = now('Asia/Jakarta');
                $consultation->save();
                $this->chatEnded = true;
                $this->timerStarted = false;
                $this->dispatch('timer-stopped');
            }
        }
    }
}