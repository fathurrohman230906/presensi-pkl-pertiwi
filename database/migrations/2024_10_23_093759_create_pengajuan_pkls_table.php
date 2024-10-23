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
            $table->id('pengajuanID');
            $table->foreignId('nis')->constrained('siswa', 'nis')->onDelete('cascade');
            $table->foreignId('perusahaanID')->constrained('perusahaan', 'perusahaanID')->onDelete('cascade');
            $table->date('bulan_masuk');
            $table->date('bulan_keluar');
            $table->enum('status_pengajuan', ['diterima', 'ditolak', 'ditunggu']);
            $table->timestamps();
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
