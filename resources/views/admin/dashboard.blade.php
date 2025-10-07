@extends('layouts.app')

@section('content')
<div class="dashboard-container">
    <h1>Admin Panelis</h1>
    <p style="color: #666; margin-top: 10px;">Laipni lūdzam administratora panelī!</p>

    <div class="dashboard-grid">
        <a href="{{ route('admin.fish.index') }}" class="dashboard-card">
            <div class="card-icon">🐟</div>
            <div class="card-title">Zivis</div>
            <div class="card-description">Pārvaldīt zivju katalogu</div>
        </a>

        <a href="{{ route('admin.batches.index') }}" class="dashboard-card">
            <div class="card-icon">📦</div>
            <div class="card-title">Kūpinājumi</div>
            <div class="card-description">Pārvaldīt kūpinājumus</div>
        </a>

        <a href="{{ route('admin.orders.index') }}" class="dashboard-card">
            <div class="card-icon">📋</div>
            <div class="card-title">Pasūtījumi</div>
            <div class="card-description">Skatīt un apstiprināt pasūtījumus</div>
        </a>
    </div>
</div>
@endsection