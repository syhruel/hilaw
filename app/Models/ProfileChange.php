<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileChange extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'changes',
        'old_data',
        'status',
        'rejection_reason',
        'approved_at',
        'approved_by',
        'rejected_by',
        'rejected_at'
    ];

    protected $casts = [
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime'
    ];

    /**
     * Relationship dengan User (Dokter)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship dengan admin yang approve
     */
    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Relationship dengan admin yang reject
     */
    public function rejectedBy()
    {
        return $this->belongsTo(User::class, 'rejected_by');
    }

    /**
     * Scope untuk status pending
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope untuk status approved
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope untuk status rejected
     */
    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    /**
     * Accessor untuk mendapatkan changes sebagai array
     */
    public function getChangesAttribute($value)
    {
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            return is_array($decoded) ? $decoded : [];
        }
        return is_array($value) ? $value : [];
    }

    /**
     * Accessor untuk mendapatkan old_data sebagai array
     */
    public function getOldDataAttribute($value)
    {
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            return is_array($decoded) ? $decoded : [];
        }
        return is_array($value) ? $value : [];
    }

    /**
     * Check if profile change is pending
     */
    public function isPending()
    {
        return $this->status === 'pending';
    }

    /**
     * Check if profile change is approved
     */
    public function isApproved()
    {
        return $this->status === 'approved';
    }

    /**
     * Check if profile change is rejected
     */
    public function isRejected()
    {
        return $this->status === 'rejected';
    }
}