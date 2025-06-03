<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Livre;
use App\Models\Auteur;
use App\Models\Categorie;
use App\Models\Emprunt;
use App\Models\Recommandation;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Affiche le tableau de bord
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Récupérer les statistiques pour le tableau de bord
        $totalLivres = Livre::count();
        $totalAuteurs = Auteur::count();
        $totalCategories = Categorie::count();
        
        // Récupérer les emprunts actifs de l'utilisateur connecté
        $mesEmpruntsActifs = Emprunt::where('user_id', Auth::id())
            ->whereNull('date_retour')
            ->count();
        
        // Récupérer les emprunts actifs avec détails
        $empruntsActifs = Emprunt::with(['livre', 'livre.auteur'])
            ->where('user_id', Auth::id())
            ->whereNull('date_retour')
            ->orderBy('date_retour_prevue', 'asc')
            ->take(5)
            ->get();
        
        // Récupérer les activités récentes
        $activitesRecentes = $this->getActivitesRecentes();
        
        // Récupérer les livres recommandés
        $livresRecommandes = $this->getLivresRecommandes();
        
        return view('membre.dashboard', compact(
            'totalLivres', 
            'totalAuteurs', 
            'totalCategories', 
            'mesEmpruntsActifs',
            'empruntsActifs',
            'activitesRecentes',
            'livresRecommandes'
        ));
    }
    
    /**
     * Récupère les activités récentes
     * 
     * @return \Illuminate\Support\Collection
     */
    private function getActivitesRecentes()
    {
        // Cette méthode est un exemple, vous devrez l'adapter à votre modèle de données
        // Ici, nous créons des données factices pour l'exemple
        
        return collect([
            (object) [
                'id' => 1,
                'type' => 'emprunt',
                'titre' => 'Nouvel emprunt',
                'description' => 'Le Petit Prince - Antoine de Saint-Exupéry',
                'date_relative' => 'Il y a 2 heures'
            ],
            (object) [
                'id' => 2,
                'type' => 'retour',
                'titre' => 'Livre retourné',
                'description' => '1984 - George Orwell',
                'date_relative' => 'Hier'
            ],
            (object) [
                'id' => 3,
                'type' => 'nouveau_livre',
                'titre' => 'Nouveau livre ajouté',
                'description' => 'Harry Potter et la Chambre des Secrets - J.K. Rowling',
                'date_relative' => 'Il y a 3 jours'
            ]
        ]);
        
        // Dans une implémentation réelle, vous pourriez faire quelque chose comme:
        /*
        return Activity::with(['subject'])
            ->where(function($query) {
                $query->where('user_id', Auth::id())
                      ->orWhere('is_public', true);
            })
            ->latest()
            ->take(5)
            ->get()
            ->map(function($activity) {
                return (object) [
                    'id' => $activity->id,
                    'type' => $activity->type,
                    'titre' => $activity->title,
                    'description' => $activity->description,
                    'date_relative' => $activity->created_at->diffForHumans()
                ];
            });
        */
    }
    
    /**
     * Récupère les livres recommandés pour l'utilisateur
     * 
     * @return \Illuminate\Support\Collection
     */
    private function getLivresRecommandes()
    {
        // Cette méthode est un exemple, vous devrez l'adapter à votre modèle de données
        // Ici, nous créons des données factices pour l'exemple
        
        return collect([
            (object) [
                'id' => 1,
                'titre' => 'Le Petit Prince',
                'auteur' => (object) ['nom' => 'Antoine de Saint-Exupéry'],
                'categorie' => (object) ['nom' => 'Fiction'],
                'image_couverture' => 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                'disponible' => true
            ],
            (object) [
                'id' => 2,
                'titre' => '1984',
                'auteur' => (object) ['nom' => 'George Orwell'],
                'categorie' => (object) ['nom' => 'Science-Fiction'],
                'image_couverture' => 'https://images.unsplash.com/photo-1541963463532-d68292c34b19?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                'disponible' => false
            ],
            (object) [
                'id' => 3,
                'titre' => 'L\'Étranger',
                'auteur' => (object) ['nom' => 'Albert Camus'],
                'categorie' => (object) ['nom' => 'Philosophie'],
                'image_couverture' => 'https://images.unsplash.com/photo-1495640452828-3df6795cf69b?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                'disponible' => true
            ],
            (object) [
                'id' => 4,
                'titre' => 'Harry Potter et la Pierre Philosophale',
                'auteur' => (object) ['nom' => 'J.K. Rowling'],
                'categorie' => (object) ['nom' => 'Fantasy'],
                'image_couverture' => 'https://images.unsplash.com/photo-1543002588-bfa74002ed7e?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                'disponible' => true
            ]
        ]);
        
        // Dans une implémentation réelle, vous pourriez faire quelque chose comme:
        /*
        // Récupérer les catégories des livres que l'utilisateur a empruntés
        $categoriesPreferees = Emprunt::where('user_id', Auth::id())
            ->with('livre.categorie')
            ->get()
            ->pluck('livre.categorie.id')
            ->unique();
            
        // Récupérer les livres des mêmes catégories qui n'ont pas été empruntés par l'utilisateur
        return Livre::with(['auteur', 'categorie'])
            ->whereIn('categorie_id', $categoriesPreferees)
            ->whereDoesntHave('emprunts', function($query) {
                $query->where('user_id', Auth::id());
            })
            ->inRandomOrder()
            ->take(4)
            ->get();
        */
    }

    /**
     * Affiche le tableau de bord du membre
     */
    public function membre()
    {
        $user = Auth::user();

        // Statistiques
        $empruntsEnCours = Emprunt::where('user_id', $user->id)
            ->whereNull('date_retour')
            ->count();

        $totalEmprunts = Emprunt::where('user_id', $user->id)->count();

        $recommandationsCount = Recommandation::where('user_id', $user->id)->count();

        // Compte des notifications non lues
        $notificationsCount = Notification::where('notifiable_type', 'App\Models\User')
            ->where('notifiable_id', $user->id)
            ->whereNull('read_at')
            ->count();

        // Emprunts en cours
        $emprunts = Emprunt::with(['livre', 'livre.auteur'])
            ->where('user_id', $user->id)
            ->whereNull('date_retour')
            ->orderBy('date_retour_prevue')
            ->get();

        // Recommandations
        $recommandations = Recommandation::with(['livre', 'livre.auteur'])
            ->where('user_id', $user->id)
            ->orderBy('priorite', 'desc')
            ->limit(4)
            ->get();

        // Historique des emprunts
        $historique = Emprunt::with(['livre', 'livre.auteur'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($emprunt) {
                $emprunt->est_en_retard = !$emprunt->date_retour && $emprunt->date_retour_prevue < now();
                return $emprunt;
            });

        return view('membre.dashboard', compact(
            'empruntsEnCours',
            'totalEmprunts',
            'recommandationsCount',
            'notificationsCount',
            'emprunts',
            'recommandations',
            'historique'
        ));
    }

    public function admin()
    {
        // ... code existant pour le dashboard admin ...
    }
}
