@extends('layouts.app')

@section('title', $kategori)

@section('content')
    {{-- Iklan 1 --}}
    <div class="w-full bg-gray-300 flex justify-center items-center h-40 my-4">
        <h1 class="text-xl font-bold">IKLAN</h1>
    </div>

    <div class="border-t-2 border-black mb-6"></div>

    <main class="flex flex-col md:flex-row gap-6 px-6">
         <div class="w-full md:w-[70%] flex flex-col space-y-6">
            <div class="text-2xl font-bold capitalize">{{ $kategori }}</div>
            <div class="border-t-2 border-black"></div>

            {{-- Headline --}}
            @if ($article->count() > 0)
                @php $headline = $article[0]; @endphp
                <a href="{{ route('kategori.detail', ['id' => $headline['id'], 'source' => $headline['source'], 'kategori' => $slug]) }}"
                    class="relative block rounded overflow-hidden">
                    <img src="{{ $headline['image_url'] ?? asset('images/post-berita.jpg') }}" alt="Headline"
                        class="w-full h-[550px] object-cover">
                    <div class="absolute bottom-0 left-0 w-full bg-gradient-to-t from-black to-transparent text-white p-4">
                        <span class="bg-gray-800 text-blue-400 text-xs px-2 py-1 rounded font-bold">HEADLINE</span>
                        <h2 class="text-xl font-semibold mt-2">{{ $headline['title'] }}</h2>
                        <p class="text-sm text-gray-300">
                            {{ \Carbon\Carbon::parse($headline['pubDate'])->translatedFormat('d F Y, H:i') }}
                        </p>
                    </div>
                </a>
            @endif

            {{-- 4 Sub Berita --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                @foreach ($article->slice(1, 4) as $berita)
                    <a href="{{ route('kategori.detail', ['id' => $berita['id'], 'source' => $berita['source'], 'kategori' => $slug]) }}">
                        <div class="bg-black text-white rounded overflow-hidden">
                            <img src="{{ $berita['image_url'] ?? asset('images/post-berita.jpg') }}"
                                 class="w-full h-32 object-cover border-b border-gray-600">
                            <p class="p-2 text-sm">{{ $berita['title'] }}</p>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="border-t-2 border-black my-4"></div>
            <div class="text-right text-lg font-semibold capitalize">Update Berita</div>
            <div class="border-t-2 border-black my-4"></div>

            {{-- Update Berita --}}
            @foreach ($article->slice(5) as $berita)
                <div class="flex flex-col md:flex-row gap-4 border-b pb-4">
                    <img src="{{ $berita['image_url'] ?? asset('images/post-berita.jpg') }}"
                         class="w-full md:w-72 h-40 object-cover rounded">
                    <div class="flex flex-col justify-between">
                        <h1 class="text-lg font-bold">{{ $berita['title'] }}</h1>
                        <p class="text-sm text-gray-600 mt-1">
                            {{ $berita['description'] ?? 'Tidak ada deskripsi.' }}
                        </p>
                        <div class="flex gap-4 text-xs text-gray-500 mt-2">
                            <span>{{ ucfirst($berita['category'][0] ?? 'umum') }}</span>
                            <span>
                                {{ $berita['pubDate'] ? \Carbon\Carbon::parse($berita['pubDate'])->translatedFormat('d F Y, H:i') : '-' }}
                            </span>
                            <span class="italic text-[10px]">Sumber: {{ $berita['source'] === 'api' ? 'News API' : 'Lokal' }}</span>
                        </div>
                        <a href="{{ route('kategori.detail', ['id' => $berita['id'], 'source' => $berita['source'], 'kategori' => $slug]) }}"
                           class="mt-2 text-blue-600 font-semibold hover:underline">
                            Baca Selengkapnya
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Iklan 2 --}}
        <div class="w-full md:w-[30%] bg-gray-300 flex items-center justify-center min-h-full">
            <h1 class="text-xl font-bold">IKLAN</h1>
        </div>
    </main>
@endsection
