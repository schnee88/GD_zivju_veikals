<!DOCTYPE html>
<html lang="lv">

<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Zivju Veikals</title>
     <style>
          /* Pamata stili */
          body {
               font-family: Arial, sans-serif;
               margin: 0;
               padding: 0;
               line-height: 1.6;
          }

          .container {
               max-width: 1200px;
               margin: 0 auto;
               padding: 0 20px;
          }

          /* Navigācija */
          nav {
               background: #2c3e50;
               color: white;
               padding: 1rem 0;
               margin-bottom: 20px;
          }

          nav .container {
               display: flex;
               justify-content: space-between;
               align-items: center;
          }

          nav a {
               color: white;
               text-decoration: none;
               margin: 0 10px;
               padding: 5px 10px;
          }

          nav a:hover {
               background: #34495e;
               border-radius: 3px;
          }

          /* Ziņojumi */
          .alert {
               padding: 12px;
               margin: 15px 0;
               border-radius: 4px;
               border: 1px solid transparent;
          }

          .alert-success {
               background: #d4edda;
               color: #155724;
               border-color: #c3e6cb;
          }

          .alert-error {
               background: #f8d7da;
               color: #721c24;
               border-color: #f5c6cb;
          }

          /* Formas */
          .form-group {
               margin-bottom: 15px;
          }

          .form-group label {
               display: block;
               margin-bottom: 5px;
               font-weight: bold;
          }

          .form-group input {
               width: 100%;
               padding: 8px;
               border: 1px solid #ddd;
               border-radius: 4px;
               box-sizing: border-box;
          }

          button {
               background: #3498db;
               color: white;
               padding: 10px 20px;
               border: none;
               border-radius: 4px;
               cursor: pointer;
          }

          button:hover {
               background: #2980b9;
          }
     </style>
</head>

<body>
     <nav>
          <div class="container">
               <div>
                    <a href="{{ route('home') }}">Mājas</a>
                    <a href="{{ route('fish.index') }}">Zivis</a>
               </div>
               <div>
                    @auth
                    @if(auth()->user()->is_admin)
                    <a href="{{ route('admin.dashboard') }}">Admin Panelis</a>
                    @endif
                    <a href="{{ route('orders.index') }}">Mani pasūtījumi</a>
                    <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                         @csrf
                         <button type="submit" style="background:#e74c3c; padding:5px 10px;">
                              Iziet
                         </button>
                    </form>
                    @else
                    <a href="{{ route('login') }}">Pieteikties</a>
                    <a href="{{ route('register') }}">Reģistrēties</a>
                    @endauth
               </div>
          </div>
     </nav>

     <div class="container">
          <!-- Ziņojumu parādīšana -->
          @if(session('success'))
          <div class="alert alert-success">
               {{ session('success') }}
          </div>
          @endif

          @if(session('error'))
          <div class="alert alert-error">
               {{ session('error') }}
          </div>
          @endif

          <!-- Galvenais saturs -->
          @yield('content')
     </div>
</body>

</html>