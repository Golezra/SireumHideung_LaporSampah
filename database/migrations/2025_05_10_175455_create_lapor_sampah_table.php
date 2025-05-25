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
        Schema::create('lapor_sampahs', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // FK ke users.id
            $table->foreignId('metode_bayar_id')->nullable()->constrained('metode_bayars')->onDelete('cascade'); // FK ke metode_bayars.id
            $table->foreignId('setting_biaya_id')->constrained('setting_biayas')->onDelete('cascade'); // FK ke setting_biayas.id
            $table->decimal('volume_sampah', 8, 2); // Volume sampah
            $table->string('lokasi_sampah'); // Lokasi sampah
            $table->string('foto_sampah')->nullable(); // Foto sampah (opsional)
            $table->string('jenis_sampah'); // Jenis sampah
            $table->enum('status_bayar', ['belum bayar', 'sudah bayar'])->default('belum bayar'); // Status pembayaran
            $table->enum('status_lapor', ['pending', 'diproses', 'selesai'])->default('pending'); // Status laporan
            $table->timestamps(); // created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lapor_sampahs');
    }
};
