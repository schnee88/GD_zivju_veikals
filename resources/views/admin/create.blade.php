@extends('layouts.app')

@section('content')
    <h1>Pievienot jaunu zivi</h1>

    @if(session('success'))
        <p style="color: green">{{ session('success') }}</p>
    @endif

    <form action="{{ route('fish.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <label>Nosaukums:</label><br>
        <input type="text" name="name" value="{{ old('name') }}"><br>
        @error('name') <small style="color:red">{{ $message }}</small> @enderror
        <br>

        <label>Cena (€):</label><br>
        <input type="number" step="0.01" name="price" value="{{ old('price') }}"><br>
        @error('price') <small style="color:red">{{ $message }}</small> @enderror
        <br>

        <label>Apraksts:</label><br>
        <textarea name="description">{{ old('description') }}</textarea><br>

        <label>Bilde:</label><br>
        <input type="file" name="image"><br>
        @error('image') <small style="color:red">{{ $message }}</small> @enderror
        <br><br>

        <button type="submit">Saglabāt</button>
    </form>
@endsection
