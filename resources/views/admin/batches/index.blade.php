@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 mb-2 flex items-center gap-3">
                <span class="text-4xl">⚗️</span>
                <span>Produktu partiju pārvaldība</span>
            </h1>
            <p class="text-gray-600">
                Plānojiet un pārvaldiet ražošanas partijas
            </p>
        </div>
        <a href="{{ route('admin.batches.create') }}" 
           class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl font-bold hover:from-blue-700 hover:to-blue-800 transition-all shadow-lg hover:shadow-xl">
            <span class="text-xl">➕</span>
            <span>Jauna partija</span>
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded-lg shadow-sm animate-in slide-in-from-top duration-300">
            <div class="flex items-center gap-3">
                <span class="text-2xl">✅</span>
                <p class="text-green-800 font-medium">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    @if($batches->isEmpty())
        <div class="max-w-md mx-auto text-center py-16">
            <div class="mb-8">
                <div class="inline-flex items-center justify-center w-24 h-24 bg-gray-100 rounded-full mb-6">
                    <span class="text-6xl">📦</span>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">
                    Nav izveidotu partiju
                </h2>
                <p class="text-gray-600 mb-8">
                    Vēl nav izveidota neviena partija. Izveidojiet pirmo!
                </p>
            </div>
            
            <a href="{{ route('admin.batches.create') }}" 
               class="inline-flex items-center gap-2 px-6 py-4 bg-blue-600 text-white rounded-xl font-bold hover:bg-blue-700 transition-all shadow-lg">
                <span>➕</span>
                <span>Izveidot pirmo partiju</span>
            </a>
        </div>
    @else
        <!-- Batches List -->
        <div class="space-y-6">
            @foreach($batches as $batch)
                <div class="bg-white rounded-2xl border-2 overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300"
                     style="border-color: {{ $batch->status_color }};">
                    
                    <div class="px-6 py-5 bg-gradient-to-r from-gray-50 to-white border-b border-gray-200">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-2">
                                    <span class="text-2xl">📦</span>
                                    <h2 class="text-2xl font-bold text-gray-900">{{ $batch->name }}</h2>
                                </div>
                                <p class="flex items-center gap-2 text-gray-600">
                                    <span class="text-lg">📅</span>
                                    <span class="font-semibold">Datums:</span>
                                    <span>{{ $batch->formatted_batch_date }}</span>
                                </p>
                            </div>
                            
                            <div class="flex items-center gap-3">
                                <!-- Status Badge -->
                                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold text-white shadow-md"
                                      style="background-color: {{ $batch->status_color }};">
                                    {{ $batch->status_text }}
                                </span>
                            </div>
                        </div>

                        @if($batch->description)
                            <div class="mt-4 p-4 bg-blue-50 border-l-4 border-blue-400 rounded-lg">
                                <p class="text-gray-700 leading-relaxed">{{ $batch->description }}</p>
                            </div>
                        @endif
                    </div>

                    <!-- Batch Content -->
                    <div class="px-6 py-5">
                        <!-- Fish List -->
                        <div class="mb-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                                <span>🐟</span>
                                <span>Zivis šajā žāvējumā:</span>
                            </h3>

                            @if($batch->fishes->isEmpty())
                                <p class="text-center py-4 text-gray-500 italic bg-gray-50 rounded-lg">
                                    Nav pievienotu zivju
                                </p>
                            @else
                                <!-- Desktop Table -->
                                <div class="hidden md:block overflow-x-auto bg-white border border-gray-200 rounded-xl">
                                    <table class="w-full">
                                        <thead class="bg-gray-800 text-white">
                                            <tr>
                                                <th class="px-4 py-3 text-left text-sm font-bold">Zivs</th>
                                                <th class="px-4 py-3 text-center text-sm font-bold">Daudzums</th>
                                                <th class="px-4 py-3 text-center text-sm font-bold">Mērvienība</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200">
                                            @foreach($batch->fishes as $fish)
                                                <tr class="hover:bg-gray-50">
                                                    <td class="px-4 py-3">
                                                        <span class="font-semibold text-gray-900">{{ $fish->name }}</span>
                                                    </td>
                                                    <td class="px-4 py-3 text-center font-bold text-blue-600">
                                                        {{ $fish->pivot->quantity }}
                                                    </td>
                                                    <td class="px-4 py-3 text-center text-gray-700">
                                                        {{ $fish->pivot->unit == 'kg' ? 'kg' : 'gab.' }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Mobile Cards -->
                                <div class="md:hidden space-y-3">
                                    @foreach($batch->fishes as $fish)
                                        <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                                            <div class="flex items-center gap-2 mb-2">
                                                <span class="text-xl">🐟</span>
                                                <span class="font-bold text-gray-900">{{ $fish->name }}</span>
                                            </div>
                                            <div class="flex justify-between text-sm">
                                                <span class="text-gray-600">Daudzums:</span>
                                                <span class="font-bold text-blue-600">{{ $fish->pivot->quantity }} {{ $fish->pivot->unit == 'kg' ? 'kg' : 'gab.' }}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <!-- Status Change & Actions -->
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pt-6 border-t-2 border-gray-200">
                            <!-- Status Selector -->
                            <div class="flex items-center gap-3">
                                <label class="font-bold text-gray-900 whitespace-nowrap">Mainīt statusu:</label>
                                <form action="{{ route('admin.batches.update-status', $batch) }}" method="POST" class="flex-1">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" 
                                            onchange="this.form.submit()"
                                            class="px-4 py-2 border-2 border-gray-300 rounded-lg bg-white font-semibold text-gray-900 hover:border-blue-500 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all outline-none cursor-pointer">
                                        <option value="preparing" {{ $batch->status == 'preparing' ? 'selected' : '' }}>Gatavošanā</option>
                                        <option value="available" {{ $batch->status == 'available' ? 'selected' : '' }}>Pieejams</option>
                                        <option value="sold_out" {{ $batch->status == 'sold_out' ? 'selected' : '' }}>Izpārdots</option>
                                    </select>
                                </form>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex gap-3">
                                <a href="{{ route('admin.batches.edit', $batch) }}" 
                                   class="px-5 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-semibold text-sm flex items-center gap-2">
                                    <span>✏️</span>
                                    <span>Rediģēt</span>
                                </a>
                                <form action="{{ route('admin.batches.destroy', $batch) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            onclick="return confirm('Vai tiešām vēlaties dzēst {{ $batch->name }}? Šo darbību nevarēs atsaukt!')"
                                            class="px-5 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors font-semibold text-sm flex items-center gap-2">
                                        <span>🗑️</span>
                                        <span>Dzēst</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

@endsection