<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Pengeluaran;
use App\Models\MetodeBayar;
use Carbon\Carbon;

class KeuanganController extends Controller
{
    public function index(Request $request)
    {
        $start = $request->start_date ? Carbon::parse($request->start_date)->startOfDay() : null;
        $end = $request->end_date ? Carbon::parse($request->end_date)->endOfDay() : null;

        // Query pemasukan dari LaporSampah (status_bayar = 'lunas')
        $query = \App\Models\LaporSampah::with(['user', 'metodeBayar']);
        $query->where('status_bayar', 'lunas');
        if ($start) $query->where('updated_at', '>=', $start);
        if ($end) $query->where('updated_at', '<=', $end);

        $transactions = $query->orderBy('updated_at', 'desc')->get();

        // Total pemasukan
        $totalLunas = $transactions->sum(function($item) {
            return $item->metodeBayar->nominal ?? 0;
        });

        // Query pengeluaran
        // $pengeluaranQuery = Pengeluaran::query();
        // if ($start) $pengeluaranQuery->where('created_at', '>=', $start);
        // if ($end) $pengeluaranQuery->where('created_at', '<=', $end);
        // $pengeluaran = $pengeluaranQuery->orderBy('created_at', 'desc')->get();

        // $totalPengeluaran = $pengeluaran->sum('nominal');
        // $totalSaldo = $totalLunas - $totalPengeluaran;

        return view('admin.keuangan.index', compact(
            'transactions',
            // 'pengeluaran',
            'totalLunas',
            // 'totalPengeluaran',
            // 'totalSaldo'
        ));
    }

    public function store(Request $request)
    {
        // Proses tambah transaksi pengeluaran/pemasukan
    }
}
