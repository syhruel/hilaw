<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}