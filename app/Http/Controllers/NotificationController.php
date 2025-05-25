<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function pesanMasuk()
    {
        $notifications = auth()->user()->notifications()->orderBy('created_at', 'desc')->get();

        // Filter hanya notifikasi yang laporan terkait status_lapor = 'ditolak'
        $notifications = $notifications->filter(function ($notification) {
            if (isset($notification->data['laporan_id'])) {
                $laporan = \App\Models\LaporSampah::find($notification->data['laporan_id']);
                // Mapping status agar bisa dipakai di Blade
                $notification->status = $laporan ? $laporan->status_lapor : null;
                return $laporan && $laporan->status_lapor === 'ditolak';
            }
            $notification->status = null;
            return false;
        });

        return view('notification.pesan-masuk', compact('notifications'));
    }

    /**
     * Mengambil notifikasi yang memiliki URL untuk edit laporan sampah.
     */
    public function getNotifikasiEditLaporan()
    {
        // Ambil semua notifikasi pengguna yang sedang login
        $notifications = auth()->user()->notifications;

        // Filter notifikasi yang memiliki URL untuk edit laporan sampah
        $filteredNotifications = $notifications->filter(function ($notification) {
            return isset($notification->data['url']) && str_contains($notification->data['url'], '/lapor-sampah/edit/');
        });

        // Kirim notifikasi yang difilter ke view
        return view('halaman.pesan-masuk', compact('filteredNotifications'));
    }

    public function handleNotification($id)
    {
        $laporan = \App\Models\LaporSampah::findOrFail($id);
        $notification = auth()->user()->unreadNotifications->firstWhere('data.laporan_id', $id);
        $settingBiaya = \App\Models\SettingBiaya::where('is_active', 1)->first();

        // Hanya izinkan edit jika status_lapor 'ditolak'
        if ($laporan->status_lapor !== 'ditolak') {
            return redirect()->route('pesan-masuk')->with('error', 'Laporan ini sudah diperbarui dan tidak dapat diakses lagi.');
        }

        // Tandai notifikasi sebagai dibaca
        $notification = auth()->user()->unreadNotifications->firstWhere('data.laporan_id', $id);
        if ($notification) {
            $notification->markAsRead();
        }

        // Redirect ke halaman edit laporan
        return view('halaman.lapor-sampah.edit', [
        'laporan' => $laporan,
        'notification' => $notification,
        'settingBiaya' => $settingBiaya,
    ]);
    }
}
