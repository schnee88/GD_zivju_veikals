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
                <input type="text" name="name" class="form-input @error('name') is-invalid @enderror" 
                       value="{{ old('name', $fish->name) }}" required>
                @error('name')
                <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="price" class="form-label">Cena (€)</label>
                <input type="number" step="0.01" name="price" class="form-input @error('price') is-invalid @enderror" 
                       value="{{ old('price', $fish->price) }}" required>
                @error('price')
                <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="description" class="form-label">Apraksts</label>
                <textarea name="description" class="form-input form-textarea @error('description') is-invalid @enderror" 
                          rows="4">{{ old('description', $fish->description) }}</textarea>
                @error('description')
                <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="image" class="form-label">Attēls</label>
                @if($fish->image)
                <div style="margin-bottom: 15px;">
                    <img src="{{ asset('storage/fish_images/' . $fish->image) }}" alt="{{ $fish->name }}" 
                         style="width: 150px; border-radius: 8px; border: 1px solid #ddd;">
                </div>
                @endif
                <input type="file" name="image" class="form-input @error('image') is-invalid @enderror">
                @error('image')
                <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="is_orderable" class="form-label">Pasūtīšanas statuss</label>
                <select name="is_orderable" id="is_orderable" class="form-input @error('is_orderable') is-invalid @enderror">
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
                <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- Stock Fields -->
            <div id="stockFields" style="display: {{ old('is_orderable', $fish->is_orderable) == 1 ? 'block' : 'none' }};">
                <div class="form-group">
                    <label class="form-label">Pieejamais daudzums:</label>
                    <input type="number" name="stock_quantity" class="form-input" 
                           value="{{ old('stock_quantity', $fish->stock_quantity ?? 0) }}" min="0" step="0.1">
                    @error('stock_quantity') <small class="error-message">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Mērvienība:</label>
                    <select name="stock_unit" class="form-input">
                        <option value="pieces" {{ old('stock_unit', $fish->stock_unit ?? 'pieces') == 'pieces' ? 'selected' : '' }}>
                            Gabali (gab.)
                        </option>
                        <option value="kg" {{ old('stock_unit', $fish->stock_unit ?? 'kg') == 'kg' ? 'selected' : '' }}>
                            Kilogrami (kg)
                        </option>
                    </select>
                    @error('stock_unit') <small class="error-message">{{ $message }}</small> @enderror
                </div>
            </div>

            <div class="button-group">
                <button type="submit" class="checkout-btn">Saglabāt izmaiņas</button>
                <a href="{{ route('admin.fish.index') }}" class="btn-secondary">Atpakaļ</a>
            </div>
        </form>
    </div>
</div>

<script>
    const orderableSelect = document.getElementById('is_orderable');
    const stockFields = document.getElementById('stockFields');
    
    orderableSelect.addEventListener('change', function() {
        stockFields.style.display = this.value == '1' ? 'block' : 'none';
    });
</script>
@endsection