<?php

namespace App\Http\Controllers\Admin;

use App\Models\LaporSampah;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Notifications\LaporanDitolakNotification;
use Barryvdh\DomPDF\Facade\Pdf;

class ValidasiController extends Controller
{
    public function index()
    {
        $laporan = \App\Models\LaporSampah::with(['user', 'metodeBayar'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.validasi.index', compact('laporan'));
    }

    /**
     * Memfilter laporan sampah berdasarkan bulan dan tahun.
     */
    public function filter(Request $request)
    {
        // Filter data validasi berdasarkan bulan dan tahun
        // Ambil parameter bulan dan tahun dari request
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');

        // Query untuk mengambil laporan sampah beserta data pengguna
        $query = LaporSampah::with('user');

        // Filter laporan berdasarkan bulan jika parameter 'bulan' diisi
        if ($bulan) {
            $query->whereMonth('created_at', $bulan);
        }

        // Filter laporan berdasarkan tahun jika parameter 'tahun' diisi
        if ($tahun) {
            $query->whereYear('created_at', $tahun);
        }

        // Ambil data laporan berdasarkan filter
        $laporan = $query->get();

        // Kirim data laporan ke view 'admin.validasi.index'
        return view('admin.validasi.index', compact('laporan'));
    }

    public function cetakPdf(Request $request)
    {
        // Ambil filter bulan dan tahun jika ada
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');

        // Query laporan
        $query = \App\Models\LaporSampah::with('user');

        if ($bulan) {
            $query->whereMonth('created_at', $bulan);
        }
        if ($tahun) {
            $query->whereYear('created_at', $tahun);
        }

        $laporan = $query->get();

        // Jika ingin menyesuaikan data yang dikirim ke PDF, lakukan di sini

        // Render PDF
        $pdf = Pdf::loadView('admin.validasi.pdf', compact('laporan'))
            ->setPaper('A4', 'landscape');

        return $pdf->download('laporan-validasi.pdf');
    }
    
    /**
     * Memvalidasi laporan sampah dan mengubah status menjadi 'diproses'.
     */
    public function validasi($id)
    {
        // Cari laporan berdasarkan ID
        $laporan = LaporSampah::findOrFail($id);
        // Ubah status laporan menjadi 'diproses'
        if ($laporan->status_lapor !== 'diproses') {
            
            $laporan->status_lapor = 'diproses'; 
            $laporan->save(); // Simpan perubahan status laporan

            return redirect()->back()->with('success', 'Laporan berhasil divalidasi!');
        }
        
        // Jika laporan sudah divalidasi sebelumnya, kembalikan dengan pesan error
        return redirect()->back()->with('error', 'Laporan sudah divalidasi sebelumnya!');
    }
    
    /**
     * Menolak laporan sampah dan mengirim notifikasi ke pembuat laporan.
     */
    public function tolak(Request $request, $id)
    {
        // Cari laporan berdasarkan ID
        $laporan = \App\Models\LaporSampah::findOrFail($id);
        // Ubah status laporan menjadi 'ditolak'
        $laporan->status_lapor = 'ditolak';
        $laporan->save();

        // Kirim alasan langsung dari request, tidak perlu simpan ke database
        $user = $laporan->user;
        $user->notify(new LaporanDitolakNotification($laporan, $request->input('alasan')));

        return redirect()->back()->with('success', 'Laporan berhasil ditolak!');
    }
}
