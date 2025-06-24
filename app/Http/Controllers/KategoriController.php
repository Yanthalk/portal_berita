<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use App\Models\Category;
use App\Models\Comments;
use App\Services\NewsDataService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
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
                'id'          => $article['article_id'] ?? null,
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

        // Ambil berita dari DB lokal
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

        // Gabungkan dan urutkan berdasarkan tanggal terbaru
        $allArticles = $apiArticles->merge($localArticles)->sortByDesc('pubDate')->values();

        return view('kategori', [
            'kategori' => ucfirst($kategoriNama),
            'slug'     => $slug,
            'article'  => $allArticles
        ]);
    }

    public function showDetail(Request $request, $id)
    {
        $source = $request->query('source');

        if ($source === 'local') {
            $berita = News::where('news_id', $id)->firstOrFail();
            $komentar = Comments::where('news_id', $id)
                ->orderByDesc('tanggal_komentar')
                ->with('user')
                ->get();

            return view('view-berita', [
                'id'       => $berita->news_id,
                'judul'    => $berita->judul,
                'tanggal'  => $berita->tanggal_publish,
                'penulis'  => $berita->penulis,
                'gambar'   => $berita->gambar ? asset('storage/' . $berita->gambar) : null,
                'konten'   => $berita->konten,
                'komentar' => $komentar,
            ]);
        }

        if ($source === 'api') {
            $slug = strtolower($request->query('kategori'));
            $kategoriMap = config('kategori');
            $kategoriName = $kategoriMap[$slug] ?? null;

            if (!$kategoriName) {
                abort(404);
            }

            $rawData = $this->newsService->getTopHeadlines('id', $slug, 100);
            $article = collect($rawData)->firstWhere('article_id', $id);

            if (!$article) {
                abort(404);
            }

            $konten = strlen($article['content'] ?? '') < 30
                ? ($article['description'] ?? 'Tidak tersedia')
                : $article['content'];

            return view('view-berita-kategori', [
                'judul'    => $article['title'] ?? 'Judul Tidak Tersedia',
                'tanggal'  => \Carbon\Carbon::parse($article['pubDate'])->format('d/m/y, H:i') . ' WIB',
                'penulis'  => data_get($article, 'creator.0', 'Anonim'),
                'gambar'   => $article['image_url'] ?? null,
                'konten'   => $konten,
                'komentar' => null,
            ]);
        }

        abort(404);
    }

}