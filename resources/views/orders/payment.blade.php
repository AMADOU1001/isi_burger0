@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Enregistrer un Paiement pour la Commande #{{ $order->id }}</h1>
    <form action="{{ route('orders.payment', $order->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="amount">Montant payé</label>
            <input type="number" name="amount" id="amount" class="form-control" step="0.01" required>
        </div>
        <button type="submit" class="btn btn-success">Enregistrer le Paiement</button>
    </form>
</div>
@endsection