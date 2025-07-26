<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['consultation_id', 'sender_id', 'receiver_id', 'message'];

    // Relationships
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function consultation()
    {
        return $this->belongsTo(Consultation::class);
    }

    // Accessors
    public function getIsSentByAuthAttribute()
    {
        return $this->sender_id === auth()->id();
    }

    // Scopes
    public function scopeForConsultation($query, $consultationId)
    {
        return $query->where('consultation_id', $consultationId);
    }

    public function scopeSentBy($query, $userId)
    {
        return $query->where('sender_id', $userId);
    }

    public function scopeReceivedBy($query, $userId)
    {
        return $query->where('receiver_id', $userId);
    }
}