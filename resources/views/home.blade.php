@extends('layouts.app')

@section('content')


    <!-- Hero Section -->
    <div class="modern-hero">
        <div class="hero-content">
            <div class="hero-badge">🐟 Kvalitāte garantēta</div>
            <h1 class="hero-title">Ģimenes Zivju Veikals</h1>
            <p class="hero-subtitle">Svaigas un garšīgas zivis</p>

            <div class="hero-features">
                <div class="hero-feature">
                    <span class="hero-feature-icon">✓</span>
                    <span>Augstākā kvalitāte</span>
                </div>
                <div class="hero-feature">
                    <span class="hero-feature-icon">✓</span>
                    <span>Izdevīgākās cenas</span>
                </div>
                <div class="hero-feature">
                    <span class="hero-feature-icon">✓</span>
                    <span>Laipna apkalpošana</span>
                </div>
            </div>

            <div class="hero-actions">
                <a href="{{ route('fish.shop') }}" class="btn-hero-primary">
                    <span>🛒</span>
                    <span>Pieejamā produkcija</span>
                </a>
                <a href="{{ route('fish.catalog') }}" class="btn-hero-secondary">
                    <span>📖</span>
                    <span>Pilns katalogs</span>
                </a>
            </div>
        </div>
    </div>

    <div class="features-section">
        <div class="section-header">
            <h2 class="section-title">Kāpēc izvēlēties mūs?</h2>
            <p class="section-subtitle">Mēs piedāvājam labāko kvalitāti un servisu zivju produktu jomā</p>
        </div>

        <div class="features-grid">
            <div class="feature-card">
                <span class="feature-icon">🐟</span>
                <h3 class="feature-title">Svaigs produkts</h3>
                <p class="feature-description">Zivis tiek piegādātas katru dienu no uzticamiem piegādātājiem</p>
            </div>

            <div class="feature-card">
                <span class="feature-icon">⭐</span>
                <h3 class="feature-title">Augsta kvalitāte</h3>
                <p class="feature-description">Rūpīgi atlasīts sortiments un kvalitātes kontrole</p>
            </div>

            <div class="feature-card">
                <span class="feature-icon">🚚</span>
                <h3 class="feature-title">Ātra apkalpošana</h3>
                <p class="feature-description">Pasūtījums tiek apstrādāts ātri un profesionāli</p>
            </div>

            <div class="feature-card">
                <span class="feature-icon">💰</span>
                <h3 class="feature-title">Labas cenas</h3>
                <p class="feature-description">Konkurētspējīgas cenas bez kompromisiem ar kvalitāti</p>
            </div>

            <div class="feature-card">
                <span class="feature-icon">👨‍👩‍👧‍👦</span>
                <h3 class="feature-title">Ģimenes bizness</h3>
                <p class="feature-description">Personīga pieeja katram klientam</p>
            </div>

            <div class="feature-card">
                <span class="feature-icon">📞</span>
                <h3 class="feature-title">Vienmēr sazvanāmi</h3>
                <p class="feature-description">Mūsu komanda vienmēr gatava palīdzēt</p>
            </div>
        </div>
    </div>

    <div class="how-to-order">
        <div class="section-header">
            <h2 class="section-title">Kā veikt pasūtījumu?</h2>
            <p class="section-subtitle">Vienkārši trīs soļi līdz svaigām zivīm</p>
        </div>

        <div class="order-steps">
            <div class="order-step">
                <div class="step-number">1</div>
                <h3 class="step-title">Reģistrējieties</h3>
                <p class="step-description">
                    Izveidojiet kontu mūsu vietnē
                    <a href="{{ route('register') }}" style="color: #3b82f6; font-weight: 600;">šeit</a>
                </p>
            </div>

            <div class="order-step">
                <div class="step-number">2</div>
                <h3 class="step-title">Izvēlieties produktus</h3>
                <p class="step-description">Pārlūkojiet mūsu pieejamo sortimentu un pievienojiet grozam</p>
            </div>

            <div class="order-step">
                <div class="step-number">3</div>
                <h3 class="step-title">Veiciet pasūtījumu</h3>
                <p class="step-description">Veicot pasūtījumu ir obligāti jānorāda telefona numurs</p>
            </div>

            <div class="order-step">
                <div class="step-number">4</div>
                <h3 class="step-title">Pasūtījuma apstiprināšana</h3>
                <p class="step-description">Mūsu administrators sazināsies ar jums, lai apstiprinātu pasūtījumu</p>
            </div>
        </div>
    </div>

    <div class="contact-cta">
        <h3>Vēlaties pasūtīt pa tālruni?</h3>
        <p>Zvaniet mums darba dienās</p>
        <a href="tel:+37112345678" class="phone-number">📞 +371 12345678</a>
        <p class="working-hours">⏰ Darba laiks: Pirmdiena - Piektdiena, 9:00 - 18:00</p>
    </div>
@endsection