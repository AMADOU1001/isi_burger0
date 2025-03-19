@extends('layouts.app')

@section('content')
<div class="container bg-dark text-white p-4 rounded shadow">
    <!-- Titre de la page -->
    <h1 class="mb-4 text-center">Détails de la Commande #{{ $order->id }}</h1>

    <!-- Informations de la commande -->
    <div class="mb-4 p-4 bg-secondary rounded">
        <p class="mb-2"><strong>Utilisateur :</strong> {{ $order->user->name }}</p>
        <p class="mb-2"><strong>Prix Total :</strong> {{ $order->total_price }} F CFA</p>
        <p class="mb-0"><strong>Statut :</strong> {{ $order->status }}</p>
    </div>

    <!-- Liste des burgers commandés -->
    <h3 class="mb-3">Burgers Commandés</h3>
    <ul class="list-group mb-4">
        @foreach ($order->burgers as $burger)
        <li class="list-group-item bg-dark text-white border-secondary">
            {{ $burger->name }} (x{{ $burger->pivot->quantity }})
        </li>
        @endforeach
    </ul>

    <!-- Bouton de retour -->
    @if (Auth::user()->role === 'gestionnaire')
    <a href="{{ route('gestionnaire.home') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Retour
    </a>
    @else
    <a href="{{ route('orders.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Retour
    </a>
    @endif
</div>
@endsection