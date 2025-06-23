@extends('layouts.app')

@section('title', $judul)

@section('content')

    {{-- Iklan 1 --}}
    <div class="bg-gray-300 h-36 flex items-center justify-center text-xl font-bold mt-4">Iklan</div>

    <div class="w-full h-[2px] bg-black my-4"></div>

    {{-- Konten Utama --}}
    <main class="flex flex-col md:flex-row px-4 md:px-12 gap-6">
        {{-- Berita --}}
        <div class="w-[70%] md:w-2/3 space-y-4">
            <h1 class="text-3xl font-bold capitalize">{{ $judul }}</h1>
            <p class="text-sm text-gray-700">
                <a href="{{ route('homepage') }}" class="text-black font-semibold underline">Portal Berita</a> - {{ $tanggal }}
            </p>
            <p class="text-base font-medium capitalize">{{ $penulis }}</p>
            @if ($gambar)
                <div class="flex justify-center mt-4">
                    <img src="{{ $gambar }}" alt="cover"
                         class="w-full max-h-[600px] object-cover border-2 border-black shadow-md rounded">
                </div>
            @endif

            <div class="mt-4 text-justify text-base leading-relaxed break-words overflow-hidden">
                {!! nl2br(e($konten)) !!}
            </div>

            {{-- Komentar --}}
            @if (!is_null($komentar))
                <div class="mt-10">
                    <h2 class="text-2xl font-semibold mb-4">Komentar</h2>
                    <div class="bg-gray-200 border-2 border-black rounded-lg p-4 space-y-4">
                        @auth
                            <form action="{{ route('kirim-komentar', ['id' => request()->route('id')]) }}" method="POST"
                                  class="flex gap-2 items-center">
                                @csrf
                                <input name="komentar" required placeholder="Tulis komentar..."
                                       class="flex-1 px-4 py-2 rounded-full border border-gray-400 focus:ring-2 focus:ring-blue-500">
                                <button type="submit" class="bg-blue-600 text-white p-2 rounded-full text-xl hover:bg-blue-800">
                                    <i class='bx bx-send'></i>
                                </button>
                            </form>
                            <div class="w-full h-[2px] bg-black my-2"></div>
                        @endauth

                        @guest
                            <div class="bg-gray-700 text-white text-center p-6 rounded-lg max-w-xl mx-auto">
                                Silakan <a href="{{ route('login') }}" class="underline text-blue-400 font-semibold">login</a> untuk mengirim komentar.
                            </div>
                        @endguest

                        @foreach ($komentar as $komen)
                            <div class="bg-white p-3 rounded-lg shadow">
                                <div class="flex justify-between text-sm text-gray-500 mb-1">
                                    <span class="font-semibold text-black">{{ $komen->user->nama }}</span>
                                    <span class="italic">{{ \Carbon\Carbon::parse($komen->tanggal_komentar)->translatedFormat('d F Y H:i') }}</span>
                                </div>
                                <p class="text-gray-700">{{ $komen->komentar }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        {{-- Iklan 2 (sidebar tinggi penuh) --}}
        <div class="w-full md:w-1/3">
            <div class="bg-gray-300 w-full h-full min-h-[400px] flex justify-center items-center text-xl font-bold">
                Iklan
            </div>
        </div>
    </main>
@endsection
