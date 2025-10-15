@extends('layouts.app')

@section('content')
<div class="fish-page">
     <h1>Produktu katalogs</h1>
     <p class="page-description">
          Šeit var apskatīt mūsu sortimentu. Lai iegādātos, lūdzu, apmeklējiet mūsu veikalu vai zvaniet.
     </p>

     @if($fishes->isEmpty())
     <div class="empty-state">
          <p>Šobrīd katalogā nav neviena produkta</p>
     </div>
     @else
     <div class="fish-grid compact-grid catalog-grid">
          @foreach($fishes as $fish)
          <div class="fish-card compact-card catalog-card">
               <div class="fish-image-container">
                    @if($fish->image)
                    <img src="{{ asset('storage/fish_images/' . $fish->image) }}"
                         alt="{{ $fish->name }}"
                         class="fish-image">
                    @else
                    <div class="no-image">
                         <span>📷</span>
                    </div>
                    @endif
               </div>

               <div class="fish-header">
                    <h3>🐟 {{ $fish->name }}</h3>
               </div>

               @if($fish->description)
               <div class="fish-description">
                    <p>{{ Str::limit($fish->description, 80) }}</p>
               </div>
               @endif

               <div class="price-container">
                    <p class="price">{{ number_format($fish->price, 2) }} €</p>
                    <p class="price-label">par kg</p>
               </div>

               <div class="contact-info">
                    <p>📞 Lai pasūtītu, zvaniet: <strong>+371 XXXXXXXX</strong></p>
               </div>

               <div class="action-container">
                    <a href="{{ route('fish.show', $fish->id) }}" class="btn-view-more">
                         Skatīt vairāk
                    </a>
               </div>
          </div>
          @endforeach
     </div>
     @endif
f
     <!-- Contact box -->
     <div class="contact-box">
          <h3>🛒 Kā iegādāties?</h3>
          <p>Apmeklējiet mūsu veikalu vai zvaniet!</p>
          <p>
               <a href="tel:+371XXXXXXXX" class="phone-link">
                    📞 +371 XXXXXXXX
               </a>
          </p>
          <p class="working-hours">⏰ Darba laiks: Pirmdiena-Piektdiena 9:00-18:00</p>
     </div>
</div>
@endsection