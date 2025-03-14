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
                    <td>{{ $burger->price }} F CFA</td>
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
                    <td>{{ $order->total_price }} F CFA</td>
                    <td>{{ $order->status }}</td>
                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        @if ($order->status === 'en_traitement' && Auth::user()->role === 'gestionnaire')
                        <form action="{{ route('orders.validate', $order->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-primary btn-sm">Valider</button>
                        </form>
                        @else
                        <form action="{{ route('orders.show', $order->id) }}" method="GET" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-primary btn-sm">Voir détails</button>
                        </form>
                        @if ($order->status === 'validée')
                        <a href="{{ route('orders.invoice', $order->id) }}" class="btn btn-success btn-sm" target="_blank">
                            Voir Facture
                        </a>
                        @endif
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
            <!-- Commandes en cours -->
            <div class="col-md-4">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h5 class="card-title">Commandes en cours</h5>
                        <p class="card-text">{{ $todayPendingOrders }}</p>
                    </div>
                </div>
            </div>

            <!-- Commandes validées -->
            <div class="col-md-4">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h5 class="card-title">Commandes validées</h5>
                        <p class="card-text">{{ $todayCompletedOrders }}</p>
                    </div>
                </div>
            </div>

            <!-- Recettes journalières -->
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



    <!-- Graphique : Burgers vendus par mois -->
    <div class="mb-5">
        <h3>Burgers vendus par mois</h3>
        <canvas id="burgersChart" width="400" height="200"></canvas>
    </div>

    <!-- Inclure Chart.js -->

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Section : Graphique des commandes par mois -->
    @if($monthlyOrders->isEmpty())
    <p>Aucune donnée disponible pour les commandes par mois.</p>
    @else
    <canvas id="ordersChart" width="400" height="200"
        data-labels="{{ json_encode($monthlyOrders->pluck('month_name')) }}"
        data-totals="{{ json_encode($monthlyOrders->pluck('total')) }}"
        data-validated-totals="{{ json_encode($monthlyOrders->pluck('validated_total')) }}">
    </canvas>
    @endif

    <!-- Inclure Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Récupérer les données depuis les attributs HTML
        const ordersChart = document.getElementById('ordersChart');
        const labels = JSON.parse(ordersChart.dataset.labels || '[]'); // Utiliser un tableau vide si undefined
        const totals = JSON.parse(ordersChart.dataset.totals || '[]'); // Utiliser un tableau vide si undefined
        const validatedTotals = JSON.parse(ordersChart.dataset.validatedTotals || '[]'); // Utiliser un tableau vide si undefined

        // Données pour le graphique des commandes par mois
        const ordersData = {
            labels: labels,
            datasets: [{
                    label: 'Commandes par mois',
                    data: totals,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Commandes validées par mois',
                    data: validatedTotals,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }
            ]
        };

        // Configurer le graphique des commandes
        const ordersCtx = ordersChart.getContext('2d');
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
    </script>
    @endsection