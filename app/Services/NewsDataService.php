<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class NewsDataService
{
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = env('API_KEY');
        $this->baseUrl = 'https://newsdata.io/api/1/';
    }

    public function getTopHeadlines($country = 'id', $category = null, $limit = 100)
    {
        $params = [
            'apikey' => $this->apiKey,
            'country' => $country,
            'language' => 'id',
        ];

        if ($category) {
            $params['category'] = $category;
        }

        $response = Http::get($this->baseUrl . 'news', $params);

        if ($response->failed()) {
            logger()->error('Gagal mengambil data dari NewsData API', [
                'url' => $this->baseUrl . 'news',
                'params' => $params,
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            return [];
        }

        $results = $response->json()['results'] ?? [];
        return array_slice($results, 0, $limit);

    }

    public function search($query)
    {
        $params = [
            'apikey' => $this->apiKey,
            'q' => $query,
            'language' => 'id',
        ];

        $response = Http::get($this->baseUrl . 'news', $params);

        if ($response->failed()) {
            logger()->error('Gagal mencari berita di NewsData API', [
                'query' => $query,
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            return [];
        }

        return $response->json();
    }
}