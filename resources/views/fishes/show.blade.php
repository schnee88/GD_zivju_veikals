<!DOCTYPE html>
<html>
<head>
    <title>{{ $fish->name }} - Zivju Veikals</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            margin: 20px;
            line-height: 1.6;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .fish-detail {
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .fish-image {
            max-width: 100%;
            height: auto;
            margin-bottom: 15px;
        }
        .btn {
            display: inline-block;
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin-right: 10px;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        .availability {
            margin-top: 15px;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 4px;
        }
        .order-form {
            margin-top: 20px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="number"], input[type="tel"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .error {
            color: red;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="{{ url('/') }}" class="btn">← Atpakaļ uz galveno lapu</a>
        
        <div class="fish-detail">
            <h1>{{ $fish->name }}</h1>
            
            @if($fish->image)
                <img src="{{ asset('storage/' . $fish->image) }}" alt="{{ $fish->name }}" class="fish-image">
            @endif
            
            <p><strong>Cena:</strong> {{ number_format($fish->price, 2) }} €</p>
            <p>{{ $fish->description }}</p>
            
            <div class="availability">
                <h3>Pieejamība:</h3>
                @if($fish->availabilityDays && $fish->availabilityDays->count() > 0)
                    <ul>
                        @foreach($fish->availabilityDays as $day)
                            <li>{{ $day->day_name }}</li>
                        @endforeach
                    </ul>
                @else
                    <p>Šobrīd nav pieejama</p>
                @endif
            </div>
        </div>

        @auth
            <div class="order-form">
                <h2>Pasūtīt</h2>
                
                @if(session('success'))
                    <div style="color: green; margin-bottom: 15px;">
                        {{ session('success') }}
                    </div>
                @endif
                
                @if(session('error'))
                    <div style="color: red; margin-bottom: 15px;">
                        {{ session('error') }}
                    </div>
                @endif
                
                <form action="{{ route('order.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="fish_id" value="{{ $fish->id }}">
                    
                    <div class="form-group">
                        <label for="quantity">Daudzums:</label>
                        <input type="number" id="quantity" name="quantity" min="1" value="1" required>
                        @error('quantity')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="phone">Telefona numurs (LV formāts):</label>
                        <input type="tel" id="phone" name="phone" placeholder="+3712XXXXXXX" required>
                        @error('phone')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <button type="submit" class="btn">Pasūtīt</button>
                </form>
            </div>
        @else
            <div style="margin-top: 20px; padding: 15px; background-color: #f8f9fa; border-radius: 4px;">
                <p>Lai pasūtītu, jums ir <a href="{{ route('login') }}">jāpieslēdzas</a> vai <a href="{{ route('register') }}">jāreģistrējas</a>.</p>
            </div>
        @endauth
    </div>
</body>
</html>