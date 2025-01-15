<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class BukuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('buku')->insert([
            [
                'id_kategori' => 1, // ID kategori Fiksi
                'judul' => 'Petualangan si Kancil',
                'sampul' => null, // Bisa diisi file biner jika tersedia
                'selengkapnya' => json_encode([
                    'penulis' => 'Budi Santoso',
                    'tahun' => 2020,
                    'penerbit' => 'Gramedia',
                    'sinopsis' => 'Kisah si kancil yang cerdik dan penuh petualangan.',
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_kategori' => 2, // ID kategori Non-Fiksi
                'judul' => 'Belajar Hidup Bahagia',
                'sampul' => null,
                'selengkapnya' => json_encode([
                    'penulis' => 'Ani Kusuma',
                    'tahun' => 2021,
                    'penerbit' => 'Bentang Pustaka',
                    'sinopsis' => 'Panduan untuk menjalani hidup yang lebih bahagia dan bermakna.',
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_kategori' => 3, // ID kategori Edukasi
                'judul' => 'Belajar Pemrograman Laravel',
                'sampul' => null,
                'selengkapnya' => json_encode([
                    'penulis' => 'Agus Sutrisno',
                    'tahun' => 2023,
                    'penerbit' => 'Media Teknik',
                    'sinopsis' => 'Buku panduan lengkap belajar Laravel untuk pemula.',
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
