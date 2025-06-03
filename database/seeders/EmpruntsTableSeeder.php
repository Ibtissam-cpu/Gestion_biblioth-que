<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Emprunt;
use App\Models\Livre;
use App\Models\User;
use Carbon\Carbon;

class EmpruntsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Récupérer les utilisateurs non-admin
        $users = User::where('is_admin', false)->get();
        
        // Récupérer tous les livres
        $livres = Livre::all();
        
        // Créer des emprunts
        $now = Carbon::now();
        
        // Emprunts retournés
        for ($i = 0; $i < 10; $i++) {
            $user = $users->random();
            $livre = $livres->random();
            $dateEmprunt = Carbon::now()->subDays(rand(30, 60));
            $dateRetourPrevue = (clone $dateEmprunt)->addDays(14);
            $dateRetour = (clone $dateEmprunt)->addDays(rand(10, 14));
            
            Emprunt::create([
                'livre_id' => $livre->id,
                'user_id' => $user->id,
                'date_emprunt' => $dateEmprunt,
                'date_retour_prevue' => $dateRetourPrevue,
                'date_retour' => $dateRetour,
                'commentaire' => 'Emprunt retourné à temps',
                'etat_avant' => 'Bon',
                'etat_apres' => 'Bon',
                'prolonge' => false,
            ]);
        }
        
        // Emprunts en cours
        for ($i = 0; $i < 5; $i++) {
            $user = $users->random();
            $livre = $livres->where('quantite_disponible', '>', 0)->random();
            $dateEmprunt = Carbon::now()->subDays(rand(1, 10));
            $dateRetourPrevue = (clone $dateEmprunt)->addDays(14);
            
            Emprunt::create([
                'livre_id' => $livre->id,
                'user_id' => $user->id,
                'date_emprunt' => $dateEmprunt,
                'date_retour_prevue' => $dateRetourPrevue,
                'date_retour' => null,
                'commentaire' => 'Emprunt en cours',
                'etat_avant' => 'Bon',
                'etat_apres' => null,
                'prolonge' => false,
            ]);
            
            // Mettre à jour la quantité disponible du livre
            $livre->quantite_disponible = $livre->quantite_disponible - 1;
            $livre->disponible = $livre->quantite_disponible > 0;
            $livre->save();
        }
        
        // Emprunts en retard
        for ($i = 0; $i < 3; $i++) {
            $user = $users->random();
            $livre = $livres->where('quantite_disponible', '>', 0)->random();
            $dateEmprunt = Carbon::now()->subDays(rand(20, 30));
            $dateRetourPrevue = (clone $dateEmprunt)->addDays(14);
            
            Emprunt::create([
                'livre_id' => $livre->id,
                'user_id' => $user->id,
                'date_emprunt' => $dateEmprunt,
                'date_retour_prevue' => $dateRetourPrevue,
                'date_retour' => null,
                'commentaire' => 'Emprunt en retard',
                'etat_avant' => 'Bon',
                'etat_apres' => null,
                'prolonge' => false,
            ]);
            
            // Mettre à jour la quantité disponible du livre
            $livre->quantite_disponible = $livre->quantite_disponible - 1;
            $livre->disponible = $livre->quantite_disponible > 0;
            $livre->save();
        }
        
        // Emprunts prolongés
        for ($i = 0; $i < 2; $i++) {
            $user = $users->random();
            $livre = $livres->where('quantite_disponible', '>', 0)->random();
            $dateEmprunt = Carbon::now()->subDays(rand(10, 20));
            $dateRetourPrevue = (clone $dateEmprunt)->addDays(28); // 14 + 14 jours
            
            Emprunt::create([
                'livre_id' => $livre->id,
                'user_id' => $user->id,
                'date_emprunt' => $dateEmprunt,
                'date_retour_prevue' => $dateRetourPrevue,
                'date_retour' => null,
                'commentaire' => 'Emprunt prolongé',
                'etat_avant' => 'Bon',
                'etat_apres' => null,
                'prolonge' => true,
            ]);
            
            // Mettre à jour la quantité disponible du livre
            $livre->quantite_disponible = $livre->quantite_disponible - 1;
            $livre->disponible = $livre->quantite_disponible > 0;
            $livre->save();
        }
    }
}
