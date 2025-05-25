<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\WargaController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\InsentifController;
use App\Http\Controllers\Admin\KeuanganController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\ValidasiController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\LaporSampahController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\RiwayatLaporController;
use App\Http\Controllers\MidtransController;
use App\Http\Controllers\TimOperasionalController;


Route::get('/', function () {
    return view('halaman.hero-blocks');
});

// Beranda
Route::get('/beranda', [BerandaController::class, 'index'])->name('beranda');

// Kebijakan Privasi
Route::get('/kebijakan-privasi', function () {
    return view('halaman.kebijakan-privasi');
})->name('kebijakan-privasi');

// Login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('auth.login-form');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

// Register
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('auth.register');
Route::post('/register', [AuthController::class, 'register'])->name('auth.register');

// Forget Password
Route::get('/forget-password', [AuthController::class, 'showForgetPasswordForm'])->name('auth.password.request');
Route::post('/forget-password', [AuthController::class, 'sendForgetPassword'])->name('auth.password.email');

// Reset Password
Route::get('/reset-password', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

// Change Password
Route::get('/change-password', [AuthController::class, 'showChangePasswordForm'])->name('auth.change-password-form');
Route::post('/change-password', [AuthController::class, 'changePassword'])->name('auth.change-password');

// Notifikasi verifikasi (tidak perlu login)
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->name('verification.notice');

// Proses klik link verifikasi
Route::get('/email/verify/{id}/{hash}', function ($id, $hash, Request $request) {
    $user = User::find($id);

    if (!$user) {
        abort(404, 'User tidak ditemukan.');
    }

    // Cek hash
    if (!hash_equals(sha1($user->getEmailForVerification()), $hash)) {
        abort(403, 'Link verifikasi tidak valid.');
    }

    // Jika sudah diverifikasi
    if ($user->hasVerifiedEmail()) {
        return redirect()->route('verification.success');
    }

    // Set email_verified_at
    $user->markEmailAsVerified();

    // Redirect ke halaman sukses
    return redirect()->route('verification.success');
})->name('verification.verify');

// Halaman sukses verifikasi
Route::get('/email/verified-success', function () {
    return view('auth.verified-success');
})->name('verification.success');

// Kirim ulang email verifikasi (opsional, jika ingin user bisa request ulang)
Route::post('/email/verification-notification', function (Request $request) {
    $user = \App\Models\User::where('email', $request->email)->first();
    if ($user) {
        $user->sendEmailVerificationNotification();
    }
    return back()->with('message', 'Link verifikasi telah dikirim ulang!');
})->name('verification.send');

//warga
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [WargaController::class, 'dashboard'])->name('warga.dashboard');
    Route::get('/edit-profil', [WargaController::class, 'editProfil'])->name('warga.edit-profil');
    Route::put('/edit-profil', [WargaController::class, 'updateProfil'])->name('warga.update-profil');
    Route::get('/lapor-sampah/create', [LaporSampahController::class, 'create'])->name('lapor-sampah.create');
    Route::post('/lapor-sampah', [LaporSampahController::class, 'store'])->name('lapor-sampah.store');
    Route::get('/lapor-sampah/edit/{id}', [LaporSampahController::class, 'edit'])->name('lapor-sampah.edit');
    Route::put('/lapor-sampah/update/{id}', [LaporSampahController::class, 'update'])->name('lapor-sampah.update');
    Route::get('/riwayat-lapor', [RiwayatLaporController::class, 'index'])->name('riwayat-lapor');
    Route::patch('/riwayat-lapor/ubah-status/{id}/{status}', [\App\Http\Controllers\RiwayatLaporController::class, 'ubahStatus'])->name('riwayat-lapor.ubah-status');
    // Daftar pembayaran
    Route::get('/pembayaran', [PembayaranController::class, 'daftarBayar'])->name('pembayaran.daftar-bayar');

    // Detail pembayaran non-tunai
    Route::get('/pembayaran/{id}', [PembayaranController::class, 'show'])->name('pembayaran.show');
    // Download PDF tagihan
    Route::get('/pembayaran/{id}/download-pdf', [PembayaranController::class, 'downloadPdf'])->name('pembayaran.download-pdf');
    
    // Proses pembayaran non-tunai
    Route::get('/pembayaran/non-tunai/{id}', [PembayaranController::class, 'createSnapToken'])->name('pembayaran.non-tunai');
    
    // Midtrans callback
    Route::post('/midtrans/callback', [PembayaranController::class, 'handleCallback'])->name('midtrans.callback');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/pembayaran/{id}', [PembayaranController::class, 'show'])->name('pembayaran.show');
    Route::get('/notification/pesan-masuk', [NotificationController::class, 'pesanMasuk'])->name('pesan-masuk');
    Route::get('/pesan-masuk/handle/{id}', [NotificationController::class, 'handleNotification'])->name('pesan-masuk.handle');
    Route::get('/pembayaran/tunai/{id}', [PembayaranController::class, 'showTunai'])->name('pembayaran.tunai');
    Route::post('/pembayaran/tunai/{id}', [PembayaranController::class, 'prosesTunai'])->name('pembayaran.tunai.proses');
});

