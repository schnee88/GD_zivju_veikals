@extends('layouts.app')

@section('content')
<div class="admin-container">
    <div class="admin-header">
        <h1>Admin panelis – Zivju saraksts</h1>
        <a href="{{ route('admin.fish.create') }}" class="btn btn-primary">
            ➕ Pievienot jaunu zivi
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success">
        ✅ {{ session('success') }}
    </div>
    @endif

    <div class="admin-table-container">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nosaukums</th>
                    <th>Cena (€)</th>
                    <th class="text-center">Pasūtāms</th>
                    <th class="text-center">Noliktavā</th>
                    <th>Apraksts</th>
                    <th>Bilde</th>
                    <th class="text-center">Darbības</th>
                </tr>
            </thead>
            <tbody>
                @forelse($fishes as $fish)
                <tr>
                    <td class="fish-id">{{ $fish->id }}</td>
                    <td class="fish-name">{{ $fish->name }}</td>
                    <td class="fish-price">{{ number_format($fish->price, 2) }} €</td>
                    <td class="text-center">
                        @if($fish->is_orderable)
                        <span class="status-badge status-active">✅ JĀ</span>
                        @else
                        <span class="status-badge status-inactive">❌ NĒ</span>
                        @endif
                    </td>
                    <td class="text-center">
                        @if($fish->is_orderable)
                        <div class="stock-info">
                            <span class="stock-quantity">{{ $fish->stock_quantity }} {{ $fish->stock_unit == 'kg' ? 'kg' : 'gab.' }}</span>
                            @if($fish->inStock())
                            <br><small class="stock-status in-stock">Pieejams</small>
                            @else
                            <br><small class="stock-status out-of-stock">Nav pieejams</small>
                            @endif
                        </div>
                        @else
                        <span class="not-applicable">-</span>
                        @endif
                    </td>
                    <td class="fish-description">{{ Str::limit($fish->description, 50) }}</td>
                    <td class="fish-image">
                        @if($fish->image)
                        <img src="{{ asset('storage/fish_images/' . $fish->image) }}" alt="{{ $fish->name }}" class="fish-thumbnail">
                        @else
                        <span class="no-image">Nav bildes</span>
                        @endif
                    </td>
                    <td class="action-buttons">
                        <div class="button-group">
                            <a href="{{ route('admin.fish.edit', $fish->id) }}" class="btn btn-edit">
                                ✏️ Rediģēt
                            </a>
                            <form action="{{ route('admin.fish.destroy', $fish->id) }}" method="POST" class="delete-form" onsubmit="return confirm('Tiešām dzēst šo zivi?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-delete">
                                    🗑️ Dzēst
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="empty-state">
                        Nav pievienotu zivju.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection