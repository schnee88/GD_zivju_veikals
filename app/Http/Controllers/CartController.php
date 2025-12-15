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
        $validated = $request->validate([
            'fish_id' => 'required|exists:fishes,id',
            'quantity' => 'required|numeric|min:0.1',
        ]);

        $fish = Fish::findOrFail($validated['fish_id']);

        if (!$fish->hasStock($validated['quantity'])) {
            return back()->withErrors(['quantity' => 'Nav pietiekami daudz šīs zivis noliktavā!']);
        }

        $cartItem = CartItem::firstOrCreate(
            [
                'user_id' => auth()->id(),
                'fish_id' => $validated['fish_id'],
            ],
            ['quantity' => 0]
        );

        $cartItem->increment('quantity', $validated['quantity']);

        return redirect()->back()->with('success', 'Produkts pievienots grozam!');
    }

    public function update(Request $request, $id)
    {
        //id atrod pareizo groza ierakstu
        //user_id pārbauda, vai šis ieraksts pieder tieši šim lietotājam
        $cartItem = CartItem::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $validated = $request->validate([
            'quantity' => 'required|numeric|min:0.1',
        ]);

        $fish = $cartItem->fish;

        // Pārbauda vai gabali ir veseli skaitļi
        if ($fish->stock_unit == 'pieces' && floor($validated['quantity']) != $validated['quantity']) {
            return back()->withErrors(['quantity' => 'Gabalu daudzumam jābūt veselam skaitlim.']);
        }

        // Pārbauda pieejamību
        if (!$fish->hasStock($validated['quantity'])) {
            return back()->withErrors(['quantity' => 'Pārsniegts pieejamais daudzums. Pieejams: ' . $fish->stock_quantity . ' ' . ($fish->stock_unit == 'kg' ? 'kg' : 'gab.')]);
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