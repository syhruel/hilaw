<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_approved',
        'was_pending',
        'approval_status',
        'rejection_reason',
        'is_online',
        'tarif_konsultasi',
        'jadwal_kerja',
        'foto',
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
        'is_approved' => 'boolean',
        'was_pending' => 'boolean',
        'is_online' => 'boolean',
        'pengalaman_tahun' => 'integer',
        'tarif_konsultasi' => 'decimal:2',
    ];

    public function consultationsAsDoctor()
    {
        return $this->hasMany(\App\Models\Consultation::class, 'dokter_id');
    }

    public function consultationsAsPatient()
    {
        return $this->hasMany(\App\Models\Consultation::class, 'user_id');
    }

    public function konsultasiAktifDengan($user_id)
    {
        return $this->hasOne(\App\Models\Consultation::class, 'dokter_id')
            ->where('user_id', $user_id)
            ->where('status', 'approved');
    }

    public function konsultasi_aktif()
    {
        return $this->hasOne(Consultation::class, 'dokter_id')
            ->where('user_id', auth()->id())
            ->where('status', 'approved')
            ->whereNull('chat_ended_at');
    }

    public function profileChanges()
    {
        return $this->hasMany(ProfileChange::class);
    }

    public function pendingProfileChanges()
    {
        return $this->hasMany(ProfileChange::class)->where('status', 'pending');
    }

    // Accessor untuk mendapatkan hari_mulai dari jadwal_kerja
    public function getHariMulaiAttribute()
    {
        return $this->parseJadwalKerja()['hari_mulai'];
    }

    // Accessor untuk mendapatkan hari_selesai dari jadwal_kerja
    public function getHariSelesaiAttribute()
    {
        return $this->parseJadwalKerja()['hari_selesai'];
    }

    // Accessor untuk mendapatkan jam_mulai dari jadwal_kerja
    public function getJamMulaiAttribute()
    {
        return $this->parseJadwalKerja()['jam_mulai'];
    }

    // Accessor untuk mendapatkan jam_selesai dari jadwal_kerja
    public function getJamSelesaiAttribute()
    {
        return $this->parseJadwalKerja()['jam_selesai'];
    }

    // Helper method untuk parsing jadwal kerja
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

        // Format: "senin 08:00-17:00" atau "senin-jumat 08:00-17:00"
        $parts = explode(' ', $this->jadwal_kerja);
        $hari = $parts[0] ?? '';
        $jam = $parts[1] ?? '';

        // Parse hari
        $hari_parts = explode('-', $hari);
        $hari_mulai = $hari_parts[0] ?? '';
        $hari_selesai = isset($hari_parts[1]) ? $hari_parts[1] : null;

        // Parse jam
        $jam_parts = explode('-', $jam);
        $jam_mulai = $jam_parts[0] ?? '';
        $jam_selesai = $jam_parts[1] ?? '';

        return [
            'hari_mulai' => $hari_mulai,
            'hari_selesai' => $hari_selesai,
            'jam_mulai' => $jam_mulai,
            'jam_selesai' => $jam_selesai,
        ];
    }
}