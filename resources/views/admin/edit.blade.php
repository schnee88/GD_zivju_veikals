@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Rediģēt zivi: {{ $fish->name }}</h2>

    <form action="{{ route('admin.fish.update', $fish->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Nosaukums</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $fish->name) }}" required>
            @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Cena (€)</label>
            <input type="number" step="0.01" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', $fish->price) }}" required>
            @error('price')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Apraksts</label>
            <textarea name="description" class="form-control @error('description') is-invalid @enderror">{{ old('description', $fish->description) }}</textarea>
            @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Attēls</label><br>
            @if ($fish->image_url)
            <img src="{{ $fish->image_url }}" alt="Fish image" width="120" class="mb-2">
            @endif
            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
            @error('image')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">Saglabāt izmaiņas</button>
        <a href="{{ route('admin.fish.index') }}" class="btn btn-secondary">Atpakaļ</a>
    </form>
</div>
@endsection