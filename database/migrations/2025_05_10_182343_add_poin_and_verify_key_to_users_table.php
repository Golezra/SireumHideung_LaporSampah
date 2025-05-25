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
        Schema::table('users', function (Blueprint $table) {
            $table->integer('poin')->default(0)->after('jumlah_lapor'); // Kolom poin dengan default 0
            $table->string('verify_key')->nullable()->after('email_verified_at'); // Kolom verify_key (opsional)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['poin', 'verify_key']);
        });
    }
};
