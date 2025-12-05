@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto">
    <!-- Page Header -->
    <div class="text-center mb-10">
        <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-4 flex items-center justify-center gap-3">
            <span class="text-4xl">⚗️</span>
            <span>Plānotās ražošanas partijas</span>
        </h1>
        <p class="text-lg text-gray-600 max-w-3xl mx-auto">
            Apskatiet mūsu plānotās produkcijas partijas un to izgatavošanas laikus
        </p>
    </div>

    @if($batches->isEmpty())
        <!-- Empty State -->
        <div class="max-w-md mx-auto text-center py-16">
            <div class="mb-8">
                <div class="inline-flex items-center justify-center w-24 h-24 bg-gray-100 rounded-full mb-6">
                    <span class="text-6xl">📦</span>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">
                    Nav plānotu partiju
                </h2>
                <p class="text-gray-600 mb-8">
                    Šobrīd nav plānotu ražošanas partiju
                </p>
            </div>
            
            <div class="space-y-3">
                <a href="{{ route('fish.shop') }}" 
                   class="block w-full px-6 py-4 bg-blue-600 text-white rounded-xl font-bold text-lg hover:bg-blue-700 transition-all shadow-lg hover:shadow-xl">
                    🛍️ Skatīt pieejamo produkciju
                </a>
                <a href="{{ route('home') }}" 
                   class="block w-full px-6 py-3 bg-gray-100 text-gray-700 rounded-xl font-semibold hover:bg-gray-200 transition-colors">
                    🏠 Uz sākumu
                </a>
            </div>
        </div>
    @else
        <!-- Batches List -->
        <div class="space-y-8">
            @foreach($batches as $batch)
                <div class="bg-white rounded-3xl border-2 overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300"
                     style="border-color: {{ $batch->status_color }};">
                    
                    <!-- Batch Header -->
                    <div class="px-6 md:px-8 py-6 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                            <div>
                                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">
                                    {{ $batch->name }}
                                </h2>
                                <p class="flex items-center gap-2 text-gray-600">
                                    <span class="text-lg">📅</span>
                                    <span class="font-semibold">Izgatavošanas datums:</span>
                                    <span>{{ $batch->batch_date->format('d.m.Y H:i') }}</span>
                                </p>
                            </div>
                            <span class="inline-flex items-center px-5 py-2 rounded-full text-sm font-bold text-white shadow-md"
                                  style="background-color: {{ $batch->status_color }};">
                                {{ $batch->status_text }}
                            </span>
                        </div>

                        @if($batch->description)
                            <div class="mt-4 p-4 bg-blue-50 border-l-4 border-blue-400 rounded-lg">
                                <p class="text-gray-700 leading-relaxed">
                                    {{ $batch->description }}
                                </p>
                            </div>
                        @endif
                    </div>

                    <div class="px-6 md:px-8 py-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                            <span class="text-2xl">🐟</span>
                            <span>Plānotās zivis:</span>
                        </h3>

                        <!-- Desktop Table View -->
                        <div class="hidden md:block overflow-x-auto">
                            <table class="w-full border-collapse">
                                <thead>
                                    <tr class="bg-gradient-to-r from-blue-600 to-blue-700 text-white">
                                        <th class="px-6 py-4 text-left font-bold rounded-tl-xl">Zivs</th>
                                        <th class="px-6 py-4 text-center font-bold">Daudzums</th>
                                        <th class="px-6 py-4 text-center font-bold">Mērvienība</th>
                                        <th class="px-6 py-4 text-center font-bold rounded-tr-xl">Cena</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach($batch->fishes as $fish)
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-6 py-4">
                                                <div class="font-bold text-gray-900 mb-1">{{ $fish->name }}</div>
                                                @if($fish->description)
                                                    <div class="text-sm text-gray-600">{{ Str::limit($fish->description, 100) }}</div>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                <span class="text-lg font-bold text-blue-600">{{ $fish->pivot->quantity }}</span>
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                <span class="text-gray-700 font-medium">{{ $fish->pivot->unit == 'kg' ? 'kg' : 'gab.' }}</span>
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                <span class="text-lg font-bold text-green-600">{{ number_format($fish->price, 2) }} €</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Mobile Card View -->
                        <div class="md:hidden space-y-4">
                            @foreach($batch->fishes as $fish)
                                <div class="p-5 bg-gray-50 rounded-xl border border-gray-200">
                                    <h4 class="font-bold text-gray-900 mb-3 text-lg">{{ $fish->name }}</h4>
                                    
                                    @if($fish->description)
                                        <p class="text-sm text-gray-600 mb-4 leading-relaxed">{{ Str::limit($fish->description, 80) }}</p>
                                    @endif

                                    <div class="grid grid-cols-2 gap-3">
                                        <div class="p-3 bg-white rounded-lg border border-gray-200">
                                            <p class="text-xs text-gray-600 mb-1">Daudzums</p>
                                            <p class="text-lg font-bold text-blue-600">{{ $fish->pivot->quantity }}</p>
                                        </div>
                                        <div class="p-3 bg-white rounded-lg border border-gray-200">
                                            <p class="text-xs text-gray-600 mb-1">Mērvienība</p>
                                            <p class="text-lg font-bold text-gray-900">{{ $fish->pivot->unit == 'kg' ? 'kg' : 'gab.' }}</p>
                                        </div>
                                        <div class="col-span-2 p-3 bg-green-50 rounded-lg border border-green-200">
                                            <p class="text-xs text-gray-600 mb-1">Paredzamā cena</p>
                                            <p class="text-2xl font-bold text-green-600">{{ number_format($fish->price, 2) }} €</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Info Notice -->
                        <div class="mt-6 p-4 bg-blue-50 border-l-4 border-blue-500 rounded-lg">
                            <p class="text-sm text-gray-700 flex items-start gap-3">
                                <span class="text-xl flex-shrink-0">ℹ️</span>
                                <span>
                                    <strong>Informācija:</strong> Šī ir plānotā ražošanas partija. Lai iegādātos produktus, apmeklējiet mūsu veikalu pēc to sagatavošanas.
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- CTA Section -->
        <div class="mt-12 p-8 md:p-12 bg-gradient-to-br from-blue-600 to-blue-700 text-white rounded-3xl shadow-2xl text-center">
            <h3 class="text-2xl md:text-3xl font-bold mb-4 flex items-center justify-center gap-3">
                <span class="text-3xl">🐟</span>
                <span>Apskatiet mūsu sortimentu</span>
            </h3>
            <p class="text-lg text-blue-100 mb-4">
                Plānotās partijas sniedz priekšstatu par mūsu ražošanu
            </p>
            <p class="text-blue-100 mb-8">
                Produktus var iegādāties mūsu veikalā pēc to sagatavošanas
            </p>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center max-w-2xl mx-auto">
                <a href="{{ route('fish.shop') }}" 
                   class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-white text-blue-700 rounded-xl font-bold text-lg hover:bg-blue-50 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    <span class="text-xl">🛒</span>
                    <span>Apmeklēt veikalu</span>
                </a>
                <a href="{{ route('fish.catalog') }}" 
                   class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-white/15 backdrop-blur-md text-white rounded-xl font-bold text-lg border-2 border-white/30 hover:bg-white/25 hover:border-white/50 transition-all">
                    <span class="text-xl">📖</span>
                    <span>Skatīt katalogu</span>
                </a>
            </div>

            <p class="mt-8 text-blue-100 text-base">
                ⏰ Darba laiks: Pirmdiena-Piektdiena 9:00-18:00
            </p>
        </div>
    @endif
</div>

@endsection