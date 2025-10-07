@extends('layouts.app')

@section('content')
<div class="checkout-container">
    <h1>Pasūtījuma noformēšana</h1>
    
    @if($cartItems->isEmpty())
        <div class="empty-state">
            <p>Jūsu grozs ir tukšs</p>
            <a href="{{ route('batches.public') }}" class="btn-primary">
                Apskatīt kūpinājumus
            </a>
        </div>
    @else
        <div class="info-box">
            <p><strong>ℹ️ Svarīgi:</strong> Pēc pasūtījuma veikšanas administratoris sazināsies ar jums norādītajā tālruņa numurā, lai apstiprinātu pasūtījumu un vienotos par saņemšanu.</p>
        </div>

        <div class="checkout-grid">
            <!-- Left Column - Order Items -->
            <div>
                <div class="checkout-section">
                    <h2 class="section-title">Groza saturs</h2>
                    
                    @foreach($cartItems as $item)
                    <div class="cart-item">
                        <div class="cart-item-header">
                            <span class="item-name">{{ $item->fish->name }}</span>
                            <span class="item-price">{{ number_format ($item->getTotalPrice(), 2) }} €</span>
                        </div>
                        <div class="item-details">
                            <p><strong>Kūpinājums:</strong> {{ $item->batch->name ?? 'Kūpinājums #' . $item->batch->id }}</p>
                            <p><strong>Daudzums:</strong> {{ $item->quantity }} {{ $item->getUnit() }}</p>
                            <p><strong>Cena par {{ $item->getUnit() }}:</strong> {{ number_format($item->fish->price, 2) }} €</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Right Column - Order Form -->
            <div>
                <div class="checkout-section">
                    <h2 class="section-title">Pasūtījuma informācija</h2>
                    
                    <form action="{{ route('orders.store') }}" method="POST" id="checkoutForm">
                        @csrf
                        
                        <div class="form-group">
                            <label for="phone" class="form-label">Tālrunis *</label>
                            <input 
                                type="tel" 
                                id="phone" 
                                name="phone" 
                                class="form-input" 
                                value="{{ old('phone') }}"
                                placeholder="+371 20123456 vai 20123456"
                                required
                            >
                            @error('phone')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                            <div class="info-text">
                                Formāts: +371 2XXXXXXX vai 2XXXXXXX
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="notes" class="form-label">Piezīmes (neobligāti)</label>
                            <textarea 
                                id="notes" 
                                name="notes" 
                                class="form-input form-textarea" 
                                placeholder="Papildu informācija, prasības vai jautājumi..."
                            >{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="summary-row">
                            <span>Preču skaits:</span>
                            <span><strong>{{ $cartItems->count() }}</strong></span>
                        </div>
                        <div class="summary-row" style="border-bottom: none;">
                            <span style="font-size: 1.2em;"><strong>Kopējā summa:</strong></span>
                            <span style="font-weight: bold; color: #27ae60; font-size: 1.3em;">
                                {{ number_format(Auth::user()->getCartTotal(), 2) }} €
                            </span>
                        </div>
                        
                        <button type="submit" class="checkout-btn">
                            Apstiprināt pasūtījumu
                        </button>
                    </form>
                    
                    <a href="{{ route('cart.index') }}" class="back-btn">
                        ← Atpakaļ uz grozu
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('checkoutForm');
        const phoneInput = document.getElementById('phone');
        
        phoneInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            
            if (value.startsWith('371')) {
                value = '+' + value;
            } else if (value.length === 8 && value.startsWith('2')) {
                value = '+371 ' + value;
            }
            
            e.target.value = value;
        });
        
        form.addEventListener('submit', function(e) {
            const phoneValue = phoneInput.value.replace(/\s+/g, '');
            const phoneRegex = /^(\+371|371)?[2-3]\d{7}$/;
            
            if (!phoneRegex.test(phoneValue.replace(/\D/g, ''))) {
                e.preventDefault();
                alert('Lūdzu, ievadiet derīgu Latvijas telefona numuru');
                phoneInput.focus();
            }
        });
    });
</script>
@endsection