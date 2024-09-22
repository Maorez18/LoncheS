<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeRecipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('type_recipes')->insert([
            'type_recipe'=>'Bebida',
        ]);
        DB::table('type_recipes')->insert([
            'type_recipe'=>'Plato principal',
        ]);
        DB::table('type_recipes')->insert([
            'type_recipe'=>'Bocadillo',
        ]);
        DB::table('type_recipes')->insert([
            'type_recipe'=>'Ensalada',
        ]);
        DB::table('type_recipes')->insert([
            'type_recipe'=>'Sopa o guisado',
        ]);
        DB::table('type_recipes')->insert([
            'type_recipe'=>'Postre',
        ]);
    }
}
