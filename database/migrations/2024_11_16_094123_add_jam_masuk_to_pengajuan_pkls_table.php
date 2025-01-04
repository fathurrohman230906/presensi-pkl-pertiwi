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
            $table->time('jam_masuk')->nullable()->after('status_pengajuan');
            $table->time('jam_keluar')->nullable()->after('status_pengajuan');
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengajuan_pkls', function (Blueprint $table) {
            $table->dropColumn('jam_masuk');
            $table->dropColumn('jam_keluar');
        });
    }
};
