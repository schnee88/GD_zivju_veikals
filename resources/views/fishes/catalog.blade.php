@extends('layouts.app')

@section('content')

<!-- Page Header -->
<div class="text-center mb-8">
    <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-4">
        Produktu katalogs
    </h1>
    <p class="text-lg text-gray-600 max-w-2xl mx-auto">
        Šeit var apskatīt mūsu sortimentu. Lai iegādātos, lūdzu, apmeklējiet mūsu veikalu vai zvaniet.
    </p>
</div>

@if($fishes->isEmpty())
    <!-- Empty State -->
    <div class="max-w-md mx-auto text-center py-16">
        <div class="text-6xl mb-6">🐠</div>
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Nav produktu</h2>
        <p class="text-gray-600 mb-8">
            Šobrīd katalogā nav neviena produkta
        </p>
        <a href="{{ route('home') }}" 
           class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
            <span>🏠</span>
            <span>Atpakaļ uz sākumu</span>
        </a>
    </div>
@else
    <!-- Products Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
        @foreach($fishes as $fish)
            <div class="group bg-white rounded-2xl border-2 border-blue-100 overflow-hidden shadow-sm hover:shadow-xl hover:border-blue-300 hover:-translate-y-2 transition-all duration-300">
                <!-- Image Container -->
                <div class="relative h-48 bg-gradient-to-br from-gray-50 to-gray-100 overflow-hidden">
                    @if($fish->image)
                        <img src="{{ asset('storage/fish_images/' . $fish->image) }}"
                             alt="{{ $fish->name }}"
                             class="w-full h-full object-contain p-4 group-hover:scale-110 transition-transform duration-300">
                    @else
                        <div class="flex items-center justify-center h-full">
                            <span class="text-6xl text-gray-300">📷</span>
                        </div>
                    @endif
                </div>

                <!-- Content -->
                <div class="p-6 space-y-4">
                    <div class="flex items-start gap-2">
                        <h3 class="text-xl font-bold text-gray-900 leading-tight">
                            {{ $fish->name }}
                        </h3>
                    </div>

                    @if($fish->description)
                        <p class="text-gray-600 text-sm leading-relaxed line-clamp-3">
                            {{ Str::limit($fish->description, 120) }}
                        </p>
                    @endif

                    <div class="p-4 bg-gray-50 rounded-xl border border-gray-200 text-center">
                        <p class="text-3xl font-bold text-green-600 mb-1">
                            {{ number_format($fish->price, 2) }} €
                        </p>
                        <p class="text-sm text-gray-500">
                            par kg
                        </p>
                    </div>

                    <a href="{{ route('fish.show', $fish->id) }}" 
                       class="block w-full px-4 py-3 bg-blue-600 text-white text-center rounded-xl font-semibold hover:bg-blue-700 transition-colors">
                        Skatīt vairāk
                    </a>
                </div>
            </div>
        @endforeach
    </div>
@endif

<!-- Contact CTA Box -->
<div class="max-w-3xl mx-auto mt-16 p-8 md:p-12 bg-gradient-to-br from-blue-600 to-blue-700 text-white rounded-3xl shadow-2xl text-center">
    <h3 class="text-2xl md:text-3xl font-bold mb-4">
        🛒 Kā iegādāties?
    </h3>
    <p class="text-lg text-blue-100 mb-6">
        Apmeklējiet mūsu veikalu vai zvaniet!
    </p>
    <a href="tel:+371XXXXXXXX" 
       class="inline-flex items-center gap-3 px-8 py-4 bg-white/20 backdrop-blur-md text-white rounded-full text-xl md:text-2xl font-bold border-2 border-white/30 hover:bg-white/30 hover:scale-105 transition-all duration-300 mb-6">
        <span class="text-2xl">📞</span>
        <span>+371 XXXXXXXX</span>
    </a>
    <p class="text-blue-100 text-base">
        ⏰ Darba laiks: Pirmdiena - Piektdiena, 9:00 - 18:00
    </p>
</div>

@endsection