<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('gurus', function (Blueprint $table) {
            $table->id();
            // Relasi ke tabel users (Guru login menggunakan data dari users)
            // onDelete('cascade') berarti jika akun user dihapus, data profil guru ini ikut terhapus.
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Nomor Induk Pegawai (bisa kosong / null jika guru tersebut belum memiliki NIP)
            $table->string('nip')->unique()->nullable();
            $table->timestamps(); // Membuat kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gurus');
    }
};
