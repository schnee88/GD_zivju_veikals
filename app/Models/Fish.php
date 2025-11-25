<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fish extends Model
{
    use HasFactory;

    protected $table = 'fishes';

    protected $fillable = [
        'name',
        'price',
        'description',
        'image',
        'is_orderable',
        'stock_quantity',
        'stock_unit',
    ];

    protected $casts = [
        'is_orderable' => 'boolean',
        'stock_quantity' => 'integer',
    ];

    // RELATIONSHIPS
    
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function batches()
    {
        return $this->belongsToMany(Batch::class, 'batch_fish')
            ->withPivot('quantity', 'unit', 'available_quantity');
    }

    // SCOPES (for queries)

    public function scopeOrderable($query)
    {
        return $query->where('is_orderable', true);
    }

    public function scopeNotOrderable($query)
    {
        return $query->where('is_orderable', false);
    }

    public function scopeInStock($query)
    {
        return $query->where('is_orderable', true)
                     ->where('stock_quantity', '>', 0);
    }

    // ACCESSORS

    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/fish_images/' . $this->image);
        }
        return null;
    }

    public function getFormattedPriceAttribute()
    {
        return number_format($this->price, 2) . ' €';
    }

    public function getUnitLabelAttribute()
    {
        return $this->stock_unit === 'kg' ? 'kg' : 'gab.';
    }

    // STOCK MANAGEMENT METHODS

    public function inStock(): bool
    {
        return $this->stock_quantity > 0;
    }

    public function hasStock(float $quantity): bool
    {
        return $this->stock_quantity >= $quantity;
    }

    public function decreaseStock(float $quantity): bool
    {
        if (!$this->hasStock($quantity)) {
            return false;
        }

        $this->decrement('stock_quantity', $quantity);
        return true;
    }

    public function increaseStock(float $quantity): void
    {
        $this->increment('stock_quantity', $quantity);
    }

    public function setStock(float $quantity): void
    {
        $this->update(['stock_quantity' => $quantity]);
    }

    // VALIDATION HELPERS

    public function validateQuantity(float $quantity): bool
    {
        // For pieces, quantity must be a whole number
        if ($this->stock_unit === 'pieces') {
            return floor($quantity) == $quantity;
        }
        
        // For kg, allow decimals
        return $quantity > 0;
    }

    public function getMinimumQuantity(): float
    {
        return $this->stock_unit === 'kg' ? 0.1 : 1;
    }

    public function getQuantityStep(): float
    {
        return $this->stock_unit === 'kg' ? 0.1 : 1;
    }

    // BUSINESS LOGIC

    public function canBeOrdered(): bool
    {
        return $this->is_orderable && $this->inStock();
    }

    public function getStockStatusMessage(): string
    {
        if (!$this->is_orderable) {
            return 'Šis produkts nav pasūtāms';
        }

        if ($this->inStock()) {
            return "Pieejams: {$this->stock_quantity} {$this->unit_label}";
        }

        return 'Nav pieejams';
    }

    public function calculatePrice(float $quantity): float
    {
        return $this->price * $quantity;
    }
}