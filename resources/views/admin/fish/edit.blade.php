@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Rediģēt zivi: {{ $fish->name }}</h2>

    <div class="checkout-section">
        <form action="{{ route('admin.fish.update', $fish->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name" class="form-label">Nosaukums</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                       value="{{ old('name', $fish->name) }}" required>
                @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="price" class="form-label">Cena (€)</label>
                <input type="number" step="0.01" name="price" class="form-control @error('price') is-invalid @enderror" 
                       value="{{ old('price', $fish->price) }}" required>
                @error('price')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="description" class="form-label">Apraksts</label>
                <textarea name="description" class="form-control @error('description') is-invalid @enderror" 
                          rows="4">{{ old('description', $fish->description) }}</textarea>
                @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="image" class="form-label">Attēls</label>
                @if ($fish->image_url)
                <div style="margin-bottom: 15px;">
                    <img src="{{ $fish->image_url }}" alt="Fish image" width="120" class="mb-2" 
                         style="border-radius: 8px; border: 1px solid #ddd;">
                </div>
                @endif
                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" 
                       style="padding: 8px;">
                @error('image')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="is_orderable" class="form-label">Pasūtīšanas statuss</label>
                <select name="is_orderable" class="form-control @error('is_orderable') is-invalid @enderror" 
                        style="padding: 10px; border-radius: 6px; border: 1px solid #ddd;">
                    <option value="0" {{ old('is_orderable', $fish->is_orderable) == 0 ? 'selected' : '' }}>
                        ❌ Tikai katalogā (nevar pasūtīt)
                    </option>
                    <option value="1" {{ old('is_orderable', $fish->is_orderable) == 1 ? 'selected' : '' }}>
                        ✅ Pasūtāms (var pievienot pasūtījumam)
                    </option>
                </select>
                <small style="color: #666; margin-top: 8px; display: block;">
                    <strong>Pasūtāms:</strong> Zivs redzama pasūtījumu sarakstā un pievienojama grozam<br>
                    <strong>Tikai katalogā:</strong> Zivs redzama tikai informācijas nolūkos
                </small>
                @error('is_orderable')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="button-group">
                <button type="submit" class="btn btn-success">Saglabāt izmaiņas</button>
                <a href="{{ route('admin.fish.index') }}" class="btn-secondary">Atpakaļ</a>
            </div>
        </form>
    </div>
</div>
@endsection