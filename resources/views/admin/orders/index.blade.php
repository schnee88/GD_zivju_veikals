@extends('layouts.app')

@section('content')
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