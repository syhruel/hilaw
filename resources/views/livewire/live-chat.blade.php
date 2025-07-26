<div>
    <div wire:poll.5s="checkChatStatus"></div>
    <div class="d-flex justify-content-between mb-2">
        <div>
            <strong>Durasi Konsultasi:</strong>
            {{ gmdate("H:i:s", $totalDurationSeconds) }} WIB
        </div>
        <div>
            <p><strong>Sisa Waktu:</strong>
                <span id="countdown" wire:ignore class="{{ $remainingSeconds <= 300 ? 'text-danger fw-bold' : '' }}">
                    {{ $chatStarted ? gmdate("H:i:s", $remainingSeconds) : 'Menunggu mulai...' }}
                </span>
            </p>
        </div>
    </div>

    <div class="mb-2">
        <small class="text-muted">
            @if($isDokter)
                <i class="fas fa-user-md"></i> Dokter - 
            @else
                <i class="fas fa-user"></i> Pengguna - 
            @endif
            
            @if($hasRefreshed)
                <span class="badge bg-success">Sudah refresh (1x)</span>
                <span class="text-muted">- Tidak ada refresh lagi</span>
            @else
                Pesan dikirim: <span class="badge bg-info">{{ $currentUserMessageCount }}/2</span>
                @if($currentUserMessageCount >= 2)
                    <span class="text-success">- Halaman akan refresh otomatis</span>
                @endif
            @endif
        </small>
    </div>

    <div class="border p-3 h-96 overflow-y-auto bg-white rounded shadow">
        <div wire:poll.3s.keep-alive>
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
            <input type="text" wire:model.defer="messageText" class="form-control flex-fill" 
                   placeholder="Ketik pesan..." maxlength="500">
            <button class="btn btn-primary" type="submit">Kirim</button>
        @else
            <input type="text" class="form-control" disabled placeholder="Chat telah diakhiri">
            <button class="btn btn-secondary" disabled>Kirim</button>
        @endif
    </form>

    @if ($isDokter && !$chatEnded)
        <div class="mt-2 text-end">
            <button wire:click="endChat" class="btn btn-danger" 
                    onclick="return confirm('Apakah Anda yakin ingin mengakhiri chat ini?')">
                Akhiri Chat
            </button>
        </div>
    @elseif ($chatEnded)
        <div class="mt-2 text-center text-danger fw-bold">Chat telah diakhiri</div>
    @endif

@if ($chatStarted && !$chatEnded)
    <div id="countdown" class="text-dark fw-bold"></div>
@endif

<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (window.chatCountdownInterval) {
            clearInterval(window.chatCountdownInterval);
        }

        const countdownEl = document.getElementById('countdown');
        const endTimestamp = @json($chatEndTimestamp);

        if (!countdownEl || !endTimestamp) return;

        function updateCountdown() {
            const now = Math.floor(Date.now() / 1000);
            const remaining = endTimestamp - now;

            if (remaining <= 0) {
                countdownEl.textContent = '00:00:00';
                countdownEl.className = 'text-danger fw-bold';
                clearInterval(window.chatCountdownInterval);
                return;
            }

            const hours = String(Math.floor(remaining / 3600)).padStart(2, '0');
            const minutes = String(Math.floor((remaining % 3600) / 60)).padStart(2, '0');
            const seconds = String(remaining % 60).padStart(2, '0');

            countdownEl.textContent = `${hours}:${minutes}:${seconds}`;
            countdownEl.className = remaining <= 300 ? 'text-danger fw-bold' : '';
        }

        updateCountdown();
        window.chatCountdownInterval = setInterval(updateCountdown, 1000);

        Livewire.hook('element.removed', () => {
            clearInterval(window.chatCountdownInterval);
            window.chatCountdownInterval = null;
        });
    });

    // Script untuk refresh halaman ketika chat dimulai
    window.addEventListener('chat-started-refresh', function() {
        const storageKey = 'chatStartedRefresh_{{ $consultationId }}';
        
        if (!sessionStorage.getItem(storageKey)) {
            sessionStorage.setItem(storageKey, 'true');
            console.log('Chat dimulai! Refresh halaman...');
            
            setTimeout(() => {
                location.reload();
            }, 500);
        }
    });

    // Script untuk auto refresh setelah 2 pesan (HANYA 1 KALI per user)
    window.addEventListener('auto-refresh-page', function(event) {
        const userType = event.detail && event.detail.userType ? event.detail.userType : 'user';
        const currentUserId = {{ auth()->id() }};
        const refreshFlagKey = `refresh_executed_${currentUserId}_{{ $consultationId }}`;
        
        // Cek apakah refresh sudah pernah dieksekusi di browser ini
        if (localStorage.getItem(refreshFlagKey)) {
            console.log('Refresh sudah pernah dilakukan, dibatalkan!');
            return;
        }
        
        // Set flag di localStorage untuk prevent refresh berulang
        localStorage.setItem(refreshFlagKey, 'true');
        
        console.log(`Auto refresh triggered - 2 pesan telah dikirim oleh ${userType}! (HANYA 1 KALI)`);
        
        // Tampilkan notifikasi sebelum refresh
        const notification = document.createElement('div');
        notification.innerHTML = `
            <div class="alert alert-warning alert-dismissible fade show position-fixed" 
                 style="top: 20px; right: 20px; z-index: 9999; min-width: 400px;">
                <i class="fas fa-sync-alt fa-spin"></i> 
                <strong>${userType === 'dokter' ? 'Dokter' : 'Pengguna'}</strong> telah mengirim 2 pesan.<br>
                <strong>REFRESH OTOMATIS (1 KALI SAJA)</strong> dalam <span id="refresh-countdown">3</span> detik...
                <small class="d-block mt-1 text-muted">Setelah ini tidak akan ada refresh lagi</small>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
        document.body.appendChild(notification);
        
        // Countdown untuk refresh
        let countdown = 3;
        const countdownEl = document.getElementById('refresh-countdown');
        const countdownInterval = setInterval(() => {
            countdown--;
            if (countdownEl) {
                countdownEl.textContent = countdown;
            }
            if (countdown <= 0) {
                clearInterval(countdownInterval);
                location.reload();
            }
        }, 1000);
    });

    // Cleanup localStorage jika halaman di-refresh manual (optional)
    window.addEventListener('beforeunload', function() {
        // Jangan cleanup jika ini adalah auto refresh
        if (!document.querySelector('.alert-warning')) {
            // Optional: bisa dihapus jika ingin permanent
            // const currentUserId = {{ auth()->id() }};
            // const refreshFlagKey = `refresh_executed_${currentUserId}_{{ $consultationId }}`;
            // localStorage.removeItem(refreshFlagKey);
        }
    });
</script>

</div>