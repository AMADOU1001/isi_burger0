<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class TestController extends Controller
{



    public function testPdf()
    {
        $dummyOrder = (object) [
            'id' => 999,
            'created_at' => now(),
            'user' => (object) ['name' => 'Client Test'],
            'burgers' => [
                (object) ['name' => 'Burger Test', 'pivot' => (object) ['quantity' => 2], 'price' => 5]
            ],
            'total_price' => 10
        ];

        $pdf = Pdf::loadView('pdf.invoice', ['order' => $dummyOrder]);

        if (!$pdf) {
            return "Erreur lors de la génération du PDF";
        }

        $pdfPath = 'invoices/invoice_test.pdf';
        Storage::put($pdfPath, $pdf->output());

        if (!Storage::exists($pdfPath)) {
            return "Échec de l'enregistrement du PDF";
        }

        return "PDF généré avec succès dans " . storage_path('app/' . $pdfPath);
    }
}
