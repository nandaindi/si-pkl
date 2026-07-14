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
        Schema::create('tempat_pkls', function (Blueprint $table) {
            $table->id();
            $table->string('nama_instansi');
            $table->text('alamat');
            // Jumlah maksimal siswa yang bisa diterima di tempat PKL ini. 
            // Default 0 artinya tempat tersebut baru, belum dikonfigurasi kuotanya.
            $table->integer('kuota')->default(0);
            $table->timestamps(); // Membuat kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tempat_pkls');
    }
};
