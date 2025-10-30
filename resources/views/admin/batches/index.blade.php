@extends('layouts.app')

@section('content')
    <div class="batch-management">
        <h1>Produktu partiju pārvaldība</h1>

        <div style="margin-bottom: 30px; text-align: center;">
            <a href="{{ route('admin.batches.create') }}" class="btn btn-primary"
                style="background: #3498db; color: white; padding: 12px 25px; text-decoration: none; border-radius: 6px; display: inline-block; font-weight: bold;">
                + Jauna partija
            </a>
        </div>

        @if($batches->isEmpty())
            <div style="text-align: center; padding: 40px; background: #f8f9fa; border-radius: 8px; margin: 20px 0;">
                <p style="font-size: 1.1em; color: #666;">Vēl nav izveidota neviena partija.</p>
            </div>
        @else
            <div class="batches-list">
                @foreach($batches as $batch)
                    <div class="batch-card"
                        style="border: 3px solid {{ $batch->status_color }}; border-radius: 12px; padding: 20px; margin-bottom: 30px; background: white; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">

                        <div
                            style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; padding-bottom: 15px; border-bottom: 2px solid #f0f0f0;">
                            <h2 style="margin: 0; color: #2c3e50; font-size: 1.5em;">{{ $batch->name }}</h2>
                            <span
                                style="background: {{ $batch->status_color }}; color: white; padding: 8px 16px; border-radius: 20px; font-size: 0.95em; font-weight: bold;">
                                {{ $batch->status_text }}
                            </span>
                        </div>

                        <div style="margin-bottom: 20px;">
                            <p style="margin: 8px 0; color: #555; font-size: 1em;">
                                <strong style="color: #2c3e50;">📅 Datums:</strong> {{ $batch->formatted_batch_date }}
                            </p>

                            @if($batch->description)
                                <p style="margin: 8px 0; color: #555; font-size: 1em;">
                                    <strong style="color: #2c3e50;">📝 Apraksts:</strong> {{ $batch->description }}
                                </p>
                            @endif
                        </div>

                        <div style="background: #f8f9fa; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                            <h3 style="margin: 0 0 15px 0; color: #2c3e50; font-size: 1.2em;">🐟 Zivis šajā žāvējumā:</h3>

                            @if($batch->fishes->isEmpty())
                                <p style="color: #999; font-style: italic; text-align: center; padding: 10px;">Nav pievienotu zivju</p>
                            @else
                                <table
                                    style="width: 100%; border-collapse: collapse; background: white; border-radius: 6px; overflow: hidden;">
                                    <thead>
                                        <tr style="background: #2c3e50; color: white;">
                                            <th style="padding: 12px; text-align: left;">Zivs</th>
                                            <th style="padding: 12px; text-align: center;">Kopējais daudzums</th>
                                            <th style="padding: 12px; text-align: center;">Pieejams</th>
                                            <th style="padding: 12px; text-align: center;">Mērvienība</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($batch->fishes as $fish)
                                            <tr style="border-bottom: 1px solid #e9ecef;">
                                                <td style="padding: 12px;">
                                                    <strong style="color: #2c3e50;">{{ $fish->name }}</strong>
                                                </td>
                                                <td style="padding: 12px; text-align: center; font-weight: bold;">
                                                    {{ $fish->pivot->quantity }}
                                                </td>
                                                <td
                                                    style="padding: 12px; text-align: center; color: {{ $fish->pivot->available_quantity > 0 ? '#27ae60' : '#e74c3c' }}; font-weight: bold; font-size: 1.1em;">
                                                    {{ $fish->pivot->available_quantity }}
                                                </td>
                                                <td style="padding: 12px; text-align: center;">
                                                    {{ $fish->pivot->unit == 'kg' ? 'kg' : 'gab.' }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>

                        <div
                            style="display: flex; justify-content: space-between; align-items: center; gap: 15px; flex-wrap: wrap; padding-top: 15px; border-top: 2px solid #f0f0f0;">

                            <div style="display: flex; gap: 10px; align-items: center;">
                                <span style="font-weight: bold; color: #2c3e50;">Mainīt statusu:</span>
                                <form action="{{ route('admin.batches.update-status', $batch) }}" method="POST"
                                    style="display: inline;">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" onchange="this.form.submit()"
                                        style="padding: 8px 12px; border: 2px solid #ddd; border-radius: 6px; background: white; cursor: pointer; font-size: 0.95em;">
                                        <option value="preparing" {{ $batch->status == 'preparing' ? 'selected' : '' }}>Gatavošanā
                                        </option>
                                        <option value="available" {{ $batch->status == 'available' ? 'selected' : '' }}>Pieejams
                                        </option>
                                        <option value="sold_out" {{ $batch->status == 'sold_out' ? 'selected' : '' }}>Izpārdots
                                        </option>
                                    </select>
                                </form>
                            </div>

                            <div style="display: flex; gap: 10px;">
                                <a href="{{ route('admin.batches.edit', $batch) }}"
                                    style="padding: 10px 20px; background: #27ae60; color: white; text-decoration: none; border-radius: 6px; font-weight: bold; transition: background 0.3s;">
                                    ✏️ Rediģēt
                                </a>
                                <form action="{{ route('admin.batches.destroy', $batch) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        onclick="return confirm('Vai tiešām vēlaties dzēst šo žāvējumu? Šo darbību nevarēs atsaukt!')"
                                        style="padding: 10px 20px; background: #e74c3c; color: white; border: none; border-radius: 6px; cursor: pointer; font-weight: bold; transition: background 0.3s;">
                                        🗑️ Dzēst
                                    </button>
                                </form>
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection