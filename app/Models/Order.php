<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'phone',
        'ip_address',
        'user_agent',
        'status',
        'notes',
        'admin_notes',
        'total_amount',
    ];

    // Order statusi ka konstantes
    const STATUS_PENDING = 'pending';
    const STATUS_CONFIRMED = 'confirmed';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';

    // RELATIONSHIPS

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // SCOPES

    public function scopeActive($query)
    {
        return $query->whereIn('status', [self::STATUS_PENDING, self::STATUS_CONFIRMED]);
    }

    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', self::STATUS_CONFIRMED);
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    // ACCESSORS

    public function getFormattedTotalAttribute()
    {
        return number_format($this->total_amount, 2) . ' €';
    }

    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            self::STATUS_PENDING => 'Gaida apstiprinājumu',
            self::STATUS_CONFIRMED => 'Apstiprināts',
            self::STATUS_COMPLETED => 'Pabeigts',
            self::STATUS_CANCELLED => 'Atcelts',
            default => 'Nezināms'
        };
    }

    // STATUSA PARBAUDE

    public function isActive(): bool
    {
        return in_array($this->status, [self::STATUS_PENDING, self::STATUS_CONFIRMED]);
    }

    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isConfirmed(): bool
    {
        return $this->status === self::STATUS_CONFIRMED;
    }

    public function isCompleted(): bool
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    public function isCancelled(): bool
    {
        return $this->status === self::STATUS_CANCELLED;
    }

    public function canBeCancelled(): bool
    {
        return $this->isPending();
    }

    // ============================================
    // BUSINESS LOGIC
    // ============================================

    public function calculateTotal(): float
    {
        return $this->items->sum(function ($item) {
            return $item->quantity * $item->price;
        });
    }

    /**
     * Apstiprināt pasūtījumu
     * Pārbauda pieejamību un samazina Fish::stock_quantity
     */
    public function confirm(): bool
    {
        if (!$this->isPending()) {
            return false;
        }

        // Pārbauda vai visas zivis ir pieejamas
        foreach ($this->items as $item) {
            if (!$item->fish->hasStock($item->quantity)) {
                return false;
            }
        }

        // Samazina krājumus
        foreach ($this->items as $item) {
            $item->fish->decreaseStock($item->quantity);
        }

        $this->update(['status' => self::STATUS_CONFIRMED]);
        return true;
    }

    /**
     * Atcelt pasūtījumu
     * Ja bija apstiprināts, atgriež krājumus
     */
    public function cancel(): bool
    {
        // Ja pasūtījums bija apstiprināts, atgriežam krājumus
        if ($this->isConfirmed()) {
            foreach ($this->items as $item) {
                $item->fish->increaseStock($item->quantity);
            }
        }

        $this->update(['status' => self::STATUS_CANCELLED]);
        return true;
    }

    /**
     * Pabeigt pasūtījumu
     */
    public function complete(): bool
    {
        if (!$this->isConfirmed()) {
            return false;
        }

        $this->update(['status' => self::STATUS_COMPLETED]);
        return true;
    }
}