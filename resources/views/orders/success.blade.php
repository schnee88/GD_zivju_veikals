@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/orders.css') }}">

    <div class="admin-container" style="max-width: 800px; margin: 0 auto; padding: 40px 20px;">
        <div class="success-container">
            <div class="success-icon">✅</div>

            <h1 class="success-title">Pasūtījums veiksmīgi izveidots!</h1>

            <p class="success-message">
                Paldies par jūsu pasūtījumu! Mēs esam saņēmuši jūsu pieteikumu un drīzumā sazināsimies ar jums norādītajā
                telefona numurā.
            </p>

            <div class="info-box">
                <h3>Kas notiks tālāk?</h3>
                <ul>
                    <li>Administrators pārskatīs jūsu pasūtījumu</li>
                    <li>Jūs saņemsiet zvanu uz norādīto telefona numuru pasūtījuma apstiprināšanai</li>
                    <li>Pēc apstiprinājuma varēsiet saņemt preci veikalā</li>
                    <li>Maksājums notiek tikai saņemot preci klātienē</li>
                </ul>
            </div>

            <div class="order-summary">
                <div class="summary-header">
                    <span class="order-number">Pasūtījums #{{ $order->id }}</span>
                    <span class="order-status status-badge status-pending">
                        Gaida apstiprinājumu
                    </span>
                </div>

                <div style="padding: 20px;">
                    @foreach($order->items as $item)
                        <div class="summary-item">
                            <div>
                                <div class="item-name">{{ $item->fish->name }}</div>
                                <div class="item-details">
                                    Daudzums: {{ $item->quantity }} {{ $item->fish->stock_unit == 'kg' ? 'kg' : 'gab.' }}
                                </div>
                            </div>
                            <div style="font-weight: 700; color: var(--success); font-size: 1.1rem;">
                                {{ number_format($item->getTotalPrice(), 2) }} €
                            </div>
                        </div>
                    @endforeach

                    <div class="summary-total">
                        <strong style="color: var(--dark); font-size: 1.2rem;">KOPĀ:</strong>
                        <strong style="color: var(--success); font-size: 1.3rem;">
                            {{ number_format($order->total_amount, 2) }} €
                        </strong>
                    </div>
                </div>
            </div>

            <div class="action-buttons">
                <a href="{{ route('orders.index') }}" class="btn btn-primary">
                    Skatīt manus pasūtījumus
                </a>
                <a href="{{ route('fish.shop') }}" class="btn btn-secondary">
                    Turpināt iepirkties
                </a>
            </div>
        </div>
    </div>
@endsection