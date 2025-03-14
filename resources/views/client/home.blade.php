@extends('layouts.app')

@section('content')

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
<div class="container">
    <!-- Section Hero -->
    <div class="hero-section">
        <div>
            <h1>Bienvenue chez ISI Burger</h1>
            <p>Découvrez nos délicieux burgers faits maison</p>
        </div>
    </div>

    <!-- Section Menu -->
    <div class="bg-dark py-5">
        <div class="container">
            <h2 class="text-center mb-4">Notre Menu</h2>
            <div class="row">
                @foreach ($burgers as $burger)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="{{ asset('storage/' . $burger->image) }}" class="card-img-top" alt="{{ $burger->name }}">

                        <div class="card-body">
                            <h5 class="card-title">{{ $burger->name }}</h5>
                            <p class="card-text">{{ $burger->description }}</p>
                            <p class="card-text"><strong>Prix : {{ $burger->price }} F</strong></p>
                            <a href="{{ route('orders.create', ['burger_id' => $burger->id]) }}" class="btn btn-primary">Commander</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
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
</div>

<!-- Footer -->
<footer class="footer">
    <div class="container text-center">
        <p>&copy; 2025 ISI Burger. Tous droits réservés.</p>
    </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
@endsection