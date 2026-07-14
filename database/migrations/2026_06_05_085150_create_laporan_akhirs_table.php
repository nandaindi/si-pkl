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
        Schema::create('laporan_akhirs', function (Blueprint $table) {
            $table->id();
            // Laporan akhir milik siswa siapa
            $table->foreignId('siswa_id')->constrained('siswas')->onDelete('cascade');
            
            // Path file laporan PDF yang diupload (biasanya disimpan di storage framework/public)
            $table->string('file_laporan');
            
            // Status verifikasi laporan oleh pembimbing
            $table->enum('status_verifikasi', ['pending', 'disetujui', 'revisi'])->default('pending');
            
            // Jika status revisi, pembimbing bisa meninggalkan catatan/feedback di sini
            $table->text('catatan_pembimbing')->nullable();
            $table->timestamps(); // Membuat kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_akhirs');
    }
};
