<?php

namespace App\Listeners;

use App\Events\OrderValidated;
use App\Mail\OrderValidatedMail;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class SendOrderValidatedNotification
{
    public function handle(OrderValidated $event)
    {
        $order = $event->order;
        $pdfPath = 'private/invoices/invoice_' . $order->id . '.pdf'; // 🔥 Modifier ici pour s'assurer qu'il est bien dans private/

        // Vérifier et créer le dossier
        Storage::makeDirectory('private/invoices');

        // Générer le PDF
        $pdf = Pdf::loadView('pdf.invoice', ['order' => $order]);

        // Sauvegarder le PDF dans le bon dossier
        Storage::put($pdfPath, $pdf->output());

        // Envoyer l'email avec la facture
        Mail::to($order->user->email)->send(new OrderValidatedMail($order, $pdfPath));
    }
}
