<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['category_id' => 1, 'nama_kategori' => 'Politik'],
            ['category_id' => 2, 'nama_kategori' => 'Teknologi'],
            ['category_id' => 3, 'nama_kategori' => 'Kesehatan'],
            ['category_id' => 4, 'nama_kategori' => 'Berita Utama'],
            ['category_id' => 5, 'nama_kategori' => 'Bisnis'],
            ['category_id' => 6, 'nama_kategori' => 'Kriminal'],
            ['category_id' => 7, 'nama_kategori' => 'Pendidikan'],
            ['category_id' => 8, 'nama_kategori' => 'Hiburan'],
            ['category_id' => 9, 'nama_kategori' => 'Makanan'],
            ['category_id' => 10, 'nama_kategori' => 'Olahraga'],
        ];

        DB::table('category')->insert($data);
    }
}
