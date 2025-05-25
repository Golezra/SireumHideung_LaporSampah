@extends('layouts.app')

@section('title', 'SH | Daftar Pembayaran')

@section('content')

    @include('components.alert')

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
            <div class="header-content position-relative d-flex align-items-center justify-content-between">
                <div class="back-button">
                    <a href="{{ asset('/home') }}">
                        <i class="bi bi-arrow-left-short"></i>
                    </a>
                </div>
                <div class="page-heading">
                    <h6 class="mb-0">Daftar Pembayaran Laporan Sampah</h6>
                </div>
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
            <div class="element-heading">
                <p class="mb-3 text-center">Silakan pilih metode pembayaran yang sesuai dengan kebutuhan Anda.</p>
            </div>
        </div>

        <div class="container">
            <div class="card">
            <div class="card-body">
                <div class="standard-tab">
                <ul class="nav rounded-lg mb-2 p-2 shadow-sm flex-column flex-sm-row" id="affanTabs1" role="tablist">
                    <li class="nav-item" role="presentation">
                    <button class="btn active w-100 mb-2 mb-sm-0" id="bootstrap-tab" data-bs-toggle="tab" data-bs-target="#bootstrap"
                        type="button" role="tab" aria-controls="bootstrap" aria-selected="true">Non-Tunai</button>
                    </li>
                    <li class="nav-item" role="presentation">
                    <button class="btn w-100" id="pwa-tab" data-bs-toggle="tab" data-bs-target="#pwa" type="button" role="tab"
                        aria-controls="pwa" aria-selected="false">Tunai</button>
                    </li>
                </ul>
                <div class="tab-content rounded-lg p-3 shadow-sm" id="affanTabs1Content">
                    <div class="tab-pane fade show active" id="bootstrap" role="tabpanel" aria-labelledby="bootstrap-tab">
                    <h6>Transfer</h6>
                    <p class="mb-0">Silakan tekan tombol "Bayar Non-Tunai" untuk melakukan pembayaran via Transfer (BRIlink, M-Banking, ShoopePay dll).</p>
                    </div>
                    <div class="tab-pane fade" id="pwa" role="tabpanel" aria-labelledby="pwa-tab">
                    <h6>Bayar di Tempat</h6>
                    <p class="mb-0">Jika Anda ingin melakukan pembayaran tunai/langsung ditempat, silakan tekan tombol "Tunai".</p>
                    </div>
                </div>
                </div>
            </div>
            </div>
        </div>

        <div class="container mt-4">
            @if ($laporanBelumLunas->isEmpty())
            <div class="col-12">
                <p class="text-center">Belum ada laporan pembayaran belum lunas.</p>
            </div>
            @else
            <div class="list-group">
                @foreach ($laporanBelumLunas as $laporan)
                <div class="list-group-item shadow-sm mb-3">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <strong class="mb-1">Nama Pelapor: {{ $laporan->user->name ?? 'Tidak diketahui' }}</strong>
                            <p class="mb-1">
                                <strong>Lokasi:</strong> {{ $laporan->laporSampah->keterangan_lokasi ?? 'Tidak diketahui' }}<br>
                                <strong>Jenis Sampah:</strong> {{ ucfirst($laporan->laporSampah->jenis_sampah) }}<br>
                                <strong>Volume Sampah:</strong> {{ $laporan->laporSampah->volume_sampah }} Liter<br>
                                <strong>Nominal Bayar:</strong> Rp. {{ number_format($laporan->nominal, 0, ',', '.') }}<br>
                                <strong>Waktu Lapor:</strong> {{ $laporan->created_at->translatedFormat('d F Y H:i') }}
                            </p>
                        </div>
                        <div class="ms-3">
                            <div class="d-flex flex-column flex-sm-row gap-2">
                                @if ($laporan->metode_bayar === 'tunai')
                                    <p class="text-success mb-0" style="font-size: 1rem; word-break: break-word;">
                                        <span class="d-block d-sm-inline text-success">Tunggu petugas kami untuk menagihnya,</span>
                                        <span class="d-block d-sm-inline text-success">terima kasih.</span>
                                    </p>
                                @else
                                    <a href="{{ route('pembayaran.show', $laporan->id) }}" class="btn btn-primary btn-sm mb-1 mb-sm-0">Non-Tunai</a>
                                    <a href="{{ route('pembayaran.tunai', $laporan->id) }}" class="btn btn-sm btn-warning">Tunai</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>

    <!-- Footer Nav -->
    <div class="footer-nav-area" id="footerNav">
        <div class="container px-0">
            @include('components.footer')
        </div>
    </div>

@endsection
