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
        'foto',
        'keahlian',
        'pengalaman',
        'lulusan_universitas',
        'alamat',
        'is_online', 
        'tarif_konsultasi', 
        'durasi', 
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_approved' => 'boolean',
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

}