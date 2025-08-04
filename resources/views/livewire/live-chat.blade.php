<div class="livechat-container">
    <div wire:poll.5s="checkChatStatus"></div>
    
    <!-- Header Info -->
    <div class="row mb-3">
        <div class="col-md-6">
            <div class="card border-0 bg-light">
                <div class="card-body py-2">
                    <small><strong>Durasi:</strong> {{ $this->formatDuration($totalDurationSeconds) }}</small>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 bg-light">
                <div class="card-body py-2">
                    <small><strong>Sisa Waktu:</strong> 
                        <span id="countdown" wire:ignore class="{{ $remainingSeconds <= 300 ? 'text-danger fw-bold' : 'text-success fw-bold' }}">
                            @if($timerStarted)
                                {{ $this->formatDuration($remainingSeconds) }}
                            @else
                                Menunggu pesan...
                            @endif
                        </span>
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- Status -->
    <div class="alert alert-success py-2 mb-3 border-0">
        @if($isDokter)
            <i class="fas fa-balance-scale text-success"></i> Ahli Hukum
        @else
            <i class="fas fa-user text-success"></i> Klien
        @endif
        
        @if($timerStarted)
            <span class="badge bg-dark ms-2">Timer Aktif</span>
        @endif
    </div>

    <!-- Chat Area -->
    <div class="card border-success">
        <div class="card-header bg-success text-white">
            <i class="fas fa-comments"></i> Konsultasi Hukum
        </div>
        <div class="card-body p-0">
            <div class="chat-box" id="chatContainer">
                <div wire:poll.3s.keep-alive class="px-2 py-3">
                    @forelse ($messages as $msg)
                        @php
                            $isSystemMessage = isset($msg->is_system_message) && $msg->is_system_message;
                            $isOwnMessage = $msg->sender_id === auth()->id();
                        @endphp
                        
                        @if($isSystemMessage)
                            <!-- Pesan Sistem/Welcome -->
                            <div class="mb-3 d-flex justify-content-center">
                                <div class="system-message">
                                    <div class="system-message-header">
                                        <i class="fas fa-gavel text-success"></i>
                                        <strong>HILAW - Konsultan Hukum</strong>
                                        <small class="text-muted ms-1">{{ $msg->created_at->format('H:i') }}</small>
                                    </div>
                                    <div class="system-message-text">{!! nl2br(e($msg->message)) !!}</div>
                                </div>
                            </div>
                        @else
                            <!-- Pesan Normal -->
                            <div class="mb-2 d-flex {{ $isOwnMessage ? 'justify-content-end' : 'justify-content-start' }}">
                                <div class="message {{ $isOwnMessage ? 'sent' : 'received' }}">
                                    <div class="message-header">
                                        <strong>{{ $isOwnMessage ? 'Anda' : $msg->sender->name }}</strong>
                                        <small class="text-muted ms-1">{{ $msg->created_at->format('H:i') }}</small>
                                    </div>
                                    <div class="message-text">{{ $msg->message }}</div>
                                </div>
                            </div>
                        @endif
                    @empty
                        <div class="text-center py-5 text-muted">
                            <i class="fas fa-comments fa-2x mb-2 text-success"></i>
                            <p class="mb-0">Belum ada pesan. Mulai konsultasi hukum!</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Input -->
    <div class="card mt-3 border-success">
        <div class="card-body">
            <form wire:submit.prevent="sendMessage">
                @if (!$chatEnded)
                    <div class="input-group">
                        <input type="text" 
                               wire:model.defer="messageText" 
                               class="form-control border-success" 
                               placeholder="Ketik pesan..." 
                               maxlength="500">
                        <button class="btn btn-success" type="submit">
                            <i class="fas fa-paper-plane"></i> Kirim
                        </button>
                    </div>
                @else
                    <div class="input-group">
                        <input type="text" class="form-control" disabled placeholder="Konsultasi telah diakhiri">
                        <button class="btn btn-secondary" disabled>Kirim</button>
                    </div>
                @endif
            </form>

            @if ($isDokter && !$chatEnded)
                <div class="mt-2 text-end">
                    <button wire:click="endChat" 
                            class="btn btn-danger btn-sm" 
                            onclick="return confirm('Yakin ingin mengakhiri konsultasi?')">
                        <i class="fas fa-stop"></i> Akhiri Konsultasi
                    </button>
                </div>
            @endif

            @if ($chatEnded)
                <div class="alert alert-warning mt-2 mb-0">
                    <i class="fas fa-info-circle"></i> Konsultasi telah diakhiri
                </div>
            @endif
        </div>
    </div>

    <style>
    .chat-box {
        height: 400px;
        overflow-y: auto;
        background: #f8fff8;
        border-radius: 0;
    }

    .livechat-container {
        max-width: 900px;
        margin: 0 auto;
    }

    .message {
        max-width: 60%;
        min-width: 120px;
        padding: 8px 12px;
        border-radius: 12px;
        word-wrap: break-word;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }

    .message.sent {
        background: #28a745;
        color: white;
        border-bottom-right-radius: 4px;
        margin-left: 20px;
    }

    .message.received {
        background: white;
        border: 1px solid #dee2e6;
        color: #333;
        border-bottom-left-radius: 4px;
        margin-right: 20px;
    }

    .message-header {
        font-size: 0.8em;
        margin-bottom: 4px;
        opacity: 0.8;
        font-weight: 600;
    }

    .message-text {
        font-size: 0.9em;
        line-height: 1.3;
    }

    .system-message {
        max-width: 80%;
        padding: 12px 16px;
        background: linear-gradient(135deg, #e8f5e8, #f0f9f0);
        border: 2px solid #28a745;
        border-radius: 12px;
        text-align: center;
        box-shadow: 0 2px 8px rgba(40, 167, 69, 0.2);
    }

    .system-message-header {
        font-size: 0.85em;
        margin-bottom: 8px;
        color: #28a745;
        font-weight: 600;
    }

    .system-message-text {
        font-size: 0.9em;
        line-height: 1.4;
        color: #155724;
        text-align: left;
    }

    .chat-box::-webkit-scrollbar {
        width: 6px;
    }

    .chat-box::-webkit-scrollbar-thumb {
        background: #28a745;
        border-radius: 3px;
    }

    .chat-box::-webkit-scrollbar-track {
        background: #e8f5e8;
    }

    .card-header.bg-success {
        background: linear-gradient(135deg, #28a745, #20c997) !important;
    }

    .btn-success {
        background: linear-gradient(135deg, #28a745, #20c997);
        border: none;
    }

    .btn-success:hover {
        background: linear-gradient(135deg, #218838, #1ba085);
        border: none;
    }

    .border-success {
        border-color: #28a745 !important;
    }

    .alert-success {
        background-color: #e8f5e8;
        border-color: #28a745;
        color: #155724;
    }

    .badge.bg-success {
        background-color: #28a745 !important;
    }

    .text-success {
        color: #28a745 !important;
    }
    </style>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        // Auto scroll
        function scrollToBottom() {
            const container = document.getElementById('chatContainer');
            if (container) {
                container.scrollTop = container.scrollHeight;
            }
        }

        // Scroll saat load
        setTimeout(scrollToBottom, 100);

        // Observer untuk scroll otomatis
        const container = document.getElementById('chatContainer');
        if (container) {
            const observer = new MutationObserver(scrollToBottom);
            observer.observe(container, { childList: true, subtree: true });
        }

        // Timer countdown dengan data yang selalu fresh
        const countdownEl = document.getElementById('countdown');
        let endTimestamp = @json($chatEndTimestamp);
        let timerStarted = @json($timerStarted);
        let remainingSeconds = @json($remainingSeconds);
        let totalDuration = @json($totalDurationSeconds);

        function updateTimer() {
            if (!countdownEl) return;

            // Jika chat sudah diakhiri, tampilkan status "Konsultasi diakhiri"
            const chatEndedAlert = document.querySelector('.alert-warning');
            if (chatEndedAlert && chatEndedAlert.textContent.includes('Konsultasi telah diakhiri')) {
                countdownEl.textContent = 'Konsultasi diakhiri';
                countdownEl.className = 'text-warning fw-bold';
                return;
            }

            // Re-check timer status dari elemen DOM
            const timerBadge = document.querySelector('.badge.bg-dark');
            const isTimerActive = timerBadge && timerBadge.textContent.includes('Timer Aktif');

            if (!timerStarted && !isTimerActive) {
                countdownEl.textContent = 'Menunggu pesan...';
                countdownEl.className = 'text-muted';
                return;
            }

            // Jika timer aktif, gunakan remaining seconds dari server
            if (timerStarted || isTimerActive) {
                let remaining = remainingSeconds;

                // Jika ada endTimestamp, hitung dari timestamp
                if (endTimestamp) {
                    const now = Math.floor(Date.now() / 1000);
                    remaining = Math.max(0, endTimestamp - now);
                }

                if (remaining <= 0) {
                    countdownEl.textContent = 'Waktu habis';
                    countdownEl.className = 'text-danger fw-bold';
                    return;
                }

                const hours = Math.floor(remaining / 3600);
                const minutes = Math.floor((remaining % 3600) / 60);
                const seconds = remaining % 60;

                let timeText = '';
                if (hours > 0) timeText += hours + ' jam ';
                if (minutes > 0) timeText += minutes + ' menit ';
                if (seconds > 0) timeText += seconds + ' detik';

                countdownEl.textContent = timeText.trim() || 'Waktu habis';
                
                // Update warna berdasarkan waktu tersisa
                if (remaining <= 300) {
                    countdownEl.className = 'text-danger fw-bold';
                } else {
                    countdownEl.className = 'text-success fw-bold';
                }

                // Kurangi remaining seconds untuk update berikutnya (countdown lokal)
                if (remainingSeconds > 0) {
                    remainingSeconds--;
                }
            } else {
                countdownEl.textContent = 'Menunggu pesan...';
                countdownEl.className = 'text-muted';
            }
        }

        updateTimer();
        const timerInterval = setInterval(updateTimer, 1000);

        // Auto focus input
        const messageInput = document.querySelector('input[wire\\:model\\.defer="messageText"]');
        if (messageInput) {
            messageInput.focus();
        }

        // Listen untuk perubahan timer status dari Livewire
        window.addEventListener('timer-status-updated', function(event) {
            timerStarted = event.detail.timerStarted;
            updateTimer();
        });

        // Listen untuk timer stopped event
        window.addEventListener('timer-stopped', function() {
            timerStarted = false;
            remainingSeconds = 0;
            updateTimer();
            
            // Tampilkan notifikasi bahwa timer telah dihentikan
            const notification = document.createElement('div');
            notification.className = 'alert alert-warning alert-dismissible fade show position-fixed';
            notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
            notification.innerHTML = `
                <strong><i class="fas fa-stop-circle text-warning"></i> Timer Dihentikan!</strong><br>
                <small>Konsultasi telah diakhiri oleh ahli hukum.</small>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            document.body.appendChild(notification);
            
            // Auto remove setelah 5 detik
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.parentNode.removeChild(notification);
                }
            }, 5000);
        });

        // Listen untuk chat ended by ahli event
        window.addEventListener('chat-ended-by-ahli', function() {
            // Refresh halaman setelah 2 detik untuk memastikan UI ter-update
            setTimeout(() => {
                location.reload();
            }, 2000);
        });

        // Listen untuk Livewire component updates
        document.addEventListener('livewire:updated', function () {
            // Update data dari component yang ter-render ulang
            const newTimerStarted = @json($timerStarted);
            const newEndTimestamp = @json($chatEndTimestamp);
            const newRemainingSeconds = @json($remainingSeconds);
            const newChatEnded = @json($chatEnded);
            
            if (newTimerStarted !== timerStarted) {
                timerStarted = newTimerStarted;
            }
            
            if (newEndTimestamp !== endTimestamp) {
                endTimestamp = newEndTimestamp;
            }

            if (newRemainingSeconds !== remainingSeconds) {
                remainingSeconds = newRemainingSeconds;
            }

            // Jika chat diakhiri, hentikan timer
            if (newChatEnded && !timerStarted) {
                timerStarted = false;
                remainingSeconds = 0;
            }
            
            updateTimer();
        });
    });

    // Timer started notification
    window.addEventListener('timer-started', function() {
        // Update status timer di JS
        const countdownEl = document.getElementById('countdown');
        if (countdownEl) {
            // Force update timer status
            window.dispatchEvent(new CustomEvent('timer-status-updated', {
                detail: { timerStarted: true }
            }));
        }

        // Buat notifikasi sederhana dengan styling hijau
        const notification = document.createElement('div');
        notification.className = 'alert alert-success alert-dismissible fade show position-fixed';
        notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
        notification.innerHTML = `
            <strong><i class="fas fa-play-circle text-success"></i> Timer Dimulai!</strong><br>
            <small>Kedua pihak telah mengirim 6 pesan. Waktu konsultasi mulai berjalan.</small>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        document.body.appendChild(notification);
        
        // Auto remove setelah 5 detik
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 5000);
    });

    // Livewire hook untuk scroll setelah message sent
    Livewire.hook('message.processed', (message, component) => {
        if (component.fingerprint.name === 'live-chat') {
            setTimeout(() => {
                const container = document.getElementById('chatContainer');
                if (container) {
                    container.scrollTop = container.scrollHeight;
                }
            }, 100);
        }
    });

    // Hook untuk update setelah component di-render ulang
    Livewire.hook('component.initialized', (component) => {
        if (component.fingerprint.name === 'live-chat') {
            // Trigger update timer setelah component initialized
            setTimeout(() => {
                const event = new CustomEvent('livewire:updated');
                document.dispatchEvent(event);
            }, 100);
        }
    });
    </script>
</div>