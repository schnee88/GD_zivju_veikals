@extends('layouts.app')

@section('content')

<div class="max-w-md mx-auto">
    <!-- Header -->
    <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-green-600 to-green-700 text-white rounded-2xl shadow-lg mb-4">
            <span class="text-3xl">📝</span>
        </div>
        <h1 class="text-3xl font-extrabold text-gray-900 mb-2">
            Reģistrācija
        </h1>
        <p class="text-gray-600">
            Izveido savu kontu dažās sekundēs
        </p>
    </div>

    <!-- Register Card -->
    <div class="bg-white rounded-2xl shadow-xl border border-gray-200 p-8">
        <form method="POST" action="{{ route('register') }}" class="space-y-6">
            @csrf

            <div>
                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                    Vārds un uzvārds
                </label>
                <input 
                    type="text" 
                    name="name" 
                    id="name" 
                    value="{{ old('name') }}"
                    required 
                    autofocus
                    class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-4 focus:ring-green-500/10 transition-all outline-none @error('name') border-red-500 @enderror"
                    placeholder="Jānis Bērziņš">
                @error('name')
                    <p class="mt-2 text-sm text-red-600 flex items-center gap-2">
                        <span>⚠️</span>
                        <span>{{ $message }}</span>
                    </p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                    E-pasta adrese
                </label>
                <input 
                    type="email" 
                    name="email" 
                    id="email" 
                    value="{{ old('email') }}"
                    required
                    class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-4 focus:ring-green-500/10 transition-all outline-none @error('email') border-red-500 @enderror"
                    placeholder="janis@epasts.lv">
                @error('email')
                    <p class="mt-2 text-sm text-red-600 flex items-center gap-2">
                        <span>⚠️</span>
                        <span>{{ $message }}</span>
                    </p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                    Parole
                </label>
                <input 
                    type="password" 
                    name="password" 
                    id="password" 
                    required
                    class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-4 focus:ring-green-500/10 transition-all outline-none @error('password') border-red-500 @enderror"
                    placeholder="••••••••">
                @error('password')
                    <p class="mt-2 text-sm text-red-600 flex items-center gap-2">
                        <span>⚠️</span>
                        <span>{{ $message }}</span>
                    </p>
                @enderror
                <p class="mt-2 text-xs text-gray-500">
                    Minimums 8 simboli
                </p>
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                    Apstipriniet paroli
                </label>
                <input 
                    type="password" 
                    name="password_confirmation" 
                    id="password_confirmation" 
                    required
                    class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-4 focus:ring-green-500/10 transition-all outline-none"
                    placeholder="••••••••">
            </div>

            <!-- Terms Agreement -->
            <div class="flex items-start">
                <input 
                    type="checkbox" 
                    name="terms" 
                    id="terms"
                    required
                    class="w-4 h-4 mt-1 text-green-600 border-gray-300 rounded focus:ring-green-500">
                <label for="terms" class="ml-2 text-sm text-gray-600">
                    Es piekrītu <a href="#" class="text-green-600 font-semibold hover:underline">lietošanas noteikumiem</a> un <a href="#" class="text-green-600 font-semibold hover:underline">privātuma politikai</a>
                </label>
            </div>

            <button 
                type="submit"
                class="w-full px-6 py-4 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-xl font-bold text-lg hover:from-green-700 hover:to-green-800 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                Izveidot kontu
            </button>
        </form>
    </div>

    <div class="mt-6 text-center">
        <p class="text-gray-600">
            Jau ir konts? 
            <a href="{{ route('login') }}" class="text-green-600 font-semibold hover:text-green-700 hover:underline">
                Pieslēgties
            </a>
        </p>
    </div>

    <!-- Benefits Grid -->
    <div class="mt-12 grid sm:grid-cols-2 gap-4">
        <div class="p-4 bg-white rounded-xl border border-gray-200 shadow-sm">
            <div class="flex items-start gap-3">
                <span class="text-2xl flex-shrink-0">🛒</span>
                <div>
                    <h3 class="font-bold text-gray-900 text-sm mb-1">Viegla pasūtīšana</h3>
                    <p class="text-xs text-gray-600">Pasūti produktus dažos klikšķos</p>
                </div>
            </div>
        </div>

        <div class="p-4 bg-white rounded-xl border border-gray-200 shadow-sm">
            <div class="flex items-start gap-3">
                <span class="text-2xl flex-shrink-0">📦</span>
                <div>
                    <h3 class="font-bold text-gray-900 text-sm mb-1">Pasūtījumu vēsture</h3>
                    <p class="text-xs text-gray-600">Seko līdzi visiem pasūtījumiem</p>
                </div>
            </div>
        </div>

        <div class="p-4 bg-white rounded-xl border border-gray-200 shadow-sm">
            <div class="flex items-start gap-3">
                <span class="text-2xl flex-shrink-0">⚡</span>
                <div>
                    <h3 class="font-bold text-gray-900 text-sm mb-1">Ātra apkalpošana</h3>
                    <p class="text-xs text-gray-600">Saņem pasūtījumu ātri</p>
                </div>
            </div>
        </div>

        <div class="p-4 bg-white rounded-xl border border-gray-200 shadow-sm">
            <div class="flex items-start gap-3">
                <span class="text-2xl flex-shrink-0">🎁</span>
                <div>
                    <h3 class="font-bold text-gray-900 text-sm mb-1">Īpaši piedāvājumi</h3>
                    <p class="text-xs text-gray-600">Ekskluzīvi piedāvājumi</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Security Notice -->
    <div class="mt-8 p-4 bg-gray-50 rounded-xl border border-gray-200 text-center">
        <p class="text-sm text-gray-600">
            <span class="font-semibold">🔒 Drošība garantēta:</span> Jūsu dati tiek droši glabāti un nekad netiek nodoti trešajām pusēm
        </p>
    </div>
</div>

@endsection