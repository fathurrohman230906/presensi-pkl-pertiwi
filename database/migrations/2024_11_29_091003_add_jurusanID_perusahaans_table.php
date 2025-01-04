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
        Schema::table('perusahaan', function (Blueprint $table) {
            $table->foreignId('jurusanID')->nullable()->constrained('jurusan', 'jurusanID')->onDelete('cascade')->after('deskripsi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('perusahaan', function (Blueprint $table) {
            $table->dropForeign(['jurusanID']); // Hapus foreign key
            $table->dropColumn('jurusanID');   // Hapus kolom
        });
    }
};
