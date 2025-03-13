@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tableau de Bord</h1>
    <p>Bienvenue, {{ Auth::user()->name }} !</p>

    <!-- Section : Vos Commandes -->
    <div class="mb-5">
        <h2>Vos Commandes</h2>
        @if ($orders->isEmpty())
        <p>Vous n'avez aucune commande pour le moment.</p>
        @else
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Prix Total</th>
                    <th>Statut</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->total_price }} €</td>
                    <td>{{ $order->status }}</td>
                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

    <!-- Section : Liste des Burgers -->
    <div class="mb-5">
        <h2>Burgers Disponibles</h2>
        @if ($burgers->isEmpty())
        <p>Aucun burger disponible pour le moment.</p>
        @else
        <div class="row">
            @foreach ($burgers as $burger)
            <div class="col-md-4 mb-4">
                <div class="card">
                    @if ($burger->image)
                    <img src="{{ asset('storage/' . $burger->image) }}" class="card-img-top" alt="{{ $burger->name }}">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $burger->name }}</h5>
                        <p class="card-text">{{ $burger->description }}</p>
                        <p class="card-text"><strong>Prix :</strong> {{ $burger->price }} €</p>
                        <form action="{{ route('orders.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="burger_id" value="{{ $burger->id }}">
                            <div class="form-group">
                                <label for="quantity">Quantité</label>
                                <input type="number" name="quantity" id="quantity" class="form-control" min="1" value="1" required>
                            </div>
                            <button type="submit" class="btn btn-primary mt-2">Commander</button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>
@endsection