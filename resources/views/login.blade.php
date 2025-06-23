<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login Portal Berita</title>

  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
    }
  </style>
</head>

<body class="relative min-h-screen flex items-center justify-center overflow-hidden">

  <div class="absolute inset-0 z-0 bg-cover bg-center filter blur-md"
       style="background-image: url('/images/background.png');"></div>

  <div class="relative z-10 w-[420px] bg-white/10 backdrop-blur-xl border-2 border-black shadow-md rounded-[35px] px-10 py-8 text-black">

    <form action="{{ route('login') }}" method="POST">
      @csrf

      <h1 class="text-3xl text-center font-bold mb-2">Portal Berita</h1>
      <h3 class="text-base text-center mb-4">Selamat Datang di Portal Berita</h3>

      @if ($errors->any())
        <div class="bg-red-100 border border-red-500 text-red-700 text-sm font-semibold px-4 py-2 rounded-xl text-center mb-3">
          {{ $errors->first() }}
        </div>
      @endif

      <!-- Input Username/Email -->
      <div class="relative w-full h-[50px] mb-6">
        <input type="text" name="login" placeholder="Enter Username or Email" required
               value="{{ old('login', request()->cookie('remembered_nama')) }}"
               class="w-full h-full bg-gray-300 rounded-full border-2 border-white/20 outline-none px-5 pr-12 text-black placeholder-black text-base">
        <i class='bx bxs-user absolute right-5 top-1/2 transform -translate-y-1/2 text-lg'></i>
      </div>

      <!-- Input Password -->
      <div class="relative w-full h-[50px] mb-6">
        <input type="password" name="password" id="password" placeholder="Enter Password" required
               class="w-full h-full bg-gray-300 rounded-full border-2 border-white/20 outline-none px-5 pr-12 text-black placeholder-black text-base">
        <i class='bx bxs-lock-alt absolute right-5 top-1/2 transform -translate-y-1/2 text-lg'></i>
      </div>

      <!-- Remember Me -->
      <div class="flex justify-between items-center text-sm mb-4">
        <label class="flex items-center gap-2">
          <input type="checkbox" name="remember" {{ request()->cookie('remembered_nama') ? 'checked' : '' }} class="accent-white">
          Ingat Saya
        </label>
      </div>

      <!-- Button Login -->
      <button type="submit"
              class="w-full h-[45px] bg-gray-300 rounded-full shadow-sm hover:bg-gray-400 text-lg font-semibold text-black transition">
        Login
      </button>

      <!-- Link Daftar -->
      <div class="text-sm text-center mt-6">
        <p>
          Tidak punya akun?
          <a href="{{ route('daftar') }}" class="text-black font-semibold hover:underline">Daftar akun?</a>
        </p>
      </div>
    </form>
  </div>
</body>
</html>
