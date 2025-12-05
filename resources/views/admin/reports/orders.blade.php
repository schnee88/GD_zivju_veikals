@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-6 max-w-7xl">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">📊 Plašais pasūtījumu pārskats</h1>
            <div class="flex gap-2 w-full sm:w-auto">
                <a href="{{ route('admin.orders.index') }}" 
                   class="flex-1 sm:flex-none px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition text-center">
                    ← Uz pasūtījumiem
                </a>
                <button onclick="window.print()" 
                        class="flex-1 sm:flex-none px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    🖨️ Drukāt
                </button>
            </div>
        </div>

        <!-- Filters Card -->
        <div class="bg-white rounded-lg shadow-md p-4 sm:p-6 mb-6">
            <h3 class="text-lg sm:text-xl font-semibold mb-4 text-gray-700">🔍 Filtri un meklēšana</h3>
            <form method="GET" action="{{ route('admin.reports.orders') }}" id="filterForm">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-4">
                    <div>
                        <label for="date_from" class="block text-sm font-medium text-gray-700 mb-1">📅 Datums no:</label>
                        <input type="text" id="date_from" name="date_from" value="{{ request('date_from') }}"
                            placeholder="DD/MM/YYYY" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    <div>
                        <label for="date_to" class="block text-sm font-medium text-gray-700 mb-1">📅 Datums līdz:</label>
                        <input type="text" id="date_to" name="date_to" value="{{ request('date_to') }}"
                            placeholder="DD/MM/YYYY" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">📊 Statuss:</label>
                        <select id="status" name="status" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Visi</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Gaida</option>
                            <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Apstiprināts</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Pabeigts</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Atcelts</option>
                        </select>
                    </div>

                    <div>
                        <label for="order_id" class="block text-sm font-medium text-gray-700 mb-1">🔢 Pasūtījuma #:</label>
                        <input type="number" id="order_id" name="order_id" value="{{ request('order_id') }}"
                            placeholder="Piemēram: 15" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    <div>
                        <label for="customer_name" class="block text-sm font-medium text-gray-700 mb-1">👤 Klienta vārds:</label>
                        <input type="text" id="customer_name" name="customer_name" value="{{ request('customer_name') }}"
                            placeholder="Meklēt pēc vārda..." 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">📞 Telefons:</label>
                        <input type="text" id="phone" name="phone" value="{{ request('phone') }}" 
                            placeholder="+371..." 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    <div>
                        <label for="fish_id" class="block text-sm font-medium text-gray-700 mb-1">🐟 Zivs:</label>
                        <select id="fish_id" name="fish_id" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="all" {{ request('fish_id') == 'all' ? 'selected' : '' }}>Visas</option>
                            @foreach($allFishes as $fish)
                                <option value="{{ $fish->id }}" {{ request('fish_id') == $fish->id ? 'selected' : '' }}>
                                    {{ $fish->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="sort_by" class="block text-sm font-medium text-gray-700 mb-1">📋 Kārtot pēc:</label>
                        <select id="sort_by" name="sort_by" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="id" {{ request('sort_by') == 'id' ? 'selected' : '' }}>Pasūtījuma ID</option>
                            <option value="date" {{ request('sort_by') == 'date' ? 'selected' : '' }}>Datuma</option>
                            <option value="amount" {{ request('sort_by') == 'amount' ? 'selected' : '' }}>Summas</option>
                        </select>
                    </div>

                    <div>
                        <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-1">↕️ Secība:</label>
                        <select id="sort_order" name="sort_order" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>Dilstošā</option>
                            <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>Augošā</option>
                        </select>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-2">
                    <button type="submit" 
                            class="flex-1 sm:flex-none px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                        🔍 Filtrēt
                    </button>
                    <a href="{{ route('admin.reports.orders') }}" 
                       class="flex-1 sm:flex-none px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition text-center">
                        ❌ Notīrīt filtrus
                    </a>
                    <button type="button" onclick="exportToCSV()" 
                            class="flex-1 sm:flex-none px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        📥 Eksportēt CSV
                    </button>
                </div>
            </form>
        </div>

        <!-- Active Filters Display -->
        @if(request()->hasAny(['date_from', 'date_to', 'status', 'order_id', 'customer_name', 'phone', 'fish_id']))
            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6 rounded">
                <strong class="text-blue-800">Aktīvie filtri:</strong>
                <div class="flex flex-wrap gap-2 mt-2">
                    @if(request('date_from'))
                        <span class="inline-block bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">
                            No: {{ request('date_from') }}
                        </span>
                    @endif
                    @if(request('date_to'))
                        <span class="inline-block bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">
                            Līdz: {{ request('date_to') }}
                        </span>
                    @endif
                    @if(request('status') && request('status') != 'all')
                        <span class="inline-block bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">
                            Statuss:
                            @if(request('status') == 'pending') Gaida
                            @elseif(request('status') == 'confirmed') Apstiprināts
                            @elseif(request('status') == 'completed') Pabeigts
                            @elseif(request('status') == 'cancelled') Atcelts
                            @endif
                        </span>
                    @endif
                    @if(request('order_id'))
                        <span class="inline-block bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">
                            Pasūtījums: #{{ request('order_id') }}
                        </span>
                    @endif
                    @if(request('customer_name'))
                        <span class="inline-block bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">
                            Klients: {{ request('customer_name') }}
                        </span>
                    @endif
                    @if(request('phone'))
                        <span class="inline-block bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">
                            Telefons: {{ request('phone') }}
                        </span>
                    @endif
                    @if(request('fish_id') && request('fish_id') != 'all')
                        @php
                            $selectedFish = $allFishes->firstWhere('id', request('fish_id'));
                        @endphp
                        @if($selectedFish)
                            <span class="inline-block bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">
                                Zivs: {{ $selectedFish->name }}
                            </span>
                        @endif
                    @endif
                </div>
            </div>
        @endif

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="text-3xl font-bold text-gray-800">{{ $orderItems->count() }}</div>
                <div class="text-sm text-gray-600 mt-1">Kopā pozīcijas</div>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="text-3xl font-bold text-gray-800">{{ $orderItems->pluck('order_id')->unique()->count() }}</div>
                <div class="text-sm text-gray-600 mt-1">Unikāli pasūtījumi</div>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="text-3xl font-bold text-green-600">{{ number_format($totalAmount, 2) }} €</div>
                <div class="text-sm text-gray-600 mt-1">Kopējā summa</div>
            </div>
        </div>

        <!-- Orders Table -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Pasūt. #</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Datums</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider hidden md:table-cell">Klients</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider hidden lg:table-cell">Telefons</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Zivs</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider">Daudzums</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-700 uppercase tracking-wider hidden sm:table-cell">Cena</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-700 uppercase tracking-wider">Summa</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider">Statuss</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($orderItems as $item)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <strong class="text-gray-900">#{{ $item->order_id }}</strong>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">
                                    {{ $item->order->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-700 hidden md:table-cell">
                                    {{ $item->order->user->name }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700 hidden lg:table-cell">
                                    {{ $item->order->phone }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    <strong class="text-gray-900">{{ $item->fish->name }}</strong>
                                    @if($item->batch_id)
                                        <br><small class="text-gray-500">{{ $item->batch->name ?? 'Batch #' . $item->batch_id }}</small>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-center whitespace-nowrap text-sm text-gray-700">
                                    {{ $item->quantity }}
                                    @if($item->batch_id)
                                        {{ $item->batch->fishes()->where('fish_id', $item->fish_id)->first()->pivot->unit ?? 'kg' }}
                                    @else
                                        {{ $item->fish->stock_unit == 'kg' ? 'kg' : 'gab.' }}
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-right whitespace-nowrap text-sm text-gray-700 hidden sm:table-cell">
                                    {{ number_format($item->price, 2) }} €
                                </td>
                                <td class="px-4 py-3 text-right whitespace-nowrap text-sm">
                                    <strong class="text-gray-900">{{ number_format($item->quantity * $item->price, 2) }} €</strong>
                                </td>
                                <td class="px-4 py-3 text-center whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                        {{ $item->order->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        {{ $item->order->status == 'confirmed' ? 'bg-blue-100 text-blue-800' : '' }}
                                        {{ $item->order->status == 'completed' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $item->order->status == 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                                        @if($item->order->status == 'pending') Gaida
                                        @elseif($item->order->status == 'confirmed') Apstipr.
                                        @elseif($item->order->status == 'completed') Pabeigts
                                        @elseif($item->order->status == 'cancelled') Atcelts
                                        @endif
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-4 py-8 text-center text-gray-500">
                                    Nav neviena ieraksta
                                </td>
                            </tr>
                        @endforelse

                        @if($orderItems->isNotEmpty())
                            <tr class="bg-gray-100 font-bold">
                                <td colspan="7" class="px-4 py-3 text-right text-gray-900">KOPĀ:</td>
                                <td class="px-4 py-3 text-right text-green-600 text-lg">{{ number_format($totalAmount, 2) }} €</td>
                                <td></td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Product Stats -->
        @if($productStats->isNotEmpty())
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-xl font-semibold mb-4 text-gray-800">Produktu statistika</h3>
                <div class="space-y-3">
                    @foreach($productStats as $stat)
                        <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                            <div>
                                <strong class="text-gray-900">{{ $stat['name'] }}</strong>
                                <small class="block text-gray-600 text-sm">Daudzums: {{ $stat['total_quantity'] }}</small>
                            </div>
                            <div class="text-lg font-semibold text-green-600">
                                {{ number_format($stat['total_amount'], 2) }} €
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            flatpickr("#date_from", {
                dateFormat: "d/m/Y",
                locale: "lv",
                defaultDate: "{{ request('date_from') }}"
            });

            flatpickr("#date_to", {
                dateFormat: "d/m/Y",
                locale: "lv",
                defaultDate: "{{ request('date_to') }}"
            });
        });

        function exportToCSV() {
            let csv = [];
            let rows = document.querySelectorAll("table tr");

            for (let i = 0; i < rows.length - 1; i++) {
                let row = [],
                    cols = rows[i].querySelectorAll("td, th");

                for (let j = 0; j < cols.length; j++) {
                    let data = cols[j].innerText.replace(/(\r\n|\n|\r)/gm, '').replace(/\s+/g, ' ').trim();
                    data = data.replace(/"/g, '""');
                    row.push('"' + data + '"');
                }

                csv.push(row.join(","));
            }

            let csvFile = new Blob(["\ufeff" + csv.join("\n")], {
                type: 'text/csv;charset=utf-8;'
            });
            let downloadLink = document.createElement("a");
            downloadLink.download = "pasutijumi_" + new Date().toISOString().slice(0, 10) + ".csv";
            downloadLink.href = window.URL.createObjectURL(csvFile);
            downloadLink.style.display = "none";
            document.body.appendChild(downloadLink);
            downloadLink.click();
            document.body.removeChild(downloadLink);
        }

        document.getElementById('sort_by').addEventListener('change', function () {
            document.getElementById('filterForm').submit();
        });

        document.getElementById('sort_order').addEventListener('change', function () {
            document.getElementById('filterForm').submit();
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/lv.js"></script>
@endsection