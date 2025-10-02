<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Batch;
use App\Models\Fish;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller
{
    // Lietotāja rezervāciju saraksts
    public function index()
    {
        $reservations = Auth::user()->reservations()
            ->with(['batch', 'fish'])
            ->latest()
            ->get();

        return view('reservations.index', compact('reservations'));
    }

    // Vienas rezervācijas apskate
    public function show($id)
    {
        $reservation = Reservation::with(['batch', 'fish', 'user'])->findOrFail($id);

        if ($reservation->user_id !== Auth::id() && !Auth::user()->is_admin) {
            abort(403);
        }

        return view('reservations.show', compact('reservation'));
    }

    // Checkout lapa (rezervācijas noformēšana no groza)
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

    // Izveidot rezervācijas no groza
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

        // Pārbauda aktīvo rezervāciju limitu
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

        // Izmanto transaction lai viss notiktu vienlaicīgi
        DB::beginTransaction();

        try {
            // Izveido rezervāciju katrai groza precei
            foreach ($cartItems as $cartItem) {
                // Pārbauda pieejamību
                $batchFish = $cartItem->batch->fishes()->where('fish_id', $cartItem->fish_id)->first();

                if (!$batchFish || $batchFish->pivot->available_quantity < $cartItem->quantity) {
                    DB::rollBack();
                    return redirect()->back()->with('error', 'Zivs "' . $cartItem->fish->name . '" vairs nav pietiekamā daudzumā. Lūdzu, atjauniniet grozu.');
                }

                // Izveido rezervāciju
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

            // Iztīra grozu
            Auth::user()->cartItems()->delete();

            DB::commit();

            return redirect()->route('reservations.success')
                ->with('reservation_ids', $createdReservations);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Radās kļūda veidojot rezervāciju. Lūdzu, mēģiniet vēlreiz.');
        }
    }

    // Success lapa pēc rezervācijas
    public function success()
    {
        $reservationIds = session('reservation_ids');

        if (!$reservationIds) {
            return redirect()->route('reservations.index');
        }

        $reservations = Reservation::with(['batch', 'fish'])
            ->whereIn('id', $reservationIds)
            ->where('user_id', Auth::id())
            ->get();

        return view('reservations.success', compact('reservations'));
    }

    // Admin: visu rezervāciju saraksts
    public function adminIndex()
    {
        $reservations = Reservation::with(['user', 'batch', 'fish'])
            ->latest()
            ->paginate(20);

        return view('admin.reservations.index', compact('reservations'));
    }

    // Admin: rezervācijas apskate
    public function adminShow($id)
    {
        $reservation = Reservation::with(['user', 'batch', 'fish'])->findOrFail($id);
        return view('admin.reservations.show', compact('reservation'));
    }

    // Admin: atjaunināt statusu
    public function updateStatus(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $oldStatus = $reservation->status;
        $newStatus = $validated['status'];

        // Ja status mainās uz "confirmed", samazina pieejamo daudzumu
        if ($oldStatus == 'pending' && $newStatus == 'confirmed') {
            $batchFish = $reservation->batch->fishes()->where('fish_id', $reservation->fish_id)->first();

            if ($batchFish) {
                $newQuantity = $batchFish->pivot->available_quantity - $reservation->quantity;

                if ($newQuantity < 0) {
                    return redirect()->back()->with('error', 'Nav pietiekami daudz pieejamās zivs!');
                }

                // Atjaunina pieejamo daudzumu
                $reservation->batch->fishes()->updateExistingPivot($reservation->fish_id, [
                    'available_quantity' => $newQuantity
                ]);
            }
        }

        // Ja status mainās no "confirmed" uz "cancelled", atgriež daudzumu
        if ($oldStatus == 'confirmed' && $newStatus == 'cancelled') {
            $batchFish = $reservation->batch->fishes()->where('fish_id', $reservation->fish_id)->first();

            if ($batchFish) {
                $newQuantity = $batchFish->pivot->available_quantity + $reservation->quantity;

                $reservation->batch->fishes()->updateExistingPivot($reservation->fish_id, [
                    'available_quantity' => $newQuantity
                ]);
            }
        }

        $reservation->update([
            'status' => $newStatus,
            'admin_notes' => $validated['admin_notes'] ?? $reservation->admin_notes,
        ]);

        return redirect()->back()->with('success', 'Rezervācijas statuss atjaunināts!');
    }

    // Lietotājs dzēš savu rezervāciju (tikai ja pending)
    public function destroy(Reservation $reservation)
    {
        if ($reservation->user_id !== Auth::id()) {
            abort(403);
        }

        if ($reservation->status != 'pending') {
            return redirect()->back()->with('error', 'Nevar dzēst apstiprinatu rezervāciju. Lūdzu, sazinieties ar administrātoru.');
        }

        $reservation->delete();

        return redirect()->route('reservations.index')
            ->with('success', 'Rezervācija veiksmīgi atcelta!');
    }
}
