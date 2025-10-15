@extends('layouts.app')

@section('content')
<div class="admin-container compact-form">
    <div class="admin-header">
        <h1>Pievienot jaunu zivi</h1>
        <a href="{{ route('admin.fish.index') }}" class="btn btn-secondary btn-sm">
            ← Atpakaļ uz sarakstu
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success">
        ✅ {{ session('success') }}
    </div>
    @endif

    <div class="form-container">
        <form action="{{ route('admin.fish.store') }}" method="POST" enctype="multipart/form-data" class="fish-form">
            @csrf
            <div class="form-grid">
                <!-- Basic Info -->
                <div class="form-group">
                    <label for="name" class="form-label">Nosaukums *</label>
                    <input type="text" name="name" id="name" class="form-input @error('name') error @enderror" 
                           value="{{ old('name') }}" required>
                    @error('name')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="price" class="form-label">Cena (€) *</label>
                    <input type="number" step="0.01" name="price" id="price" class="form-input @error('price') error @enderror" 
                           value="{{ old('price') }}" required>
                    @error('price')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                <!-- Order Settings -->
                <div class="form-group">
                    <label for="is_orderable" class="form-label">Statuss *</label>
                    <select name="is_orderable" id="is_orderable" class="form-input @error('is_orderable') error @enderror">
                        <option value="0" {{ old('is_orderable') == '0' ? 'selected' : '' }}>
                            ❌ Tikai katalogā
                        </option>
                        <option value="1" {{ old('is_orderable') == '1' ? 'selected' : '' }}>
                            ✅ Pasūtāms
                        </option>
                    </select>
                    <div class="form-help">
                        <strong>Pasūtāms:</strong> Zivs redzama pasūtījumu sarakstā un pievienojama grozam<br>
                        <strong>Tikai katalogā:</strong> Zivs redzama tikai informācijas nolūkos
                    </div>
                    @error('is_orderable')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Stock Fields -->
                <div id="stockFields" class="form-group {{ old('is_orderable') == '1' ? 'visible' : 'hidden' }}">
                    <div class="stock-row">
                        <div class="stock-input">
                            <label for="stock_quantity" class="form-label">Daudzums *</label>
                            <input type="number" name="stock_quantity" id="stock_quantity" class="form-input @error('stock_quantity') error @enderror" 
                                   value="{{ old('stock_quantity', 0) }}" min="0" step="0.1">
                        </div>
                        <div class="stock-unit">
                            <label for="stock_unit" class="form-label">Mērvienība *</label>
                            <select name="stock_unit" id="stock_unit" class="form-input @error('stock_unit') error @enderror">
                                <option value="pieces" {{ old('stock_unit') == 'pieces' ? 'selected' : '' }}>gab.</option>
                                <option value="kg" {{ old('stock_unit') == 'kg' ? 'selected' : '' }}>kg</option>
                            </select>
                        </div>
                    </div>
                    @error('stock_quantity') <div class="error-message">{{ $message }}</div> @enderror
                    @error('stock_unit') <div class="error-message">{{ $message }}</div> @enderror
                </div>

                <!-- Description -->
                <div class="form-group full-width">
                    <label for="description" class="form-label">Apraksts</label>
                    <textarea name="description" id="description" class="form-input form-textarea @error('description') error @enderror" 
                              rows="3" placeholder="Īss produkta apraksts...">{{ old('description') }}</textarea>
                    @error('description')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Image -->
                <div class="form-group full-width">
                    <label for="image" class="form-label">Attēls</label>
                    <input type="file" name="image" id="image" class="form-input @error('image') error @enderror" 
                           accept="image/*">
                    <div class="form-help">Atļautie formāti: JPG, PNG, GIF. Maksimālais izmērs: 5MB</div>
                    @error('image')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary btn-sm">
                    ➕ Izveidot zivi
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