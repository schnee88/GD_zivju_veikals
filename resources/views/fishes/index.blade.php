@extends('layouts.app')

@section('content')
    <h1>Zivju Veikaliņa pieejamā produkcija</h1>
    
    <div class="fish-grid">
        @foreach($fishes as $fish)
            <div class="fish-card">
                <h2>{{ $fish->name }}</h2>

                @if($fish->image)
                    <img src="{{ asset('storage/' . $fish->image) }}" alt="{{ $fish->name }}">
                @else
                    <div class="no-image">Nav bildes</div>
                @endif

                <p>Cena: {{ $fish->price }} € (Eur/kg)</p>
                <p>{{ $fish->description }}</p>
                <a href="{{ route('fish.show', $fish->id) }}">Skatīt vairāk</a>
            </div>
        @endforeach
    </div>
@endsection