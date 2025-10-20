@extends('layouts.app')

@section('content')
<div class="home-hero">
    <h1>🐟 Laipni lūgti Ģimenes Zivju Veikaliņā! 🐟</h1>
    <p>Svaigas un garšīgas zivis tieši no jūras līdz jūsu galdam</p>
    <p>Augstākā kvalitāte • Svaigums garantēts • Ātri pasūtījumi</p>
    <a href="{{ route('fish.catalog') }}">Apskatīt vispārigo produkciju →</a>
    <br>
    <a href="{{ route('batches.public') }}">Apskaīt pieejamo produkciju, kūpinājumus →</a>
    <br>
    <h2>Kā pasūtīt preci? 🐟</h2>
    <p> Veicat reģistrāciju <a href="{{ route('register') }}">šeit</a> , pēc tam izvēlaties pieejamo produkciju un veicat pasūtījumu.
     Būs janorāda Jūsu telefona numurs uz kuru adminstrātors veiks apstiprinājuma zvanu, vai ari veciet zvanu paši uz numuru 📞 +371 12345678</p>
</div>

<div class="features-grid">
    <h2>Izvēlies mūsu zivis!</h2>
</div>

<div style="text-align: center; margin-top: 30px; padding: 20px; background: 
#e8f4fd; border-radius: 8px;">
    <h3 style="color: 
#2c3e50;">Kā pasūtīt?</h3>
    <p>Zvaniet mums pa telefonu: <strong style="font-size: 1.2em;">+371 XXXXXXXX</strong></p>
    <p>Darba laiks: P-P 9:00-18:00</p>
</div>
@endsection