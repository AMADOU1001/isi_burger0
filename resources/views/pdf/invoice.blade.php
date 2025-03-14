<!DOCTYPE html>
<html>

<head>
    <title>Facture #{{ $order->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        h1 {
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #333;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>

<body>
    <h1>Facture #{{ $order->id }}</h1>
    <p>Date : {{ $order->created_at->format('d/m/Y H:i') }}</p>
    <p>Client : {{ $order->user->name }}</p>
    <table>
        <thead>
            <tr>
                <th>Produit</th>
                <th>Quantité</th>
                <th>Prix unitaire</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->burgers as $burger)
            <tr>
                <td>{{ $burger->name }}</td>
                <td>{{ $burger->pivot->quantity }}</td>
                <td>{{ $burger->price }} F CFA</td>
                <td>{{ $burger->price * $burger->pivot->quantity }} €</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <p><strong>Montant total : {{ $order->total_price }} €</strong></p>
</body>

</html>