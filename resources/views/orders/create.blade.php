@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center mb-4 text-white animate__animated animate__fadeIn">Créer une Commande</h1>
    <div class="card shadow bg-dark text-white animate__animated animate__fadeInUp">
        <div class="card-body">
            <!-- Barre de recherche et boutons de tri -->
            <div class="mb-4">
                <input type="text" id="searchInput" class="form-control bg-dark text-white mb-3" placeholder="Rechercher un burger par nom...">
                <div class="d-flex gap-2">
                    <button id="sortByName" class="btn btn-outline-light">
                        <i class="bi bi-sort-alpha-down me-2"></i>Trier par nom
                    </button>
                    <button id="sortByPrice" class="btn btn-outline-light">
                        <i class="bi bi-sort-numeric-down me-2"></i>Trier par prix
                    </button>
                </div>
            </div>

            <!-- Liste des burgers -->
            <form action="{{ route('orders.store') }}" method="POST" id="orderForm">
                @csrf
                <div class="form-group" id="burgersList">
                    <h3 class="mb-3"><i class="bi bi-burger me-2"></i>Choisissez vos burgers</h3>
                    @foreach ($burgers as $burger)
                    <div class="card mb-3 bg-secondary text-white animate__animated animate__fadeIn burger-item" data-name="{{ $burger->name }}" data-price="{{ $burger->price }}">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <!-- Image du burger -->
                                <div class="col-md-3">
                                    @if ($burger->image)
                                    <img src="{{ asset('storage/' . $burger->image) }}" class="img-fluid rounded" alt="{{ $burger->name }}">
                                    @else
                                    <div class="text-center">
                                        <i class="bi bi-image" style="font-size: 5rem; color: #666;"></i>
                                    </div>
                                    @endif
                                </div>
                                <!-- Détails du burger -->
                                <div class="col-md-5">
                                    <div class="form-check">
                                        <input type="checkbox" name="burger_ids[]" id="burger_{{ $burger->id }}" value="{{ $burger->id }}" class="form-check-input burger-checkbox">
                                        <label for="burger_{{ $burger->id }}" class="form-check-label">
                                            <h5 class="mb-1">{{ $burger->name }}</h5>
                                            <p class="mb-1">{{ $burger->description }}</p>
                                            <p class="mb-0"><strong>Prix : {{ $burger->price }} F CFA</strong></p>
                                        </label>
                                    </div>
                                </div>
                                <!-- Quantité -->
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-text bg-dark text-white">
                                            <i class="bi bi-cart"></i>
                                        </span>
                                        <input type="number" name="quantities[]" class="form-control bg-dark text-white burger-quantity" placeholder="Quantité" min="1" value="1">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-success btn-lg animate__animated animate__pulse">
                        <i class="bi bi-cart-check me-2"></i>Créer la Commande
                    </button>
                </div>
            </form>

            <!-- Spinner de chargement -->
            <div id="loadingSpinner" class="text-center mt-4" style="display: none;">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Chargement...</span>
                </div>
                <p class="mt-2 text-white">Chargement en cours...</p>
            </div>

            <!-- Toast pour afficher un message -->
            <div id="toastMessage" class="toast align-items-center text-white bg-success border-0 position-fixed top-0 end-0 m-3" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <!-- Message dynamique ici -->
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<!-- Styles existants -->
@endsection

@section('scripts')
<!-- Bootstrap Icons via CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">

<!-- Animate.css via CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

<!-- Script pour gérer les checkboxes, les quantités, la recherche et le tri -->
<script>
    // Fonction de recherche
    const searchInput = document.getElementById('searchInput');
    const burgerItems = document.querySelectorAll('.burger-item');

    searchInput.addEventListener('input', function() {
        const searchTerm = searchInput.value.toLowerCase();
        burgerItems.forEach(burger => {
            const burgerName = burger.getAttribute('data-name').toLowerCase();
            if (burgerName.includes(searchTerm)) {
                burger.style.display = 'block';
            } else {
                burger.style.display = 'none';
            }
        });
    });

    // Fonction de tri par nom
    const sortByName = document.getElementById('sortByName');
    sortByName.addEventListener('click', function() {
        const burgerItemsArray = Array.from(burgerItems);
        burgerItemsArray.sort((a, b) => {
            const nameA = a.getAttribute('data-name').toLowerCase();
            const nameB = b.getAttribute('data-name').toLowerCase();
            return nameA.localeCompare(nameB);
        });

        const burgersList = document.getElementById('burgersList');
        burgersList.innerHTML = ''; // Vider la liste actuelle
        burgerItemsArray.forEach(item => burgersList.appendChild(item)); // Ajouter les éléments triés
    });

    // Fonction de tri par prix
    const sortByPrice = document.getElementById('sortByPrice');
    sortByPrice.addEventListener('click', function() {
        const burgerItemsArray = Array.from(burgerItems);
        burgerItemsArray.sort((a, b) => {
            const priceA = parseFloat(a.getAttribute('data-price'));
            const priceB = parseFloat(b.getAttribute('data-price'));
            return priceA - priceB;
        });

        const burgersList = document.getElementById('burgersList');
        burgersList.innerHTML = ''; // Vider la liste actuelle
        burgerItemsArray.forEach(item => burgersList.appendChild(item)); // Ajouter les éléments triés
    });

    // Gestion de la soumission du formulaire
    const orderForm = document.getElementById('orderForm');
    const loadingSpinner = document.getElementById('loadingSpinner');
    const toastMessage = new bootstrap.Toast(document.getElementById('toastMessage'));

    orderForm.addEventListener('submit', function(event) {
        event.preventDefault();
        loadingSpinner.style.display = 'block';

        setTimeout(() => {
            loadingSpinner.style.display = 'none';
            const toastBody = toastMessage._element.querySelector('.toast-body');
            toastBody.textContent = 'Commande créée avec succès !';
            toastMessage.show();
            orderForm.submit();
        }, 3000);
    });
</script>
@endsection