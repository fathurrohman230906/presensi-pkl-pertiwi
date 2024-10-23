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
        Schema::create('kegiatan_pkl', function (Blueprint $table) {
            $table->id('kegiatanID');
            $table->string('deskripsi_kegiatan');
            $table->date('tgl_kegiatan');
            $table->foreignId('nis')->constrained('siswa', 'nis')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kegiatan_pkl');
    }
};
