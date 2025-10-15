@extends('layouts.app')

@section('content')
<div class="admin-container compact-form">
    <div class="admin-header">
        <h1>Rediģēt: {{ $fish->name }}</h1>
        <a href="{{ route('admin.fish.index') }}" class="btn btn-secondary btn-sm">
            ← Atpakaļ
        </a>
    </div>

    <div class="form-container">
        <form action="{{ route('admin.fish.update', $fish->id) }}" method="POST" enctype="multipart/form-data" class="fish-form">
            @csrf
            @method('PUT')

            <div class="form-grid">
                <!-- Basic Info -->
                <div class="form-group">
                    <label for="name" class="form-label">Nosaukums *</label>
                    <input type="text" name="name" class="form-input @error('name') error @enderror" 
                           value="{{ old('name', $fish->name) }}" required>
                    @error('name')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="price" class="form-label">Cena (€) *</label>
                    <input type="number" step="0.01" name="price" class="form-input @error('price') error @enderror" 
                           value="{{ old('price', $fish->price) }}" required>
                    @error('price')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Order Settings -->
                <div class="form-group">
                    <label for="is_orderable" class="form-label">Statuss *</label>
                    <select name="is_orderable" id="is_orderable" class="form-input @error('is_orderable') error @enderror">
                        <option value="0" {{ old('is_orderable', $fish->is_orderable) == 0 ? 'selected' : '' }}>
                            ❌ Tikai katalogā
                        </option>
                        <option value="1" {{ old('is_orderable', $fish->is_orderable) == 1 ? 'selected' : '' }}>
                            ✅ Pasūtāms
                        </option>
                    </select>
                    @error('is_orderable')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Stock Fields -->
                <div id="stockFields" class="form-group {{ old('is_orderable', $fish->is_orderable) == 1 ? 'visible' : 'hidden' }}">
                    <div class="stock-row">
                        <div class="stock-input">
                            <label for="stock_quantity" class="form-label">Daudzums *</label>
                            <input type="number" name="stock_quantity" id="stock_quantity" class="form-input @error('stock_quantity') error @enderror" 
                                   value="{{ old('stock_quantity', $fish->stock_quantity ?? 0) }}" min="0" step="0.1">
                        </div>
                        <div class="stock-unit">
                            <label for="stock_unit" class="form-label">Mērvienība *</label>
                            <select name="stock_unit" id="stock_unit" class="form-input @error('stock_unit') error @enderror">
                                <option value="pieces" {{ old('stock_unit', $fish->stock_unit ?? 'pieces') == 'pieces' ? 'selected' : '' }}>gab.</option>
                                <option value="kg" {{ old('stock_unit', $fish->stock_unit ?? 'kg') == 'kg' ? 'selected' : '' }}>kg</option>
                            </select>
                        </div>
                    </div>
                    @error('stock_quantity') <div class="error-message">{{ $message }}</div> @enderror
                    @error('stock_unit') <div class="error-message">{{ $message }}</div> @enderror
                </div>

                <!-- Description -->
                <div class="form-group full-width">
                    <label for="description" class="form-label">Apraksts</label>
                    <textarea name="description" class="form-input form-textarea @error('description') error @enderror" 
                              rows="3" placeholder="Īss produkta apraksts...">{{ old('description', $fish->description) }}</textarea>
                    @error('description')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Image -->
                <div class="form-group full-width">
                    <label class="form-label">Attēls</label>
                    <div class="image-section">
                        @if($fish->image)
                        <div class="current-image">
                            <img src="{{ asset('storage/fish_images/' . $fish->image) }}" alt="{{ $fish->name }}" 
                                 class="fish-image-preview">
                            <small>Pašreizējais attēls</small>
                        </div>
                        @else
                        <div class="no-image">
                            <span>📷 Nav attēla</span>
                        </div>
                        @endif
                        
                        <div class="image-upload">
                            <input type="file" name="image" class="form-input @error('image') error @enderror" 
                                   accept="image/*">
                            <small class="form-help">JPG, PNG, GIF (max 5MB)</small>
                            @error('image')
                            <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary btn-sm">
                    💾 Saglabāt
                </button>
                <a href="{{ route('admin.fish.index') }}" class="btn btn-secondary btn-sm">
                    ❌ Atcelt
                </a>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const orderableSelect = document.getElementById('is_orderable');
    const stockFields = document.getElementById('stockFields');
    
    orderableSelect.addEventListener('change', function() {
        if (this.value == '1') {
            stockFields.classList.remove('hidden');
            stockFields.classList.add('visible');
        } else {
            stockFields.classList.remove('visible');
            stockFields.classList.add('hidden');
        }
    });
});
</script>
@endsection