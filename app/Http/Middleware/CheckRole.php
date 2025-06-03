<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  ...$roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Si l'utilisateur n'est pas connecté, rediriger vers la page de connexion
        if (!$request->user()) {
            return redirect('login');
        }

        // Vérifier si l'utilisateur est un admin
        if ($request->user()->isAdmin()) {
            return $next($request);
        }

        // Pour le rôle 'bibliothecaire'
        if (in_array('bibliothecaire', $roles) && $request->user()->isBibliothecaire()) {
            return $next($request);
        }

        // Si nous arrivons ici, l'utilisateur n'a pas le rôle requis
        abort(403, 'Accès non autorisé.');
    }
}

