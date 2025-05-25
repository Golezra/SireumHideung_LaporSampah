@extends('layouts.app')

@section('title', 'Pembayaran Non-Tunai')

@section('content')

    <!-- Dark mode switching -->
    <div class="dark-mode-switching">
        <div class="d-flex w-100 h-100 align-items-center justify-content-center">
            <div class="dark-mode-text text-center">
                <i class="bi bi-moon"></i>
                <p class="mb-0">Switching to dark mode</p>
            </div>
            <div class="light-mode-text text-center">
                <i class="bi bi-brightness-high"></i>
                <p class="mb-0">Switching to light mode</p>
            </div>
        </div>
    </div>

    <!-- RTL mode switching -->
    <div class="rtl-mode-switching">
        <div class="d-flex w-100 h-100 align-items-center justify-content-center">
            <div class="rtl-mode-text text-center">
                <i class="bi bi-text-right"></i>
                <p class="mb-0">Switching to RTL mode</p>
            </div>
            <div class="ltr-mode-text text-center">
                <i class="bi bi-text-left"></i>
                <p class="mb-0">Switching to default mode</p>
            </div>
        </div>
    </div>

    <!-- Setting Popup Overlay -->
    <div id="setting-popup-overlay"></div>

    <!-- Setting Popup Card -->
    <div class="card setting-popup-card shadow-lg" id="settingCard">
        <div class="card-body">
            <div class="container">
                <div class="setting-heading d-flex align-items-center justify-content-between mb-3">
                    <p class="mb-0">Settings</p>
                    <div class="btn-close" id="settingCardClose"></div>
                </div>

                <div class="single-setting-panel">
                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" id="darkSwitch">
                        <label class="form-check-label" for="darkSwitch">Dark mode</label>
                    </div>
                </div>

                <div class="single-setting-panel">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="rtlSwitch">
                        <label class="form-check-label" for="rtlSwitch">RTL mode</label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Header Area -->
    <div class="header-area" id="headerArea">
        <div class="container">
            <!-- Header Content -->
            <div class="header-content position-relative d-flex align-items-center justify-content-between">
                <!-- Back Button -->
                <div class="back-button">
                    <a href="{{ asset('/home') }}">
                        <i class="bi bi-arrow-left-short"></i>
                    </a>
                </div>

                <!-- Page Title -->
                <div class="page-heading">
                    <h6 class="mb-0">Pembayaran Non-Tunai</h6>
                </div>

                <!-- Settings -->
                <div class="setting-wrapper">
                    <div class="setting-trigger-btn" id="settingTriggerBtn">
                        <i class="bi bi-gear"></i>
                        <span></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="page-content-wrapper py-3">
        <div class="container">
            <div class="card invoice-card shadow">
                <div class="card-body">
                    <div class="invoice-header d-flex align-items-center justify-content-between mb-4">
                        <div class="logo">
                            <img src="{{ asset('img/core-img/icon.png') }}" alt="Logo" class="img-fluid">
                        </div>
                        <div class="invoice-title text-center">
                            <h5>Tagihan Lapor Sampah</h5>
                        </div>
                    </div>
                    <div class="invoice-body">
                        <p class="mb-0">Terima kasih telah menggunakan layanan kami. Berikut adalah rincian pembayaran Anda:</p>
                        <p class="mb-0">Silakan lakukan pembayaran sesuai dengan rincian di bawah ini.</p>
                    </div>
                    <div class="invoice-table mt-4">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Jenis Sampah</th>
                                    <th>Volume</th>
                                    <th>Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ ucfirst($laporan->jenis_sampah) }}</td>
                                    <td>{{ $laporan->volume_sampah }} Liter</td>
                                    <td>Rp {{ number_format($nominal, 0, ',', '.') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="invoice-total mt-4 d-flex justify-content-between">
                        <h6>Total:</h6>
                        <h6>
                            @if ($user->poin > 0)
                                <span class="text-decoration-line-through">
                                    Rp {{ number_format($nominal, 0, ',', '.') }}
                                </span>
                                <br>
                                <h6 class="fz-14 text-end text-md-start">Menjadi: Rp {{ number_format($finalNominal, 0, ',', '.') }}</h6>
                            @else
                                Rp {{ number_format($nominal, 0, ',', '.') }}
                            @endif
                        </h6>
                    </div>
                    <!-- Spacer -->
                    <div class="mt-4"></div>

                    <!-- Invoice Info -->
                    <div class="row invoice-info mb-4">
                        <div class="col-6 text-start">
                            <h5 class="mb-1 fz-14">Sireum Hideung.</h5>
                            <p class="mb-0 fz-12"><strong>Poin Anda:</strong> {{ $user->poin }}</p>
                            <p class="mb-0 fz-12"><strong>Potongan:</strong> Rp. {{ number_format($user->poin * 1000, 0, ',', '.') }}</p>
                        </div>
                        <div class="col-6 text-end">
                            <h5 class="mb-1 fz-12"><strong>Pelapor:</strong> {{ $laporan->user->name }}</h5>
                            <p class="mb-0 fz-12"><strong>ID Tagihan:</strong> {{ $metodeBayar->order_id }}</p>
                            <p class="mb-0 fz-12"><strong>Tanggal Lapor:</strong> {{ $laporan->created_at->format('d-m-Y') }}</p>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <button id="pay-button" class="btn btn-primary">Bayar Sekarang</button>
                        <!-- Download Invoice -->
                        <div class="download-invoice fz-12">
                            <a class="btn btn-sm btn-primary me-2" href="{{ route('pembayaran.download-pdf', $laporan->id) }}">
                                <i class="bi bi-file-earmark-pdf"></i> PDF
                            </a>
                            <a class="btn btn-sm btn-light" href="#">
                                <i class="bi bi-printer"></i> Print
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Snap.js -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
    <script>
        document.getElementById('pay-button').addEventListener('click', function () {
            snap.pay('{{ $snapToken }}', {
                onSuccess: function(result) {
                    alert('Pembayaran berhasil!');
                    console.log(result);
                    window.location.href = '/riwayat-lapor';
                },
                onPending: function(result) {
                    alert('Menunggu pembayaran!');
                    console.log(result);
                },
                onError: function(result) {
                    alert('Pembayaran gagal!');
                    console.log(result);
                },
                onClose: function() {
                    alert('Anda menutup pembayaran!');
                }
            });
        });
    </script>
@endsection