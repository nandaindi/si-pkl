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
        Schema::create('nilai_pkls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswas')->onDelete('cascade');
            
            // Nilai dari Guru Pembimbing (berdasarkan progres jurnal dan laporan akhir)
            $table->float('nilai_pembimbing')->nullable();
            
            // Nilai dari Guru Penguji (berdasarkan performa saat presentasi sidang)
            $table->float('nilai_penguji')->nullable();
            
            // Nilai Akhir (biasanya rata-rata dari kedua nilai di atas)
            $table->float('nilai_akhir')->nullable();
            $table->timestamps(); // Membuat kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai_pkls');
    }
};
