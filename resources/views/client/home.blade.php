@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Section Hero -->
    <div class="hero-section">
        <div>
            <h1>Bienvenue chez ISI Burger</h1>
            <p>Découvrez nos délicieux burgers faits maison</p>
        </div>
    </div>

    <!-- Section Menu -->
    <div class="bg-dark py-5">
        <div class="container">
            <h2 class="text-center mb-4">Notre Menu</h2>
            <div class="row">
                @foreach ($burgers as $burger)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="{{ asset('images/' . $burger->image) }}" class="card-img-top" alt="{{ $burger->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $burger->name }}</h5>
                            <p class="card-text">{{ $burger->description }}</p>
                            <p class="card-text"><strong>Prix : {{ $burger->price }} €</strong></p>
                            <a href="{{ route('orders.create', ['burger_id' => $burger->id]) }}" class="btn btn-primary">Commander</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection