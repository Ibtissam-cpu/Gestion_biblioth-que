<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categorie;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'nom' => 'Roman',
                'description' => 'Œuvres de fiction en prose, généralement assez longues, qui présentent et font vivre dans un milieu des personnages donnés comme réels.',
                'couleur' => '#4299e1', // Bleu
            ],
            [
                'nom' => 'Science-Fiction',
                'description' => 'Genre narratif structuré par des hypothèses sur ce que pourrait être le futur et/ou les univers inconnus.',
                'couleur' => '#805ad5', // Violet
            ],
            [
                'nom' => 'Fantastique',
                'description' => 'Genre littéraire qui se caractérise par l\'intrusion du surnaturel dans le cadre réaliste d\'un récit.',
                'couleur' => '#667eea', // Indigo
            ],
            [
                'nom' => 'Policier',
                'description' => 'Genre littéraire présentant une énigme à résoudre, généralement un crime, un délit ou un enlèvement.',
                'couleur' => '#f56565', // Rouge
            ],
            [
                'nom' => 'Biographie',
                'description' => 'Récit détaillé de la vie d\'une personne réelle.',
                'couleur' => '#ed8936', // Orange
            ],
            [
                'nom' => 'Histoire',
                'description' => 'Livres traitant de faits et d\'événements du passé.',
                'couleur' => '#ecc94b', // Jaune
            ],
            [
                'nom' => 'Philosophie',
                'description' => 'Ouvrages traitant des questions fondamentales comme l\'existence, la connaissance, la vérité, la morale, la beauté, l\'esprit et le langage.',
                'couleur' => '#48bb78', // Vert
            ],
            [
                'nom' => 'Poésie',
                'description' => 'Art du langage visant à exprimer ou suggérer par le rythme, l\'harmonie et l\'image.',
                'couleur' => '#38b2ac', // Turquoise
            ],
            [
                'nom' => 'Théâtre',
                'description' => 'Textes destinés à être joués sur scène par des acteurs.',
                'couleur' => '#9f7aea', // Pourpre
            ],
            [
                'nom' => 'Jeunesse',
                'description' => 'Livres destinés aux enfants et aux adolescents.',
                'couleur' => '#4fd1c5', // Turquoise clair
            ],
        ];

        foreach ($categories as $categorie) {
            Categorie::create($categorie);
        }
    }
}
