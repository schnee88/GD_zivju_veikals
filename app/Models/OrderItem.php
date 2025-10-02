<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'batch_id',
        'fish_id',
        'quantity',
        'price',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

    public function fish()
    {
        return $this->belongsTo(Fish::class);
    }

    public function getTotalPrice()
    {
        return $this->quantity * $this->price;
    }

    public function getUnit()
    {
        $batchFish = $this->batch->fishes()->where('fish_id', $this->fish_id)->first();
        return $batchFish ? $batchFish->pivot->unit : 'kg';
    }
}
