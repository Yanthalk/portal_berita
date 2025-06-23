<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya</title>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-[Poppins] bg-gray-400 min-h-screen">

    <main class="max-w-xl mx-auto mt-36 bg-white rounded-lg p-6 shadow-md">
        <div class="flex items-center mb-6">
            <a href="{{ route('homepage') }}" class="text-black text-2xl mr-3">
                <i class='bx bx-arrow-back'></i>
            </a>
            <h1 class="text-xl font-bold text-center flex-1 capitalize">Profile Saya</h1>
        </div>

        <div class="w-full h-[2px] bg-black mb-4"></div>

        <div class="text-center space-y-6 my-10">
            <div>
                <p class="text-lg font-semibold">Username</p>
                <p class="text-xl text-black">{{ $user->nama }}</p>
            </div>

            <div>
                <p class="text-lg font-semibold">Email</p>
                <p class="text-base text-gray-700">{{ $user->email }}</p>
            </div>
        </div>
    </main>

    <div class="max-w-xl mx-auto mt-4 bg-white rounded-lg p-6 shadow-md space-y-4 text-center">
        <a href="{{ route('ubah-profile') }}"
           class="block w-full text-black font-semibold text-base hover:underline">
           Ubah Profile
        </a>

        <div class="w-full h-[2px] bg-black"></div>

        <form action="{{ route('logout') }}" method="POST" class="w-full">
            @csrf
            <button type="submit" class="w-full text-red-600 font-semibold hover:underline">
                Logout Akun
            </button>
        </form>
    </div>
</body>
</html>
