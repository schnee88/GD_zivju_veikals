<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
    ];

    protected $hidden = [
        'password', // Parole nekad netiek atgriezta API atbildēs vai JSON
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed', // Laravel automātiski šifrē paroli pie saglabāšanas
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

    public function hasMaxActiveOrders($max = 3)
    {
        return $this->orders()->active()->count() >= $max;
    }
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

    public function hasEmptyCart(): bool
    {
        return $this->cartItems()->count() === 0;
    }
}
