@extends('layouts.app')

@section('content')
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
                <p><strong>Cena par {{ $item->getUnit() }}:</strong> {{ number_format($item->fish->price, 2) }} €</p>
                <p style="color: #27ae60;"><strong>Pieejams:</strong> {{ $item->getAvailableQuantity() }} {{ $item->getUnit() }}</p>
            </div>

            <div class="quantity-input">
                <form action="{{ route('cart.update', $item->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <input
                        type="number"
                        name="quantity"
                        value="{{ $item->quantity }}"
                        min="{{ $item->getUnit() == 'kg' ? '0.1' : '1' }}"
                        max="{{ $item->getAvailableQuantity() }}"
                        step="{{ $item->getUnit() == 'kg' ? '0.1' : '1' }}"
                        required>
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

        <form action="{{ route('reservations.checkout') }}" method="GET">
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