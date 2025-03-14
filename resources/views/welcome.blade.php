<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ISI Burger - Accueil</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #1a1a1a;
            color: #ffffff;
        }

        .navbar {
            background-color: #333333;
        }

        .hero-section {
            background: url('/images/hero-burger.jpg') no-repeat center center/cover;
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
        }

        .hero-section p {
            font-size: 1.5rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
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
    </style>
</head>

<body>
    <!-- Barre de navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="/">ISI Burger</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @if (Auth::check())
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Déconnexion
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                    @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Connexion</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Inscription</a>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <!-- Section Hero -->
    <div class="hero-section">
        <div>
            <h1>Bienvenue chez ISI Burger</h1>
            <p>Découvrez nos délicieux burgers faits maison</p>
            @if (Auth::check() && Auth::user()->role === 'client')
            <a href="{{ route('burgers.index') }}" class="btn btn-primary">Voir le menu</a>
            @elseif (Auth::check() && Auth::user()->role === 'gestionnaire')
            <a href="{{ route('gestionnaire.home') }}" class="btn btn-primary">Voir le dashboard</a>
            @else
            <p>Veuillez vous <a href="{{ route('login') }}" class="text-warning">connecter</a> ou vous <a href="{{ route('register') }}" class="text-warning">inscrire</a> pour voir le menu.</p>
            @endif
        </div>
    </div>

    <!-- Section À propos -->
    <div class="container my-5">
        <div class="row">
            <div class="col-md-6">
                <h2>À propos de nous</h2>
                <p>
                    ISI Burger est un restaurant passionné par la création de burgers savoureux et de qualité.
                    Nous utilisons uniquement des ingrédients frais et locaux pour vous offrir une expérience unique.
                </p>
            </div>
            <div class="col-md-6">
                <img src="/images/about-restaurant.jpg" alt="À propos de nous" class="img-fluid rounded">
            </div>
        </div>
    </div>

    <!-- Section Menu -->
    <div class="bg-dark py-5">
        <div class="container">
            <h2 class="text-center mb-4">Notre Menu</h2>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="/images/classic-burger.jpg" class="card-img-top" alt="Burger 1">
                        <div class="card-body">
                            <h5 class="card-title">Burger Classique</h5>
                            <p class="card-text">Un burger simple mais délicieux.</p>
                            @if (Auth::check())
                            <a href="{{ route('orders.create') }}" class="btn btn-primary">Commander</a>
                            @else
                            <p class="text-warning">Connectez-vous pour commander.</p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="/images/vegetarian-burger.jpg" class="card-img-top" alt="Burger 2">
                        <div class="card-body">
                            <h5 class="card-title">Burger Végétarien</h5>
                            <p class="card-text">Un burger 100% végétal.</p>
                            @if (Auth::check())
                            <a href="{{ route('orders.create') }}" class="btn btn-primary">Commander</a>
                            @else
                            <p class="text-warning">Connectez-vous pour commander.</p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="/images/spicy-burger.jpg" class="card-img-top" alt="Burger 3">
                        <div class="card-body">
                            <h5 class="card-title">Burger Épicé</h5>
                            <p class="card-text">Pour les amateurs de sensations fortes.</p>
                            @if (Auth::check())
                            <a href="{{ route('orders.create') }}" class="btn btn-primary">Commander</a>
                            @else
                            <p class="text-warning">Connectez-vous pour commander.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container text-center">
            <p>&copy; 2023 ISI Burger. Tous droits réservés.</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>