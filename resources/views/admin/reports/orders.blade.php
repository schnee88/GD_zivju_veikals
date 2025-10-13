@extends('layouts.app')

@section('content')

<div class="reports-container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h1>📊 Pasūtījumu pārskats</h1>
        <div style="display: flex; gap: 10px;">
            <a href="{{ route('admin.orders.index') }}" style="background: #95a5a6; color: white; padding: 10px 20px; border-radius: 4px; text-decoration: none;">
                ← Atpakaļ uz pasūtījumiem
            </a>
            <button onclick="window.print()" style="background: #3498db; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;">
                🖨️ Drukāt
            </button>
        </div>
    </div>
    
    <!-- Filtri -->
    <div class="filters-card">
        <h3 style="margin: 0 0 15px 0;">🔍 Filtri un meklēšana</h3>
        <form method="GET" action="{{ route('admin.reports.orders') }}" id="filterForm">
            <div class="filters-grid" style="grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));">
                <!-- Datums no -->
                <div class="filter-group">
                    <label for="date_from">📅 Datums no:</label>
                    <input type="date" id="date_from" name="date_from" value="{{ request('date_from') }}" class="filter-input">
                </div>
                
                <!-- Datums līdz -->
                <div class="filter-group">
                    <label for="date_to">📅 Datums līdz:</label>
                    <input type="date" id="date_to" name="date_to" value="{{ request('date_to') }}" class="filter-input">
                </div>
                
                <!-- Statuss -->
                <div class="filter-group">
                    <label for="status">📊 Statuss:</label>
                    <select id="status" name="status" class="filter-input">
                        <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Visi</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Gaida</option>
                        <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Apstiprināts</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Pabeigts</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Atcelts</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="order_id">🔢 Pasūtījuma #:</label>
                    <input type="number" id="order_id" name="order_id" value="{{ request('order_id') }}" placeholder="Piemēram: 15" class="filter-input">
                </div>
                
                <div class="filter-group">
                    <label for="customer_name">👤 Klienta vārds:</label>
                    <input type="text" id="customer_name" name="customer_name" value="{{ request('customer_name') }}" placeholder="Meklēt pēc vārda..." class="filter-input">
                </div>

                <div class="filter-group">
                    <label for="phone">📞 Telefons:</label>
                    <input type="text" id="phone" name="phone" value="{{ request('phone') }}" placeholder="+371..." class="filter-input">
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
                
                <!-- Kārtošanas secība -->
                <div class="filter-group">
                    <label for="sort_order">↕️ Secība:</label>
                    <select id="sort_order" name="sort_order" class="filter-input">
                        <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>Dilstošā</option>
                        <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>Augošā</option>
                    </select>
                </div>
            </div>
            
            <div style="display: flex; gap: 10px; margin-top: 15px; flex-wrap: wrap;">
                <button type="submit" style="background: #27ae60; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;">
                    🔍 Filtrēt
                </button>
                <a href="{{ route('admin.reports.orders') }}" style="background: #95a5a6; color: white; padding: 10px 20px; border-radius: 4px; text-decoration: none; display: inline-block;">
                    ❌ Notīrīt filtrus
                </a>
                <button type="button" onclick="exportToCSV()" style="background: #3498db; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;">
                    📥 Eksportēt CSV
                </button>
            </div>
        </form>
    </div>
    
    <!-- Statistika -->
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
            <div class="stat-number" style="color: #27ae60;">{{ number_format($totalAmount, 2) }} €</div>
            <div class="stat-label">Kopējā summa</div>
        </div>
    </div>
    
    <!-- Galvenā tabula -->
    <div class="reports-table">
        <table>
            <thead>
                <tr>
                    <th>Pasūt. #</th>
                    <th>Datums</th>
                    <th>Klients</th>
                    <th>Telefons</th>
                    <th>Zivs</th>
                    <th style="text-align: center;">Daudzums</th>
                    <th style="text-align: right;">Cena</th>
                    <th style="text-align: right;">Summa</th>
                    <th style="text-align: center;">Statuss</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orderItems as $item)
                <tr>
                    <td><strong>#{{ $item->order_id }}</strong></td>
                    <td>{{ $item->order->created_at->format('d.m.Y H:i') }}</td>
                    <td>{{ $item->order->user->name }}</td>
                    <td>{{ $item->order->phone }}</td>
                    <td>
                        <strong>{{ $item->fish->name }}</strong>
                        @if($item->batch_id)
                            <br><small style="color: #666;">{{ $item->batch->name ?? 'Batch #' . $item->batch_id }}</small>
                        @endif
                    </td>
                    <td style="text-align: center;">
                        {{ $item->quantity }} 
                        @if($item->batch_id)
                            {{ $item->batch->fishes()->where('fish_id', $item->fish_id)->first()->pivot->unit ?? 'kg' }}
                        @else
                            {{ $item->fish->stock_unit == 'kg' ? 'kg' : 'gab.' }}
                        @endif
                    </td>
                    <td style="text-align: right;">{{ number_format($item->price, 2) }} €</td>
                    <td style="text-align: right;"><strong>{{ number_format($item->quantity * $item->price, 2) }} €</strong></td>
                    <td style="text-align: center;">
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
                    <td colspan="9" style="text-align: center; padding: 40px; color: #999;">
                        Nav neviena ieraksta
                    </td>
                </tr>
                @endforelse
                
                @if($orderItems->isNotEmpty())
                <tr class="total-row">
                    <td colspan="7" style="text-align: right;">KOPĀ:</td>
                    <td style="text-align: right; color: #27ae60;">{{ number_format($totalAmount, 2) }} €</td>
                    <td></td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
    
    <!-- Produktu statistika -->
    @if($productStats->isNotEmpty())
    <div class="product-stats">
        <h3>Produktu statistika</h3>
        <div class="product-stats-list">
            @foreach($productStats as $stat)
            <div class="product-stat-item">
                <div>
                    <strong>{{ $stat['name'] }}</strong><br>
                    <small style="color: #666;">Daudzums: {{ $stat['total_quantity'] }}</small>
                </div>
                <div style="font-weight: bold; color: #27ae60;">
                    {{ number_format($stat['total_amount'], 2) }} €
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>

<script>
// Eksportēt uz CSV funkcija
function exportToCSV() {
    let csv = [];
    let rows = document.querySelectorAll(".reports-table table tr");
    
    for (let i = 0; i < rows.length - 1; i++) { // -1 lai izslēgtu KOPĀ rindu
        let row = [], cols = rows[i].querySelectorAll("td, th");
        
        for (let j = 0; j < cols.length; j++) {
            let data = cols[j].innerText.replace(/(\r\n|\n|\r)/gm, '').replace(/\s+/g, ' ').trim();
            data = data.replace(/"/g, '""');
            row.push('"' + data + '"');
        }
        
        csv.push(row.join(","));
    }
    
    let csvFile = new Blob(["\ufeff" + csv.join("\n")], { type: 'text/csv;charset=utf-8;' });
    let downloadLink = document.createElement("a");
    downloadLink.download = "pasutijumi_" + new Date().toISOString().slice(0,10) + ".csv";
    downloadLink.href = window.URL.createObjectURL(csvFile);
    downloadLink.style.display = "none";
    document.body.appendChild(downloadLink);
    downloadLink.click();
    document.body.removeChild(downloadLink);
}

// Auto-submit formu ja maina kārtošanu
document.getElementById('sort_by').addEventListener('change', function() {
    document.getElementById('filterForm').submit();
});

document.getElementById('sort_order').addEventListener('change', function() {
    document.getElementById('filterForm').submit();
});
</script>
@endsection