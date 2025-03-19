@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-2 d-none d-md-block bg-dark sidebar position-fixed" style=" overflow-y: auto; padding-top:0;">
            <div class="sidebar-sticky pt-3">
                <ul class="nav flex-column">
                    <!-- Tableau de Bord -->
                    <li class="nav-item">
                        <a class="nav-link active text-white fs-6" href="#tableau-de-bord">
                            <i class="bi bi-house-door me-2"></i>Tableau de Bord
                        </a>
                    </li>

                    <!-- Gestion des Burgers -->
                    <li class="nav-item">
                        <a class="nav-link text-white fs-6" href="#gestion-burgers">
                            <i class="bi bi-egg-fried me-2"></i>Gestion des Burgers
                        </a>
                    </li>

                    <!-- Commandes -->
                    <li class="nav-item">
                        <a class="nav-link text-white fs-6" href="#commandes">
                            <i class="bi bi-cart me-2"></i>Gestion des Commandes
                        </a>
                    </li>

                    <!-- Mes Commandes (si l'utilisateur est un client) -->
                    @auth
                    @if (Auth::user()->role === 'client')
                    <li class="nav-item">
                        <a class="nav-link text-white fs-5" href="#mes-commandes">
                            <i class="bi bi-list-check me-2"></i>Mes Commandes
                        </a>
                    </li>
                    @endif
                    @endauth
                </ul>
            </div>
        </nav>

        <!-- Main Content -->
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4" style="margin-left: 200px;">
            <!-- Section : Tableau de Bord -->
            <div id="tableau-de-bord" class="mb-5">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2 text-white">Tableau de Bord - Gestionnaire</h1>
                    <p class="h5 text-white">Bienvenue, {{ Auth::user()->name }} !</p>
                </div>

                <!-- Section : Statistiques -->
                <div class="mb-5">
                    <h2 class="text-white">Statistiques Journalières</h2>
                    <div class="row">
                        <!-- Commandes en cours -->
                        <div class="col-md-4">
                            <div class="card bg-primary text-white">
                                <div class="card-body d-flex align-items-center">
                                    <i class="bi bi-hourglass-split fs-3 me-3"></i>
                                    <div>
                                        <h5 class="card-title">Commandes en cours</h5>
                                        <p class="card-text">{{ $todayPendingOrders }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Commandes validées -->
                        <div class="col-md-4">
                            <div class="card bg-success text-white">
                                <div class="card-body d-flex align-items-center">
                                    <i class="bi bi-check-circle fs-3 me-3"></i>
                                    <div>
                                        <h5 class="card-title">Commandes validées</h5>
                                        <p class="card-text">{{ $todayCompletedOrders }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Recettes journalières -->
                        <div class="col-md-4">
                            <div class="card bg-info text-white">
                                <div class="card-body d-flex align-items-center">
                                    <i class="bi bi-cash-coin fs-3 me-3"></i>
                                    <div>
                                        <h5 class="card-title">Recettes journalières</h5>
                                        <p class="card-text">{{ $todayRevenue }} F CFA</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section : Gestion des Burgers -->
            <div id="gestion-burgers" class="mb-5">
                <h2 class="text-white">Gestion des Burgers</h2>
                <a href="{{ route('burgers.create') }}" class="btn btn-primary mb-3">
                    <i class="bi bi-plus-circle me-2"></i>Ajouter un Burger
                </a>

                @if ($burgers->isEmpty())
                <p class="text-white">Aucun burger disponible pour le moment.</p>
                @else
                <button id="toggleBurgers" class="btn btn-secondary mb-3">
                    <i class="bi bi-list"></i> Afficher les 5 derniers
                </button>
                <table class="table table-dark table-striped" id="burgersTable">
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
                                    <button type="submit" class="btn btn-sm {{ $burger->is_published ? 'btn-warning' : 'btn-success' }}" data-bs-toggle="tooltip" title="{{ $burger->is_published ? 'Dépublier' : 'Publier' }}">
                                        <i class="bi {{ $burger->is_published ? 'bi-eye-slash' : 'bi-eye' }}"></i>
                                    </button>
                                </form>

                                <!-- Bouton Modifier -->
                                <a href="{{ route('burgers.edit', $burger->id) }}" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" title="Modifier">
                                    <i class="bi bi-pencil"></i>
                                </a>

                                <!-- Bouton Supprimer -->
                                <form action="{{ route('burgers.destroy', $burger->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" title="Supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce burger ?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>

            <!-- Section : Commandes -->
            <div id="commandes" class="mb-5">
                <h2 class="text-white">Commandes</h2>
                @if ($orders->isEmpty())
                <p class="text-white">Aucune commande pour le moment.</p>
                @else
                <button id="toggleOrders" class="btn btn-secondary mb-3">
                    <i class="bi bi-list"></i> Afficher les 5 derniers
                </button>
                <table class="table table-dark table-striped" id="ordersTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Client</th>
                            <th>Prix Total</th>
                            <th>Statut</th>
                            <th>Date</th>
                            <th>Actions</th>
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
                                    <button type="submit" class="btn btn-primary btn-sm" data-bs-toggle="tooltip" title="Valider la commande">
                                        <i class="bi bi-check-circle"></i>
                                    </button>
                                </form>
                                @else
                                <form action="{{ route('orders.show', $order->id) }}" method="GET" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-sm" data-bs-toggle="tooltip" title="Voir les détails">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </form>
                                @if ($order->status === 'validée')
                                <a href="{{ route('orders.invoice', $order->id) }}" class="btn btn-success btn-sm" data-bs-toggle="tooltip" title="Voir la facture" target="_blank">
                                    <i class="bi bi-receipt"></i>
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

            <!-- Section : Mes Commandes (pour les clients) -->
            @auth
            @if (Auth::user()->role === 'client')
            <div id="mes-commandes" class="mb-5">
                <h2 class="text-white">Mes Commandes</h2>
                <!-- Contenu de la section -->
            </div>
            @endif
            @endauth

            <!-- Graphique : Burgers vendus par mois -->
            <div class="mb-5">
                <h3 class="text-white">Burgers vendus par mois</h3>
                <canvas id="burgersChart" width="400" height="200"></canvas>
            </div>

            <!-- Section : Graphique des commandes par mois -->
            @if($monthlyOrders->isEmpty())
            <p class="text-white">Aucune donnée disponible pour les commandes par mois.</p>
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

            <script>
                // Fonction pour basculer entre l'affichage des 5 derniers éléments et tout le tableau
                function toggleTableRows(tableId, buttonId) {
                    const table = document.getElementById(tableId);
                    const button = document.getElementById(buttonId);
                    const rows = table.querySelectorAll('tbody tr');

                    if (button.textContent.includes('5 derniers')) {
                        // Afficher seulement les 5 derniers éléments
                        rows.forEach((row, index) => {
                            if (index >= rows.length - 5) {
                                row.style.display = '';
                            } else {
                                row.style.display = 'none';
                            }
                        });
                        button.innerHTML = '<i class="bi bi-list"></i> Afficher tout';
                    } else {
                        // Afficher tout le tableau
                        rows.forEach(row => row.style.display = '');
                        button.innerHTML = '<i class="bi bi-list"></i> Afficher les 5 derniers';
                    }
                }

                // Appliquer la fonction au tableau des burgers
                document.getElementById('toggleBurgers').addEventListener('click', () => {
                    toggleTableRows('burgersTable', 'toggleBurgers');
                });

                // Appliquer la fonction au tableau des commandes
                document.getElementById('toggleOrders').addEventListener('click', () => {
                    toggleTableRows('ordersTable', 'toggleOrders');
                });

                // Activer les tooltips de Bootstrap
                const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                tooltipTriggerList.map(function(tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });

                // Activer le défilement fluide pour les liens du sidebar
                document.querySelectorAll('.sidebar a').forEach(anchor => {
                    anchor.addEventListener('click', function(e) {
                        e.preventDefault(); // Empêcher le comportement par défaut
                        const targetId = this.getAttribute('href').substring(1); // Récupérer l'ID de la cible
                        const targetSection = document.getElementById(targetId); // Trouver la section cible
                        if (targetSection) {
                            targetSection.scrollIntoView({
                                behavior: 'smooth'
                            }); // Défilement fluide
                        }
                    });
                });
            </script>
        </main>
    </div>
</div>



@endsection