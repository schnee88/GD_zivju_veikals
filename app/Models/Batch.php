<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'batch_date', 'status', 'description'];
    
    protected $casts = [
        'batch_date' => 'datetime'
    ];

    public function fishes()
    {
        return $this->belongsToMany(Fish::class, 'batch_fish')
                    ->withPivot('quantity', 'unit', 'available_quantity')
                    ->withTimestamps();
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'available' => '#28a745',
            'sold_out' => '#dc3545',  
            'preparing' => '#fd7e14', 
            default => '#6c757d'
        };
    }

    public function getStatusTextAttribute()
    {
        return match($this->status) {
            'available' => 'Pieejams',
            'sold_out' => 'Izpārdots',
            'preparing' => 'Gatavošanā',
            default => 'Nezināms'
        };
    }
}
