<?php
namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;
    
    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'password',
        'role',
        'phone',
        'gender',  
        'date_of_birth',
        'foto',
        'is_approved',
        'was_pending',
        'approval_status',
        'rejection_reason',
        'is_online',
        'is_suspended', // tambah field suspended
        'last_active_at', // tambah field last active
        'tarif_konsultasi',
        'jadwal_kerja',
        'keahlian',
        'lulusan_universitas',
        'alamat',
        'pengalaman_tahun',
        'pengalaman_deskripsi',
        'sertifikat',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'date_of_birth' => 'date',
        'last_active_at' => 'datetime', // cast last_active_at
        'is_approved' => 'boolean',
        'was_pending' => 'boolean',
        'is_online' => 'boolean',
        'is_suspended' => 'boolean', // cast is_suspended
        'pengalaman_tahun' => 'integer',
        'tarif_konsultasi' => 'decimal:2',
    ];

    // ============= RELASI =============
    public function consultationsAsDoctor()
    {
        return $this->hasMany(\App\Models\Consultation::class, 'dokter_id');
    }

    public function consultationsAsPatient()
    {
        return $this->hasMany(\App\Models\Consultation::class, 'user_id');
    }

    public function profileChanges()
    {
        return $this->hasMany(ProfileChange::class);
    }

    public function pendingProfileChanges()
    {
        return $this->hasMany(ProfileChange::class)->where('status', 'pending');
    }

    public function invoicesAsPatient()
    {
        return $this->hasMany(Invoice::class, 'user_id');
    }

    public function invoicesAsDoctor()
    {
        return $this->hasMany(Invoice::class, 'dokter_id');
    }

    // ============= SCOPE =============
    public function scopeDokter($query)
    {
        return $query->where('role', 'dokter');
    }

    public function scopeOnline($query)
    {
        return $query->where('is_online', true);
    }

    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    public function scopeActive($query)
    {
        return $query->where('is_suspended', false);
    }

    public function scopeSuspended($query)
    {
        return $query->where('is_suspended', true);
    }

    // ============= HELPER METHODS =============
    
    /**
     * Check if user is currently active (online in last 5 minutes)
     */
    public function isCurrentlyActive()
    {
        if (!$this->last_active_at) {
            return false;
        }
        
        return $this->last_active_at->diffInMinutes(now()) <= 5;
    }

    /**
     * Update last active timestamp
     */
    public function updateLastActive()
    {
        $this->update(['last_active_at' => now()]);
    }

    /**
     * Get formatted last active status
     */
    public function getLastActiveStatusAttribute()
    {
        if (!$this->last_active_at) {
            return 'Belum pernah aktif';
        }

        if ($this->isCurrentlyActive()) {
            return 'Aktif sekarang';
        }

        return 'Terakhir aktif ' . $this->last_active_at->diffForHumans();
    }

    // ============= LOGIKA BUTTON =============

    public function getKonsultasiAktifDengan($userId)
    {
        return $this->consultationsAsDoctor()
            ->where('user_id', $userId)
            ->whereIn('status', ['pending', 'approved']) 
            ->whereNull('chat_ended_at')
            ->with('payment') 
            ->orderBy('created_at', 'desc') 
            ->first(); 
    }

    public function getStatusTombol($userId)
    {
        $konsultasi = $this->getKonsultasiAktifDengan($userId);
        if (!$konsultasi) {
            return 'konsultasi';
        }
        
        if ($konsultasi->status === 'pending') {
            return 'bayar';
        }
        
        if ($konsultasi->status === 'approved') {
            if (!$konsultasi->payment) {
                return 'bayar';
            }
            
            $statusPayment = $konsultasi->payment->status;
            
            if (in_array($statusPayment, ['pending', 'unpaid', 'waiting'])) {
                return 'bayar';
            }
            
            if (in_array($statusPayment, ['paid', 'completed', 'success', 'approved'])) {
                return 'chat';
            }
        }
        return 'konsultasi';
    }

    public function getTeksTombol($userId)
    {
        $status = $this->getStatusTombol($userId);
        
        switch ($status) {
            case 'bayar':
                return 'Bayar';
            case 'chat':
                return 'Lanjutkan Chat';
            case 'konsultasi':
            default:
                return 'Konsultasi';
        }
    }

    public function getUrlTombol($userId)
    {
        $status = $this->getStatusTombol($userId);
        $konsultasi = $this->getKonsultasiAktifDengan($userId);
        
        switch ($status) {
            case 'bayar':
                if ($konsultasi) {
                    return route('pengguna.consultations.payment', $konsultasi->id);
                }
                return route('pengguna.consultations.create', $this->id);
                
            case 'chat':
                return route('pengguna.consultations.chat', $konsultasi->id);
                
            case 'konsultasi':
            default:
                return route('pengguna.consultations.create', $this->id);
        }
    }

    public function getClassTombol($userId)
    {
        $status = $this->getStatusTombol($userId);
        
        switch ($status) {
            case 'bayar':
                return 'btn btn-warning btn-sm px-3 py-1';
            case 'chat':
                return 'btn btn-success btn-sm px-3 py-1';
            case 'konsultasi':
            default:
                return 'btn btn-primary btn-sm px-3 py-1';
        }
    }

    public function getIconTombol($userId)
    {
        $status = $this->getStatusTombol($userId);
        
        switch ($status) {
            case 'bayar':
                return 'fas fa-credit-card';
            case 'chat':
                return 'fas fa-comments';
            case 'konsultasi':
            default:
                return 'fas fa-comment-medical';
        }
    }

    public function konsultasiAktifDengan($user_id)
    {
        return $this->hasOne(\App\Models\Consultation::class, 'dokter_id')
            ->where('user_id', $user_id)
            ->where('status', 'approved')
            ->whereNull('chat_ended_at')
            ->with('payment')
            ->latest();
    }

    public function konsultasi_aktif()
    {
        return $this->hasOne(Consultation::class, 'dokter_id')
            ->where('user_id', auth()->id())
            ->where('status', 'approved')
            ->whereNull('chat_ended_at')
            ->with('payment')
            ->latest();
    }
    
    public function getHariMulaiAttribute()
    {
        return $this->parseJadwalKerja()['hari_mulai'];
    }

    public function getHariSelesaiAttribute()
    {
        return $this->parseJadwalKerja()['hari_selesai'];
    }

    public function getJamMulaiAttribute()
    {
        return $this->parseJadwalKerja()['jam_mulai'];
    }

    public function getJamSelesaiAttribute()
    {
        return $this->parseJadwalKerja()['jam_selesai'];
    }

    private function parseJadwalKerja()
    {
        if (!$this->jadwal_kerja) {
            return [
                'hari_mulai' => null,
                'hari_selesai' => null,
                'jam_mulai' => null,
                'jam_selesai' => null,
            ];
        }

        // Format yang diharapkan: "Senin: 08:00 - 17:00" atau "Senin-Jumat: 08:00 - 17:00"
        
        // Pisahkan berdasarkan titik dua (:)
        if (strpos($this->jadwal_kerja, ':') !== false) {
            $parts = explode(':', $this->jadwal_kerja, 2);
            $hari_part = trim($parts[0]);
            $jam_part = trim($parts[1] ?? '');
        } else {
            // Fallback untuk format lama "senin 08:00-17:00"
            $parts = explode(' ', $this->jadwal_kerja, 2);
            $hari_part = trim($parts[0] ?? '');
            $jam_part = trim($parts[1] ?? '');
        }

        // Parse hari
        $hari_mulai = null;
        $hari_selesai = null;
        
        if (strpos($hari_part, '-') !== false) {
            $hari_parts = explode('-', $hari_part, 2);
            $hari_mulai = strtolower(trim($hari_parts[0]));
            $hari_selesai = strtolower(trim($hari_parts[1]));
        } else {
            $hari_mulai = strtolower(trim($hari_part));
        }

        // Parse jam
        $jam_mulai = null;
        $jam_selesai = null;
        
        if (strpos($jam_part, '-') !== false) {
            $jam_parts = explode('-', $jam_part, 2);
            $jam_mulai = trim($jam_parts[0]);
            $jam_selesai = trim($jam_parts[1]);
        }

        return [
            'hari_mulai' => $hari_mulai,
            'hari_selesai' => $hari_selesai,
            'jam_mulai' => $jam_mulai,
            'jam_selesai' => $jam_selesai,
        ];
    }
}