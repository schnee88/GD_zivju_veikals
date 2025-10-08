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
        'is_orderable'

    ];

    protected $casts = [
        'is_orderable' => 'boolean',
    ];

    public function availabilityDays()
    {
        return $this->hasMany(AvailabilityDay::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function batches()
    {
        return $this->belongsToMany(Batch::class, 'batch_fish')
            ->withPivot('quantity', 'unit', 'available_quantity');
    }

    public function getCurrentAvailableQuantityAttribute()
    {
        return $this->batches()
            ->where('status', 'available', 'preparing')
            ->sum('batch_fish.available_quantity');
    }
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/fish_images/' . $this->image);
        }
        return null;
    }
}
