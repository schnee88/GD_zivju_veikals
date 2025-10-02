@extends('layouts.app')

@section('content')
<style>
    .orders-container {
        max-width: 1000px;
        margin: 0 auto;
    }
    
    .order-card {
        background: white;
        padding: 25px;
        margin-bottom: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        transition: transform 0.2s;
    }
    
    .order-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }
    
    .order-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
        padding-bottom: 15px;
        border-bottom: 2px solid #eee;
    }
    
    .order-number {
        font-size: 1.3em;
        font-weight: bold;
        color: #2c3e50;
    }
    
    .status-badge {
        display: inline-block;
        padding: 6px 15px;
        border-radius: 20px;
        font-weight: bold;
        font-size: 0.9em;
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
    
    .order-items {
        margin: 15px 0;
    }
    
    .order-item {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .order-item:last-child {
        border-bottom: none;
    }
    
    .item-info {
        flex: 1;
    }
    
    .item-name {
        font-weight: bold;
        color: #2c3e50;
    }
    
    .item-details {
        color: #666;
        font-size: 0.9em;
        margin-top: 3px;
    }
    
    .item-price {
        font-weight: bold;
        color: #27ae60;
        white-space: nowrap;
        margin-left: 15px;
    }
    
    .order-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 15px;
        padding-top: 15px;
        border-top: 2px solid #eee;
    }
    
    .order-total {
        font-size: 1.2em;
        font-weight: bold;
        color: #2c3e50;
    }
    
    .order-date {
        color: #666;
        font-size: 0.9em;
    }
    
    .order-actions {
        display: flex;
        gap: 10px;
        margin-top: 10px;
    }
    
    .btn {
        padding: 8px 20px;
        border-radius: 4px;
        text-decoration: none;
        font-size: 0.9em;
        font-weight: bold;
        border: none;
        cursor: pointer;
    }
    
    .btn-view {
        background: #3498db;
        color: white;
    }
    
    .btn-view:hover {
        background: #2980b9;
    }
    
    .btn-cancel {
        background: #e74c3c;
        color: white;
    }
    
    .btn-cancel:hover {
        background: #c0392b;
    }
    
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
</style>

<div class="orders-container">
    <h1>Mani pasūtījumi</h1>
    
    @if($orders->isEmpty())
        <div class="empty-state">
            <p style="font-size: 1.2em; color: #999; margin-bottom: 20px;">Jums vēl nav neviena pasūtījuma</p>
            <a href="{{ route('batches.public') }}" style="background: #3498db; color: white; padding: 12px 24px; border-radius: 6px; text-decoration: none;">
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
                    <a href="{{ route('orders.show', $order->id) }}" class="btn btn-view">Skatīt</a>
                    @if($order->status == 'pending')
                    <form action="{{ route('orders.cancel', $order->id) }}" method="POST" onsubmit="return confirm('Vai tiešām vēlaties atcelt šo pasūtījumu?')">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-cancel">Atcelt</button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    @endif
</div>
@endsection