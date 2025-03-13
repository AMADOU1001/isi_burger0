@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $burger->name }}</h1>
    <p><strong>Prix :</strong> {{ $burger->price }} €</p>
    <p><strong>Description :</strong> {{ $burger->description }}</p>
    <p><strong>Statut :</strong> {{ $burger->is_published ? 'Publié' : 'Non publié' }}</p>

    @if ($burger->image)
    <img src="{{ asset('storage/' . $burger->image) }}" alt="{{ $burger->name }}" class="img-fluid">
    @endif

    @if (Auth::user()->role === 'gestionnaire')
    <div class="mt-4">
        <!-- Bouton Publier/Dépublier -->
        <form action="{{ route('burgers.togglePublish', $burger->id) }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" class="btn {{ $burger->is_published ? 'btn-warning' : 'btn-success' }}">
                {{ $burger->is_published ? 'Dépublier' : 'Publier' }}
            </button>
        </form>

        <!-- Bouton Modifier -->
        <a href="{{ route('burgers.edit', $burger->id) }}" class="btn btn-primary">Modifier</a>

        <!-- Bouton Supprimer -->
        <form action="{{ route('burgers.destroy', $burger->id) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce burger ?')">Supprimer</button>
        </form>
    </div>
    @endif

    <a href="{{ route('burgers.index') }}" class="btn btn-secondary mt-3">Retour</a>
</div>
@endsection