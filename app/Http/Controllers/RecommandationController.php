<?php

namespace App\Http\Controllers;

use App\Models\Recommandation;
use App\Models\Livre;
use App\Models\Emprunt;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RecommandationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // Recommandations basées sur les catégories
        $recommandationsCategories = Recommandation::with(['livre', 'livre.auteur', 'livre.categories'])
            ->where('user_id', Auth::id())
            ->orderByDesc('priorite')  // Utiliser priorite au lieu de score
            ->get()
            ->pluck('livre');
            
        // Livres les plus populaires
        $livresPopulaires = Livre::withCount('emprunts')
            ->with(['auteur'])
            ->orderByDesc('emprunts_count')
            ->limit(4)
            ->get();
            
        // Nouveautés
        $nouveautes = Livre::with(['auteur'])
            ->orderByDesc('created_at')
            ->limit(4)
            ->get();
            
        return view('membre.recommandations.index', compact('recommandationsCategories', 'livresPopulaires', 'nouveautes'));
    }

    // Génère des recommandations pour l'utilisateur connecté
    public function genererRecommandations()
    {
        $userId = Auth::id();
        
        // Récupérer les catégories préférées de l'utilisateur (basées sur les emprunts)
        $categoriesPreferees = Emprunt::where('user_id', $userId)
            ->join('livres', 'emprunts.livre_id', '=', 'livres.id')
            ->select('livres.categorie_id', DB::raw('COUNT(*) as count'))
            ->groupBy('livres.categorie_id')
            ->orderByDesc('count')
            ->limit(3)
            ->pluck('categorie_id');
            
        // Livres déjà empruntés
        $livresEmpruntes = Emprunt::where('user_id', $userId)
            ->pluck('livre_id')
            ->toArray();
            
        // Récupérer des livres similaires basés sur les catégories
        $livresSimilaires = Livre::whereIn('categorie_id', $categoriesPreferees)
            ->whereNotIn('id', $livresEmpruntes) // Exclure les livres déjà empruntés
            ->where('stock_disponible', '>', 0) // Uniquement les livres disponibles
            ->get();
            
        // Supprimer les anciennes recommandations
        Recommandation::where('user_id', $userId)->delete();
        
        $compteur = 0;
        foreach ($livresSimilaires as $livre) {
            // Créer la recommandation
            Recommandation::create([
                'user_id' => $userId,
                'livre_id' => $livre->id,
                'type' => 'categorie',
                'categorie_id' => $livre->categorie_id,
                'priorite' => 1, // Priorité par défaut
                'commentaire' => 'Basé sur vos lectures précédentes'
            ]);
            
            $compteur++;
            if ($compteur >= 10) break; // Limiter à 10 recommandations
        }
        
        // Créer une notification
        if ($compteur > 0) {
            Notification::create([
                'user_id' => $userId,
                'titre' => 'Nouvelles recommandations',
                'message' => "Nous avons généré $compteur nouvelles recommandations de lecture pour vous!",
                'type' => 'recommandation',
            ]);
        }
        
        return redirect()->route('membre.recommandations.index')
            ->with('success', "$compteur recommandations ont été générées pour vous.");
    }
}
