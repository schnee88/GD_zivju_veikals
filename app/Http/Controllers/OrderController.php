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
    // ============================================
    // USER SKATS
    // ============================================

    public function index()
    {
        $orders = Auth::user()
            ->orders()
            ->with(['items.fish'])
            ->latest()
            ->get();

        return view('orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with(['items.fish', 'user'])
            ->findOrFail($id);

        // Pārbaudām autorizāciju
        if ($order->user_id !== Auth::id() && !Auth::user()->is_admin) {
            abort(403);
        }

        return view('orders.show', compact('order'));
    }

    public function checkout()
    {
        $cartItems = Auth::user()
            ->cartItems()
            ->with(['fish'])
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

        if ($user->hasMaxActiveOrders(3)) {
            return back()->with('error', 'Jums jau ir 3 aktīvie pasūtījumi. Lūdzu, gaidiet to apstrādi.');
        }

        // Pārbauda IP limitu
        if (Order::hasExceededIpLimit($request->ip())) {
            return back()->with('error', 'No šīs IP adreses šodien ir veikti pārāk daudz pasūtījumi.');
        }

        DB::beginTransaction();

        try {
            $order = Order::createFromCart(
                $user,
                $request->phone ?? '12345678',
                $request->ip(),
                $request->userAgent(),
                $request->notes
            );

            DB::commit();

            return redirect()->route('orders.success', $order->id);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Order creation error: ' . $e->getMessage());

            return back()->with('error', $e->getMessage());
        }
    }

    public function success($id)
    {
        $order = Order::with(['items.fish'])
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

        // Command-Query Separation principu - viena metode vai jautā, vai dara, bet ne abus.

        if (!$order->canBeCancelled()) {
            return back()->with('error', 'Nevar atcelt apstiprinātu pasūtījumu. Lūdzu, sazinieties ar administrātoru.');
        }

        $order->cancel();

        return redirect()->route('orders.index')->with('success', 'Pasūtījums veiksmīgi atcelts!');
    }

    // ============================================
    // ADMIN SKATS
    // ============================================

    public function adminIndex(Request $request)
    {
        $orders = Order::query()
            ->withRelations()
            ->filterByDateRange($request->start_date, $request->end_date)
            ->filterByStatus($request->status)
            ->latest()
            ->paginate(20);

        return view('admin.orders.index', compact('orders'));
    }

    public function adminShow($id)
    {
        $order = Order::with(['user', 'items.fish'])
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

        // Pārvaldīt statusa maiņu
        if ($oldStatus === Order::STATUS_PENDING && $newStatus === Order::STATUS_CONFIRMED) {
            if (!$order->confirm()) {
                return back()->with('error', 'Nav pietiekami daudz produktu noliktavā!');
            }
        } elseif ($oldStatus === Order::STATUS_CONFIRMED && $newStatus === Order::STATUS_CANCELLED) {
            $order->cancel();
        } else {
            $order->update(['status' => $newStatus]);
        }

        // Atjaunināt admin piezīmes
        if ($request->filled('admin_notes')) {
            $order->update(['admin_notes' => $validated['admin_notes']]);
        }

        return back()->with('success', 'Pasūtījuma statuss atjaunināts!');
    }
}