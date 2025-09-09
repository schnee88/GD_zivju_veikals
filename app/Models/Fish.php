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
        'image'
    ];

    public function availabilityDays()
    {
        return $this->hasMany(AvailabilityDay::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
