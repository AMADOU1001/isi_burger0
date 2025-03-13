@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tableau de Bord - Gestionnaire</h1>
    <p>Bienvenue, {{ Auth::user()->name }} !</p>

    <!-- Section : Gestion des Burgers -->
    <div class="mb-5">
        <h2>Gestion des Burgers</h2>
        <a href="{{ route('burgers.create') }}" class="btn btn-primary mb-3">Ajouter un Burger</a>

        @if ($burgers->isEmpty())
        <p>Aucun burger disponible pour le moment.</p>
        @else
        <table class="table">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prix</th>
                    <th>Description</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($burgers as $burger)
                <tr>
                    <td>{{ $burger->name }}</td>
                    <td>{{ $burger->price }} €</td>
                    <td>{{ $burger->description }}</td>
                    <td>{{ $burger->is_published ? 'Publié' : 'Non publié' }}</td>
                    <td>
                        <!-- Bouton Publier/Dépublier -->
                        <form action="{{ route('burgers.togglePublish', $burger->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-sm {{ $burger->is_published ? 'btn-warning' : 'btn-success' }}">
                                {{ $burger->is_published ? 'Dépublier' : 'Publier' }}
                            </button>
                        </form>

                        <!-- Bouton Modifier -->
                        <a href="{{ route('burgers.edit', $burger->id) }}" class="btn btn-sm btn-primary">Modifier</a>

                        <!-- Bouton Supprimer -->
                        <form action="{{ route('burgers.destroy', $burger->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce burger ?')">Supprimer</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

    <!-- Section : Commandes -->
    <div class="mb-5">
        <h2>Commandes</h2>
        @if ($orders->isEmpty())
        <p>Aucune commande pour le moment.</p>
        @else
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Client</th>
                    <th>Prix Total</th>
                    <th>Statut</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->user->name }}</td>
                    <td>{{ $order->total_price }} €</td>
                    <td>{{ $order->status }}</td>
                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>
@endsection