@extends('layouts.app')

@section('content')
<style>
    .admin-container {
        max-width: 1400px;
        margin: 0 auto;
    }
    
    .stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }
    
    .stat-card {
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        text-align: center;
    }
    
    .stat-number {
        font-size: 2.5em;
        font-weight: bold;
        color: #3498db;
        margin-bottom: 5px;
    }
    
    .stat-label {
        color: #666;
        font-size: 0.9em;
    }
    
    .orders-table {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        overflow: hidden;
    }
    
    .orders-table table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .orders-table th {
        background: #2c3e50;
        color: white;
        padding: 15px;
        text-align: left;
        font-weight: bold;
    }
    
    .orders-table td {
        padding: 12px 15px;
        border-bottom: 1px solid #eee;
    }
    
    .orders-table tr:hover {
        background: #f8f9fa;
    }
    
    .status-badge {
        display: inline-block;
        padding: 5px 12px;
        border-radius: 15px;
        font-size: 0.85em;
        font-weight: bold;
    }
    
    .status-pending {
        background: #fff3cd;
        color: #856404;
    }
    
    .status-confirmed {
        background: #d1ecf1;
        color: #0c5460;
    }
    
    .status-completed {
        background: #d4edda;
        color: #155724;
    }
    
    .status-cancelled {
        background: #f8d7da;
        color: #721c24;
    }
    
    .view-btn {
        background: #3498db;
        color: white;
        padding: 6px 15px;
        border-radius: 4px;
        text-decoration: none;
        font-size: 0.9em;
    }
    
    .view-btn:hover {
        background: #2980b9;
    }
</style>

<div class="admin-container">
    <h1>Pasūtījumu pārvaldība</h1>
    
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
                    <td>{{ $order->created_at->format('d.m.Y H:i') }}</td>
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
@endsection