<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SettingBiaya;

class SettingsController extends Controller
{
    public function index()
    {
        // Ambil setting aktif terakhir
        $settingbiayas = SettingBiaya::orderBy('created_at', 'desc')->first();

        return view('admin.settings.index', compact('settingbiayas'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'biaya_organik' => 'required|numeric|min:0',
            'biaya_anorganik' => 'required|numeric|min:0',
            'biaya_campuran' => 'required|numeric|min:0',
        ]);

        // Nonaktifkan setting sebelumnya
        SettingBiaya::where('is_active', true)->update(['is_active' => false]);

        // Simpan setting baru
        $settingbiayas = SettingBiaya::create([
            'biaya_organik' => $request->biaya_organik,
            'biaya_anorganik' => $request->biaya_anorganik,
            'biaya_campuran' => $request->biaya_campuran,
            'is_active' => true,
        ]);

        return redirect()->route('admin.settings.index')->with('success', 'Biaya sampah berhasil diubah!');
    }
}
