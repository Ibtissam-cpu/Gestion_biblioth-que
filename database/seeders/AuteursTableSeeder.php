<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Auteur;

class AuteursTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $auteurs = [
            [
                'nom' => 'Hugo',
                'prenom' => 'Victor',
                'biographie' => 'Victor Hugo est un poète, dramaturge, écrivain, romancier et dessinateur romantique français, né le 26 février 1802 à Besançon et mort le 22 mai 1885 à Paris.',
                'date_naissance' => '1802-02-26',
                'date_deces' => '1885-05-22',
                'nationalite' => 'Française',
            ],
            [
                'nom' => 'Camus',
                'prenom' => 'Albert',
                'biographie' => 'Albert Camus est un écrivain, philosophe, romancier, dramaturge, essayiste et nouvelliste français, né le 7 novembre 1913 à Mondovi et mort le 4 janvier 1960 à Villeblevin.',
                'date_naissance' => '1913-11-07',
                'date_deces' => '1960-01-04',
                'nationalite' => 'Française',
            ],
            [
                'nom' => 'Rowling',
                'prenom' => 'J.K.',
                'biographie' => 'Joanne Rowling, connue sous le nom de J. K. Rowling, est une romancière et scénariste britannique née le 31 juillet 1965 dans l\'agglomération de Yate.',
                'date_naissance' => '1965-07-31',
                'date_deces' => null,
                'nationalite' => 'Britannique',
            ],
            [
                'nom' => 'Tolkien',
                'prenom' => 'J.R.R.',
                'biographie' => 'John Ronald Reuel Tolkien, plus connu sous la forme J. R. R. Tolkien, est un écrivain, poète, philologue, essayiste et professeur d\'université anglais, né le 3 janvier 1892 à Bloemfontein et mort le 2 septembre 1973 à Bournemouth.',
                'date_naissance' => '1892-01-03',
                'date_deces' => '1973-09-02',
                'nationalite' => 'Britannique',
            ],
            [
                'nom' => 'Austen',
                'prenom' => 'Jane',
                'biographie' => 'Jane Austen est une femme de lettres anglaise, née le 16 décembre 1775 à Steventon, dans le Hampshire en Angleterre, et morte le 18 juillet 1817 à Winchester, dans le même comté.',
                'date_naissance' => '1775-12-16',
                'date_deces' => '1817-07-18',
                'nationalite' => 'Britannique',
            ],
            [
                'nom' => 'Zola',
                'prenom' => 'Émile',
                'biographie' => 'Émile Zola est un écrivain et journaliste français, né le 2 avril 1840 à Paris, où il est mort le 29 septembre 1902.',
                'date_naissance' => '1840-04-02',
                'date_deces' => '1902-09-29',
                'nationalite' => 'Française',
            ],
            [
                'nom' => 'Flaubert',
                'prenom' => 'Gustave',
                'biographie' => 'Gustave Flaubert est un écrivain français né à Rouen le 12 décembre 1821 et mort à Croisset, lieu-dit de la commune de Canteleu, le 8 mai 1880.',
                'date_naissance' => '1821-12-12',
                'date_deces' => '1880-05-08',
                'nationalite' => 'Française',
            ],
            [
                'nom' => 'Proust',
                'prenom' => 'Marcel',
                'biographie' => 'Marcel Proust est un écrivain français, né à Paris le 10 juillet 1871 et mort à Paris le 18 novembre 1922.',
                'date_naissance' => '1871-07-10',
                'date_deces' => '1922-11-18',
                'nationalite' => 'Française',
            ],
            [
                'nom' => 'Dostoïevski',
                'prenom' => 'Fiodor',
                'biographie' => 'Fiodor Mikhaïlovitch Dostoïevski est un écrivain russe, né à Moscou le 11 novembre 1821 et mort à Saint-Pétersbourg le 9 février 1881.',
                'date_naissance' => '1821-11-11',
                'date_deces' => '1881-02-09',
                'nationalite' => 'Russe',
            ],
            [
                'nom' => 'Orwell',
                'prenom' => 'George',
                'biographie' => 'George Orwell, de son vrai nom Eric Arthur Blair, est un écrivain, essayiste et journaliste britannique né le 25 juin 1903 à Motihari, en Inde, et mort le 21 janvier 1950 à Londres.',
                'date_naissance' => '1903-06-25',
                'date_deces' => '1950-01-21',
                'nationalite' => 'Britannique',
            ],
        ];

        foreach ($auteurs as $auteur) {
            Auteur::create($auteur);
        }
    }
}
