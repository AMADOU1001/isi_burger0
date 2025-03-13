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
            // Redirige le gestionnaire vers la vue de gestion des burgers
            $burgers = Burger::all();
            return view('gestionnaire.home', compact('burgers'));
        } else {
            // Redirige le client vers la vue des burgers publiés et de ses commandes
            $orders = Order::where('user_id', $user->id)->get();
            $burgers = Burger::where('is_published', true)->get();
            return view('client.home', compact('orders', 'burgers'));
        }
    }
}
