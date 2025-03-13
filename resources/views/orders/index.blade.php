@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Liste des Commandes</h1>
    @if (Auth::user()->role === 'client')
    <a href="{{ route('orders.create') }}" class="btn btn-primary mb-3">Passer une commande</a>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Utilisateur</th>
                <th>Prix Total</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
            @if (Auth::user()->role === 'gestionnaire' || $order->user_id === Auth::id())
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->user->name }}</td>
                <td>{{ $order->total_price }} €</td>
                <td>{{ $order->status }}</td>
                <td>
                    <a href="{{ route('orders.show', $order->id) }}" class="btn btn-info btn-sm">Voir</a>
                    @if (Auth::user()->role === 'gestionnaire')
                    <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-warning btn-sm">Modifier</a>
                    @endif
                </td>
            </tr>
            @endif
            @endforeach
        </tbody>
    </table>
</div>
@endsection