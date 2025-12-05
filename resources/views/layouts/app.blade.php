<!DOCTYPE html>
<html lang="lv" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Zivju Veikals - Svaigākās un garšīgākās zivis Latvijā">
    <title>{{ $title ?? 'Zivju Veikals' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>

<body class="min-h-screen flex flex-col bg-gray-50 text-gray-900 antialiased">
    <!-- Navigation -->
    <nav class="sticky top-0 z-50 bg-gradient-to-r from-slate-800 to-slate-700 shadow-lg backdrop-blur-sm bg-opacity-95">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between py-4">
                <!-- Logo & Primary Nav -->
                <div class="flex items-center gap-2 md:gap-4 flex-wrap">
                    <a href="{{ route('home') }}" 
                       class="flex items-center gap-2 px-3 py-2 text-white font-semibold rounded-lg hover:bg-white/10 transition-all duration-200 hover:scale-105">
                        <span class="text-xl">🏠</span>
                        <span class="hidden sm:inline">Mājas</span>
                    </a>
                    <a href="{{ route('fish.catalog') }}" 
                       class="flex items-center gap-2 px-3 py-2 text-white/90 rounded-lg hover:bg-white/10 hover:text-white transition-all duration-200">
                        <span>🐟</span>
                        <span class="hidden sm:inline">Katalogs</span>
                    </a>
                    <a href="{{ route('fish.shop') }}" 
                       class="flex items-center gap-2 px-3 py-2 text-white/90 rounded-lg hover:bg-white/10 hover:text-white transition-all duration-200">
                        <span>🛍️</span>
                        <span class="hidden sm:inline">Veikals</span>
                    </a>
                    <a href="{{ route('batches.public') }}" 
                       class="flex items-center gap-2 px-3 py-2 text-white/90 rounded-lg hover:bg-white/10 hover:text-white transition-all duration-200">
                        <span>⚗️</span>
                        <span class="hidden lg:inline">Ražošana</span>
                    </a>
                </div>

                <!-- User Nav -->
                <div class="flex items-center gap-2 md:gap-3 flex-wrap">
                    @auth
                        @if(auth()->user()->is_admin)
                            <a href="{{ route('admin.dashboard') }}" 
                               class="flex items-center gap-2 px-3 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all duration-200 text-sm font-medium">
                                <span>⚙️</span>
                                <span class="hidden md:inline">Admin</span>
                            </a>
                        @endif
                        
                        <a href="{{ route('cart.index') }}" 
                           class="relative flex items-center gap-2 px-3 py-2 text-white/90 rounded-lg hover:bg-white/10 hover:text-white transition-all duration-200">
                            <span class="text-lg">🛒</span>
                            <span class="hidden sm:inline">Grozs</span>
                            @if(auth()->user()->getCartCount() > 0)
                                <span class="absolute -top-1 -right-1 flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-500 rounded-full animate-pulse">
                                    {{ auth()->user()->getCartCount() }}
                                </span>
                            @endif
                        </a>

                        <a href="{{ route('orders.index') }}" 
                           class="flex items-center gap-2 px-3 py-2 text-white/90 rounded-lg hover:bg-white/10 hover:text-white transition-all duration-200">
                            <span>📦</span>
                            <span class="hidden md:inline">Pasūtījumi</span>
                        </a>

                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" 
                                    class="flex items-center gap-2 px-3 py-2 text-white/90 rounded-lg hover:bg-red-600/20 hover:text-white transition-all duration-200">
                                <span>🚪</span>
                                <span class="hidden md:inline">Iziet</span>
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" 
                           class="flex items-center gap-2 px-4 py-2 text-white/90 rounded-lg hover:bg-white/10 hover:text-white transition-all duration-200">
                            <span>🔐</span>
                            <span class="hidden sm:inline">Pieteikties</span>
                        </a>
                        <a href="{{ route('register') }}" 
                           class="flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all duration-200 font-medium">
                            <span>📝</span>
                            <span class="hidden sm:inline">Reģistrēties</span>
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-1 container mx-auto px-4 py-6">
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded-lg shadow-sm animate-in slide-in-from-top duration-300">
                <div class="flex items-center gap-3">
                    <span class="text-2xl">✅</span>
                    <p class="text-green-800 font-medium">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-lg shadow-sm animate-in slide-in-from-top duration-300">
                <div class="flex items-center gap-3">
                    <span class="text-2xl">❌</span>
                    <p class="text-red-800 font-medium">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        <!-- Validation -->
        @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-lg shadow-sm animate-in slide-in-from-top duration-300">
                <div class="flex items-start gap-3">
                    <span class="text-2xl">⚠️</span>
                    <div class="flex-1">
                        <p class="text-red-800 font-semibold mb-2">Lūdzu, labojiet šādas kļūdas:</p>
                        <ul class="list-disc list-inside space-y-1 text-red-700">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="mt-auto bg-gradient-to-r from-slate-800 to-slate-700 text-white">
        <div class="container mx-auto px-4 py-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Company Info -->
                <div class="space-y-4">
                    <h3 class="text-xl font-bold">Zivju Veikals</h3>
                    <p class="text-gray-300">
                        Visas garšīgākās zivis un kūpinājumi vienuviet!
                    </p>
                </div>

                <!-- Contact -->
                <div class="space-y-4">
                    <h3 class="text-xl font-bold flex items-center gap-2">
                        <span>📞</span> Kontakti
                    </h3>
                    <div class="space-y-2 text-gray-300">
                        <p>+371 12345678</p>
                        <p>✉️ info@zivjuveikals.lv</p>
                        <p>📍 Tukuma Nov., Bigauņciems</p>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="space-y-4">
                    <h3 class="text-xl font-bold flex items-center gap-2">
                        <span>🔗</span> Ātrās saites
                    </h3>
                    <div class="space-y-2">
                        <a href="{{ route('home') }}" class="block text-gray-300 hover:text-white transition-colors">Mājas</a>
                        <a href="{{ route('fish.shop') }}" class="block text-gray-300 hover:text-white transition-colors">Veikals</a>
                        <a href="{{ route('cart.index') }}" class="block text-gray-300 hover:text-white transition-colors">Grozs</a>
                        <a href="{{ route('orders.index') }}" class="block text-gray-300 hover:text-white transition-colors">Pasūtījumi</a>
                    </div>
                </div>

                <!-- Hours -->
                <div class="space-y-4">
                    <h3 class="text-xl font-bold flex items-center gap-2">
                        <span>🕒</span> Darba laiks
                    </h3>
                    <div class="space-y-2 text-gray-300">
                        <p>P.-P.: 8:00 - 18:00</p>
                        <p>S.: 9:00 - 16:00</p>
                        <p>Sv.: Slēgts</p>
                    </div>
                </div>
            </div>

            <div class="mt-8 pt-8 border-t border-gray-600 text-center text-gray-400">
                <p>&copy; 2025 KarkliBC. Visas tiesības aizsargātas.</p>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>

</html>