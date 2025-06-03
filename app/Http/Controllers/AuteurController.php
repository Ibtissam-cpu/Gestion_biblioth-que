<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Auteur;

class AuteurController extends Controller
{
    public function __construct()
    {
        // Utilisez le middleware 'auth' avant le middleware 'role'
        $this->middleware('auth');
        // Seuls les admins et bibliothécaires peuvent gérer les auteurs
        $this->middleware('role:admin,bibliothecaire')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $auteurs = Auteur::orderBy('nom')->paginate(10);
        return view('auteurs.index', compact('auteurs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('auteurs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|max:255',
            'biographie' => 'nullable',
            'date_naissance' => 'nullable|date',
        ]);

        Auteur::create($validated);

        return redirect()->route('auteurs.index')
            ->with('success', 'Auteur créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Auteur $auteur)
    {
        return view('auteurs.show', compact('auteur'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Auteur $auteur)
    {
        return view('auteurs.edit', compact('auteur'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Auteur $auteur)
    {
        $validated = $request->validate([
            'nom' => 'required|max:255',
            'biographie' => 'nullable',
            'date_naissance' => 'nullable|date',
        ]);

        $auteur->update($validated);

        return redirect()->route('auteurs.index')
            ->with('success', 'Auteur mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Auteur $auteur)
    {
        // Vérifier si l'auteur a des livres associés
        if ($auteur->livres()->count() > 0) {
            return redirect()->route('auteurs.index')
                ->with('error', 'Impossible de supprimer cet auteur car il a des livres associés.');
        }

        $auteur->delete();

        return redirect()->route('auteurs.index')
            ->with('success', 'Auteur supprimé avec succès.');
    }
}



