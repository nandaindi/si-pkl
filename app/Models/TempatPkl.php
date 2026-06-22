<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TempatPkl extends Model
{
    protected $fillable = ['nama_instansi', 'jurusan', 'alamat', 'kuota', 'gambar'];

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
                $formattedWord = ucwords($lowerWord);
            }
            $formattedWords[] = $formattedWord;
        }
        return implode(' ', $formattedWords);
    }

    public function getRawNamaInstansiAttribute()
    {
        return $this->attributes['nama_instansi'] ?? '';
    }

    public function pengajuanPkls()
    {
        return $this->hasMany(PengajuanPkl::class);
    }
}
