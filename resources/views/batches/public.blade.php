@extends('layouts.app')

@section('content')
    <div class="production-plan-page">
        <h1>Plānotās ražošanas partijas</h1>

        @if($batches->isEmpty())
            <div style="text-align: center; padding: 40px; background: #f8f9fa; border-radius: 8px; margin: 20px 0;">
                <p style="font-size: 1.1em; color: #666;">Šobrīd nav plānotu ražošanas partiju.</p>
                <p style="color: #999;">Ja vēlaties kādu produktu, lūdzu sazinieties ar mums!</p>
            </div>
        @else
            <div class="batches-list">
                @foreach($batches as $batch)
                    <div class="batch-card"
                        style="border: 3px solid #3498db; border-radius: 12px; padding: 20px; margin-bottom: 30px; background: white; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">

                        <div
                            style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; padding-bottom: 15px; border-bottom: 2px solid #f0f0f0;">
                            <h2 style="margin: 0; color: #2c3e50; font-size: 1.5em;">{{ $batch->name }}</h2>
                            <span
                                style="background: #3498db; color: white; padding: 8px 16px; border-radius: 20px; font-size: 0.95em; font-weight: bold;">
                                🗓️ PLĀNOTS
                            </span>
                        </div>

                        <div style="margin-bottom: 20px;">
                            <p style="margin: 8px 0; color: #555; font-size: 1em;">
                                <strong style="color: #2c3e50;">📅 Izgatavošanas datus:</strong>
                                {{ $batch->batch_date->format('d.m.Y H:i') }}
                            </p>

                            @if($batch->description)
                                <div
                                    style="margin: 15px 0; padding: 15px; background: #f8f9fa; border-left: 4px solid #3498db; border-radius: 4px;">
                                    <p style="margin: 0; color: #555; line-height: 1.6;">{{ $batch->description }}</p>
                                </div>
                            @endif
                        </div>

                        <div style="background: #f8f9fa; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                            <h3 style="margin: 0 0 15px 0; color: #2c3e50; font-size: 1.2em;">🐟 Plānotās zivis:</h3>

                            <div style="overflow-x: auto;">
                                <table
                                    style="width: 100%; border-collapse: collapse; background: white; border-radius: 6px; overflow: hidden; min-width: 600px;">
                                    <thead>
                                        <tr style="background: #2c3e50; color: white;">
                                            <th style="padding: 12px; text-align: left;">Zivs</th>
                                            <th style="padding: 12px; text-align: center;">Plānotais daudzums</th>
                                            <th style="padding: 12px; text-align: center;">Mērvienība</th>
                                            <th style="padding: 12px; text-align: center;">Paredzamā cena</th>
                                            <th style="padding: 12px; text-align: center;">Rezervēt</th>
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
                                                <td
                                                    style="padding: 12px; text-align: center; font-weight: bold; color: #3498db; font-size: 1.1em;">
                                                    {{ $fish->pivot->quantity }}
                                                </td>
                                                <td style="padding: 12px; text-align: center; color: #555;">
                                                    {{ $fish->pivot->unit == 'kg' ? 'kg' : 'gab.' }}
                                                </td>
                                                <td
                                                    style="padding: 12px; text-align: center; font-weight: bold; color: #2c3e50; font-size: 1.1em;">
                                                    {{ number_format($fish->price, 2) }} €
                                                </td>
                                                <td style="padding: 12px; text-align: center;">
                                                    @auth
                                                        <form action="{{ route('cart.add') }}" method="POST" style="display: inline-block;">
                                                            @csrf
                                                            <input type="hidden" name="batch_id" value="{{ $batch->id }}">
                                                            <input type="hidden" name="fish_id" value="{{ $fish->id }}">
                                                            <input type="number" name="quantity"
                                                                value="{{ $fish->pivot->unit == 'kg' ? '0.5' : '1' }}"
                                                                min="{{ $fish->pivot->unit == 'kg' ? '0.1' : '1' }}"
                                                                max="{{ $fish->pivot->quantity }}"
                                                                step="{{ $fish->pivot->unit == 'kg' ? '0.1' : '1' }}"
                                                                style="width: 70px; padding: 5px; border: 1px solid #ddd; border-radius: 4px; margin-right: 5px;">
                                                            <button type="submit"
                                                                style="background: #e67e22; color: white; padding: 8px 16px; border: none; border-radius: 6px; cursor: pointer; font-weight: bold; transition: background 0.3s;">
                                                                📋 Rezervēt
                                                            </button>
                                                        </form>
                                                        <small style="display: block; margin-top: 5px; color: #666; font-size: 0.85em;">
                                                            Iepriekšēja rezervācija
                                                        </small>
                                                    @else
                                                        <a href="{{ route('login') }}"
                                                            style="background: #3498db; color: white; padding: 10px 16px; text-decoration: none; border-radius: 6px; display: inline-block; font-weight: bold; transition: background 0.3s; white-space: nowrap;">
                                                            🔐 Pieteikties
                                                        </a>
                                                        <small style="display: block; margin-top: 5px; color: #999; font-size: 0.85em;">lai
                                                            rezervētu</small>
                                                    @endauth
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div
                            style="background: #fff3cd; border: 1px solid #ffeaa7; border-radius: 6px; padding: 15px; margin-top: 15px;">
                            <p style="margin: 0; color: #856404; font-size: 0.95em;">
                                <strong>💡 Rezervācijas informācija:</strong>
                                Rezervējiet produktus jau tagad! Mēs ar jums sazināsimies, kad partija būs gatava.
                            </p>
                        </div>

                    </div>
                @endforeach
            </div>
        @endif

        <div
            style="text-align: center; margin-top: 40px; padding: 25px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px; color: white; box-shadow: 0 4px 8px rgba(0,0,0,0.15);">
            <h3 style="margin: 0 0 15px 0; font-size: 1.4em;">ℹ️ Kā strādā rezervācijas?</h3>
            <p style="margin: 10px 0; font-size: 1.05em;">1. Rezervējiet vēlamos produktus</p>
            <p style="margin: 10px 0; font-size: 1.05em;">2. Mēs ar jums sazināsimies, kad partija būs gatava</p>
            <p style="margin: 10px 0; font-size: 1.05em;">3. Maksājums notiek preces saņemšanas brīdī</p>
            <p style="margin: 10px 0; font-size: 0.95em; opacity: 0.9;">⏰ Darba laiks: Pirmdiena-Piektdiena 9:00-18:00</p>
        </div>
    </div>
@endsection