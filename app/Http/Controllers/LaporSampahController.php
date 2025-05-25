<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\LaporSampah;
use App\Models\SettingBiaya;
use App\Models\User;
use App\Models\MetodeBayar;

class LaporSampahController extends Controller
{
    // Tampilkan form laporan sampah
    public function create()
    {
        $settingBiaya = SettingBiaya::where('is_active', 1)->first();
        return view('halaman.lapor-sampah.create', compact('settingBiaya'));
    }

    // Proses simpan laporan sampah
    public function store(Request $request)
    {
        $request->validate([
            'lokasi_sampah' => 'required',
            'keterangan_lokasi' => 'required|string',
            'jenis_sampah' => 'required|in:organik,anorganik,campuran',
            'volume_sampah' => 'required|numeric|min:0.1',
            'foto_sampah' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Ambil data biaya yang aktif
        $settingBiaya = SettingBiaya::where('is_active', 1)->first();
        if (!$settingBiaya) {
            return back()->with('error', 'Tidak ada data biaya yang aktif!');
        }

        // Simpan foto sampah
        $fotoPath = $request->file('foto_sampah')->store('foto_sampah', 'public');

        // Hitung nominal sesuai jenis sampah
        $volume = $request->volume_sampah;
        $jenis = $request->jenis_sampah;
        $nominal = 0;

        if ($jenis === 'organik') {
            $nominal = $volume * $settingBiaya->biaya_organik; // Ambil biaya organik dari tabel setting_biayas
        } elseif ($jenis === 'anorganik') {
            $nominal = $volume * $settingBiaya->biaya_anorganik; // Ambil biaya anorganik dari tabel setting_biayas
        } elseif ($jenis === 'campuran') {
            $nominal = $volume * $settingBiaya->biaya_campuran; // Ambil biaya campuran dari tabel setting_biayas
        }

        // Simpan ke tabel lapor_sampahs
        $laporSampah = LaporSampah::create([
            'user_id' => Auth::id(),
            'lokasi_sampah' => $request->lokasi_sampah,
            'keterangan_lokasi' => $request->keterangan_lokasi,
            'jenis_sampah' => $jenis,
            'volume_sampah' => $volume,
            'nominal' => $nominal, // Nominal dihitung dari tabel setting_biayas
            'foto_sampah' => $fotoPath,
            'status_bayar' => 'belum lunas',
            'status_lapor' => 'pending',
            'setting_biaya_id' => $settingBiaya->id, // Simpan ID setting biaya yang aktif
        ]);

        // Simpan ke tabel metode_bayars
        $metodeBayar = MetodeBayar::create([
            'user_id' => Auth::id(),
            'lapor_sampah_id' => $laporSampah->id,
            'order_id' => 'ORD-' . strtoupper(uniqid()), // Generate order ID unik
            'keterangan' => 'Pembayaran untuk laporan sampah',
            'nominal' => $nominal, // Nominal yang sama dengan laporan sampah
            'metode_bayar' => 'belum dipilih', // Default metode bayar
            'jenis_sampah' => $jenis,
            'status_sampah' => 'pending',
        ]);

        // Perbarui kolom metode_bayar_id di tabel lapor_sampahs
        $laporSampah->update([
            'metode_bayar_id' => $metodeBayar->id,
        ]);

        // Update jumlah_lapor di tabel users
        $user = Auth::user();
        $user->increment('jumlah_lapor');

        return redirect()->route('pembayaran.daftar-bayar')->with('success', 'Laporan sampah berhasil dikirim! Silakan lakukan pembayaran.');
    }

    public function edit($id)
    {
        $laporan = \App\Models\LaporSampah::findOrFail($id);
        $notification = auth()->user()->notifications->firstWhere('data.laporan_id', $id);
        $settingBiaya = \App\Models\SettingBiaya::where('is_active', 1)->first();

        return view('halaman.lapor-sampah.edit', compact('laporan', 'notification', 'settingBiaya'));
        
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'lokasi_sampah' => 'required|string|max:255',
            'keterangan_lokasi' => 'required|string|max:255',
            'jenis_sampah' => 'required|string|in:organik,anorganik,campuran',
            'volume_sampah' => 'required|numeric|min:0.1',
            'foto_sampah' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Cari laporan berdasarkan ID
        $laporan = LaporSampah::findOrFail($id);

        // Update data laporan
        $laporan->lokasi_sampah = $request->lokasi_sampah;
        $laporan->keterangan_lokasi = $request->keterangan_lokasi;
        $laporan->jenis_sampah = $request->jenis_sampah;
        $laporan->volume_sampah = $request->volume_sampah;

        // Jika ada file foto baru, simpan dan update
        if ($request->hasFile('foto_sampah')) {
            $file = $request->file('foto_sampah');
            $filename = time() . '_' . $file->getClientOriginalName();
            $fotoPath = $request->file('foto_sampah')->store('foto_sampah', 'public');
            $laporan->foto_sampah = 'img/foto-sampah/' . $filename;
        }

        // Ubah status laporan menjadi "pending" setelah diedit
        $laporan->status_lapor = 'pending';

        $laporan->save();

        return redirect()->route('pesan-masuk')->with('success', 'Laporan berhasil diperbarui. Terima kasih!');
    }
}
