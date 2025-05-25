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
        Schema::table('metode_bayars', function (Blueprint $table) {
            $table->unsignedBigInteger('lapor_sampah_id')->after('user_id'); // Tambahkan kolom lapor_sampah_id
            $table->foreign('lapor_sampah_id')->references('id')->on('lapor_sampahs')->onDelete('cascade'); // Relasi ke tabel lapor_sampahs
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('metode_bayars', function (Blueprint $table) {
            $table->dropForeign(['lapor_sampah_id']);
            $table->dropColumn('lapor_sampah_id');
        });
    }
};
