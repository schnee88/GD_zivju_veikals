<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Http\Requests\StoreOrderRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // USER VIEWS

    public function index()
    {
        $orders = Auth::user()
            ->orders()
            ->with(['items.batch', 'items.fish'])
            ->latest()
            ->get();

        return view('orders.index', compact('orders'));
    }

    /**
     * Show single order details
     */
    public function show($id)
    {
        $order = Order::with(['items.batch', 'items.fish', 'user'])
            ->findOrFail($id);

        // Check authorization
        if ($order->user_id !== Auth::id() && !Auth::user()->is_admin) {
            abort(403);
        }

        return view('orders.show', compact('order'));
    }

    public function checkout()
    {
        $cartItems = Auth::user()
            ->cartItems()
            ->with(['batch', 'fish'])
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()
                ->route('cart.index')
                ->with('error', 'Jūsu grozs ir tukšs!');
        }

        return view('orders.checkout', compact('cartItems'));
    }

    public function store(StoreOrderRequest $request)
    {
        $user = Auth::user();
        $cartItems = $user->cartItems()->with('fish')->get();

        if ($cartItems->isEmpty()) {
            return redirect()
                ->route('cart.index')
                ->with('error', 'Jūsu grozs ir tukšs!');
        }

        if ($user->hasMaxActiveOrders(3)) {
            return redirect()
                ->back()
                ->with('error', 'Jums jau ir 3 aktīvie pasūtījumi. Lūdzu, gaidiet to apstrādi.');
        }

        // Check IP rate limit
        if ($this->hasExceededIpLimit($request->ip())) {
            return redirect()
                ->back()
                ->with('error', 'No šīs IP adreses šodien ir veikti pārāk daudz pasūtījumi.');
        }

        DB::beginTransaction();

        try {
            foreach ($cartItems as $cartItem) {
                if (!$cartItem->fish->hasStock($cartItem->quantity)) {
                    DB::rollBack();
                    return redirect()
                        ->back()
                        ->with('error', "Zivs \"{$cartItem->fish->name}\" vairs nav pietiekamā daudzumā.");
                }
            }

            $totalAmount = $cartItems->sum(function ($item) {
                return $item->quantity * $item->fish->price;
            });

            $order = Order::create([
                'user_id' => $user->id,
                'phone' => $request->phone,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'status' => Order::STATUS_PENDING,
                'notes' => $request->notes,
                'total_amount' => $totalAmount,
            ]);

            foreach ($cartItems as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'batch_id' => $cartItem->batch_id,
                    'fish_id' => $cartItem->fish_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->fish->price,
                ]);
            }

            $user->cartItems()->delete();

            DB::commit();

            return redirect()->route('orders.success', $order->id);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Order creation error: ' . $e->getMessage());
            
            return redirect()
                ->back()
                ->with('error', 'Radās kļūda veidojot pasūtījumu. Lūdzu, mēģiniet vēlreiz.');
        }
    }

    public function success($id)
    {
        $order = Order::with(['items.batch', 'items.fish'])
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('orders.success', compact('order'));
    }

    public function cancel(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        if (!$order->canBeCancelled()) {
            return redirect()
                ->back()
                ->with('error', 'Nevar atcelt apstiprinātu pasūtījumu. Lūdzu, sazinieties ar administrātoru.');
        }

        $order->cancel();

        return redirect()
            ->route('orders.index')
            ->with('success', 'Pasūtījums veiksmīgi atcelts!');
    }

    // ADMIN VIEWS
    /**
     * Show all orders (admin)
     */
    public function adminIndex(Request $request)
    {
        $query = Order::with(['user', 'items.batch', 'items.fish']);

        // Apply filters
        if ($request->filled('start_date')) {
            $startDate = \Carbon\Carbon::createFromFormat('d/m/Y', $request->start_date)->startOfDay();
            $query->where('created_at', '>=', $startDate);
        }

        if ($request->filled('end_date')) {
            $endDate = \Carbon\Carbon::createFromFormat('d/m/Y', $request->end_date)->endOfDay();
            $query->where('created_at', '<=', $endDate);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->latest()->paginate(20);

        return view('admin.orders.index', compact('orders'));
    }

    public function adminShow($id)
    {
        $order = Order::with(['user', 'items.batch', 'items.fish'])
            ->findOrFail($id);
            
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::with('items')->findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $oldStatus = $order->status;
        $newStatus = $validated['status'];

        // Handle status change
        if ($oldStatus === Order::STATUS_PENDING && $newStatus === Order::STATUS_CONFIRMED) {
            if (!$order->confirm()) {
                return redirect()
                    ->back()
                    ->with('error', 'Nav pietiekami daudz produktu noliktavā!');
            }
        } elseif ($oldStatus === Order::STATUS_CONFIRMED && $newStatus === Order::STATUS_CANCELLED) {
            $order->cancel();
        } else {
            $order->update(['status' => $newStatus]);
        }

        // Update admin notes
        if ($request->filled('admin_notes')) {
            $order->update(['admin_notes' => $validated['admin_notes']]);
        }

        return redirect()
            ->back()
            ->with('success', 'Pasūtījuma statuss atjaunināts!');
    }

    // PRIVATE HELPERS

    /**
     * Check if IP has exceeded daily order limit
     */
    private function hasExceededIpLimit(string $ipAddress): bool
    {
        $todayOrders = Order::where('ip_address', $ipAddress)
            ->whereDate('created_at', today())
            ->count();

        return $todayOrders >= 5;
    }
}