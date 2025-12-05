@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 mb-2 flex items-center gap-3">
                <span class="text-4xl">🐟</span>
                <span>Zivju pārvaldība</span>
            </h1>
            <p class="text-gray-600">
                Pievienojiet, rediģējiet un pārvaldiet zivju katalogu
            </p>
        </div>
        <a href="{{ route('admin.fish.create') }}" 
           class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl font-bold hover:from-blue-700 hover:to-blue-800 transition-all shadow-lg hover:shadow-xl">
            <span class="text-xl">➕</span>
            <span>Pievienot jaunu zivi</span>
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

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
            <div class="flex items-center justify-between mb-2">
                <span class="text-gray-600 text-sm font-medium">Kopā zivis</span>
                <span class="text-2xl">🐟</span>
            </div>
            <p class="text-3xl font-bold text-gray-900">{{ $fishes->count() }}</p>
        </div>
        
        <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
            <div class="flex items-center justify-between mb-2">
                <span class="text-gray-600 text-sm font-medium">Pasūtāmas</span>
                <span class="text-2xl">✅</span>
            </div>
            <p class="text-3xl font-bold text-green-600">{{ $fishes->where('is_orderable', true)->count() }}</p>
        </div>
        
        <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
            <div class="flex items-center justify-between mb-2">
                <span class="text-gray-600 text-sm font-medium">Pieejamas</span>
                <span class="text-2xl">📦</span>
            </div>
            <p class="text-3xl font-bold text-blue-600">{{ $fishes->filter(fn($f) => $f->is_orderable && $f->inStock())->count() }}</p>
        </div>
        
        <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
            <div class="flex items-center justify-between mb-2">
                <span class="text-gray-600 text-sm font-medium">Tikai katalogā</span>
                <span class="text-2xl">📖</span>
            </div>
            <p class="text-3xl font-bold text-gray-600">{{ $fishes->where('is_orderable', false)->count() }}</p>
        </div>
    </div>

    <!-- Fish Table -->
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
        <!-- Table Header -->
        <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-white border-b border-gray-200">
            <h2 class="text-lg font-bold text-gray-900">Visu zivju saraksts</h2>
        </div>

        <!-- Desktop Table -->
        <div class="hidden lg:block overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">ID</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Nosaukums</th>
                        <th class="px-4 py-3 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">Cena</th>
                        <th class="px-4 py-3 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">Statuss</th>
                        <th class="px-4 py-3 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">Noliktava</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Apraksts</th>
                        <th class="px-4 py-3 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">Attēls</th>
                        <th class="px-4 py-3 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">Darbības</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($fishes as $fish)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-4 py-4 whitespace-nowrap">
                                <span class="text-sm font-semibold text-gray-600">{{ $fish->id }}</span>
                            </td>
                            <td class="px-4 py-4">
                                <div class="flex items-center gap-2">
                                    <span class="text-lg">🐟</span>
                                    <span class="font-semibold text-gray-900">{{ $fish->name }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-4 text-center">
                                <span class="text-sm font-bold text-green-600">{{ number_format($fish->price, 2) }} €</span>
                            </td>
                            <td class="px-4 py-4 text-center">
                                @if($fish->is_orderable)
                                    <span class="inline-flex items-center gap-1 px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">
                                        <span>✅</span>
                                        <span>Pasūtāms</span>
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-xs font-bold">
                                        <span>📖</span>
                                        <span>Katalogā</span>
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-4 text-center">
                                @if($fish->is_orderable)
                                    <div class="text-sm">
                                        <p class="font-bold text-gray-900">{{ $fish->stock_quantity }} {{ $fish->stock_unit == 'kg' ? 'kg' : 'gab.' }}</p>
                                        @if($fish->inStock())
                                            <p class="text-xs text-green-600 font-semibold">Pieejams</p>
                                        @else
                                            <p class="text-xs text-red-600 font-semibold">Nav pieejams</p>
                                        @endif
                                    </div>
                                @else
                                    <span class="text-gray-400 text-sm">-</span>
                                @endif
                            </td>
                            <td class="px-4 py-4 max-w-xs">
                                <p class="text-sm text-gray-600 truncate">{{ Str::limit($fish->description, 50) }}</p>
                            </td>
                            <td class="px-4 py-4 text-center">
                                @if($fish->image)
                                    <img src="{{ asset('storage/fish_images/' . $fish->image) }}" 
                                         alt="{{ $fish->name }}"
                                         class="w-16 h-12 object-cover rounded-lg border border-gray-200 mx-auto">
                                @else
                                    <span class="text-gray-400 text-xs italic">Nav</span>
                                @endif
                            </td>
                            <td class="px-4 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.fish.edit', $fish->id) }}" 
                                       class="px-3 py-1.5 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition-colors text-sm font-semibold">
                                        ✏️ Edit
                                    </a>
                                    <form action="{{ route('admin.fish.destroy', $fish->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                onclick="return confirm('Tiešām dzēst {{ $fish->name }}?')"
                                                class="px-3 py-1.5 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition-colors text-sm font-semibold">
                                            🗑️ Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-12 text-center">
                                <div class="flex flex-col items-center gap-4">
                                    <span class="text-6xl">🐟</span>
                                    <p class="text-gray-500 font-medium">Nav pievienotu zivju</p>
                                    <a href="{{ route('admin.fish.create') }}" 
                                       class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-semibold">
                                        Pievienot pirmo zivi
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile Cards -->
        <div class="lg:hidden p-4 space-y-4">
            @forelse($fishes as $fish)
                <div class="bg-gray-50 rounded-xl border border-gray-200 overflow-hidden">
                    <div class="p-4 space-y-3">
                        <!-- Header -->
                        <div class="flex items-start justify-between gap-3">
                            <div class="flex items-center gap-2">
                                <span class="text-2xl">🐟</span>
                                <div>
                                    <h3 class="font-bold text-gray-900">{{ $fish->name }}</h3>
                                    <p class="text-xs text-gray-500">ID: {{ $fish->id }}</p>
                                </div>
                            </div>
                            @if($fish->image)
                                <img src="{{ asset('storage/fish_images/' . $fish->image) }}" 
                                     alt="{{ $fish->name }}"
                                     class="w-16 h-12 object-cover rounded-lg border border-gray-200">
                            @endif
                        </div>

                        <!-- Info Grid -->
                        <div class="grid grid-cols-2 gap-3 text-sm">
                            <div>
                                <p class="text-gray-600 text-xs">Cena</p>
                                <p class="font-bold text-green-600">{{ number_format($fish->price, 2) }} €</p>
                            </div>
                            <div>
                                <p class="text-gray-600 text-xs">Statuss</p>
                                @if($fish->is_orderable)
                                    <p class="text-green-600 font-semibold text-xs">✅ Pasūtāms</p>
                                @else
                                    <p class="text-gray-600 font-semibold text-xs">📖 Katalogā</p>
                                @endif
                            </div>
                            @if($fish->is_orderable)
                                <div class="col-span-2">
                                    <p class="text-gray-600 text-xs">Noliktavā</p>
                                    <p class="font-bold text-gray-900">
                                        {{ $fish->stock_quantity }} {{ $fish->stock_unit == 'kg' ? 'kg' : 'gab.' }}
                                        @if($fish->inStock())
                                            <span class="text-green-600 text-xs">(Pieejams)</span>
                                        @else
                                            <span class="text-red-600 text-xs">(Nav pieejams)</span>
                                        @endif
                                    </p>
                                </div>
                            @endif
                        </div>

                        @if($fish->description)
                            <p class="text-sm text-gray-600">{{ Str::limit($fish->description, 80) }}</p>
                        @endif

                        <!-- Actions -->
                        <div class="flex gap-2 pt-3 border-t border-gray-200">
                            <a href="{{ route('admin.fish.edit', $fish->id) }}" 
                               class="flex-1 px-4 py-2 bg-blue-600 text-white text-center rounded-lg hover:bg-blue-700 transition-colors font-semibold text-sm">
                                ✏️ Rediģēt
                            </a>
                            <form action="{{ route('admin.fish.destroy', $fish->id) }}" method="POST" class="flex-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        onclick="return confirm('Tiešām dzēst {{ $fish->name }}?')"
                                        class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors font-semibold text-sm">
                                    🗑️ Dzēst
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-12">
                    <span class="text-6xl block mb-4">🐟</span>
                    <p class="text-gray-500 font-medium mb-4">Nav pievienotu zivju</p>
                    <a href="{{ route('admin.fish.create') }}" 
                       class="inline-block px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-semibold">
                        Pievienot pirmo zivi
                    </a>
                </div>
            @endforelse
        </div>
    </div>
</div>

@endsection