<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    public function pesan()
    {
        $notifications = DatabaseNotification::orderBy('created_at', 'desc')->get();

        return view('admin.notifications.pesan', compact('notifications'));
    }

    public function pesanMasuk()
    {
        // Ambil notifikasi untuk user yang sedang login
        $notifications = auth()->user()->notifications()->orderBy('created_at', 'desc')->get();

        return view('notification.pesan-masuk', compact('notifications'));
    }

    public function create()
    {
        // Form kirim pesan
        return view('admin.notifications.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'role' => 'required|in:warga,tim-operasional',
            'content' => 'required|string|max:255',
        ]);

        // Ambil user sesuai role
        $users = \App\Models\User::where('role', $request->role)->get();

        // Kirim notifikasi ke setiap user (bisa menggunakan event, notification, atau simpan ke tabel notifikasi)
        foreach ($users as $user) {
            \DB::table('notifications')->insert([
                'user_id' => $user->id,
                'content' => $request->content,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $user->notify(new \App\Notifications\LaporanDitolakNotification($laporan, $alasan));
        }

        return redirect()->route('admin.notifications.create')->with('success', 'Pesan berhasil dikirim!');
    }

    public function handleNotification($id)
    {
        $laporan = \App\Models\LaporSampah::findOrFail($id);

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
        ]);
    }
}
