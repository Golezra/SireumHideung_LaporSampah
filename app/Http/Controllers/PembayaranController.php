<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LaporSampah;
use App\Models\MetodeBayar;
use Illuminate\Support\Facades\Auth;
use Midtrans\Snap;
use Illuminate\Support\Facades\Log;

class PembayaranController extends Controller
{
    // Menampilkan daftar pembayaran
    public function daftarBayar()
    {
        // Ambil data laporan yang belum lunas dari tabel metode_bayars
        $laporanBelumLunas = MetodeBayar::where('user_id', Auth::id())
            ->where('status_sampah', 'pending') // Status pembayaran belum selesai
            ->with('laporSampah') // Pastikan relasi ke tabel lapor_sampahs di-load
            ->orderBy('created_at', 'desc')
            ->get();

        return view('halaman.pembayaran.daftar-bayar', compact('laporanBelumLunas'));
    }

    // Menampilkan detail pembayaran non-tunai
    public function show($id)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Anda harus login untuk mengakses halaman ini.');
        }

        $metodeBayar = MetodeBayar::with('laporSampah.settingBiaya', 'laporSampah.user')->findOrFail($id);
        $laporan = $metodeBayar->laporSampah;

        if (!$laporan) {
            abort(404, 'Laporan sampah tidak ditemukan.');
        }

        $settingBiaya = $laporan->settingBiaya;
        if (!$settingBiaya) {
            abort(404, 'Biaya tidak ditemukan.');
        }

        $orderId = $metodeBayar->order_id;

        $total = 0;
        if ($laporan->jenis_sampah === 'organik') {
            $total = $laporan->volume_sampah * $settingBiaya->biaya_organik;
        } elseif ($laporan->jenis_sampah === 'anorganik') {
            $total = $laporan->volume_sampah * $settingBiaya->biaya_anorganik;
        } elseif ($laporan->jenis_sampah === 'campuran') {
            $total = $laporan->volume_sampah * $settingBiaya->biaya_campuran;
        }

        $finalNominal = $total;
        if ($user->poin > 0) {
            $finalNominal = max(0, $total - ($user->poin * 1000));
        }

        // Ambil nominal dari tabel metode_bayars
        $nominal = $metodeBayar->nominal;

        // === Tambahkan kode berikut untuk generate Snap Token ===
        $snapToken = null;
        if (config('midtrans.client_key')) {
            \Midtrans\Config::$serverKey = config('midtrans.server_key');
            \Midtrans\Config::$isProduction = config('midtrans.is_production');
            \Midtrans\Config::$isSanitized = config('midtrans.is_sanitized');
            \Midtrans\Config::$is3ds = config('midtrans.is_3ds');

            $params = [
                'transaction_details' => [
                    'order_id' => $orderId,
                    'gross_amount' => (int) $finalNominal,
                ],
                'customer_details' => [
                    'first_name' => $user->name,
                    'email' => $user->email,
                ],
            ];

            $snapToken = \Midtrans\Snap::getSnapToken($params);
        }
        // === END Tambahan ===

        return view('halaman.pembayaran.non-tunai', compact('metodeBayar', 'laporan', 'snapToken', 'user', 'nominal', 'finalNominal', 'total'));
    }

    // Menampilkan detail pembayaran tunai
    public function showTunai($id)
    {
        $metodeBayar = MetodeBayar::with('laporSampah.settingBiaya', 'laporSampah.user')->findOrFail($id);
        $laporan = $metodeBayar->laporSampah;
        $user = $laporan->user;
        $nominal = $metodeBayar->nominal;
        $finalNominal = $nominal;
        if ($user->poin > 0) {
            $finalNominal = max(0, $nominal - ($user->poin * 1000));
        }
        return view('halaman.pembayaran.tunai', compact('metodeBayar', 'laporan', 'user', 'nominal', 'finalNominal'));
    }
    
    // Proses pembayaran
    public function prosesTunai(Request $request, $id)
    {
        $metodeBayar = MetodeBayar::where('lapor_sampah_id', $id)->firstOrFail();
        $metodeBayar->update([
            'metode_bayar' => 'tunai',
        ]);
        $laporan = LaporSampah::findOrFail($id);
        $laporan->update([
            'status_bayar' => 'menunggu ditagih',
        ]);
        return redirect()->route('riwayat-lapor')->with('success', 'Pembayaran tunai berhasil!');
    }

    // Download PDF tagihan
    public function downloadPdf($id)
    {
        $laporan = LaporSampah::with('user')->findOrFail($id);

        // Generate PDF (gunakan library seperti DomPDF atau Snappy)
        $pdf = \PDF::loadView('halaman.pembayaran.pdf', compact('laporan'));

        return $pdf->download('tagihan-lapor-sampah-' . $laporan->id . '.pdf');
    }

    
}
