@extends('layouts.app')

@section('content')
<div class="fish-page">
     <h1>Produktu katalogs</h1>
     <p style="text-align: center; color: #666; margin-bottom: 40px;">
          Šeit var apskatīt mūsu sortimentu. Lai iegādātos, lūdzu, apmeklējiet mūsu veikalu vai zvaniet.
     </p>

     @if($fishes->isEmpty())
     <div style="text-align: center; padding: 40px; background: #f8f9fa; border-radius: 8px; margin: 20px 0;">
          <p style="font-size: 1.1em; color: #666;">Šobrīd katalogā nav neviena produkta</p>
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
               <div style="background: #f8f9fa; padding: 12px; border-radius: 8px; margin-bottom: 15px; text-align: center;">
                    <p style="margin: 0; color: #27ae60; font-size: 1.4em; font-weight: bold;">
                         {{ number_format($fish->price, 2) }} €
                    </p>
                    <p style="margin: 5px 0 0 0; color: #666; font-size: 0.9em;">
                         <small>Vienam kg</small>
                    </p>
               </div>

               <!-- Contact info -->
               <div style="text-align: center; padding: 12px; background: #f8f9fa; border-radius: 6px; margin-top: 15px;">
                    <p style="margin: 0; color: #666; font-size: 0.9em;">
                         📞 Lai pasūtītu, zvaniet: <strong>+371 XXXXXXXX</strong>
                    </p>
               </div>

               <div style="margin-top: auto; text-align: center;">
                    <a href="{{ route('fish.show', $fish->id) }}"
                         style="display: inline-block; background: #3498db; color: white; padding: 12px 25px; border-radius: 6px; text-decoration: none; font-weight: bold; transition: background 0.3s ease, transform 0.3s ease;">
                         📋 Skatīt vairāk
                    </a>
               </div>

          </div>
          @endforeach
     </div>
     @endif

     <!-- Contact box -->
     <div style="text-align: center; margin-top: 40px; padding: 25px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px; color: white; box-shadow: 0 4px 8px rgba(0,0,0,0.15);">
          <h3 style="margin: 0 0 15px 0; font-size: 1.4em;">🛒 Kā iegādāties?</h3>
          <p style="margin: 10px 0; font-size: 1.05em;">Apmeklējiet mūsu veikalu vai zvaniet!</p>
          <p style="margin: 15px 0;">
               <a href="tel:+371XXXXXXXX" style="color: white; font-size: 1.5em; font-weight: bold; text-decoration: none; background: rgba(255,255,255,0.2); padding: 10px 20px; border-radius: 8px; display: inline-block;">
                    📞 +371 XXXXXXXX
               </a>
          </p>
          <p style="margin: 10px 0; font-size: 0.95em; opacity: 0.9;">⏰ Darba laiks: Pirmdiena-Piektdiena 9:00-18:00</p>
     </div>
</div>
@endsection