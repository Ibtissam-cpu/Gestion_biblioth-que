<?php

namespace App\Http\Controllers;

use App\Models\Livre;
use App\Models\Auteur;
use App\Models\Categorie;
use Illuminate\Http\Request;

class RechercheController extends Controller
{
    public function index()
    {
        $categories = Categorie::all();
        return view('recherche.index', compact('categories'));
    }

    public function rechercher(Request $request)
    {
        $query = Livre::with(['auteur', 'categorie']);
        
        // Recherche par terme
        if ($request->has('terme') && $request->terme) {
            $terme = $request->terme;
            $query->where(function($q) use ($terme) {
                $q->where('titre', 'like', "%{$terme}%")
                  ->orWhere('isbn', 'like', "%{$terme}%")
                  ->orWhere('description', 'like', "%{$terme}%")
                  ->orWhereHas('auteur', function($q) use ($terme) {
                      $q->where('nom', 'like', "%{$terme}%")
                        ->orWhere('prenom', 'like', "%{$terme}%");
                  });
            });
        }
        
        // Filtrage par catégorie
        if ($request->has('categorie_id') && $request->categorie_id) {
            $query->where('categorie_id', $request->categorie_id);
        }
        
        // Filtrage par disponibilité
        if ($request->has('disponible') && $request->disponible) {
            $query->where('stock_disponible', '>', 0);
        }
        
        // Filtrage par année de publication
        if ($request->has('annee_min') && $request->annee_min) {
            $query->where('annee_publication', '>=', $request->annee_min);
        }
        
        if ($request->has('annee_max') && $request->annee_max) {
            $query->where('annee_publication', '<=', $request->annee_max);
        }
        
        $livres = $query->paginate(15);
        $categories = Categorie::all();
        
        return view('recherche.resultats', compact('livres', 'categories'));
    }

    public function avancee()
    {
        $categories = Categorie::all();
        $auteurs = Auteur::orderBy('nom')->get();
        
        return view('recherche.avancee', compact('categories', 'auteurs'));
    }
}
