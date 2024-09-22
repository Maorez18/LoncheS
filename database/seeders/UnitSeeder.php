<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('units')->insert([
            'unit'=>'Cucharadita',
            'acronym' => 'cdta',
        ]);
        DB::table('units')->insert([
            'unit'=>'Cucharada',
            'acronym' => 'cda',
        ]);
        DB::table('units')->insert([
            'unit'=>'Taza',
            'acronym' => 'tza',
        ]);
        DB::table('units')->insert([
            'unit'=>'Unidad',
            'acronym' => 'und',
        ]);
        DB::table('units')->insert([
            'unit'=>'Gramo',
            'acronym' => 'g',
        ]);
        DB::table('units')->insert([
            'unit'=>'Kilogramo',
            'acronym' => 'kg',
        ]);
        DB::table('units')->insert([
            'unit'=>'Miligramo',
            'acronym' => 'mg',
        ]);
        DB::table('units')->insert([
            'unit'=>'Litro',
            'acronym' => 'L',
        ]);
        DB::table('units')->insert([
            'unit'=>'Mililitro',
            'acronym' => 'mL',
        ]);
        DB::table('units')->insert([
            'unit'=>'Onza',
            'acronym' => 'oz',
        ]);
        DB::table('units')->insert([
            'unit'=>'Galon',
            'acronym' => 'gal',
        ]);
        DB::table('units')->insert([
            'unit'=>'Libra',
            'acronym' => 'lb',
        ]);
        DB::table('units')->insert([
            'unit'=>'Pizca',
            'acronym' => 'pizca',
        ]);
        DB::table('units')->insert([
            'unit'=>'Trozo',
            'acronym' => 'trozo',
        ]);
        DB::table('units')->insert([
            'unit'=>'Bote',
            'acronym' => 'bote',
        ]);
        DB::table('units')->insert([
            'unit'=>'Loncha',
            'acronym' => 'loncha',
        ]);
        DB::table('units')->insert([
            'unit'=>'Tajada',
            'acronym' => 'tajada',
        ]);
        DB::table('units')->insert([
            'unit'=>'Rebanada',
            'acronym' => 'rebanada',
        ]);
        DB::table('units')->insert([
            'unit'=>'Hoja',
            'acronym' => 'hoja',
        ]);
    }
}
