@extends('layouts.app')

@section('content')
<div class="container bg-dark text-white p-4 rounded shadow">
    <!-- Bouton de retour -->
    <div class="mb-4">
        <a href="{{ route('gestionnaire.home') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-2"></i>Retour
        </a>
    </div>

    <!-- Titre de la page -->
    <h1 class="mb-4 text-center">Ajouter un Burger</h1>

    <!-- Formulaire -->
    <form action="{{ route('burgers.store') }}" method="POST" enctype="multipart/form-data" class="bg-dark text-white p-4 rounded border border-secondary">
        @csrf
        <div class="form-group mb-3">
            <label for="name" class="form-label">Nom</label>
            <input type="text" name="name" id="name" class="form-control bg-dark text-white" required>
        </div>
        <div class="form-group mb-3">
            <label for="price" class="form-label">Prix</label>
            <input type="number" name="price" id="price" class="form-control bg-dark text-white" step="0.01" required>
        </div>
        <div class="form-group mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control bg-dark text-white" rows="4" required></textarea>
        </div>
        <div class="form-group mb-3">
            <label for="stock" class="form-label">Stock</label>
            <input type="number" name="stock" id="stock" class="form-control bg-dark text-white" required>
        </div>
        <div class="form-group mb-4">
            <label for="image" class="form-label">Image</label>
            <input type="file" name="image" id="image" class="form-control bg-dark text-white">
        </div>
        <button type="submit" class="btn btn-success w-100">
            <i class="bi bi-check-circle me-2"></i>Créer
        </button>
    </form>
</div>
@endsection