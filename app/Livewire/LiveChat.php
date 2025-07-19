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

    public function mount($consultationId)
    {
        $this->consultationId = $consultationId;
    }

    public function sendMessage()
    {
        if (trim($this->messageText) === '') return;

        $consultation = Consultation::findOrFail($this->consultationId);

        if (!$consultation->chat_started_at) {
            $senders = Message::where('consultation_id', $this->consultationId)->distinct()->pluck('sender_id');

            if (
                $senders->contains($consultation->user_id) &&
                $senders->contains($consultation->dokter_id)
            ) {
                $consultation->chat_started_at = now('Asia/Jakarta');
                $consultation->save();
            }
        }

        $receiverId = Auth::id() === $consultation->user_id
            ? $consultation->dokter_id
            : $consultation->user_id;

        Message::create([
            'consultation_id' => $this->consultationId,
            'sender_id' => Auth::id(),
            'receiver_id' => $receiverId,
            'message' => $this->messageText,
        ]);

        $this->messageText = '';
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

        $durationSeconds = $consultation->duration_minutes * 60;
        $chatEnded = $consultation->chat_ended_at !== null;
        $remainingSeconds = $durationSeconds;

        if ($consultation->chat_started_at) {
            $start = \Carbon\Carbon::parse($consultation->chat_started_at)->timezone('Asia/Jakarta');
            $now = now('Asia/Jakarta');

            $elapsedSeconds = $now->diffInSeconds($start);
            $remainingSeconds = max($durationSeconds - $elapsedSeconds, 0);

            if (!$chatEnded && $remainingSeconds <= 0) {
                $consultation->chat_ended_at = now('Asia/Jakarta');
                $consultation->save();
                $chatEnded = true;
            }
        }

        $this->messages = Message::where('consultation_id', $this->consultationId)
            ->with('sender')
            ->orderBy('created_at', 'asc')
            ->get();

        return view('livewire.live-chat', [
            'consultation' => $consultation,
            'remainingSeconds' => $remainingSeconds,
            'chatEnded' => $chatEnded,
            'isDokter' => auth()->id() === $consultation->dokter_id,
            'totalDurationSeconds' => $durationSeconds,
        ]);
    }
}
