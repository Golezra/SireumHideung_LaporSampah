<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\LaporSampah;
use App\Models\Transaction;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // Total user
        $totalUsers = User::count();

        // Contoh: Hitung session aktif (jika ada field last_login_at)
        $activeSessions = User::whereNotNull('last_login_at')->count();

        // Laporan pending
        $pendingReports = LaporSampah::where('status_lapor', 'pending')->count();

        // Total berat sampah
        $totalSampah = LaporSampah::sum('volume_sampah');

        // Laporan menunggu diangkut
        $waitingToBePickedUp = LaporSampah::where('status_lapor', 'menunggu diangkut')->count();

        // Laporan belum lunas
        $unpaidReports = LaporSampah::where('status_bayar', 'belum lunas')->count();

        // Aktivitas terbaru (misal 10 terakhir)
        $recentActivities = LaporSampah::with('user')
            ->orderByDesc('created_at')
            ->take(10)
            ->get();

        // Grafik: Sampah berdasarkan jenis
        $sampahByJenis = LaporSampah::select('jenis_sampah')
            ->selectRaw('SUM(volume_sampah) as total_volume')
            ->selectRaw('COUNT(*) as total_jenis')
            ->groupBy('jenis_sampah')
            ->get();

        // Grafik: Sampah berdasarkan waktu (per bulan)
        $sampahByWaktu = LaporSampah::selectRaw('MONTH(created_at) as bulan')
            ->selectRaw('SUM(volume_sampah) as total_volume')
            ->groupByRaw('MONTH(created_at)')
            ->orderBy('bulan')
            ->get();

        return view('admin.reports.index', compact(
            'totalUsers',
            'activeSessions',
            'pendingReports',
            'totalSampah',
            'waitingToBePickedUp',
            'unpaidReports',
            'recentActivities',
            'sampahByJenis',
            'sampahByWaktu'
        ));
    }
}
