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
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}

// php artisan db:seed --class=TypeUserSeeder
// php artisan db:seed --class=AdminSeeder
// php artisan db:seed --class=UnitSeeder
// php artisan db:seed --class=CategoryIngredientSeeder
// php artisan db:seed --class=IngredientsSeeder