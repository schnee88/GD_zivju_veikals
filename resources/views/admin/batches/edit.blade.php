@extends('layouts.app')

@section('content')

<div class="max-w-5xl mx-auto">
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 mb-2 flex items-center gap-3">
                <span class="text-4xl">✏️</span>
                <span>Rediģēt: {{ $batch->name }}</span>
            </h1>
            <p class="text-gray-600">Atjauniniet partijas informāciju</p>
        </div>
        <a href="{{ route('admin.batches.index') }}"
            class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors font-medium">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            <span>Atpakaļ</span>
        </a>
    </div>

    <!-- Errors Display -->
    @if ($errors->any())
    <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-lg shadow-sm">
        <div class="flex items-start gap-3">
            <span class="text-2xl">⚠️</span>
            <div>
                <h3 class="font-bold text-red-800 mb-2">Lūdzu, labojiet kļūdas:</h3>
                <ul class="list-disc list-inside space-y-1 text-red-700">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif

    <!-- Form Card -->
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
        <form action="{{ route('admin.batches.update', $batch) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="p-6 md:p-8 space-y-8">
                <div>
                    <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <span>📝</span>
                        <span>Pamata informācija</span>
                    </h2>

                    <div class="space-y-6">
                        <div>
                            <label for="name" class="block text-sm font-bold text-gray-700 mb-2">
                                Nosaukums <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="text"
                                name="name"
                                id="name"
                                value="{{ old('name', $batch->name) }}"
                                required
                                class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-300 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all outline-none">
                        </div>

                        <div>
                            <label for="batch_date" class="block text-sm font-bold text-gray-700 mb-2">
                                Žāvēšanas datums un laiks <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="text"
                                name="batch_date"
                                id="batch_date"
                                value="{{ old('batch_date', $batch->batch_date->format('d/m/Y H:i')) }}"
                                required
                                class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-300 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all outline-none"
                                placeholder="DD/MM/YYYY HH:MM">
                            <p class="mt-2 text-sm text-gray-600">
                                Formāts: DD/MM/YYYY HH:MM (piemēram: 31/12/2026 14:30)
                            </p>
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-bold text-gray-700 mb-2">
                                Apraksts (neobligāts)
                            </label>
                            <textarea
                                name="description"
                                id="description"
                                rows="3"
                                class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-300 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all outline-none resize-none">{{ old('description', $batch->description) }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Fish Management -->
                <div class="pt-8 border-t border-gray-200">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                            <span>🐟</span>
                            <span>Zivis žāvējumā</span>
                        </h2>
                        <button type="button"
                            id="add-fish"
                            class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-semibold text-sm flex items-center gap-2">
                            <span>➕</span>
                            <span>Pievienot zivi</span>
                        </button>
                    </div>

                    <div id="fishes-container" class="space-y-4">
                        @foreach($batch->fishes as $index => $fish)
                        <div class="fish-row p-4 bg-gray-50 rounded-xl border-2 border-gray-200">
                            <div class="grid md:grid-cols-12 gap-4">
                                <!-- Fish Select -->
                                <div class="md:col-span-5">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Zivs *</label>
                                    <select name="fishes[{{ $index }}][fish_id]"
                                        required
                                        class="w-full px-4 py-3 bg-white border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all outline-none">
                                        <option value="">Izvēlieties zivi</option>
                                        @foreach($fishes as $fishOption)
                                        <option value="{{ $fishOption->id }}" {{ $fishOption->id == $fish->id ? 'selected' : '' }}>
                                            {{ $fishOption->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Quantity -->
                                <div class="md:col-span-3">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Daudzums *</label>
                                    <input type="number"
                                        name="fishes[{{ $index }}][quantity]"
                                        value="{{ old('fishes.' . $index . '.quantity', $fish->pivot->quantity) }}"
                                        step="0.01"
                                        min="0"
                                        required
                                        class="w-full px-4 py-3 bg-white border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all outline-none">
                                </div>

                                <!-- Unit -->
                                <div class="md:col-span-3">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Mērvienība *</label>
                                    <select name="fishes[{{ $index }}][unit]"
                                        required
                                        class="w-full px-4 py-3 bg-white border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all outline-none">
                                        <option value="kg" {{ $fish->pivot->unit == 'kg' ? 'selected' : '' }}>kg</option>
                                        <option value="pieces" {{ $fish->pivot->unit == 'pieces' ? 'selected' : '' }}>gab.</option>
                                    </select>
                                </div>

                                <!-- Remove Button -->
                                <div class="md:col-span-1 flex items-end">
                                    <button type="button"
                                        class="remove-fish w-full px-3 py-3 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 border-2 border-red-200 transition-colors font-bold">
                                        ×
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="px-6 md:px-8 py-6 bg-gray-50 border-t border-gray-200 flex flex-col sm:flex-row gap-3">
                <button
                    type="submit"
                    class="flex-1 px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-xl font-bold hover:from-green-700 hover:to-green-800 transition-all shadow-lg hover:shadow-xl flex items-center justify-center gap-2">
                    <span>💾</span>
                    <span>Saglabāt izmaiņas</span>
                </button>
                <a href="{{ route('admin.batches.index') }}"
                    class="flex-1 sm:flex-initial px-6 py-3 bg-gray-200 text-gray-700 text-center rounded-xl font-bold hover:bg-gray-300 transition-colors">
                    Atcelt
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Flatpickr CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let fishIndex = {
            {
                $batch - > fishes - > count()
            }
        };

        // Initialize Flatpickr
        flatpickr("#batch_date", {
            enableTime: true,
            dateFormat: "d/m/Y H:i",
            time_24hr: true,
            minuteIncrement: 1,
            defaultDate: "{{ $batch->batch_date->format('d/m/Y H:i') }}"
        });

        // Add new fish row
        document.getElementById('add-fish').addEventListener('click', function() {
            const container = document.getElementById('fishes-container');
            const newRow = document.createElement('div');
            newRow.className = 'fish-row p-4 bg-gray-50 rounded-xl border-2 border-gray-200';
            newRow.innerHTML = `
                <div class="grid md:grid-cols-12 gap-4">
                    <div class="md:col-span-5">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Zivs *</label>
                        <select name="fishes[${fishIndex}][fish_id]" 
                                required
                                class="w-full px-4 py-3 bg-white border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all outline-none">
                            <option value="">Izvēlieties zivi</option>
                            @foreach($fishes as $fishOption)
                                <option value="{{ $fishOption->id }}">{{ $fishOption->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="md:col-span-3">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Daudzums *</label>
                        <input type="number" 
                               name="fishes[${fishIndex}][quantity]" 
                               step="0.01" 
                               min="0" 
                               required
                               class="w-full px-4 py-3 bg-white border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all outline-none">
                    </div>
                    <div class="md:col-span-3">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Mērvienība *</label>
                        <select name="fishes[${fishIndex}][unit]" 
                                required
                                class="w-full px-4 py-3 bg-white border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all outline-none">
                            <option value="kg">kg</option>
                            <option value="pieces">gab.</option>
                        </select>
                    </div>
                    <div class="md:col-span-1 flex items-end">
                        <button type="button" 
                                class="remove-fish w-full px-3 py-3 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 border-2 border-red-200 transition-colors font-bold">
                            ×
                        </button>
                    </div>
                </div>
            `;

            container.appendChild(newRow);
            fishIndex++;
        });

        // Remove fish row
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-fish') || e.target.closest('.remove-fish')) {
                const button = e.target.classList.contains('remove-fish') ? e.target : e.target.closest('.remove-fish');
                const rows = document.querySelectorAll('.fish-row');

                if (rows.length > 1) {
                    if (confirm('Vai tiešām vēlaties dzēst šo zivi?')) {
                        button.closest('.fish-row').remove();
                    }
                } else {
                    alert('Jābūt vismaz vienai zivij partijā!');
                }
            }
        });
    });
</script>
@endpush

@endsection