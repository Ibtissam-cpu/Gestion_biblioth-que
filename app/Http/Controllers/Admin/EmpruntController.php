<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Emprunt;
use App\Models\Livre;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class EmpruntController extends Controller
{
    public function index()
    {
        $emprunts = Emprunt::with(['user', 'livre'])
            ->orderBy('date_emprunt', 'desc')
            ->paginate(10);

        return view('admin.emprunts.index', compact('emprunts'));
    }

    public function create()
    {
        $users = User::where('is_admin', false)->get();
        $livres = Livre::whereDoesntHave('emprunts', function($query) {
            $query->whereNull('date_retour');
        })->get();

        return view('admin.emprunts.create', compact('users', 'livres'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'livre_id' => 'required|exists:livres,id',
            'date_retour_prevue' => 'required|date|after:today'
        ]);

        $emprunt = new Emprunt();
        $emprunt->user_id = $validated['user_id'];
        $emprunt->livre_id = $validated['livre_id'];
        $emprunt->date_emprunt = now();
        $emprunt->date_retour_prevue = $validated['date_retour_prevue'];
        $emprunt->save();

        return redirect()->route('admin.emprunts.index')
            ->with('success', 'Emprunt créé avec succès.');
    }

    public function retour(Emprunt $emprunt)
    {
        if (!$emprunt->date_retour) {
            $emprunt->date_retour = now();
            $emprunt->save();
            return redirect()->back()->with('success', 'Retour enregistré avec succès.');
        }
        return redirect()->back()->with('error', 'Cet emprunt a déjà été retourné.');
    }

    public function retards()
    {
        $emprunts = Emprunt::whereNull('date_retour')
            ->where('date_retour_prevue', '<', Carbon::now())
            ->with(['user', 'livre'])
            ->paginate(10);

        return view('admin.emprunts.retards', compact('emprunts'));
    }
} 