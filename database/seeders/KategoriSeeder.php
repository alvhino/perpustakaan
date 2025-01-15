<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('kategori')->insert([
            ['nama_kategori' => 'Fiksi', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Non-Fiksi', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Edukasi', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Sejarah', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Teknologi', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
