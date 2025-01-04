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
        Schema::create('presensi', function (Blueprint $table) {
            $table->id('presensiID');
            $table->foreignId('nis')->constrained('siswa', 'nis')->onDelete('cascade');
            $table->foreignId('perusahaanID')->constrained('perusahaan', 'perusahaanID')->onDelete('cascade');
            $table->date('tgl_presensi');
            $table->time('masuk');
            $table->time('pulang');
            $table->enum('status_presensi', ['hadir', 'sakit', 'izin']);
            $table->string('keterangan');
            $table->string('foto')->nullable();
            $table->string('latitude');
            $table->string('longitude');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presensi');
    }
};
