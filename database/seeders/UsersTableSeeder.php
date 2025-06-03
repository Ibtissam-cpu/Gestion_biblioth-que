<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer un administrateur
        User::create([
            'name' => 'Admin',
            'email' => 'admin@bibliotheque.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
        ]);

        // Créer un bibliothécaire
        User::create([
            'name' => 'Bibliothécaire',
            'email' => 'biblio@bibliotheque.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
        ]);

        // Créer des utilisateurs normaux
        User::create([
            'name' => 'Jean Dupont',
            'email' => 'jean@exemple.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
        ]);

        User::create([
            'name' => 'Marie Martin',
            'email' => 'marie@exemple.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
        ]);

        User::create([
            'name' => 'Pierre Durand',
            'email' => 'pierre@exemple.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
        ]);
    }
}
