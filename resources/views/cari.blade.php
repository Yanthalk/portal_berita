@extends('layouts.app')

@section('title', "Hasil Pencarian: $query")

@section('content')
    <div class="w-full py-6">
        <h2 class="text-xl font-semibold text-gray-800">Hasil pencarian untuk: <span class="text-black">{{ $query }}</span></h2>
    </div>

    <div class="w-full h-[2px] bg-black my-2"></div>

    @forelse ($results as $item)
        <div class="flex gap-4 mb-6 pb-5 border-b border-gray-300">
            <div>
                <img src="{{ $item['image_url'] ?? asset('images/post-berita.jpg') }}" alt="post-berita"
                     class="w-[300px] h-[150px] rounded-lg object-cover shrink-0">
            </div>
            <div class="flex-1">
                <h1 class="text-lg font-bold leading-snug mb-2">
                    <a href="{{ $item['url'] }}" class="hover:underline text-black">{{ $item['judul'] }}</a>
                </h1>
                <p class="text-sm text-gray-700 mb-2">{{ $item['description'] ?? 'Tidak ada deskripsi.' }}</p>
                <div class="flex gap-6 text-gray-500 text-xs mb-2 flex-wrap">
                    <p>{{ ucfirst($item['category'][0] ?? 'umum') }}</p>
                    <p>{{ isset($item['pubDate']) ? \Carbon\Carbon::parse($item['pubDate'])->translatedFormat('d F Y, H:i') : '-' }}</p>
                    <p class="italic text-[12px] text-gray-500">Sumber: {{ $item['source'] === 'api' ? 'News API' : 'Lokal' }}</p>
                </div>
                <a href="{{ $item['url'] }}" class="text-blue-500 hover:underline text-sm">Baca Selengkapnya</a>
            </div>
        </div>
    @empty
        <p class="text-gray-600">Tidak ada hasil ditemukan.</p>
    @endforelse
@endsection