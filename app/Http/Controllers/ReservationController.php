<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Batch;
use App\Models\Fish;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function create($batchId, $fishId)
    {
        $batch = Batch::findOrFail($batchId);
        $fish = Fish::findOrFail($fishId);

        // Pārbauda vai batch vēl ir pieejams
        $batchFish = $batch->fishes()->where('fish_id', $fishId)->first();

        if (!$batchFish || $batchFish->pivot->available_quantity <= 0) {
            return redirect()->back()->with('error', 'Šī zivs vairs nav pieejama rezervācijai.');
        }

        // Pārbauda vai lietotājam nav pārāk daudz aktīvo rezervāciju
        if (Auth::user()->hasMaxActiveReservations(3)) {
            return redirect()->back()->with('error', 'Jums jau ir 3 aktīvās rezervācijas. Lūdzu, gaidiet to apstrādi.');
        }

        return view('reservations.create', compact('batch', 'fish', 'batchFish'));
    }

    // Saglabāt jaunu rezervāciju
    public function store(Request $request)
    {
        // Validācija
        $validated = $request->validate([
            'batch_id' => 'required|exists:batches,id',
            'fish_id' => 'required|exists:fishes,id',
            'quantity' => 'required|integer|min:1',
            'phone' => ['required', 'regex:/^(\+371|371)?[2-3]\d{7}$/'],
            'notes' => 'nullable|string|max:500',
        ], [
            'phone.regex' => 'Lūdzu, ievadiet derīgu Latvijas telefona numuru (piemēram: +371 20123456 vai 20123456)',
            'quantity.min' => 'Daudzumam jābūt vismaz 1',
        ]);

        // Pārbauda aktīvo rezervāciju limitu
        if (Auth::user()->hasMaxActiveReservations(3)) {
            return redirect()->back()->with('error', 'Jums jau ir 3 aktīvās rezervācijas.');
        }

        // Pārbauda IP limitu (max 5 rezervācijas dienā)
        $ipAddress = $request->ip();
        $todayReservations = Reservation::where('ip_address', $ipAddress)
            ->whereDate('created_at', today())
            ->count();

        if ($todayReservations >= 5) {
            return redirect()->back()->with('error', 'No šīs IP adreses šodien ir veiktas pārāk daudz rezervācijas.');
        }

        // Pārbauda vai pietiek daudzuma
        $batch = Batch::findOrFail($validated['batch_id']);
        $batchFish = $batch->fishes()->where('fish_id', $validated['fish_id'])->first();

        if (!$batchFish || $batchFish->pivot->available_quantity < $validated['quantity']) {
            return redirect()->back()->with('error', 'Nav pietiekami daudz zivju pieejamībā.');
        }

        // Izveido rezervāciju
        $reservation = Reservation::create([
            'user_id' => Auth::id(),
            'batch_id' => $validated['batch_id'],
            'fish_id' => $validated['fish_id'],
            'quantity' => $validated['quantity'],
            'phone' => $validated['phone'],
            'ip_address' => $ipAddress,
            'user_agent' => $request->userAgent(),
            'status' => 'pending',
            'notes' => $validated['notes'],
        ]);

        return redirect()->route('reservations.show', $reservation->id)
            ->with('success', 'Rezervācija veiksmīgi izveidota! Administratoris drīzumā sazināsies ar jums.');
    }

    // Parādīt vienu rezervāciju
    public function show($id)
    {
        $reservation = Reservation::with(['batch', 'fish'])->findOrFail($id);

        // Pārbauda vai lietotājs var skatīt šo rezervāciju
        if ($reservation->user_id !== Auth::id() && !Auth::user()->is_admin) {
            abort(403);
        }

        return view('reservations.show', compact('reservation'));
    }

    // Lietotāja rezervāciju saraksts
    public function index()
    {
        $reservations = Auth::user()->reservations()
            ->with(['batch', 'fish'])
            ->latest()
            ->get();

        return view('reservations.index', compact('reservations'));
    }

    public function destroy(Reservation $reservation)
    {
        $reservation->delete();

        return redirect()->route('reservations.index')
            ->with('success', 'Rezervācija veiksmīgi dzēsta!');
    }
}
