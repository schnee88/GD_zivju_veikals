<!DOCTYPE html>
<html lang="lv">

<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Zivju Veikals</title>
     <link rel="stylesheet" href="{{ asset('css/app.css') }}">
     @stack('styles')
</head>

<body>
     <nav>
          <div class="container">
               <div>
                    <a href="{{ route('home') }}">🏠 Mājas</a>
                    <a href="{{ route('fish.catalog') }}">🐟 Zivju katalogs</a>
                    <a href="{{ route('fish.shop') }}">🛍️ Veikals</a>
                    <a href="{{ route('batches.public') }}">⚗️ Ieplānotā Produkcijas Izgatavošana</a>
               </div>
               <div>
                    @auth
                         @if(auth()->user()->is_admin)
                              <a href="{{ route('admin.dashboard') }}">⚙️ Admin Panelis</a>
                         @endif
                         <a href="{{ route('cart.index') }}">
                              🛒 Grozs
                              @if(auth()->user()->getCartCount() > 0)
                                   <span class="cart-badge">
                                        {{ auth()->user()->getCartCount() }}
                                   </span>
                              @endif
                         </a>
                         <a href="{{ route('orders.index') }}">📦 Mani pasūtījumi</a>
                         <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                              @csrf
                              <button type="submit">
                                   🚪 Iziet
                              </button>
                         </form>
                    @else
                         <a href="{{ route('login') }}">🔐 Pieteikties</a>
                         <a href="{{ route('register') }}">📝 Reģistrēties</a>
                    @endauth
               </div>
          </div>
     </nav>

     <div class="container">
          @if(session('success'))
               <div class="alert alert-success">
                    ✅ {{ session('success') }}
               </div>
          @endif

          @if(session('error'))
               <div class="alert alert-error">
                    ❌ {{ session('error') }}
               </div>
          @endif

          @yield('content')
     </div>

     <footer>
          <div class="container">
               <div class="footer-content">
                    <div class="footer-section">
                         <h3>Zivju Veikals</h3>
                         <p>Viss garšīgākās zivis un kūpinājumi vienuviet!</p>
                    </div>
                    <div class="footer-section">
                         <h3>📞 Kontakti</h3>
                         <p>+371 12345678</p>
                         <p>✉️ info@zivjuveikals.lv</p>
                         <p>📍 Tukuma Nov., Bigauņciems, Latvija</p>
                    </div>
                    <div class="footer-section">
                         <h3>🔗 Ātrās saites</h3>
                         <p><a href="{{ route('home') }}">Mājas</a></p>
                         <p><a href="{{ route('fish.shop') }}">Veikals</a></p>
                         <p><a href="{{ route('cart.index') }}">Grozs</a></p>
                         <p><a href="{{ route('orders.index') }}">Mani pasūtījumi</a></p>
                    </div>
                    <div class="footer-section">
                         <h3>🕒 Darba laiks</h3>
                         <p>P.-P.: 8:00 - 18:00</p>
                         <p>S.: 9:00 - 16:00</p>
                         <p>Sv.: Slēgts</p>
                    </div>
               </div>
               <div class="footer-bottom">
                    <p>&copy; 2025 KarkliBC. Visas tiesības aizsargātas.</p>
               </div>
          </div>
     </footer>
</body>

</html>