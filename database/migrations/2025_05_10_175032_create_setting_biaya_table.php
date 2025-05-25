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
        Schema::create('setting_biayas', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->decimal('biaya_organik', 10, 2); // Biaya untuk sampah organik
            $table->decimal('biaya_anorganik', 10, 2); // Biaya untuk sampah anorganik
            $table->decimal('biaya_campuran', 10, 2); // Biaya untuk sampah campuran
            $table->decimal('biaya_pengurangan', 10, 2)->nullable(); // Biaya pengurangan (opsional)
            $table->boolean('is_active')->default(true); // Status aktif
            $table->timestamps(); // created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('setting_biayas');
    }
};
