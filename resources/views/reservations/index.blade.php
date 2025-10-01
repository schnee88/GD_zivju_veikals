@extends('layouts.app')

@section('content')


<div class="reservations-container">
    <h1>Manas rezervācijas</h1>
    
    @if($reservations->isEmpty())
        <div class="empty-state">
            <p style="font-size: 18px; margin-bottom: 20px;">Jums vēl nav nevienas rezervācijas</p>
            <a href="{{ route('batches.public') }}" style="background: #3498db; color: white; padding: 12px 24px; border-radius: 4px; text-decoration: none;">
                Apskatīt kūpinājumus
            </a>
        </div>
    @else
        @foreach($reservations as $reservation)
        <div class="reservation-item">
            <div class="reservation-info">
                <h3>{{ $reservation->fish->name }}</h3>
                <p><strong>Kūpinājums:</strong> {{ $reservation->batch->name ?? 'Batch #' . $reservation->batch->id }}</p>
                <p><strong>Daudzums:</strong> {{ $reservation->quantity }} kg</p>
                <p><strong>Datums:</strong> {{ $reservation->created_at->format('d.m.Y H:i') }}</p>
                <span class="status-badge status-{{ $reservation->status }}">
                    @if($reservation->status == 'pending') Gaida apstiprinājumu
                    @elseif($reservation->status == 'confirmed') Apstiprināta
                    @elseif($reservation->status == 'completed') Pabeigta
                    @elseif($reservation->status == 'cancelled') Atcelta
                    @endif
                </span>
            </div>
            <div class="reservation-actions">
                <a href="{{ route('reservations.show', $reservation->id) }}" class="view-btn">Skatīt</a>
                <form action="{{ route('reservations.destroy', $reservation->id) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="delete-btn" onclick="return confirm('Vai tiešām vēlaties dzēst šo rezervāciju?')">
                        Dzēst
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    @endif
</div>
@endsection