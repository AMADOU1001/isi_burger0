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
                    <th>Actions</th> <!-- Nouvelle colonne pour les actions -->
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
                    <td>
                        @if ($order->status === 'en_traitement' && Auth::user()->role === 'gestionnaire')
                        <form action="{{ route('orders.validate', $order->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-primary btn-sm">Valider</button>
                        </form>
                        @else
                        <span class="text-muted">Aucune action disponible</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

    <!-- Section : Statistiques -->
    <div class="mb-5">
        <h2>Statistiques</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h5 class="card-title">Commandes en cours</h5>
                        <p class="card-text">{{ $todayPendingOrders }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h5 class="card-title">Commandes validées</h5>
                        <p class="card-text">{{ $todayCompletedOrders }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <h5 class="card-title">Recettes journalières</h5>
                        <p class="card-text">{{ $todayRevenue }} €</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Graphique : Commandes par mois -->
    <div class="mb-5">
        <h3>Commandes par mois</h3>
        <canvas id="ordersChart" width="400" height="200"></canvas>
    </div>

    <!-- Graphique : Burgers vendus par mois -->
    <div class="mb-5">
        <h3>Burgers vendus par mois</h3>
        <canvas id="burgersChart" width="400" height="200"></canvas>
    </div>

    <!-- Inclure Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Script pour les graphiques -->
    <script>
        // Données pour le graphique des commandes
        const ordersData = {
            labels: {
                !!json_encode($monthlyOrders - > pluck('month')) !!
            },
            datasets: [{
                label: 'Commandes par mois',
                data: {
                    !!json_encode($monthlyOrders - > pluck('total')) !!
                },
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        };

        // Données pour le graphique des burgers vendus
        const burgersData = {
            labels: {
                !!json_encode($monthlyBurgersSold - > pluck('month')) !!
            },
            datasets: [{
                label: 'Burgers vendus par mois',
                data: {
                    !!json_encode($monthlyBurgersSold - > pluck('total')) !!
                },
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        };

        // Configurer le graphique des commandes
        const ordersCtx = document.getElementById('ordersChart').getContext('2d');
        new Chart(ordersCtx, {
            type: 'bar',
            data: ordersData,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Configurer le graphique des burgers vendus
        const burgersCtx = document.getElementById('burgersChart').getContext('2d');
        new Chart(burgersCtx, {
            type: 'bar',
            data: burgersData,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
    @endsection