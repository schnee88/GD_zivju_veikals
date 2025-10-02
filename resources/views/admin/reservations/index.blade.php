@extends('layouts.app')

@section('content')
<style>
    .admin-container {
        max-width: 1400px;
        margin: 0 auto;
    }
    
    .filters {
        background: white;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 20px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    
    .filter-group {
        display: flex;
        gap: 15px;
        align-items: center;
        flex-wrap: wrap;
    }
    
    .filter-group label {
        font-weight: bold;
        color: #2c3e50;
    }
    
    .filter-group select {
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }
    
    .reservations-table {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        overflow: hidden;
    }
    
    .reservations-table table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .reservations-table th {
        background: #2c3e50;
        color: white;
        padding: 15px;
        text-align: left;
        font-weight: bold;
    }
    
    .reservations-table td {
        padding: 12px 15px;
        border-bottom: 1px solid #eee;
    }
    
    .reservations-table tr:hover {
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
</style>

<div class="admin-container">
    <h1>Rezervāciju pārvaldība</h1>
    
    <div class="stats">
        <div class="stat-card">
            <div class="stat-number">{{ $reservations->where('status', 'pending')->count() }}</div>
            <div class="stat-label">Gaida apstiprinājumu</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $reservations->where('status', 'confirmed')->count() }}</div>
            <div class="stat-label">Apstiprinātas</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $reservations->where('status', 'completed')->count() }}</div>
            <div class="stat-label">Pabeigtas</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $reservations->where('status', 'cancelled')->count() }}</div>
            <div class="stat-label">Atceltas</div>
        </div>
    </div>
    
    <div class="reservations-table">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Klients</th>
                    <th>Telefons</th>
                    <th>Zivs</th>
                    <th>Daudzums</th>
                    <th>Summa</th>
                    <th>Status</th>
                    <th>Datums</th>
                    <th>Darbības</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reservations as $reservation)
                <tr>
                    <td><strong>#{{ $reservation->id }}</strong></td>
                    <td>
                        {{ $reservation->user->name }}<br>
                        <small style="color: #999;">{{ $reservation->user->email }}</small>
                    </td>
                    <td>{{ $reservation->phone }}</td>
                    <td>
                        <strong>{{ $reservation->fish->name }}</strong><br>
                        <small style="color: #666;">{{ $reservation->batch->name ?? 'Batch #' . $reservation->batch->id }}</small>
                    </td>
                    <td>{{ $reservation->quantity }} {{ $reservation->batch->fishes()->where('fish_id', $reservation->fish_id)->first()->pivot->unit }}</td>
                    <td><strong>{{ number_format($reservation->quantity * $reservation->fish->price, 2) }} €</strong></td>
                    <td>
                        <span class="status-badge status-{{ $reservation->status }}">
                            @if($reservation->status == 'pending') Gaida
                            @elseif($reservation->status == 'confirmed') Apstiprināta
                            @elseif($reservation->status == 'completed') Pabeigta
                            @elseif($reservation->status == 'cancelled') Atcelta
                            @endif
                        </span>
                    </td>
                    <td>{{ $reservation->created_at->format('d.m.Y H:i') }}</td>
                    <td>
                        <a href="{{ route('admin.reservations.show', $reservation->id) }}" class="view-btn">
                            Skatīt
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" style="text-align: center; padding: 40px; color: #999;">
                        Nav nevienas rezervācijas
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div style="margin-top: 20px;">
        {{ $reservations->links() }}
    </div>
</div>
@endsection