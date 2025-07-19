<div>
    <div class="d-flex justify-content-between mb-2">
        <div>
            <strong>Durasi Konsultasi:</strong>
            {{ gmdate("H:i:s", $totalDurationSeconds) }} WIB
        </div>
        <div wire:ignore>
            <p><strong>Sisa Waktu:</strong> <span id="countdown"></span></p>
        </div>
    </div>

    <div class="border p-3 h-96 overflow-y-auto bg-white rounded shadow">
        <div wire:poll.3000ms.keep-alive>
            @forelse ($messages as $msg)
                <div class="mb-2 {{ $msg->sender_id === auth()->id() ? 'text-end' : 'text-start' }}">
                    <strong>{{ $msg->sender_id === auth()->id() ? 'Anda' : $msg->sender->name }}:</strong>
                    <div>{{ $msg->message }}</div>
                    <small class="text-muted text-xs">{{ $msg->created_at->diffForHumans() }}</small>
                </div>
            @empty
                <p class="text-center text-muted">Belum ada pesan</p>
            @endforelse
        </div>
    </div>

    <form wire:submit.prevent="sendMessage" class="mt-3 d-flex gap-2">
        @if (!$chatEnded)
            <input type="text" wire:model.defer="messageText" class="form-control flex-fill" placeholder="Ketik pesan...">
            <button class="btn btn-primary">Kirim</button>
        @else
            <input type="text" class="form-control" disabled placeholder="Chat telah diakhiri">
            <button class="btn btn-secondary" disabled>Kirim</button>
        @endif
    </form>

    @if ($isDokter && !$chatEnded)
        <div class="mt-2 text-end">
            <button wire:click="endChat" class="btn btn-danger">Akhiri Chat</button>
        </div>
    @elseif ($chatEnded)
        <div class="mt-2 text-center text-danger fw-bold">Chat telah diakhiri</div>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let remaining = {{ $remainingSeconds }};
            const countdownEl = document.getElementById('countdown');

            function updateCountdown() {
                if (remaining <= 0) {
                    countdownEl.textContent = '00:00:00';
                    return;
                }

                const hours = String(Math.floor(remaining / 3600)).padStart(2, '0');
                const minutes = String(Math.floor((remaining % 3600) / 60)).padStart(2, '0');
                const seconds = String(remaining % 60).padStart(2, '0');

                countdownEl.textContent = `${hours}:${minutes}:${seconds}`;
                remaining--;
            }

            updateCountdown();
            setInterval(updateCountdown, 1000);
        });
    </script>
</div>
