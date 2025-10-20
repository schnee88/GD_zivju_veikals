@extends('layouts.app')

@section('content')
<div class="admin-container">
    <div class="admin-header">
        <h1>🛒Grozs</h1>
    </div>

    @if($cartItems->isEmpty())
    <div class="empty-state">
        <p>Jūsu grozs ir tukšs</p>
        <a href="{{ route('fish.shop') }}" class="btn btn-primary">
            Apskatīt pieejamo produkciju
        </a>
    </div>
    @else
    <div class="cart-items">
        @foreach($cartItems as $item)
        <div class="cart-item">
            <div class="item-info">
                <h3>{{ $item->fish->name }}</h3>
                <p><strong>Cena par {{ $item->fish->stock_unit == 'kg' ? 'kg' : 'gab.' }}:</strong> {{ number_format($item->fish->price, 2) }} €</p>
                <p class="stock-info"><strong>Pieejams:</strong> {{ $item->fish->stock_quantity }} {{ $item->fish->stock_unit }}</p>
            </div>

            <div class="quantity-control">
                <form action="{{ route('cart.update', $item->id) }}" method="POST" class="quantity-form">
                    @csrf
                    @method('PATCH')
                    <input
                        type="number"
                        name="quantity"
                        value="{{ $item->quantity }}"
                        min="{{ $item->fish->stock_unit == 'kg' ? '0.1' : '1' }}"
                        max="{{ $item->fish->stock_quantity }}"
                        step="{{ $item->fish->stock_unit == 'kg' ? '0.1' : '1' }}"
                        class="quantity-input"
                        required>
                    <button type="submit" class="btn btn-success btn-sm">✓</button>
                </form>
            </div>

            <div class="item-price">
                {{ number_format($item->quantity * $item->fish->price, 2) }} €
            </div>

            <form action="{{ route('cart.remove', $item->id) }}" method="POST" class="remove-form">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-error btn-sm" onclick="return confirm('Vai tiešām vēlaties izņemt šo zivi no groza?')">
                    🗑️
                </button>
            </form>
        </div>
        @endforeach
    </div>

    <div class="cart-summary">
        <div class="summary-row">
            <span>Kopā preču:</span>
            <span><strong>{{ $cartItems->count() }}</strong></span>
        </div>
        <div class="summary-row summary-total">
            <span>KOPĀ (Aptuvenā summa):</span>
            <span class="total-amount">{{ number_format($total, 2) }} €</span>
        </div>

        <a href="{{ route('orders.checkout') }}" class="btn btn-primary checkout-btn">
            📋 Veikt Pasūtījumu
        </a>

        <form action="{{ route('cart.clear') }}" method="POST" class="clear-form">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-secondary" onclick="return confirm('Vai tiešām vēlaties iztīrīt grozu?')">
                Iztīrīt grozu
            </button>
        </form>
    </div>
    @endif
</div>
@endsection