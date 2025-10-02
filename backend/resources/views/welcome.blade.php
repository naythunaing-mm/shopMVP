<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>POS Dashboard</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <style>
        body {
            font-family: 'Instrument Sans', sans-serif;
            background: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        header {
            background: #1b1b18;
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header a {
            color: white;
            text-decoration: none;
            margin-left: 15px;
            padding: 6px 12px;
            border: 1px solid white;
            border-radius: 4px;
            font-size: 14px;
        }

        header a:hover {
            background: white;
            color: #1b1b18;
        }

        main {
            display: flex;
            justify-content: center;
            align-items: center;
            height: calc(100vh - 60px);
            flex-direction: column;
            text-align: center;
        }

        .dashboard-card {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            max-width: 400px;
        }

        .dashboard-card h1 {
            font-size: 24px;
            margin-bottom: 15px;
        }

        .dashboard-card p {
            color: #555;
            font-size: 16px;
        }

        /* Logo styling */
        .logo {
            display: block;
            margin: 20px auto;
            max-width: 150px;
            height: auto;
        }
    </style>
</head>
<body>

    <!-- Header -->
    <header>
        <div><strong>POS Dashboard</strong></div>
        @if (Route::has('login'))
            <nav>
                @auth
                    <a href="{{ url('/shop-owner/dashboard') }}">Dashboard</a>
                @else
                    <a href="{{ route('login') }}">Login</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}">Register</a>
                    @endif
                @endauth
            </nav>
        @endif
    </header>

    <!-- Main -->
    <main>
        <div class="dashboard-card">
            <h1>Welcome to the POS System</h1>

            <!-- Logo -->
            <img src="{{ asset('default_logo.png') }}" alt="POS Logo">

            <p>Guest user before login. Please log in to access your dashboard.</p>
        </div>
    </main>

</body>
</html>
