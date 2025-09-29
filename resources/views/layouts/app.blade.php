<!DOCTYPE html>
<html lang="lv">

<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Zivju Veikals</title>
     <style>
          /* Base Styles */
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

          h1 {
               text-align: center;
               margin-top: 20px;
               margin-bottom: 20px;
          }

          /* Navigation */
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

          /* Alerts */
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

          /* Forms */
          .form-group {
               margin-bottom: 15px;
          }

          .form-group label {
               display: block;
               margin-bottom: 5px;
               font-weight: bold;
          }

          .form-group input,
          .form-group textarea,
          .form-group select {
               width: 100%;
               padding: 8px;
               border: 1px solid #ddd;
               border-radius: 4px;
               box-sizing: border-box;
          }

          form input[type="file"] {
               border: none;
               padding-left: 0;
          }

          /* Buttons */
          button {
               background: #3498db;
               color: white;
               padding: 10px 20px;
               border: none;
               border-radius: 4px;
               cursor: pointer;
               transition: background 0.3s;
          }

          button:hover {
               background: #2980b9;
          }

          .delete-btn {
               background: #dc3545;
          }

          .delete-btn:hover {
               background: #c82333;
          }

          .edit-btn {
               background: green;
          }

          .edit-btn:hover {
               background: darkgreen;
          }

          /* Fish Grid & Cards */
          .fish-grid {
               display: flex;
               flex-wrap: wrap;
               justify-content: center;
               gap: 20px;
               padding: 20px 0;
          }

          .fish-card {
               border: 1px solid #ddd;
               border-radius: 12px;
               padding: 20px;
               text-align: center;
               width: 300px;
               min-height: 500px;
               box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
               display: flex;
               flex-direction: column;
               justify-content: space-between;
               background-color: #fff;
               transition: transform 0.3s ease, box-shadow 0.3s ease;
          }

          .fish-card:hover {
               transform: translateY(-5px);
               box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15) !important;
          }

          .fish-card a:hover {
               background: #2980b9 !important;
               transform: scale(1.05);
          }

          .fish-card img:hover {
               opacity: 0.9;
          }

          .fish-card h2 {
               margin-top: 0;
               margin-bottom: 12px;
               color: #2c3e50;
               font-size: 1.4em;
               min-height: 50px;
               display: flex;
               align-items: center;
               justify-content: center;
          }

          .fish-card .price {
               font-size: 1.3em;
               font-weight: bold;
               color: #27ae60;
               margin: 10px 0;
          }

          .fish-card img {
               width: 100%;
               height: 200px;
               object-fit: contain;
               display: block;
               margin-bottom: 15px;
               border-radius: 8px;
               background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
               padding: 15px;
               border: 1px solid #e9ecef;
               transition: opacity 0.3s ease;
          }

          .fish-card .no-image {
               width: 100%;
               height: 200px;
               background-color: #f8f8f8;
               display: flex;
               align-items: center;
               justify-content: center;
               color: #999;
               border: 1px dashed #ccc;
               border-radius: 4px;
               margin-bottom: 15px;
               font-style: italic;
          }

          .fish-card p {
               font-size: 0.95em;
               color: #555;
               margin-bottom: 8px;
          }

          .fish-card a {
               display: inline-block;
               background: #3498db;
               color: white;
               padding: 10px 20px;
               border-radius: 6px;
               text-decoration: none;
               margin-top: auto;
               transition: background 0.3s ease, transform 0.2s ease;
               font-weight: bold;
          }

          .fish-card a:hover {
               background: #2980b9;
               transform: scale(1.05);
          }

          /* Batch Cards */
          .batch-card a:hover {
               background: #229954 !important;
               transform: translateY(-2px);
          }

          .batch-card a:hover {
               opacity: 0.9;
               transform: translateY(-2px);
          }

          .batch-card button:hover {
               background: #c0392b !important;
               transform: translateY(-2px);
          }

          /* Table Rows */
          .fish-row {
               transition: all 0.3s ease;
          }

          .fish-row:hover {
               background: #f0f0f0 !important;
          }

          /* Responsive Design */
          @media (max-width: 768px) {
               .batch-card h2 {
                    font-size: 1.2em !important;
               }

               .batch-card table {
                    font-size: 0.9em;
               }

               .batch-card td,
               .batch-card th {
                    padding: 8px !important;
               }

               .batch-card a {
                    padding: 8px 12px !important;
                    font-size: 0.9em;
               }

               .fish-card {
                    width: calc(100% - 40px);
                    min-height: auto;
               }

               .fish-grid {
                    gap: 15px;
               }

               .fish-row>div {
                    grid-template-columns: 1fr !important;
                    gap: 10px !important;
               }

               .batch-card>div:last-child {
                    flex-direction: column;
                    align-items: stretch !important;
               }

               .batch-card>div:last-child>div {
                    width: 100%;
                    justify-content: center;
               }
          }
     </style>
</head>

<body>
     <nav>
          <div class="container">
               <div>
                    <a href="{{ route('home') }}">Mājas</a>
                    <a href="{{ route('fish.index') }}">Zivis</a>
                    <a href="{{ route('batches.public') }}">Žāvējumi</a>
               </div>
               <div>
                    @auth
                    @if(auth()->user()->is_admin)
                    <a href="{{ route('admin.dashboard') }}">Admin Panelis</a>
                    @endif
                    <a href="{{ route('fish.index') }}">Mani pasūtījumi</a>
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

          <!-- Main-->
          @yield('content')
     </div>
</body>

</html>