@extends('layouts.app')

@section('content')
<style>
    .cart-container {
        max-width: 1000px;
        margin: 0 auto;
    }
    
    .cart-item {
        background: white;
        padding: 20px;
        margin-bottom: 15px;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        display: grid;
        grid-template-columns: 1fr 150px 150px 100px 80px;
        gap: 15px;
        align-items: center;
    }
    
    .cart-item:hover {
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }
    
    .item-info h3 {
        margin: 0 0 5px 0;
        color: #2c3e50;
    }
    
    .item-info p {
        margin: 3px 0;
        color: #666;
        font-size: 0.9em;
    }
    
    .quantity-input {
        display: flex;
        align-items: center;
        gap: 5px;
    }
    
    .quantity-input input {
        width: 70px;
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 4px;
        text-align: center;
    }
    
    .quantity-input button {
        background: #3498db;
        color: white;
        border: none;
        padding: 8px 12px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 0.85em;
    }
    
    .quantity-input button:hover {
        background: #2980b9;
    }
    
    .price {
        font-size: 1.2em;
        font-weight: bold;
        color: #27ae60;
        text-align: right;
    }
    
    .remove-btn {
        background: #e74c3c;
        color: white;
        border: none;
        padding: 8px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 1.2em;
    }
    
    .remove-btn:hover {
        background: #c0392b;
    }
    
    .cart-summary {
        background: white;
        padding: 25px;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        margin-top: 20px;
    }
    
    .summary-row {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid #eee;
    }
    
    .summary-total {
        font-size: 1.5em;
        font-weight: bold;
        color: #2c3e50;
        padding-top: 15px;
    }
    
    .checkout-btn {
        width: 100%;
        background: #27ae60;
        color: white;
        padding: 15px;
        border: none;
        border-radius: 6px;
        font-size: 1.1em;
        font-weight: bold;
        cursor: pointer;
        margin-top: 15px;
    }
    
    .checkout-btn:hover {
        background: #229954;
    }
    
    .clear-cart-btn {
        background: #95a5a6;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        margin-top: 10px;
    }
    
    .clear-cart-btn:hover {
        background: #7f8c8d;
    }
    
    .empty-cart {
        text-align: center;
        padding: 60px 20px;
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    
    @media (max-width: 768px) {
        .cart-item {
            grid-template-columns: 1fr;
            gap: 10px;
        }
        
        .price {
            text-align: left;
        }
    }
</style>

<div class="cart-container">
    <h1>🛒 Mans Grozs</h1>
    
    @if($cartItems->isEmpty())
        <div class="empty-cart">
            <p style="font-size: 1.2em; color: #999; margin-bottom: 20px;">Jūsu grozs ir tukšs</p>
            <a href="{{ route('batches.public') }}" style="background: #3498db; color: white; padding: 12px 24px; border-radius: 6px; text-decoration: none; display: inline-block;">
                Apskatīt kūpinājumus
            </a>
        </div>
    @else
        <div class="cart-items">
            @foreach($cartItems as $item)
            <div class="cart-item">
                <div class="item-info">
                    <h3>{{ $item->fish->name }}</h3>
                    <p><strong>Kūpinājums:</strong> {{ $item->batch->name ?? 'Batch #' . $item->batch->id }}</p>
                    <p><strong>Cena par {{ $item->batch->fishes()->where('fish_id', $item->fish_id)->first()->pivot->unit }}:</strong> {{ number_format($item->fish->price, 2) }} €</p>
                    <p style="color: #27ae60;"><strong>Pieejams:</strong> {{ $item->batch->fishes()->where('fish_id', $item->fish_id)->first()->pivot->available_quantity }} {{ $item->batch->fishes()->where('fish_id', $item->fish_id)->first()->pivot->unit }}</p>
                </div>
                
                <div class="quantity-input">
                    <form action="{{ route('cart.update', $item->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input 
                            type="number" 
                            name="quantity" 
                            value="{{ $item->quantity }}"
                            min="0.1"
                            max="{{ $item->batch->fishes()->where('fish_id', $item->fish_id)->first()->pivot->available_quantity }}"
                            step="0.1"
                            required
                        >
                        <button type="submit">✓</button>
                    </form>
                </div>
                
                <div class="price">
                    {{ number_format($item->getTotalPrice(), 2) }} €
                </div>
                
                <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="remove-btn" onclick="return confirm('Vai tiešām vēlaties izņemt šo zivi no groza?')">
                        🗑️
                    </button>
                </form>
            </div>
            @endforeach
        </div>
        
        <div class="cart-summary">
            <div class="summary-row">
                <span>Kopā preču:</span>
                <span>{{ $cartItems->count() }}</span>
            </div>
            <div class="summary-row summary-total">
                <span>KOPĀ:</span>
                <span style="color: #27ae60;">{{ number_format($total, 2) }} €</span>
            </div>
            
            <form action="{{ route('cart.checkout') }}" method="POST">
                @csrf
                <button type="submit" class="checkout-btn">
                    📋 Veikt Rezervāciju
                </button>
            </form>
            
            <form action="{{ route('cart.clear') }}" method="POST" style="text-align: center;">
                @csrf
                @method('DELETE')
                <button type="submit" class="clear-cart-btn" onclick="return confirm('Vai tiešām vēlaties iztīrīt grozu?')">
                    Iztīrīt grozu
                </button>
            </form>
        </div>
    @endif
</div>
@endsection