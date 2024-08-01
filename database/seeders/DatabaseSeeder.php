<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Kjør de ulike seeders
        $this->call([
            UserSeeder::class,
            TeamsTableSeeder::class,
            ProjectsTableSeeder::class,
        ]);
    }
}
