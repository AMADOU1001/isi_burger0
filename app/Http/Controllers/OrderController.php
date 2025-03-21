<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Burger;
use App\Models\User;
use Illuminate\Support\Facades\Auth; // Import de la façade Auth
use Illuminate\Http\Request;
use App\Mail\OrderValidatedMail;
use Illuminate\Support\Facades\Mail;
use App\Events\OrderValidated;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    /**
     * Affiche la liste des commandes.
     */
    public function index(Request $request)
    {
        // Récupérer l'utilisateur connecté
        $user = Auth::user();

        // Récupérer toutes les commandes en fonction du rôle de l'utilisateur
        if ($user->role === 'gestionnaire') {
            $orders = Order::with('user', 'burgers')->get(); // Toutes les commandes pour le gestionnaire
        } else {
            $orders = Order::where('user_id', $user->id)->with('burgers')->get(); // Commandes de l'utilisateur connecté
        }

        // Filtrer les commandes en fonction du statut sélectionné
        $status = $request->input('status'); // Récupérer le statut depuis la requête
        if ($status && in_array($status, ['en_traitement', 'validée'])) {
            $orders = $orders->where('status', $status); // Filtrer les commandes par statut
        }

        // Passer les commandes filtrées à la vue
        return view('orders.index', compact('orders'));
    }


    /**
     * Affiche le formulaire de création d'une commande.
     */
    public function create()
    {
        if (Auth::user()->role !== 'client') {
            abort(403, 'Accès non autorisé.');
        }

        // Vérifie si l'utilisateur a déjà une commande en cours
        $existingOrder = Order::where('user_id', Auth::id())
            ->whereIn('status', ['en_attente', 'en_preparation'])
            ->first();

        if ($existingOrder) {
            return redirect()->route('orders.index')->with('error', 'Vous avez déjà une commande en cours.');
        }

        $burgers = Burger::where('is_published', true)->get(); // Seuls les burgers publiés
        return view('orders.create', compact('burgers'));
    }


    /**
     * Enregistre une nouvelle commande dans la base de données.
     */
    public function store(Request $request)
    {
        if (Auth::user()->role !== 'client') {
            abort(403, 'Accès non autorisé.');
        }

        // Validation des données du formulaire
        $request->validate([
            'burger_ids' => 'required|array',
            'burger_ids.*' => 'exists:burgers,id',
            'quantities' => 'required|array',
            'quantities.*' => 'integer|min:1',
        ]);

        // Calcul du prix total
        $totalPrice = 0;
        foreach ($request->burger_ids as $index => $burgerId) {
            $burger = Burger::find($burgerId);
            $totalPrice += $burger->price * $request->quantities[$index];
        }

        // Création de la commande
        $order = Order::create([
            'user_id' => Auth::id(),
            'total_price' => $totalPrice,
            'status' => 'en_attente',
        ]);

        // Ajout des burgers à la commande
        foreach ($request->burger_ids as $index => $burgerId) {
            $order->burgers()->attach($burgerId, ['quantity' => $request->quantities[$index]]);
        }

        return redirect()->route('orders.index')->with('success', 'Commande créée avec succès !');
    }


    /**
     * Affiche les détails d'une commande.
     */
    public function show(Order $order)
    {
        // Récupère l'utilisateur authentifié
        $user = Auth::user();

        // Vérifie que l'utilisateur a le droit de voir cette commande
        if ($user->role !== 'gestionnaire' && $order->user_id !== $user->id) {
            abort(403, 'Accès non autorisé.');
        }

        return view('orders.show', compact('order'));
    }

    /**
     * Affiche le formulaire de modification d'une commande.
     */
    public function edit(Order $order)
    {
        // Récupère l'utilisateur authentifié
        $user = Auth::user();

        // Vérifie que l'utilisateur a le droit de modifier cette commande
        if ($user->role !== 'gestionnaire') {
            abort(403, 'Accès non autorisé.');
        }

        $burgers = Burger::all(); // Récupère tous les burgers disponibles
        return view('orders.edit', compact('order', 'burgers'));
    }

    /**
     * Met à jour une commande dans la base de données.
     */
    public function update(Request $request, Order $order)
    {
        // Récupère l'utilisateur authentifié
        $user = Auth::user();

        // Vérifie que l'utilisateur a le droit de modifier cette commande
        if ($user->role !== 'gestionnaire') {
            abort(403, 'Accès non autorisé.');
        }

        // Validation des données du formulaire
        $request->validate([
            'status' => 'required|in:en_attente,en_preparation,prete,payee',
        ]);

        // Mise à jour du statut de la commande
        $order->update([
            'status' => $request->status,
        ]);

        return redirect()->route('gestionnaire.home')->with('success', 'Commande mise à jour avec succès !');
    }

    /**
     * Supprime une commande de la base de données.
     */
    public function destroy(Order $order)
    {
        // Récupère l'utilisateur authentifié
        $user = Auth::user();

        // Vérifie que l'utilisateur a le droit de supprimer cette commande
        if ($user->role !== 'gestionnaire') {
            abort(403, 'Accès non autorisé.');
        }

        $order->delete(); // Supprime la commande
        return redirect()->route('gestionnaire.home')->with('success', 'Commande supprimée avec succès!');
    }

    /**
     * Affiche le formulaire pour enregistrer un paiement.
     */
    public function payment(Order $order)
    {
        // Vérifie que l'utilisateur a le droit de modifier cette commande
        if (Auth::user()->role !== 'gestionnaire') {
            abort(403, 'Accès non autorisé.');
        }

        return view('orders.payment', compact('order'));
    }

    /**
     * Enregistre un paiement pour une commande.
     */
    public function processPayment(Request $request, Order $order)
    {
        // Vérifie que l'utilisateur est le propriétaire de la commande
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Accès non autorisé.');
        }

        // Vérifie que la commande est en attente
        if ($order->status !== 'en_attente') {
            return redirect()->route('home')->with('error', 'Cette commande ne peut pas être payée.');
        }

        // Validation des données du formulaire
        $request->validate([
            'card_number' => 'required|string',
            'expiry_date' => 'required|string',
            'cvv' => 'required|string',
        ]);

        // Met à jour le statut de la commande
        $order->update([
            'status' => 'en_traitement', // Statut après paiement
            'payment_status' => 'payée', // Statut du paiement
        ]);

        return redirect()->route('home')->with('success', 'Paiement effectué avec succès ! La commande est en traitement.');
    }


    public function pay(Order $order)
    {
        // Vérifie que l'utilisateur est le propriétaire de la commande
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Accès non autorisé.');
        }

        // Vérifie que la commande est en attente
        if ($order->status !== 'en_attente') {
            return redirect()->route('home')->with('error', 'Cette commande ne peut pas être payée.');
        }

        // Redirige vers la page de paiement
        return view('orders.payment', compact('order'));
    }

    public function cancel(Order $order)
    {
        // Vérifie que l'utilisateur est le propriétaire de la commande
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Accès non autorisé.');
        }

        // Vérifie que la commande est en attente
        if ($order->status !== 'en_attente') {
            return redirect()->route('home')->with('error', 'Cette commande ne peut pas être annulée.');
        }

        // Supprime la commande
        $order->delete();

        return redirect()->route('home')->with('success', 'Commande annulée avec succès !');
    }

    /**
     * Valide une commande (gestionnaire uniquement).
     */






    public function validateOrder(Request $request, Order $order)
    {
        // Vérification du rôle de l'utilisateur
        if (Auth::user()->role !== 'gestionnaire') {
            abort(403, 'Accès non autorisé.');
        }

        // Vérification du statut de la commande
        if ($order->status !== 'en_traitement') {
            return redirect()->route('gestionnaire.home')->with('error', 'Cette commande ne peut pas être validée.');
        }

        // Mise à jour du statut de la commande
        $order->update([
            'status' => 'validée',
        ]);

        // Déclencher l'événement pour envoyer l'email et générer la facture
        event(new OrderValidated($order));

        // Vérifier et créer le dossier invoices s'il n'existe pas
        Storage::makeDirectory('invoices'); // Crée le dossier s'il n'existe pas

        // Générer la facture PDF
        $pdf = Pdf::loadView('pdf.invoice', ['order' => $order]);
        $pdfPath = 'invoices' . DIRECTORY_SEPARATOR . 'invoice_' . $order->id . '.pdf';

        // Sauvegarder le fichier PDF dans storage/app/invoices/
        Storage::put($pdfPath, $pdf->output());

        // Envoyer l'email avec la facture en pièce jointe
        Mail::to($order->user->email)->send(new OrderValidatedMail($order, $pdfPath));

        return redirect()->route('gestionnaire.home')->with('success', 'Commande validée avec succès et mail envoyé !');
    }




    public function showStatistics()
    {
        $year = now()->year; // Vous pouvez rendre cette valeur dynamique
        $monthlyOrders = Order::getMonthlyOrderStatistics($year);

        return view('orders.statistics', compact('monthlyOrders'));
    }

    public function downloadInvoice($orderId)
    {
        $order = Order::findOrFail($orderId);

        // Chemin du fichier PDF
        $pdfPath = "private/invoices/invoice_{$order->id}.pdf";

        // Vérifier si le fichier existe
        if (!Storage::exists($pdfPath)) {
            return abort(404, "Facture introuvable.");
        }

        // Retourner le PDF en téléchargement
        return response()->file(Storage::path($pdfPath), [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="facture_' . $order->id . '.pdf"',
        ]);
    }
}
