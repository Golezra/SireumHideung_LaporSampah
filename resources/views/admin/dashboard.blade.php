@extends('layouts.app')

@section('content')
    <!-- Header Area -->
    <div class="header-area" id="headerArea">
        @include('components.header-menu')
    </div>

    <!-- Sidenav Left -->
    <div class="offcanvas offcanvas-start" id="affanOffcanvas" data-bs-scroll="true" tabindex="-1" aria-labelledby="affanOffcanvsLabel">
        @include('components.sidenav-leaft')
    </div>

    <div class="page-content-wrapper py-3">
        <div class="container">
            <!-- User Information -->
            <div class="card user-info-card card bg-dark mb-3" style="background-image: url('{{ asset('img/core-img/1.png') }}');">
                <div class="card-body d-flex align-items-center">
                    <div class="user-profile me-3">
                        <img src="{{ asset(Auth::user()->foto_profil ?? 'img/foto-profil/default-fotoprofil.png') }} " alt="User Profile Picture" class="rounded-circle shadow" style="width: 80px; height: 80px; object-fit: cover;">
                    </div>
                    <div class="user-info">
                        <div class="d-flex align-items-center">
                            <h5 class="text-white mb-1">{{ Auth::user()->name }}</h5>
                            <span class="badge bg-warning ms-2 rounded-pill">Admin</span>
                        </div>
                        <p class="mb-0">{{ Auth::user()->rt ?? 'Tidak diketahui' }}</p>
                    </div>
                </div>
            </div>

            <!-- Cards Row -->
            <div class="container">
                <div class="row g-3">
                    <!-- Card: Pengguna -->
                    <div class="col-6 col-md-4">
                        <div class="card bg-dark bg-img" style="background-image: url('{{ asset('img/core-img/1.png') }}');">
                            <div class="card-body text-center">
                                <i class="bi bi-people text-danger mb-3 display-4"></i>
                                <h5 class="card-title text-white">Total Pengguna</h5>
                                <p class="text-muted small">Kelola semua pengguna yang terdaftar</p>
                                <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-primary">Buka</a>
                            </div>
                        </div>
                    </div>

                    <!-- Card: Laporan -->
                    <div class="col-6 col-md-4">
                        <div class="card bg-dark bg-img" style="background-image: url('{{ asset('img/core-img/2.png') }}');">
                            <div class="card-body text-center">
                                <i class="bi bi-bar-chart text-warning mb-3 display-4"></i>
                                <h5 class="card-title text-white">Laporan</h5>
                                <p class="text-muted small">Akses laporan dan analitik sistem</p>
                                <a href="{{ route('admin.reports.index') }}" class="btn btn-sm btn-primary">Buka</a>
                            </div>
                        </div>
                    </div>

                    <!-- Card: Manajemen Insentif -->
                    <div class="col-6 col-md-4">
                        <div class="card bg-dark bg-img" style="background-image: url('{{ asset('img/core-img/1.png') }}');">
                            <div class="card-body text-center">
                                <i class="bi bi-gift text-success mb-3 display-4"></i>
                                <h5 class="card-title text-white">Insentif</h5>
                                <p class="text-muted small">Kelola insentif berdasarkan laporan</p>
                                <a href="{{ route('admin.insentif.add-poin') }}" class="btn btn-sm btn-primary">Buka</a>
                            </div>
                        </div>
                    </div>

                    <!-- Card: Pengaturan -->
                    <div class="col-6 col-md-4">
                        <div class="card bg-dark bg-img" style="background-image: url('{{ asset('img/core-img/2.png') }}');">
                            <div class="card-body text-center">
                                <i class="bi bi-gear text-danger mb-3 display-4"></i>
                                <h5 class="card-title text-white">Pengaturan</h5>
                                <p class="text-muted small">Konfigurasi pengaturan aplikasi</p>
                                <a href="{{ route('admin.settings.index') }}" class="btn btn-sm btn-primary">Buka</a>
                            </div>
                        </div>
                    </div>

                    <!-- Card: Validasi Lapor Sampah -->
                    <div class="col-6 col-md-4">
                        <div class="card bg-dark bg-img" style="background-image: url('{{ asset('img/core-img/1.png') }}');">
                            <div class="card-body text-center position-relative">
                                <i class="bi bi-check-circle text-success mb-3 display-4"></i>
                                <h5 class="card-title text-white">Validasi Lapor</h5>
                                <p class="text-muted small">Kelola dan validasi laporan sampah dari warga</p>
                                <a href="{{ route('admin.validasi.index') }}" class="btn btn-sm btn-primary position-relative">
                                    Buka
                                    @if($pendingCount > 0)
                                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                            {{ $pendingCount }}
                                        </span>
                                    @endif
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Card: Notifikasi -->
                    <div class="col-6 col-md-4">
                        <div class="card bg-dark bg-img" style="background-image: url('{{ asset('img/core-img/2.png') }}');">
                            <div class="card-body text-center">
                                <i class="bi bi-bell text-warning mb-3 display-4"></i>
                                <h5 class="card-title text-white">Notifikasi</h5>
                                <p class="text-muted small">Lihat dan kelola notifikasi pengguna</p>
                                <a href="{{ route('admin.notifications') }}" class="btn btn-sm btn-primary">Buka</a>
                            </div>
                        </div>
                    </div>

                    <!-- Card: Berita -->
                    <div class="col-6 col-md-4">
                        <div class="card bg-dark bg-img" style="background-image: url('{{ asset('img/core-img/1.png') }}');">
                            <div class="card-body text-center">
                                <i class="bi bi-newspaper text-info mb-3 display-4"></i>
                                <h5 class="card-title text-white">Berita</h5>
                                <p class="text-muted small">Tetap terupdate dengan berita dan pengumuman terbaru</p>
                                <a href="#" class="btn btn-sm btn-primary">Buka</a>
                            </div>
                        </div>
                    </div>

                    <!-- Card: Keuangan -->
                    <div class="col-6 col-md-4">
                        <div class="card bg-dark bg-img" style="background-image: url('{{ asset('img/core-img/2.png') }}');">
                            <div class="card-body text-center">
                                <i class="bi bi-cash-coin text-success mb-3 display-4"></i>
                                <h5 class="card-title text-white">Keuangan</h5>
                                <p class="text-muted small">Lihat dan Kelola pemasukan serta pengeluaran sistem</p>
                                <a href="{{ route('admin.keuangan.index') }}" class="btn btn-sm btn-primary">Buka</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container mt-4">
            <!-- Logout Button -->
            <form action="{{ route('auth.logout') }}" method="POST">
            @csrf
            <div class="card user-info-card card bg-dark mb-3" style="background-image: url('{{ asset('img/core-img/1.png') }}');">
                <button type="submit" class="card-body d-flex justify-content-between align-items-center border-0 bg-transparent">
                <span class="text-danger fw-bold">Keluar Akun</span>
                <i class="bi bi-box-arrow-right text-danger" style="font-size: 1.5rem;"></i>
                </button>
            </div>
            </form>
        </div>
    </div>

    <!-- Footer Nav -->
    <div class="footer-nav-area" id="footerNav">
        <div class="container px-0">
            @include('components.footer2')
        </div>
    </div>
@endsection
