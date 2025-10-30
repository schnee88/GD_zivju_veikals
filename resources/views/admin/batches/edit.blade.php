@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Rediģēt žāvējumu: {{ $batch->name }}</h1>

        @if ($errors->any())
            <div class="alert alert-error">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.batches.update', $batch) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Nosaukums:</label>
                <input type="text" name="name" id="name" value="{{ old('name', $batch->name) }}" required>
            </div>

            <div class="form-group">
                <label for="description">Apraksts:</label>
                <textarea name="description" id="description"
                    style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; height: 100px; box-sizing: border-box;">{{ old('description', $batch->description) }}</textarea>
            </div>

            <div class="form-group">
                <label for="batch_date">Žāvēšanas datums:</label>
                <input type="text" name="batch_date" id="batch_date"
                    value="{{ old('batch_date', $batch->batch_date->format('d/m/Y H:i')) }}" required
                    placeholder="DD/MM/YYYY HH:MM (piemēram: 31/12/2023 14:30)"
                    style="padding: 8px; border: 1px solid #ddd; border-radius: 4px; width: 100%; box-sizing: border-box;">
            </div>

            <h3 style="margin: 30px 0 15px 0;">Zivis žāvējumā</h3>

            <div id="fishes-container">
                @foreach($batch->fishes as $index => $fish)
                    <div class="fish-row"
                        style="border: 1px solid #ddd; padding: 20px; margin-bottom: 20px; border-radius: 8px; background: #f9f9f9;">
                        <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr auto; gap: 20px; align-items: start;">
                            <div class="form-group">
                                <label>Zivs:</label>
                                <select name="fishes[{{ $index }}][fish_id]" required
                                    style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; height: 40px;">
                                    <option value="">Izvēlieties zivi</option>
                                    @foreach($fishes as $fishOption)
                                        <option value="{{ $fishOption->id }}" {{ $fishOption->id == $fish->id ? 'selected' : '' }}>
                                            {{ $fishOption->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Kopējais daudzums:</label>
                                <input type="number" name="fishes[{{ $index }}][quantity]"
                                    value="{{ old('fishes.' . $index . '.quantity', $fish->pivot->quantity) }}" step="0.01" min="0"
                                    required oninput="updateAvailableMax(this)"
                                    style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
                            </div>

                            <div class="form-group">
                                <label>Pieejamais daudzums:</label>
                                <input type="number" name="fishes[{{ $index }}][available_quantity]"
                                    value="{{ old('fishes.' . $index . '.available_quantity', $fish->pivot->available_quantity) }}"
                                    step="0.01" min="0" required oninput="validateAvailableQuantity(this)"
                                    style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
                                <small style="color: #666; font-size: 12px; display: block; margin-top: 5px;">
                                    Maksimāli: <span class="max-value">{{ $fish->pivot->quantity }}</span>
                                </small>
                            </div>

                            <div class="form-group">
                                <label>Mērvienība:</label>
                                <select name="fishes[{{ $index }}][unit]" required
                                    style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; height: 40px;">
                                    <option value="kg" {{ $fish->pivot->unit == 'kg' ? 'selected' : '' }}>kg</option>
                                    <option value="pieces" {{ $fish->pivot->unit == 'pieces' ? 'selected' : '' }}>gab.</option>
                                </select>
                            </div>

                            <div style="display: flex; align-items: center; height: 40px; margin-top: 25px;">
                                <button type="button" class="remove-fish delete-btn">
                                    Dzēst
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <button type="button" id="add-fish" class="edit-btn" style="margin-bottom: 30px;">
                + Pievienot zivi
            </button>

            <div style="display: flex; gap: 15px; margin-top: 30px;">
                <button type="submit" class="edit-btn" style="padding: 12px 25px;">
                    Atjaunināt žāvējumu
                </button>

                <a href="{{ route('admin.batches.index') }}"
                    style="background: #6c757d; color: white; padding: 12px 25px; border-radius: 4px; text-decoration: none; display: inline-block;">
                    Atcelt
                </a>
            </div>
        </form>
    </div>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let fishIndex = {{ $batch->fishes->count() }};

            flatpickr("#batch_date", {
                enableTime: true,
                dateFormat: "d/m/Y H:i",
                time_24hr: true,
                minuteIncrement: 1,
                defaultDate: "{{ $batch->batch_date->format('d/m/Y H:i') }}"
            });

            // Pievienot jaunu zivi
            document.getElementById('add-fish').addEventListener('click', function () {
                const container = document.getElementById('fishes-container');
                const newRow = document.createElement('div');
                newRow.className = 'fish-row';
                newRow.innerHTML = `
                <div style="border: 1px solid #ddd; padding: 20px; margin-bottom: 20px; border-radius: 8px; background: #f9f9f9;">
                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr auto; gap: 20px; align-items: start;">
                        <div class="form-group">
                            <label>Zivs:</label>
                            <select name="fishes[${fishIndex}][fish_id]" required 
                                    style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; height: 40px;">
                                <option value="">Izvēlieties zivi</option>
                                @foreach($fishes as $fishOption)
                                    <option value="{{ $fishOption->id }}">{{ $fishOption->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Kopējais daudzums:</label>
                            <input type="number" name="fishes[${fishIndex}][quantity]" 
                                   step="0.01" min="0" required 
                                   oninput="updateAvailableMax(this)"
                                   style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
                        </div>

                        <div class="form-group">
                            <label>Pieejamais daudzums:</label>
                            <input type="number" name="fishes[${fishIndex}][available_quantity]" 
                                   step="0.01" min="0" required 
                                   oninput="validateAvailableQuantity(this)"
                                   style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
                            <small style="color: #666; font-size: 12px; display: block; margin-top: 5px;">
                                Maksimāli: <span class="max-value">0</span>
                            </small>
                        </div>

                        <div class="form-group">
                            <label>Mērvienība:</label>
                            <select name="fishes[${fishIndex}][unit]" required 
                                    style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; height: 40px;">
                                <option value="kg">kg</option>
                                <option value="pieces">gab.</option>
                            </select>
                        </div>

                        <div style="display: flex; align-items: center; height: 40px; margin-top: 25px;">
                            <button type="button" class="remove-fish delete-btn">
                                Dzēst
                            </button>
                        </div>
                    </div>
                </div>
            `;

                container.appendChild(newRow);
                fishIndex++;
            });

            // Dzēst zivi
            document.addEventListener('click', function (e) {
                if (e.target.classList.contains('remove-fish')) {
                    if (confirm('Vai tiešām vēlaties dzēst šo zivi?')) {
                        e.target.closest('.fish-row').remove();
                    }
                }
            });

            document.querySelectorAll('input[name*="[quantity]"]').forEach(input => {
                updateAvailableMax(input);
            });
        });

        function updateAvailableMax(quantityInput) {
            const fishRow = quantityInput.closest('.fish-row');
            const availableInput = fishRow.querySelector('input[name*="[available_quantity]"]');
            const maxValueSpan = fishRow.querySelector('.max-value');
            const quantity = parseFloat(quantityInput.value) || 0;

            maxValueSpan.textContent = quantity;

            const currentAvailable = parseFloat(availableInput.value) || 0;
            if (currentAvailable > quantity) {
                availableInput.value = quantity;
            }

            availableInput.max = quantity;
        }

        function validateAvailableQuantity(availableInput) {
            const fishRow = availableInput.closest('.fish-row');
            const quantityInput = fishRow.querySelector('input[name*="[quantity]"]');
            const quantity = parseFloat(quantityInput.value) || 0;
            const available = parseFloat(availableInput.value) || 0;

            if (available > quantity) {
                availableInput.style.borderColor = '#dc3545';
                availableInput.style.backgroundColor = '#f8d7da';
            } else {
                availableInput.style.borderColor = '#ddd';
                availableInput.style.backgroundColor = '';
            }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
@endsection