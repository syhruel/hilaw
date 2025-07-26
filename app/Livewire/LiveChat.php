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
    public $isDokter = false;
    public $chatStarted = false;
    public $currentUserMessageCount = 0; 
    public $hasRefreshed = false; 

    public function mount($consultationId)
    {
        $this->consultationId = $consultationId;
        $this->initializeMessageCount();
        $this->checkRefreshStatus();
    }

    public function initializeMessageCount()
    {
        $currentUserId = Auth::id();
        $sessionKey = 'message_count_' . $currentUserId . '_' . $this->consultationId;
        $this->currentUserMessageCount = session($sessionKey, 0);
    }

    public function checkRefreshStatus()
    {
        $currentUserId = Auth::id();
        $refreshKey = 'has_refreshed_' . $currentUserId . '_' . $this->consultationId;
        $this->hasRefreshed = session($refreshKey, false);
    }

    public function sendMessage()
    {
        if (trim($this->messageText) === '') return;

        $consultation = Consultation::findOrFail($this->consultationId);
        $senderId = Auth::id();
        $receiverId = $senderId === $consultation->user_id
            ? $consultation->dokter_id
            : $consultation->user_id;

        Message::create([
            'consultation_id' => $this->consultationId,
            'sender_id' => $senderId,
            'receiver_id' => $receiverId,
            'message' => $this->messageText,
        ]);

        $this->messageText = '';

        $currentUserId = Auth::id();
        $this->currentUserMessageCount++;
        $sessionKey = 'message_count_' . $currentUserId . '_' . $this->consultationId;
        session([$sessionKey => $this->currentUserMessageCount]);

        if ($this->currentUserMessageCount >= 2 && !$this->hasRefreshed) {
            $refreshKey = 'has_refreshed_' . $currentUserId . '_' . $this->consultationId;
            session([$refreshKey => true]);
            session()->forget($sessionKey);
            
            $this->hasRefreshed = true;
            $this->currentUserMessageCount = 0;
            
            $userType = $this->isDokter ? 'dokter' : 'pengguna';
            $this->dispatch('auto-refresh-page', ['userType' => $userType]);
        }

        if (!$consultation->chat_started_at) {
            $userSent = Message::where('consultation_id', $this->consultationId)
                ->where('sender_id', $consultation->user_id)
                ->exists();

            $dokterSent = Message::where('consultation_id', $this->consultationId)
                ->where('sender_id', $consultation->dokter_id)
                ->exists();

            if ($userSent && $dokterSent) {
                $consultation->chat_started_at = now('Asia/Jakarta');
                $consultation->save();
                
                $this->chatStarted = true;
                $this->dispatch('chat-started-refresh');
            }
        }
    }

    public function endChat()
    {
        $consultation = Consultation::findOrFail($this->consultationId);

        if (Auth::id() === $consultation->dokter_id && !$consultation->chat_ended_at) {
            $consultation->chat_ended_at = now('Asia/Jakarta');
            $consultation->save();
        }
    }

    public function render()
    {
        $consultation = Consultation::findOrFail($this->consultationId);
        $this->isDokter = Auth::id() === $consultation->dokter_id;
        
        $this->initializeMessageCount();
        $this->checkRefreshStatus();
        
        $this->totalDurationSeconds = $consultation->duration_minutes * 60;
        $this->chatEnded = $consultation->chat_ended_at !== null;
        $this->chatStarted = $consultation->chat_started_at !== null;

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
            }
        } else {
            $this->remainingSeconds = $this->totalDurationSeconds;
        }

        $this->messages = Message::where('consultation_id', $this->consultationId)
            ->with('sender')
            ->orderBy('created_at', 'asc')
            ->get();

        return view('livewire.live-chat', [
            'chatEndTimestamp' => $chatEndTimestamp,
        ]);
    }

    public function checkChatStatus()
    {
        $consultation = Consultation::find($this->consultationId);

        if (!$consultation) return;

        $this->chatEnded = $consultation->chat_ended_at !== null;
        
        if ($this->chatEnded) return;

        $wasChatStarted = $this->chatStarted; 

        if (!$consultation->chat_started_at) {
            $userSent = Message::where('consultation_id', $this->consultationId)
                ->where('sender_id', $consultation->user_id)
                ->exists();

            $dokterSent = Message::where('consultation_id', $this->consultationId)
                ->where('sender_id', $consultation->dokter_id)
                ->exists();

            if ($userSent && $dokterSent) {
                $consultation->chat_started_at = now('Asia/Jakarta');
                $consultation->save();
            }
        }

        $this->chatStarted = $consultation->chat_started_at !== null;

        if (!$wasChatStarted && $this->chatStarted) {
            $this->dispatch('chat-started-refresh');
        }

        if ($this->chatStarted) {
            $this->totalDurationSeconds = $consultation->duration_minutes * 60;
            $start = Carbon::parse($consultation->chat_started_at)->timezone('Asia/Jakarta');
            $now = now('Asia/Jakarta');
            $elapsed = $now->diffInSeconds($start);
            $this->remainingSeconds = max(0, $this->totalDurationSeconds - $elapsed);
            
            if ($this->remainingSeconds <= 0) {
                $consultation->chat_ended_at = now('Asia/Jakarta');
                $consultation->save();
                $this->chatEnded = true;
            }
        }
    }
}