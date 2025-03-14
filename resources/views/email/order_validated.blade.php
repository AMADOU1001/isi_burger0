<!DOCTYPE html>
<html>

<head>
    <title>Commande Validée</title>
</head>

<body>
    <h1>Bonjour {{ $order->user->name }},</h1>
    <p>Votre commande #{{ $order->id }} a été validée avec succès.</p>
    <p>Montant total : {{ $order->total_price }} €</p>
    <p>Merci pour votre confiance !</p>
</body>

</html>