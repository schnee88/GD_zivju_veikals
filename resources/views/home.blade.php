@extends('layouts.app')

@section('content')

<!-- Hero Section -->
<div class="relative overflow-hidden rounded-3xl my-8 bg-gradient-to-br from-blue-900 via-blue-700 to-blue-500 text-white shadow-2xl">
    <!-- Animated Background Elements -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute -top-1/2 -right-1/4 w-[500px] h-[500px] bg-white/10 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute -bottom-1/3 -left-1/4 w-[400px] h-[400px] bg-white/5 rounded-full blur-3xl animate-pulse delay-1000"></div>
    </div>

    <div class="relative z-10 px-6 md:px-12 py-16 md:py-24 max-w-4xl mx-auto text-center">
        <!-- Badge -->
        <div class="inline-flex items-center gap-2 px-5 py-2 mb-6 bg-white/20 backdrop-blur-md rounded-full border border-white/30 text-sm font-semibold animate-in fade-in zoom-in duration-500">
            <span class="text-lg">🐟</span>
            <span>Kvalitāte garantēta</span>
        </div>

        <!-- Title -->
        <h1 class="text-4xl md:text-6xl font-extrabold mb-6 leading-tight tracking-tight animate-in fade-in slide-in-from-bottom duration-700">
            Ģimenes Zivju Veikals
        </h1>

        <!-- Subtitle -->
        <p class="text-xl md:text-2xl mb-8 text-blue-100 font-medium animate-in fade-in slide-in-from-bottom duration-700 delay-100">
            Svaigas un garšīgas zivis tieši jums
        </p>

        <!-- Features -->
        <div class="flex flex-wrap justify-center gap-6 mb-10 animate-in fade-in slide-in-from-bottom duration-700 delay-200">
            <div class="flex items-center gap-2 text-base md:text-lg font-medium">
                <span class="text-green-400 text-2xl">✓</span>
                <span>Augstākā kvalitāte</span>
            </div>
            <div class="flex items-center gap-2 text-base md:text-lg font-medium">
                <span class="text-green-400 text-2xl">✓</span>
                <span>Izdevīgākās cenas</span>
            </div>
            <div class="flex items-center gap-2 text-base md:text-lg font-medium">
                <span class="text-green-400 text-2xl">✓</span>
                <span>Laipna apkalpošana</span>
            </div>
        </div>

        <!-- CTA Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center animate-in fade-in slide-in-from-bottom duration-700 delay-300">
            <a href="{{ route('fish.shop') }}" 
               class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-white text-blue-900 rounded-xl font-bold text-lg shadow-xl hover:bg-blue-50 hover:shadow-2xl hover:-translate-y-1 transition-all duration-300">
                <span class="text-xl">🛒</span>
                <span>Pieejamā produkcija</span>
            </a>
            <a href="{{ route('fish.catalog') }}" 
               class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-white/15 backdrop-blur-md text-white rounded-xl font-bold text-lg border-2 border-white/30 hover:bg-white/25 hover:border-white/50 hover:-translate-y-1 transition-all duration-300">
                <span class="text-xl">📖</span>
                <span>Pilns katalogs</span>
            </a>
        </div>
    </div>
</div>

