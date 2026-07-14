<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

/**
 * Model User
 * Merepresentasikan tabel 'users' di database.
 * Model ini digunakan untuk proses Autentikasi (Login/Register).
 */
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    // Menggunakan trait HasRoles dari package Spatie untuk manajemen hak akses (role & permission)
    use HasFactory, Notifiable, HasRoles;

    /**
     * $fillable menentukan kolom mana saja yang boleh diisi secara massal (mass assignment).
     * Contoh saat menggunakan User::create([...])
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * $hidden menentukan kolom mana saja yang akan disembunyikan
     * saat model di-convert menjadi bentuk array atau JSON (misal di API).
     * Sangat penting menyembunyikan password demi keamanan.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     * $casts digunakan untuk mengubah otomatis tipe data dari kolom database.
     * Contoh: 'password' => 'hashed' berarti password akan otomatis di-hash oleh framework saat disimpan.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relasi One-to-One dengan model Siswa.
     * Artinya: Satu akun user maksimal hanya bisa terhubung ke satu data profil siswa.
     */
    public function siswa()
    {
        return $this->hasOne(Siswa::class);
    }

    /**
     * Relasi One-to-One dengan model Guru.
     * Artinya: Satu akun user maksimal hanya bisa terhubung ke satu data profil guru.
     */
    public function guru()
    {
        return $this->hasOne(Guru::class);
    }
}
