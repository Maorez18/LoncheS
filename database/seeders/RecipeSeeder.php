<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RecipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('recipes')->insert([
            'name'=>'Wrap de Pavo y Aguacate',
            'time'=>'10',
            'description'=>'Wrap de Pavo y Aguacate',
            'preparation'=>'Extiende la tortilla y unta el hummus en toda la superficie.@Coloca la lechuga, el jamón de pavo y el aguacate en el centro de la tortilla.@Enrolla la tortilla firmemente, cortando por la mitad si es necesario.',
            'fk_type_recipe' => '2',
            'fk_creator_recipe' => '1',
        ]);
        DB::table('recipes')->insert([
            'name'=>'Bolitas de Energía de Avena y Mantequilla de Maní',
            'time'=>'40',
            'description'=>'Bolitas de Energía de Avena y Mantequilla de Maní',
            'preparation'=>'En un bol grande, mezcla la avena, la mantequilla de maní, la miel y el cacao en polvo hasta que estén bien combinados.@Incorpora las chispas de chocolate.@Forma bolitas del tamaño de una nuez con la mezcla.@Refrigera por al menos 30 minutos antes de servir.',
            'fk_type_recipe' => '3',
            'fk_creator_recipe' => '1',
        ]);
        DB::table('recipes')->insert([
            'name'=>'Muffins de Banano y Avena',
            'time'=>'35',
            'description'=>'Muffins de Banano y Avena',
            'preparation'=>'Precalienta el horno a 180°C y engrasa un molde para muffins.@Machaca los plátanos en un bol grande.@Añade los huevos, la avena, la leche de almendras, la miel y el polvo para hornear. Mezcla bien.@Incorpora las chispas de chocolate, si las estás usando.@Llena los moldes para muffins hasta 2\/3 de su capacidad.@Hornea durante 20-25 minutos o hasta que un palillo insertado en el centro salga limpio.',
            'fk_type_recipe' => '3',
            'fk_creator_recipe' => '1',
        ]);
        DB::table('recipes')->insert([
            'name'=>'Ensalada de Arroz con Huevo y Aguacate',
            'time'=>'60',
            'description'=>'Ensalada de Arroz con Huevo y Aguacate',
            'preparation'=>'Cocina el arroz según las instrucciones del paquete y deja enfriar.@Cocina los huevos de gallina en agua hirviendo durante 10 minutos. Luego, pela y pica los huevos.@En un bol grande, mezcla el arroz, los huevos, el aguacate y la lechuga.@Añade el hummus y la sal, mezclando bien todos los ingredientes.@Sirve en un recipiente para llevar.',
            'fk_type_recipe' => '4',
            'fk_creator_recipe' => '1',
        ]);
        DB::table('recipes')->insert([
            'name'=>'Smoothie de Plátano y Cacao',
            'time'=>'5',
            'description'=>'Smoothie de Plátano y Cacao',
            'preparation'=>'Coloca todos los ingredientes en una licuadora.@Mezcla hasta obtener una consistencia suave y homogénea.@Vierte en una botella reutilizable para llevar.',
            'fk_type_recipe' => '1',
            'fk_creator_recipe' => '1',
        ]);
    }
}
