<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model Siswa
 * Merepresentasikan tabel 'siswas' di database.
 */
class Siswa extends Model
{
    /**
     * $fillable menentukan kolom-kolom yang dapat diisi secara massal (mass assignment).
     */
    protected $fillable = ['user_id', 'nisn', 'kelas', 'jurusan', 'pembimbing_id'];

    /**
     * Relasi BelongsTo ke model User.
     * Artinya: Setiap data siswa merupakan milik dari satu User (akun).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi HasMany ke model PengajuanPkl.
     * Artinya: Satu siswa dapat memiliki banyak data pengajuan PKL (misal jika pernah ditolak, bisa mengajukan lagi).
     */
    public function pengajuanPkls()
    {
        return $this->hasMany(PengajuanPkl::class);
    }

    /**
     * Relasi HasMany ke model LaporanHarian.
     * Artinya: Satu siswa dapat mengisi banyak laporan harian (setiap hari selama masa PKL).
     */
    public function laporanHarians()
    {
        return $this->hasMany(LaporanHarian::class);
    }

    /**
     * Relasi HasMany ke model LaporanAkhir.
     * Artinya: Satu siswa dapat mengumpulkan lebih dari satu revisi laporan akhir (atau banyak file laporan).
     */
    public function laporanAkhirs()
    {
        return $this->hasMany(LaporanAkhir::class);
    }

    /**
     * Relasi HasMany ke model JadwalSidang.
     * Artinya: Jadwal sidang siswa (bisa ada jadwal utama dan ulangan/revisi).
     */
    public function jadwalSidangs()
    {
        return $this->hasMany(JadwalSidang::class);
    }

    /**
     * Relasi HasOne ke model NilaiPkl.
     * Artinya: Satu siswa hanya memiliki satu rangkuman nilai PKL final.
     */
    public function nilaiPkls()
    {
        return $this->hasOne(NilaiPkl::class);
    }

    /**
     * Relasi HasOne ke model Sertifikat.
     * Artinya: Satu siswa hanya akan mendapatkan satu sertifikat setelah selesai PKL.
     */
    public function sertifikat()
    {
        return $this->hasOne(Sertifikat::class);
    }

    /**
     * Relasi BelongsTo ke model Guru (dengan foreign key pembimbing_id).
     * Artinya: Setiap siswa dibimbing oleh satu Guru Pembimbing.
     */
    public function pembimbing()
    {
        return $this->belongsTo(Guru::class, 'pembimbing_id');
    }
}
