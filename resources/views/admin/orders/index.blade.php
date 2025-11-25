@extends('layouts.app')

@section('content')
    <div class="admin-container">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h1>📊 Pasūtījumi</h1>
            <div>
                <a href="{{ route('admin.reports.orders') }}" class="btn btn-secondary">
                    ← Uz pārskatu
                </a>
            </div>
        </div>

        <!-- Date Filter Form -->
        <div class="filter-card" style="background: #f8f9fa; padding: 20px; border-radius: 8px; margin-bottom: 20px;">
            <h3 style="margin-bottom: 15px;">📅 Filtrēt pēc datuma</h3>
            <form action="{{ route('admin.orders.index') }}" method="GET"
                style="display: grid; grid-template-columns: 1fr 1fr auto auto; gap: 15px; align-items: end;">
                @csrf
                <div>
                    <label for="start_date" style="display: block; margin-bottom: 5px; font-weight: bold;">No
                        datuma:</label>
                    <input type="text" name="start_date" id="start_date" value="{{ request('start_date') }}"
                        placeholder="DD/MM/YYYY"
                        style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                </div>
                <div>
                    <label for="end_date" style="display: block; margin-bottom: 5px; font-weight: bold;">Līdz
                        datumam:</label>
                    <input type="text" name="end_date" id="end_date" value="{{ request('end_date') }}"
                        placeholder="DD/MM/YYYY"
                        style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                </div>
                <div>
                    <label for="status" style="display: block; margin-bottom: 5px; font-weight: bold;">Statuss:</label>
                    <select name="status" id="status"
                        style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                        <option value="">Visi statusi</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Gaida</option>
                        <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Apstiprināti
                        </option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Pabeigti</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Atcelti</option>
                    </select>
                </div>
                <div style="display: flex; gap: 10px;">
                    <button type="submit"
                        style="background: #3498db; color: white; padding: 8px 16px; border: none; border-radius: 4px; cursor: pointer;">
                        🔍 Filtrēt
                    </button>
                    <a href="{{ route('admin.orders.index') }}"
                        style="background: #6c757d; color: white; padding: 8px 16px; border-radius: 4px; text-decoration: none; display: inline-block;">
                        ❌ Notīrīt
                    </a>
                </div>
            </form>
        </div>

        <!-- Active Filters -->
        @if(request()->hasAny(['start_date', 'end_date', 'status']))
            <div
                style="background: #e3f2fd; padding: 10px 15px; border-radius: 6px; margin-bottom: 20px; border-left: 4px solid #2196f3;">
                <strong>Aktīvie filtri:</strong>
                @if(request('start_date'))
                    <span class="filter-tag">No: {{ request('start_date') }}</span>
                @endif
                @if(request('end_date'))
                    <span class="filter-tag">Līdz: {{ request('end_date') }}</span>
                @endif
                @if(request('status'))
                    <span class="filter-tag">Statuss:
                        @if(request('status') == 'pending') Gaida
                        @elseif(request('status') == 'confirmed') Apstiprināts
                        @elseif(request('status') == 'completed') Pabeigts
                        @elseif(request('status') == 'cancelled') Atcelts
                        @endif
                    </span>
                @endif
            </div>
        @endif

        <div class="stats">
            <div class="stat-card">
                <div class="stat-number">{{ $orders->where('status', 'pending')->count() }}</div>
                <div class="stat-label">Gaida apstiprinājumu</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $orders->where('status', 'confirmed')->count() }}</div>
                <div class="stat-label">Apstiprināti</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $orders->where('status', 'completed')->count() }}</div>
                <div class="stat-label">Pabeigti</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $orders->where('status', 'cancelled')->count() }}</div>
                <div class="stat-label">Atcelti</div>
            </div>
        </div>

        <div class="orders-table">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Klients</th>
                        <th>Telefons</th>
                        <th>Produkti</th>
                        <th>Summa</th>
                        <th>Status</th>
                        <th>Datums</th>
                        <th>Darbības</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td><strong>#{{ $order->id }}</strong></td>
                            <td>
                                {{ $order->user->name }}<br>
                                <small style="color: #999;">{{ $order->user->email }}</small>
                            </td>
                            <td>{{ $order->phone }}</td>
                            <td>
                                <small style="color: #666;">{{ $order->items->count() }} produkti</small>
                            </td>
                            <td><strong>{{ number_format($order->total_amount, 2) }} €</strong></td>
                            <td>
                                <span class="status-badge status-{{ $order->status }}">
                                    @if($order->status == 'pending') Gaida
                                    @elseif($order->status == 'confirmed') Apstiprināts
                                    @elseif($order->status == 'completed') Pabeigts
                                    @elseif($order->status == 'cancelled') Atcelts
                                    @endif
                                </span>
                            </td>
                            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="view-btn">
                                    Skatīt
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="text-align: center; padding: 40px; color: #999;">
                                Nav neviena pasūtījuma
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top: 20px;">
            {{ $orders->links() }}
        </div>
    </div>

    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Initialize Flatpickr for date inputs
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

    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/lv.js"></script>
@endsection