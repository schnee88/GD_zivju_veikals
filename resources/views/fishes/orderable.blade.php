@extends('layouts.app')

@section('content')

<!-- Page Header -->
<div class="text-center mb-8">
    <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-4">
        Zivju veikals
    </h1>
    <p class="text-lg text-gray-600 max-w-2xl mx-auto">
        Pasūti zivis tieši tagad!
    </p>
</div>

@if($fishes->isEmpty())
    <!-- Empty State -->
    <div class="max-w-md mx-auto text-center py-16">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Nav pieejamu produktu</h2>
        <p class="text-gray-600 mb-8">
            Šobrīd nav pieejamu produktu pasūtīšanai
        </p>
        <a href="{{ route('fish.catalog') }}" 
           class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
            <span>📖</span>
            <span>Skatīt katalogu</span>
        </a>
    </div>
@else
    <!-- Products Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($fishes as $fish)
            <div class="group bg-white rounded-2xl border-2 border-blue-100 overflow-hidden shadow-sm hover:shadow-xl hover:border-blue-300 hover:-translate-y-2 transition-all duration-300 flex flex-col">
                <!-- Image Container -->
                <div class="relative h-40 bg-gradient-to-br from-gray-50 to-gray-100 overflow-hidden">
                    @if($fish->image)
                        <img src="{{ asset('storage/fish_images/' . $fish->image) }}"
                             alt="{{ $fish->name }}"
                             class="w-full h-full object-contain p-3 group-hover:scale-110 transition-transform duration-300">
                    @else
                        <div class="flex items-center justify-center h-full">
                            <span class="text-5xl text-gray-300">📷</span>
                        </div>
                    @endif
                </div>

                <!-- Content -->
                <div class="p-5 flex flex-col flex-1 space-y-3">
                    <!-- Title -->
                    <div class="flex items-center gap-2 min-h-[3rem]">
                        <span class="text-xl flex-shrink-0">🐟</span>
                        <h3 class="text-lg font-bold text-gray-900 leading-tight line-clamp-2">
                            {{ $fish->name }}
                        </h3>
                    </div>

                    <!-- Description -->
                    @if($fish->description)
                        <p class="text-gray-600 text-sm leading-relaxed line-clamp-2 flex-1">
                            {{ Str::limit($fish->description, 100) }}
                        </p>
                    @endif

                    <!-- Price -->
                    <div class="p-3 bg-gray-50 rounded-lg border border-gray-200 text-center">
                        <p class="text-2xl font-bold text-green-600 mb-0.5">
                            {{ number_format($fish->price, 2) }} €
                        </p>
                        <p class="text-xs text-gray-500">
                            / {{ $fish->stock_unit == 'kg' ? 'kg' : 'gab.' }}
                        </p>
                    </div>

                    <!-- Stock Status -->
                    <div class="p-2 rounded-lg text-center text-sm font-semibold
                                {{ $fish->inStock() 
                                    ? 'bg-green-50 text-green-700 border border-green-200' 
                                    : 'bg-red-50 text-red-700 border border-red-200' }}">
                        @if($fish->inStock())
                            ✅ Pieejams: {{ $fish->stock_quantity }} {{ $fish->stock_unit == 'kg' ? 'kg' : 'gab.' }}
                        @else
                            ❌ Nav pieejams
                        @endif
                    </div>

                    <!-- Add to Cart / Login -->
                    @auth
                        @if($fish->inStock())
                            <form action="{{ route('cart.add') }}" method="POST" class="space-y-3 mt-auto">
                                @csrf
                                <input type="hidden" name="fish_id" value="{{ $fish->id }}">

                                <!-- Quantity Selector -->
                                <div class="flex items-center justify-between gap-3 p-3 bg-gray-50 rounded-lg border border-gray-200">
                                    <label for="quantity-{{ $fish->id }}" class="text-sm font-semibold text-gray-700 whitespace-nowrap">
                                        Daudzums:
                                    </label>
                                    <input
                                        type="number"
                                        id="quantity-{{ $fish->id }}"
                                        name="quantity"
                                        value="{{ $fish->stock_unit == 'kg' ? '0.5' : '1' }}"
                                        min="{{ $fish->stock_unit == 'kg' ? '0.1' : '1' }}"
                                        max="{{ $fish->stock_quantity }}"
                                        step="{{ $fish->stock_unit == 'kg' ? '0.1' : '1' }}"
                                        class="w-20 px-3 py-2 text-center border border-gray-300 rounded-lg font-semibold focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                        required>
                                </div>

                                <!-- Add to Cart Button -->
                                <button type="submit"
                                        class="w-full px-4 py-3 bg-green-600 text-white rounded-xl font-semibold hover:bg-green-700 transition-colors flex items-center justify-center gap-2">
                                    <span>🛒</span>
                                    <span>Pievienot grozam</span>
                                </button>
                            </form>
                        @else
                            <!-- Out of Stock Message -->
                            <div class="p-3 bg-gray-100 text-gray-500 text-center rounded-lg font-semibold mt-auto">
                                Nav pieejams
                            </div>
                        @endif
                    @else
                        <!-- Login Button -->
                        <a href="{{ route('login') }}"
                           class="block w-full px-4 py-3 bg-blue-600 text-white text-center rounded-xl font-semibold hover:bg-blue-700 transition-colors mt-auto">
                            🔐 Pieteikties pasūtīšanai
                        </a>
                    @endauth
                </div>
            </div>
        @endforeach
    </div>
@endif

<!-- Info Banner -->
@guest
<div class="mt-12 max-w-3xl mx-auto p-6 bg-blue-50 border-l-4 border-blue-500 rounded-lg">
    <div class="flex items-start gap-4">
        <span class="text-3xl flex-shrink-0">ℹ️</span>
        <div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">
                Lai pasūtītu produktus
            </h3>
            <p class="text-gray-700 mb-4">
                Lūdzu, vispirms pieteikties vai izveidojiet jaunu kontu. Tas ļaus jums pievienot produktus grozam un veikt pasūtījumus.
            </p>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('login') }}" 
                   class="inline-flex items-center gap-2 px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                    <span>🔐</span>
                    <span>Pieteikties</span>
                </a>
                <a href="{{ route('register') }}" 
                   class="inline-flex items-center gap-2 px-5 py-2 bg-white border-2 border-blue-600 text-blue-600 rounded-lg hover:bg-blue-50 transition-colors font-medium">
                    <span>📝</span>
                    <span>Reģistrēties</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endguest

@endsection