Route::middleware(['auth', 'verified', 'can:admin-access'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
});

Route::middleware(['auth', 'can:admin-access'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::get('users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::get('insentif/add-poin', [InsentifController::class, 'addPoinForm'])->name('insentif.add-poin');
    Route::post('insentif/add-poin', [InsentifController::class, 'addPoin']);
    Route::get('insentif/autocomplete', [InsentifController::class, 'autocomplete'])->name('insentif.autocomplete');
    Route::get('keuangan', [KeuanganController::class, 'index'])->name('keuangan.index');
    Route::post('keuangan', [KeuanganController::class, 'store'])->name('keuangan.store');
    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('settings', [SettingsController::class, 'update'])->name('settings.update');
    Route::get('notifications', [NotificationController::class, 'pesan'])->name('notifications');
    Route::get('notifications/create', [NotificationController::class, 'create'])->name('notifications.create');
    Route::post('notifications', [NotificationController::class, 'store'])->name('notifications.store');
    Route::get('validasi', [ValidasiController::class, 'index'])->name('validasi.index');
    Route::get('validasi/filter', [ValidasiController::class, 'filter'])->name('validasi.filter');
    Route::get('validasi/cetak-pdf', [ValidasiController::class, 'cetakPdf'])->name('validasi.cetak-pdf');
    Route::post('validasi/{id}', [ValidasiController::class, 'validasi'])->name('validasi');
    Route::post('validasi/tolak/{id}', [ValidasiController::class, 'tolak'])->name('validasi.tolak');
});

Route::middleware(['auth', 'verified'])->prefix('tim-operasional')->name('tim-operasional.')->group(function () {
    Route::get('dashboard', [TimOperasionalController::class, 'dashboard'])->name('dashboard');
    Route::get('laporan/menunggu', [TimOperasionalController::class, 'laporanMenunggu'])->name('laporan.menunggu');
    Route::get('/autocomplete/pelapor', [\App\Http\Controllers\TimOperasionalController::class, 'autocompletePelapor'])->name('autocomplete.pelapor');
    Route::get('laporan/diangkut', [TimOperasionalController::class, 'laporanDiangkut'])->name('laporan.diangkut');
    Route::get('penagihan', [TimOperasionalController::class, 'penagihanTunai'])->name('penagihan');
    Route::post('penagihan/lunas/{id}', [TimOperasionalController::class, 'penagihanLunas'])->name('penagihan.lunas');
});

Route::get('/midtrans/snap-token/{id}', [MidtransController::class, 'createSnapToken'])->name('midtrans.snap-token');
Route::post('/midtrans/callback', [MidtransController::class, 'handleCallback'])->name('midtrans.callback');


