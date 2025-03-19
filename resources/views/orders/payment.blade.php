@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center mb-4 text-white animate__animated animate__fadeIn">
        <i class="bi bi-credit-card me-2"></i>Paiement de la Commande #{{ $order->id }}
    </h1>
    <p class="text-center mb-4 text-white animate__animated animate__fadeIn">
        <i class="bi bi-cash-coin me-2"></i>Montant à payer : {{ $order->total_price }} F CFA
    </p>

    <div class="card shadow bg-dark text-white animate__animated animate__fadeInUp">
        <div class="card-body">
            <form action="{{ route('orders.processPayment', $order->id) }}" method="POST">
                @csrf
                <div class="form-group mb-4">
                    <label for="card_number" class="form-label">
                        <i class="bi bi-credit-card-2-front me-2"></i>Numéro de carte
                    </label>
                    <input type="text" id="card_number" name="card_number" class="form-control bg-dark text-white" required>
                </div>
                <div class="form-group mb-4">
                    <label for="expiry_date" class="form-label">
                        <i class="bi bi-calendar-date me-2"></i>Date d'expiration
                    </label>
                    <input type="text" id="expiry_date" name="expiry_date" class="form-control bg-dark text-white" required>
                </div>
                <div class="form-group mb-4">
                    <label for="cvv" class="form-label">
                        <i class="bi bi-shield-lock me-2"></i>CVV
                    </label>
                    <input type="text" id="cvv" name="cvv" class="form-control bg-dark text-white" required>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-success btn-lg animate__animated animate__pulse">
                        <i class="bi bi-check-circle me-2"></i>Payer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Styles personnalisés pour le dark mode -->
<style>
    body {
        background-color: #121212;
        /* Fond sombre */
        color: #ffffff;
        /* Texte blanc */
    }

    .card {
        border: none;
        border-radius: 10px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
    }

    .form-control {
        border-radius: 5px;
        background-color: #333333;
        /* Champ de formulaire sombre */
        color: #ffffff;
        /* Texte blanc */
        border: 1px solid #444444;
    }

    .form-control:focus {
        background-color: #444444;
        color: #ffffff;
        border-color: #555555;
    }

    .btn-success {
        background-color: #28a745;
        border: none;
        padding: 10px 30px;
        font-size: 1.1rem;
        transition: background-color 0.3s ease;
    }

    .btn-success:hover {
        background-color: #218838;
    }

    .form-label {
        font-weight: 500;
        color: #ffffff;
        /* Texte blanc pour les labels */
    }

    .animate__animated {
        animation-duration: 1s;
    }
</style>

<!-- Bootstrap Icons via CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">

<!-- Animate.css via CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
@endsection