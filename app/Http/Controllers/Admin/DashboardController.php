<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Livre;  // Changé de Book à Livre
use App\Models\Emprunt;
use App\Models\Activity;
use Carbon\Carbon;

class DashboardController extends Controller
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

        // Données pour le graphique des emprunts (corrigé)
        $loanChartData = [];
        $loanChartLabels = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $loanChartLabels[] = $date->format('d/m');
            $loanChartData[] = Emprunt::whereDate('date_emprunt', $date)->count();
        }

        // Activités récentes
        $recentActivities = Activity::with('user')
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard.index', compact(
            'totalUsers',
            'userGrowth',
            'activeLoans',
            'lateLoans',
            'loanGrowth',
            'totalBooks',
            'availableBooks',
            'topBooks',
            'loanChartData',
            'loanChartLabels',
            'recentActivities'
        ));
    }
}