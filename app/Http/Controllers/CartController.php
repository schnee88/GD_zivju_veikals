<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem;
use App\Models\Fish;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Auth::user()->cartItems()
            ->with('fish')
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
}