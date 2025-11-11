@extends('layouts.app')

@section('content')
<style>
/* === ORDERS INDEX STYLES === */
.admin-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px 0;
}

.admin-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 32px;
    padding: 0 20px;
}

.admin-header h1 {
    margin: 0;
    color: var(--dark);
    font-size: 2rem;
    font-weight: 700;
    text-align: left;
}

.empty-state {
    text-align: center;
    padding: 80px 40px;
    background: var(--white);
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow-sm);
    border: 2px dashed var(--gray-300);
    margin: 40px 20px;
}

.empty-state p {
    font-size: 1.2rem;
    color: var(--gray-600);
    margin-bottom: 24px;
    font-weight: 500;
}

.empty-state .btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 14px 28px;
    font-size: 1rem;
    font-weight: 600;
}

.orders-list {
    display: flex;
    flex-direction: column;
    gap: 20px;
    padding: 0 20px;
}

.order-card {
    background: var(--white);
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--gray-200);
    overflow: hidden;
    transition: var(--transition);
    position: relative;
}

.order-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-lg);
    border-color: var(--primary-light);
}

.order-card::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 4px;
    height: 100%;
    background: var(--primary);
    opacity: 0;
    transition: var(--transition);
}

.order-card:hover::before {
    opacity: 1;
}

.order-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 24px;
    background: var(--gray-50);
    border-bottom: 1px solid var(--gray-200);
}

.order-number {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--dark);
    display: flex;
    align-items: center;
    gap: 8px;
}

.order-number::before {
    content: "📦";
    font-size: 1.2em;
}

.status-badge {
    display: inline-flex;
    align-items: center;
    padding: 8px 16px;
    border-radius: 20px;
    font-weight: 600;
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    gap: 6px;
}

.status-pending {
    background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
    color: #92400e;
    border: 1px solid #fcd34d;
}

.status-confirmed {
    background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
    color: #065f46;
    border: 1px solid #34d399;
}

.status-completed {
    background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
    color: #166534;
    border: 1px solid #22c55e;
}

.status-cancelled {
    background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
    color: #991b1b;
    border: 1px solid #f87171;
}

.order-items {
    padding: 0;
}

.order-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 16px 24px;
    border-bottom: 1px solid var(--gray-100);
    transition: var(--transition-fast);
}

.order-item:hover {
    background: var(--gray-50);
}

.order-item:last-child {
    border-bottom: none;
}

.item-info {
    flex: 1;
}

.item-name {
    font-size: 1rem;
    font-weight: 600;
    color: var(--dark);
    margin-bottom: 4px;
}

.item-details {
    font-size: 0.9rem;
    color: var(--gray-600);
    display: flex;
    align-items: center;
    gap: 8px;
}

.item-price {
    font-weight: 700;
    color: var(--success);
    font-size: 1rem;
    min-width: 100px;
    text-align: right;
}

.order-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 24px;
    background: var(--gray-50);
    border-top: 1px solid var(--gray-200);
    gap: 16px;
}

.order-meta {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.order-total {
    font-size: 1.2rem;
    font-weight: 700;
    color: var(--success);
    display: flex;
    align-items: center;
    gap: 8px;
}

.order-total::before {
    content: "💰";
    font-size: 1.1em;
}

.order-date {
    font-size: 0.9rem;
    color: var(--gray-600);
    display: flex;
    align-items: center;
    gap: 6px;
}

.order-date::before {
    content: "🕒";
    font-size: 0.9em;
}

.order-actions {
    display: flex;
    gap: 12px;
    align-items: center;
}

.order-actions .btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 10px 16px;
    font-size: 0.85rem;
    font-weight: 600;
    text-decoration: none;
    border-radius: var(--radius-md);
    transition: var(--transition);
    min-width: 100px;
    justify-content: center;
}

.order-actions .btn-primary {
    background: var(--primary);
    color: var(--white);
    border: 1px solid var(--primary);
}

