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
            $table->integer('total_setuju_kaprog')->defauld(0)->after('jam_masuk');
            $table->integer('total_setuju_pembimbing')->defauld(0)->after('jam_masuk');
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengajuan_pkls', function (Blueprint $table) {
            $table->dropColumn('total_setuju_kaprog');
            $table->dropColumn('total_setuju_pembimbing');
        });
    }
};
