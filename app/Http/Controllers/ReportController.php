<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller

// vel nav iecomitos, testesana nepieciesama. Vienigas izmainas ReportController, admin/reports/orders.blade.php un web prieks routes

{
    public function orders(Request $request)
    {
        $query = OrderItem::with(['order.user', 'fish', 'batch']);

        if ($request->filled('date_from')) {
            $query->whereHas('order', function ($q) use ($request) {
                $q->whereDate('created_at', '>=', $request->date_from);
            });
        }

        if ($request->filled('date_to')) {
            $query->whereHas('order', function ($q) use ($request) {
                $q->whereDate('created_at', '<=', $request->date_to);
            });
        }

        if ($request->filled('status') && $request->status != 'all') {
            $query->whereHas('order', function ($q) use ($request) {
                $q->where('status', $request->status);
            });
        }

        if ($request->filled('customer_name')) {
            $query->whereHas('order.user', function ($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->customer_name . '%');
            });
        }

        if ($request->filled('phone')) {
            $query->whereHas('order', function ($q) use ($request) {
                $q->where('phone', 'LIKE', '%' . $request->phone . '%');
            });
        }

        if ($request->filled('order_id')) {
            $query->where('order_id', $request->order_id);
        }

        if ($request->filled('fish_id') && $request->fish_id != 'all') {
            $query->where('fish_id', $request->fish_id);
        }

        $sortBy = $request->get('sort_by', 'id');
        $sortOrder = $request->get('sort_order', 'desc');

        if ($sortBy == 'date') {
            $query->orderBy('created_at', $sortOrder);
        } elseif ($sortBy == 'amount') {
            $orderItems = $query->get()->sortBy(function ($item) use ($sortOrder) {
                return $item->quantity * $item->price;
            }, SORT_REGULAR, $sortOrder == 'desc');
        } else {
            $query->orderBy('id', $sortOrder);
        }

        if (!isset($orderItems)) {
            $orderItems = $query->get();
        }

        $totalAmount = $orderItems->sum(function ($item) {
            return $item->quantity * $item->price;
        });

        // Statistika pēc produktiem
        $productStats = $orderItems->groupBy('fish_id')->map(function ($items) {
            $fish = $items->first()->fish;
            return [
                'name' => $fish->name,
                'total_quantity' => $items->sum('quantity'),
                'total_amount' => $items->sum(function ($item) {
                    return $item->quantity * $item->price;
                }),
            ];
        })->sortByDesc('total_amount');

        // Iegūst visas zivis dropdown izvēlnei
        $allFishes = \App\Models\Fish::orderBy('name')->get();

        return view('admin.reports.orders', compact('orderItems', 'totalAmount', 'productStats', 'allFishes'));
    }

    // Eksportēt uz Excel (vēlāk)
    public function exportOrders(Request $request)
    {
        // TODO: Implementēt Excel eksportu
    }
}
