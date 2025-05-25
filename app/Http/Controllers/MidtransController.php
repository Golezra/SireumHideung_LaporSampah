<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LaporSampah;
use App\Models\MetodeBayar;
use Midtrans\Snap;
use Illuminate\Support\Facades\Auth;
use App\Mail\PembayaranBerhasilMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class MidtransController extends Controller
{
    public function createSnapToken($id)
    {
        \Midtrans\Config::$serverKey = config('services.midtrans.server_key');
        \Midtrans\Config::$isProduction = config('services.midtrans.is_production');
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        // Ambil data metode bayar
        $metodeBayar = MetodeBayar::with('laporSampah.settingBiaya', 'laporSampah.user')->findOrFail($id);

        $nominal = $metodeBayar->nominal;

        // Ambil data laporan sampah dari relasi
        $laporan = $metodeBayar->laporSampah;

        // Ambil data pengguna yang sedang login
        $user = Auth::user();

        // Ambil biaya dari tabel setting_biayas
        $settingBiaya = $laporan->settingBiaya;

        if (!$settingBiaya) {
            abort(404, 'Biaya tidak ditemukan.');
        }

        // Hitung total pembayaran berdasarkan jenis sampah
        $total = 0;
        if ($laporan->jenis_sampah === 'organik') {
            $total = $laporan->volume_sampah * $settingBiaya->biaya_organik;
        } elseif ($laporan->jenis_sampah === 'anorganik') {
            $total = $laporan->volume_sampah * $settingBiaya->biaya_anorganik;
        } elseif ($laporan->jenis_sampah === 'campuran') {
            $total = $laporan->volume_sampah * $settingBiaya->biaya_campuran;
        }

        // Hitung nominal setelah potongan poin
        $finalNominal = $total;
        if ($user->poin > 0) {
            $finalNominal = max(0, $total - ($user->poin * $settingBiaya->biaya_pengurangan));
        }

        // Buat parameter transaksi
        $params = [
            'transaction_details' => [
                'order_id' => $metodeBayar->order_id,
                'gross_amount' => (int) $finalNominal,
            ],
            'customer_details' => [
                'first_name' => $metodeBayar->user->name,
                'email' => $metodeBayar->user->email,
            ],
        ];

        // Generate Snap Token
        $snapToken = \Midtrans\Snap::getSnapToken($params);

        // Ambil nominal dari tabel metode_bayars
        $nominal = $metodeBayar->nominal;
        

        // Kirim data ke view
        return view('halaman.pembayaran.non-tunai', compact('metodeBayar', 'laporan', 'snapToken', 'user', 'total', 'nominal', 'finalNominal'));
    }

    public function handleNotification(Request $request)
    {
        Log::info('Notifikasi diterima:', $request->all());

        // Konfigurasi Midtrans
        $serverKey = config('midtrans.server_key');
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        // Validasi signature key
        if ($hashed !== $request->signature_key) {
            Log::error('Signature key tidak valid');
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        Log::info('Signature key valid');

        // Ambil status transaksi dan order_id
        $transactionStatus = $request->transaction_status;
        $orderId = $request->order_id;

        Log::info('Order ID:', ['order_id' => $orderId]);
        Log::info('Status Transaksi:', ['status' => $transactionStatus]);

        // Cari laporan berdasarkan order_id
        $laporan = LaporSampah::where('order_id', $orderId)->first();

        if (!$laporan) {
            Log::error('Laporan tidak ditemukan untuk order_id: ' . $orderId);
            return response()->json(['message' => 'Laporan tidak ditemukan'], 404);
        }

        Log::info('Laporan ditemukan:', ['laporan_id' => $laporan->id]);

        // Perbarui status pembayaran berdasarkan status transaksi
        if ($transactionStatus === 'capture' || $transactionStatus === 'settlement') {
            \App\Models\Transaction::where('lapor_sampah_id', $laporan->id)
                ->update(['status_bayar' => 'lunas']);

            // Kirim email ke user
            $user = $laporan->user; // Pastikan relasi user ada di model LaporSampah
            if ($user && $user->email) {
                Log::info('Akan mengirim email ke: ' . ($user ? $user->email : 'user null'));
                Mail::to($user->email)->send(new PembayaranBerhasilMail($user, $laporan));
            }
        } elseif ($transactionStatus === 'pending') {
            \App\Models\Transaction::where('lapor_sampah_id', $laporan->id)
                ->update(['status_bayar' => 'menunggu']);
        } elseif ($transactionStatus === 'deny' || $transactionStatus === 'expire' || $transactionStatus === 'cancel') {
            \App\Models\Transaction::where('lapor_sampah_id', $laporan->id)
                ->update(['status_bayar' => 'gagal']);
        }

        $laporan->save();

        Log::info('Status pembayaran diperbarui untuk order_id: ' . $orderId . ' dengan status: ' . $transactionStatus);

        return response()->json(['message' => 'Notifikasi berhasil diproses'], 200);
    }

    public function callback(Request $request)
    {
        $serverKey = config('midtrans.server_key');
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if ($hashed === $request->signature_key) {
            if ($request->transaction_status === 'settlement') {
                // Pembayaran berhasil
                return app(PembayaranController::class)->handlePaymentSuccess($request);
            }
        }

        return response()->json(['message' => 'Invalid signature'], 403);
    }
}
