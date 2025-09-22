@extends('layouts.app')

@section('content')
<div style="max-width:600px; margin:20px auto; text-align:center;">
    <h1>{{ $fish->name }}</h1>

    @if($fish->image)
        <img src="{{ asset('storage/' . $fish->image) }}" alt="{{ $fish->name }}" style="width:100%; max-height:400px; object-fit:cover; border-radius:8px;">
    @else
        <div style="width:100%; height:300px; background:#f0f0f0; display:flex; align-items:center; justify-content:center; border-radius:8px;">
            Nav bildes
        </div>
    @endif

    <p style="margin-top:15px; font-size:1.1em;">{{ $fish->description ?? 'Nav apraksta' }}</p>
    <p style="font-weight:bold; font-size:1.2em;">Cena: €{{ $fish->price }}</p>

    <a href="{{ route('fish.index') }}" style="display:inline-block; margin-top:20px; background:#3498db; color:white; padding:10px 20px; border-radius:5px; text-decoration:none;">
        Atpakaļ uz sarakstu
    </a>
</div>
@endsection
