<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (!session()->has('url.intended')) {
            session(['url.intended' => url()->previous()]);
        }
        return view('login');
    }

    public function login(Request $request)
    {
        // Validasi input login
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        $loginInput = $request->input('login');
        $field = filter_var($loginInput, FILTER_VALIDATE_EMAIL) ? 'email' : 'nama';

        $user = User::where($field, $loginInput)->first();

        // Cek apakah user ditemukan dan password cocok
        if ($user && Hash::check($request->password, $user->password)) {
            auth()->login($user);

            // Ingat username jika dicentang
            if ($request->has('remember')) {
                Cookie::queue('remembered_nama', $user->nama, 60 * 24 * 30); // 30 hari
            } else {
                Cookie::queue(Cookie::forget('remembered_nama'));
            }

            return redirect()->intended(route('homepage'));
        }

        return back()->withErrors(['message' => 'Username atau password salah']);
    }

    public function showRegister()
    {
        return view('daftar');
    }

    public function register(Request $request)
    {
        // Validasi input daftar
        $request->validate([
            'nama' => 'required|string|unique:users,nama',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'confirm_password' => 'required|string|min:6',
        ]);

        // Cek apakah password dan confirm password sama
        if ($request->password !== $request->confirm_password) {
            return back()->withErrors(['confirm_password' => 'Password dan konfirmasi password tidak cocok'])->withInput();
        }

        // Jika sama, lanjut simpan user (confirm_password tidak disimpan)
        $user = User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => 1,
        ]);

        // Login otomatis setelah daftar
        auth()->login($user);

        return redirect()->route('homepage');
    }
}
