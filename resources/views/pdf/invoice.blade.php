<!DOCTYPE html>
<html>

<head>
    <title>Facture #{{ $order->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f9f9f9;
            color: #333;
        }

        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #28a745;
            text-align: center;
            margin-bottom: 20px;
            font-size: 28px;
        }

        .invoice-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .invoice-header p {
            margin: 5px 0;
            font-size: 16px;
            color: #555;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #28a745;
            color: #ffffff;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .total-amount {
            text-align: right;
            font-size: 18px;
            font-weight: bold;
            color: #28a745;
            margin-top: 20px;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 14px;
            color: #777;
        }

        .footer a {
            color: #28a745;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="invoice-container">
        <!-- En-tête de la facture -->
        <h1>Facture #{{ $order->id }}</h1>
        <div class="invoice-header">
            <p>Date : {{ $order->created_at->format('d/m/Y H:i') }}</p>
            <p>Client : {{ $order->user->name }}</p>
        </div>

        <!-- Tableau des produits -->
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
                    <td>{{ $burger->price * $burger->pivot->quantity }} F CFA</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Montant total -->
        <p class="total-amount">Montant total : {{ $order->total_price }} F CFA</p>

        <!-- Pied de page -->
        <div class="footer">
            <p>Merci pour votre commande !</p>
            <p>Pour toute question, contactez-nous à <a href="beizeamadou@icloud.com">beizeamadou@icloud.com</a>.</p>
            <p>&copy; {{ date('Y') }} Votre ISI BURGER. Tous droits réservés.</p>
        </div>
    </div>
</body>

</html>