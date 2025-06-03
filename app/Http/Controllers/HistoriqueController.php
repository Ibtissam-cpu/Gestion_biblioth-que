<?php

namespace App\Http\Controllers;

use App\Models\Historique;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Emprunt;

class HistoriqueController extends Controller
{
   public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {        
        $users = User::where('role', 'membre')->get(); // Déclaré avant les conditions
        if (Auth::user()->isAdmin() || Auth::user()->isBibliothecaire()) {
            // Les admins et bibliothécaires voient tout l'historique
            $query = Historique::with(['user', 'livre']);
            
            // Filtrage
            if ($request->has('user_id') && $request->user_id) {
                $query->where('user_id', $request->user_id);
            }
            
            if ($request->has('action') && $request->action) {
                $query->where('action', $request->action);
            }
            
            $historiques = $query->latest('date_action')->paginate(25);
            $users = User::where('role', 'membre')->get();
            
            return view('historiques.index', compact('historiques', 'users'));
        } else {
            // Les membres ne voient que leur historique
            $historiques = Historique::with(['livre'])
                ->where('user_id', Auth::id())
                ->latest('date_action')
                ->paginate(25);
                
            return view('historiques.index', compact('historiques', 'users'));
        }
    }

    public function userHistorique(User $user)
    {
        // Vérifier les permissions
        if (!Auth::user()->isAdmin() && !Auth::user()->isBibliothecaire() && Auth::id() !== $user->id) {
            abort(403);
        }
        
        $historiques = Historique::with(['livre'])
            ->where('user_id', $user->id)
            ->latest('date_action')
            ->paginate(25);
            
        return view('historiques.user', compact('historiques', 'user'));
    }

    public function empruntHistorique()
    {
        $user = auth()->user();
        
        $emprunts = Emprunt::with(['livre', 'livre.auteur'])
            ->where('user_id', $user->id)
            ->orderByDesc('date_emprunt')
            ->paginate(10);

        $statistiques = [
            'total' => Emprunt::where('user_id', $user->id)->count(),
            'en_cours' => Emprunt::where('user_id', $user->id)
                ->whereNull('date_retour')
                ->count(),
            'retournes' => Emprunt::where('user_id', $user->id)
                ->whereNotNull('date_retour')
                ->count(),
            'en_retard' => Emprunt::where('user_id', $user->id)
                ->whereNull('date_retour')
                ->where('date_retour_prevue', '<', now())
                ->count()
        ];

        return view('membre.historique.index', compact('emprunts', 'statistiques'));
    }
}
