<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsClient
{
    /**
     * Vérifie si l'utilisateur est un client.
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role === 'client') {
            return $next($request);
        }

        abort(403, 'Accès non autorisé.');
    }
}
