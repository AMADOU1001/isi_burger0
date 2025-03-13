@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Créer une Commande</h1>
    <form action="{{ route('orders.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="burgers">Burgers</label>
            @foreach ($burgers as $burger)
            <div class="form-check">
                <input type="checkbox" name="burger_ids[]" id="burger_{{ $burger->id }}" value="{{ $burger->id }}" class="form-check-input">
                <label for="burger_{{ $burger->id }}" class="form-check-label">
                    {{ $burger->name }} ({{ $burger->price }} €)
                </label>
                <input type="number" name="quantities[]" class="form-control" placeholder="Quantité" min="1" value="1">
            </div>
            @endforeach
        </div>
        <button type="submit" class="btn btn-success">Créer la Commande</button>
    </form>
</div>
@endsection