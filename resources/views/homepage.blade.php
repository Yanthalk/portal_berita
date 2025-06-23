@extends('layouts.app')

@section('title', 'Homepage')

@section('content')
    <!-- Iklan -->
    <div class="w-full h-[150px] bg-gray-300 flex items-center justify-center my-3">
        <h1 class="text-xl font-bold">Iklan</h1>
    </div>

    <!-- Garis Pembatas -->
    <div class="w-full h-[2px] bg-black my-2"></div>

    <!-- Main -->
    <main class="flex w-full px-5 gap-5 items-stretch">
        <!-- Artikel (70%) -->
        <div class="w-[70%]">
            <div class="mb-4">
                <h4 class="text-xl capitalize mb-2">Update Berita</h4>
                <div class="w-full h-[2px] bg-black"></div>
            </div>

            <!-- Looping artikel -->
            @foreach ($articles as $article)
                <div class="flex gap-4 mb-6 pb-5 border-b border-gray-300">
                    <div>
                        <img src="{{ $article['image_url'] ?? asset('images/post-berita.jpg') }}"
                            onerror="this.onerror=null;this.src='{{ asset('images/post-berita.jpg') }}';"
                            alt="post-berita"
                            class="w-[300px] h-[150px] rounded-lg object-cover shrink-0">
                    </div>
                    <div class="flex-1">
                        <h1 class="text-lg font-bold leading-snug mb-2">{{ $article['title'] ?? 'Judul Tidak Tersedia' }}</h1>
                        <p class="text-sm text-gray-700 mb-2">{{ $article['description'] ?? 'Tidak ada deskripsi.' }}</p>
                        <div class="flex gap-6 text-gray-500 text-xs mb-2">
                            <p>{{ ucfirst($article['category'][0] ?? 'Umum') }}</p>
                            <p>{{ \Carbon\Carbon::parse($article['pubDate'])->translatedFormat('d F Y, H:i') }}</p>
                        </div>
                        <a href="{{ route('view-berita', ['id' => $article['id'], 'source' => $article['source']]) }}" class="text-blue-500 hover:underline text-sm">Baca Selengkapnya</a>
                    </div>
                </div>
            @endforeach

            @if ($articles->isEmpty())
                <p class="text-gray-600">Tidak ada data artikel tersedia.</p>
            @endif
        </div>

        <!-- Iklan 2 (30%) -->
        <div class="w-[30%] bg-gray-300 p-4 flex items-center justify-center">
            <h1 class="text-xl font-bold">Iklan</h1>
        </div>
    </main>
@endsection
