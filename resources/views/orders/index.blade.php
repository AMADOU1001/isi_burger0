@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center mb-4 text-white animate__animated animate__fadeIn">Vos Commandes</h1>

    <!-- Formulaire de filtrage -->
    <form action="{{ route('orders.index') }}" method="GET" class="mb-4">
        <label for="status" class="text-white">Filtrer par statut :</label>
        <select name="status" id="status" class="form-select bg-dark text-white" onchange="this.form.submit()">
            <option value="">Toutes les commandes</option>
            <option value="en_traitement" {{ request('status') === 'en_traitement' ? 'selected' : '' }}>En traitement</option>
            <option value="validée" {{ request('status') === 'validée' ? 'selected' : '' }}>Validées</option>
        </select>
    </form>

    @if ($orders->isEmpty())
    <div class="alert alert-info text-center animate__animated animate__fadeIn">
        <i class="bi bi-info-circle me-2"></i>Vous n'avez aucune commande pour le moment.
    </div>
    @else
    <div class="row">
        @foreach ($orders as $order)
        <div class="col-md-6 mb-4 animate__animated animate__fadeInUp">
            <div class="card bg-dark text-white shadow">
                <div class="card-body">
                    <h5 class="card-title">Commande #{{ $order->id }}</h5>
                    <p class="card-text"><strong>Prix Total :</strong> {{ $order->total_price }} F CFA</p>
                    <p class="card-text"><strong>Statut :</strong> {{ $order->status }}</p>
                    <p class="card-text"><strong>Date :</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                    <div class="d-flex justify-content-between">
                        @if ($order->status === 'en_attente')
                        <form action="{{ route('orders.pay', $order->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm">
                                <i class="bi bi-credit-card me-2"></i>Payer
                            </button>
                        </form>
                        <form action="{{ route('orders.cancel', $order->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir annuler cette commande ?')">
                                <i class="bi bi-x-circle me-2"></i>Annuler
                            </button>
                        </form>
                        @elseif (trim($order->status) === 'en_traitement' && trim(Auth::user()->role) === 'gestionnaire')
                        <form action="{{ route('orders.validate', $order->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="bi bi-check-circle me-2"></i>Valider
                            </button>
                        </form>
                        @else
                        <form action="{{ route('orders.show', $order->id) }}" method="GET" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="bi bi-eye me-2"></i>Voir détails
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection

@section('styles')
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

    .btn-success {
        background-color: #28a745;
        border: none;
        padding: 10px 20px;
        font-size: 1rem;
        transition: background-color 0.3s ease;
    }

    .btn-success:hover {
        background-color: #218838;
    }

    .btn-danger {
        background-color: #dc3545;
        border: none;
        padding: 10px 20px;
        font-size: 1rem;
        transition: background-color 0.3s ease;
    }

    .btn-danger:hover {
        background-color: #c82333;
    }

    .btn-primary {
        background-color: #007bff;
        border: none;
        padding: 10px 20px;
        font-size: 1rem;
        transition: background-color 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .alert-info {
        background-color: #17a2b8;
        border: none;
        color: #ffffff;
    }

    .animate__animated {
        animation-duration: 1s;
    }

    .form-select {
        background-color: #333;
        color: #fff;
        border: 1px solid #555;
    }

    .form-select:focus {
        background-color: #444;
        color: #fff;
        border-color: #777;
    }
</style>
@endsection

@section('scripts')
<!-- Bootstrap Icons via CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">

<!-- Animate.css via CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
@endsection