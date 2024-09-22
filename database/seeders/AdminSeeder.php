<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'nickname' => 'admin',
            'name' => 'Admin',
            'email' => 'lonches.adm@gmail.com',
            'password' => Hash::make('1234'),
            'fk_type' => 1,
            'is_active' => true,
        ]);
    }
}
