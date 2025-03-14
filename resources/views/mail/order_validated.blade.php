<!DOCTYPE html>
<html>

<head>
    <title>Commande validée</title>
</head>

<body>
    <h1>Bonjour {{ $order->user->name }},</h1>
    <p>Votre commande n°{{ $order->id }} a été validée.</p>
    <p>Montant total : {{ $order->total_price }} €</p>
    <p>Merci pour votre confiance !</p>
</body>

</html>