@extends('layouts.app')

@section('content')

<div class="max-w-6xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-2 flex items-center gap-3">
            <span class="text-4xl">🛒</span>
            <span>Mans grozs</span>
        </h1>
        <p class="text-gray-600">
            Pārskatiet un rediģējiet savus izvēlētos produktus
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
                    Pievienojiet produktus no mūsu veikala, lai turpinātu
                </p>
            </div>
            
            <div class="space-y-3">
                <a href="{{ route('fish.shop') }}" 
                   class="block w-full px-6 py-4 bg-blue-600 text-white rounded-xl font-bold text-lg hover:bg-blue-700 transition-all shadow-lg hover:shadow-xl">
                    🛍️ Apmeklēt veikalu
                </a>
                <a href="{{ route('fish.catalog') }}" 
                   class="block w-full px-6 py-3 bg-gray-100 text-gray-700 rounded-xl font-semibold hover:bg-gray-200 transition-colors">
                    📖 Skatīt katalogu
                </a>
            </div>
        </div>
    @else
        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Cart Items (Left Side - 2 columns) -->
            <div class="lg:col-span-2 space-y-4">
                @foreach($cartItems as $item)
                    <div class="bg-white rounded-2xl border-2 border-gray-200 overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300">
                        <div class="p-6">
                            <div class="flex flex-col md:flex-row gap-6">
                                <!-- Product Image -->
                                <div class="flex-shrink-0">
                                    <div class="w-full md:w-32 h-32 bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl overflow-hidden border border-gray-200">
                                        @if($item->fish->image)
                                            <img src="{{ asset('storage/fish_images/' . $item->fish->image) }}" 
                                                 alt="{{ $item->fish->name }}"
                                                 class="w-full h-full object-contain p-3">
                                        @else
                                            <div class="flex items-center justify-center h-full">
                                                <span class="text-4xl text-gray-300">🐟</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Product Info -->
                                <div class="flex-1 space-y-3">
                                    <div>
                                        <h3 class="text-xl font-bold text-gray-900 mb-2 flex items-center gap-2">
                                            <span>🐟</span>
                                            <span>{{ $item->fish->name }}</span>
                                        </h3>
                                        <div class="space-y-1 text-sm text-gray-600">
                                            <p class="flex items-center gap-2">
                                                <span class="font-semibold">Cena par {{ $item->fish->stock_unit == 'kg' ? 'kg' : 'gab.' }}:</span>
                                                <span class="text-green-600 font-bold">{{ number_format($item->fish->price, 2) }} €</span>
                                            </p>
                                            <p class="flex items-center gap-2">
                                                <span class="font-semibold">📦 Pieejams:</span>
                                                <span class="text-blue-600 font-medium">{{ $item->fish->stock_quantity }} {{ $item->fish->stock_unit == 'kg' ? 'kg' : 'gab.' }}</span>
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Quantity & Actions -->
                                    <div class="flex flex-wrap items-center gap-4 pt-3 border-t border-gray-200">
                                        <!-- Quantity Update Form -->
                                        <form action="{{ route('cart.update', $item->id) }}" method="POST" class="flex items-center gap-3">
                                            @csrf
                                            @method('PATCH')
                                            <label class="text-sm font-semibold text-gray-700 whitespace-nowrap">
                                                Daudzums:
                                            </label>
                                            <input
                                                type="number"
                                                name="quantity"
                                                value="{{ $item->quantity }}"
                                                min="{{ $item->fish->stock_unit == 'kg' ? '0.1' : '1' }}"
                                                max="{{ $item->fish->stock_quantity }}"
                                                step="{{ $item->fish->stock_unit == 'kg' ? '0.1' : '1' }}"
                                                class="w-24 px-3 py-2 text-center border-2 border-gray-300 rounded-lg font-semibold focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                required>
                                            <button type="submit"
                                                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium text-sm">
                                                ✓ Atjaunot
                                            </button>
                                        </form>

                                        <form action="{{ route('cart.remove', $item->id) }}" method="POST" class="ml-auto">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    onclick="return confirm('Vai tiešām vēlaties izņemt šo zivi no groza?')"
                                                    class="px-4 py-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 border border-red-200 transition-colors font-medium text-sm flex items-center gap-2">
                                                <span>🗑️</span>
                                                <span>Izņemt</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                <!-- Item Total Price -->
                                <div class="flex flex-col items-end justify-between">
                                    <div class="text-right">
                                        <p class="text-sm text-gray-500 mb-1">Summa</p>
                                        <p class="text-2xl font-bold text-green-600">
                                            {{ number_format($item->quantity * $item->fish->price, 2) }} €
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Order Summary (Right Side - 1 column) -->
            <div class="lg:col-span-1">
                <div class="sticky top-24">
                    <div class="bg-white rounded-2xl border-2 border-gray-200 overflow-hidden shadow-lg">
                        <!-- Header -->
                        <div class="px-6 py-4 bg-gradient-to-r from-blue-600 to-blue-700 text-white">
                            <h2 class="text-xl font-bold flex items-center gap-2">
                                <span>📊</span>
                                <span>Pasūtījuma kopsavilkums</span>
                            </h2>
                        </div>

                        <div class="p-6 space-y-4">
                            <div class="flex justify-between items-center pb-4 border-b border-gray-200">
                                <span class="text-gray-600 font-medium">Preču skaits:</span>
                                <span class="font-bold text-gray-900 text-lg">{{ $cartItems->count() }}</span>
                            </div>

                            <div class="p-4 bg-green-50 rounded-xl border-2 border-green-200">
                                <div class="flex justify-between items-baseline mb-1">
                                    <span class="text-gray-700 font-semibold">KOPĀ:</span>
                                    <div class="text-right">
                                        <span class="text-3xl font-extrabold text-green-600">
                                            {{ number_format($total, 2) }}
                                        </span>
                                        <span class="text-xl font-bold text-green-600 ml-1">€</span>
                                    </div>
                                </div>
                                <p class="text-xs text-gray-600 text-right">
                                    (Aptuvenā summa)
                                </p>
                            </div>

                            <a href="{{ route('orders.checkout') }}" 
                               class="block w-full px-6 py-4 bg-gradient-to-r from-green-600 to-green-700 text-white text-center rounded-xl font-bold text-lg hover:from-green-700 hover:to-green-800 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                📋 Veikt pasūtījumu
                            </a>

                            <!-- Info Note -->
                            <div class="p-4 bg-blue-50 rounded-lg border border-blue-200">
                                <p class="text-sm text-gray-700 leading-relaxed">
                                    <span class="font-semibold">ℹ️ Piezīme:</span> 
                                    Pēc pasūtījuma administrators sazināsies ar jums apstiprināšanai.
                                </p>
                            </div>

                            <form action="{{ route('cart.clear') }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        onclick="return confirm('Vai tiešām vēlaties iztīrīt grozu?')"
                                        class="w-full px-4 py-3 bg-gray-100 text-gray-700 rounded-xl font-semibold hover:bg-gray-200 transition-colors text-sm">
                                    🗑️ Iztīrīt grozu
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="mt-6 text-center">
                        <a href="{{ route('fish.shop') }}" 
                           class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 font-semibold transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                            <span>Turpināt iepirkties</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

@endsection