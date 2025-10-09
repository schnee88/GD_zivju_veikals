@extends('layouts.app')

@section('content')
<div class="fish-page">
    <h1 style="text-align: center; margin: 30px 0;">🛒 Marinētu zivju veikals</h1>
    <p style="text-align: center; color: #666; margin-bottom: 40px;">
        Pasūti marinētas zivis!
    </p>

    @if($fishes->isEmpty())
    <div style="text-align: center; padding: 40px; background: #f8f9fa; border-radius: 8px; margin: 20px 0;">
        <p style="font-size: 1.1em; color: #666;">Šobrīd nav pieejamu produktu pasūtīšanai</p>
    </div>
    @else
    <div class="fish-grid">
        @foreach($fishes as $fish)
        <div class="fish-card" style="border: 3px solid #3498db; border-radius: 12px; padding: 20px; background: white; box-shadow: 0 4px 8px rgba(0,0,0,0.1); display: flex; flex-direction: column; transition: transform 0.3s ease, box-shadow 0.3s ease;">

            <!-- Fish image -->
            <div style="margin-bottom: 15px; text-align: center; overflow: hidden; border-radius: 8px;">
                @if($fish->image)
                <div style="width: 100%; height: 200px; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border: 1px solid #e9ecef; border-radius: 8px; padding: 15px; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                    <img src="{{ asset('storage/fish_images/' . $fish->image) }}" 
                         alt="{{ $fish->name }}"
                         style="max-width: 100%; max-height: 100%; object-fit: contain; display: block;">
                </div>
                @else
                <div style="width: 100%; height: 200px; background: #f8f9fa; display: flex; align-items: center; justify-content: center; border-radius: 8px; border: 2px dashed #ddd;">
                    <span style="color: #999; font-style: italic;">📷 Nav attēla</span>
                </div>
                @endif
            </div>

            <!-- Fish name header -->
            <div style="margin-bottom: 15px; padding-bottom: 15px; border-bottom: 2px solid #f0f0f0;">
                <h2 style="margin: 0; color: #2c3e50; font-size: 1.4em; text-align: center; min-height: 50px; display: flex; align-items: center; justify-content: center;">
                    🐟 {{ $fish->name }}
                </h2>
            </div>

            <!-- Description -->
            @if($fish->description)
            <div style="margin-bottom: 15px; flex-grow: 1;">
                <p style="margin: 0; color: #555; line-height: 1.6; text-align: center; font-size: 0.95em;">
                    {{ Str::limit($fish->description, 100) }}
                </p>
            </div>
            @endif

            <!-- Price -->
            <div style="background: #f8f9fa; padding: 12px; border-radius: 8px; margin-bottom: 10px; text-align: center;">
                <p style="margin: 0; color: #27ae60; font-size: 1.4em; font-weight: bold;">
                    {{ number_format($fish->price, 2) }} €
                </p>
                <p style="margin: 5px 0 0 0; color: #666; font-size: 0.9em;">
                    <small>/ {{ $fish->stock_unit == 'kg' ? 'kg' : 'gab.' }}</small>
                </p>
            </div>

            <!-- Stock info -->
            <div style="text-align: center; padding: 10px; background: {{ $fish->inStock() ? '#e8f5e9' : '#ffebee' }}; border-radius: 6px; margin-bottom: 15px;">
                @if($fish->inStock())
                    <p style="margin: 0; color: #27ae60; font-weight: bold;">
                        ✅ Pieejams: {{ $fish->stock_quantity }} {{ $fish->stock_unit == 'kg' ? 'kg' : 'gab.' }}
                    </p>
                @else
                    <p style="margin: 0; color: #e74c3c; font-weight: bold;">
                        ❌ Nav pieejams
                    </p>
                @endif
            </div>

            @auth
                @if($fish->inStock())
                    <form action="{{ route('cart.add') }}" method="POST" style="margin-top: auto;">
                        @csrf
                        <input type="hidden" name="fish_id" value="{{ $fish->id }}">
                        
                        <div style="display: flex; gap: 10px; align-items: center; margin-bottom: 15px; background: #f8f9fa; padding: 12px; border-radius: 6px;">
                            <label style="flex: 1; text-align: left; font-weight: bold; color: #2c3e50; margin: 0;">Daudzums:</label>
                            <input 
                                type="number" 
                                name="quantity" 
                                value="{{ $fish->stock_unit == 'kg' ? '0.5' : '1' }}" 
                                min="{{ $fish->stock_unit == 'kg' ? '0.1' : '1' }}"
                                max="{{ $fish->stock_quantity }}"
                                step="{{ $fish->stock_unit == 'kg' ? '0.1' : '1' }}"
                                style="width: 80px; padding: 8px; border: 1px solid #ddd; border-radius: 4px; text-align: center; font-weight: bold;"
                                required
                            >
                        </div>
                        
                        <button type="submit" style="width: 100%; background: #27ae60; color: white; padding: 12px; border: none; border-radius: 6px; cursor: pointer; font-weight: bold; font-size: 1em; transition: background 0.3s ease;">
                            🛒 Pievienot grozam
                        </button>
                    </form>
                @else
                    <div style="text-align: center; padding: 12px; background: #f0f0f0; border-radius: 6px; color: #999; margin-top: 15px; font-weight: bold;">
                        Nav pieejams
                    </div>
                @endif
            @else
                <a href="{{ route('login') }}" style="display: block; background: #3498db; color: white; padding: 12px; border-radius: 6px; text-decoration: none; text-align: center; margin-top: 15px; font-weight: bold; transition: background 0.3s ease;">
                    🔐 Pieteikties
                </a>
            @endauth

        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection