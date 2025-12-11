<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'fish_id',
        'quantity',
        'price',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function fish()
    {
        return $this->belongsTo(Fish::class);
    }

    public function getTotalPrice(): float
    {
        return $this->quantity * $this->price;
    }
    
    public function getUnit(): string
    {
        return $this->fish->stock_unit == 'kg' ? 'kg' : 'gab.';
    }

    // ============================================
    // QUERY SCOPES
    // ============================================

    /**
     * Filtrēt pārskatu skatam
     */
    public function scopeFilterForReport($query, $filters)
    {
        if (!empty($filters['date_from'])) {
            $startDate = \Carbon\Carbon::parse($filters['date_from'])->startOfDay();
            $query->whereHas('order', function ($q) use ($startDate) {
                $q->where('created_at', '>=', $startDate);
            });
        }

        if (!empty($filters['date_to'])) {
            $endDate = \Carbon\Carbon::parse($filters['date_to'])->endOfDay();
            $query->whereHas('order', function ($q) use ($endDate) {
                $q->where('created_at', '<=', $endDate);
            });
        }

        if (!empty($filters['status']) && $filters['status'] != 'all') {
            $query->whereHas('order', function ($q) use ($filters) {
                $q->where('status', $filters['status']);
            });
        }

        if (!empty($filters['customer_name'])) {
            $query->whereHas('order.user', function ($q) use ($filters) {
                $q->where('name', 'LIKE', '%' . $filters['customer_name'] . '%');
            });
        }

        if (!empty($filters['phone'])) {
            $query->whereHas('order', function ($q) use ($filters) {
                $q->where('phone', 'LIKE', '%' . $filters['phone'] . '%');
            });
        }

        if (!empty($filters['order_id'])) {
            $query->where('order_id', $filters['order_id']);
        }

        if (!empty($filters['fish_id']) && $filters['fish_id'] != 'all') {
            $query->where('fish_id', $filters['fish_id']);
        }

        return $query;
    }

    /**
     * Aprēķināt produktu statistiku pārskatam
     */
    public static function getProductStats($orderItems)
    {
        return $orderItems->groupBy('fish_id')->map(function ($items) {
            $fish = $items->first()->fish;
            return [
                'name' => $fish->name,
                'total_quantity' => $items->sum('quantity'),
                'total_amount' => $items->sum(function ($item) {
                    return $item->quantity * $item->price;
                }),
            ];
        })->sortByDesc('total_amount');
    }
}