<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Portal Berita</title>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center relative font-[Poppins]">

    {{-- Background blur --}}
    <div class="absolute inset-0 bg-cover bg-center filter blur-md -z-10" style="background-image: url('{{ asset('images/background.png') }}');"></div>

    {{-- Wrapper --}}
    <div class="w-full max-w-md bg-white/30 backdrop-blur-xl border-2 border-black shadow-md rounded-3xl p-8 z-10">

        {{-- Error alert --}}
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                <ul class="text-sm list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form --}}
        <form action="{{ route('daftar') }}" method="POST" class="space-y-6">
            @csrf

            <h1 class="text-3xl font-bold text-center text-black">Daftar Akun</h1>

            {{-- Nama --}}
            <div>
                <input type="text" name="nama" placeholder="Enter Nama" value="{{ old('nama') }}" required
                    class="w-full h-12 px-5 text-black text-base bg-gray-300 border border-white/30 rounded-full focus:outline-none focus:ring-2 focus:ring-black placeholder-black">
            </div>

            {{-- Email --}}
            <div>
                <input type="email" name="email" placeholder="Enter Email" value="{{ old('email') }}" required
                    class="w-full h-12 px-5 text-black text-base bg-gray-300 border border-white/30 rounded-full focus:outline-none focus:ring-2 focus:ring-black placeholder-black">
            </div>

            {{-- Password --}}
            <div class="flex gap-3">
                <input type="password" name="password" placeholder="Enter Password" required
                    class="w-1/2 h-12 px-5 text-black text-base bg-gray-300 border border-white/30 rounded-full focus:outline-none focus:ring-2 focus:ring-black placeholder-black">
                <input type="password" name="confirm_password" placeholder="Confirm Password" required
                    class="w-1/2 h-12 px-5 text-black text-base bg-gray-300 border border-white/30 rounded-full focus:outline-none focus:ring-2 focus:ring-black placeholder-black">
            </div>

            {{-- Tombol daftar --}}
            <button type="submit"
                class="w-full h-12 bg-gray-300 text-black font-semibold rounded-full shadow hover:bg-black hover:text-white transition">
                Daftar
            </button>

            {{-- Link login --}}
            <div class="text-center text-sm">
                <p>Sudah punya akun?
                    <a href="{{ route('login') }}" class="text-black font-semibold hover:underline">
                        Masuk Login
                    </a>
                </p>
            </div>
        </form>
    </div>

</body>
</html>