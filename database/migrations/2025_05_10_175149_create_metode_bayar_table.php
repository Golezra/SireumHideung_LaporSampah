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
        Schema::create('metode_bayars', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // FK ke users.id
            $table->string('order_id')->unique(); // ID order pembayaran
            $table->text('keterangan')->nullable(); // Keterangan tambahan
            $table->decimal('nominal', 10, 2); // Nominal pembayaran
            $table->string('metode_bayar'); // Nama metode pembayaran
            $table->string('jenis_sampah'); // Jenis sampah
            $table->enum('status_sampah', ['pending', 'selesai'])->default('pending'); // Status sampah
            $table->timestamps(); // created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('metode_bayars');
    }
};
