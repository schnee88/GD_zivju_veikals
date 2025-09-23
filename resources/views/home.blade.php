@extends('layouts.app')

@section('content')
    <h1>Laipni lūgti Ģimenes Zivju Veikaliņā!</h1>
    
    <div class="intro">
        <p>Mēs piedāvājam svaigas un garšīgas zivis no Latvijas jūras un tīriem ezeriem. 
           Visas mūsu zivis tiek nozvejotas ar mīlestību un rūpēm par vidi.</p>
        
        <p>Apskatiet mūsu <a href="{{ route('fish.index') }}">zivju piedāvājumu</a> un izveidojiet savu pasūtījumu!</p>
    </div>

    <div class="features">
        <h2>Izvēlies mūsu zivis!</h2>
        <p>Lai veiktu pasūtījumu <a href="{{ route('register') }}"> reģistrējies šeit</a> !</p>
    </div>

    <div style="text-align: center; margin-top: 30px; padding: 20px; background: #e8f4fd; border-radius: 8px;">
        <h3 style="color: #2c3e50;">Kā pasūtīt?</h3>
        <p>Zvaniet mums pa telefonu: <strong style="font-size: 1.2em;">+371 XXXXXXXX</strong></p>
        <p>Darba laiks: P-P 9:00-18:00</p>
    </div>
    
@endsection