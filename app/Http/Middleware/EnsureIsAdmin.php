<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
   public function handle($request, Closure $next)
{
    if (!auth()->check()) {
        return redirect()->route('login');
    }

    $user = auth()->user();
    
    if (!$user->isAdmin()) {
        // Log pour débogage (à vérifier dans storage/logs/laravel.log)
        \Log::warning('Tentative d\'accès admin non autorisée', [
            'user_id' => $user->id,
            'role' => $user->role,
            'is_admin' => $user->is_admin
        ]);
        
        abort(403, 'Accès réservé aux administrateurs');
    }

    return $next($request);
}
}
