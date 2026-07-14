<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Menampilkan halaman/form untuk mengedit profil pengguna (nama, email, foto, dll).
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Menyimpan pembaruan informasi profil pengguna.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // 1. Mengisi data profil user dengan data dari form yang sudah divalidasi.
        $request->user()->fill($request->validated());

        // 2. Jika email diubah (isDirty), maka status verifikasi email harus di-reset menjadi null.
        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        // 3. Menangani proses upload foto profil (avatar) jika user memilih file baru.
        if ($request->hasFile('avatar')) {
            // Hapus file avatar lama jika ada di dalam folder 'public'.
            if ($request->user()->avatar) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($request->user()->avatar);
            }
            // Simpan file avatar baru ke dalam folder 'storage/app/public/avatars'.
            $request->user()->avatar = $request->file('avatar')->store('avatars', 'public');
        }

        // 4. Menyimpan perubahan ke database.
        $request->user()->save();

        return Redirect::route('profile.edit')->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Menghapus akun pengguna secara permanen.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // 1. Validasi keamanan: User harus memasukkan password saat ini dengan benar sebelum akun dapat dihapus.
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        // 2. Proses logout akun agar sesi web diakhiri.
        Auth::logout();

        // 3. Hapus data akun pengguna dari database secara permanen.
        $user->delete();

        // 4. Invalidate / hapus sesi dan token keamanan.
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // 5. Kembali ke halaman utama aplikasi.
        return Redirect::to('/');
    }
}
