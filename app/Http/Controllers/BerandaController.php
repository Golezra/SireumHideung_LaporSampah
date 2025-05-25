<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BerandaController extends Controller
{
    public function index()
    {
        // Data dummy, silakan ganti dengan query dari database sesuai kebutuhan
        $totalPemasukan = 100000;
        $totalPengeluaran = 50000;
        $saldoAkhir = 50000;
        $sampahByJenis = collect([
            (object)['jenis_sampah' => 'organik', 'total_berat' => 120, 'total_jenis' => 10],
            (object)['jenis_sampah' => 'anorganik', 'total_berat' => 80, 'total_jenis' => 7],
            (object)['jenis_sampah' => 'campuran', 'total_berat' => 50, 'total_jenis' => 5],
        ]);

        return view('halaman.beranda', compact('totalPemasukan', 'totalPengeluaran', 'saldoAkhir', 'sampahByJenis'));
    }
}
