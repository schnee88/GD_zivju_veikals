@extends('layouts.app')

@section('content')
<div class="order-detail">
    <div class="page-header">
        <h1>Pasūtījums #{{ $order->id }}</h1>
        <a href="{{ route('orders.index') }}" class="btn-secondary">
            ← Atpakaļ
        </a>
    </div>
    
    <div class="detail-card">
        <div class="order-header">
            <h2 style="border: none; margin: 0; padding: 0;">Pasūtījuma informācija</h2>
            <span class="status-badge status-{{ $order->status }}">
                @if($order->status == 'pending') Gaida apstiprinājumu
                @elseif($order->status == 'confirmed') Apstiprināts
                @elseif($order->status == 'completed') Pabeigts
                @elseif($order->status == 'cancelled') Atcelts
                @endif
            </span>
        </div>
        
        <div class="info-row">
            <span class="info-label">Pasūtījuma numurs:</span>
            <span class="info-value"><strong>#{{ $order->id }}</strong></span>
        </div>
        
        <div class="info-row">
            <span class="info-label">Telefons:</span>
            <span class="info-value">{{ $order->phone }}</span>
        </div>
        
        <div class="info-row">
            <span class="info-label">Izveidots:</span>
            <span class="info-value">{{ $order->created_at->format('d.m.Y H:i') }}</span>
        </div>
        
        <div class="info-row">
            <span class="info-label">Atjaunināts:</span>
            <span class="info-value">{{ $order->updated_at->format('d.m.Y H:i') }}</span>
        </div>
    </div>
    
    <div class="detail-card">
        <h2>Pasūtītās preces</h2>
        
        <table class="order-items-table">
            <thead>
                <tr>
                    <th>Zivs</th>
                    <th>Kūpinājums</th>
                    <th class="text-center">Daudzums</th>
                    <th class="text-right">Cena</th>
                    <th class="text-right">Summa</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td><strong>{{ $item->fish->name }}</strong></td>
                    <td>{{ $item->batch->name ?? 'Batch #' . $item->batch->id }}</td>
                    <td class="text-center">{{ $item->quantity }} {{ $item->getUnit() }}</td>
                    <td class="text-right">{{ number_format($item->price, 2) }} €</td>
                    <td class="text-right"><strong class="price-highlight">{{ number_format($item->getTotalPrice(), 2) }} €</strong></td>
                </tr>
                @endforeach
                <tr class="bg-light">
                    <td colspan="4" class="text-right total-row"><strong>KOPĀ:</strong></td>
                    <td class="text-right total-row"><strong class="total-amount">{{ number_format($order->total_amount, 2) }} €</strong></td>
                </tr>
            </tbody>
        </table>
    </div>
    
    @if($order->notes)
    <div class="notes-box" style="background: #fff9e6; border-left-color: #ffc107;">
        <h3>Jūsu piezīmes:</h3>
        <p>{{ $order->notes }}</p>
    </div>
    @endif
    
    @if($order->admin_notes && Auth::user()->is_admin)
    <div class="notes-box">
        <h3>Admin piezīmes:</h3>
        <p>{{ $order->admin_notes }}</p>
    </div>
    @endif
    
    @if($order->status == 'pending' && $order->user_id == Auth::id())
    <div class="text-center" style="margin-top: 20px;">
        <form action="{{ route('orders.cancel', $order->id) }}" method="POST" onsubmit="return confirm('Vai tiešām vēlaties atcelt šo pasūtījumu?')">
            @csrf
            @method('PATCH')
            <button type="submit" class="delete-btn cancel-btn">
                Atcelt pasūtījumu
            </button>
        </form>
    </div>
    @endif
</div>
@endsection