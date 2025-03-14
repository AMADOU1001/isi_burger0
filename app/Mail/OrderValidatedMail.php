<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class OrderValidatedMail extends Mailable
{
    use  SerializesModels;

    public $order;
    public $pdfPath;

    public function __construct($order, $pdfPath)
    {
        $this->order = $order;
        $this->pdfPath = $pdfPath;
    }

    public function build()
    {
        return $this->view('mail.order_validated')
            ->attach(Storage::path($this->pdfPath), [  // 🔥 CHANGEMENT ICI 🔥
                'as' => 'facture_' . $this->order->id . '.pdf',
                'mime' => 'application/pdf',
            ]);
    }
}
