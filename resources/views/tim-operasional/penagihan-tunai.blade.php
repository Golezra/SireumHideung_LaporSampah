@extends('layouts.app')

@section('title', 'Daftar Penagihan')

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
                    <p class="mb-0">Pengaturan</p>
                    <div class="btn-close" id="settingCardClose"></div>
                </div>
                <div class="single-setting-panel">
                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" id="darkSwitch">
                        <label class="form-check-label" for="darkSwitch">Mode Gelap</label>
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
                    <a href="{{ route('tim-operasional.dashboard') }}">
                        <i class="bi bi-arrow-left-short"></i>
                    </a>
                </div>
                <div class="page-heading">
                    <h6 class="mb-0">Daftar Penagihan Pembayaran Tunai</h6>
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
            <h4 class="mb-4">Daftar Penagihan Pembayaran Tunai</h4>

            <form method="GET" action="{{ route('tim-operasional.penagihan') }}" class="mb-3">
                <div class="input-group">
                    <input type="text" id="pelapor" name="pelapor" class="form-control" placeholder="Cari nama pelapor..." autocomplete="off">
                    <ul class="list-group position-absolute w-100" id="autocomplete-list" style="z-index:1000;"></ul>
                    <button class="btn btn-primary" type="submit">Cari</button>
                </div>
            </form>

            @if ($laporanTunai->isEmpty())
                <div class="alert alert-info" role="alert">
                    Tidak ada laporan dengan pembayaran tunai yang menunggu penagihan.
                </div>
            @else
                <div class="list-group">
                    @foreach ($laporanTunai as $laporan)
                    <div class="list-group-item shadow-sm mb-3">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <strong class="mb-1">Nama Pelapor: {{ $laporan->user->name ?? 'Tidak diketahui' }}</strong>
                                <p class="mb-1">
                                    <strong>Lokasi:</strong> {{ $laporan->keterangan_lokasi ?? 'Tidak diketahui' }}<br>
                                    <strong>Jenis Sampah:</strong> {{ ucfirst($laporan->jenis_sampah) }}<br>
                                    <strong>Berat Sampah:</strong> {{ $laporan->volume_sampah }} liter<br>
                                    <strong>Nominal Bayar:</strong> Rp. {{ number_format($laporan->metodeBayar->nominal ?? 0, 0, ',', '.') }}<br>
                                    <strong>Waktu Lapor:</strong> {{ $laporan->created_at->translatedFormat('d F Y H:i') }}
                                </p>
                            </div>
                            <div class="ms-3 text-end text-md-start">
                                <form action="{{ route('tim-operasional.penagihan.lunas', $laporan->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm w-100">Tandai Lunas</button>
                                </form>
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
            <!-- Footer Content -->
            @include('components.footer3')
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#pelapor-autocomplete').on('input', function () {
                let query = $(this).val();

                if (query.length > 2) {
                    $.ajax({
                        url: "{{ route('tim-operasional.autocomplete.pelapor') }}",
                        type: "GET",
                        data: { query: query },
                        success: function (data) {
                            let results = $('#autocomplete-results');
                            results.empty();

                            if (data.length > 0) {
                                results.show();
                                data.forEach(function (item) {
                                    results.append(`<li class="list-group-item">${item.name}</li>`);
                                });
                            } else {
                                results.hide();
                            }
                        }
                    });
                } else {
                    $('#autocomplete-results').hide();
                }
            });

            $(document).on('click', '#autocomplete-results li', function () {
                let selectedName = $(this).text();
                $('#pelapor-autocomplete').val(selectedName);
                $('#autocomplete-results').hide();
            });

            // Hide autocomplete when clicking outside
            $(document).on('click', function(e) {
                if (!$(e.target).closest('#pelapor-autocomplete, #autocomplete-results').length) {
                    $('#autocomplete-results').hide();
                }
            });
        });
    </script>

@endsection