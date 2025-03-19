<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>ISI BURGER</title>

    <!-- Animate.css via CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Bootstrap CSS via CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <!-- Styles personnalisés -->
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
            background-color: #1a1a1a;
            color: #ffffff;
        }

        #app {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .navbar {
            background-color: #333333;
        }

        .navbar-brand,
        .nav-link {
            color: #ffffff !important;
        }

        .nav-link:hover {
            color: #ff6f61 !important;
        }

        .hero-section {
            background: url('https://images.unsplash.com/photo-1513104890138-7c749659a591?q=80&w=1000&auto=format&fit=crop') no-repeat center center/cover;
            height: 500px;
            width: 100vw;
            /* Utilise toute la largeur de la fenêtre */
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
        }

        .btn-primary {
            background-color: #ff6f61;
            border: none;
        }

        .btn-primary:hover {
            background-color: #e65a50;
        }

        .dropdown-menu {
            background-color: #333333;
            border: 1px solid #444444;
        }

        .dropdown-item {
            color: #ffffff;
        }

        .dropdown-item:hover {
            background-color: #444444;
            color: #ffffff;
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .nav-link {
            font-size: 1.1rem;
        }

        .dropdown-item {
            font-size: 1rem;
        }

        main {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .content {
            flex-grow: 1;
        }

        /* Suppression des marges et paddings par défaut */
        .container-fluid {
            padding-left: 0;
            padding-right: 0;
        }
    </style>
</head>

<body>
    <div id="app">
        <!-- Barre de navigation personnalisée -->
        <nav class="navbar navbar-expand-md navbar-dark shadow-sm">
            <div class="container-fluid"> <!-- Utilisation de container-fluid -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    <i class="bi bi-house-door me-2"></i>ISI BURGER
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        @auth
                        @if (Auth::user()->role === 'client')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('home') }}">
                                <i class="bi bi-house me-2"></i>Accueil
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('orders.index') }}">
                                <i class="bi bi-cart me-2"></i>Mes Commandes
                            </a>
                        </li>
                        @endif
                        @endauth
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                        @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="bi bi-box-arrow-in-right me-2"></i>{{ __('Connexion') }}
                            </a>
                        </li>
                        @endif

                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">
                                <i class="bi bi-person-plus me-2"></i>{{ __('Inscription') }}
                            </a>
                        </li>
                        @endif
                        @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <i class="bi bi-person-circle me-2"></i>{{ Auth::user()->name }}
                            </a>
                            @if (Auth::user()->role === 'gestionnaire')
                            <p class="text-white ms-3">Rôle de l'utilisateur : {{ Auth::user()->role }}</p>
                            @endif
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    <i class="bi bi-box-arrow-left me-2"></i>{{ __('Déconnexion') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            <div class="content">
                @yield('content')
            </div>
        </main>
    </div>

    <!-- Bootstrap JS via CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>