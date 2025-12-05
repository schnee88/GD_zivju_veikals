@extends('layouts.app')

@section('content')

<div class="max-w-md mx-auto">
    <!-- Header -->
    <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-blue-600 to-blue-700 text-white rounded-2xl shadow-lg mb-4">
            <span class="text-3xl">🔐</span>
        </div>
        <h1 class="text-3xl font-extrabold text-gray-900 mb-2">
            Pieteikšanās
        </h1>
        <p class="text-gray-600">
            Ienāc savā kontā, lai turpinātu
        </p>
    </div>

    <!-- Login Card -->
    <div class="bg-white rounded-2xl shadow-xl border border-gray-200 p-8">
        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf
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
                    autofocus
                    class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all outline-none @error('email') border-red-500 @enderror"
                    placeholder="tavs@epasts.lv">
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
                    class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all outline-none @error('password') border-red-500 @enderror"
                    placeholder="••••••••">
                @error('password')
                    <p class="mt-2 text-sm text-red-600 flex items-center gap-2">
                        <span>⚠️</span>
                        <span>{{ $message }}</span>
                    </p>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="flex items-center">
                <input 
                    type="checkbox" 
                    name="remember" 
                    id="remember"
                    class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                <label for="remember" class="ml-2 text-sm text-gray-600">
                    Atcerēties mani
                </label>
            </div>

            <button 
                type="submit"
                class="w-full px-6 py-4 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl font-bold text-lg hover:from-blue-700 hover:to-blue-800 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                Pieslēgties
            </button>
        </form>
    </div>

    <div class="mt-6 text-center">
        <p class="text-gray-600">
            Nav konta? 
            <a href="{{ route('register') }}" class="text-blue-600 font-semibold hover:text-blue-700 hover:underline">
                Reģistrēties tagad
            </a>
        </p>
    </div>

    <div class="mt-12 p-6 bg-blue-50 rounded-2xl border border-blue-200">
        <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
            <span>✨</span>
            <span>Kāpēc izveidot kontu?</span>
        </h3>
        <ul class="space-y-3 text-sm text-gray-700">
            <li class="flex items-start gap-3">
                <span class="text-green-600 flex-shrink-0">✓</span>
                <span>Viegli pasūtīt produktus tiešsaistē</span>
            </li>
            <li class="flex items-start gap-3">
                <span class="text-green-600 flex-shrink-0">✓</span>
                <span>Sekot līdzi pasūtījumu statusam</span>
            </li>
            <li class="flex items-start gap-3">
                <span class="text-green-600 flex-shrink-0">✓</span>
                <span>Ātra un ērta pasūtīšana</span>
            </li>
            <li class="flex items-start gap-3">
                <span class="text-green-600 flex-shrink-0">✓</span>
                <span>Piekļuve īpašiem piedāvājumiem</span>
            </li>
        </ul>
    </div>
</div>

@endsection