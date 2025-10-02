<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_admin' => 'boolean'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
        ];
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function isAdmin()
    {
        return $this->is_admin;
    }

    //rezervations

    public function hasMaxActiveReservations(): bool
    {
        $maxReservations = config('reservations.max_active_per_user', 3);

        return $this->activeReservations()->count() >= $maxReservations;
    }

    public function activeReservations()
    {
        return $this->reservations()->where('status', 'active');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
    //shop cart
    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function getCartTotal()
    {
        return $this->cartItems->sum(function ($item) {
            return $item->quantity * $item->fish->price;
        });
    }
    public function getCartCount()
    {
        return $this->cartItems->count();
    }
}
