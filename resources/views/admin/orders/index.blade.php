@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 mb-2 flex items-center gap-3">
                <span class="text-4xl">📊</span>
                <span>Pasūtījumu pārvaldība</span>
            </h1>
            <p class="text-gray-600">
                Pārskatiet un apstipriniet klientu pasūtījumus
            </p>
        </div>
        <a href="{{ route('admin.reports.orders') }}" 
           class="inline-flex items-center gap-2 px-6 py-3 bg-gray-100 text-gray-700 rounded-xl font-bold hover:bg-gray-200 transition-colors">
            <span>📈</span>
            <span>Uz pārskatiem</span>
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
            <div class="flex items-center justify-between mb-2">
                <span class="text-gray-600 text-sm font-medium">Gaida</span>
                <span class="text-2xl">⏳</span>
            </div>
            <p class="text-3xl font-bold text-yellow-600">{{ $orders->where('status', 'pending')->count() }}</p>
        </div>
        
        <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
            <div class="flex items-center justify-between mb-2">
                <span class="text-gray-600 text-sm font-medium">Apstiprināti</span>
                <span class="text-2xl">✅</span>
            </div>
            <p class="text-3xl font-bold text-blue-600">{{ $orders->where('status', 'confirmed')->count() }}</p>
        </div>
        
        <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
            <div class="flex items-center justify-between mb-2">
                <span class="text-gray-600 text-sm font-medium">Pabeigti</span>
                <span class="text-2xl">🎉</span>
            </div>
            <p class="text-3xl font-bold text-green-600">{{ $orders->where('status', 'completed')->count() }}</p>
        </div>
        
        <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
            <div class="flex items-center justify-between mb-2">
                <span class="text-gray-600 text-sm font-medium">Atcelti</span>
                <span class="text-2xl">❌</span>
            </div>
            <p class="text-3xl font-bold text-red-600">{{ $orders->where('status', 'cancelled')->count() }}</p>
        </div>
    </div>

    <!-- Filters Card -->
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-8">
        <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
            <span>🔍</span>
            <span>Filtri</span>
        </h3>

        <form action="{{ route('admin.orders.index') }}" method="GET">
            @csrf
            <div class="grid md:grid-cols-4 gap-4">
                <!-- Date From -->
                <div>
                    <label for="start_date" class="block text-sm font-semibold text-gray-700 mb-2">
                        No datuma
                    </label>
                    <input 
                        type="text" 
                        name="start_date" 
                        id="start_date" 
                        value="{{ request('start_date') }}"
                        placeholder="DD/MM/YYYY"
                        class="w-full px-4 py-2 bg-gray-50 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all outline-none">
                </div>

                <!-- Date To -->
                <div>
                    <label for="end_date" class="block text-sm font-semibold text-gray-700 mb-2">
                        Līdz datumam
                    </label>
                    <input 
                        type="text" 
                        name="end_date" 
                        id="end_date" 
                        value="{{ request('end_date') }}"
                        placeholder="DD/MM/YYYY"
                        class="w-full px-4 py-2 bg-gray-50 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all outline-none">
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">
                        Statuss
                    </label>
                    <select 
                        name="status" 
                        id="status"
                        class="w-full px-4 py-2 bg-gray-50 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all outline-none">
                        <option value="">Visi statusi</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Gaida</option>
                        <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Apstiprināti</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Pabeigti</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Atcelti</option>
                    </select>
                </div>

                <!-- Actions -->
                <div class="flex items-end gap-2">
                    <button 
                        type="submit"
                        class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-semibold">
                        🔍 Filtrēt
                    </button>
                    <a href="{{ route('admin.orders.index') }}" 
                       class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors font-semibold">
                        ❌
                    </a>
                </div>
            </div>
        </form>

        <!-- Active Filters Display -->
        @if(request()->hasAny(['start_date', 'end_date', 'status']))
            <div class="mt-4 pt-4 border-t border-gray-200">
                <p class="text-sm font-semibold text-gray-700 mb-2">Aktīvie filtri:</p>
                <div class="flex flex-wrap gap-2">
                    @if(request('start_date'))
                        <span class="inline-flex items-center gap-1 px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-semibold">
                            📅 No: {{ request('start_date') }}
                        </span>
                    @endif
                    @if(request('end_date'))
                        <span class="inline-flex items-center gap-1 px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-semibold">
                            📅 Līdz: {{ request('end_date') }}
                        </span>
                    @endif
                    @if(request('status'))
                        <span class="inline-flex items-center gap-1 px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-semibold">
                            🏷️ Statuss: 
                            @if(request('status') == 'pending') Gaida
                            @elseif(request('status') == 'confirmed') Apstiprināts
                            @elseif(request('status') == 'completed') Pabeigts
                            @elseif(request('status') == 'cancelled') Atcelts
                            @endif
                        </span>
                    @endif
                </div>
            </div>
        @endif
    </div>

    <!-- Orders Table -->
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
        <!-- Table Header -->
        <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-white border-b border-gray-200">
            <h2 class="text-lg font-bold text-gray-900">Visi pasūtījumi</h2>
        </div>

        <!-- Desktop Table -->
        <div class="hidden lg:block overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase">ID</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase">Klients</th>
                        <th class="px-4 py-3 text-center text-xs font-bold text-gray-700 uppercase">Telefons</th>
                        <th class="px-4 py-3 text-center text-xs font-bold text-gray-700 uppercase">Produkti</th>
                        <th class="px-4 py-3 text-right text-xs font-bold text-gray-700 uppercase">Summa</th>
                        <th class="px-4 py-3 text-center text-xs font-bold text-gray-700 uppercase">Statuss</th>
                        <th class="px-4 py-3 text-center text-xs font-bold text-gray-700 uppercase">Datums</th>
                        <th class="px-4 py-3 text-center text-xs font-bold text-gray-700 uppercase">Darbības</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($orders as $order)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-4 py-4 whitespace-nowrap">
                                <span class="font-bold text-gray-900">#{{ $order->id }}</span>
                            </td>
                            <td class="px-4 py-4">
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $order->user->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $order->user->email }}</p>
                                </div>
                            </td>
                            <td class="px-4 py-4 text-center">
                                <span class="text-sm font-medium text-gray-900">{{ $order->phone }}</span>
                            </td>
                            <td class="px-4 py-4 text-center">
                                <span class="text-sm text-gray-600">{{ $order->items->count() }} produkti</span>
                            </td>
                            <td class="px-4 py-4 text-right">
                                <span class="font-bold text-green-600">{{ number_format($order->total_amount, 2) }} €</span>
                            </td>
                            <td class="px-4 py-4 text-center">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold
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
                            </td>
                            <td class="px-4 py-4 text-center whitespace-nowrap">
                                <span class="text-sm text-gray-600">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                            </td>
                            <td class="px-4 py-4 text-center">
                                <a href="{{ route('admin.orders.show', $order->id) }}" 
                                   class="inline-flex items-center gap-1 px-3 py-1.5 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition-colors text-sm font-semibold">
                                    👁️ Skatīt
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-12 text-center">
                                <div class="flex flex-col items-center gap-4">
                                    <span class="text-6xl">📦</span>
                                    <p class="text-gray-500 font-medium">Nav neviena pasūtījuma</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile Cards -->
        <div class="lg:hidden p-4 space-y-4">
            @forelse($orders as $order)
                <div class="bg-gray-50 rounded-xl border border-gray-200 overflow-hidden">
                    <div class="p-4 space-y-3">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="font-bold text-gray-900">Pasūtījums #{{ $order->id }}</p>
                                <p class="text-sm text-gray-600">{{ $order->user->name }}</p>
                            </div>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-bold
                                @if($order->status == 'pending') bg-yellow-100 text-yellow-700
                                @elseif($order->status == 'confirmed') bg-blue-100 text-blue-700
                                @elseif($order->status == 'completed') bg-green-100 text-green-700
                                @else bg-red-100 text-red-700
                                @endif">
                                @if($order->status == 'pending') Gaida
                                @elseif($order->status == 'confirmed') Apstipr.
                                @elseif($order->status == 'completed') Pabeigts
                                @else Atcelts
                                @endif
                            </span>
                        </div>

                        <div class="grid grid-cols-2 gap-3 text-sm">
                            <div>
                                <p class="text-gray-600 text-xs">Telefons</p>
                                <p class="font-semibold text-gray-900">{{ $order->phone }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600 text-xs">Produkti</p>
                                <p class="font-semibold text-gray-900">{{ $order->items->count() }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600 text-xs">Summa</p>
                                <p class="font-bold text-green-600">{{ number_format($order->total_amount, 2) }} €</p>
                            </div>
                            <div>
                                <p class="text-gray-600 text-xs">Datums</p>
                                <p class="text-gray-900 text-xs">{{ $order->created_at->format('d/m/Y') }}</p>
                            </div>
                        </div>

                        <a href="{{ route('admin.orders.show', $order->id) }}" 
                           class="block w-full px-4 py-2 bg-blue-600 text-white text-center rounded-lg hover:bg-blue-700 transition-colors font-semibold text-sm">
                            👁️ Skatīt detaļas
                        </a>
                    </div>
                </div>
            @empty
                <div class="text-center py-12">
                    <span class="text-6xl block mb-4">📦</span>
                    <p class="text-gray-500 font-medium">Nav neviena pasūtījuma</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Pagination -->
    @if($orders->hasPages())
        <div class="mt-6">
            {{ $orders->links() }}
        </div>
    @endif
</div>

<!-- Flatpickr CSS & JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/lv.js"></script>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr("#start_date", {
            dateFormat: "d/m/Y",
            locale: "lv"
        });

        flatpickr("#end_date", {
            dateFormat: "d/m/Y",
            locale: "lv"
        });
    });
</script>
@endpush

@endsection