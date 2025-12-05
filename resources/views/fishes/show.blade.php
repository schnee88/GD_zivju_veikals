@extends('layouts.app')

@section('content')

<div class="max-w-4xl mx-auto">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('fish.catalog') }}" 
           class="inline-flex items-center gap-2 px-4 py-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            <span class="font-medium">Atpakaļ uz katalogu</span>
        </a>
    </div>

    <!-- Main Content Card -->
    <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-200">
        <div class="grid md:grid-cols-2 gap-8 p-8">
            <!-- Image Section -->
            <div class="space-y-4">
                <div class="relative aspect-square rounded-2xl overflow-hidden bg-gradient-to-br from-gray-50 to-gray-100 border-2 border-gray-200">
                    @if($fish->image)
                        <img src="{{ asset('storage/fish_images/' . $fish->image) }}" 
                             alt="{{ $fish->name }}"
                             class="w-full h-full object-contain p-8">
                    @else
                        <div class="flex items-center justify-center h-full">
                            <div class="text-center">
                                <span class="text-8xl text-gray-300 block mb-4">📷</span>
                                <p class="text-gray-400 font-medium">Nav attēla</p>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Additional Info Badges -->
                <div class="flex flex-wrap gap-3">
                    @if($fish->is_orderable)
                        <span class="inline-flex items-center gap-2 px-4 py-2 bg-green-50 text-green-700 rounded-full text-sm font-semibold border border-green-200">
                            <span>✅</span>
                            <span>Pieejams pasūtīšanai</span>
                        </span>
                    @else
                        <span class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-600 rounded-full text-sm font-semibold border border-gray-200">
                            <span>ℹ️</span>
                            <span>Tikai katalogā</span>
                        </span>
                    @endif

                    @if($fish->is_orderable && $fish->inStock())
                        <span class="inline-flex items-center gap-2 px-4 py-2 bg-blue-50 text-blue-700 rounded-full text-sm font-semibold border border-blue-200">
                            <span>📦</span>
                            <span>Noliktavā: {{ $fish->stock_quantity }} {{ $fish->stock_unit == 'kg' ? 'kg' : 'gab.' }}</span>
                        </span>
                    @endif
                </div>
            </div>

            <!-- Details Section -->
            <div class="space-y-6">
                <!-- Title -->
                <div>
                    <div class="flex items-center gap-3 mb-3">
                        <span class="text-4xl">🐟</span>
                        <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 leading-tight">
                            {{ $fish->name }}
                        </h1>
                    </div>
                </div>

                <!-- Price Card -->
                <div class="p-6 bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl border-2 border-green-200">
                    <div class="flex items-baseline gap-2 mb-2">
                        <span class="text-5xl font-extrabold text-green-600">
                            {{ number_format($fish->price, 2) }}
                        </span>
                        <span class="text-2xl font-bold text-green-600">€</span>
                    </div>
                    <p class="text-green-700 font-medium">
                        par kilograms (kg)
                    </p>
                </div>

                <!-- Description -->
                @if($fish->description)
                    <div class="p-6 bg-gray-50 rounded-2xl border border-gray-200">
                        <h2 class="text-lg font-bold text-gray-900 mb-3 flex items-center gap-2">
                            <span>📝</span>
                            <span>Apraksts</span>
                        </h2>
                        <p class="text-gray-700 leading-relaxed">
                            {{ $fish->description }}
                        </p>
                    </div>
                @else
                    <div class="p-6 bg-gray-50 rounded-2xl border border-gray-200">
                        <p class="text-gray-500 italic text-center">
                            Nav pieejams apraksts
                        </p>
                    </div>
                @endif

                <!-- Action Buttons -->
                <div class="space-y-3 pt-4">
                    @if($fish->is_orderable)
                        @auth
                            @if($fish->inStock())
                                <a href="{{ route('fish.shop') }}" 
                                   class="block w-full px-6 py-4 bg-blue-600 text-white text-center rounded-xl font-bold text-lg hover:bg-blue-700 transition-colors shadow-lg hover:shadow-xl">
                                    🛒 Pasūtīt veikalā
                                </a>
                            @else
                                <div class="p-4 bg-red-50 border-2 border-red-200 rounded-xl text-center">
                                    <p class="text-red-700 font-semibold">
                                        ❌ Šobrīd nav pieejams
                                    </p>
                                </div>
                            @endif
                        @else
                            <a href="{{ route('login') }}" 
                               class="block w-full px-6 py-4 bg-blue-600 text-white text-center rounded-xl font-bold text-lg hover:bg-blue-700 transition-colors shadow-lg hover:shadow-xl">
                                🔐 Pieteikties pasūtīšanai
                            </a>
                        @endauth
                    @else
                        <!-- Contact for Non-orderable Items -->
                        <div class="p-6 bg-blue-50 border-2 border-blue-200 rounded-xl text-center space-y-3">
                            <p class="text-gray-700 font-medium">
                                Lai iegādātos, sazinieties ar mums
                            </p>
                            <a href="tel:+371XXXXXXXX" 
                               class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-semibold">
                                <span>📞</span>
                                <span>+371 XXXXXXXX</span>
                            </a>
                        </div>
                    @endif

                    <a href="{{ route('fish.catalog') }}" 
                       class="block w-full px-6 py-3 bg-gray-100 text-gray-700 text-center rounded-xl font-semibold hover:bg-gray-200 transition-colors">
                        Atpakaļ uz katalogu
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Information Section -->
    <div class="mt-8 grid md:grid-cols-3 gap-6">
        <!-- Quality Badge -->
        <div class="p-6 bg-white rounded-2xl border border-gray-200 text-center shadow-sm">
            <div class="text-4xl mb-3">⭐</div>
            <h3 class="font-bold text-gray-900 mb-2">Augsta kvalitāte</h3>
            <p class="text-sm text-gray-600">
                Rūpīgi atlasīts produkts
            </p>
        </div>

        <!-- Fresh Badge -->
        <div class="p-6 bg-white rounded-2xl border border-gray-200 text-center shadow-sm">
            <div class="text-4xl mb-3">🐟</div>
            <h3 class="font-bold text-gray-900 mb-2">Svaigs produkts</h3>
            <p class="text-sm text-gray-600">
                Piegāde katru dienu
            </p>
        </div>

        <!-- Support Badge -->
        <div class="p-6 bg-white rounded-2xl border border-gray-200 text-center shadow-sm">
            <div class="text-4xl mb-3">📞</div>
            <h3 class="font-bold text-gray-900 mb-2">Atbalsts</h3>
            <p class="text-sm text-gray-600">
                Vienmēr gatavi palīdzēt
            </p>
        </div>
    </div>
</div>

@endsection