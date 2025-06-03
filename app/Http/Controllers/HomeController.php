<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Livre;
use App\Models\Auteur;
use App\Models\Categorie;
use App\Models\User;
use App\Models\Emprunt;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Affiche la page d'accueil
     */
    public function index()
    {
        // Récupérer les catégories pour le formulaire de recherche
        $categories = Categorie::orderBy('nom')->get();
        
        // Récupérer les nouveautés (livres récemment ajoutés)
        $nouveautes = Livre::with(['auteur', 'categorie'])
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();
            
        // Si vous avez des événements, vous pouvez les récupérer ici
        $evenements = collect([]);
        
        // Si vous avez des témoignages, vous pouvez les récupérer ici
        $temoignages = collect([]);
        
        // Statistiques pour le compteur
        $stats = [
            'livres' => Livre::count(),
            'membres' => User::count(),
            'emprunts' => Emprunt::count(),
            'auteurs' => Auteur::count(),
        ];
        
        return view('home', compact('categories', 'nouveautes', 'evenements', 'temoignages', 'stats'));
    }
}
