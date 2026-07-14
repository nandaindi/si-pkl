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
        Schema::create('jadwal_sidangs', function (Blueprint $table) {
            $table->id();
            // Siswa yang akan disidang
            $table->foreignId('siswa_id')->constrained('siswas')->onDelete('cascade');
            // Guru yang bertugas menguji (relasi ke tabel gurus)
            $table->foreignId('penguji_id')->constrained('gurus')->onDelete('cascade');
            // Guru yang membimbing siswa tersebut (disimpan di sini agar query lebih mudah tanpa join jauh)
            $table->foreignId('pembimbing_id')->constrained('gurus')->onDelete('cascade');
            
            // Waktu pelaksanaan sidang (tanggal dan jam)
            $table->dateTime('waktu');
            // Ruangan tempat sidang berlangsung
            $table->string('ruangan');
            $table->timestamps(); // Membuat kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_sidangs');
    }
};
