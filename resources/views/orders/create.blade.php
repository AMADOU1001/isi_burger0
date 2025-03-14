@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center mb-4 text-white">Créer une Commande</h1>
    <div class="card shadow bg-dark text-white">
        <div class="card-body">
            <form action="{{ route('orders.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <h3 class="mb-3">Choisissez vos burgers</h3>
                    @foreach ($burgers as $burger)
                    <div class="card mb-3 bg-secondary text-white">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <div class="form-check">
                                        <input type="checkbox" name="burger_ids[]" id="burger_{{ $burger->id }}" value="{{ $burger->id }}" class="form-check-input">
                                        <label for="burger_{{ $burger->id }}" class="form-check-label">
                                            <h5 class="mb-1">{{ $burger->name }}</h5>
                                            <p class="mb-1">{{ $burger->description }}</p>
                                            <p class="mb-0"><strong>Prix : {{ $burger->price }} F CFA</strong></p>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <input type="number" name="quantities[]" class="form-control bg-dark text-white" placeholder="Quantité" min="1" value="1">
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-success btn-lg">
                        <i class="fas fa-shopping-cart"></i> Créer la Commande
                    </button>
                </div>
            </form>
        </div>
    </div>
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
    }

    .form-check-input {
        margin-top: 0.3rem;
    }

    .btn-success {
        background-color: #28a745;
        border: none;
        padding: 10px 30px;
        font-size: 1.1rem;
    }

    .btn-success:hover {
        background-color: #218838;
    }

    .form-control {
        border-radius: 5px;
        background-color: #333333;
        /* Champ de formulaire sombre */
        color: #ffffff;
        /* Texte blanc */
        border: 1px solid #444444;
    }

    .form-control:focus {
        background-color: #444444;
        color: #ffffff;
        border-color: #555555;
    }

    h1 {
        color: #ffffff;
        /* Titre blanc */
        font-weight: bold;
    }

    .card-body {
        padding: 1.5rem;
    }

    .bg-secondary {
        background-color: #333333 !important;
        /* Cartes sombres */
    }
</style>
@endsection

@section('scripts')
<!-- Font Awesome pour les icônes -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
@endsection