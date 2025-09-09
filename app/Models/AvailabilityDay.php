<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AvailabilityDay extends Model
{
    use HasFactory;

    protected $table = 'availability_days';


    protected $fillable = [
        'fish_id',
        'date',
        'quantity_available'
    ];

    protected $casts = [
        'date' => 'date'
    ];

    public function fish()
    {
        return $this->belongsTo(Fish::class);
    }
}
