@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Modifier la Commande #{{ $order->id }}</h1>
    <form action="{{ route('orders.update', $order->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="status">Statut</label>
            <select name="status" id="status" class="form-control">
                <option value="en_attente" {{ $order->status === 'en_attente' ? 'selected' : '' }}>En attente</option>
                <option value="en_preparation" {{ $order->status === 'en_preparation' ? 'selected' : '' }}>En préparation</option>
                <option value="prete" {{ $order->status === 'prete' ? 'selected' : '' }}>Prête</option>
                <option value="payee" {{ $order->status === 'payee' ? 'selected' : '' }}>Payée</option>
            </select>
        </div>
        <button type="submit" class="btn btn-warning">Mettre à jour</button>
    </form>
</div>
@endsection