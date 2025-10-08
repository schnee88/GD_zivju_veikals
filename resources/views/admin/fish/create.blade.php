@extends('layouts.app')

@section('content')
    <div class="checkout-container">
        <h1>Pievienot jaunu zivi</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="checkout-section">
            <form action="{{ route('admin.fish.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label class="form-label">Nosaukums:</label>
                    <input type="text" name="name" class="form-input" value="{{ old('name') }}">
                    @error('name') <small class="error-message">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Cena (€):</label>
                    <input type="number" step="0.01" name="price" class="form-input" value="{{ old('price') }}">
                    @error('price') <small class="error-message">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Apraksts:</label>
                    <textarea name="description" class="form-input form-textarea">{{ old('description') }}</textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">Bilde:</label>
                    <input type="file" name="image" class="form-input">
                    @error('image') <small class="error-message">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Pasūtīšanas statuss:</label>
                    <select name="is_orderable" class="form-input">
                        <option value="0" {{ old('is_orderable') == '0' ? 'selected' : '' }}>
                            ❌ Tikai katalogā (nevar pasūtīt)
                        </option>
                        <option value="1" {{ old('is_orderable') == '1' ? 'selected' : '' }}>
                            ✅ Pasūtāms (var pievienot pasūtījumam)
                        </option>
                    </select>
                    <small style="color: #666; margin-top: 8px; display: block;">
                        <strong>Pasūtāms:</strong> Zivs redzama pasūtījumu sarakstā un pievienojama grozam<br>
                        <strong>Tikai katalogā:</strong> Zivs redzama tikai informācijas nolūkos
                    </small>
                    @error('is_orderable') <small class="error-message">{{ $message }}</small> @enderror
                </div>

                <div class="button-group">
                    <button type="submit" class="checkout-btn">Saglabāt</button>
                    <a href="{{ url()->previous() }}" class="btn-secondary">Atpakaļ</a>
                </div>
            </form>
        </div>
    </div>
@endsection