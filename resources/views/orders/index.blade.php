@extends('layouts.app')

@section('content')

<div class="max-w-6xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-2 flex items-center gap-3">
            <span class="text-4xl">📦</span>
            <span>Mani pasūtījumi</span>
        </h1>
        <p class="text-gray-600">
            Pārskatiet savus pasūtījumus un to statusu
        </p>
    </div>

    @if($orders->isEmpty())
        <!-- Empty State -->
        <div class="max-w-md mx-auto text-center py-16">
            <div class="mb-8">
                <div class="inline-flex items-center justify-center w-24 h-24 bg-gray-100 rounded-full mb-6">
                    <span class="text-6xl">📦</span>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">
                    Nav pasūtījumu
                </h2>
                <p class="text-gray-600 mb-8">
                    Jums vēl nav neviena pasūtījuma
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
        <!-- Orders List -->
        <div class="space-y-6">
            @foreach($orders as $order)
                <div class="bg-white rounded-2xl border-2 border-gray-200 overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300">
                    <!-- Order Header -->
                    <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-white border-b border-gray-200">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                            <div class="flex items-center gap-3">
                                <span class="text-2xl">📦</span>
                                <div>
                                    <h2 class="text-xl font-bold text-gray-900">
                                        Pasūtījums #{{ $order->id }}
                                    </h2>
                                    <p class="text-sm text-gray-600 flex items-center gap-2 mt-1">
                                        <span>🕒</span>
                                        <span>{{ $order->created_at->format('d.m.Y H:i') }}</span>
                                    </p>
                                </div>
                            </div>
                            
                            <!-- Status Badge -->
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold
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

                    <!-- Order Items -->
                    <div class="px-6 py-4 space-y-3">
                        @foreach($order->items as $item)
                            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2 p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center gap-3">
                                    <span class="text-xl">🐟</span>
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ $item->fish->name }}</p>
                                        <p class="text-sm text-gray-600">
                                            {{ $item->quantity }} {{ $item->fish->stock_unit == 'kg' ? 'kg' : 'gab.' }} × {{ number_format($item->price, 2) }} €
                                        </p>
                                    </div>
                                </div>
                                <p class="text-lg font-bold text-green-600 sm:text-right">
                                    {{ number_format($item->quantity * $item->price, 2) }} €
                                </p>
                            </div>
                        @endforeach
                    </div>

                    <!-- Order Footer -->
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                            <div class="flex items-center gap-6">
                                <div>
                                    <p class="text-sm text-gray-600 mb-1">Kopējā summa</p>
                                    <p class="text-2xl font-bold text-green-600">
                                        {{ number_format($order->total_amount, 2) }} €
                                    </p>
                                </div>
                            </div>
                            
                            <div class="flex flex-wrap gap-3">
                                <a href="{{ route('orders.show', $order->id) }}" 
                                   class="px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-semibold text-sm flex items-center gap-2">
                                    <span>👁️</span>
                                    <span>Skatīt detalizēti</span>
                                </a>

                                @if($order->status == 'pending')
                                    <form action="{{ route('orders.cancel', $order->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                                onclick="return confirm('Vai tiešām vēlaties atcelt šo pasūtījumu?')"
                                                class="px-5 py-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 border border-red-200 transition-colors font-semibold text-sm flex items-center gap-2">
                                            <span>❌</span>
                                            <span>Atcelt</span>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

@endsection