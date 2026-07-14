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
        Schema::create('laporan_harians', function (Blueprint $table) {
            $table->id();
            // Siapa siswa yang membuat laporan harian ini
            $table->foreignId('siswa_id')->constrained('siswas')->onDelete('cascade');
            
            // Tanggal pelaksanaan kegiatan PKL
            $table->date('tanggal');
            
            // Deskripsi kegiatan yang dilakukan pada hari itu
            $table->text('kegiatan');
            
            // Path ke bukti foto kegiatan (disimpan lokal di server)
            $table->string('bukti_foto')->nullable();
            $table->timestamps(); // Membuat kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_harians');
    }
};
