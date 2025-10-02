<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // ... your existing properties ...

    /**
     * The attributes that should be cast.
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

    // Add this missing method
    public function hasMaxActiveOrders(): bool
    {
        $maxOrders = config('orders.max_active_per_user', 3);

        return $this->activeOrders()->count() >= $maxOrders;
    }

    public function activeOrders()
    {
        return $this->orders()->whereIn('status', ['pending', 'confirmed', 'processing']);
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