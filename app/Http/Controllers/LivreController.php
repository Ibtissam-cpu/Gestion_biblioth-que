<?php

namespace App\Http\Controllers;

use App\Models\Livre;
use App\Models\Auteur;
use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LivreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $query = Livre::with(['auteur', 'categorie']);

    // Filtrage
    if ($request->has('categorie_id') && $request->categorie_id) {
        $query->where('categorie_id', $request->categorie_id);
    }

    if ($request->has('disponible') && $request->disponible == 1) {
        $query->where('stock_disponible', '>', 0);
    }

    if ($request->has('terme') && $request->terme) {
        $query->recherche($request->terme);
    }

    $livres = $query->latest()->paginate(15);
    $categories = Categorie::all();

    return view('livres.index', compact('livres', 'categories'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $auteurs = Auteur::all();
        $categories = Categorie::all();
        return view('livres.create', compact('auteurs', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'auteur_id' => 'required|exists:auteurs,id',
            'categorie_id' => 'required|exists:categories,id',
            'isbn' => 'required|string|max:20|unique:livres',
            'description' => 'nullable|string',
            'annee_publication' => 'nullable|integer|min:1000|max:' . (date('Y') + 1),
            'editeur' => 'nullable|string|max:255',
            'nombre_pages' => 'nullable|integer|min:1',
            'stock_total' => 'required|integer|min:0',
            'image_couverture' => 'nullable|image|max:2048',
        ]);

        // Gérer l'upload de l'image
        if ($request->hasFile('image_couverture')) {
            $path = $request->file('image_couverture')->store('couvertures', 'public');
            $validated['image_couverture'] = $path;
        }

        // Définir le stock disponible au même niveau que le stock total initial
        $validated['stock_disponible'] = $validated['stock_total'];

        Livre::create($validated);

        return redirect()->route('livres.index')
            ->with('success', 'Livre ajouté avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Livre $livre)
    {
        $livre->load(['auteur', 'categorie']);
        return view('livres.show', compact('livre'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Livre $livre)
    {
        $auteurs = Auteur::all();
        $categories = Categorie::all();
        return view('livres.edit', compact('livre', 'auteurs', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Livre $livre)
     {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'auteur_id' => 'required|exists:auteurs,id',
            'categorie_id' => 'required|exists:categories,id',
            'isbn' => 'required|string|max:20|unique:livres,isbn,' . $livre->id,
            'description' => 'nullable|string',
            'annee_publication' => 'nullable|integer|min:1000|max:' . (date('Y') + 1),
            'editeur' => 'nullable|string|max:255',
            'nombre_pages' => 'nullable|integer|min:1',
            'stock_total' => 'required|integer|min:' . ($livre->stock_total - $livre->stock_disponible),
            'image_couverture' => 'nullable|image|max:2048',
        ]);

        // Gérer l'upload de l'image
        if ($request->hasFile('image_couverture')) {
            // Supprimer l'ancienne image si elle existe
            if ($livre->image_couverture) {
                Storage::disk('public')->delete($livre->image_couverture);
            }
            
            $path = $request->file('image_couverture')->store('couvertures', 'public');
            $validated['image_couverture'] = $path;
        }

        // Ajuster le stock disponible
        $difference = $validated['stock_total'] - $livre->stock_total;
        $validated['stock_disponible'] = $livre->stock_disponible + $difference;

        $livre->update($validated);

        return redirect()->route('livres.index')
            ->with('success', 'Livre mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Livre $livre)
    {
        if ($livre->emprunts()->where('statut', 'en_cours')->count() > 0) {
            return back()->with('error', 'Impossible de supprimer ce livre car il a des emprunts en cours.');
        }

        // Supprimer l'image si elle existe
        if ($livre->image_couverture) {
            Storage::disk('public')->delete($livre->image_couverture);
        }

        $livre->delete();

        return redirect()->route('livres.index')
            ->with('success', 'Livre supprimé avec succès.');
    }
}
