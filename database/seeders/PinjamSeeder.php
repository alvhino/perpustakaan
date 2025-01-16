<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PinjamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pinjam')->insert([
            [
                'id_user' => 1,
                'id_buku' => 5,
                'status' => 'pinjam',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
