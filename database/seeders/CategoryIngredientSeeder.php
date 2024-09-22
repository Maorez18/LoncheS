<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryIngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('category_ingredients')->insert([
            'category'=>'Cereales y derivados'
        ]);
        DB::table('category_ingredients')->insert([
            'category'=>'Verduras, hortalizas y derivados'
        ]);
        DB::table('category_ingredients')->insert([
            'category'=>'Frutas y derivados'
        ]);
        DB::table('category_ingredients')->insert([
            'category'=>'Grasas y aceites'
        ]);
        DB::table('category_ingredients')->insert([
            'category'=>'Pescados y mariscos'
        ]);
        DB::table('category_ingredients')->insert([
            'category'=>'Carnes y derivados'
        ]);
        DB::table('category_ingredients')->insert([
            'category'=>'Leche y derivados'
        ]);
        DB::table('category_ingredients')->insert([
            'category'=>'Bebidas (alcohólicas y no alcohólicas)'
        ]);
        DB::table('category_ingredients')->insert([
            'category'=>'Huevos y derivados'
        ]);
        DB::table('category_ingredients')->insert([
            'category'=>'Productos azucarados'
        ]);
        DB::table('category_ingredients')->insert([
            'category'=>'Misceláneos'
        ]);
        DB::table('category_ingredients')->insert([
            'category'=>'Alimentos para regimenes especiales'
        ]);
        DB::table('category_ingredients')->insert([
            'category'=>'Alimentos nativos'
        ]);
        DB::table('category_ingredients')->insert([
            'category'=>'Alimentos manufacturados'
        ]);
        DB::table('category_ingredients')->insert([
            'category'=>'Alimentos preparados'
        ]);
    }
}
