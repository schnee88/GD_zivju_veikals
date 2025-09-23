<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BatchFish extends Model
{
    use HasFactory;

    protected $table = 'batch_fish';

    protected $fillable = [
        'batch_id',
        'fish_id',
        'quantity',
        'available_quantity',
        'unit',
        'status'
    ];

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

    public function fish()
    {
        return $this->belongsTo(Fish::class);
    }
    
    public function isAvailable()
    {
        return $this->status === 'available' && $this->available_quantity > 0;
    }

    public function markAsSold()
    {
        $this->update([
            'status' => 'sold',
            'available_quantity' => 0
        ]);
    }

    public function markAsReserved()
    {
        $this->update(['status' => 'reserved']);
    }
}