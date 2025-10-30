@extends('layouts.app')

@section('content')
     <div class="batch-create">
          <h2>Izveidot jaunu partiju</h2>

          <form action="{{ route('admin.batches.store') }}" method="POST" style="max-width: 600px;">
               @csrf

               <div style="margin-bottom: 15px;">
                    <label for="name" style="display: block; margin-bottom: 5px; font-weight: bold;">Nosaukums:</label>
                    <input type="text" name="name" id="name" required
                         style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
               </div>

               <div style="margin-bottom: 15px;">
                    <label for="batch_date" style="display: block; margin-bottom: 5px; font-weight: bold;">Izgatavošanas
                         datums un laiks:</label>
                    <input type="text" name="batch_date" id="batch_date" required
                         placeholder="DD/MM/YYYY HH:MM (piemēram: 31/12/2023 14:30)"
                         value="{{ old('batch_date', now()->format('d/m/Y H:i')) }}"
                         style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
               </div>

               <div style="margin-bottom: 15px;">
                    <label for="description" style="display: block; margin-bottom: 5px; font-weight: bold;">Apraksts
                         (neobligāts):</label>
                    <textarea name="description" id="description" rows="3"
                         style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;"></textarea>
               </div>

               <h3 style="margin: 20px 0 10px 0;">Pievienot zivis:</h3>

               <div id="fishes-container">
                    <div class="fish-row" style="display: flex; gap: 10px; margin-bottom: 10px; align-items: end;">
                         <div style="flex: 2;">
                              <label style="display: block; margin-bottom: 5px; font-size: 0.9em;">Zivs:</label>
                              <select name="fishes[0][fish_id]" required
                                   style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                                   <option value="">Izvēlies zivi</option>
                                   @foreach($fishes as $fish)
                                        <option value="{{ $fish->id }}">{{ $fish->name }}</option>
                                   @endforeach
                              </select>
                         </div>
                         <div style="flex: 1;">
                              <label style="display: block; margin-bottom: 5px; font-size: 0.9em;">Daudzums:</label>
                              <input type="number" name="fishes[0][quantity]" step="0.1" min="0.1" required
                                   style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                         </div>
                         <div style="flex: 1;">
                              <label style="display: block; margin-bottom: 5px; font-size: 0.9em;">Mērvienība:</label>
                              <select name="fishes[0][unit]" required
                                   style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                                   <option value="kg">kg</option>
                                   <option value="pieces">gab.</option>
                              </select>
                         </div>
                         <button type="button" onclick="removeFishRow(this)"
                              style="background: #dc3545; padding: 8px 12px; height: fit-content;">×</button>
                    </div>
               </div>

               <button type="button" onclick="addFishRow()" style="background: #28a745; margin-bottom: 20px;">+ Pievienot vēl
                    zivi</button>

               <div>
                    <button type="submit" style="background: #3498db; padding: 10px 20px;">Izveidot partiju</button>
                    <a href="{{ route('admin.batches.index') }}"
                         style="padding: 10px 20px; margin-left: 10px; background: #6c757d; color: white; text-decoration: none; border-radius: 4px;">Atcelt</a>
               </div>
          </form>
     </div>

     <!-- Flatpickr CSS -->
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

     <script>
          let fishRowCount = 1;

          function addFishRow() {
               const container = document.getElementById('fishes-container');
               const newRow = document.createElement('div');
               newRow.className = 'fish-row';
               newRow.innerHTML = `
                            <div style="display: flex; gap: 10px; margin-bottom: 10px; align-items: end; width: 100%;">
                                <div style="flex: 2;">
                                    <label style="display: block; margin-bottom: 5px; font-size: 0.9em;">Zivs:</label>
                                    <select name="fishes[${fishRowCount}][fish_id]" required style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                                        <option value="">Izvēlies zivi</option>
                                        @foreach($fishes as $fish)
                                                 <option value="{{ $fish->id }}">{{ $fish->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div style="flex: 1;">
                                    <label style="display: block; margin-bottom: 5px; font-size: 0.9em;">Daudzums:</label>
                                    <input type="number" name="fishes[${fishRowCount}][quantity]" step="0.1" min="0.1" required style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                                </div>
                                <div style="flex: 1;">
                                    <label style="display: block; margin-bottom: 5px; font-size: 0.9em;">Mērvienība:</label>
                                    <select name="fishes[${fishRowCount}][unit]" required style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                                        <option value="kg">kg</option>
                                        <option value="pieces">gab.</option>
                                    </select>
                                </div>
                                <button type="button" onclick="removeFishRow(this)" style="background: #dc3545; padding: 8px 12px; height: fit-content;">×</button>
                            </div>
                        `;
               container.appendChild(newRow);
               fishRowCount++;
          }

          function removeFishRow(button) {
               if (document.querySelectorAll('.fish-row').length > 1) {
                    button.closest('.fish-row').remove();
               }
          }

          document.addEventListener('DOMContentLoaded', function () {
               flatpickr("#batch_date", {
                    enableTime: true,
                    dateFormat: "d/m/Y H:i",
                    time_24hr: true,
                    minuteIncrement: 1,
                    defaultDate: "{{ now()->format('d/m/Y H:i') }}"
               });
          });
     </script>

     <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
@endsection