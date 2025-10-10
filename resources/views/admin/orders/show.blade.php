@extends('layouts.app')

@section('content')
<div class="reservation-detail">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h1>Pasūtījums #{{ $order->id }}</h1>
        <a href="{{ route('admin.orders.index') }}" style="background: #95a5a6; color: white; padding: 10px 20px; border-radius: 4px; text-decoration: none;">
            ← Atpakaļ
        </a>
    </div>

    @if($order->status == 'pending')
    <div class="warning-box">
        <p><strong>⚠️ Šis pasūtījums gaida apstiprinājumu!</strong> Lūdzu, piezvaniet klientam un apstipriniet pasūtījumu.</p>
    </div>
    @endif

    <div class="detail-grid">
        <div>
            <div class="detail-card">
                <h2>Pasūtījuma informācija</h2>

                <div class="info-row">
                    <span class="info-label">Status:</span>
                    <span class="info-value">
                        <span class="status-badge status-{{ $order->status }}">
                            @if($order->status == 'pending') Gaida apstiprinājumu
                            @elseif($order->status == 'confirmed') Apstiprināts
                            @elseif($order->status == 'completed') Pabeigts
                            @elseif($order->status == 'cancelled') Atcelts
                            @endif
                        </span>
                    </span>
                </div>

                <div class="info-row">
                    <span class="info-label">Pasūtījuma numurs:</span>
                    <span class="info-value"><strong>#{{ $order->id }}</strong></span>
                </div>

                <div class="info-row">
                    <span class="info-label">Produktu veidi:</span>
                    <span class="info-value">{{ $order->items->count() }}</span>
                </div>

                <div class="info-row" style="background: #f8f9fa; padding: 15px; margin-top: 10px;">
                    <span class="info-label" style="font-size: 1.2em;">KOPĀ:</span>
                    <span class="info-value" style="font-size: 1.3em; color: #27ae60; font-weight: bold;">
                        {{ number_format($order->total_amount, 2) }} €
                    </span>
                </div>

                <div class="info-row">
                    <span class="info-label">Izveidots:</span>
                    <span class="info-value">{{ $order->created_at->format('d.m.Y H:i') }}</span>
                </div>

                <div class="info-row">
                    <span class="info-label">Atjaunināts:</span>
                    <span class="info-value">{{ $order->updated_at->format('d.m.Y H:i') }}</span>
                </div>
            </div>

            <div class="detail-card" style="margin-top: 20px;">
                <h2>Pasūtītās preces</h2>

                <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
                    <thead>
                        <tr style="background: #f8f9fa; border-bottom: 2px solid #dee2e6;">
                            <th style="padding: 10px; text-align: left;">Zivs</th>
                            <th style="padding: 10px; text-align: center;">Daudzums</th>
                            <th style="padding: 10px; text-align: right;">Cena</th>
                            <th style="padding: 10px; text-align: right;">Summa</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr style="border-bottom: 1px solid #eee;">
                            <td style="padding: 10px;">
                                <strong>{{ $item->fish->name }}</strong><br>
                                <small style="color: #666;">
                                    Mērvienība: {{ $item->fish->stock_unit == 'kg' ? 'kg' : 'gab.' }}
                                </small>
                            </td>
                            <td style="padding: 10px; text-align: center;">{{ $item->quantity }} {{ $item->fish->stock_unit == 'kg' ? 'kg' : 'gab.' }}</td>
                            <td style="padding: 10px; text-align: right;">{{ number_format($item->price, 2) }} €</td>
                            <td style="padding: 10px; text-align: right;"><strong>{{ number_format($item->quantity * $item->price, 2) }} €</strong></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($order->notes)
            <div class="notes-box" style="background: #fff9e6; border-left-color: #ffc107; margin-top: 20px;">
                <h3>Klienta piezīmes:</h3>
                <p>{{ $order->notes }}</p>
            </div>
            @endif

            @if($order->admin_notes)
            <div class="notes-box" style="margin-top: 20px;">
                <h3>Admin piezīmes:</h3>
                <p>{{ $order->admin_notes }}</p>
            </div>
            @endif
        </div>

        <div>
            <div class="detail-card">
                <h2>Klienta informācija</h2>

                <div class="info-row">
                    <span class="info-label">Vārds:</span>
                    <span class="info-value">{{ $order->user->name }}</span>
                </div>

                <div class="info-row">
                    <span class="info-label">E-pasts:</span>
                    <span class="info-value">{{ $order->user->email }}</span>
                </div>

                <div class="info-row">
                    <span class="info-label">Telefons:</span>
                    <span class="info-value"><strong>{{ $order->phone }}</strong></span>
                </div>

                <div class="info-row">
                    <span class="info-label">IP adrese:</span>
                    <span class="info-value" style="font-size: 0.9em; color: #666;">{{ $order->ip_address }}</span>
                </div>
            </div>

            <div class="detail-card" style="margin-top: 20px;">
                <h2>Mainīt statusu</h2>

                <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="status-form">
                    @csrf
                    @method('PATCH')

                    <label for="status" style="display: block; margin-bottom: 8px; font-weight: bold;">Jauns status:</label>
                    <select name="status" id="status" required>
                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>
                            Gaida apstiprinājumu
                        </option>
                        <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>
                            Apstiprināts
                        </option>
                        <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>
                            Pabeigts (klients saņēmis preci)
                        </option>
                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>
                            Atcelts
                        </option>
                    </select>

                    <label for="admin_notes" style="display: block; margin-bottom: 8px; font-weight: bold;">Admin piezīmes:</label>
                    <textarea
                        name="admin_notes"
                        id="admin_notes"
                        placeholder="Piezīmes par pasūtījumu, zvana rezultāts, utt...">{{ old('admin_notes', $order->admin_notes) }}</textarea>

                    <button type="submit">Atjaunināt</button>
                </form>

                <div style="margin-top: 15px; padding: 12px; background: #e8f5e9; border-radius: 4px; font-size: 0.9em;">
                    <strong>ℹ️ Informācija:</strong>
                    <ul style="margin: 10px 0 0 20px; color: #555;">
                        <li>Apstiprinot pasūtījumu, pieejamais daudzums tiks samazināts</li>
                        <li>Atceļot apstiprinātu pasūtījumu, daudzums tiks atgriezts</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection