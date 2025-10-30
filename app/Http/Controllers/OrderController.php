<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Auth::user()->orders()
            ->with(['items.batch', 'items.fish'])
            ->latest()
            ->get();

        return view('orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with(['items.batch', 'items.fish', 'user'])->findOrFail($id);

        if ($order->user_id !== Auth::id() && !Auth::user()->is_admin) {
            abort(403);
        }

        return view('orders.show', compact('order'));
    }

    public function checkout()
    {
        $cartItems = Auth::user()->cartItems()
            ->with(['batch', 'fish'])
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Jūsu grozs ir tukšs!');
        }

        return view('orders.checkout', compact('cartItems'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'phone' => ['required', 'regex:/^(\+371|371)?[2-3]\d{7}$/'],
            'notes' => 'nullable|string|max:500',
        ], [
            'phone.regex' => 'Lūdzu, ievadiet derīgu Latvijas telefona numuru (piemēram: +371 20123456 vai 20123456)',
        ]);

        $cartItems = Auth::user()->cartItems()
            ->with(['fish']) // ✅
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Jūsu grozs ir tukšs!');
        }

        if (Auth::user()->hasMaxActiveOrders(3)) {
            return redirect()->back()->with('error', 'Jums jau ir 3 aktīvie pasūtījumi. Lūdzu, gaidiet to apstrādi.');
        }

        $ipAddress = $request->ip();
        $todayOrders = Order::where('ip_address', $ipAddress)
            ->whereDate('created_at', today())
            ->count();

        if ($todayOrders >= 5) {
            return redirect()->back()->with('error', 'No šīs IP adreses šodien ir veikti pārāk daudz pasūtījumi.');
        }

        DB::beginTransaction();

        try {
            $totalAmount = 0;

            foreach ($cartItems as $cartItem) {
                if (!$cartItem->fish->hasStock($cartItem->quantity)) {
                    DB::rollBack();
                    return redirect()->back()->with('error', 'Zivs "' . $cartItem->fish->name . '" vairs nav pietiekamā daudzumā. Lūdzu, atjauniniet grozu.');
                }

                $totalAmount += $cartItem->quantity * $cartItem->fish->price;
            }

            $order = Order::create([
                'user_id' => Auth::id(),
                'phone' => $validated['phone'],
                'ip_address' => $ipAddress,
                'user_agent' => $request->userAgent(),
                'status' => 'pending',
                'notes' => $validated['notes'],
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

            Auth::user()->cartItems()->delete();

            DB::commit();

            return redirect()->route('orders.success', $order->id);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Order creation error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Radās kļūda veidojot pasūtījumu. Lūdzu, mēģiniet vēlreiz.');
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

        if ($order->status != 'pending') {
            return redirect()->back()->with('error', 'Nevar atcelt apstiprinātu pasūtījumu. Lūdzu, sazinieties ar administrātoru.');
        }

        $order->update(['status' => 'cancelled']);

        return redirect()->route('orders.index')
            ->with('success', 'Pasūtījums veiksmīgi atcelts!');
    }

    public function adminIndex(Request $request)
    {
        $query = Order::with(['user', 'items.batch', 'items.fish']);

        if ($request->has('start_date') && $request->start_date) {
            try {
                $startDate = \Carbon\Carbon::createFromFormat('d/m/Y', $request->start_date)->startOfDay();
                $query->where('created_at', '>=', $startDate);
            } catch (\Exception $e) {
            }
        }

        if ($request->has('end_date') && $request->end_date) {
            try {
                $endDate = \Carbon\Carbon::createFromFormat('d/m/Y', $request->end_date)->endOfDay();
                $query->where('created_at', '<=', $endDate);
            } catch (\Exception $e) {
            }
        }

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $orders = $query->latest()->paginate(20);

        return view('admin.orders.index', compact('orders'));
    }

    public function adminShow($id)
    {
        $order = Order::with(['user', 'items.batch', 'items.fish'])->findOrFail($id);
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

        if ($oldStatus == 'pending' && $newStatus == 'confirmed') {
            foreach ($order->items as $item) {
                $fish = $item->fish;

                if ($item->batch_id) {
                    $batchFish = $item->batch->fishes()->where('fish_id', $item->fish_id)->first();

                    if ($batchFish) {
                        $newQuantity = $batchFish->pivot->available_quantity - $item->quantity;

                        if ($newQuantity < 0) {
                            return redirect()->back()->with('error', 'Nav pietiekami daudz zivs "' . $item->fish->name . '"!');
                        }

                        $item->batch->fishes()->updateExistingPivot($item->fish_id, [
                            'available_quantity' => $newQuantity
                        ]);
                    }
                } else {
                    if (!$fish->hasStock($item->quantity)) {
                        return redirect()->back()->with('error', 'Nav pietiekami daudz zivs "' . $fish->name . '"!');
                    }

                    $fish->decrement('stock_quantity', $item->quantity);
                }
            }
        }

        if ($oldStatus == 'confirmed' && $newStatus == 'cancelled') {
            foreach ($order->items as $item) {
                $fish = $item->fish;

                if ($item->batch_id) {
                    $batchFish = $item->batch->fishes()->where('fish_id', $item->fish_id)->first();

                    if ($batchFish) {
                        $newQuantity = $batchFish->pivot->available_quantity + $item->quantity;

                        $item->batch->fishes()->updateExistingPivot($item->fish_id, [
                            'available_quantity' => $newQuantity
                        ]);
                    }
                } else {
                    $fish->increment('stock_quantity', $item->quantity);
                }
            }
        }

        $order->update([
            'status' => $newStatus,
            'admin_notes' => $validated['admin_notes'] ?? $order->admin_notes,
        ]);

        return redirect()->back()->with('success', 'Pasūtījuma statuss atjaunināts!');
    }
}