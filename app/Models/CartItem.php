<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'fish_id',
        'quantity',
    ];

    // RELATIONSHIPS

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function fish()
    {
        return $this->belongsTo(Fish::class);
    }

    // HELPER METODES

    public function getTotalPrice(): float
    {
        return $this->quantity * $this->fish->price;
    }

    public function getUnit(): string
    {
        return $this->fish->stock_unit == 'kg' ? 'kg' : 'gab.';
    }

    public function getAvailableQuantity(): int
    {
        return $this->fish->stock_quantity;
    }
}