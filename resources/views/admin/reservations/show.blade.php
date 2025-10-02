@extends('layouts.app')

@section('content')
<style>
    .reservation-detail {
        max-width: 1000px;
        margin: 0 auto;
    }
    
    .detail-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 20px;
        margin-top: 20px;
    }
    
    .detail-card {
        background: white;
        padding: 25px;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    
    .detail-card h2 {
        color: #2c3e50;
        margin: 0 0 20px 0;
        padding-bottom: 10px;
        border-bottom: 2px solid #3498db;
    }
    
    .info-row {
        display: flex;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px solid #eee;
    }
    
    .info-row:last-child {
        border-bottom: none;
    }
    
    .info-label {
        font-weight: bold;
        color: #555;
    }
    
    .info-value {
        color: #333;
        text-align: right;
    }
    
    .status-badge {
        display: inline-block;
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 0.95em;
        font-weight: bold;
    }
    
    .status-pending {
        background: #fff3cd;
        color: #856404;
    }
    
    .status-confirmed {
        background: #d1ecf1;
        color: #0c5460;
    }
    
    .status-completed {
        background: #d4edda;
        color: #155724;
    }
    
    .status-cancelled {
        background: #f8d7da;
        color: #721c24;
    }
    
    .status-form {
        margin-top: 20px;
    }
    
    .status-form select {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        margin-bottom: 15px;
        font-size: 1em;
    }
    
    .status-form textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        min-height: 100px;
        margin-bottom: 15px;
        font-family: Arial, sans-serif;
    }
    
    .status-form button {
        width: 100%;
        background: #3498db;
        color: white;
        padding: 12px;
        border: none;
        border-radius: 4px;
        font-size: 1em;
        font-weight: bold;
        cursor: pointer;
    }
    
    .status-form button:hover {
        background: #2980b9;
    }
    
    .notes-box {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 5px;
        margin-top: 15px;
        border-left: 4px solid #3498db;
    }
    
    .notes-box h3 {
        margin: 0 0 10px 0;
        color: #2c3e50;
        font-size: 1em;
    }
    
    .notes-box p {
        margin: 0;
        color: #555;
        line-height: 1.6;
    }
    
    .warning-box {
        background: #fff3cd;
        border-left: 4px solid #ffc107;
        padding: 15px;
        border-radius: 5px;
        margin-bottom: 20px;
    }
    
    .warning-box p {
        margin: 0;
        color: #856404;
    }
    
    .contact-buttons {
        display: flex;
        gap: 10px;
        margin-top: 15px;
    }
    
    .contact-btn {
        flex: 1;
        padding: 10px;
        border: none;
        border-radius: 4px;
        font-weight: bold;
        cursor: pointer;
        text-decoration: none;
        text-align: center;
        display: block;
    }
    
    .phone-btn {
        background: #27ae60;
        color: white;
    }
    
    .phone-btn:hover {
        background: #229954;
    }
    
    .email-btn {
        background: #3498db;
        color: white;
    }
    
    .email-btn:hover {
        background: #2980b9;
    }
    
    @media (max-width: 768px) {
        .detail-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="reservation-detail">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h1>Rezervācija #{{ $reservation->id }}</h1>
        <a href="{{ route('admin.reservations.index') }}" style="background: #95a5a6; color: white; padding: 10px 20px; border-radius: 4px; text-decoration: none;">
            ← Atpakaļ
        </a>
    </div>
    
    @if($reservation->status == 'pending')
    <div class="warning-box">
        <p><strong>⚠️ Šī rezervācija gaida apstiprinājumu!</strong> Lūdzu, piezvaniet klientam un apstipriniet rezervāciju.</p>
    </div>
    @endif
    
    <div class="detail-grid">
        <!-- Left Column -->
        <div>
            <div class="detail-card">
                <h2>Rezervācijas informācija</h2>
                
                <div class="info-row">
                    <span class="info-label">Status:</span>
                    <span class="info-value">
                        <span class="status-badge status-{{ $reservation->status }}">
                            @if($reservation->status == 'pending') Gaida apstiprinājumu
                            @elseif($reservation->status == 'confirmed') Apstiprināta
                            @elseif($reservation->status == 'completed') Pabeigta
                            @elseif($reservation->status == 'cancelled') Atcelta
                            @endif
                        </span>
                    </span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">Zivs:</span>
                    <span class="info-value"><strong>{{ $reservation->fish->name }}</strong></span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">Kūpinājums:</span>
                    <span class="info-value">{{ $reservation->batch->name ?? 'Batch #' . $reservation->batch->id }}</span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">Daudzums:</span>
                    <span class="info-value">
                        {{ $reservation->quantity }} 
                        {{ $reservation->batch->fishes()->where('fish_id', $reservation->fish_id)->first()->pivot->unit }}
                    </span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">Cena par vienību:</span>
                    <span class="info-value">{{ number_format($reservation->fish->price, 2) }} €</span>
                </div>
                
                <div class="info-row" style="background: #f8f9fa; padding: 15px; margin-top: 10px;">
                    <span class="info-label" style="font-size: 1.2em;">KOPĀ:</span>
                    <span class="info-value" style="font-size: 1.3em; color: #27ae60; font-weight: bold;">
                        {{ number_format($reservation->quantity * $reservation->fish->price, 2) }} €
                    </span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">Izveidots:</span>
                    <span class="info-value">{{ $reservation->created_at->format('d.m.Y H:i') }}</span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">Atjaunināts:</span>
                    <span class="info-value">{{ $reservation->updated_at->format('d.m.Y H:i') }}</span>
                </div>
            </div>
            
            @if($reservation->notes)
            <div class="notes-box" style="background: #fff9e6; border-left-color: #ffc107; margin-top: 20px;">
                <h3>Klienta piezīmes:</h3>
                <p>{{ $reservation->notes }}</p>
            </div>
            @endif
            
            @if($reservation->admin_notes)
            <div class="notes-box" style="margin-top: 20px;">
                <h3>Admin piezīmes:</h3>
                <p>{{ $reservation->admin_notes }}</p>
            </div>
            @endif
        </div>
        
        <!-- Right Column -->
        <div>
            <div class="detail-card">
                <h2>Klienta informācija</h2>
                
                <div class="info-row">
                    <span class="info-label">Vārds:</span>
                    <span class="info-value">{{ $reservation->user->name }}</span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">E-pasts:</span>
                    <span class="info-value">{{ $reservation->user->email }}</span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">Telefons:</span>
                    <span class="info-value"><strong>{{ $reservation->phone }}</strong></span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">IP adrese:</span>
                    <span class="info-value" style="font-size: 0.9em; color: #666;">{{ $reservation->ip_address }}</span>
                </div>
                
                <div class="contact-buttons">
                    <a href="tel:{{ $reservation->phone }}" class="contact-btn phone-btn">
                        📞 Zvanīt
                    </a>
                    <a href="mailto:{{ $reservation->user->email }}" class="contact-btn email-btn">
                        ✉️ E-pasts
                    </a>
                </div>
            </div>
            
            <div class="detail-card" style="margin-top: 20px;">
                <h2>Mainīt statusu</h2>
                
                <form action="{{ route('admin.reservations.updateStatus', $reservation->id) }}" method="POST" class="status-form">
                    @csrf
                    @method('PATCH')
                    
                    <label for="status" style="display: block; margin-bottom: 8px; font-weight: bold;">Jauns status:</label>
                    <select name="status" id="status" required>
                        <option value="pending" {{ $reservation->status == 'pending' ? 'selected' : '' }}>
                            Gaida apstiprinājumu
                        </option>
                        <option value="confirmed" {{ $reservation->status == 'confirmed' ? 'selected' : '' }}>
                            Apstiprināta
                        </option>
                        <option value="completed" {{ $reservation->status == 'completed' ? 'selected' : '' }}>
                            Pabeigta (klients saņēmis preci)
                        </option>
                        <option value="cancelled" {{ $reservation->status == 'cancelled' ? 'selected' : '' }}>
                            Atcelta
                        </option>
                    </select>
                    
                    <label for="admin_notes" style="display: block; margin-bottom: 8px; font-weight: bold;">Admin piezīmes:</label>
                    <textarea 
                        name="admin_notes" 
                        id="admin_notes" 
                        placeholder="Piezīmes par rezervāciju, zvana rezultāts, utt..."
                    >{{ old('admin_notes', $reservation->admin_notes) }}</textarea>
                    
                    <button type="submit">Atjaunināt</button>
                </form>
                
                <div style="margin-top: 15px; padding: 12px; background: #e8f5e9; border-radius: 4px; font-size: 0.9em;">
                    <strong>ℹ️ Informācija:</strong>
                    <ul style="margin: 10px 0 0 20px; color: #555;">
                        <li>Apstiprinot rezervāciju, pieejamais daudzums tiks samazināts</li>
                        <li>Atceļot apstiprinātu rezervāciju, daudzums tiks atgriezts</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection