@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-2 flex items-center gap-3">
            <span class="text-4xl">⚙️</span>
            <span>Admin Panelis</span>
        </h1>
        <p class="text-gray-600">
            Laipni lūdzam administratora panelī! Pārvaldiet savu veikalu un pasūtījumus.
        </p>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Pending Orders -->
        <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 border-2 border-yellow-200 rounded-2xl p-6 shadow-sm hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-3">
                <span class="text-yellow-600 text-4xl">⏳</span>
                <span class="px-3 py-1 bg-yellow-200 text-yellow-800 rounded-full text-xs font-bold">Gaida</span>
            </div>
            <h3 class="text-3xl font-extrabold text-gray-900 mb-1">
                {{ \App\Models\Order::where('status', 'pending')->count() }}
            </h3>
            <p class="text-sm text-gray-700 font-medium">Gaida apstiprinājumu</p>
        </div>

        <div class="bg-gradient-to-br from-blue-50 to-blue-100 border-2 border-blue-200 rounded-2xl p-6 shadow-sm hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-3">
                <span class="text-blue-600 text-4xl">✅</span>
                <span class="px-3 py-1 bg-blue-200 text-blue-800 rounded-full text-xs font-bold">Aktīvi</span>
            </div>
            <h3 class="text-3xl font-extrabold text-gray-900 mb-1">
                {{ \App\Models\Order::where('status', 'confirmed')->count() }}
            </h3>
            <p class="text-sm text-gray-700 font-medium">Apstiprināti pasūtījumi</p>
        </div>

        <!-- Total Fish -->
        <div class="bg-gradient-to-br from-green-50 to-green-100 border-2 border-green-200 rounded-2xl p-6 shadow-sm hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-3">
                <span class="text-green-600 text-4xl">🐟</span>
                <span class="px-3 py-1 bg-green-200 text-green-800 rounded-full text-xs font-bold">Produkti</span>
            </div>
            <h3 class="text-3xl font-extrabold text-gray-900 mb-1">
                {{ \App\Models\Fish::count() }}
            </h3>
            <p class="text-sm text-gray-700 font-medium">Kopā zivis katalogā</p>
        </div>

        <!-- Active Batches -->
        <div class="bg-gradient-to-br from-purple-50 to-purple-100 border-2 border-purple-200 rounded-2xl p-6 shadow-sm hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-3">
                <span class="text-purple-600 text-4xl">📦</span>
                <span class="px-3 py-1 bg-purple-200 text-purple-800 rounded-full text-xs font-bold">Partijas</span>
            </div>
            <h3 class="text-3xl font-extrabold text-gray-900 mb-1">
                {{ \App\Models\Batch::whereIn('status', ['preparing', 'available'])->count() }}
            </h3>
            <p class="text-sm text-gray-700 font-medium">Aktīvas partijas</p>
        </div>
    </div>

    <!-- Main Actions Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Fish Management -->
        <a href="{{ route('admin.fish.index') }}" 
           class="group bg-white rounded-2xl border-2 border-gray-200 p-8 hover:border-blue-400 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="text-6xl mb-4 group-hover:scale-110 transition-transform duration-300">🐟</div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Zivis</h3>
            <p class="text-gray-600 text-sm">Pārvaldīt zivju katalogu un cenas</p>
        </a>

        <!-- Batch Management -->
        <a href="{{ route('admin.batches.index') }}" 
           class="group bg-white rounded-2xl border-2 border-gray-200 p-8 hover:border-purple-400 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="text-6xl mb-4 group-hover:scale-110 transition-transform duration-300">📦</div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Partijas</h3>
            <p class="text-gray-600 text-sm">Ieplānot produkcijas izstrādi</p>
        </a>

        <!-- Orders Management -->
        <a href="{{ route('admin.orders.index') }}" 
           class="group bg-white rounded-2xl border-2 border-gray-200 p-8 hover:border-yellow-400 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="text-6xl mb-4 group-hover:scale-110 transition-transform duration-300">📋</div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Pasūtījumi</h3>
            <p class="text-gray-600 text-sm">Skatīt un apstiprināt pasūtījumus</p>
            @if(\App\Models\Order::where('status', 'pending')->count() > 0)
                <span class="inline-flex items-center gap-1 mt-3 px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-bold">
                    <span>⚠️</span>
                    <span>{{ \App\Models\Order::where('status', 'pending')->count() }} gaida!</span>
                </span>
            @endif
        </a>

        <!-- Reports -->
        <a href="{{ route('admin.reports.orders') }}" 
           class="group bg-white rounded-2xl border-2 border-gray-200 p-8 hover:border-green-400 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="text-6xl mb-4 group-hover:scale-110 transition-transform duration-300">📊</div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Pārskati</h3>
            <p class="text-gray-600 text-sm">Pasūtījumu statistika un analīze</p>
        </a>
    </div>

    <!-- Recent Orders Section -->
    @php
        $recentOrders = \App\Models\Order::with('user', 'items')->latest()->take(5)->get();
    @endphp

    @if($recentOrders->isNotEmpty())
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-white border-b border-gray-200 flex items-center justify-between">
            <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                <span>🕒</span>
                <span>Jaunākie pasūtījumi</span>
            </h2>
            <a href="{{ route('admin.orders.index') }}" 
               class="text-blue-600 hover:text-blue-700 font-semibold text-sm">
                Skatīt visus →
            </a>
        </div>

        <div class="divide-y divide-gray-200">
            @foreach($recentOrders as $order)
                <a href="{{ route('admin.orders.show', $order->id) }}" 
                   class="flex items-center justify-between p-4 hover:bg-gray-50 transition-colors">
                    <div class="flex items-center gap-4">
                        <span class="text-2xl">📦</span>
                        <div>
                            <p class="font-semibold text-gray-900">
                                Pasūtījums #{{ $order->id }}
                            </p>
                            <p class="text-sm text-gray-600">
                                {{ $order->user->name }} · {{ $order->items->count() }} produkti
                            </p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-bold text-green-600">{{ number_format($order->total_amount, 2) }} €</p>
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-bold
                            @if($order->status == 'pending') bg-yellow-100 text-yellow-700
                            @elseif($order->status == 'confirmed') bg-blue-100 text-blue-700
                            @elseif($order->status == 'completed') bg-green-100 text-green-700
                            @else bg-red-100 text-red-700
                            @endif">
                            @if($order->status == 'pending') Gaida
                            @elseif($order->status == 'confirmed') Apstiprināts
                            @elseif($order->status == 'completed') Pabeigts
                            @else Atcelts
                            @endif
                        </span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Quick Tips -->
    <div class="mt-8 p-6 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl border border-blue-200">
        <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
            <span>💡</span>
            <span>Ātri padomi</span>
        </h3>
        <div class="grid md:grid-cols-2 gap-4 text-sm text-gray-700">
            <div class="flex items-start gap-3">
                <span class="text-blue-600 flex-shrink-0">✓</span>
                <span>Pārbaudiet jaunos pasūtījumus katru dienu</span>
            </div>
            <div class="flex items-start gap-3">
                <span class="text-blue-600 flex-shrink-0">✓</span>
                <span>Atjauniniet noliktavas daudzumus regulāri</span>
            </div>
            <div class="flex items-start gap-3">
                <span class="text-blue-600 flex-shrink-0">✓</span>
                <span>Zvaniet klientiem apstiprināšanai 24h laikā</span>
            </div>
            <div class="flex items-start gap-3">
                <span class="text-blue-600 flex-shrink-0">✓</span>
                <span>Izveidojiet jaunas partijas iepriekš</span>
            </div>
        </div>
    </div>
</div>

@endsection