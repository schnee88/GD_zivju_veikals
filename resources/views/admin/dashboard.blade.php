@extends('layouts.app')

@section('content')
    <h1>Administratora Panelis</h1>
    <p>Esi veiksmīgi pieslēdzies kā administrators!</p>
    
    <div style="margin-top: 20px; display: flex; gap: 15px; flex-wrap: wrap;">
        <a href="{{ route('admin.dashboard') }}" style="display: inline-block; padding: 12px 20px; background: #2ecc71; color: white; text-decoration: none; border-radius: 4px; font-weight: bold;">
            📋 Skatīt pasūtījumus
        </a>

        <a href="{{ route('admin.fish.index') }}" style="display: inline-block; padding: 12px 20px; background: #3498db; color: white; text-decoration: none; border-radius: 4px; font-weight: bold;">
            🐟 Produkcijas rediģēšana
        </a>

        <a href="{{ route('admin.batches.index') }}" style="display: inline-block; padding: 12px 20px; background: #e67e22; color: white; text-decoration: none; border-radius: 4px; font-weight: bold;">
            🔥 Žāvējumu pārvaldība
        </a>
    </div>
@endsection