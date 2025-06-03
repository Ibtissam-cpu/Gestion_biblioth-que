<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Livre;
use App\Models\Emprunt;
use Carbon\Carbon;

class TableauBordController extends Controller
{
    public function index()
    {
        // Statistiques des utilisateurs
        $totalUsers = User::count();
        $lastMonthUsers = User::where('created_at', '>=', Carbon::now()->subMonth())->count();
        $userGrowth = $totalUsers > 0 && $lastMonthUsers > 0
            ? (($totalUsers - $lastMonthUsers) / $lastMonthUsers) * 100
            : 0;

        // Statistiques des emprunts
        $activeLoans = Emprunt::whereNull('date_retour')->count();
        
        $lateLoans = Emprunt::whereNull('date_retour')
                        ->where('date_retour_prevue', '<', Carbon::now())
                        ->count();

        // Calcul de la croissance des emprunts
        $lastWeekLoans = Emprunt::whereBetween('date_emprunt', [
            Carbon::now()->subWeek(),
            Carbon::now()
        ])->count();
        
        $loanGrowth = $lastWeekLoans > 0
            ? (($activeLoans - $lastWeekLoans) / $lastWeekLoans) * 100
            : 0;

        // Statistiques des livres
        $totalBooks = Livre::count();
        $availableBooks = Livre::whereDoesntHave('emprunts', function($query) {
            $query->whereNull('date_retour');
        })->count();

        // Top 5 des livres les plus empruntés
        $topBooks = Livre::withCount(['emprunts' => function($query) {
                $query->whereNull('date_retour');
            }])
            ->orderByDesc('emprunts_count')
            ->take(5)
            ->get();

        return view('admin.tableau-bord.index', compact(
            'totalUsers',
            'userGrowth',
            'activeLoans',
            'lateLoans',
            'loanGrowth',
            'totalBooks',
            'availableBooks',
            'topBooks'
        ));
    }
} 