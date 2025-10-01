@extends('layouts.app')

@section('content')

<div class="reservation-container">
    <h1>Rezervēt zivi</h1>
    
    <div class="fish-info">
        <p><strong>Zivs:</strong> {{ $fish->name }}</p>
        <p><strong>Kūpinājums:</strong> {{ $batch->name ?? 'Batch #' . $batch->id }}</p>
        <p><strong>Pieejamais daudzums:</strong> {{ $batchFish->pivot->available_quantity }} {{ $batchFish->pivot->unit }}</p>
        <p><strong>Datums:</strong> {{ $batch->smoke_date }}</p>
    </div>
    
    <form action="{{ route('reservations.store') }}" method="POST">
        @csrf
        
        <input type="hidden" name="batch_id" value="{{ $batch->id }}">
        <input type="hidden" name="fish_id" value="{{ $fish->id }}">
        
        <div class="form-group">
            <label for="quantity">Daudzums ({{ $batchFish->pivot->unit }})*</label>
            <input 
                type="number" 
                id="quantity" 
                name="quantity" 
                value="{{ old('quantity', 1) }}"
                min="1"
                max="{{ $batchFish->pivot->available_quantity }}"
                step="0.1"
                required
            >
            @error('quantity')
                <div style="color: #d32f2f; font-size: 13px; margin-top: 5px;">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="phone">Telefona numurs*</label>
            <input 
                type="text" 
                id="phone" 
                name="phone" 
                value="{{ old('phone') }}"
                placeholder="+371 20123456 vai 20123456"
                required
            >
            <div class="info-text">Administratoris sazināsies ar jums, lai apstiprinātu rezervāciju</div>
            @error('phone')
                <div style="color: #d32f2f; font-size: 13px; margin-top: 5px;">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="notes">Piezīmes (neobligāti)</label>
            <textarea 
                id="notes" 
                name="notes" 
                placeholder="Papildus informācija vai īpaši lūgumi..."
            >{{ old('notes') }}</textarea>
            @error('notes')
                <div style="color: #d32f2f; font-size: 13px; margin-top: 5px;">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="button-group">
            <button type="submit">Rezervēt</button>
            <a href="{{ url()->previous() }}" class="btn-secondary">Atpakaļ</a>
        </div>
    </form>
</div>
@endsection