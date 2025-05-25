<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\LaporSampah;

class RiwayatLaporController extends Controller
{
    public function index(Request $request)
    {
        // Ambil user yang sedang login
        $user = Auth::user();

        // Filter laporan berdasarkan bulan (jika ada)
        $laporan = \App\Models\LaporSampah::with('metodeBayar')
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('halaman.lapor-sampah.riwayat-lapor-sampah', compact('laporan'));
    }

    public function ubahStatus($id, $status)
    {
        $laporan = \App\Models\LaporSampah::findOrFail($id);
        $laporan->status_lapor = $status;
        $laporan->save();

        return redirect()->back()->with('success', 'Status laporan berhasil diubah.');
    }
}