.order-actions .btn-primary:hover {
    background: var(--primary-dark);
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

.order-actions .btn-error {
    background: var(--error);
    color: var(--white);
    border: 1px solid var(--error);
}

.order-actions .btn-error:hover {
    background: var(--error-dark);
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

.cancel-form {
    margin: 0;
}

/* Responsive Design */
@media (max-width: 768px) {
    .admin-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 16px;
        padding: 0 16px;
    }
    
    .admin-header h1 {
        font-size: 1.6rem;
    }
    
    .orders-list {
        padding: 0 16px;
        gap: 16px;
    }
    
    .order-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
        padding: 16px 20px;
    }
    
    .order-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
        padding: 12px 20px;
    }
    
    .item-price {
        align-self: flex-end;
        text-align: right;
        min-width: auto;
    }
    
    .order-footer {
        flex-direction: column;
        align-items: stretch;
        gap: 16px;
        padding: 16px 20px;
    }
    
    .order-actions {
        justify-content: stretch;
    }
    
    .order-actions .btn {
        flex: 1;
        min-width: auto;
    }
    
    .empty-state {
        padding: 60px 24px;
        margin: 20px 16px;
    }
    
    .empty-state p {
        font-size: 1.1rem;
    }
}

@media (max-width: 480px) {
    .admin-container {
        padding: 16px 0;
    }
    
    .admin-header {
        margin-bottom: 24px;
    }
    
    .admin-header h1 {
        font-size: 1.4rem;
    }
    
    .order-header {
        padding: 14px 16px;
    }
    
    .order-number {
        font-size: 1rem;
    }
    
    .status-badge {
        font-size: 0.8rem;
        padding: 6px 12px;
    }
    
    .order-item {
        padding: 10px 16px;
    }
    
    .item-name {
        font-size: 0.95rem;
    }
    
    .item-details {
        font-size: 0.85rem;
    }
    
    .order-footer {
        padding: 14px 16px;
    }
    
    .order-total {
        font-size: 1.1rem;
    }
    
    .order-actions {
        flex-direction: column;
        width: 100%;
    }
    
    .order-actions .btn {
        width: 100%;
    }
    
    .empty-state {
        padding: 40px 20px;
    }
    
    .empty-state p {
        font-size: 1rem;
    }
}
</style>

<div class="admin-container">
    <div class="admin-header">
        <h1>Mani pasūtījumi</h1>
    </div>

    @if($orders->isEmpty())
    <div class="empty-state">
        <p>Jums vēl nav neviena pasūtījuma</p>
        <a href="{{ route('batches.public') }}" class="btn btn-primary">
            👀 Apskatīt kūpinājumus
        </a>
    </div>
    @else
    <div class="orders-list">
        @foreach($orders as $order)
        <div class="order-card">
            <div class="order-header">
                <span class="order-number">Pasūtījums #{{ $order->id }}</span>
                <span class="status-badge status-{{ $order->status }}">
                    @if($order->status == 'pending')
                    ⏳ Gaida apstiprinājumu
                    @elseif($order->status == 'confirmed')
                    ✅ Apstiprināts
                    @elseif($order->status == 'completed')
                    🎉 Pabeigts
                    @elseif($order->status == 'cancelled')
                    ❌ Atcelts
                    @endif
                </span>
            </div>

            <div class="order-items">
                @foreach($order->items as $item)
                <div class="order-item">
                    <div class="item-info">
                        <div class="item-name">{{ $item->fish->name }}</div>
                        <div class="item-details">
                            {{ $item->quantity }} {{ $item->fish->stock_unit == 'kg' ? 'kg' : 'gab.' }} × {{ number_format($item->price, 2) }} €
                        </div>
                    </div>
                    <div class="item-price">{{ number_format($item->quantity * $item->price, 2) }} €</div>
                </div>
                @endforeach
            </div>

            <div class="order-footer">
                <div class="order-meta">
                    <div class="order-total">KOPĀ: {{ number_format($order->total_amount, 2) }} €</div>
                    <div class="order-date">{{ $order->created_at->format('d.m.Y H:i') }}</div>
                </div>
                <div class="order-actions">
                    <a href="{{ route('orders.show', $order->id) }}" class="btn btn-primary btn-sm">
                        👁️ Skatīt detalizēti
                    </a>
                    @if($order->status == 'pending')
                    <form action="{{ route('orders.cancel', $order->id) }}" method="POST" class="cancel-form" onsubmit="return confirm('Vai tiešām vēlaties atcelt šo pasūtījumu?')">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-error btn-sm">
                            ❌ Atcelt pasūtījumu
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection