<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $fillable = ['user_id', 'nisn', 'kelas', 'jurusan', 'pembimbing_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pengajuanPkls()
    {
        return $this->hasMany(PengajuanPkl::class);
    }

    public function laporanHarians()
    {
        return $this->hasMany(LaporanHarian::class);
    }

    public function laporanAkhirs()
    {
        return $this->hasMany(LaporanAkhir::class);
    }

    public function jadwalSidangs()
    {
        return $this->hasMany(JadwalSidang::class);
    }

    public function nilaiPkls()
    {
        return $this->hasOne(NilaiPkl::class);
    }

    public function sertifikat()
    {
        return $this->hasOne(Sertifikat::class);
    }

    public function pembimbing()
    {
        return $this->belongsTo(Guru::class, 'pembimbing_id');
    }
}
