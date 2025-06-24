<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class NewsSeeder extends Seeder
{
    public function run()
    {
        $gambarList = ['berita/berita1.jpg', 'berita/berita2.jpg'];

        foreach (range(1, 10) as $category_id) {
            foreach (range(1, 5) as $i) {
                DB::table('news')->insert([
                    'judul' => "Berita $category_id-$i",
                    'deskripsi' => "Ini adalah deskripsi untuk berita $category_id-$i.",
                    'tanggal_publish' => Carbon::now()->subDays(rand(0, 30)),
                    'konten' => Str::random(300),
                    'gambar' => $gambarList[($category_id + $i) % 2],
                    'penulis' => "Penulis $i",
                    'category_id' => $category_id,
                ]);
            }
        }
    }
}
