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
        Schema::create('siswas', function (Blueprint $table) {
            $table->id();
            // Relasi ke tabel users (Satu akun user memiliki satu profil siswa)
            // onDelete('cascade') berarti jika akun user dihapus, profil siswa ini ikut terhapus.
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Nomor Induk Siswa Nasional (harus unik, tidak boleh ada yang sama)
            $table->string('nisn')->unique();
            $table->string('kelas');
            $table->string('jurusan');
            $table->timestamps(); // Membuat kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswas');
    }
};
