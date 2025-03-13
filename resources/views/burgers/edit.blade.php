@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Modifier le Burger</h1>
    <form action="{{ route('burgers.update', $burger->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Nom</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $burger->name }}" required>
        </div>
        <div class="form-group">
            <label for="price">Prix</label>
            <input type="number" name="price" id="price" class="form-control" value="{{ $burger->price }}" step="0.01" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control" required>{{ $burger->description }}</textarea>
        </div>
        <div class="form-group">
            <label for="stock">Stock</label>
            <input type="number" name="stock" id="stock" class="form-control" value="{{ $burger->stock }}" required>
        </div>
        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" name="image" id="image" class="form-control">
            @if ($burger->image)
            <img src="{{ asset('storage/' . $burger->image) }}" alt="{{ $burger->name }}" class="img-fluid mt-2" style="max-width: 200px;">
            @endif
        </div>
        <button type="submit" class="btn btn-warning">Mettre à jour</button>
    </form>
</div>
@endsection