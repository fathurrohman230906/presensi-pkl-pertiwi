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
        Schema::create('pembimbing', function (Blueprint $table) {
            $table->id('pembimbingID');
            $table->string('email');
            $table->string('password');
            $table->string('nm_lengkap');
            $table->enum('jk', ['L', 'P']);
            $table->string('agama');
            $table->foreignId('jurusanID')->constrained('jurusan', 'jurusanID')->onDelete('cascade');
            $table->integer('no_tlp');
            $table->string('foto');
            $table->text('alamat');
            $table->enum('level', ['kepala program', 'pembimbing']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembimbing');
    }
};
