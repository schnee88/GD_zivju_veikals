@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Pieteikšanās</h1>

        @if($errors->any())
            <div class="alert alert-error">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label for="email">E-pasts:</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus>
            </div>

            <div class="form-group">
                <label for="password">Parole:</label>
                <input type="password" name="password" id="password" required>
            </div>

            <button type="submit">Pieslēgties</button>
        </form>

        <p>Nav konta? <a href="{{ route('register') }}">Reģistrēties</a></p>
    </div>
@endsection