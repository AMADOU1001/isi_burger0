@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Liste des Burgers</h1>
    @if (Auth::user()->role === 'gestionnaire')
    <a href="{{ route('burgers.create') }}" class="btn btn-primary mb-3">Ajouter un Burger</a>
    @endif

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
            @if ($burger->is_published || Auth::user()->role === 'gestionnaire')
            <tr>
                <td>{{ $burger->name }}</td>
                <td>{{ $burger->price }} €</td>
                <td>{{ $burger->description }}</td>
                <td>{{ $burger->is_published ? 'Publié' : 'Non publié' }}</td>
                <td>
                    @if (Auth::user()->role === 'gestionnaire')
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
                    @endif
                </td>
            </tr>
            @endif
            @endforeach
        </tbody>
    </table>
</div>
@endsection