<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>ISI BURGER</title>

    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Bootstrap CSS via CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <!-- Styles personnalisés -->
    <style>
        body {
            background-color: #1a1a1a;
            color: #ffffff;
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
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
        }

        .hero-section h1 {
            font-size: 4rem;
            font-weight: bold;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
            animation: fadeInDown 5s infinite;
        }

        .hero-section p {
            font-size: 1.5rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
            animation: fadeInUp 5s infinite;
        }

        .btn-primary {
            background-color: #ff6f61;
            border: none;
            padding: 10px 20px;
            font-size: 1.2rem;
        }

        .btn-primary:hover {
            background-color: #e65a50;
        }

        .card {
            background-color: #333333;
            color: #ffffff;
            border: none;
            transition: transform 0.3s ease-in-out;
        }

        .card:hover {
            transform: translateY(-10px);
        }

        .card img {
            height: 200px;
            object-fit: cover;
        }

        .footer {
            background-color: #333333;
            color: #ffffff;
            padding: 20px 0;
        }

        /* Animation personnalisée pour le titre et le paragraphe */
        @keyframes fadeInDown {
            0% {
                opacity: 0;
                transform: translateY(-20px);
            }

            50% {
                opacity: 1;
                transform: translateY(0);
            }

            100% {
                opacity: 0;
                transform: translateY(-20px);
            }
        }

        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }

            50% {
                opacity: 1;
                transform: translateY(0);
            }

            100% {
                opacity: 0;
                transform: translateY(20px);
            }
        }
    </style>
</head>

<body>
    <div id="app">
        <!-- Barre de navigation personnalisée -->
        <nav class="navbar navbar-expand-md navbar-dark shadow-sm">
            <div class="container">
                @auth
                @if (Auth::user()->role === 'client')
                <a class="navbar-brand" href="{{ url('/home') }}">
                    <i class="bi bi-house-door me-2"></i>ISI BURGER
                </a>
                @endif
                @else
                <a class="navbar-brand" href="{{ url('/') }}">
                    <i class="bi bi-house-door me-2"></i>ISI BURGER
                </a>
                @endif

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
            <div class="container">
                <!-- Section Hero -->
                <div class="hero-section">
                    <div>
                        <h1 class="animate__animated animate__fadeInDown animate__infinite">Bienvenue chez ISI Burger</h1>
                        <p class="animate__animated animate__fadeInUp animate__infinite">Découvrez nos délicieux burgers faits maison</p>
                        @if (Auth::check() && Auth::user()->role === 'client')
                        <a href="#" class="btn btn-primary">
                            <i class="bi bi-compass me-2"></i>Explorer notre monde !
                        </a>
                        @elseif (Auth::check() && Auth::user()->role === 'gestionnaire')
                        <a href="{{ route('gestionnaire.home') }}" class="btn btn-primary">
                            <i class="bi bi-speedometer2 me-2"></i>Voir le dashboard
                        </a>
                        @else
                        <p>Veuillez vous <a href="{{ route('login') }}" class="text-warning">connecter</a> ou vous <a href="{{ route('register') }}" class="text-warning">inscrire</a> pour voir le menu.</p>
                        @endif
                    </div>
                </div>

                <!-- Section Menu -->
                <div class="bg-dark py-5">
                    <div class="container">
                        <h2 class="text-center mb-4 animate__animated animate__fadeIn"><i class="bi bi-menu-button-wide me-4"></i>Notre Menu</h2>
                        <div class="row">
                            @foreach ($burgers as $burger)
                            <div class="col-md-4 mb-4 animate__animated animate__fadeInLeft">
                                <div class="card">
                                    <img src="{{ asset('storage/' . $burger->image) }}" class="card-img-top" alt="{{ $burger->name }}">
                                    <div class="card-body">
                                        <h5 class="card-title"><i class="bi bi-star me-2"></i>{{ $burger->name }}</h5>
                                        <p class="card-text">{{ $burger->description }}</p>
                                        <p class="card-text"><strong>Prix : {{ $burger->price }} F</strong></p>
                                        <a href="{{ route('orders.create', ['burger_id' => $burger->id]) }}" class="btn btn-primary">
                                            <i class="bi bi-cart me-2"></i>Commander
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Section À propos -->
                <div class="container my-5 animate__animated animate__fadeIn">
                    <div class="row">
                        <div class="col-md-6">
                            <h2><i class="bi bi-info-circle me-2"></i>À propos de nous</h2>
                            <p>
                                ISI Burger est un restaurant passionné par la création de burgers savoureux et de qualité.
                                Nous utilisons uniquement des ingrédients frais et locaux pour vous offrir une expérience unique.
                            </p>
                        </div>
                        <div class="col-md-6">
                            <img src="https://images.unsplash.com/photo-1555396273-367ea4eb4db5?q=80&w=1000&auto=format&fit=crop" alt="À propos de nous" class="img-fluid rounded">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <footer class="footer">
                <div class="container text-center">
                    <p>&copy; 2025 ISI Burger. Tous droits réservés.</p>
                </div>
            </footer>
        </main>
    </div>

    <!-- Bootstrap JS via CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>