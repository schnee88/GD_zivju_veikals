@extends('layouts.app')

@section('content')

<div class="reservation-container">
    <h1>Rezervācija #{{ $reservation->id }}</h1>
    
    <div style="text-align: center; margin: 20px 0;">
        <span class="status-badge status-{{ $reservation->status }}">
            @if($reservation->status == 'pending') Gaida apstiprinājumu
            @elseif($reservation->status == 'confirmed') Apstiprināta
            @elseif($reservation->status == 'completed') Pabeigta
            @elseif($reservation->status == 'cancelled') Atcelta
            @endif
        </span>
    </div>
    
    <div class="detail-section">
        <div class="detail-row">
            <span class="detail-label">Zivs:</span>
            <span class="detail-value">{{ $reservation->fish->name }}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Kūpinājums:</span>
            <span class="detail-value">{{ $reservation->batch->name ?? 'Batch #' . $reservation->batch->id }}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Daudzums:</span>
            <span class="detail-value">{{ $reservation->quantity }} kg</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Telefons:</span>
            <span class="detail-value">{{ $reservation->phone }}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Izveidots:</span>
            <span class="detail-value">{{ $reservation->created_at->format('d.m.Y H:i') }}</span>
        </div>
    </div>
    
    @if($reservation->notes)
    <div class="notes-box">
        <strong>Jūsu piezīmes:</strong>
        <p style="margin-top: 10px;">{{ $reservation->notes }}</p>
    </div>
    @endif
    
    @if($reservation->admin_notes && auth()->user()->is_admin)
    <div class="notes-box" style="background: #e3f2fd; border-left-color: #2196F3;">
        <strong>Admin piezīmes:</strong>
        <p style="margin-top: 10px;">{{ $reservation->admin_notes }}</p>
    </div>
    @endif
    
    <div style="margin-top: 30px; text-align: center;">
        <a href="{{ route('reservations.index') }}" class="btn-secondary" style="background: #3498db; color: white; padding: 10px 20px; border-radius: 4px; text-decoration: none;">
            Atpakaļ uz visām rezervācijām
        </a>
    </div>
</div>
@endsection