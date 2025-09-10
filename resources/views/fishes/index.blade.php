<!DOCTYPE html>
<html>
<head>
    <title>Zivju Veikals</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .fish-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
        .fish-card { border: 1px solid #ddd; padding: 15px; border-radius: 5px; }
    </style>
</head>
<body>
    <h1>Ģimenes Zivju Veikaliņš</h1>
    
    <div class="fish-grid">
        @foreach($fishes as $fish)
            <div class="fish-card">
                <h2>{{ $fish->name }}</h2>
                <p>Cena: {{ $fish->price }} €</p>
                <p>{{ $fish->description }}</p>
                <a href="{{ route('fish.show', $fish->id) }}">Skatīt vairāk</a>
            </div>
        @endforeach
    </div>
</body>
</html>