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

    public function getTotalPrice()
    {
        return $this->quantity * $this->fish->price;
    }

    public function getUnit()
    {
        return $this->fish->stock_unit == 'kg' ? 'kg' : 'gab.';
    }

    public function getAvailableQuantity()
    {
        return $this->fish->stock_quantity;
    }
}