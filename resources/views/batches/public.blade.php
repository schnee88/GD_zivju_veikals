@extends('layouts.app')

@section('content')
    <div class="production-plan-page container">
        <div class="admin-header">
            <h1>Plānotās ražošanas partijas</h1>
        </div>

        @if($batches->isEmpty())
            <div class="empty-state">
                <p>Šobrīd nav plānotu ražošanas partiju.</p>
            </div>
        @else
            <div class="batches-list">
                @foreach($batches as $batch)
                    <div class="batch-card">
                        <div class="batch-header">
                            <h2>{{ $batch->name }}</h2>
                            <span class="status-badge" style="background: {{ $batch->status_color }}; color: white;">
                                {{ $batch->status_text }}
                            </span>
                        </div>

                        <div class="batch-info">
                            <p class="batch-date">
                                <strong>📅 Izgatavošanas datums:</strong>
                                {{ $batch->batch_date->format('d.m.Y H:i') }}
                            </p>

                            @if($batch->description)
                                <div class="batch-description">
                                    <p>{{ $batch->description }}</p>
                                </div>
                            @endif
                        </div>

                        <div class="fish-section">
                            <h3>🐟 Plānotās zivis:</h3>

                            <!-- Desktop version (table for larger screens) -->
                            <div class="fish-table-container desktop-only">
                                <table class="fish-table">
                                    <thead>
                                        <tr>
                                            <th>Zivs</th>
                                            <th>Plānotais daudzums</th>
                                            <th>Mērvienība</th>
                                            <th>Paredzamā cena</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($batch->fishes as $fish)
                                            <tr>
                                                <td class="fish-name">
                                                    <strong>{{ $fish->name }}</strong>
                                                    @if($fish->description)
                                                        <br><small>{{ $fish->description }}</small>
                                                    @endif
                                                </td>
                                                <td class="fish-quantity">{{ $fish->pivot->quantity }}</td>
                                                <td class="fish-unit">{{ $fish->pivot->unit == 'kg' ? 'kg' : 'gab.' }}</td>
                                                <td class="fish-price">{{ number_format($fish->price, 2) }} €</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Mobile version (cards for smaller screens) -->
                            <div class="fish-cards-container mobile-only">
                                @foreach($batch->fishes as $fish)
                                    <div class="fish-card-mobile">
                                        <div class="fish-card-header">
                                            <h4>{{ $fish->name }}</h4>
                                        </div>
                                        <div class="fish-card-body">
                                            @if($fish->description)
                                                <p class="fish-description">{{ $fish->description }}</p>
                                            @endif
                                            <div class="fish-details">
                                                <div class="detail-item">
                                                    <span class="detail-label">Daudzums:</span>
                                                    <span class="detail-value">{{ $fish->pivot->quantity }}</span>
                                                </div>
                                                <div class="detail-item">
                                                    <span class="detail-label">Mērvienība:</span>
                                                    <span class="detail-value">{{ $fish->pivot->unit == 'kg' ? 'kg' : 'gab.' }}</span>
                                                </div>
                                                <div class="detail-item">
                                                    <span class="detail-label">Cena:</span>
                                                    <span class="detail-value price">{{ number_format($fish->price, 2) }} €</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="batch-notice">
                            <p><strong>ℹ️ Informācija:</strong> Šī ir plānotā ražošanas partija. Lai iegādātos produktus,
                                apmeklējiet mūsu veikalu.</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="cta-section">
            <h3>🐟 Apskatiet mūsu sortimentu</h3>
            <p>Plānotās partijas sniedz priekšstatu par mūsu ražošanu</p>
            <p>Produktus var iegādāties mūsu veikalā pēc to sagatavošanas</p>
            <a href="{{ route('fish.shop') }}" class="btn btn-primary cta-button">
                🛒 Apmeklēt veikalu
            </a>
            <p class="working-hours">⏰ Darba laiks: Pirmdiena-Piektdiena 9:00-18:00</p>
        </div>
    </div>
@endsection