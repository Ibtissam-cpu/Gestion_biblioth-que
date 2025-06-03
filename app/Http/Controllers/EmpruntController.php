<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Emprunt;
use App\Models\Livre;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class EmpruntController extends Controller
{
    /**
     * Afficher la liste des emprunts
     */
    public function index()
    {
        $emprunts = Emprunt::with(['livre', 'user'])->orderBy('date_emprunt', 'desc')->paginate(10);
        return view('emprunts.index', compact('emprunts'));
    }

    /**
     * Afficher le formulaire de création d'un nouvel emprunt
     */
    public function create()
    {
        $livres = Livre::where('disponible', true)->get();
        $users = User::all();
        return view('emprunts.create', compact('livres', 'users'));
    }

    /**
     * Enregistrer un nouvel emprunt
     */
    public function store(Request $request)
    {
        $request->validate([
            'livre_id' => 'required|exists:livres,id',
            'user_id' => 'required|exists:users,id',
            'date_retour_prevue' => 'required|date|after:today',
        ]);

        // Vérifier si le livre est disponible
        $livre = Livre::findOrFail($request->livre_id);
        if (!$livre->disponible) {
            return redirect()->back()->with('error', 'Ce livre n\'est pas disponible pour l\'emprunt.');
        }

        // Créer l'emprunt
        $emprunt = new Emprunt();
        $emprunt->livre_id = $request->livre_id;
        $emprunt->user_id = $request->user_id;
        $emprunt->date_emprunt = Carbon::now();
        $emprunt->date_retour_prevue = $request->date_retour_prevue;
        $emprunt->statut = 'en_cours';
        $emprunt->save();

        // Mettre à jour le statut du livre
        $livre->disponible = false;
        $livre->save();

        return redirect()->route('emprunts.index')->with('success', 'Emprunt enregistré avec succès.');
    }

    /**
     * Afficher les détails d'un emprunt
     */
    public function show($id)
    {
        $emprunt = Emprunt::with(['livre', 'user'])->findOrFail($id);
        return view('emprunts.show', compact('emprunt'));
    }

    /**
     * Afficher le formulaire d'édition d'un emprunt
     */
    public function edit($id)
    {
        $emprunt = Emprunt::findOrFail($id);
        $livres = Livre::all();
        $users = User::all();
        return view('emprunts.edit', compact('emprunt', 'livres', 'users'));
    }

    /**
     * Mettre à jour un emprunt
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'livre_id' => 'required|exists:livres,id',
            'user_id' => 'required|exists:users,id',
            'date_retour_prevue' => 'required|date',
            'statut' => 'required|in:en_cours,retourne,en_retard',
        ]);

        $emprunt = Emprunt::findOrFail($id);
        $ancienLivreId = $emprunt->livre_id;

        // Mettre à jour l'emprunt
        $emprunt->livre_id = $request->livre_id;
        $emprunt->user_id = $request->user_id;
        $emprunt->date_retour_prevue = $request->date_retour_prevue;
        $emprunt->statut = $request->statut;
        
        // Si le livre est retourné, enregistrer la date de retour
        if ($request->statut == 'retourne' && !$emprunt->date_retour) {
            $emprunt->date_retour = Carbon::now();
        }
        
        $emprunt->save();

        // Gérer la disponibilité des livres
        if ($ancienLivreId != $request->livre_id) {
            // Rendre l'ancien livre disponible
            $ancienLivre = Livre::findOrFail($ancienLivreId);
            $ancienLivre->disponible = true;
            $ancienLivre->save();
            
            // Rendre le nouveau livre indisponible
            $nouveauLivre = Livre::findOrFail($request->livre_id);
            $nouveauLivre->disponible = false;
            $nouveauLivre->save();
        } else if ($request->statut == 'retourne') {
            // Si le statut est "retourné", rendre le livre disponible
            $livre = Livre::findOrFail($request->livre_id);
            $livre->disponible = true;
            $livre->save();
        }

        return redirect()->route('emprunts.index')->with('success', 'Emprunt mis à jour avec succès.');
    }

    /**
     * Supprimer un emprunt
     */
    public function destroy($id)
    {
        $emprunt = Emprunt::findOrFail($id);
        
        // Si l'emprunt est en cours, rendre le livre disponible
        if ($emprunt->statut == 'en_cours') {
            $livre = Livre::findOrFail($emprunt->livre_id);
            $livre->disponible = true;
            $livre->save();
        }
        
        $emprunt->delete();
        return redirect()->route('emprunts.index')->with('success', 'Emprunt supprimé avec succès.');
    }

    /**
     * Retourner un livre emprunté
     */
    public function retourner($id)
    {
        $emprunt = Emprunt::findOrFail($id);
        
        // Vérifier si l'emprunt est déjà retourné
        if ($emprunt->statut == 'retourne') {
            return redirect()->back()->with('error', 'Ce livre a déjà été retourné.');
        }
        
        // Mettre à jour l'emprunt
        $emprunt->statut = 'retourne';
        $emprunt->date_retour = Carbon::now();
        $emprunt->save();
        
        // Rendre le livre disponible
        $livre = Livre::findOrFail($emprunt->livre_id);
        $livre->disponible = true;
        $livre->save();
        
        return redirect()->route('emprunts.index')->with('success', 'Livre retourné avec succès.');
    }

    /**
     * Afficher les emprunts de l'utilisateur connecté
     */
    public function mesEmprunts()
    {
        $emprunts = Emprunt::with('livre')
                    ->where('user_id', Auth::id())
                    ->orderBy('date_emprunt', 'desc')
                    ->paginate(10);
                    
        return view('emprunts.mes-emprunts', compact('emprunts'));
    }

    /**
     * Vérifier les emprunts en retard
     */
    public function empruntEnRetard()
    {
        $dateAujourdhui = Carbon::now()->format('Y-m-d');
        $empruntsEnRetard = Emprunt::with(['livre', 'user'])
                            ->where('statut', 'en_cours')
                            ->where('date_retour_prevue', '<', $dateAujourdhui)
                            ->paginate(10);
                            
        return view('emprunts.retards', compact('empruntsEnRetard'));
    }

    /**
     * Prolonger un emprunt
     */
    public function prolonger(Request $request, $id)
    {
        $request->validate([
            'nouvelle_date' => 'required|date|after:today',
        ]);

        $emprunt = Emprunt::findOrFail($id);
        
        // Vérifier si l'emprunt est en cours
        if ($emprunt->statut != 'en_cours') {
            return redirect()->back()->with('error', 'Seuls les emprunts en cours peuvent être prolongés.');
        }
        
        // Vérifier si l'utilisateur est autorisé à prolonger l'emprunt
        if ($emprunt->user_id != Auth::id() && !Auth::user()->hasRole('bibliothecaire')) {
            return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à prolonger cet emprunt.');
        }
        
        $emprunt->date_retour_prevue = $request->nouvelle_date;
        $emprunt->save();
        
        return redirect()->back()->with('success', 'Emprunt prolongé avec succès.');
    }
}