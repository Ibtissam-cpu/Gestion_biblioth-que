<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Livre;
use App\Models\Categorie;
use App\Models\Auteur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LivreController extends Controller
{
    public function index()
    {
        $livres = Livre::with(['categorie', 'auteur'])
            ->orderBy('titre')
            ->paginate(10);

        return view('admin.livres.index', compact('livres'));
    }

    public function create()
    {
        $categories = Categorie::orderBy('nom')->get();
        $auteurs = Auteur::orderBy('nom')->get();

        return view('admin.livres.create', compact('categories', 'auteurs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|max:255',
            'isbn' => 'required|unique:livres,isbn',
            'description' => 'nullable',
            'annee_publication' => 'required|integer|min:1000|max:' . date('Y'),
            'categorie_id' => 'required|exists:categories,id',
            'auteur_id' => 'required|exists:auteurs,id',
            'quantite' => 'required|integer|min:0',
            'image' => 'nullable|image|max:2048'
        ]);

        $livre = new Livre();
        $livre->titre = $validated['titre'];
        $livre->isbn = $validated['isbn'];
        $livre->description = $validated['description'];
        $livre->annee_publication = $validated['annee_publication'];
        $livre->categorie_id = $validated['categorie_id'];
        $livre->auteur_id = $validated['auteur_id'];
        $livre->quantite = $validated['quantite'];

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('livres', 'public');
            $livre->image = $path;
        }

        $livre->save();

        return redirect()->route('admin.livres.index')
            ->with('success', 'Livre ajouté avec succès.');
    }

    public function show($id)
    {
        return view('admin.livres.show', compact('id'));
    }

    public function edit(Livre $livre)
    {
        $categories = Categorie::orderBy('nom')->get();
        $auteurs = Auteur::orderBy('nom')->get();

        return view('admin.livres.edit', compact('livre', 'categories', 'auteurs'));
    }

    public function update(Request $request, Livre $livre)
    {
        $validated = $request->validate([
            'titre' => 'required|max:255',
            'isbn' => 'required|unique:livres,isbn,' . $livre->id,
            'description' => 'nullable',
            'annee_publication' => 'required|integer|min:1000|max:' . date('Y'),
            'categorie_id' => 'required|exists:categories,id',
            'auteur_id' => 'required|exists:auteurs,id',
            'quantite' => 'required|integer|min:0',
            'image' => 'nullable|image|max:2048'
        ]);

        $livre->titre = $validated['titre'];
        $livre->isbn = $validated['isbn'];
        $livre->description = $validated['description'];
        $livre->annee_publication = $validated['annee_publication'];
        $livre->categorie_id = $validated['categorie_id'];
        $livre->auteur_id = $validated['auteur_id'];
        $livre->quantite = $validated['quantite'];

        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image si elle existe
            if ($livre->image) {
                Storage::disk('public')->delete($livre->image);
            }
            $path = $request->file('image')->store('livres', 'public');
            $livre->image = $path;
        }

        $livre->save();

        return redirect()->route('admin.livres.index')
            ->with('success', 'Livre mis à jour avec succès.');
    }

    public function destroy(Livre $livre)
    {
        // Vérifier si le livre a des emprunts en cours
        if ($livre->emprunts()->whereNull('date_retour')->exists()) {
            return redirect()->route('admin.livres.index')
                ->with('error', 'Impossible de supprimer ce livre car il a des emprunts en cours.');
        }

        // Supprimer l'image si elle existe
        if ($livre->image) {
            Storage::disk('public')->delete($livre->image);
        }

        $livre->delete();

        return redirect()->route('admin.livres.index')
            ->with('success', 'Livre supprimé avec succès.');
    }
} 