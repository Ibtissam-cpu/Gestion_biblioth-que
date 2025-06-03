<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Livre;
use App\Models\Emprunt;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class RapportController extends Controller
{
    public function index()
    {
        // Statistiques des livres
        $totalLivres = Livre::count();
        $livresDisponibles = Livre::whereDoesntHave('emprunts', function($query) {
            $query->whereNull('date_retour');
        })->count();

        // Statistiques des emprunts
        $empruntsEnCours = Emprunt::whereNull('date_retour')->count();
        $empruntsEnRetard = Emprunt::whereNull('date_retour')
            ->where('date_retour_prevue', '<', Carbon::now())
            ->count();

        // Statistiques des membres
        $totalMembres = User::where('is_admin', false)->count();

        // Livres les plus empruntés
        $livresPopulaires = Livre::withCount(['emprunts' => function($query) {
            $query->whereNull('date_retour');
        }])
        ->orderByDesc('emprunts_count')
        ->take(5)
        ->get();

        // Statistiques mensuelles
        $empruntsMensuels = Emprunt::selectRaw('MONTH(date_emprunt) as mois, COUNT(*) as total')
            ->whereYear('date_emprunt', Carbon::now()->year)
            ->groupBy('mois')
            ->orderBy('mois')
            ->get();

        // Calcul du taux de retard
        $totalEmprunts = Emprunt::whereNotNull('date_retour')->count();
        $empruntsRetournesEnRetard = Emprunt::whereNotNull('date_retour')
            ->whereRaw('date_retour > date_retour_prevue')
            ->count();
        
        $tauxRetardPourcentage = $totalEmprunts > 0 
            ? round(($empruntsRetournesEnRetard / $totalEmprunts) * 100, 1)
            : 0;

        return view('admin.rapports.index', compact(
            'totalLivres',
            'livresDisponibles',
            'empruntsEnCours',
            'empruntsEnRetard',
            'totalMembres',
            'livresPopulaires',
            'empruntsMensuels',
            'tauxRetardPourcentage'
        ));
    }
} 