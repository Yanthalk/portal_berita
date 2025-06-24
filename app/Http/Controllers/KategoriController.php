<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use App\Models\Category;
use App\Services\NewsDataService;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class KategoriController extends Controller
{
    protected $newsService;

    public function __construct(NewsDataService $newsService)
    {
        $this->newsService = $newsService;
    }

    public function tampilkanBerita(Request $request, $slug)
    {
        Carbon::setLocale('id');

        $configKategori = config('kategori');
        $kategoriNama = $configKategori[$slug] ?? null;
        if (!$kategoriNama) {
            abort(404);
        }

        $kategoriLokal = Category::where('nama_kategori', $kategoriNama)->first();
        $kategoriID = $kategoriLokal->category_id ?? null;

        // Ambil berita dari API
        $apiResults = $this->newsService->getTopHeadlines('id', $slug, 100);
        $apiArticles = collect($apiResults)->map(function ($article) {
            return [
                'id'          => $article['article_id'] ?? uniqid(),
                'article_id'  => $article['article_id'] ?? null,
                'title'       => $article['title'] ?? null,
                'description' => $article['description'] ?? null,
                'content'     => $article['content'] ?? null,
                'image_url'   => $article['image_url'] ?? null,
                'creator'     => $article['creator'][0] ?? null,
                'country'     => $article['country'] ?? null,
                'pubDate'     => $article['pubDate'] ?? null,
                'category'    => is_array($article['category']) ? $article['category'] : [$article['category']],
                'source'      => 'api'
            ];
        });

        // Ambil berita dari DB
        $localArticles = News::with('category')
            ->when($kategoriID, fn($q) => $q->where('category_id', $kategoriID))
            ->orderByDesc('tanggal_publish')
            ->take(5)
            ->get()
            ->map(function ($berita) {
                return [
                    'id'          => $berita->news_id,
                    'title'       => $berita->judul,
                    'description' => $berita->deskripsi,
                    'content'     => $berita->konten,
                    'image_url'   => $berita->gambar ? asset('storage/' . $berita->gambar) : null,
                    'creator'     => $berita->penulis,
                    'pubDate'     => $berita->tanggal_publish,
                    'category'    => [$berita->category->nama_kategori ?? 'Umum'],
                    'source'      => 'local'
                ];
            });
        logger()->info('Local Articles:', $localArticles->toArray());

        // Gabungkan dan urutkan
        $allArticles = $apiArticles->merge($localArticles)->sortByDesc('pubDate')->values();

        return view('kategori', [
            'kategori' => ucfirst($kategoriNama),
            'article' => $allArticles
        ]);
    }

}
