<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'batch_id',
        'fish_id',
        'quantity',
    ];

    // Attiecības
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

    // Helper metodes
    public function getTotalPrice()
    {
        return $this->quantity * $this->fish->price;
    }

    public function getUnit()
    {
        $batchFish = $this->batch->fishes()->where('fish_id', $this->fish_id)->first();
        return $batchFish ? $batchFish->pivot->unit : 'kg';
    }

    // Iegūst pieejamo daudzumu
    public function getAvailableQuantity()
    {
        $batchFish = $this->batch->fishes()->where('fish_id', $this->fish_id)->first();
        return $batchFish ? $batchFish->pivot->available_quantity : 0;
    }
}
