<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman form login.
     * 
     * Method ini dipanggil ketika user mengakses rute GET '/login'.
     * Fungsi utamanya adalah me-return (menampilkan) file view/tampilan 
     * login yang berada di folder resources/views/auth/login.blade.php
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Memproses data login yang dikirim oleh user dari form.
     * 
     * Method ini dipanggil ketika user men-submit form login (POST request).
     */
    public function login(Request $request)
    {
        // 1. Validasi input dari user
        // Memastikan email dan password harus diisi, dan format email valid.
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 2. Mencoba melakukan proses autentikasi (login)
        // Auth::attempt akan mengecek apakah email dan password cocok dengan data di database (tabel users).
        // Parameter kedua $request->boolean('remember') digunakan untuk fitur "Remember Me" (biar login terus).
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            // 3. Jika login berhasil, regenerate session untuk keamanan (mencegah session fixation attack)
            $request->session()->regenerate();

            // 4. Arahkan user ke halaman dashboard (atau halaman yang ingin diakses sebelum login)
            return redirect()->intended('/dashboard');
        }

        // 5. Jika login gagal (email/password salah), kembalikan ke halaman sebelumnya (form login)
        // Sambil membawa pesan error dan mengembalikan input email agar user tidak perlu mengetik ulang.
        return back()
            ->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])
            ->onlyInput('email');
    }

    /**
     * Memproses logout (keluar dari aplikasi).
     */
    public function logout(Request $request)
    {
        // 1. Menghapus data autentikasi user saat ini
        Auth::logout();

        // 2. Menghapus (invalidate) semua data yang ada di session
        $request->session()->invalidate();

        // 3. Membuat ulang CSRF token untuk keamanan form agar tidak bisa dibajak
        $request->session()->regenerateToken();

        // 4. Arahkan user kembali ke halaman utama atau halaman login
        return redirect('/');
    }
}
