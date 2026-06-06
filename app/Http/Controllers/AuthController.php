<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Method untuk menampilkan halaman login
    public function showLogin()
    {
        // Cek dulu: jika sudah login, langsung lempar ke dashboard
        if (Auth::check()) {
            return redirect('/dashboard');
        }

        // Jika belum login, tampilkan view login
        return view('auth.login');
    }

    // Method untuk memproses data login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            // Keamanan: buat session baru agar tidak bisa dibajak
            $request->session()->regenerate();

            // Redirect ke halaman yang dituju sebelumnya, atau ke dashboard
            return redirect()->intended('dashboard');
        }

        // Kembali ke halaman login jika gagal dengan pesan error
        return back()->with('error', 'Email atau Password salah!');
    }

    // Method untuk logout
    public function logout(Request $request)
    {
        Auth::logout();

        // Hapus session dan token CSRF untuk keamanan total
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}