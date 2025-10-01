<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'batch_id',
        'fish_id',
        'quantity',
        'phone',
        'ip_address',
        'user_agent',
        'status',
        'notes',
        'admin_notes',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

    public function fish()
    {
        return $this->belongsTo(Fish::class);
    }

    public function isActive()
    {
        return in_array($this->status, ['pending', 'confirmed']);
    }

    public function scopeActive($query)
    {
        return $query->whereIn('status', ['pending', 'confirmed']);
    }
}
