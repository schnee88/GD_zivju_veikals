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

    /**
     * Parādīt lietotāja pasūtījumus
     */
    public function index()
    {
        $orders = Auth::user()
            ->orders()
            ->with(['items.fish'])
            ->latest()
            ->get();

        return view('orders.index', compact('orders'));
    }

    /**
     * Parādīt vienu pasūtījumu
     */
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

    /**
     * Checkout skats
     */
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

    /**
     * Izveidot pasūtījumu
     */
    public function store(StoreOrderRequest $request)
    {
        $user = Auth::user();
        $cartItems = $user->cartItems()->with('fish')->get();

        if ($cartItems->isEmpty()) {
            return redirect()
                ->route('cart.index')
                ->with('error', 'Jūsu grozs ir tukšs!');
        }

        // Pārbauda vai nav pārāk daudz aktīvo pasūtījumu
        if ($user->hasMaxActiveOrders(3)) {
            return redirect()
                ->back()
                ->with('error', 'Jums jau ir 3 aktīvie pasūtījumi. Lūdzu, gaidiet to apstrādi.');
        }

        // Pārbauda IP limitu
        if ($this->hasExceededIpLimit($request->ip())) {
            return redirect()
                ->back()
                ->with('error', 'No šīs IP adreses šodien ir veikti pārāk daudz pasūtījumi.');
        }

        DB::beginTransaction();

        try {
            // Pārbauda pieejamību
            foreach ($cartItems as $cartItem) {
                if (!$cartItem->fish->hasStock($cartItem->quantity)) {
                    DB::rollBack();
                    return redirect()
                        ->back()
                        ->with('error', "Zivs \"{$cartItem->fish->name}\" vairs nav pietiekamā daudzumā.");
                }
            }

            // Aprēķina kopējo summu
            $totalAmount = $cartItems->sum(function ($item) {
                return $item->quantity * $item->fish->price;
            });

            // Izveido pasūtījumu
            $order = Order::create([
                'user_id' => $user->id,
                'phone' => $request->phone,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'status' => Order::STATUS_PENDING,
                'notes' => $request->notes,
                'total_amount' => $totalAmount,
            ]);

            // Izveido pasūtījuma pozīcijas
            foreach ($cartItems as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'fish_id' => $cartItem->fish_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->fish->price,
                ]);
            }

            // Iztīra grozu
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

    /**
     * Success lapa pēc pasūtījuma
     */
    public function success($id)
    {
        $order = Order::with(['items.fish'])
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('orders.success', compact('order'));
    }

    /**
     * Atcelt pasūtījumu
     */
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

    // ============================================
    // ADMIN SKATS
    // ============================================

    /**
     * Parādīt visus pasūtījumus (admin)
     */
    public function adminIndex(Request $request)
    {
        $query = Order::with(['user', 'items.fish']);

        // Filtri
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

    /**
     * Parādīt pasūtījumu (admin)
     */
    public function adminShow($id)
    {
        $order = Order::with(['user', 'items.fish'])
            ->findOrFail($id);

        return view('admin.orders.show', compact('order'));
    }

    /**
     * Atjaunināt pasūtījuma statusu
     */
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
                return redirect()
                    ->back()
                    ->with('error', 'Nav pietiekami daudz produktu noliktavā!');
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

        return redirect()
            ->back()
            ->with('success', 'Pasūtījuma statuss atjaunināts!');
    }

    // ============================================
    // PRIVATE HELPERS
    // ============================================

    /**
     * Pārbauda vai IP ir pārsniegusi limitu
     */
    private function hasExceededIpLimit(string $ipAddress): bool
    {
        $todayOrders = Order::where('ip_address', $ipAddress)
            ->whereDate('created_at', today())
            ->count();

        return $todayOrders >= 5;
    }
}