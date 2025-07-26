<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Consultation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'dokter_id',
        'keluhan',
        'tarif',
        'status',
        'duration_minutes',
        'duration_hours',
        'chat_started_at',
        'chat_ended_at',
    ];

    protected $dates = ['chat_started_at', 'chat_ended_at'];

    protected $casts = [
    'chat_started_at' => 'datetime',
    'chat_ended_at' => 'datetime',
    ];


    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dokter()
    {
        return $this->belongsTo(User::class, 'dokter_id');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    // Accessors
    public function getTotalDurationSecondsAttribute()
    {
        $hours = $this->duration_hours ?? 0;
        $minutes = $this->duration_minutes ?? 0;
        return ($hours * 3600) + ($minutes * 60);
    }

    public function getRemainingSecondsAttribute()
    {
        if (!$this->chat_started_at) {
            return $this->total_duration_seconds;
        }

        $elapsed = Carbon::now('Asia/Jakarta')->diffInSeconds($this->chat_started_at);
        $remaining = $this->total_duration_seconds - $elapsed;

        return max(0, $remaining);
    }

    public function getIsChatActiveAttribute()
    {
        return $this->chat_started_at && !$this->chat_ended_at;
    }

    public function getIsChatExpiredAttribute()
    {
        return $this->is_chat_active && $this->remaining_seconds === 0;
    }

    // Scopes
    public function scopeForUser($query, $userId)
    {
        return $query->where(function($q) use ($userId) {
            $q->where('user_id', $userId)->orWhere('dokter_id', $userId);
        });
    }
}
