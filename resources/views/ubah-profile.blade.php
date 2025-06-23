<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Profile</title>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-400 font-[Poppins] min-h-screen flex items-center justify-center">

    <main class="bg-white w-full max-w-xl rounded-lg shadow-md p-6 mt-36">
        {{-- Header --}}
        <div class="relative mb-4">
            <a href="{{ route('profile') }}" class="absolute left-0 top-1/2 -translate-y-1/2 pl-2 text-2xl text-black">
                <i class='bx bx-arrow-back'></i>
            </a>
            <h1 class="text-xl font-bold text-center capitalize">Ubah Profile</h1>
        </div>

        <div class="w-full h-[2px] bg-black mb-6"></div>

        {{-- Form --}}
        <form action="{{ route('ubah-profile.update') }}" method="POST" class="space-y-6">
            @csrf

            {{-- Username --}}
            <div>
                <p class="text-lg font-semibold mb-2 ml-6">Ubah Username</p>
                <div class="flex justify-center">
                    <input type="text" name="nama" placeholder="Enter Username"
                        value="{{ old('nama', $user->nama) }}" required
                        class="w-3/4 bg-gray-300 rounded-full px-4 py-2 text-base text-black placeholder-black shadow outline-none border-none focus:ring-2 focus:ring-black">
                </div>
            </div>

            {{-- Email --}}
            <div>
                <p class="text-lg font-semibold mb-2 ml-6">Ubah Email</p>
                <div class="flex justify-center">
                    <input type="email" name="email" placeholder="Enter Email"
                        value="{{ old('email', $user->email) }}" required
                        class="w-3/4 bg-gray-300 rounded-full px-4 py-2 text-base text-black placeholder-black shadow outline-none border-none focus:ring-2 focus:ring-black">
                </div>
            </div>

            {{-- Tombol Submit --}}
            <div class="flex justify-end pr-12 mt-8">
                <button type="submit"
                    class="w-1/4 bg-gray-300 rounded-full px-4 py-2 font-semibold text-black text-base shadow hover:bg-black hover:text-white transition">
                    Simpan
                </button>
            </div>
        </form>
    </main>

</body>
</html>
