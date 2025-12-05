@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6 max-w-7xl">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Pasūtījums #{{ $order->id }}</h1>
        <a href="{{ route('admin.orders.index') }}" 
           class="w-full sm:w-auto px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition text-center">
            ← Atpakaļ
        </a>
    </div>

    <!-- Warning for Pending Orders -->
    @if($order->status == 'pending')
    <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 mb-6 rounded">
        <p class="text-yellow-800">
            <strong>⚠️ Šis pasūtījums gaida apstiprinājumu!</strong> Lūdzu, piezvaniet klientam un apstipriniet pasūtījumu.
        </p>
    </div>
    @endif

    <!-- Main Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column - Order Details -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Order Information Card -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold mb-4 text-gray-800">Pasūtījuma informācija</h2>

                <div class="space-y-3">
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="text-gray-600 font-medium">Status:</span>
                        <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full
                            {{ $order->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                            {{ $order->status == 'confirmed' ? 'bg-blue-100 text-blue-800' : '' }}
                            {{ $order->status == 'completed' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $order->status == 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                            @if($order->status == 'pending') Gaida apstiprinājumu
                            @elseif($order->status == 'confirmed') Apstiprināts
                            @elseif($order->status == 'completed') Pabeigts
                            @elseif($order->status == 'cancelled') Atcelts
                            @endif
                        </span>
                    </div>

                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="text-gray-600 font-medium">Pasūtījuma numurs:</span>
                        <span class="font-bold text-gray-900">#{{ $order->id }}</span>
                    </div>

                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="text-gray-600 font-medium">Produktu veidi:</span>
                        <span class="text-gray-900">{{ $order->items->count() }}</span>
                    </div>

                    <div class="flex justify-between items-center py-3 bg-gray-50 rounded-lg mt-4 px-4">
                        <span class="text-gray-800 font-bold text-lg">KOPĀ:</span>
                        <span class="text-green-600 font-bold text-xl">{{ number_format($order->total_amount, 2) }} €</span>
                    </div>

                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="text-gray-600 font-medium">Izveidots:</span>
                        <span class="text-gray-900">{{ $order->created_at->format('d.m.Y H:i') }}</span>
                    </div>

                    <div class="flex justify-between items-center py-2">
                        <span class="text-gray-600 font-medium">Atjaunināts:</span>
                        <span class="text-gray-900">{{ $order->updated_at->format('d.m.Y H:i') }}</span>
                    </div>
                </div>
            </div>

            <!-- Ordered Items Card -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold mb-4 text-gray-800">Pasūtītās preces</h2>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b-2 border-gray-200">
                            <tr>
                                <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Zivs</th>
                                <th class="px-4 py-3 text-center text-sm font-medium text-gray-700">Daudzums</th>
                                <th class="px-4 py-3 text-right text-sm font-medium text-gray-700 hidden sm:table-cell">Cena</th>
                                <th class="px-4 py-3 text-right text-sm font-medium text-gray-700">Summa</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($order->items as $item)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3">
                                    <strong class="text-gray-900">{{ $item->fish->name }}</strong>
                                    <br>
                                    <small class="text-gray-500">
                                        Mērvienība: {{ $item->fish->stock_unit == 'kg' ? 'kg' : 'gab.' }}
                                    </small>
                                </td>
                                <td class="px-4 py-3 text-center text-gray-700">
                                    {{ $item->quantity }} {{ $item->fish->stock_unit == 'kg' ? 'kg' : 'gab.' }}
                                </td>
                                <td class="px-4 py-3 text-right text-gray-700 hidden sm:table-cell">
                                    {{ number_format($item->price, 2) }} €
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <strong class="text-gray-900">{{ number_format($item->quantity * $item->price, 2) }} €</strong>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Customer Notes -->
            @if($order->notes)
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded">
                <h3 class="font-semibold text-yellow-900 mb-2">Klienta piezīmes:</h3>
                <p class="text-yellow-800">{{ $order->notes }}</p>
            </div>
            @endif

            <!-- Admin Notes -->
            @if($order->admin_notes)
            <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded">
                <h3 class="font-semibold text-blue-900 mb-2">Admin piezīmes:</h3>
                <p class="text-blue-800">{{ $order->admin_notes }}</p>
            </div>
            @endif
        </div>

        <!-- Right Column - Customer & Actions -->
        <div class="space-y-6">
            <!-- Customer Information Card -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold mb-4 text-gray-800">Klienta informācija</h2>

                <div class="space-y-3">
                    <div class="py-2 border-b border-gray-100">
                        <span class="block text-sm text-gray-600 font-medium mb-1">Vārds:</span>
                        <span class="text-gray-900">{{ $order->user->name }}</span>
                    </div>

                    <div class="py-2 border-b border-gray-100">
                        <span class="block text-sm text-gray-600 font-medium mb-1">E-pasts:</span>
                        <span class="text-gray-900">{{ $order->user->email }}</span>
                    </div>

                    <div class="py-2 border-b border-gray-100">
                        <span class="block text-sm text-gray-600 font-medium mb-1">Telefons:</span>
                        <span class="font-bold text-gray-900">{{ $order->phone }}</span>
                    </div>

                    <div class="py-2">
                        <span class="block text-sm text-gray-600 font-medium mb-1">IP adrese:</span>
                        <span class="text-sm text-gray-500">{{ $order->ip_address }}</span>
                    </div>
                </div>
            </div>

            <!-- Status Update Card -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold mb-4 text-gray-800">Mainīt statusu</h2>

                <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PATCH')

                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Jauns status:</label>
                        <select name="status" id="status" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
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
                    </div>

                    <div>
                        <label for="admin_notes" class="block text-sm font-medium text-gray-700 mb-2">Admin piezīmes:</label>
                        <textarea
                            name="admin_notes"
                            id="admin_notes"
                            rows="4"
                            placeholder="Piezīmes par pasūtījumu, zvana rezultāts, utt..."
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none">{{ old('admin_notes', $order->admin_notes) }}</textarea>
                    </div>

                    <button type="submit" 
                            class="w-full px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">
                        Atjaunināt
                    </button>
                </form>

                <div class="mt-4 p-3 bg-green-50 rounded-lg border border-green-200">
                    <strong class="text-green-800 text-sm">ℹ️ Informācija:</strong>
                    <ul class="mt-2 ml-5 space-y-1 text-sm text-green-700 list-disc">
                        <li>Apstiprinot pasūtījumu, pieejamais daudzums tiks samazināts</li>
                        <li>Atceļot apstiprinātu pasūtījumu, daudzums tiks atgriezts</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection