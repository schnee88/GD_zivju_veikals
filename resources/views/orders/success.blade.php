@extends('layouts.app')

@section('content')
<div class="admin-container" style="max-width: 800px; margin: 0 auto; padding: 40px 20px;">
    <div class="success-container" style="text-align: center; background: var(--white); border-radius: var(--radius-xl); box-shadow: var(--shadow-lg); padding: 40px; border: 1px solid var(--gray-200);">

        <!-- Success Icon -->
        <div class="success-icon" style="font-size: 4rem; margin-bottom: 20px; animation: bounce 0.6s ease-in-out;">
            ✅
        </div>

        <!-- Success Title -->
        <h1 class="success-title" style="color: var(--success); font-size: 2rem; font-weight: 700; margin: 0 0 16px 0;">
            Pasūtījums veiksmīgi izveidots!
        </h1>

        <!-- Success Message -->
        <p class="success-message" style="color: var(--gray-600); font-size: 1.1rem; line-height: 1.6; margin: 0 0 30px 0; max-width: 500px; margin-left: auto; margin-right: auto;">
            Paldies par jūsu pasūtījumu! Mēs esam saņēmuši jūsu pieteikumu un drīzumā sazināsimies ar jums norādītajā telefona numurā.
        </p>

        <!-- Info Box -->
        <div class="info-box" style="background: var(--primary-light); border-left: 4px solid var(--primary); border-radius: var(--radius-md); padding: 24px; margin: 30px 0; text-align: left;">
            <h3 style="color: var(--dark); font-size: 1.2rem; font-weight: 600; margin: 0 0 16px 0;">Kas notiks tālāk?</h3>
            <ul style="color: var(--gray-700); line-height: 1.6; margin: 0; padding-left: 20px;">
                <li style="margin-bottom: 8px;">Administrators pārskatīs jūsu pasūtījumu</li>
                <li style="margin-bottom: 8px;">Jūs saņemsiet zvanu uz norādīto telefona numuru pasūtījuma apstiprināšanai</li>
                <li style="margin-bottom: 8px;">Pēc apstiprinājuma varēsiet saņemt preci veikalā</li>
                <li style="margin-bottom: 0;">Maksājums notiek tikai saņemot preci klātienē</li>
            </ul>
        </div>

        <!-- Order Summary -->
        <div class="order-summary" style="background: var(--gray-50); border-radius: var(--radius-lg); padding: 0; margin: 30px 0; overflow: hidden; border: 1px solid var(--gray-200);">

            <!-- Summary Header -->
            <div class="summary-header" style="display: flex; justify-content: space-between; align-items: center; padding: 20px; background: var(--white); border-bottom: 1px solid var(--gray-200);">
                <span class="order-number" style="font-weight: 600; color: var(--dark); font-size: 1.1rem;">
                    Pasūtījums #{{ $order->id }}
                </span>
                <span class="order-status status-badge status-pending" style="display: inline-flex; align-items: center; padding: 6px 12px; border-radius: 20px; font-weight: 600; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px; background: #fef3c7; color: #92400e;">
                    Gaida apstiprinājumu
                </span>
            </div>

            <!-- Order Items -->
            <div style="padding: 20px;">
                @foreach($order->items as $item)
                <div class="summary-item" style="display: flex; justify-content: space-between; align-items: center; padding: 16px 0; border-bottom: 1px solid var(--gray-200);">
                    <div>
                        <div class="item-name" style="font-weight: 600; color: var(--dark); font-size: 1.05rem; margin-bottom: 4px;">
                            {{ $item->fish->name }}
                        </div>
                        <div class="item-details" style="color: var(--gray-600); font-size: 0.9rem;">
                            Daudzums: {{ $item->quantity }} {{ $item->fish->stock_unit == 'kg' ? 'kg' : 'gab.' }}
                        </div>
                    </div>
                    <div style="font-weight: 700; color: var(--success); font-size: 1.1rem;">
                        {{ number_format($item->getTotalPrice(), 2) }} €
                    </div>
                </div>
                @endforeach

                <!-- Total -->
                <div class="summary-total" style="display: flex; justify-content: space-between; align-items: center; padding: 20px 0 0 0; margin-top: 16px; border-top: 2px solid var(--gray-300);">
                    <strong style="color: var(--dark); font-size: 1.2rem;">KOPĀ:</strong>
                    <strong style="color: var(--success); font-size: 1.3rem;">
                        {{ number_format($order->total_amount, 2) }} €
                    </strong>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons" style="display: flex; gap: 16px; justify-content: center; margin-top: 30px; flex-wrap: wrap;">
            <a href="{{ route('orders.index') }}" class="btn" style="background: var(--primary); color: var(--white); padding: 12px 24px; border-radius: var(--radius-md); text-decoration: none; font-weight: 600; transition: var(--transition); white-space: nowrap; min-width: 200px; text-align: center;">
                Skatīt manus pasūtījumus
            </a>
            <a href="{{ route('fish.shop') }}" class="btn btn-secondary" style="background: var(--gray-500); color: var(--white); padding: 12px 24px; border-radius: var(--radius-md); text-decoration: none; font-weight: 600; transition: var(--transition); white-space: nowrap; min-width: 200px; text-align: center;">
                Turpināt iepirkties
            </a>
        </div>
    </div>
</div>

<style>
    @keyframes bounce {

        0%,
        20%,
        60%,
        100% {
            transform: translateY(0);
        }

        40% {
            transform: translateY(-10px);
        }

        80% {
            transform: translateY(-5px);
        }
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .btn:hover:not(.btn-secondary) {
        background: var(--primary-dark);
    }

    .btn.btn-secondary:hover {
        background: var(--gray-600);
    }

    @media (max-width: 768px) {
        .admin-container {
            padding: 20px 16px;
        }

        .success-container {
            padding: 30px 20px;
        }

        .success-title {
            font-size: 1.5rem !important;
        }

        .action-buttons {
            flex-direction: column;
            align-items: stretch;
        }

        .action-buttons .btn {
            width: 100%;
            text-align: center;
        }

        .summary-header {
            flex-direction: column;
            gap: 12px;
            align-items: flex-start;
        }
    }

    @media (max-width: 480px) {
        .success-container {
            padding: 20px 16px;
        }

        .success-icon {
            font-size: 3rem !important;
        }

        .success-title {
            font-size: 1.3rem !important;
        }

        .info-box {
            padding: 16px !important;
        }

        .summary-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
        }

        .summary-item div:last-child {
            align-self: flex-end;
        }
    }
</style>
@endsection