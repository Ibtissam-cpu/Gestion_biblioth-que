<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UsersTableSeeder::class,
            AuteursTableSeeder::class,
            CategoriesTableSeeder::class,
            LivresTableSeeder::class,
            EmpruntsTableSeeder::class,
            RecommandationsTableSeeder::class,
        ]);
    }
}
