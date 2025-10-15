@extends('layouts.app')

@section('content')
<div class="admin-container">
    <div class="admin-header">
        <h1>Pasūtījums #{{ $order->id }}</h1>
        <a href="{{ route('orders.index') }}" class="btn btn-secondary">
            ← Atpakaļ uz pasūtījumiem
        </a>
    </div>
    
    <div class="detail-card">
        <div class="order-header">
            <h2>Pasūtījuma informācija</h2>
            <span class="status-badge status-{{ $order->status }}">
                @if($order->status == 'pending') Gaida apstiprinājumu
                @elseif($order->status == 'confirmed') Apstiprināts
                @elseif($order->status == 'completed') Pabeigts
                @elseif($order->status == 'cancelled') Atcelts
                @endif
            </span>
        </div>
        
        <div class="info-grid">
            <div class="info-group">
                <span class="info-label">Pasūtījuma numurs:</span>
                <span class="info-value"><strong>#{{ $order->id }}</strong></span>
            </div>
            
            <div class="info-group">
                <span class="info-label">Telefons:</span>
                <span class="info-value">{{ $order->phone }}</span>
            </div>
            
            <div class="info-group">
                <span class="info-label">Izveidots:</span>
                <span class="info-value">{{ $order->created_at->format('d.m.Y H:i') }}</span>
            </div>
            
            <div class="info-group">
                <span class="info-label">Atjaunināts:</span>
                <span class="info-value">{{ $order->updated_at->format('d.m.Y H:i') }}</span>
            </div>
        </div>
    </div>
    
    <div class="detail-card">
        <h2>Pasūtītās preces</h2>
        
        <div class="order-items-table">
            <table>
                <thead>
                    <tr>
                        <th>Zivs</th>
                        <th>Mērvienība</th>
                        <th class="text-center">Daudzums</th>
                        <th class="text-right">Cena</th>
                        <th class="text-right">Summa</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td><strong>{{ $item->fish->name }}</strong></td>
                        <td>{{ $item->fish->stock_unit == 'kg' ? 'kg' : 'gab.' }}</td>
                        <td class="text-center">{{ $item->quantity }} {{ $item->fish->stock_unit == 'kg' ? 'kg' : 'gab.' }}</td>
                        <td class="text-right">{{ number_format($item->price, 2) }} €</td>
                        <td class="text-right"><strong class="price-highlight">{{ number_format($item->quantity * $item->price, 2) }} €</strong></td>
                    </tr>
                    @endforeach
                    <tr class="total-row">
                        <td colspan="4" class="text-right"><strong>KOPĀ:</strong></td>
                        <td class="text-right"><strong class="total-amount">{{ number_format($order->total_amount, 2) }} €</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    
    @if($order->notes)
    <div class="notes-box customer-notes">
        <h3>Jūsu piezīmes:</h3>
        <p>{{ $order->notes }}</p>
    </div>
    @endif
    
    @if($order->admin_notes && Auth::user()->is_admin)
    <div class="notes-box admin-notes">
        <h3>Admin piezīmes:</h3>
        <p>{{ $order->admin_notes }}</p>
    </div>
    @endif
    
    @if($order->status == 'pending' && $order->user_id == Auth::id())
    <div class="form-actions">
        <form action="{{ route('orders.cancel', $order->id) }}" method="POST" class="cancel-form" onsubmit="return confirm('Vai tiešām vēlaties atcelt šo pasūtījumu?')">
            @csrf
            @method('PATCH')
            <button type="submit" class="btn btn-error">
                ❌ Atcelt pasūtījumu
            </button>
        </form>
    </div>
    @endif
</div>
@endsection