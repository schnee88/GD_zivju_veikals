@extends('layouts.app')

@section('content')
<div class="fish-page">
    <h1>🛒 Marinētu zivju veikals</h1>
    <p class="page-description">
        Pasūti marinētas zivis!
    </p>

    @if($fishes->isEmpty())
    <div class="empty-state">
        <p>Šobrīd nav pieejamu produktu pasūtīšanai</p>
    </div>
    @else
    <div class="fish-grid compact-grid shop-grid">
        @foreach($fishes as $fish)
        <div class="fish-card compact-card shop-card">
            <!-- Fish image -->
            <div class="fish-image-container">
                @if($fish->image)
                <img src="{{ asset('storage/fish_images/' . $fish->image) }}"
                    alt="{{ $fish->name }}"
                    class="fish-image">
                @else
                <div class="no-image">
                    <span>📷</span>
                </div>
                @endif
            </div>

            <div class="fish-header">
                <h3>🐟 {{ $fish->name }}</h3>
            </div>

            @if($fish->description)
            <div class="fish-description">
                <p>{{ Str::limit($fish->description, 80) }}</p>
            </div>
            @endif

            <div class="price-container">
                <p class="price">{{ number_format($fish->price, 2) }} €</p>
                <p class="price-label">/ {{ $fish->stock_unit == 'kg' ? 'kg' : 'gab.' }}</p>
            </div>

            <div class="stock-info {{ $fish->inStock() ? 'in-stock' : 'out-of-stock' }}">
                @if($fish->inStock())
                <p>✅ Pieejams: {{ $fish->stock_quantity }} {{ $fish->stock_unit == 'kg' ? 'kg' : 'gab.' }}</p>
                @else
                <p>❌ Nav pieejams</p>
                @endif
            </div>

            @auth
            @if($fish->inStock())
            <form action="{{ route('cart.add') }}" method="POST" class="add-to-cart-form">
                @csrf
                <input type="hidden" name="fish_id" value="{{ $fish->id }}">

                <div class="quantity-selector">
                    <label>Daudzums:</label>
                    <input
                        type="number"
                        name="quantity"
                        value="{{ $fish->stock_unit == 'kg' ? '0.5' : '1' }}"
                        min="{{ $fish->stock_unit == 'kg' ? '0.1' : '1' }}"
                        max="{{ $fish->stock_quantity }}"
                        step="{{ $fish->stock_unit == 'kg' ? '0.1' : '1' }}"
                        class="quantity-input"
                        required>
                </div>

                <button type="submit" class="btn-add-to-cart">
                    🛒 Pievienot grozam
                </button>
            </form>
            @else
            <div class="out-of-stock-message">
                Nav pieejams
            </div>
            @endif
            @else
            <a href="{{ route('login') }}" class="btn-login">
                🔐 Pieteikties
            </a>
            @endauth
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection