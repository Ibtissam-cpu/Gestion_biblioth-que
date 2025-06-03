<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Livre;
use App\Models\Auteur;
use App\Models\Categorie;

class LivresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Récupérer les IDs des auteurs et catégories
        $auteurs = Auteur::all()->pluck('id', 'nom');
        $categories = Categorie::all()->pluck('id', 'nom');

        $livres = [
            [
                'titre' => 'Les Misérables',
                'auteur_nom' => 'Hugo',
                'categorie_nom' => 'Roman',
                'isbn' => '9782253096344',
                'description' => 'Les Misérables est un roman de Victor Hugo paru en 1862. Il a donné lieu à de nombreuses adaptations au cinéma, à la télévision, en comédie musicale, en bande dessinée, etc.',
                'editeur' => 'Le Livre de Poche',
                'annee_publication' => 1862,
                'nombre_pages' => 1500,
                'langue' => 'Français',
                'quantite_totale' => 3,
                'quantite_disponible' => 2,
            ],
            [
                'titre' => 'L\'Étranger',
                'auteur_nom' => 'Camus',
                'categorie_nom' => 'Roman',
                'isbn' => '9782070360024',
                'description' => 'L\'Étranger est un roman d\'Albert Camus, paru en 1942. Il prend place dans la tétralogie que Camus nommera « cycle de l\'absurde » qui décrit les fondements de la philosophie camusienne : l\'absurde.',
                'editeur' => 'Gallimard',
                'annee_publication' => 1942,
                'nombre_pages' => 184,
                'langue' => 'Français',
                'quantite_totale' => 5,
                'quantite_disponible' => 4,
            ],
            [
                'titre' => 'Harry Potter à l\'école des sorciers',
                'auteur_nom' => 'Rowling',
                'categorie_nom' => 'Fantastique',
                'isbn' => '9782070643028',
                'description' => 'Harry Potter à l\'école des sorciers est le premier roman de la série littéraire centrée sur le personnage de Harry Potter, créé par J. K. Rowling.',
                'editeur' => 'Gallimard Jeunesse',
                'annee_publication' => 1997,
                'nombre_pages' => 308,
                'langue' => 'Français',
                'quantite_totale' => 4,
                'quantite_disponible' => 2,
            ],
            [
                'titre' => 'Le Seigneur des anneaux',
                'auteur_nom' => 'Tolkien',
                'categorie_nom' => 'Fantastique',
                'isbn' => '9782266154116',
                'description' => 'Le Seigneur des anneaux est un roman de fantasy épique en trois volumes de J. R. R. Tolkien paru en 1954 et 1955.',
                'editeur' => 'Pocket',
                'annee_publication' => 1954,
                'nombre_pages' => 1200,
                'langue' => 'Français',
                'quantite_totale' => 2,
                'quantite_disponible' => 1,
            ],
            [
                'titre' => 'Orgueil et Préjugés',
                'auteur_nom' => 'Austen',
                'categorie_nom' => 'Roman',
                'isbn' => '9782253088127',
                'description' => 'Orgueil et Préjugés est un roman de la femme de lettres anglaise Jane Austen paru en 1813.',
                'editeur' => 'Le Livre de Poche',
                'annee_publication' => 1813,
                'nombre_pages' => 392,
                'langue' => 'Français',
                'quantite_totale' => 3,
                'quantite_disponible' => 3,
            ],
            [
                'titre' => 'Germinal',
                'auteur_nom' => 'Zola',
                'categorie_nom' => 'Roman',
                'isbn' => '9782253004226',
                'description' => 'Germinal est un roman d\'Émile Zola publié en 1885. Il s\'agit du treizième roman de la série des Rougon-Macquart.',
                'editeur' => 'Le Livre de Poche',
                'annee_publication' => 1885,
                'nombre_pages' => 640,
                'langue' => 'Français',
                'quantite_totale' => 4,
                'quantite_disponible' => 4,
            ],
            [
                'titre' => 'Madame Bovary',
                'auteur_nom' => 'Flaubert',
                'categorie_nom' => 'Roman',
                'isbn' => '9782253004868',
                'description' => 'Madame Bovary est un roman de Gustave Flaubert paru en 1857.',
                'editeur' => 'Le Livre de Poche',
                'annee_publication' => 1857,
                'nombre_pages' => 528,
                'langue' => 'Français',
                'quantite_totale' => 3,
                'quantite_disponible' => 3,
            ],
            [
                'titre' => 'À la recherche du temps perdu',
                'auteur_nom' => 'Proust',
                'categorie_nom' => 'Roman',
                'isbn' => '9782070754922',
                'description' => 'À la recherche du temps perdu est un roman de Marcel Proust, écrit entre 1908 et 1922.',
                'editeur' => 'Gallimard',
                'annee_publication' => 1913,
                'nombre_pages' => 2400,
                'langue' => 'Français',
                'quantite_totale' => 2,
                'quantite_disponible' => 2,
            ],
            [
                'titre' => 'Crime et Châtiment',
                'auteur_nom' => 'Dostoïevski',
                'categorie_nom' => 'Roman',
                'isbn' => '9782253082545',
                'description' => 'Crime et Châtiment est un roman de l\'écrivain russe Fiodor Dostoïevski publié en 1866.',
                'editeur' => 'Le Livre de Poche',
                'annee_publication' => 1866,
                'nombre_pages' => 576,
                'langue' => 'Français',
                'quantite_totale' => 3,
                'quantite_disponible' => 3,
            ],
            [
                'titre' => '1984',
                'auteur_nom' => 'Orwell',
                'categorie_nom' => 'Science-Fiction',
                'isbn' => '9782070368228',
                'description' => '1984 est un roman de George Orwell publié en 1949. Il décrit une société totalitaire et dystopique.',
                'editeur' => 'Gallimard',
                'annee_publication' => 1949,
                'nombre_pages' => 438,
                'langue' => 'Français',
                'quantite_totale' => 5,
                'quantite_disponible' => 4,
            ],
            [
                'titre' => 'La Ferme des animaux',
                'auteur_nom' => 'Orwell',
                'categorie_nom' => 'Roman',
                'isbn' => '9782070375165',
                'description' => 'La Ferme des animaux est un roman de George Orwell publié en 1945, décrivant une ferme dans laquelle les animaux se révoltent, prennent le pouvoir et chassent les hommes.',
                'editeur' => 'Gallimard',
                'annee_publication' => 1945,
                'nombre_pages' => 152,
                'langue' => 'Français',
                'quantite_totale' => 4,
                'quantite_disponible' => 4,
            ],
            [
                'titre' => 'Notre-Dame de Paris',
                'auteur_nom' => 'Hugo',
                'categorie_nom' => 'Roman',
                'isbn' => '9782253096344',
                'description' => 'Notre-Dame de Paris est un roman historique de Victor Hugo publié en 1831.',
                'editeur' => 'Le Livre de Poche',
                'annee_publication' => 1831,
                'nombre_pages' => 656,
                'langue' => 'Français',
                'quantite_totale' => 3,
                'quantite_disponible' => 3,
            ],
            [
                'titre' => 'Le Hobbit',
                'auteur_nom' => 'Tolkien',
                'categorie_nom' => 'Fantastique',
                'isbn' => '9782267023305',
                'description' => 'Le Hobbit est un roman de fantasy de l\'écrivain britannique J. R. R. Tolkien. Il narre les aventures du hobbit Bilbo, entraîné malgré lui par le magicien Gandalf et une compagnie de treize nains.',
                'editeur' => 'Christian Bourgois',
                'annee_publication' => 1937,
                'nombre_pages' => 320,
                'langue' => 'Français',
                'quantite_totale' => 3,
                'quantite_disponible' => 2,
            ],
            [
                'titre' => 'La Peste',
                'auteur_nom' => 'Camus',
                'categorie_nom' => 'Roman',
                'isbn' => '9782070360420',
                'description' => 'La Peste est un roman d\'Albert Camus publié en 1947 et ayant reçu le prix des Critiques la même année.',
                'editeur' => 'Gallimard',
                'annee_publication' => 1947,
                'nombre_pages' => 336,
                'langue' => 'Français',
                'quantite_totale' => 4,
                'quantite_disponible' => 3,
            ],
            [
                'titre' => 'Harry Potter et la Chambre des secrets',
                'auteur_nom' => 'Rowling',
                'categorie_nom' => 'Fantastique',
                'isbn' => '9782070643042',
                'description' => 'Harry Potter et la Chambre des secrets est le deuxième roman de la série littéraire Harry Potter écrite par J. K. Rowling.',
                'editeur' => 'Gallimard Jeunesse',
                'annee_publication' => 1998,
                'nombre_pages' => 368,
                'langue' => 'Français',
                'quantite_totale' => 3,
                'quantite_disponible' => 2,
            ],
        ];

        foreach ($livres as $livre) {
            $auteurId = $auteurs[$livre['auteur_nom']];
            $categorieId = $categories[$livre['categorie_nom']];
            
            unset($livre['auteur_nom']);
            unset($livre['categorie_nom']);
            
            Livre::create([
                ...$livre,
                'auteur_id' => $auteurId,
                'categorie_id' => $categorieId,
                'disponible' => $livre['quantite_disponible'] > 0,
            ]);
        }
    }
}
