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
        Schema::table('lapor_sampahs', function (Blueprint $table) {
            $table->string('keterangan_lokasi')->nullable()->after('lokasi_sampah'); // Tambahkan kolom keterangan_lokasi
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lapor_sampahs', function (Blueprint $table) {
            $table->dropColumn('keterangan_lokasi'); // Hapus kolom jika rollback
        });
    }
};
