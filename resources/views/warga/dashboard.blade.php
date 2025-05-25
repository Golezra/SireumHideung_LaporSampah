@extends('layouts.app')

@section('title', 'SH | Warga')

@section('content')

    <!-- Header Area -->
    <div class="header-area" id="headerArea">
        @include('components.header-menu')
    </div>

    <!-- Sidenav Left -->
    <div class="offcanvas offcanvas-start" id="affanOffcanvas" data-bs-scroll="true" tabindex="-1"
    aria-labelledby="affanOffcanvsLabel">
    @include('components.sidenav-leaft')</div>
    
    <div class="page-content-wrapper py-3">
        <div class="container">
            <!-- User Information -->
            <div class="card user-info-card mb-3 text-center shadow p-3 mb-5 bg-white rounded">
                <div class="card-body d-flex flex-column align-items-center">
                    <div class="user-profile mb-3 ">
                        <img src="{{ asset(Auth::user()->foto_profil ?? 'img/foto-profil/default-fotoprofil.png') }}" alt="User Profile Picture"
                            class="rounded-circle shadow "
                            style="width: 80px; height: 80px; object-fit: cover; border: 2px solid #f8f9fa; cursor: pointer;"
                            data-bs-toggle="modal" data-bs-target="#profilePictureModal">
                    </div>
                    <div class="user-info">
                        <h5 class="mb-1">{{ Auth::user()->name }}</h5>
                        <span class="badge bg-warning ms-2 rounded-pill">Warga</span>
                        <p class="mb-0 mt-2 text-muted"><strong>{{ Auth::user()->rt }}</strong></p>
                    </div>
                </div>
                <div class="divider divider-center-icon border-light">
                    <i class="bi bi-recycle"></i>
                </div>
                <div class="d-flex justify-content-center align-items-center gap-3 mt-1 mb-2">
                    <div class="d-flex justify-content-center w-100 gap-5">
                        <div class="text-primary text-center" style="font-size: 0.9rem;">
                            <p class="text-primary mb-0"><strong><em> Jumlah Lapor: {{ Auth::user()->jumlah_lapor }}</em></strong></p>
                        </div>
                        <div class="text-success text-center" style="font-size: 0.9rem;">
                            <p class="text-success mb-0"><strong><em>Jumlah Poin: {{ number_format(Auth::user()->poin, 0, ',', '.') }}</strong></em></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Fitur  -->
            <div class="card mb-3 shadow-lg p-3">
                <div class="card-body direction-rtl">
                    <p class="mb-2">Pilihan Menu</p>

                    <div class="single-setting-panel">
                        <a href="{{ route('warga.edit-profil') }}">
                            <div class="icon-wrapper">
                                <i class="bi bi-person-circle"></i>
                            </div>
                            Edit Profil
                        </a>
                    </div>

                    <div class="single-setting-panel position-relative">
                        <a href="#">
                            <div class="icon-wrapper">
                                <i class="bi bi-chat-dots"></i>
                            </div>
                            Pesan Masuk
                            {{-- @if (Auth::check() && Auth::user()->unreadNotifications->count() > 0)
                                <span class="position-absolute top-0 start-30 translate-middle badge rounded-pill bg-danger">
                                    {{ Auth::user()->unreadNotifications->count() }}
                                    <span class="visually-hidden">unread messages</span>
                                </span>
                            @endif --}}
                        </a>
                    </div>

                    <div class="single-setting-panel">
                        <a href="{{ route('lapor-sampah.create') }}">
                            <div class="icon-wrapper">
                                <i class="bi bi-megaphone"></i>
                            </div>
                            Lapor Sampah
                        </a>
                    </div>

                    <div class="single-setting-panel">
                        <a href="{{ route('riwayat-lapor') }}">
                            <div class="icon-wrapper">
                                <i class="bi bi-clock-history"></i>
                            </div>
                            Riwayat Lapor
                        </a>
                    </div>

                    <div class="single-setting-panel">
                        <a href="{{ route('pembayaran.daftar-bayar') }}">
                            <div class="icon-wrapper">
                                <i class="bi bi-cash-coin"></i>
                            </div>
                            Pembayaran
                        </a>
                    </div>
                </div>
            </div>

            <!-- Card Bantuan -->
            <div class="card mb-3 shadow-lg p-3">
                <div class="card-body direction-rtl">
                    <p class="mb-2">Bantuan</p>

                    <div class="single-setting-panel">
                        <a href="https://wa.me/6285797879723" target="_blank">
                            <div class="icon-wrapper bg-success">
                                <i class="bi bi-whatsapp"></i>
                            </div>
                            Hubungi Kami di WhatsApp
                        </a>
                    </div>
                </div>
            </div>

            
            <!-- Card Kritik dan Saran -->
            <div class="card mb-3 shadow-lg p-3">
                <div class="card-body direction-rtl">
                    <p class="mb-2">Kritik dan Saran</p>
                    
                    <div class="single-setting-panel">
                        <a href="#">
                            <div class="icon-wrapper bg-info">
                                <i class="bi bi-chat-dots"></i>
                            </div>
                            Berikan masukan untuk perbaikan aplikasi
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Tombol Keluar Akun -->
        <div class="container">
            <div class="card-body text-center">
                <form action="{{ route('auth.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger d-flex align-items-center justify-content-center gap-2 shadow-sm"
                        style="font-size: 1rem; padding: 0.6rem 1rem; border-radius: 0.5rem; width: 100%;">
                        <i class="bi bi-escape"></i>
                        <span>Keluar Akun</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Modal untuk Foto Profil -->
        <div class="modal fade" id="profilePictureModal" tabindex="-1" aria-labelledby="profilePictureModalLabel"
            aria-hidden="true shadow-lg p-3 bg-white rounded">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="profilePictureModalLabel">Foto Profil</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <img src="{{ asset(Auth::user()->foto_profil ?? 'img/foto-profil/default-fotoprofil.png') }}" alt="User Profile Picture"
                            id="zoomableProfilePicture" class="img-fluid rounded-circle shadow"
                            style="max-width: 100%; cursor: zoom-in;">
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Nav -->
        <div class="footer-nav-area" id="footerNav">
            <div class="container px-0">
                <!-- Footer Content -->
                @include('components.footer')
            </div>
        </div>
    </div>
@endsection
