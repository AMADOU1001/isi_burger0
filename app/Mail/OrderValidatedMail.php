<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Order;

class OrderValidatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    /**
     * Create a new message instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Votre commande a été validée !')
            ->view('emails.order_validated') // Vue de l'e-mail
            ->attachData($this->generatePdf(), 'facture.pdf', [
                'mime' => 'application/pdf',
            ]);
    }

    /**
     * Génère le PDF de la facture.
     */
    protected function generatePdf()
    {
        // Utilise une bibliothèque comme DomPDF pour générer le PDF
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.invoice', ['order' => $this->order]);
        return $pdf->output();
    }
}
