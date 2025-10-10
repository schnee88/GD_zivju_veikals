@extends('layouts.app')

@section('content')
<h1>Admin panelis – Zivju saraksts</h1>

@if(session('success'))
<p style="color: green">{{ session('success') }}</p>
@endif

<form action="{{ route('admin.fish.create') }}">
    @csrf
    <button type="submit" style="background:#2596be; padding:5px 10px;">Pievienot jaunu zivi</button>
</form>

<table border="1" cellpadding="8" cellspacing="0" style="margin-top:20px; width:100%;">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nosaukums</th>
            <th>Cena (€)</th>
            <th>Pasūtāms</th>
            <th>Noliktavā</th>
            <th>Apraksts</th>
            <th>Bilde</th>
            <th>Darbības</th>
        </tr>
    </thead>
    <tbody>
        @forelse($fishes as $fish)
        <tr>
            <td>{{ $fish->id }}</td>
            <td>{{ $fish->name }}</td>
            <td>{{ number_format($fish->price, 2) }} €</td>
            <td style="text-align: center;">
                @if($fish->is_orderable)
                <span style="color: green; font-weight: bold;">✅ JĀ</span>
                @else
                <span style="color: red; font-weight: bold;">❌ NĒ</span>
                @endif
            </td>
            <td style="text-align: center;">
                @if($fish->is_orderable)
                {{ $fish->stock_quantity }} {{ $fish->stock_unit == 'kg' ? 'kg' : 'gab.' }}
                @if($fish->inStock())
                <br><small style="color: green;">Pieejams</small>
                @else
                <br><small style="color: red;">Nav pieejams</small>
                @endif
                @else
                <span style="color: #999;">-</span>
                @endif
            </td>
            <td>{{ Str::limit($fish->description, 50) }}</td>
            <td>
                @if($fish->image)
                <img src="{{ asset('storage/fish_images/' . $fish->image) }}" alt="zivs bilde" width="80">
                @else
                Nav bildes
                @endif
            </td>
            <td>
                {{-- Edit poga --}}
                <a href="{{ route('admin.fish.edit', $fish->id) }}">✏️ Rediģēt</a>

                {{-- Delete forma --}}
                <form action="{{ route('admin.fish.destroy', $fish->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Tiešām dzēst šo zivi?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="color:red">🗑️ Dzēst</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="8">Nav pievienotu zivju.</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection