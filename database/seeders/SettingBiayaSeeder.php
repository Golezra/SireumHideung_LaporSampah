<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SettingBiaya;

class SettingBiayaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data default untuk biaya per liter
        SettingBiaya::create([
            'biaya_organik'    => 25,     // Rp 25 per liter
            'biaya_anorganik'  => 12.5,   // Rp 12.5 per liter
            'biaya_campuran'   => 50,     // Rp 50 per liter
            'biaya_pengurangan'=> 0,      // Tidak ada pengurangan biaya
            'is_active'        => 1,      // Status aktif
        ]);
    }
}
