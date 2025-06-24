<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use App\Models\Komentar;
use App\Services\NewsDataService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->query('query');
        if (!$query || strlen($query) < 2) {
            return response()->json([]);
        }

        $localResults = News::where('judul', 'LIKE', "%{$query}%")
            ->get()
            ->map(function ($berita) {
                return [
                    'source' => 'local',
                    'id' => $berita->news_id,
                    'judul' => $berita->judul,
                ];
            });

        $newsService = new NewsDataService();
        $apiResponse = $newsService->search($query);
        $apiResults = [];

        if (isset($apiResponse['results'])) {
            $apiResults = collect($apiResponse['results'])
                ->take(10)
                ->map(function ($article, $index) {
                    return [
                        'source' => 'api',
                        'id' => $index,
                        'judul' => $article['title'],
                        'url' => route('view-berita-cari', [
                            'id' => $article['article_id'] ?? uniqid()
                        ]) . '?source=api&judul=' . urlencode($article['title'])
                    ];
                });
        }

        $results = $localResults->merge($apiResults);
        return response()->json($results);
    }

    public function cari(Request $request)
    {
        $query = $request->input('query');

        $localResults = News::where('judul', 'LIKE', "%{$query}%")
            ->get()
            ->map(function ($berita) {
                return [
                    'source' => 'local',
                    'judul' => $berita->judul,
                    'id' => $berita->news_id,
                    'description' => $berita->deskripsi,
                    'content'     => $berita->konten,
                    'image_url' => $berita->gambar ? asset('storage/' . $berita->gambar) : asset('images/post-berita.jpg'),
                    'pubDate' => $berita->tanggal_publish,
                    'category' => [$berita->category->nama_kategori ?? 'Umum'],
                    'url' => route('view-berita-cari', ['id' => $berita->news_id, 'source' => 'local'])
                ];
            });

        $newsService = new NewsDataService();
        $apiResponse = $newsService->search($query);
        $apiResults = [];

        if (isset($apiResponse['results'])) {
            $apiResults = collect($apiResponse['results'])
                ->take(10)
                ->map(function ($article) {
                    return [
                        'source' => 'api',
                        'judul' => $article['title'],
                        'id' => $article['article_id'] ?? uniqid(),
                        'description' => $article['description'] ?? 'Tidak ada deskripsi.',
                        'image_url' => $article['image_url'] ?? asset('images/post-berita.jpg'),
                        'pubDate' => $article['pubDate'] ?? now(),
                        'category' => is_array($article['category']) ? $article['category'] : [$article['category'] ?? 'Umum'],
                        'url' => route('view-berita-cari', [
                            'id' => $article['article_id'] ?? uniqid()
                        ]) . '?source=api&judul=' . urlencode($article['title'])
                    ];
                });
        }

        $combined = $localResults->concat($apiResults);

        return view('cari', [
            'query' => $query,
            'results' => $combined
        ]);
    }

    public function viewBeritaCari(Request $request, $id)
    {
        $source = $request->query('source');

        if ($source === 'local') {
            $berita = News::with('category')->where('news_id', $id)->firstOrFail();

            return view('view-berita-cari', [
                'judul' => $berita->judul,
                'tanggal' => $berita->tanggal_publish,
                'penulis' => $berita->penulis,
                'gambar' => $berita->gambar ? asset('storage/' . $berita->gambar) : null,
                'konten' => $berita->konten,
                'komentar' => $berita->komentar,
                'id' => $berita->news_id,
            ]);
        } elseif ($source === 'api') {
            $judul = $request->query('judul');

            if (!$judul) {
                abort(404);
            }

            $newsService = new NewsDataService();
            $rawData = $newsService->search($judul);
            $article = collect($rawData['results'] ?? [])->firstWhere('title', $judul);

            if (!$article) {
                abort(404);
            }

            $konten = strlen($article['content'] ?? '') < 30
                ? ($article['description'] ?? 'Tidak tersedia')
                : $article['content'];

            return view('view-berita-cari', [
                'judul' => $article['title'] ?? 'Judul Tidak Tersedia',
                'tanggal' => \Carbon\Carbon::parse($article['pubDate'])->format('d/m/y, H:i') . ' WIB',
                'penulis' => data_get($article, 'creator.0', 'Anonim'),
                'gambar' => $article['image_url'] ?? null,
                'konten' => $konten,
                'komentar' => null,
            ]);
        } else {
            abort(404);
        }
    }
}