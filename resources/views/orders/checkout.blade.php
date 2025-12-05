@extends('layouts.app')

@section('content')

<div class="max-w-6xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-2 flex items-center gap-3">
            <span class="text-4xl">📋</span>
            <span>Pasūtījuma noformēšana</span>
        </h1>
        <p class="text-gray-600">
            Pārbaudiet savu pasūtījumu un aizpildiet kontaktinformāciju
        </p>
    </div>

    @if($cartItems->isEmpty())
        <!-- Empty Cart State -->
        <div class="max-w-md mx-auto text-center py-16">
            <div class="mb-8">
                <div class="inline-flex items-center justify-center w-24 h-24 bg-gray-100 rounded-full mb-6">
                    <span class="text-6xl">🛒</span>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">
                    Jūsu grozs ir tukšs
                </h2>
                <p class="text-gray-600 mb-8">
                    Nav ko pasūtīt. Pievienojiet produktus no veikala.
                </p>
            </div>
            
            <a href="{{ route('fish.shop') }}" 
               class="inline-flex items-center gap-2 px-6 py-4 bg-blue-600 text-white rounded-xl font-bold text-lg hover:bg-blue-700 transition-all shadow-lg hover:shadow-xl">
                <span>🛍️</span>
                <span>Apmeklēt veikalu</span>
            </a>
        </div>
    @else
        <!-- Important Info Banner -->
        <div class="mb-8 p-6 bg-blue-50 border-l-4 border-blue-500 rounded-lg shadow-sm">
            <div class="flex items-start gap-4">
                <span class="text-3xl flex-shrink-0">ℹ️</span>
                <div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Svarīgi!</h3>
                    <p class="text-gray-700 leading-relaxed">
                        Pēc pasūtījuma veikšanas administrators sazināsies ar jums norādītajā tālruņa numurā, 
                        lai apstiprinātu pasūtījumu un vienotos par saņemšanu.
                    </p>
                </div>
            </div>
        </div>

        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Left Column - Order Items -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Order Items Card -->
                <div class="bg-white rounded-2xl border-2 border-gray-200 overflow-hidden shadow-sm">
                    <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-white border-b border-gray-200">
                        <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                            <span>🛒</span>
                            <span>Groza saturs</span>
                        </h2>
                    </div>

                    <div class="p-6 space-y-4">
                        @foreach($cartItems as $item)
                            <div class="p-4 bg-gray-50 rounded-xl border border-gray-200">
                                <div class="flex justify-between items-start mb-3">
                                    <div class="flex items-center gap-3">
                                        <span class="text-2xl">🐟</span>
                                        <div>
                                            <h3 class="font-bold text-gray-900 text-lg">{{ $item->fish->name }}</h3>
                                            <p class="text-sm text-gray-600">
                                                {{ $item->quantity }} {{ $item->getUnit() }} × {{ number_format($item->fish->price, 2) }} €
                                            </p>
                                        </div>
                                    </div>
                                    <p class="text-xl font-bold text-green-600">
                                        {{ number_format($item->getTotalPrice(), 2) }} €
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Order Form Card -->
                <div class="bg-white rounded-2xl border-2 border-gray-200 overflow-hidden shadow-sm">
                    <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-white border-b border-gray-200">
                        <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                            <span>📝</span>
                            <span>Pasūtījuma informācija</span>
                        </h2>
                    </div>

                    <form action="{{ route('orders.store') }}" method="POST" id="checkoutForm" class="p-6 space-y-6">
                        @csrf

                        <div>
                            <label for="phone" class="block text-sm font-bold text-gray-700 mb-2">
                                Tālrunis <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="tel" 
                                id="phone" 
                                name="phone" 
                                value="{{ old('phone') }}"
                                placeholder="+371 20123456 vai 20123456"
                                required
                                class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-300 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all outline-none @error('phone') border-red-500 @enderror">
                            @error('phone')
                                <p class="mt-2 text-sm text-red-600 flex items-center gap-2">
                                    <span>⚠️</span>
                                    <span>{{ $message }}</span>
                                </p>
                            @enderror
                            <p class="mt-2 text-sm text-gray-500">
                                Formāts: +371 2XXXXXXX vai 2XXXXXXX
                            </p>
                        </div>

                        <div>
                            <label for="notes" class="block text-sm font-bold text-gray-700 mb-2">
                                Piezīmes (neobligāti)
                            </label>
                            <textarea 
                                id="notes" 
                                name="notes" 
                                rows="4"
                                placeholder="Papildu informācija, prasības vai jautājumi..."
                                class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-300 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all outline-none resize-none @error('notes') border-red-500 @enderror">{{ old('notes') }}</textarea>
                            @error('notes')
                                <p class="mt-2 text-sm text-red-600 flex items-center gap-2">
                                    <span>⚠️</span>
                                    <span>{{ $message }}</span>
                                </p>
                            @enderror
                        </div>

                        <!-- Summary in Form -->
                        <div class="pt-6 border-t border-gray-200 space-y-3">
                            <div class="flex justify-between items-center text-gray-700">
                                <span class="font-semibold">Preču skaits:</span>
                                <span class="font-bold">{{ $cartItems->count() }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-bold text-gray-900">Kopējā summa:</span>
                                <span class="text-2xl font-extrabold text-green-600">
                                    {{ number_format(Auth::user()->getCartTotal(), 2) }} €
                                </span>
                            </div>
                        </div>

                        <button 
                            type="submit"
                            class="w-full px-6 py-4 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-xl font-bold text-lg hover:from-green-700 hover:to-green-800 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                            <span>✓</span>
                            <span>Apstiprināt pasūtījumu</span>
                        </button>

                        <a href="{{ route('cart.index') }}" 
                           class="block w-full px-6 py-3 bg-gray-100 text-gray-700 text-center rounded-xl font-semibold hover:bg-gray-200 transition-colors">
                            ← Atpakaļ uz grozu
                        </a>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-1">
                <div class="sticky top-24">
                    <div class="bg-white rounded-2xl border-2 border-gray-200 overflow-hidden shadow-lg">
                        <!-- Header -->
                        <div class="px-6 py-4 bg-gradient-to-r from-blue-600 to-blue-700 text-white">
                            <h2 class="text-lg font-bold flex items-center gap-2">
                                <span>💰</span>
                                <span>Kopsavilkums</span>
                            </h2>
                        </div>

                        <!-- Content -->
                        <div class="p-6 space-y-4">
                            <!-- Items -->
                            <div class="space-y-3">
                                @foreach($cartItems as $item)
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600">{{ $item->fish->name }} ({{ $item->quantity }} {{ $item->getUnit() }})</span>
                                        <span class="font-semibold text-gray-900">{{ number_format($item->getTotalPrice(), 2) }} €</span>
                                    </div>
                                @endforeach
                            </div>

                            <div class="border-t border-gray-200 pt-4">
                                <div class="flex justify-between items-baseline">
                                    <span class="text-gray-700 font-semibold">KOPĀ:</span>
                                    <span class="text-2xl font-extrabold text-green-600">
                                        {{ number_format(Auth::user()->getCartTotal(), 2) }} €
                                    </span>
                                </div>
                            </div>

                            <!-- Info Box -->
                            <div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                                <p class="text-sm text-gray-700 leading-relaxed">
                                    <span class="font-semibold">⚠️ Maksājums:</span> 
                                    Maksājums tiek veikts tikai saņemot preci klātienē.
                                </p>
                            </div>

                            <!-- Trust Badges -->
                            <div class="space-y-3 pt-4 border-t border-gray-200">
                                <div class="flex items-center gap-3 text-sm text-gray-600">
                                    <span class="text-green-600 text-xl">✓</span>
                                    <span>Pasūtījums tiek apstiprināts ar zvanu</span>
                                </div>
                                <div class="flex items-center gap-3 text-sm text-gray-600">
                                    <span class="text-green-600 text-xl">✓</span>
                                    <span>Ātra apkalpošana</span>
                                </div>
                                <div class="flex items-center gap-3 text-sm text-gray-600">
                                    <span class="text-green-600 text-xl">✓</span>
                                    <span>Kvalitāte garantēta</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('checkoutForm');
        const phoneInput = document.getElementById('phone');
        
        // Format phone input
        phoneInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            
            if (value.startsWith('371')) {
                value = '+' + value;
            } else if (value.length === 8 && value.startsWith('2')) {
                value = '+371 ' + value;
            }
            
            e.target.value = value;
        });
        
        // Validate phone on submit
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
@endpush

@endsection