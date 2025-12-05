@extends('layouts.app')

@section('content')

<div class="max-w-4xl mx-auto">
    <!-- Success Header -->
    <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-24 h-24 bg-green-100 rounded-full mb-6 animate-bounce">
            <span class="text-6xl">✅</span>
        </div>
        
        <h1 class="text-3xl md:text-4xl font-extrabold text-green-600 mb-4">
            Pasūtījums veiksmīgi izveidots!
        </h1>
        
        <p class="text-lg text-gray-600 max-w-2xl mx-auto leading-relaxed">
            Paldies par jūsu pasūtījumu! Mēs esam saņēmuši jūsu pieteikumu un drīzumā sazināsimies ar jums norādītajā telefona numurā.
        </p>
    </div>

    <!-- What's Next Info -->
    <div class="mb-8 p-6 md:p-8 bg-blue-50 border-l-4 border-blue-500 rounded-lg">
        <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
            <span class="text-2xl">📋</span>
            <span>Kas notiks tālāk?</span>
        </h3>
        <ul class="space-y-3">
            <li class="flex items-start gap-3 text-gray-700">
                <span class="text-blue-600 flex-shrink-0 text-xl">1.</span>
                <span>Administrators pārskatīs jūsu pasūtījumu</span>
            </li>
            <li class="flex items-start gap-3 text-gray-700">
                <span class="text-blue-600 flex-shrink-0 text-xl">2.</span>
                <span>Jūs saņemsiet zvanu uz norādīto telefona numuru pasūtījuma apstiprināšanai</span>
            </li>
            <li class="flex items-start gap-3 text-gray-700">
                <span class="text-blue-600 flex-shrink-0 text-xl">3.</span>
                <span>Pēc apstiprinājuma varēsiet saņemt preci veikalā</span>
            </li>
            <li class="flex items-start gap-3 text-gray-700">
                <span class="text-blue-600 flex-shrink-0 text-xl">4.</span>
                <span>Maksājums notiek tikai saņemot preci klātienē</span>
            </li>
        </ul>
    </div>

    <!-- Order Summary Card -->
    <div class="bg-white rounded-2xl border-2 border-gray-200 overflow-hidden shadow-lg mb-8">
        <!-- Header -->
        <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-white border-b border-gray-200">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                    <span>📦</span>
                    <span>Pasūtījums #{{ $order->id }}</span>
                </h2>
                <span class="inline-flex items-center px-4 py-2 bg-yellow-100 text-yellow-800 rounded-full text-sm font-bold border border-yellow-200">
                    ⏳ Gaida apstiprinājumu
                </span>
            </div>
        </div>

        <!-- Order Items -->
        <div class="p-6 space-y-4">
            @foreach($order->items as $item)
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 p-4 bg-gray-50 rounded-xl">
                    <div>
                        <h3 class="font-bold text-gray-900 text-lg mb-1">{{ $item->fish->name }}</h3>
                        <p class="text-sm text-gray-600">
                            Daudzums: {{ $item->quantity }} {{ $item->fish->stock_unit == 'kg' ? 'kg' : 'gab.' }}
                        </p>
                    </div>
                    <p class="text-xl font-bold text-green-600">
                        {{ number_format($item->getTotalPrice(), 2) }} €
                    </p>
                </div>
            @endforeach

            <!-- Total -->
            <div class="pt-4 border-t-2 border-gray-200">
                <div class="flex justify-between items-center">
                    <span class="text-xl font-bold text-gray-900">KOPĀ:</span>
                    <span class="text-3xl font-extrabold text-green-600">
                        {{ number_format($order->total_amount, 2) }} €
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex flex-col sm:flex-row gap-4">
        <a href="{{ route('orders.index') }}" 
           class="flex-1 px-6 py-4 bg-blue-600 text-white text-center rounded-xl font-bold text-lg hover:bg-blue-700 transition-all shadow-lg hover:shadow-xl">
            📋 Skatīt manus pasūtījumus
        </a>
        <a href="{{ route('fish.shop') }}" 
           class="flex-1 px-6 py-4 bg-gray-100 text-gray-700 text-center rounded-xl font-bold text-lg hover:bg-gray-200 transition-colors">
            🛍️ Turpināt iepirkties
        </a>
    </div>

    <!-- Contact Info -->
    <div class="mt-8 p-6 bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-xl text-center">
        <h3 class="text-lg font-bold text-gray-900 mb-3">
            Jautājumi par pasūtījumu?
        </h3>
        <p class="text-gray-700 mb-4">
            Sazinieties ar mums darba laikā
        </p>
        <a href="tel:+37112345678" 
           class="inline-flex items-center gap-2 px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-semibold">
            <span>📞</span>
            <span>+371 12345678</span>
        </a>
        <p class="mt-3 text-sm text-gray-600">
            ⏰ P.-P. 9:00-18:00
        </p>
    </div>
</div>

@endsection