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
                <div class="card-body d-flex align-items-center flex-column flex-sm-row text-center text-sm-start">
                    <div class="user-profile mb-3 mb-sm-0 me-sm-3">
                        <img src="{{ asset(Auth::user()->foto_profil ?? 'img/foto-profil/default-fotoprofil.png') }}" alt="User Profile Picture" class="rounded-circle shadow" style="width: 80px; height: 80px; object-fit: cover;">
                    </div>
                    <div class="user-info">
                        <div class="d-flex align-items-center justify-content-center justify-content-sm-start flex-wrap">
                            <h5 class="text-white mb-1">{{ Auth::user()->name }}</h5>
                            <span class="badge bg-warning ms-2 rounded-pill">Tim Operasional</span>
                        </div>
                        <p class="mb-0">{{ Auth::user()->rt ?? 'Tidak diketahui' }}</p>
                    </div>
                </div>
            </div>

            <!-- Cards Row -->
            <div class="row g-3">
                <!-- Card: Laporan Menunggu Diangkut -->
                <div class="col-6 col-md-4">
                    <div class="card bg-dark bg-img h-100" style="background-image: url('{{ asset('img/core-img/1.png') }}');">
                        <div class="card-body text-center">
                            <i class="bi bi-clock-history text-warning" style="font-size: 2rem;"></i>
                            <h6 class="mt-3 card-title text-white">Menunggu Diangkut</h6>
                            <p class="text-muted small">Lihat laporan yang perlu diangkut.</p>
                            <a href="{{ route('tim-operasional.laporan.menunggu') }}" class="btn btn-sm btn-primary">Buka</a>
                        </div>
                    </div>
                </div>

                <!-- Card: Laporan Sudah Diangkut -->
                <div class="col-6 col-md-4">
                    <div class="card bg-dark bg-img h-100" style="background-image: url('{{ asset('img/core-img/2.png') }}');">
                        <div class="card-body text-center">
                            <i class="bi bi-check-circle text-success" style="font-size: 2rem;"></i>
                            <h6 class="mt-3 card-title text-white">Diangkut</h6>
                            <p class="text-muted small">Lihat laporan yang sudah diangkut.</p>
                            <a href="{{ route('tim-operasional.laporan.diangkut') }}" class="btn btn-sm btn-primary">Buka</a>
                        </div>
                    </div>
                </div>

                <!-- Card: Laporan Penagihan -->
                <div class="col-6 col-md-4">
                    <div class="card bg-dark bg-img h-100" style="background-image: url('{{ asset('img/core-img/1.png') }}');">
                        <div class="card-body text-center">
                            <i class="bi bi-cash-coin text-info" style="font-size: 2rem;"></i>
                            <h6 class="mt-3 text-white">Penagihan</h6>
                            <p class="text-muted small">Penagihan tunai dan lihat data yang penagihan.</p>
                            <a href="{{ route('tim-operasional.penagihan') }}" class="btn btn-sm btn-primary">Buka</a>
                        </div>
                    </div>
                </div>

                <!-- Card: Keluar Akun -->
                <div class="col-6 col-md-4">
                    <div class="card bg-dark bg-img h-100" style="background-image: url('{{ asset('img/core-img/1.png') }}');">
                        <div class="card-body text-center">
                            <i class="bi bi-box-arrow-right text-danger" style="font-size: 2rem;"></i>
                            <h6 class="mt-3 text-danger">Keluar Akun</h6>
                            <p class="text-muted small">Keluar dari akun Anda.</p>
                            <form action="{{ route('auth.logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger">Keluar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Nav -->
    <div class="footer-nav-area" id="footerNav">
        <div class="container px-0">
            @include('components.footer3')
        </div>
    </div>
@endsection
