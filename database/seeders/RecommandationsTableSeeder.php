<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Recommandation;
use App\Models\Livre;
use App\Models\User;
use App\Models\Categorie;

class RecommandationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Récupérer les administrateurs
        $admins = User::where('is_admin', true)->get();
        
        // Récupérer tous les livres
        $livres = Livre::all();
        
        // Récupérer toutes les catégories
        $categories = Categorie::all();
        
        // Recommandations générales
        $recommandationsGenerales = [
            [
                'commentaire' => 'Un chef-d\'œuvre de la littérature française, à lire absolument !',
                'priorite' => 3,
            ],
            [
                'commentaire' => 'Un roman captivant qui vous tiendra en haleine du début à la fin.',
                'priorite' => 2,
            ],
            [
                'commentaire' => 'Une lecture enrichissante pour tous les amateurs de littérature.',
                'priorite' => 2,
            ],
            [
                'commentaire' => 'Un classique intemporel qui mérite d\'être redécouvert.',
                'priorite' => 3,
            ],
            [
                'commentaire' => 'Une œuvre majeure qui a marqué son époque.',
                'priorite' => 2,
            ],
        ];
        
        foreach ($recommandationsGenerales as $recommandation) {
            Recommandation::create([
                'livre_id' => $livres->random()->id,
                'user_id' => $admins->random()->id,
                'commentaire' => $recommandation['commentaire'],
                'type' => 'general',
                'priorite' => $recommandation['priorite'],
            ]);
        }
        
        // Recommandations par catégorie
        foreach ($categories as $categorie) {
            $livresCategorie = $livres->where('categorie_id', $categorie->id);
            
            if ($livresCategorie->count() > 0) {
                Recommandation::create([
                    'livre_id' => $livresCategorie->random()->id,
                    'user_id' => $admins->random()->id,
                    'commentaire' => "Excellent livre dans la catégorie {$categorie->nom}. Recommandé pour les amateurs du genre.",
                    'type' => 'categorie',
                    'categorie_id' => $categorie->id,
                    'priorite' => rand(1, 3),
                ]);
            }
        }
        
        // Recommandations par âge
        $recommandationsAge = [
            [
                'commentaire' => 'Parfait pour les jeunes lecteurs qui débutent.',
                'age_min' => 7,
                'age_max' => 10,
                'priorite' => 2,
            ],
            [
                'commentaire' => 'Recommandé pour les adolescents.',
                'age_min' => 12,
                'age_max' => 16,
                'priorite' => 2,
            ],
            [
                'commentaire' => 'Lecture adaptée aux jeunes adultes.',
                'age_min' => 16,
                'age_max' => 25,
                'priorite' => 1,
            ],
            [
                'commentaire' => 'Pour les lecteurs adultes à la recherche de profondeur.',
                'age_min' => 25,
                'age_max' => 99,
                'priorite' => 3,
            ],
        ];
        
        foreach ($recommandationsAge as $recommandation) {
            Recommandation::create([
                'livre_id' => $livres->random()->id,
                'user_id' => $admins->random()->id,
                'commentaire' => $recommandation['commentaire'],
                'type' => 'age',
                'age_min' => $recommandation['age_min'],
                'age_max' => $recommandation['age_max'],
                'priorite' => $recommandation['priorite'],
            ]);
        }
    }
}
