@extends('layouts.app')

@section('title', 'SH | Beranda')

@section('content')
    <!-- Area Header -->
    <div class="header-area" id="headerArea">
        @include('components.header-menu')
    </div>

    <!-- Sidenav Kiri -->
    @auth
        <div class="offcanvas offcanvas-start" id="affanOffcanvas" data-bs-scroll="true" tabindex="-1" aria-labelledby="affanOffcanvsLabel">
            @include('components.sidenav-leaft')
        </div>
    @else
        <div class="offcanvas offcanvas-start" id="affanOffcanvas" data-bs-scroll="true" tabindex="-1" aria-labelledby="affanOffcanvsLabel">
            <div class="offcanvas-body d-flex flex-column justify-content-center align-items-center p-4">
                <p class="text-center mb-3">Silakan login terlebih dahulu</p>
                <a href="{{ route('auth.login-form') }}" class="btn btn-primary">
                    <i class="bi bi-box-arrow-in-right"></i> Masuk
                </a>
            </div>
        </div>
    @endauth

    <div class="page-content-wrapper">
        <!-- Sambutan -->
        @include('components.welcome-toast')

        <!-- Slider Utama -->
        <div class="tiny-slider-one-wrapper">
            <div class="tiny-slider-one">
                @foreach ([
                    ['img/bg-img/33.png', 'Lapor Sampah dengan Mudah', 'Gunakan aplikasi kami untuk melaporkan sampah di rumah Anda.'],
                    ['img/bg-img/34.png', 'Solusi Kebersihan Terbaik', 'Aplikasi ini membantu menjaga lingkungan tetap bersih dan sehat.'],
                    ['img/bg-img/35.jpg', 'Ayo Bergabung', 'Klik tombol "Pasang Sekarang" & jadilah bagian dari solusi kebersihan.'],
                    ['img/bg-img/35.jpg', 'Fitur Canggih', 'Nikmati fitur lengkap untuk mempermudah pengelolaan sampah.'],
                    ['img/bg-img/35.jpg', 'Ramah Lingkungan', 'Bersama kita wujudkan lingkungan yang lebih bersih dan hijau.']
                ] as $slide)
                    <div>
                        <div class="single-hero-slide bg-overlay" style="background-image: url('{{ $slide[0] }}')">
                            <div class="h-100 d-flex align-items-center text-center">
                                <div class="container">
                                    <h3 class="text-white mb-1">{{ $slide[1] }}</h3>
                                    <p class="text-white mb-4">{{ $slide[2] }}</p>
                                    <a class="btn btn-creative btn-warning" href="#">Pasang Sekarang</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="scroll-down-btn text-center">
            <a href="#nextSection" class="scroll-link">
                <i class="bi bi-chevron-down"></i>
            </a>
        </div>

        <div class="pt-3"></div>

        <!-- Kartu Fitur -->
        <div class="container direction-rtl">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row g-3">
                        @foreach ([
                            ['img/demo-img/bag.png', 'Siapkan Sampah'],
                            ['img/demo-img/digital.png', 'Membuat Laporan'],
                            ['img/demo-img/loan.png', 'Pilih Metode Bayar']
                        ] as $feature)
                            <div class="col-4">
                                <div class="feature-card mx-auto text-center">
                                    <div class="card mx-auto bg-gray">
                                        <img src="{{ $feature[0] }}" alt="">
                                    </div>
                                    <p class="mb-0">{{ $feature[1] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Fitur Tambahan -->
        <div class="container direction-rtl">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row g-3">
                        @foreach ([
                            ['img/demo-img/garbage-truck.png', 'Sampah di Angkut'],
                            ['img/demo-img/save.png', 'Mendapat Poin'],
                            ['img/demo-img/recycle.png', 'Sampah Diproses']
                        ] as $feature)
                            <div class="col-4">
                                <div class="feature-card mx-auto text-center">
                                    <div class="card mx-auto bg-gray">
                                        <img src="{{ $feature[0] }}" alt="">
                                    </div>
                                    <p class="mb-0">{{ $feature[1] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Ringkasan Keuangan -->
        <div class="container">
            <div class="card">
                <div class="card-body direction-rtl">
                    <h5 class="mb-3 text-center">Informasi Keuangan</h5>
                    <div class="row">
                        <div class="col-4">
                            <div class="single-counter-wrap text-center">
                                <i class="bi bi-arrow-up-circle-fill mb-2 text-success"></i>
                                <h4 class="mb-1 text-success">
                                    <span class="counter">{{ number_format($totalPemasukan, 0, ',', '.') }}</span>
                                </h4>
                                <p class="mb-0 fz-12">Total Pemasukan</p>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="single-counter-wrap text-center">
                                <i class="bi bi-arrow-down-circle-fill mb-2 text-danger"></i>
                                <h4 class="mb-1 text-danger">
                                    <span class="counter">{{ number_format($totalPengeluaran, 0, ',', '.') }}</span>
                                </h4>
                                <p class="mb-0 fz-12">Total Pengeluaran</p>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="single-counter-wrap text-center">
                                <i class="bi bi-wallet-fill mb-2 text-primary"></i>
                                <h4 class="mb-1 text-primary">
                                    <span class="counter">{{ number_format($saldoAkhir, 0, ',', '.') }}</span>
                                </h4>
                                <p class="mb-0 fz-12">Saldo Akhir</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-3"></div>

        <!-- Charts -->
        <div class="container mt-4">
            <div class="card shadow-sm">
                <div class="card-body pb-2">
                    <h5 class="mb-3 text-center">Grafik Sampah Berdasarkan Jenis</h5>
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

        <div class="pt-3"></div>

        <!-- Google Maps -->
        <div class="container">
            <div class="card">
                <div class="card-body direction-rtl">
                    <div class="google-maps">
                        <h5 class="mb-3 text-center">Wilayah Layanan</h5>
                        <iframe class="w-100" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3952.9019689861403!2d107.6106274!3d-6.3762693!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e696bceb80de31b%3A0x77fc53a83fede33e!2sGempolsari%2C%20Kec.%20Patokbeusi%2C%20Kabupaten%20Subang%2C%20Jawa%20Barat!5e0!3m2!1sen!2sid!4v1697021234567!5m2!1sen!2sid" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-3"></div>

        <!-- Ulasan Pelanggan -->
        <div class="container">
            <div class="card mb-3">
                <div class="card-body">
                    <h3>Ulasan Pengguna</h3>
                    <div class="testimonial-slide-three-wrapper">
                        <div class="testimonial-slide3 testimonial-style3">
                            @foreach ([
                                ['Aplikasi ini sangat membantu saya dalam melaporkan sampah di lingkungan sekitar. Prosesnya cepat dan mudah, serta saya mendapatkan poin yang bisa digunakan untuk berbagai keperluan. Terima kasih!', 'Budi Santoso, Warga RT 12'],
                                ['Saya sangat puas dengan aplikasi ini. Tidak hanya membantu menjaga kebersihan lingkungan, tetapi juga memberikan insentif berupa poin', 'Siti Aminah, Warga RT 12'],
                                ['Fitur-fitur di aplikasi ini sangat lengkap. Saya bisa melaporkan sampah dengan mudah', 'Dewi Lestari, Warga RT 13'],
                                ['Saya sangat merekomendasikan aplikasi ini. Proses pelaporan sampah sangat mudah, dan saya merasa lebih peduli terhadap kebersihan lingkungan', 'Nurul Hidayah, Warga RT 13']
                            ] as $review)
                                <div class="single-testimonial-slide">
                                    <div class="text-content">
                                        <span class="d-inline-block badge bg-warning mb-2">
                                            @for ($i = 0; $i < 5; $i++)
                                                <i class="bi bi-star-fill me-1"></i>
                                            @endfor
                                        </span>
                                        <h6 class="mb-2">{{ $review[0] }}</h6>
                                        <span class="d-block">{{ $review[1] }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-3"></div>

        <div class="container">
            <div class="card position-relative shadow-sm">
                <img class="card-img-top" src="img/bg-img/3.png" alt="">
            </div>
        </div>

        <div class="pt-3"></div>

        <!-- Partner's Logo -->
        <div class="container">
            <div class="element-heading">
                <h6>Partner</h6>
            </div>
        </div>

        <div class="container">
            <div class="card">
                <div class="card-body">
                    <div class="partner-logo-slide-wrapper">
                        <div class="partner-slide">
                            @foreach (range(1, 8) as $logo)
                                <div>
                                    <div class="card partner-slide-card border my-2 bg-white">
                                        <div class="card-body p-3">
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#logoModal" onclick="showImage('img/partner-img/{{ $logo }}.png')">
                                                <img src="img/partner-img/{{ $logo }}.png" alt="Partner Logo {{ $logo }}">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-3"></div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="logoModal" tabindex="-1" aria-labelledby="logoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logoModalLabel">Partner</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" src="" alt="Partner Logo" class="img-fluid">
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer-nav-area" id="footerNav">
        <div class="container px-0">
            @include('components.footer')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var options1 = {
                series: [
                    @foreach ($sampahByJenis as $data)
                        {{ $data->total_berat }},
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
                            return val + " KG";
                        }
                    }
                }
            };

            var chart1 = new ApexCharts(document.querySelector("#areaChart1"), options1);
            chart1.render();
        });

        function showImage(imageSrc) {
            document.getElementById('modalImage').src = imageSrc;
        }
    </script>
@endsection
