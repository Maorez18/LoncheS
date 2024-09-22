<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IngredientsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('ingredients')->insert([
            'ingredient'=>'Avena en hojuelas',
            'calories'=>'411',
            'protein'=>'16.9',
            'carbohydrates'=>'64.1',
            'fiber'=>'9.8',
            'sodium'=>'3',
            'saturated_fat'=>'1.3',
            'fk_category'=>'1',
        ]);
        DB::table('ingredients')->insert([
            'ingredient'=>'Huevo de gallina',
            'calories'=>'149',
            'protein'=>'12.6',
            'carbohydrates'=>'0.3',
            'fiber'=>'0',
            'sodium'=>'139',
            'saturated_fat'=>'3.1',
            'fk_category'=>'9',
        ]);
        DB::table('ingredients')->insert([
            'ingredient'=>'Banano',
            'calories'=>'101',
            'protein'=>'1.5',
            'carbohydrates'=>'22.3',
            'fiber'=>'2.6',
            'sodium'=>'3',
            'saturated_fat'=>'0',
            'fk_category'=>'3',
        ]);
        DB::table('ingredients')->insert([
            'ingredient'=>'Cacao (polvo)',
            'calories'=>'468',
            'protein'=>'14.4',
            'carbohydrates'=>'51.9',
            'fiber'=>'0',
            'sodium'=>'4',
            'saturated_fat'=>'0',
            'fk_category'=>'11',
        ]);
        DB::table('ingredients')->insert([
            'ingredient'=>'Polvo para hornear',
            'calories'=>'0',
            'protein'=>'0',
            'carbohydrates'=>'0',
            'fiber'=>'0',
            'sodium'=>'65',
            'saturated_fat'=>'0',
            'fk_category'=>'11',
        ]);
        DB::table('ingredients')->insert([
            'ingredient'=>'Leche de almendras',
            'calories'=>'30',
            'protein'=>'1',
            'carbohydrates'=>'1',
            'fiber'=>'1',
            'sodium'=>'135',
            'saturated_fat'=>'0',
            'fk_category'=>'11',
        ]);
        DB::table('ingredients')->insert([
            'ingredient'=>'Tortilla integral',
            'calories'=>'100',
            'protein'=>'3.11',
            'carbohydrates'=>'26.6',
            'fiber'=>'2.3',
            'sodium'=>'164',
            'saturated_fat'=>'2',
            'fk_category'=>'1',
        ]);
        DB::table('ingredients')->insert([
            'ingredient'=>'Jamon de pavo',
            'calories'=>'36',
            'protein'=>'4.96',
            'carbohydrates'=>'0.58',
            'fiber'=>'0.1',
            'sodium'=>'316',
            'saturated_fat'=>'1.37',
            'fk_category'=>'6',
        ]);
        DB::table('ingredients')->insert([
            'ingredient'=>'Lechuga',
            'calories'=>'18',
            'protein'=>'0.8',
            'carbohydrates'=>'2.6',
            'fiber'=>'1.7',
            'sodium'=>'6',
            'saturated_fat'=>'0',
            'fk_category'=>'2',
        ]);
        DB::table('ingredients')->insert([
            'ingredient'=>'Aguacate Hass',
            'calories'=>'221',
            'protein'=>'1.3',
            'carbohydrates'=>'13.5',
            'fiber'=>'6.8',
            'sodium'=>'0',
            'saturated_fat'=>'0',
            'fk_category'=>'3',
        ]);
        DB::table('ingredients')->insert([
            'ingredient'=>'Hummus',
            'calories'=>'27',
            'protein'=>'0.73',
            'carbohydrates'=>'3.02',
            'fiber'=>'0.6',
            'sodium'=>'36',
            'saturated_fat'=>'1.3',
            'fk_category'=>'1',
        ]);
        DB::table('ingredients')->insert([
            'ingredient'=>'Mantequilla de mani',
            'calories'=>'94',
            'protein'=>'4.01',
            'carbohydrates'=>'3.13',
            'fiber'=>'1',
            'sodium'=>'73',
            'saturated_fat'=>'8.06',
            'fk_category'=>'11',
        ]);
        DB::table('ingredients')->insert([
            'ingredient'=>'Miel de abejas',
            'calories'=>'332',
            'protein'=>'0.6',
            'carbohydrates'=>'82.4',
            'fiber'=>'0.2',
            'sodium'=>'9',
            'saturated_fat'=>'0',
            'fk_category'=>'10',
        ]);
        DB::table('ingredients')->insert([
            'ingredient'=>'Chispas de chocolate',
            'calories'=>'479',
            'protein'=>'4.2',
            'carbohydrates'=>'63.1',
            'fiber'=>'5.9',
            'sodium'=>'11',
            'saturated_fat'=>'17.75',
            'fk_category'=>'10',
        ]);
        DB::table('ingredients')->insert([
            'ingredient'=>'Jamon',
            'calories'=>'215',
            'protein'=>'11.4',
            'carbohydrates'=>'7.4',
            'fiber'=>'0',
            'sodium'=>'1023',
            'saturated_fat'=>'5',
            'fk_category'=>'6',
        ]);
        DB::table('ingredients')->insert([
            'ingredient'=>'Queso doble crema',
            'calories'=>'286',
            'protein'=>'23.4',
            'carbohydrates'=>'5.9',
            'fiber'=>'0',
            'sodium'=>'475',
            'saturated_fat'=>'0',
            'fk_category'=>'7',
        ]);
        DB::table('ingredients')->insert([
            'ingredient'=>'Arroz blanco',
            'calories'=>'353',
            'protein'=>'6.7',
            'carbohydrates'=>'80.1',
            'fiber'=>'1',
            'sodium'=>'2',
            'saturated_fat'=>'0.2',
            'fk_category'=>'1',
        ]);
        // DB::table('ingredients')->insert([
        //     'ingredient'=>'',
        //     'calories'=>'',
        //     'protein'=>'',
        //     'carbohydrates'=>'',
        //     'fiber'=>'',
        //     'sodium'=>'',
        //     'saturated_fat'=>'',
        //     'fk_category'=>'',
        // ]);
        // DB::table('ingredients')->insert([
        //     'ingredient'=>'',
        //     'calories'=>'',
        //     'protein'=>'',
        //     'carbohydrates'=>'',
        //     'fiber'=>'',
        //     'sodium'=>'',
        //     'saturated_fat'=>'',
        //     'fk_category'=>'',
        // ]);
    }
}
