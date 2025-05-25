@extends('layouts.app')

@section('title', 'Admin Reports')

@section('content')

<!-- Dark Mode Switching -->
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

<!-- RTL Mode Switching -->
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

<!-- Setting Popup -->
<div id="setting-popup-overlay"></div>
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
                <a href="{{ route('admin.dashboard') }}">
                    <i class="bi bi-arrow-left-short"></i>
                </a>
            </div>
            <div class="page-heading">
                <h6 class="mb-0">Laporan Admin</h6>
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

<!-- Page Content -->
<div class="page-content-wrapper py-3">
    <div class="container">
        <div class="element-heading">
            <p class="text-center">Sistem Informasi Pengelolaan Sampah</p>
            <p class="text-center">Berikut adalah laporan terbaru mengenai aktivitas pengelolaan sampah di sistem.</p>
        </div>
    </div>

    <div class="container">
        <div class="row g-3">
            <!-- Card: Total Users -->
            <div class="col-md-4">
                <div class="card bg-primary bg-img" style="background-image: url('{{ asset('img/core-img/2.png') }}');">
                    <div class="card-body text-center">
                        <i class="bi bi-cpu text-white mb-3 display-4"></i>
                        <h5 class="text-white">Total Users</h5>
                        <h3 class="text-white">{{ $totalUsers }}</h3>
                        <p class="text-white mb-0">Jumlah total pengguna yang terdaftar di sistem.</p>
                    </div>
                </div>
            </div>

            <!-- Card: Active Sessions -->
            <div class="col-md-4">
                <div class="card bg-success bg-img" style="background-image: url('{{ asset('img/core-img/2.png') }}');">
                    <div class="card-body text-center">
                        <i class="bi bi-person-check text-white mb-3 display-4"></i>
                        <h5 class="text-white">Pengguna Aktif</h5>
                        <h3 class="text-white">{{ $activeSessions }}</h3>
                        <p class="text-white mb-0">Jumlah login aktif saat ini di sistem.</p>
                    </div>
                </div>
            </div>

            <!-- Card: Total Lapor Sampah Pending -->
            <div class="col-md-4">
                <div class="card bg-warning bg-img" style="background-image: url('{{ asset('img/core-img/2.png') }}');">
                    <div class="card-body text-center">
                        <i class="bi bi-hourglass-split text-white mb-3 display-4"></i>
                        <h5 class="text-white">Sampah Pending</h5>
                        <h3 class="text-white">{{ $pendingReports }}</h3>
                        <p class="text-white mb-0">Jumlah laporan sampah yang belum divalidasi.</p>
                    </div>
                </div>
            </div>

            <!-- Card: Total Sampah Dilaporkan -->
            <div class="col-md-4">
                <div class="card bg-info bg-img" style="background-image: url('{{ asset('img/core-img/2.png') }}');">
                    <div class="card-body text-center">
                        <i class="bi bi-trash text-white mb-3 display-4"></i>
                        <h5 class="text-white">Volume Sampah Dilaporkan</h5>
                        <h3 class="text-white">{{ $totalSampah }} Liter</h3>
                        <p class="text-white mb-0">Jumlah total volume sampah yang telah dilaporkan oleh pengguna.</p>
                    </div>
                </div>
            </div>

            <!-- Card: Total Laporan Menunggu Diangkut -->
            <div class="col-md-4">
                <div class="card bg-secondary bg-img" style="background-image: url('{{ asset('img/core-img/2.png') }}');">
                    <div class="card-body text-center">
                        <i class="bi bi-truck text-white mb-3 display-4"></i>
                        <h5 class="text-white">Menunggu Diangkut</h5>
                        <h3 class="text-white">{{ $waitingToBePickedUp }}</h3>
                        <p class="text-white mb-0">Jumlah laporan sampah yang menunggu untuk diangkut.</p>
                    </div>
                </div>
            </div>

            <!-- Card: Total Laporan Belum Lunas -->
            <div class="col-md-4">
                <div class="card bg-danger bg-img" style="background-image: url('{{ asset('img/core-img/2.png') }}');">
                    <div class="card-body text-center">
                        <i class="bi bi-cash-coin text-white mb-3 display-4"></i>
                        <h5 class="text-white">Sampah Belum Lunas</h5>
                        <h3 class="text-white">{{ $unpaidReports }}</h3>
                        <p class="text-white mb-0">Jumlah laporan sampah dengan status bayar belum lunas.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Form -->
    <div class="container mt-4">
        <form action="{{ route('admin.reports.index') }}" method="GET" class="row g-3">
            <div class="col-md-4">
                <label for="month" class="form-label">Bulan</label>
                <select name="month" id="month" class="form-select">
                    <option value="">Semua Bulan</option>
                    @for ($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ request('month') == $i ? 'selected' : '' }}>
                            {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                        </option>
                    @endfor
                </select>
            </div>
            <div class="col-md-4">
                <label for="year" class="form-label">Tahun</label>
                <select name="year" id="year" class="form-select">
                    <option value="">Semua Tahun</option>
                    @foreach (range(date('Y'), 2025) as $year)
                        <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                            {{ $year }}
                        </option>
                    @endforeach
                    @foreach (range(2026, 2029) as $year)
                        <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                            {{ $year }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">Cari</button>
            </div>
        </form>
    </div>

    <!-- Charts -->
    <div class="container mt-4">
        <div class="element-heading text-center">
            <h6>Grafik Sampah Berdasarkan Jenis</h6>
        </div>
        <div class="card shadow-sm">
            <div class="card-body pb-2">
                <div class="chart-wrapper">
                    <div id="areaChart1" style="max-width: 100%; overflow-x: auto;"></div>
                </div>
            </div>
        </div>
    </div>
    <style>
        @media (max-width: 768px) {
            .chart-wrapper {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }
            #areaChart1 {
                min-width: 300px;
            }
        }
    </style>

    <div class="container mt-4">
        <div class="element-heading text-center">
            <h6>Grafik Sampah Berdasarkan Waktu</h6>
        </div>
        <div class="card shadow-sm">
            <div class="card-body pb-2">
                <div class="chart-wrapper">
                    <div id="areaChart2"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Aktivitas Terbaru Lapor-->
    <div class="container mt-4">
        <div class="element-heading">
            <p class="text-center">Laporan Aktivitas Terbaru</p>
            <p class="text-center">Berikut adalah laporan terbaru mengenai aktivitas pengelolaan sampah di sistem.</p>
        </div>
    </div>
    <div class="page-content-wrapper py-3">
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered w-100" id="dataTable">
                            <thead>
                                <tr>
                                    <th scope="col">Alamat</th>
                                    <th>Jenis Sampah</th>
                                    <th>Nama Warga</th>
                                    <th>Waktu Buat</th>
                                    <th>Status Bayar</th>
                                    <th>Status Sampah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($recentActivities as $activity)
                                    <tr>
                                        <td>{{ $activity->lokasi_sampah ?? 'Tidak diketahui' }}</td>
                                        <td>{{ ucfirst($activity->jenis_sampah) }} ({{ $activity->volume_sampah }} L)</td>
                                        <td>{{ $activity->user->name ?? 'Tidak diketahui' }}</td>
                                        <td>{{ $activity->created_at->translatedFormat('d F Y H:i:s') }}</td>
                                        <td>
                                            @if ($activity->status_bayar === 'belum lunas')
                                                <span class="badge bg-danger">Belum Lunas</span>
                                            @elseif ($activity->status_bayar === 'lunas')
                                                <span class="badge bg-success">Lunas</span>
                                            @else
                                                <span class="badge bg-secondary">Tidak Diketahui</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($activity->status_lapor === 'pending')
                                                <span class="badge bg-warning">Belum Divalidasi</span>
                                            @elseif ($activity->status_lapor === 'diangkut')
                                                <span class="badge bg-success">Diangkut</span>
                                            @else
                                                <span class="badge bg-secondary">Menunggu Diangkut</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<div class="footer-nav-area" id="footerNav">
    <div class="container px-0">
        @include('components.footer2')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    // Chart 1: Sampah Berdasarkan Jenis
    var options1 = {
        series: [
            @foreach ($sampahByJenis as $data)
                {{ $data->total_volume }}@if (!$loop->last),@endif
            @endforeach
        ],
        chart: { type: 'pie', height: 350 },
        labels: [
            @foreach ($sampahByJenis as $data)
                '{{ ucfirst($data->jenis_sampah) }} ({{ $data->total_jenis }} laporan)',
            @endforeach
        ],
        responsive: [{
            breakpoint: 480,
            options: {
                chart: { width: 200 },
                legend: { position: 'bottom' }
            }
        }],
        tooltip: {
            y: {
                formatter: function (val) {
                    return val + " Liter";
                }
            }
        }
    };
    var chart1 = new ApexCharts(document.querySelector("#areaChart1"), options1);
    chart1.render();

    // Chart 2: Sampah Berdasarkan Waktu
    var options2 = {
        series: [{
            name: 'Total Volume Sampah',
            data: [
                @foreach ($sampahByWaktu as $data)
                    {{ $data->total_volume }}@if (!$loop->last),@endif
                @endforeach
            ]
        }],
        chart: { type: 'line', height: 350 },
        xaxis: {
            categories: [
                @foreach ($sampahByWaktu as $data)
                    '{{ $data->bulan }}',
                @endforeach
            ],
            title: {
                text: 'Waktu (Bulan)'
            }
        },
        yaxis: {
            title: {
                text: 'Volume Sampah (Liter)'
            }
        },
        stroke: {
            curve: 'smooth'
        },
        markers: {
            size: 5,
            colors: ['#FFA41B'],
            strokeColors: '#fff',
            strokeWidth: 2
        },
        tooltip: {
            y: {
                formatter: function (val) {
                    return val + " Liter";
                }
            }
        },
        dataLabels: {
            enabled: true,
            style: {
                colors: ['#000'] // Change text color to black
            }
        }
    };
    var chart2 = new ApexCharts(document.querySelector("#areaChart2"), options2);
    chart2.render();
</script>

@endsection
