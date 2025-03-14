@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Vos Commandes</h1>
    @if ($orders->isEmpty())
    <p>Vous n'avez aucune commande pour le moment.</p>
    @else
    <table class="table table-dark table-striped">
        <thead>
            <tr>
                <th>ID</th>
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
                <td>{{ $order->total_price }} F CFA</td>
                <td>{{ $order->status }}</td>
                <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                <td>
                    @if ($order->status === 'en_attente')
                    <form action="{{ route('orders.pay', $order->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-success btn-sm">Payer</button>
                    </form>
                    <form action="{{ route('orders.cancel', $order->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir annuler cette commande ?')">Annuler</button>
                    </form>
                    @elseif (trim($order->status) === 'en_traitement' && trim(Auth::user()->role) === 'gestionnaire')
                    <form action="{{ route('orders.validate', $order->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-sm">Valider</button>
                    </form>
                    @else
                    <form action="{{ route('orders.show', $order->id) }}" method="GET" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-sm">Voir détails</button>
                    </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>
@endsection

@php
\Log::info('Statut de la commande : ' . $order->status);
\Log::info('Rôle de l\'utilisateur : ' . Auth::user()->role);
@endphp