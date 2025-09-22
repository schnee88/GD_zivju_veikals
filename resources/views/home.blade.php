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
@endsection