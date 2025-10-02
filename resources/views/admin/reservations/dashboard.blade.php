@extends('layouts.app')

@section('content')
<style>
    .dashboard-container {
        max-width: 1200px;
        margin: 0 auto;
    }
    
    .dashboard-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-top: 30px;
    }
    
    .dashboard-card {
        background: white;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        text-align: center;
        transition: transform 0.3s, box-shadow 0.3s;
        text-decoration: none;
        display: block;
    }
    
    .dashboard-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    
    .card-icon {
        font-size: 3em;
        margin-bottom: 15px;
    }
    
    .card-title {
        color: #2c3e50;
        font-size: 1.3em;
        font-weight: bold;
        margin-bottom: 10px;
    }
    
    .card-description {
        color: #666;
        font-size: 0.9em;
    }
</style>

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
        
        <a href="{{ route('admin.reservations.index') }}" class="dashboard-card">
            <div class="card-icon">📋</div>
            <div class="card-title">Rezervācijas</div>
            <div class="card-description">Skatīt un apstiprināt rezervācijas</div>
        </a>
    </div>
</div>
@endsection