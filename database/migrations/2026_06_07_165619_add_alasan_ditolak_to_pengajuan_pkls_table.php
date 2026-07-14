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
            // Kolom untuk menyimpan alasan / keterangan jika pengajuan tempat PKL ditolak oleh pembimbing
            $table->text('alasan_ditolak')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengajuan_pkls', function (Blueprint $table) {
            $table->dropColumn('alasan_ditolak');
        });
    }
};
