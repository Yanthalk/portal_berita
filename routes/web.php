<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\{AuthController, HomeController, NewsController, KategoriController};


// Homepage
Route::get('/', [HomeController::class, 'index'])->name('homepage');

// Auth - Register & Login
Route::get('/daftar', [AuthController::class, 'showRegister'])->name('daftar');
Route::post('/daftar', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Logout
Route::post('/logout', function () {
    Auth::logout(); 
    request()->session()->invalidate(); 
    request()->session()->regenerateToken(); 
    return redirect()->route('homepage'); 
})->name('logout');

// Berita
Route::get('/berita', [NewsController::class, 'index'])->name('berita.index');
Route::get('/berita/view/{id}', [HomeController::class, 'showDetail'])->name('view-berita');
Route::post('/berita/view/{id}/komentar', [HomeController::class, 'kirimKomentar'])->middleware('auth')->name('kirim-komentar');

// Pencarian
Route::get('/search-berita', [NewsController::class, 'search'])->name('berita.search.json'); // untuk AJAX/autocomplete
Route::get('/cari', [NewsController::class, 'cari'])->name('berita.cari'); // untuk hasil pencarian penuh

// Kategori
Route::get('/kategori/{slug}', [KategoriController::class, 'tampilkanBerita'])->name('kategori.show');

// Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [HomeController::class, 'showProfile'])->name('profile');
    Route::get('/ubah-profile', [HomeController::class, 'editProfile'])->name('ubah-profile');
    Route::post('/ubah-profile', [HomeController::class, 'updateProfile'])->name('ubah-profile.update');
});
