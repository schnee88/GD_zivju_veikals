@extends('layouts.app')

@section('content')
    <div class="reports-container">
        <div class="reports-header">
            <h1>📊 Pasūtījumu pārskats</h1>
            <div class="header-actions">
                <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
                    ← Uz pasūtījumiem
                </a>
                <button onclick="window.print()" class="btn btn-primary">
                    🖨️ Drukāt
                </button>
            </div>
        </div>

        <div class="filters-card">
            <h3>🔍 Filtri un meklēšana</h3>
            <form method="GET" action="{{ route('admin.reports.orders') }}" id="filterForm">
                <div class="filters-grid">
                    <!-- Datums no -->
                    <div class="filter-group">
                        <label for="date_from">📅 Datums no:</label>
                        <input type="text" id="date_from" name="date_from" value="{{ request('date_from') }}"
                            placeholder="DD/MM/YYYY" class="filter-input">
                    </div>

                    <!-- Datums līdz -->
                    <div class="filter-group">
                        <label for="date_to">📅 Datums līdz:</label>
                        <input type="text" id="date_to" name="date_to" value="{{ request('date_to') }}"
                            placeholder="DD/MM/YYYY" class="filter-input">
                    </div>

                    <!-- Statuss -->
                    <div class="filter-group">
                        <label for="status">📊 Statuss:</label>
                        <select id="status" name="status" class="filter-input">
                            <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Visi</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Gaida</option>
                            <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Apstiprināts
                            </option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Pabeigts
                            </option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Atcelts
                            </option>
                        </select>
                    </div>

                    <div class="filter-group">
                        <label for="order_id">🔢 Pasūtījuma #:</label>
                        <input type="number" id="order_id" name="order_id" value="{{ request('order_id') }}"
                            placeholder="Piemēram: 15" class="filter-input">
                    </div>

                    <div class="filter-group">
                        <label for="customer_name">👤 Klienta vārds:</label>
                        <input type="text" id="customer_name" name="customer_name" value="{{ request('customer_name') }}"
                            placeholder="Meklēt pēc vārda..." class="filter-input">
                    </div>

                    <div class="filter-group">
                        <label for="phone">📞 Telefons:</label>
                        <input type="text" id="phone" name="phone" value="{{ request('phone') }}" placeholder="+371..."
                            class="filter-input">
                    </div>

                    <div class="filter-group">
                        <label for="fish_id">🐟 Zivs:</label>
                        <select id="fish_id" name="fish_id" class="filter-input">
                            <option value="all" {{ request('fish_id') == 'all' ? 'selected' : '' }}>Visas</option>
                            @foreach($allFishes as $fish)
                                <option value="{{ $fish->id }}" {{ request('fish_id') == $fish->id ? 'selected' : '' }}>
                                    {{ $fish->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="filter-group">
                        <label for="sort_by">📋 Kārtot pēc:</label>
                        <select id="sort_by" name="sort_by" class="filter-input">
                            <option value="id" {{ request('sort_by') == 'id' ? 'selected' : '' }}>Pasūtījuma ID</option>
                            <option value="date" {{ request('sort_by') == 'date' ? 'selected' : '' }}>Datuma</option>
                            <option value="amount" {{ request('sort_by') == 'amount' ? 'selected' : '' }}>Summas</option>
                        </select>
                    </div>

                    <div class="filter-group">
                        <label for="sort_order">↕️ Secība:</label>
                        <select id="sort_order" name="sort_order" class="filter-input">
                            <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>Dilstošā</option>
                            <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>Augošā</option>
                        </select>
                    </div>
                </div>

                <div class="filter-actions">
                    <button type="submit" class="btn btn-success">
                        🔍 Filtrēt
                    </button>
                    <a href="{{ route('admin.reports.orders') }}" class="btn btn-secondary">
                        ❌ Notīrīt filtrus
                    </a>
                    <button type="button" onclick="exportToCSV()" class="btn btn-primary">
                        📥 Eksportēt CSV
                    </button>
                </div>
            </form>
        </div>

        <!-- Active Filters Display -->
        @if(request()->hasAny(['date_from', 'date_to', 'status', 'order_id', 'customer_name', 'phone', 'fish_id']))
            <div
                style="background: #e3f2fd; padding: 10px 15px; border-radius: 6px; margin-bottom: 20px; border-left: 4px solid #2196f3;">
                <strong>Aktīvie filtri:</strong>
                @if(request('date_from'))
                    <span class="filter-tag">No: {{ request('date_from') }}</span>
                @endif
                @if(request('date_to'))
                    <span class="filter-tag">Līdz: {{ request('date_to') }}</span>
                @endif
                @if(request('status') && request('status') != 'all')
                    <span class="filter-tag">Statuss:
                        @if(request('status') == 'pending') Gaida
                        @elseif(request('status') == 'confirmed') Apstiprināts
                        @elseif(request('status') == 'completed') Pabeigts
                        @elseif(request('status') == 'cancelled') Atcelts
                        @endif
                    </span>
                @endif
                @if(request('order_id'))
                    <span class="filter-tag">Pasūtījums: #{{ request('order_id') }}</span>
                @endif
                @if(request('customer_name'))
                    <span class="filter-tag">Klients: {{ request('customer_name') }}</span>
                @endif
                @if(request('phone'))
                    <span class="filter-tag">Telefons: {{ request('phone') }}</span>
                @endif
                @if(request('fish_id') && request('fish_id') != 'all')
                    @php
                        $selectedFish = $allFishes->firstWhere('id', request('fish_id'));
                    @endphp
                    @if($selectedFish)
                        <span class="filter-tag">Zivs: {{ $selectedFish->name }}</span>
                    @endif
                @endif
            </div>
        @endif

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number">{{ $orderItems->count() }}</div>
                <div class="stat-label">Kopā pozīcijas</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $orderItems->pluck('order_id')->unique()->count() }}</div>
                <div class="stat-label">Unikāli pasūtījumi</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" style="color: var(--success);">{{ number_format($totalAmount, 2) }} €</div>
                <div class="stat-label">Kopējā summa</div>
            </div>
        </div>

        <div class="reports-table">
            <table>
                <thead>
                    <tr>
                        <th>Pasūt. #</th>
                        <th>Datums</th>
                        <th>Klients</th>
                        <th>Telefons</th>
                        <th>Zivs</th>
                        <th class="text-center">Daudzums</th>
                        <th class="text-right">Cena</th>
                        <th class="text-right">Summa</th>
                        <th class="text-center">Statuss</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orderItems as $item)
                        <tr>
                            <td><strong>#{{ $item->order_id }}</strong></td>
                            <td>{{ $item->order->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ $item->order->user->name }}</td>
                            <td>{{ $item->order->phone }}</td>
                            <td>
                                <strong>{{ $item->fish->name }}</strong>
                                @if($item->batch_id)
                                    <br><small class="batch-info">{{ $item->batch->name ?? 'Batch #' . $item->batch_id }}</small>
                                @endif
                            </td>
                            <td class="text-center">
                                {{ $item->quantity }}
                                @if($item->batch_id)
                                    {{ $item->batch->fishes()->where('fish_id', $item->fish_id)->first()->pivot->unit ?? 'kg' }}
                                @else
                                    {{ $item->fish->stock_unit == 'kg' ? 'kg' : 'gab.' }}
                                @endif
                            </td>
                            <td class="text-right">{{ number_format($item->price, 2) }} €</td>
                            <td class="text-right"><strong>{{ number_format($item->quantity * $item->price, 2) }} €</strong>
                            </td>
                            <td class="text-center">
                                <span class="status-badge status-{{ $item->order->status }}">
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
                            <td colspan="9" class="empty-state">
                                Nav neviena ieraksta
                            </td>
                        </tr>
                    @endforelse

                    @if($orderItems->isNotEmpty())
                        <tr class="total-row">
                            <td colspan="7" class="text-right">KOPĀ:</td>
                            <td class="text-right total-amount">{{ number_format($totalAmount, 2) }} €</td>
                            <td></td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        @if($productStats->isNotEmpty())
            <div class="product-stats">
                <h3>Produktu statistika</h3>
                <div class="product-stats-list">
                    @foreach($productStats as $stat)
                        <div class="product-stat-item">
                            <div class="product-info">
                                <strong>{{ $stat['name'] }}</strong>
                                <small>Daudzums: {{ $stat['total_quantity'] }}</small>
                            </div>
                            <div class="product-amount">
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
            let rows = document.querySelectorAll(".reports-table table tr");

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

    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/lv.js"></script>
@endsection