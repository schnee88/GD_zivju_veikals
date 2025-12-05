@extends('layouts.app')

@section('content')

<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 mb-2 flex items-center gap-3">
                <span class="text-4xl">➕</span>
                <span>Pievienot jaunu zivi</span>
            </h1>
            <p class="text-gray-600">Aizpildiet informāciju par jauno produktu</p>
        </div>
        <a href="{{ route('admin.fish.index') }}" 
           class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors font-medium">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            <span>Atpakaļ</span>
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
        <form action="{{ route('admin.fish.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="p-6 md:p-8 space-y-6">
                <div>
                    <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <span>📝</span>
                        <span>Pamata informācija</span>
                    </h2>

                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-bold text-gray-700 mb-2">
                                Nosaukums <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                name="name" 
                                id="name" 
                                value="{{ old('name') }}"
                                required
                                class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-300 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all outline-none @error('name') border-red-500 @enderror"
                                placeholder="Piemēram: Kūpināta līdaka">
                            @error('name')
                                <p class="mt-2 text-sm text-red-600 flex items-center gap-2">
                                    <span>⚠️</span>
                                    <span>{{ $message }}</span>
                                </p>
                            @enderror
                        </div>

                        <div>
                            <label for="price" class="block text-sm font-bold text-gray-700 mb-2">
                                Cena (€ par kg) <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="number" 
                                step="0.01" 
                                name="price" 
                                id="price" 
                                value="{{ old('price') }}"
                                required
                                class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-300 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all outline-none @error('price') border-red-500 @enderror"
                                placeholder="0.00">
                            @error('price')
                                <p class="mt-2 text-sm text-red-600 flex items-center gap-2">
                                    <span>⚠️</span>
                                    <span>{{ $message }}</span>
                                </p>
                            @enderror
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mt-6">
                        <label for="description" class="block text-sm font-bold text-gray-700 mb-2">
                            Apraksts
                        </label>
                        <textarea 
                            name="description" 
                            id="description" 
                            rows="4"
                            class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-300 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all outline-none resize-none @error('description') border-red-500 @enderror"
                            placeholder="Īss produkta apraksts...">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-2 text-sm text-red-600 flex items-center gap-2">
                                <span>⚠️</span>
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>
                </div>

                <!-- Order Settings Section -->
                <div class="pt-6 border-t border-gray-200">
                    <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <span>⚙️</span>
                        <span>Pasūtījumu iestatījumi</span>
                    </h2>

                    <div class="mb-6">
                        <label for="is_orderable" class="block text-sm font-bold text-gray-700 mb-2">
                            Statuss <span class="text-red-500">*</span>
                        </label>
                        <select 
                            name="is_orderable" 
                            id="is_orderable"
                            class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-300 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all outline-none @error('is_orderable') border-red-500 @enderror">
                            <option value="0" {{ old('is_orderable') == '0' ? 'selected' : '' }}>
                                ❌ Tikai katalogā (nav pasūtāms)
                            </option>
                            <option value="1" {{ old('is_orderable') == '1' ? 'selected' : '' }}>
                                ✅ Pasūtāms (redzams veikalā)
                            </option>
                        </select>
                        <p class="mt-2 text-sm text-gray-600">
                            <strong>Pasūtāms:</strong> Produkts būs pieejams veikalā un to varēs pievienot grozam.<br>
                            <strong>Tikai katalogā:</strong> Produkts būs redzams tikai katalogā informācijas nolūkos.
                        </p>
                        @error('is_orderable')
                            <p class="mt-2 text-sm text-red-600 flex items-center gap-2">
                                <span>⚠️</span>
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>
                    
                    <div id="stockFields" class="{{ old('is_orderable') == '1' ? '' : 'hidden' }}">
                        <div class="p-4 bg-blue-50 border border-blue-200 rounded-xl">
                            <h3 class="text-sm font-bold text-gray-900 mb-4 flex items-center gap-2">
                                <span>📦</span>
                                <span>Noliktavas informācija</span>
                            </h3>

                            <div class="grid md:grid-cols-2 gap-4">
                                <!-- Stock Quantity -->
                                <div>
                                    <label for="stock_quantity" class="block text-sm font-bold text-gray-700 mb-2">
                                        Daudzums <span class="text-red-500">*</span>
                                    </label>
                                    <input 
                                        type="number" 
                                        name="stock_quantity" 
                                        id="stock_quantity" 
                                        value="{{ old('stock_quantity', 0) }}"
                                        min="0" 
                                        step="0.1"
                                        class="w-full px-4 py-3 bg-white border-2 border-gray-300 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all outline-none @error('stock_quantity') border-red-500 @enderror">
                                    @error('stock_quantity')
                                        <p class="mt-2 text-sm text-red-600 flex items-center gap-2">
                                            <span>⚠️</span>
                                            <span>{{ $message }}</span>
                                        </p>
                                    @enderror
                                </div>

                                <!-- Stock Unit -->
                                <div>
                                    <label for="stock_unit" class="block text-sm font-bold text-gray-700 mb-2">
                                        Mērvienība <span class="text-red-500">*</span>
                                    </label>
                                    <select 
                                        name="stock_unit" 
                                        id="stock_unit"
                                        class="w-full px-4 py-3 bg-white border-2 border-gray-300 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all outline-none @error('stock_unit') border-red-500 @enderror">
                                        <option value="pieces" {{ old('stock_unit') == 'pieces' ? 'selected' : '' }}>gab. (gabali)</option>
                                        <option value="kg" {{ old('stock_unit') == 'kg' ? 'selected' : '' }}>kg (kilogrami)</option>
                                    </select>
                                    @error('stock_unit')
                                        <p class="mt-2 text-sm text-red-600 flex items-center gap-2">
                                            <span>⚠️</span>
                                            <span>{{ $message }}</span>
                                        </p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Image Section -->
                <div class="pt-6 border-t border-gray-200">
                    <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <span>📷</span>
                        <span>Produkta attēls</span>
                    </h2>

                    <div>
                        <label for="image" class="block text-sm font-bold text-gray-700 mb-2">
                            Augšupielādēt attēlu
                        </label>
                        <input 
                            type="file" 
                            name="image" 
                            id="image" 
                            accept="image/*"
                            class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-300 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all outline-none file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 @error('image') border-red-500 @enderror">
                        <p class="mt-2 text-sm text-gray-600">
                            Atļautie formāti: JPG, PNG, GIF. Maksimālais izmērs: 5MB
                        </p>
                        @error('image')
                            <p class="mt-2 text-sm text-red-600 flex items-center gap-2">
                                <span>⚠️</span>
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="px-6 md:px-8 py-6 bg-gray-50 border-t border-gray-200 flex flex-col sm:flex-row gap-3">
                <button 
                    type="submit"
                    class="flex-1 px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl font-bold hover:from-blue-700 hover:to-blue-800 transition-all shadow-lg hover:shadow-xl flex items-center justify-center gap-2">
                    <span>✓</span>
                    <span>Izveidot zivi</span>
                </button>
                <a href="{{ route('admin.fish.index') }}" 
                   class="flex-1 sm:flex-initial px-6 py-3 bg-gray-200 text-gray-700 text-center rounded-xl font-bold hover:bg-gray-300 transition-colors">
                    Atcelt
                </a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const orderableSelect = document.getElementById('is_orderable');
        const stockFields = document.getElementById('stockFields');
        
        orderableSelect.addEventListener('change', function() {
            if (this.value == '1') {
                stockFields.classList.remove('hidden');
            } else {
                stockFields.classList.add('hidden');
            }
        });
    });
</script>
@endpush

@endsection