@extends('layouts.app')

@section('content')
<div class="availability-page">
    <h1>Pieejamie Kūpinājumi</h1>

    @if($batches->isEmpty())
    <div style="text-align: center; padding: 40px; background: #f8f9fa; border-radius: 8px; margin: 20px 0;">
        <p style="font-size: 1.1em; color: #666;">Šobrīd nav pieejamu kūpinājumu.</p>
        <p style="color: #999;">Lūdzu, apmeklējiet vēlāk vai sazinieties ar mums pa telefonu!</p>
    </div>
    @else
    <div class="batches-list">
        @foreach($batches as $batch)
        <div class="batch-card" style="border: 3px solid {{ $batch->status == 'available' ? '#27ae60' : '#f39c12' }}; border-radius: 12px; padding: 20px; margin-bottom: 30px; background: white; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">

            <!-- Header, status -->
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; padding-bottom: 15px; border-bottom: 2px solid #f0f0f0;">
                <h2 style="margin: 0; color: #2c3e50; font-size: 1.5em;">{{ $batch->name }}</h2>
                <span style="background: {{ $batch->status == 'available' ? '#27ae60' : '#f39c12' }}; color: white; padding: 8px 16px; border-radius: 20px; font-size: 0.95em; font-weight: bold;">
                    {{ $batch->status == 'available' ? '✓ PIEEJAMS' : '⏱ GATAVOJAS' }}
                </span>
            </div>

            <!-- Date and descript -->
            <div style="margin-bottom: 20px;">
                <p style="margin: 8px 0; color: #555; font-size: 1em;">
                    <strong style="color: #2c3e50;">📅 {{ $batch->status == 'available' ? 'Pieejams no:' : 'Plānots gatavs:' }}</strong>
                    {{ $batch->batch_date->format('d.m.Y H:i') }}
                </p>

                @if($batch->description)
                <div style="margin: 15px 0; padding: 15px; background: #f8f9fa; border-left: 4px solid {{ $batch->status == 'available' ? '#27ae60' : '#f39c12' }}; border-radius: 4px;">
                    <p style="margin: 0; color: #555; line-height: 1.6;">{{ $batch->description }}</p>
                </div>
                @endif
            </div>

            <!-- Fish list section -->
            <div style="background: #f8f9fa; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                <h3 style="margin: 0 0 15px 0; color: #2c3e50; font-size: 1.2em;">🐟 Pieejamās zivis:</h3>

                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse; background: white; border-radius: 6px; overflow: hidden; min-width: 650px;">
                        <thead>
                            <tr style="background: #2c3e50; color: white;">
                                <th style="padding: 12px; text-align: left;">Zivs</th>
                                <th style="padding: 12px; text-align: center;">Pieejams</th>
                                <th style="padding: 12px; text-align: center;">Mērvienība</th>
                                <th style="padding: 12px; text-align: center;">Cena</th>
                                <th style="padding: 12px; text-align: center;">Darbības</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($batch->fishes as $fish)
                            <tr style="border-bottom: 1px solid #e9ecef;">
                                <td style="padding: 12px;">
                                    <strong style="color: #2c3e50; font-size: 1.05em;">{{ $fish->name }}</strong>
                                    @if($fish->description)
                                    <br><small style="color: #666; line-height: 1.4;">{{ $fish->description }}</small>
                                    @endif
                                </td>
                                <td style="padding: 12px; text-align: center; font-weight: bold; color: {{ $fish->pivot->available_quantity > 0 ? '#27ae60' : '#e74c3c' }}; font-size: 1.1em;">
                                    {{ $fish->pivot->available_quantity }}
                                </td>
                                <td style="padding: 12px; text-align: center; color: #555;">
                                    {{ $fish->pivot->unit == 'kg' ? 'kg' : 'gab.' }}
                                </td>
                                <td style="padding: 12px; text-align: center; font-weight: bold; color: #2c3e50; font-size: 1.1em;">
                                    {{ number_format($fish->price, 2) }} €
                                </td>
                                <td style="padding: 12px; text-align: center;">
                                    @auth
                                    @if($batch->status == 'available' && $fish->pivot->available_quantity > 0)
                                    <form action="{{ route('cart.add') }}" method="POST" style="display: inline-block;">
                                        @csrf
                                        <input type="hidden" name="batch_id" value="{{ $batch->id }}">
                                        <input type="hidden" name="fish_id" value="{{ $fish->id }}">
                                        <input type="number"
                                            name="quantity"
                                            value="1"
                                            min="{{ $fish->pivot->unit == 'kg' ? '0.1' : '1' }}"
                                            max="{{ $fish->pivot->available_quantity }}"
                                            step="{{ $fish->pivot->unit == 'kg' ? '0.1' : '1' }}"
                                            style="width: 70px; padding: 5px; border: 1px solid #ddd; border-radius: 4px; margin-right: 5px;">
                                        <button type="submit"
                                            style="background: #27ae60; color: white; padding: 8px 16px; border: none; border-radius: 6px; cursor: pointer; font-weight: bold; transition: background 0.3s;">
                                            🛒 Grozā
                                        </button>
                                    </form>
                                    @else
                                    <span style="color: #999; font-style: italic; font-size: 0.9em;">
                                        {{ $fish->pivot->available_quantity <= 0 ? 'Nav pieejams' : 'Vēl nav gatavs' }}
                                    </span>
                                    @endif
                                    @else
                                    <a href="{{ route('login') }}"
                                        style="background: #3498db; color: white; padding: 10px 16px; text-decoration: none; border-radius: 6px; display: inline-block; font-weight: bold; transition: background 0.3s; white-space: nowrap;">
                                        🔐 Pieteikties
                                    </a>
                                    <small style="display: block; margin-top: 5px; color: #999; font-size: 0.85em;">lai pievienotu grozam</small>
                                    @endauth
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        @endforeach
    </div>
    @endif

    <!-- Contact info box -->
    <div style="text-align: center; margin-top: 40px; padding: 25px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px; color: white; box-shadow: 0 4px 8px rgba(0,0,0,0.15);">
        <h3 style="margin: 0 0 15px 0; font-size: 1.4em;">ℹ️ Informācija</h3>
        <p style="margin: 10px 0; font-size: 1.05em;">Rezervējiet zivis tiešsaistē un mēs sazināsimies ar jums!</p>
        <p style="margin: 10px 0; font-size: 0.95em; opacity: 0.9;">Maksājums notiek tikai saņemot preci klātienē.</p>
        <p style="margin: 10px 0; font-size: 0.95em; opacity: 0.9;">⏰ Darba laiks: Pirmdiena-Piektdiena 9:00-18:00</p>
    </div>
</div>
@endsection