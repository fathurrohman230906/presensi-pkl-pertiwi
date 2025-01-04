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
        Schema::create('wali_kelas', function (Blueprint $table) {
            $table->id('wali_kelasID');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('nm_lengkap');
            $table->enum('jk', ['L', 'P']);
            $table->string('agama');
            $table->foreignId('kelasID')->constrained('kelas', 'kelasID')->onDelete('cascade');
            $table->string('no_tlp');
            $table->string('foto');
            $table->text('alamat');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wali_kelas');
    }
};
