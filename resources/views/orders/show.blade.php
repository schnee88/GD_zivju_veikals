@extends('layouts.app')

@section('content')

<div class="max-w-5xl mx-auto">
    <!-- Back Button & Header -->
    <div class="mb-6">
        <a href="{{ route('orders.index') }}" 
           class="inline-flex items-center gap-2 px-4 py-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors mb-4">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            <span class="font-medium">Atpakaļ uz pasūtījumiem</span>
        </a>

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 flex items-center gap-3">
                <span class="text-4xl">📦</span>
                <span>Pasūtījums #{{ $order->id }}</span>
            </h1>

            <!-- Status Badge -->
            <span class="inline-flex items-center px-5 py-2 rounded-full text-sm font-bold
                @if($order->status == 'pending') bg-yellow-100 text-yellow-800 border border-yellow-200
                @elseif($order->status == 'confirmed') bg-blue-100 text-blue-800 border border-blue-200
                @elseif($order->status == 'completed') bg-green-100 text-green-800 border border-green-200
                @elseif($order->status == 'cancelled') bg-red-100 text-red-800 border border-red-200
                @endif">
                @if($order->status == 'pending')
                    ⏳ Gaida apstiprinājumu
                @elseif($order->status == 'confirmed')
                    ✅ Apstiprināts
                @elseif($order->status == 'completed')
                    🎉 Pabeigts
                @elseif($order->status == 'cancelled')
                    ❌ Atcelts
                @endif
            </span>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-6">
        <!-- Left Column - Main Info -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Order Info Card -->
            <div class="bg-white rounded-2xl border-2 border-gray-200 overflow-hidden shadow-sm">
                <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-white border-b border-gray-200">
                    <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                        <span>📋</span>
                        <span>Pasūtījuma informācija</span>
                    </h2>
                </div>

                <div class="p-6 grid sm:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Pasūtījuma numurs</p>
                        <p class="text-lg font-bold text-gray-900">#{{ $order->id }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Telefons</p>
                        <p class="text-lg font-bold text-gray-900">{{ $order->phone }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Izveidots</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $order->created_at->format('d.m.Y H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Atjaunināts</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $order->updated_at->format('d.m.Y H:i') }}</p>
                    </div>
                </div>
            </div>

            <!-- Order Items Card -->
            <div class="bg-white rounded-2xl border-2 border-gray-200 overflow-hidden shadow-sm">
                <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-white border-b border-gray-200">
                    <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                        <span>🐟</span>
                        <span>Pasūtītās preces</span>
                    </h2>
                </div>

                <!-- Desktop Table -->
                <div class="hidden md:block overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-bold text-gray-700">Zivs</th>
                                <th class="px-6 py-3 text-center text-sm font-bold text-gray-700">Daudzums</th>
                                <th class="px-6 py-3 text-right text-sm font-bold text-gray-700">Cena</th>
                                <th class="px-6 py-3 text-right text-sm font-bold text-gray-700">Summa</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($order->items as $item)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <p class="font-bold text-gray-900">{{ $item->fish->name }}</p>
                                        <p class="text-sm text-gray-600">{{ $item->fish->stock_unit == 'kg' ? 'kg' : 'gab.' }}</p>
                                    </td>
                                    <td class="px-6 py-4 text-center font-semibold text-gray-900">
                                        {{ $item->quantity }} {{ $item->fish->stock_unit == 'kg' ? 'kg' : 'gab.' }}
                                    </td>
                                    <td class="px-6 py-4 text-right text-gray-900">
                                        {{ number_format($item->price, 2) }} €
                                    </td>
                                    <td class="px-6 py-4 text-right font-bold text-green-600">
                                        {{ number_format($item->quantity * $item->price, 2) }} €
                                    </td>
                                </tr>
                            @endforeach
                            <tr class="bg-gray-50">
                                <td colspan="3" class="px-6 py-4 text-right font-bold text-gray-900">KOPĀ:</td>
                                <td class="px-6 py-4 text-right text-2xl font-bold text-green-600">
                                    {{ number_format($order->total_amount, 2) }} €
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Cards -->
                <div class="md:hidden p-4 space-y-4">
                    @foreach($order->items as $item)
                        <div class="p-4 bg-gray-50 rounded-xl border border-gray-200">
                            <div class="flex items-center gap-2 mb-3">
                                <span class="text-2xl">🐟</span>
                                <h3 class="font-bold text-gray-900">{{ $item->fish->name }}</h3>
                            </div>
                            <div class="grid grid-cols-2 gap-3 text-sm">
                                <div>
                                    <p class="text-gray-600">Daudzums</p>
                                    <p class="font-semibold text-gray-900">{{ $item->quantity }} {{ $item->fish->stock_unit == 'kg' ? 'kg' : 'gab.' }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-600">Cena</p>
                                    <p class="font-semibold text-gray-900">{{ number_format($item->price, 2) }} €</p>
                                </div>
                                <div class="col-span-2">
                                    <p class="text-gray-600">Summa</p>
                                    <p class="text-xl font-bold text-green-600">{{ number_format($item->quantity * $item->price, 2) }} €</p>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <div class="pt-4 border-t-2 border-gray-300">
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-bold text-gray-900">KOPĀ:</span>
                            <span class="text-2xl font-bold text-green-600">{{ number_format($order->total_amount, 2) }} €</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Customer Notes -->
            @if($order->notes)
                <div class="p-6 bg-yellow-50 border-l-4 border-yellow-400 rounded-lg">
                    <h3 class="font-bold text-gray-900 mb-2 flex items-center gap-2">
                        <span>📝</span>
                        <span>Jūsu piezīmes:</span>
                    </h3>
                    <p class="text-gray-700 leading-relaxed">{{ $order->notes }}</p>
                </div>
            @endif

            <!-- Admin Notes -->
            @if($order->admin_notes && Auth::user()->is_admin)
                <div class="p-6 bg-blue-50 border-l-4 border-blue-400 rounded-lg">
                    <h3 class="font-bold text-gray-900 mb-2 flex items-center gap-2">
                        <span>🔧</span>
                        <span>Admin piezīmes:</span>
                    </h3>
                    <p class="text-gray-700 leading-relaxed">{{ $order->admin_notes }}</p>
                </div>
            @endif
        </div>

        <!-- Right Column - Actions & Summary -->
        <div class="lg:col-span-1">
            <div class="sticky top-24 space-y-6">
                <!-- Summary Card -->
                <div class="bg-white rounded-2xl border-2 border-gray-200 overflow-hidden shadow-lg">
                    <div class="px-6 py-4 bg-gradient-to-r from-blue-600 to-blue-700 text-white">
                        <h2 class="text-lg font-bold flex items-center gap-2">
                            <span>💰</span>
                            <span>Kopsavilkums</span>
                        </h2>
                    </div>

                    <div class="p-6 space-y-4">
                        <div class="flex justify-between items-center pb-4 border-b border-gray-200">
                            <span class="text-gray-600 font-medium">Produktu veidi:</span>
                            <span class="font-bold text-gray-900">{{ $order->items->count() }}</span>
                        </div>

                        <div class="p-4 bg-green-50 rounded-xl border-2 border-green-200">
                            <div class="flex justify-between items-baseline">
                                <span class="text-gray-700 font-semibold">KOPĀ:</span>
                                <span class="text-2xl font-extrabold text-green-600">
                                    {{ number_format($order->total_amount, 2) }} €
                                </span>
                            </div>
                        </div>

                        <!-- Actions -->
                        @if($order->status == 'pending' && $order->user_id == Auth::id())
                            <form action="{{ route('orders.cancel', $order->id) }}" method="POST" 
                                  onsubmit="return confirm('Vai tiešām vēlaties atcelt šo pasūtījumu?')">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                        class="w-full px-6 py-3 bg-red-600 text-white rounded-xl font-bold hover:bg-red-700 transition-colors flex items-center justify-center gap-2">
                                    <span>❌</span>
                                    <span>Atcelt pasūtījumu</span>
                                </button>
                            </form>
                        @endif

                        <a href="{{ route('orders.index') }}" 
                           class="block w-full px-6 py-3 bg-gray-100 text-gray-700 text-center rounded-xl font-semibold hover:bg-gray-200 transition-colors">
                            ← Visi pasūtījumi
                        </a>
                    </div>
                </div>

                <!-- Status Info -->
                <div class="p-6 bg-blue-50 rounded-xl border border-blue-200">
                    <h3 class="font-bold text-gray-900 mb-3">ℹ️ Informācija</h3>
                    <div class="space-y-2 text-sm text-gray-700">
                        @if($order->status == 'pending')
                            <p>Jūsu pasūtījums gaida administratora apstiprinājumu.</p>
                            <p>Jūs saņemsiet zvanu tuvākajā laikā.</p>
                        @elseif($order->status == 'confirmed')
                            <p>Pasūtījums ir apstiprināts!</p>
                            <p>Varat saņemt preci veikalā darba laikā.</p>
                        @elseif($order->status == 'completed')
                            <p>Paldies par pirkumu!</p>
                            <p>Pasūtījums ir pabeigts.</p>
                        @elseif($order->status == 'cancelled')
                            <p>Šis pasūtījums ir atcelts.</p>
                        @endif
                    </div>
                </div>

                <!-- Contact Card -->
                <div class="p-6 bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl border border-green-200">
                    <h3 class="font-bold text-gray-900 mb-3">📞 Kontakti</h3>
                    <p class="text-sm text-gray-700 mb-3">
                        Jautājumi par pasūtījumu?
                    </p>
                    <a href="tel:+37112345678" 
                       class="block w-full px-4 py-3 bg-green-600 text-white text-center rounded-lg hover:bg-green-700 transition-colors font-semibold">
                        Zvanīt: +371 12345678
                    </a>
                    <p class="text-xs text-gray-600 text-center mt-2">
                        P.-P. 9:00-18:00
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection