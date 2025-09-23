@extends('layouts.app')

@section('content')
<div class="availability-page">
    <h1>Pieejamie Kūpinājumi</h1>
    
    @if($batches->isEmpty())
        <div style="text-align: center; padding: 40px; background: #f8f9fa; border-radius: 8px;">
            <p style="font-size: 1.1em; color: #666;">Šobrīd nav pieejamu žāvējumu.</p>
            <p>Lūdzu, vēlaties vēlāk vai sazinieties ar mums pa telefonu!</p>
        </div>
    @else
        @foreach($batches as $batch)
        <div class="batch-section" style="border: 2px solid {{ $batch->status == 'available' ? '#28a745' : '#ffc107' }}; border-radius: 8px; padding: 20px; margin-bottom: 30px; background: white;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                <h2 style="margin: 0; color: #2c3e50;">{{ $batch->name }}</h2>
                <span style="background: {{ $batch->status == 'available' ? '#28a745' : '#ffc107' }}; color: white; padding: 6px 15px; border-radius: 20px; font-weight: bold;">
                    {{ $batch->status == 'available' ? 'PIEEJAMS' : 'GATAVOJAS' }}
                </span>
            </div>
            
            <p style="margin: 5px 0; color: #666;">
                <strong>{{ $batch->status == 'available' ? 'Pieejams no:' : 'Plānots gatavs:' }}</strong> 
                {{ $batch->batch_date->format('d.m.Y H:i') }}
            </p>
            
            @if($batch->description)
            <p style="margin: 10px 0; padding: 10px; background: #f8f9fa; border-radius: 4px;">
                {{ $batch->description }}
            </p>
            @endif

            <h3 style="margin: 20px 0 15px 0; color: #2c3e50;">Pieejamās zivis:</h3>
            
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; min-width: 600px;">
                    <thead>
                        <tr style="background: #2c3e50; color: white;">
                            <th style="padding: 12px; text-align: left; border: 1px solid #34495e;">Zivs</th>
                            <th style="padding: 12px; text-align: center; border: 1px solid #34495e;">Pieejamais daudzums</th>
                            <th style="padding: 12px; text-align: center; border: 1px solid #34495e;">Mērvienība</th>
                            <th style="padding: 12px; text-align: center; border: 1px solid #34495e;">Cena</th>
                            <th style="padding: 12px; text-align: center; border: 1px solid #34495e;">Pasūtīt</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($batch->fishes as $fish)
                        <tr style="border-bottom: 1px solid #ddd;">
                            <td style="padding: 12px; border: 1px solid #ddd;">
                                <strong style="color: #2c3e50;">{{ $fish->name }}</strong>
                                @if($fish->description)
                                <br><small style="color: #666;">{{ $fish->description }}</small>
                                @endif
                            </td>
                            <td style="padding: 12px; text-align: center; border: 1px solid #ddd; font-weight: bold; color: #28a745;">
                                {{ $fish->pivot->available_quantity }}
                            </td>
                            <td style="padding: 12px; text-align: center; border: 1px solid #ddd;">
                                {{ $fish->pivot->unit == 'kg' ? 'kg' : 'gab.' }}
                            </td>
                            <td style="padding: 12px; text-align: center; border: 1px solid #ddd; font-weight: bold;">
                                {{ number_format($fish->price, 2) }} €
                            </td>
                            <td style="padding: 12px; text-align: center; border: 1px solid #ddd;">
                                <a href="tel:+371XXXXXXXX" style="background: {{ $batch->status == 'available' ? '#28a745' : '#ffc107' }}; color: white; padding: 8px 15px; text-decoration: none; border-radius: 4px; display: inline-block;">
                                    📞 Zvanīt pasūtīt
                                </a>
                                <small style="display: block; margin-top: 5px; color: #666;">Tikai pa telefonu</small>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endforeach
    @endif

    <div style="text-align: center; margin-top: 30px; padding: 20px; background: #e8f4fd; border-radius: 8px;">
        <h3 style="color: #2c3e50;">Kā pasūtīt?</h3>
        <p>Zvaniet mums pa telefonu: <strong style="font-size: 1.2em;">+371 XXXXXXXX</strong></p>
        <p>Darba laiks: P-P 9:00-18:00</p>
    </div>
</div>


@endsection