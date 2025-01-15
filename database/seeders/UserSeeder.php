<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('user')->insert([
            [
            'username' => 'admin',
            'role' => 'admin',
            'password' =>\Hash::make('1234'),
            'created_at' => now(),
            'updated_at' => now(),
            ],
            [
            'username' => 'user',
            'role' => 'user',
            'password' =>\Hash::make('5678'),
            'created_at' => now(),
            'updated_at' => now(),
            ],
    
        ]);
    }
}
