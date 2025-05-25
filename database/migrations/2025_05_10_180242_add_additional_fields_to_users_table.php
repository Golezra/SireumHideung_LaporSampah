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
            $table->string('phone_number')->nullable(); // Nomor telepon
            $table->enum('role', ['user', 'admin', 'koordinator', 'tim_operasional'])->default('user'); // Role dengan default 'user'
            $table->string('foto_profil')->nullable(); // Foto profil
            $table->string('rt')->nullable(); // RT (opsional)
            $table->string('nik')->unique()->nullable(); // NIK
            $table->integer('jumlah_lapor')->default(0); // Jumlah laporan dengan default 0
            $table->timestamp('last_login_at')->nullable()->after('email_verified_at'); // Waktu terakhir login
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone_number',
                'role',
                'foto_profil',
                'rt',
                'nik',
                'jumlah_lapor',
                'last_login_at',
            ]);
        });
    }
};
