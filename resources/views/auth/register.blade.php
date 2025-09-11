@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Reģistrācija</h1>

        @if($errors->any())
            <div class="alert alert-error">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="form-group">
                <label for="name">Vārds:</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required autofocus>
            </div>

            <div class="form-group">
                <label for="email">E-pasts:</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required>
            </div>

            <div class="form-group">
                <label for="phone">Telefons:</label>
                <input type="text" name="phone" id="phone" value="{{ old('phone') }}" required 
                       placeholder="22222222">
                <small>Formāts: Var vadīt ar vai bez valsts koda</small>
            </div>

            <div class="form-group">
                <label for="password">Parole:</label>
                <input type="password" name="password" id="password" required>
            </div>

            <div class="form-group">
                <label for="password_confirmation">Parole atkārtoti:</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required>
            </div>

            <button type="submit">Reģistrēties</button>
        </form>

        <p>Jau ir konts? <a href="{{ route('login') }}">Pieslēgties</a></p>
    </div>
@endsection