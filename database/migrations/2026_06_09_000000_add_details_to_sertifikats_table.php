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
        Schema::table('sertifikats', function (Blueprint $table) {
            $table->string('file_sertifikat')->nullable()->change();
            $table->string('tempat_lahir')->nullable()->after('siswa_id');
            $table->date('tanggal_lahir')->nullable()->after('tempat_lahir');
            $table->date('tanggal_mulai')->nullable()->after('tanggal_lahir');
            $table->date('tanggal_selesai')->nullable()->after('tanggal_mulai');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sertifikats', function (Blueprint $table) {
            $table->string('file_sertifikat')->nullable(false)->change();
            $table->dropColumn(['tempat_lahir', 'tanggal_lahir', 'tanggal_mulai', 'tanggal_selesai']);
        });
    }
};
