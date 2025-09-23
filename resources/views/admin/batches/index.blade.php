@extends('layouts.app')

@section('content')
<div class="batch-management">
     <h2>Žāvējumu Pārvaldība</h2>

     <div style="margin-bottom: 20px;">
          <a href="{{ route('admin.batches.create') }}" class="btn btn-primary">+ Jauns žāvējums</a>
     </div>

     @if($batches->isEmpty())
     <p>Vēl nav izveidotu žāvējumu.</p>
     @else
     <div class="batches-list">
          @foreach($batches as $batch)
          <div class="batch-card" style="border: 2px solid {{ $batch->status_color }}; border-radius: 8px; padding: 15px; margin-bottom: 25px; background: white;">
               <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                    <h3 style="margin: 0; color: #333;">{{ $batch->name }}</h3>
                    <span style="background: {{ $batch->status_color }}; color: white; padding: 4px 12px; border-radius: 20px; font-size: 0.9em;">
                         {{ $batch->status_text }}
                    </span>
               </div>

               <p style="margin: 5px 0; color: #666;">
                    <strong>Datums:</strong> {{ $batch->batch_date->format('d.m.Y H:i') }}
               </p>

               @if($batch->description)
               <p style="margin: 5px 0; color: #666;">
                    <strong>Apraksts:</strong> {{ $batch->description }}
               </p>
               @endif

               <h4 style="margin: 15px 0 10px 0;">Zivis šajā žāvējumā:</h4>

               @if($batch->fishes->isEmpty())
               <p style="color: #999;">Nav pievienotu zivju</p>
               @else
               <table style="width: 100%; border-collapse: collapse; margin: 10px 0;">
                    <thead>
                         <tr style="background: #f8f9fa;">
                              <th style="padding: 10px; text-align: left; border: 1px solid #ddd;">Zivs</th>
                              <th style="padding: 10px; text-align: center; border: 1px solid #ddd;">Kopējais daudzums</th>
                              <th style="padding: 10px; text-align: center; border: 1px solid #ddd;">Pieejams</th>
                              <th style="padding: 10px; text-align: center; border: 1px solid #ddd;">Mērvienība</th>
                         </tr>
                    </thead>
                    <tbody>
                         @foreach($batch->fishes as $fish)
                         <tr>
                              <td style="padding: 10px; border: 1px solid #ddd;">
                                   <strong>{{ $fish->name }}</strong>
                              </td>
                              <td style="padding: 10px; text-align: center; border: 1px solid #ddd;">
                                   {{ $fish->pivot->quantity }}
                              </td>
                              <td style="padding: 10px; text-align: center; border: 1px solid #ddd; color: {{ $fish->pivot->available_quantity > 0 ? '#28a745' : '#dc3545' }}; font-weight: bold;">
                                   {{ $fish->pivot->available_quantity }}
                              </td>
                              <td style="padding: 10px; text-align: center; border: 1px solid #ddd;">
                                   {{ $fish->pivot->unit == 'kg' ? 'kg' : 'gab.' }}
                              </td>
                         </tr>
                         @endforeach
                    </tbody>
               </table>
               @endif

               <div style="margin-top: 15px; display: flex; gap: 10px; align-items: center; justify-content: space-between;">
                    <div style="display: flex; gap: 10px; align-items: center;">
                         <span style="font-weight: bold;">Mainīt statusu:</span>
                         <form action="{{ route('admin.batches.update-status', $batch) }}" method="POST" style="display: inline;">
                              @csrf @method('PATCH')
                              <select name="status" onchange="this.form.submit()" style="padding: 5px; border: 1px solid #ddd; border-radius: 4px;">
                                   <option value="preparing" {{ $batch->status == 'preparing' ? 'selected' : '' }}>Gatavošanā</option>
                                   <option value="available" {{ $batch->status == 'available' ? 'selected' : '' }}>Pieejams</option>
                                   <option value="sold_out" {{ $batch->status == 'sold_out' ? 'selected' : '' }}>Izpārdots</option>
                              </select>
                         </form>
                    </div>

                    <!-- Delete Button -->
                    <form action="{{ route('admin.batches.destroy', $batch) }}" method="POST" style="display: inline;">
                         @csrf
                         @method('DELETE')
                         <button type="submit" onclick="return confirm('Vai tiešām vēlaties dzēst šo žāvējumu?')" class="delete-btn">
                              Dzēst žāvējumu
                         </button>
                    </form>
               </div>
          </div>
          @endforeach
     </div>
     @endif
</div>

<!-- Add some JavaScript for better confirmation dialog -->
<script>
     function confirmDelete() {
          return confirm('Vai tiešām vēlaties dzēst šo žāvējumu? Šo darbību nevarēs atsaukt!');
     }
</script>
@endsection