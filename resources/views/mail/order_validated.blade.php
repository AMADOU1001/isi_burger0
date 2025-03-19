<!DOCTYPE html>
<html>

<head>
    <title>Commande validée</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .email-header {
            background-color: #28a745;
            color: #ffffff;
            padding: 20px;
            text-align: center;
        }

        .email-header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
        }

        .email-body {
            padding: 20px;
            line-height: 1.6;
        }

        .email-body h2 {
            color: #28a745;
            font-size: 20px;
            margin-bottom: 10px;
        }

        .email-body p {
            margin: 10px 0;
        }

        .email-footer {
            background-color: #f4f4f4;
            padding: 15px;
            text-align: center;
            font-size: 14px;
            color: #666;
            border-top: 1px solid #ddd;
        }

        .email-footer a {
            color: #28a745;
            text-decoration: none;
        }

        .email-footer a:hover {
            text-decoration: underline;
        }

        .highlight {
            color: #28a745;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <!-- En-tête du mail -->
        <div class="email-header">
            <h1>Commande validée</h1>
        </div>

        <!-- Corps du mail -->
        <div class="email-body">
            <h2>Bonjour {{ $order->user->name }},</h2>
            <p>Nous sommes ravis de vous informer que votre commande n°<span class="highlight">{{ $order->id }}</span> a été validée avec succès.</p>
            <p>Montant total : <span class="highlight">{{ $order->total_price }} F CFA</span></p>
            <p>Merci pour votre confiance et à bientôt !</p>
        </div>

        <!-- Pied de page du mail -->
        <div class="email-footer">
            <p>Si vous avez des questions, n'hésitez pas à nous contacter à l'adresse <a href="mailto:beizeamadou@icloud.com">beizeamadou@icloud.com</a>.</p>
            <p>&copy; {{ date('Y') }} ISI BURGER. Tous droits réservés.</p>
        </div>
    </div>
</body>

</html>