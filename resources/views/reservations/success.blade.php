@extends('layouts.app')

@section('content')
<div class="success-container">
    <div class="success-icon">✅</div>
    <h1 class="success-title">Rezervācija veiksmīgi izveidota!</h1>
    <p class="success-message">
        Paldies par jūsu rezervāciju! Mēs esam saņēmuši jūsu pasūtījumu un drīzumā sazināsimies ar jums norādītajā telefona numurā.
    </p>
    
    <div class="info-box">
        <h3>Kas notiks tālāk?</h3>
        <ul>
            <li>Administratoris pārskatīs jūsu rezervāciju</li>
            <li>Jūs saņemsiet zvanu uz norādīto telefona numuru rezervācijas apstiprināšanai</li>
            <li>Pēc apstiprinājuma varēsiet saņemt preci veikalā</li>
            <li>Maksājums notiek tikai saņemot preci klātienē</li>
        </ul>
    </div>
    
    @if($reservations && $reservations->isNotEmpty())
    <div class="reservation-summary">
        <h2 style="margin: 0 0 20px 0; color: #2c3e50;">Jūsu rezervācijas:</h2>
        
        @foreach($reservations as $reservation)
        <div class="summary-item">
            <div>
                <div class="item-name">{{ $reservation->fish->name }}</div>
                <div class="item-details">
                    Kūpinājums: {{ $reservation->batch->name ?? 'Batch #' . $reservation->batch->id }} | 
                    Daudzums: {{ $reservation->quantity }} {{ $reservation->batch->fishes()->where('fish_id', $reservation->fish_id)->first()->pivot->unit }}
                </div>
            </div>
            <div style="font-weight: bold; color: #27ae60; font-size: 1.1em;">
                {{ number_format($reservation->quantity * $reservation->fish->price, 2) }} €
            </div>
        </div>
        @endforeach
        
        <div class="summary-item" style="background: #f8f9fa; margin-top: 10px; padding: 20px; font-size: 1.2em;">
            <strong>KOPĀ:</strong>
            <strong style="color: #27ae60;">
                {{ number_format($reservations->sum(function($r) { return $r->quantity * $r->fish->price; }), 2) }} €
            </strong>
        </div>
    </div>
    @endif
    
    <div class="action-buttons">
        <a href="{{ route('reservations.index') }}" class="btn btn-primary">
            Skatīt manas rezervācijas
        </a>
        <a href="{{ route('batches.public') }}" class="btn btn-secondary">
            Turpināt iepirkties
        </a>
    </div>
</div>
@endsection