@extends('layouts.app')

@section('content')
<div class="orders-container">
    <h1>Mani pasūtījumi</h1>
    
    @if($orders->isEmpty())
        <div class="empty-state">
            <p style="font-size: 1.2em; color: #999; margin-bottom: 20px;">Jums vēl nav neviena pasūtījuma</p>
            <a href="{{ route('batches.public') }}" class="btn-primary">
                Apskatīt kūpinājumus
            </a>
        </div>
    @else
        @foreach($orders as $order)
        <div class="order-card">
            <div class="order-header">
                <span class="order-number">Pasūtījums #{{ $order->id }}</span>
                <span class="status-badge status-{{ $order->status }}">
                    @if($order->status == 'pending') Gaida apstiprinājumu
                    @elseif($order->status == 'confirmed') Apstiprināts
                    @elseif($order->status == 'completed') Pabeigts
                    @elseif($order->status == 'cancelled') Atcelts
                    @endif
                </span>
            </div>
            
            <div class="order-items">
                @foreach($order->items as $item)
                <div class="order-item">
                    <div class="item-info">
                        <div class="item-name">{{ $item->fish->name }}</div>
                        <div class="item-details">
                            {{ $item->batch->name ?? 'Batch #' . $item->batch->id }} | 
                            {{ $item->quantity }} {{ $item->getUnit() }} × {{ number_format($item->price, 2) }} €
                        </div>
                    </div>
                    <div class="item-price">{{ number_format($item->getTotalPrice(), 2) }} €</div>
                </div>
                @endforeach
            </div>
            
            <div class="order-footer">
                <div>
                    <div class="order-total">KOPĀ: {{ number_format($order->total_amount, 2) }} €</div>
                    <div class="order-date">{{ $order->created_at->format('d.m.Y H:i') }}</div>
                </div>
                <div class="order-actions">
                    <a href="{{ route('orders.show', $order->id) }}" class="btn btn-primary">Skatīt</a>
                    @if($order->status == 'pending')
                    <form action="{{ route('orders.cancel', $order->id) }}" method="POST" onsubmit="return confirm('Vai tiešām vēlaties atcelt šo pasūtījumu?')">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn delete-btn">Atcelt</button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    @endif
</div>
@endsection