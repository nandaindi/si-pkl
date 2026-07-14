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
        Schema::table('pengajuan_pkls', function (Blueprint $table) {
            // Menghapus kolom file_surat_pengantar. 
            // Biasa dilakukan jika ada perubahan alur bisnis (misal suratnya tidak perlu diupload oleh siswa).
            $table->dropColumn('file_surat_pengantar');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengajuan_pkls', function (Blueprint $table) {
            $table->string('file_surat_pengantar')->nullable();
        });
    }
};
