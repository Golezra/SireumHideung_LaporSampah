<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use App\Models\LaporSampah;
use App\Models\User;

class TimOperasionalController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        return view('tim-operasional.dashboard');
    }

    public function laporanMenunggu(Request $request)
    {
        $query = LaporSampah::with('user')
            ->where('status_lapor', 'diproses')
            ->orderBy('created_at', 'desc');

        // Filter by pelapor jika ada
        if ($request->filled('pelapor')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->pelapor . '%');
            });
        }

        $laporan = $query->get();
        return view('tim-operasional.laporan-menunggu', compact('laporan'));
    }

    public function laporanDiangkut(Request $request)
    {
        $query = LaporSampah::with(['user', 'metodebayar'])
            ->where('status_lapor', 'diangkut')
            ->orderBy('created_at', 'desc');

        // Filter by tanggal jika ada
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $laporan = $query->get();
        return view('tim-operasional.laporan-diangkut', compact('laporan'));
    }

    public function penagihanTunai(Request $request)
    {
        $query = \App\Models\LaporSampah::with('user')
            ->where('status_lapor', 'diangkut')
            ->where('status_bayar', 'menunggu ditagih')
            ->whereHas('metodeBayar', function ($q) {
                $q->where('metode_bayar', 'tunai');
            });

        if ($request->filled('pelapor')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->pelapor . '%');
            });
        }

        $laporanTunai = $query->get();

        return view('tim-operasional.penagihan-tunai', compact('laporanTunai'));
    }

    public function autocompletePelapor(Request $request)
    {
        $query = $request->get('query');
        $results = [];

        if ($query) {
            $results = \App\Models\User::where('name', 'like', '%' . $query . '%')
                ->select('name')
                ->limit(10)
                ->get();
        }

        return response()->json($results);
    }

    public function penagihanLunas($id, Request $request)
    {
        $laporan = \App\Models\LaporSampah::findOrFail($id);

        // Jika ingin update status_lapor, pastikan value-nya valid dan tidak kosong
        if ($request->filled('status_lapor')) {
            $laporan->status_lapor = $request->status_lapor;
        }

        // Update status_bayar pada tabel lapor_sampah saja
        $laporan->status_bayar = 'lunas';
        $laporan->save();

        return redirect()->back()->with('success', 'Status pembayaran berhasil diubah menjadi lunas.');
    }
}
