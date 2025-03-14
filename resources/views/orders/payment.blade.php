@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Paiement de la Commande #{{ $order->id }}</h1>
    <p>Montant à payer : {{ $order->total_price }} €</p>

    <form action="{{ route('orders.processPayment', $order->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="card_number">Numéro de carte</label>
            <input type="text" id="card_number" name="card_number" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="expiry_date">Date d'expiration</label>
            <input type="text" id="expiry_date" name="expiry_date" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="cvv">CVV</label>
            <input type="text" id="cvv" name="cvv" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Payer</button>
    </form>
</div>
@endsection