<!-- Features Section -->
<div class="my-16">
    <div class="text-center mb-12">
        <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-4">
            Kāpēc izvēlēties mūs?
        </h2>
        <p class="text-lg text-gray-600 max-w-2xl mx-auto">
            Mēs piedāvājam labāko kvalitāti un servisu zivju produktu jomā
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="group p-8 bg-white rounded-2xl border border-gray-200 shadow-sm hover:shadow-xl hover:border-blue-200 hover:-translate-y-2 transition-all duration-300">
            <div class="text-5xl mb-4">🐟</div>
            <h3 class="text-xl font-bold text-gray-900 mb-3">Svaigs produkts</h3>
            <p class="text-gray-600 leading-relaxed">
                Zivis tiek piegādātas no uzticamiem piegādātājiem
            </p>
        </div>

        <div class="group p-8 bg-white rounded-2xl border border-gray-200 shadow-sm hover:shadow-xl hover:border-blue-200 hover:-translate-y-2 transition-all duration-300">
            <div class="text-5xl mb-4">⭐</div>
            <h3 class="text-xl font-bold text-gray-900 mb-3">Augsta kvalitāte</h3>
            <p class="text-gray-600 leading-relaxed">
                Rūpīgi atlasīts sortiments un kvalitātes kontrole
            </p>
        </div>

        <div class="group p-8 bg-white rounded-2xl border border-gray-200 shadow-sm hover:shadow-xl hover:border-blue-200 hover:-translate-y-2 transition-all duration-300">
            <div class="text-5xl mb-4">🚚</div>
            <h3 class="text-xl font-bold text-gray-900 mb-3">Ātra apkalpošana</h3>
            <p class="text-gray-600 leading-relaxed">
                Pasūtījums tiek apstrādāts ātri
            </p>
        </div>

        <div class="group p-8 bg-white rounded-2xl border border-gray-200 shadow-sm hover:shadow-xl hover:border-blue-200 hover:-translate-y-2 transition-all duration-300">
            <div class="text-5xl mb-4">💰</div>
            <h3 class="text-xl font-bold text-gray-900 mb-3">Labas cenas</h3>
            <p class="text-gray-600 leading-relaxed">
                Konkurētspējīgas cenas bez kompromisiem ar kvalitāti
            </p>
        </div>

        <div class="group p-8 bg-white rounded-2xl border border-gray-200 shadow-sm hover:shadow-xl hover:border-blue-200 hover:-translate-y-2 transition-all duration-300">
            <div class="text-5xl mb-4">👨‍👩‍👧‍👦</div>
            <h3 class="text-xl font-bold text-gray-900 mb-3">Ģimenes bizness</h3>
            <p class="text-gray-600 leading-relaxed">
                Personīga pieeja katram klientam
            </p>
        </div>

        <div class="group p-8 bg-white rounded-2xl border border-gray-200 shadow-sm hover:shadow-xl hover:border-blue-200 hover:-translate-y-2 transition-all duration-300">
            <div class="text-5xl mb-4">📞</div>
            <h3 class="text-xl font-bold text-gray-900 mb-3">Vienmēr sazvanāmi</h3>
            <p class="text-gray-600 leading-relaxed">
                Mūsu komanda vienmēr gatava palīdzēt
            </p>
        </div>
    </div>
</div>

<!-- How to Order Section -->
<div class="my-16 p-8 md:p-12 bg-gradient-to-br from-gray-50 to-blue-50 rounded-3xl border border-blue-100">
    <div class="text-center mb-12">
        <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-4">
            Kā veikt pasūtījumu?
        </h2>
        <p class="text-lg text-gray-600 max-w-2xl mx-auto">
            Vienkārši četri soļi līdz svaigām zivīm
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 max-w-6xl mx-auto">
        <div class="text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 mb-6 bg-gradient-to-br from-blue-600 to-blue-700 text-white rounded-full text-2xl font-bold shadow-lg">
                1
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-3">Reģistrējieties</h3>
            <p class="text-gray-600 leading-relaxed">
                Izveidojiet kontu mūsu vietnē 
                <a href="{{ route('register') }}" class="text-blue-600 font-semibold hover:underline">šeit</a>
            </p>
        </div>

        <div class="text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 mb-6 bg-gradient-to-br from-blue-600 to-blue-700 text-white rounded-full text-2xl font-bold shadow-lg">
                2
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-3">Izvēlieties produktus</h3>
            <p class="text-gray-600 leading-relaxed">
                Pārlūkojiet mūsu pieejamo sortimentu un pievienojiet grozam
            </p>
        </div>

        <div class="text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 mb-6 bg-gradient-to-br from-blue-600 to-blue-700 text-white rounded-full text-2xl font-bold shadow-lg">
                3
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-3">Veiciet pasūtījumu</h3>
            <p class="text-gray-600 leading-relaxed">
                Veicot pasūtījumu ir obligāti jānorāda telefona numurs
            </p>
        </div>

        <div class="text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 mb-6 bg-gradient-to-br from-blue-600 to-blue-700 text-white rounded-full text-2xl font-bold shadow-lg">
                4
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-3">Apstiprināšana</h3>
            <p class="text-gray-600 leading-relaxed">
                Mūsu administrators sazināsies ar jums, lai apstiprinātu
            </p>
        </div>
    </div>
</div>

<!-- Contact CTA -->
<div class="my-16 p-8 md:p-12 bg-gradient-to-br from-green-600 to-green-700 text-white rounded-3xl shadow-2xl text-center">
    <h3 class="text-2xl md:text-3xl font-bold mb-4">
        Vēlaties pasūtīt pa tālruni?
    </h3>
    <p class="text-lg md:text-xl text-green-100 mb-6">
        Zvaniet mums darba dienās
    </p>
    <a href="tel:+37112345678" 
       class="inline-flex items-center gap-3 px-8 py-4 bg-white/20 backdrop-blur-md text-white rounded-full text-xl md:text-2xl font-bold border-2 border-white/30 hover:bg-white/30 hover:scale-105 transition-all duration-300 mb-6">
        <span class="text-2xl">📞</span>
        <span>+371 12345678</span>
    </a>
    <p class="text-green-100 text-base md:text-lg">
        ⏰ Darba laiks: Pirmdiena - Piektdiena, 9:00 - 18:00
    </p>
</div>

@endsection