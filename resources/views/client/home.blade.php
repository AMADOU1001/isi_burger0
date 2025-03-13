<!-- Section : Vos Commandes -->
<div class="mb-5">
    <h2>Vos Commandes</h2>
    @if ($orders->isEmpty())
    <p>Vous n'avez aucune commande pour le moment.</p>
    @else
    <table class="table">
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
                <td>{{ $order->total_price }} €</td>
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
                    @else
                    <span class="text-muted">Aucune action disponible</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>