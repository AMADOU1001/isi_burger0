@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Détails de la Commande #{{ $order->id }}</h1>
    <p><strong>Utilisateur :</strong> {{ $order->user->name }}</p>
    <p><strong>Prix Total :</strong> {{ $order->total_price }} F CFA</p>
    <p><strong>Statut :</strong> {{ $order->status }}</p>

    <h3>Burgers Commandés</h3>
    <ul>
        @foreach ($order->burgers as $burger)
        <li>{{ $burger->name }} (x{{ $burger->pivot->quantity }})</li>
        @endforeach
    </ul>

    @if (Auth::user()->role === 'gestionnaire')
    <a href="{{ route('gestionnaire.home') }}" class="btn btn-secondary">Retour</a>
    @else
    <a href="{{ route('orders.index') }}" class="btn btn-secondary">Retour</a>
    @endif
</div>
@endsection