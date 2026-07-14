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
        Schema::create('pengajuan_pkls', function (Blueprint $table) {
            $table->id();
            // Relasi ke tabel siswas: Menyimpan ID siswa yang melakukan pengajuan
            $table->foreignId('siswa_id')->constrained('siswas')->onDelete('cascade');
            
            // Relasi ke tabel tempat_pkls: Menyimpan ID tempat PKL yang dituju
            $table->foreignId('tempat_pkl_id')->constrained('tempat_pkls')->onDelete('cascade');
            
            // Status persetujuan pengajuan, default-nya menunggu persetujuan pembimbing (pending)
            $table->enum('status', ['pending', 'disetujui', 'ditolak'])->default('pending');
            $table->string('file_surat_pengantar')->nullable();
            $table->timestamps(); // Membuat kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_pkls');
    }
};
