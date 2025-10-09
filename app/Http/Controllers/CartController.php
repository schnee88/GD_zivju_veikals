<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem;
use App\Models\Batch;
use App\Models\Fish;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Auth::user()->cartItems()
            ->with(['batch', 'fish'])
            ->get();

        $total = Auth::user()->getCartTotal();

        return view('cart.index', compact('cartItems', 'total'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'fish_id' => 'required|exists:fishes,id',
            'quantity' => 'required|numeric|min:0.1',
        ]);

        $fish = Fish::findOrFail($request->fish_id);

        if (!$fish->hasStock($request->quantity)) {
            return redirect()->back()->with('error', 'Nav pietiekami daudz šīs zivis noliktavā!');
        }
        $existingCartItem = CartItem::where('user_id', auth()->id())
            ->where('fish_id', $request->fish_id)
            ->first();

        if ($existingCartItem) {
            $existingCartItem->quantity += $request->quantity;
            $existingCartItem->save();
        } else {

            CartItem::create([
                'user_id' => auth()->id(),
                'fish_id' => $request->fish_id,
                'batch_id' => null,
                'quantity' => $request->quantity,
            ]);
        }

        return redirect()->back()->with('success', 'Produkts pievienots grozam!');
    }

    public function update(Request $request, $id)
    {
        $cartItem = CartItem::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $validated = $request->validate([
            'quantity' => 'required|numeric|min:0.1',
        ]);

        $fish = $cartItem->fish;

        // Pārbauda vai gabali ir veseli skaitļi
        if ($fish->stock_unit == 'pieces' && floor($validated['quantity']) != $validated['quantity']) {
            return redirect()->back()->with('error', 'Gabalu daudzumam jābūt veselam skaitlim.');
        }

        // Pārbauda pieejamību
        if (!$fish->hasStock($validated['quantity'])) {
            return redirect()->back()->with('error', 'Pārsniegts pieejamais daudzums. Pieejams: ' . $fish->stock_quantity . ' ' . ($fish->stock_unit == 'kg' ? 'kg' : 'gab.'));
        }

        $cartItem->update(['quantity' => $validated['quantity']]);

        return redirect()->back()->with('success', 'Daudzums atjaunināts!');
    }
    public function remove($id)
    {
        $cartItem = CartItem::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $cartItem->delete();

        return redirect()->back()->with('success', 'Zivs izņemta no groza.');
    }

    public function clear()
    {
        Auth::user()->cartItems()->delete();

        return redirect()->back()->with('success', 'Grozs iztīrīts.');
    }

    public function checkout()
    {
        $cartItems = Auth::user()->cartItems()
            ->with(['batch', 'fish'])
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Jūsu grozs ir tukšs!');
        }

        return view('reservations.checkout', compact('cartItems'));
    }

    public function storeFromCart(Request $request)
    {
        $validated = $request->validate([
            'phone' => ['required', 'regex:/^(\+371|371)?[2-3]\d{7}$/'],
            'notes' => 'nullable|string|max:500',
        ], [
            'phone.regex' => 'Lūdzu, ievadiet derīgu Latvijas telefona numuru (piemēram: +371 20123456 vai 20123456)',
        ]);

        $cartItems = Auth::user()->cartItems()
            ->with(['batch', 'fish'])
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Jūsu grozs ir tukšs!');
        }

        if (Auth::user()->hasMaxActiveReservations(3)) {
            return redirect()->back()->with('error', 'Jums jau ir 3 aktīvās rezervācijas. Lūdzu, gaidiet to apstrādi.');
        }

        // Pārbauda IP limitu
        $ipAddress = $request->ip();
        $todayReservations = Reservation::where('ip_address', $ipAddress)
            ->whereDate('created_at', today())
            ->count();

        if ($todayReservations >= 5) {
            return redirect()->back()->with('error', 'No šīs IP adreses šodien ir veiktas pārāk daudz rezervācijas.');
        }

        $createdReservations = [];

        foreach ($cartItems as $cartItem) {
            $batchFish = $cartItem->batch->fishes()->where('fish_id', $cartItem->fish_id)->first();

            if (!$batchFish || $batchFish->pivot->available_quantity < $cartItem->quantity) {
                return redirect()->back()->with('error', 'Zivs "' . $cartItem->fish->name . '" vairs nav pietiekamā daudzumā. Lūdzu, atjauniniet grozu.');
            }
            $reservation = Reservation::create([
                'user_id' => Auth::id(),
                'batch_id' => $cartItem->batch_id,
                'fish_id' => $cartItem->fish_id,
                'quantity' => $cartItem->quantity,
                'phone' => $validated['phone'],
                'ip_address' => $ipAddress,
                'user_agent' => $request->userAgent(),
                'status' => 'pending',
                'notes' => $validated['notes'],
            ]);

            $createdReservations[] = $reservation->id;
        }

        Auth::user()->cartItems()->delete();

        return redirect()->route('reservations.index')
            ->with('success', 'Rezervācija veiksmīgi izveidota! Administratoris drīzumā sazināsies ar jums. Izveidotas ' . count($createdReservations) . ' rezervācijas.');
    }
}
