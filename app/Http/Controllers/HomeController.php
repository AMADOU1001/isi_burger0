<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Burger;

class HomeController extends Controller
{
    /**
     * Affiche le tableau de bord en fonction du rôle de l'utilisateur.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'gestionnaire') {
            // Récupère tous les burgers
            $burgers = Burger::all();

            // Récupère toutes les commandes avec les utilisateurs associés
            $orders = Order::with('user')->get();

            // Statistiques des commandes par mois
            $year = now()->year; // Année en cours
            $monthlyOrders = Order::getMonthlyOrderStatistics($year);

            // Statistiques journalières
            $todayPendingOrders = Order::whereDate('created_at', now()->toDateString())
                ->where('status', 'en_attente')
                ->count();

            $todayCompletedOrders = Order::whereDate('created_at', now()->toDateString())
                ->where('status', 'validée')
                ->count();

            $todayRevenue = Order::whereDate('created_at', now()->toDateString())
                ->where('status', 'validée')
                ->sum('total_price');

            // Passe les variables à la vue
            return view('gestionnaire.home', compact(
                'burgers',
                'orders',
                'monthlyOrders',
                'todayPendingOrders',
                'todayCompletedOrders',
                'todayRevenue'
            ));
        } else {
            // Redirige le client vers la vue des burgers publiés et de ses commandes
            $orders = Order::where('user_id', $user->id)->get();
            $burgers = Burger::where('is_published', true)->get();
            return view('client.home', compact('orders', 'burgers'));
        }
    }

    /**
     * Récupère le nombre de commandes en cours pour aujourd'hui.
     */
    public function getTodayPendingOrders()
    {
        return Order::whereDate('created_at', today())
            ->where('status', 'en_traitement')
            ->count();
    }

    /**
     * Récupère le nombre de commandes validées pour aujourd'hui.
     */
    public function getTodayCompletedOrders()
    {
        return Order::whereDate('created_at', today())
            ->where('status', 'validée')
            ->count();
    }

    /**
     * Récupère les recettes journalières.
     */
    public function getTodayRevenue()
    {
        return Order::whereDate('created_at', today())
            ->where('status', 'validée')
            ->sum('total_price');
    }

    /**
     * Récupère le nombre de commandes par mois.
     */
    public function getMonthlyOrders()
    {
        return Order::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();
    }

    /**
     * Récupère le nombre de burgers vendus par mois.
     */
    public function getMonthlyBurgersSold()
    {
        return Order::join('burger_order', 'orders.id', '=', 'burger_order.order_id')
            ->selectRaw('MONTH(orders.created_at) as month, SUM(burger_order.quantity) as total')
            ->whereYear('orders.created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();
    }
}
