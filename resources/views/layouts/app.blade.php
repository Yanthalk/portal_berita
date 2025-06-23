<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'HotNews')</title>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <!-- Navbar Utama -->
    <nav class="flex justify-between items-center px-5 py-2 bg-black text-white sticky top-0 z-50 w-full mb-1">
        <div class="flex items-center gap-2">
            <a href="{{ route('homepage') }}">
                <h1 class="text-red-600 text-xl font-bold">Hot</h1>
            </a>
            <a href="{{ route('homepage') }}">
                <h1 class="text-white text-xl font-bold">News</h1>
            </a>
        </div>
        <div class="flex items-center gap-4">
            <form action="{{ route('berita.cari') }}" method="GET" class="flex items-center space-x-2">
                <input type="text" name="query" placeholder="Cari Berita"
                    class="border rounded-full px-4 py-2 w-full md:w-64 focus:outline-none focus:ring-2 focus:ring-blue-400 text-black">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-500">Cari</button>
            </form>
            <div>
                @auth
                    <a href="{{ route('profile') }}"
                    class="inline-block px-4 py-2 bg-green-600 text-white font-bold rounded hover:bg-green-800 transition">
                        Profile
                    </a>
                @endauth

                @guest
                    <a href="{{ route('login') }}"
                    class="inline-block px-4 py-2 bg-gray-300 text-black font-bold rounded hover:bg-blue-800 hover:text-white transition">
                        Login
                    </a>
                @endguest
            </div>
        </div>
    </nav>

    <!-- Navbar Kedua -->
    <div class="w-full flex flex-col gap-10 mx-auto">
        <nav class="flex justify-center items-center px-5 py-2 bg-black text-white w-full">
            <ul class="flex gap-20 flex-wrap justify-center">
                @foreach(config('kategori') as $slug => $nama)
                    <li>
                        <a href="{{ route('kategori.show', $slug) }}"
                        class="capitalize font-semibold px-4 py-2 border rounded-xl transition
                                {{ request()->is("kategori/$slug") ? 'bg-gray-800 text-white border-white' : 'bg-gray-300 border-gray-800 hover:bg-gray-800 hover:text-white' }}">
                            {{ $nama }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </nav>
    </div>

    <!-- Konten Utama -->
    <main class="max-w-7xl mx-auto p-4">
        @yield('content')
    </main>

    <!-- Script jika diperlukan -->
    @stack('scripts')
</body>
</html>
