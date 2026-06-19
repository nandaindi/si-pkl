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
        Schema::table('laporan_harians', function (Blueprint $table) {
            $table->index(['siswa_id', 'status']);
        });

        Schema::table('pengajuan_pkls', function (Blueprint $table) {
            $table->index(['siswa_id', 'status']);
        });

        Schema::table('jadwal_sidangs', function (Blueprint $table) {
            $table->index(['siswa_id', 'pembimbing_id', 'penguji_id']);
        });

        Schema::table('laporan_akhirs', function (Blueprint $table) {
            $table->index(['siswa_id', 'status_verifikasi']);
        });

        Schema::table('siswas', function (Blueprint $table) {
            $table->index('pembimbing_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('laporan_harians', function (Blueprint $table) {
            $table->dropIndex(['siswa_id', 'status']);
        });

        Schema::table('pengajuan_pkls', function (Blueprint $table) {
            $table->dropIndex(['siswa_id', 'status']);
        });

        Schema::table('jadwal_sidangs', function (Blueprint $table) {
            $table->dropIndex(['siswa_id', 'pembimbing_id', 'penguji_id']);
        });

        Schema::table('laporan_akhirs', function (Blueprint $table) {
            $table->dropIndex(['siswa_id', 'status_verifikasi']);
        });

        Schema::table('siswas', function (Blueprint $table) {
            $table->dropIndex(['pembimbing_id']);
        });
    }
};
