@extends('layouts.app')

@section('content')
    <h1>Administratora Panelis</h1>
    <p>Esi veiksmīgi pieslēdzies kā administrators!</p>
    
    <div style="margin-top: 20px;">
        <a href="{{ route('fish.create') }}" style="display: inline-block; padding: 10px; background: #3498db; color: white; text-decoration: none; margin-right: 10px;">
            Pievienot jaunu zivi
        </a>
        <a href="{{ route('admin.orders.index') }}" style="display: inline-block; padding: 10px; background: #2ecc71; color: white; text-decoration: none;">
            Skatīt pasūtījumus
        </a>
    </div>
@endsection