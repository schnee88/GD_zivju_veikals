<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use App\Models\Fish;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function orders(Request $request)
    {
        // IEGŪSTAM VISUS FILTRUS NO FORMAS
        $filters = [
            'date_from' => $request->date_from,
            'date_to' => $request->date_to,
            'status' => $request->status,
            'customer_name' => $request->customer_name,
            'phone' => $request->phone,
            'order_id' => $request->order_id,
            'fish_id' => $request->fish_id,
        ];

        $query = OrderItem::with(['order.user', 'fish', 'batch'])
            ->filterForReport($filters);

        // KĀRTOŠANA
        $sortBy = $request->get('sort_by', 'id');
        $sortOrder = $request->get('sort_order', 'desc');

        if ($sortBy == 'date') {
            $query->orderBy('created_at', $sortOrder);
        } else {
            $query->orderBy('id', $sortOrder);
        }

        $orderItems = $query->get();

        // Kārtošana pēc summas
        if ($sortBy == 'amount') {
            $orderItems = $orderItems->sortBy(function ($item) {
                return $item->quantity * $item->price;
            }, SORT_REGULAR, $sortOrder == 'desc');
        }

        // APRĒĶINĀT STATISTIKU
        $totalAmount = $orderItems->sum(function ($item) {
            return $item->quantity * $item->price;
        });

        $productStats = OrderItem::getProductStats($orderItems);
        
        $allFishes = Fish::orderBy('name')->get();

        return view('admin.reports.orders', compact(
            'orderItems',
            'totalAmount',
            'productStats',
            'allFishes'
        ));
    }
}