<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model TempatPkl
 * Menyimpan database daftar perusahaan/instansi tujuan PKL.
 */
class TempatPkl extends Model
{
    protected $fillable = ['nama_instansi', 'jurusan', 'alamat', 'kuota', 'gambar'];

    /**
     * Accessor (Mutator) Laravel: Mengubah/memformat data saat dibaca dari database.
     * Nama fungsi `getNamaInstansiAttribute` otomatis dijalankan ketika mengakses property $tempat->nama_instansi
     * Fungsi ini bertugas merapikan penulisan singkatan perusahaan seperti PT, CV, Tbk, dll.
     */
    public function getNamaInstansiAttribute($value)
    {
        if (!$value) {
            return $value;
        }
        $words = explode(' ', $value);
        $formattedWords = [];
        foreach ($words as $word) {
            $cleanWord = trim($word);
            $lowerWord = strtolower($cleanWord);
            $matchWord = rtrim($lowerWord, '.,');
            
            if (in_array($matchWord, ['pt', 'cv', 'tbk', 'pte', 'ltd', 'bumn', 'pns', 'tni', 'polri'])) {
                if ($matchWord === 'pt' || $matchWord === 'cv') {
                    $formattedWord = strtoupper($matchWord) . '.';
                } elseif ($matchWord === 'tbk') {
                    $formattedWord = 'Tbk' . (str_ends_with($cleanWord, '.') ? '' : '.');
                } elseif ($matchWord === 'ltd') {
                    $formattedWord = 'Ltd' . (str_ends_with($cleanWord, '.') ? '' : '.');
                } else {
                    $formattedWord = strtoupper($matchWord) . substr($cleanWord, strlen($matchWord));
                }
            } else {
                $formattedWord = ucwords($lowerWord); // Sisanya pakai huruf kapital di awal (Capitalize)
            }
            $formattedWords[] = $formattedWord;
        }
        return implode(' ', $formattedWords);
    }

    /**
     * Membaca nama instansi asli tanpa format/accessor tambahan.
     */
    public function getRawNamaInstansiAttribute()
    {
        return $this->attributes['nama_instansi'] ?? '';
    }

    /**
     * Relasi HasMany ke model PengajuanPkl.
     * Satu tempat PKL bisa dipilih oleh banyak pengajuan.
     */
    public function pengajuanPkls()
    {
        return $this->hasMany(PengajuanPkl::class, 'tempat_pkl_id');
    }

    /**
     * Custom Attribute (Accessor buatan):
     * Diakses dengan cara $tempat->sisa_kuota
     * Mengembalikan kuota awal dikurangi jumlah pengajuan yang sudah disetujui.
     */
    public function getSisaKuotaAttribute()
    {
        return $this->kuota - $this->pengajuanPkls()->where('status', 'disetujui')->count();
    }
}
