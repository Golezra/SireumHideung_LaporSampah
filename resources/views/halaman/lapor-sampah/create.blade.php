@extends('layouts.app')

@section('title', 'SH | Lapor sampah')

@section('content')

    @include('components.alert')

    <style>
        .image-wrapper {
            position: relative;
            display: inline-block;
            width: 250px;
            margin: 0 auto;
        }

        .image-wrapper img {
            width: 100%;
            height: auto;
            display: block;
        }

        .image-text {
            position: absolute;
            bottom: 10px;
            left: 50%;
            transform: translateX(-50%);
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 14px;
        }
    </style>

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

    <!-- Setting Popup -->
    <div id="setting-popup-overlay"></div>
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
                        <label class="form-check-label" for="rtlSwitch">Mode RTL</label>
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
                    <h6 class="mb-0">Melaporkan Sampah</h6>
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
            <div class="card">
                <div class="card-body">
                    <div class="text-center px-4">
                        <div class="image-wrapper">
                            <img class="login-intro-img" src="{{ asset('img/bg-img/41.png') }}" alt="Gambar Laporan Sampah">
                        </div>
                    </div>
                    <div class="element-heading text-center">
                        <h6>Isi Form Laporan Sampah</h6>
                    </div>
                    <form action="{{ route('lapor-sampah.store') }}" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
                        @csrf

                        <!-- Lokasi Sampah -->
                        <div class="form-group">
                            <label class="form-label" for="lokasi_sampah">Lokasi Sampah</label>
                            <div class="d-flex flex-wrap gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="rt12" name="lokasi_sampah" value="RT 12" required>
                                    <label class="form-check-label" for="rt12">RT 12</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="rt13" name="lokasi_sampah" value="RT 13" required>
                                    <label class="form-check-label" for="rt13">RT 13</label>
                                </div>
                            </div>
                            <small class="text-muted" style="opacity: 0.6;">
                                Pilih salah satu lokasi sampah yang sesuai
                                <span style="color: red;">*</span>
                            </small>
                        </div>

                        <!-- Keterangan Lokasi Sampah -->
                        <div class="form-group">
                            <label class="form-label" for="keterangan_lokasi">Keterangan Lokasi Sampah</label>
                            <input class="form-control" id="keterangan_lokasi" type="text" name="keterangan_lokasi" placeholder="Rumah Bapak/Ibu..." required>
                        </div>

                        <!-- Jenis Sampah -->
                        <div class="form-group">
                            <label class="form-label" for="jenis_sampah">Jenis Sampah</label>
                            <div class="d-flex flex-wrap gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="organik" name="jenis_sampah" value="organik" required>
                                    <label class="form-check-label" for="organik">Organik</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="anorganik" name="jenis_sampah" value="anorganik" required>
                                    <label class="form-check-label" for="anorganik">Anorganik</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="campuran" name="jenis_sampah" value="campuran" required>
                                    <label class="form-check-label" for="campuran">Campuran</label>
                                </div>
                            </div>
                            <small class="text-muted" style="opacity: 0.6;">
                                Pilih salah satu jenis sampah yang sesuai
                                <span style="color: red;">*</span>
                            </small>
                        </div>

                        <!-- Volume Sampah -->
                        <div class="form-group">
                            <label class="form-label" for="volume_sampah">Kapasitas Tempat Sampah (liter) :</label>
                            <div class="input-group">
                                <input class="form-control" id="volume_sampah" type="number" name="volume_sampah" min="0" step="0.1" required>
                                <div class="input-group-append">
                                    <span class="input-group-text">Liter</span>
                                </div>
                            </div>
                        </div>

                        <!-- Nominal yang Harus Dibayar -->
                        <div class="form-group">
                            <label class="form-label">Nominal yang Harus Dibayar</label>
                            <p id="nominalDisplay" class="text-success">Rp 0</p>
                            <small class="text-muted" style="opacity: 0.6;">
                                Nominal akan dihitung berdasarkan jenis dan volume liter tempat sampah
                                <span style="color: red;">*</span>
                            </small>
                        </div>

                        <!-- Foto Sampah -->
                        <div class="container">
                            <div class="card">
                                <div class="card-body py-5 text-center">
                                    <img class="w-75 mb-4" src="{{ asset('img/bg-img/ftosampah.png') }}" alt="">
                                    <h6 class="text-muted mb-4">Upload foto sampah yang jelas<span style="color: red;">*</span></h6>
                                    <div class="form-file">
                                        <input class="form-control d-none" id="foto_sampah" type="file" name="foto_sampah" accept="image/*" required>
                                        <label class="form-file-label justify-content-center" for="foto_sampah">
                                            <span class="form-file-button btn btn-danger d-flex align-items-center justify-content-center shadow-lg">
                                                <i class="bi bi-plus-circle me-2 fz-16"></i> Upload Foto Sampah
                                            </span>
                                        </label>
                                    </div>
                                    <h6 class="mt-4 mb-0" id="uploadStatus">Upload foto sampah yang jelas</h6>
                                    <small id="uploadHint">.jpg .png .jpeg</small>
                                    <script>
                                        document.getElementById('foto_sampah').addEventListener('change', function () {
                                            const fileInput = this;
                                            const uploadStatus = document.getElementById('uploadStatus');
                                            const uploadHint = document.getElementById('uploadHint');

                                            if (fileInput.files && fileInput.files[0]) {
                                                const file = fileInput.files[0];
                                                const validExtensions = ['image/jpeg', 'image/png', 'image/jpg'];

                                                if (validExtensions.includes(file.type)) {
                                                    uploadStatus.textContent = 'Foto berhasil diupload';
                                                    uploadStatus.classList.remove('text-danger');
                                                    uploadStatus.classList.add('text-success');
                                                    uploadHint.style.display = 'none';
                                                } else {
                                                    uploadStatus.textContent = 'Gagal upload, format file tidak didukung';
                                                    uploadStatus.classList.remove('text-success');
                                                    uploadStatus.classList.add('text-danger');
                                                    uploadHint.style.display = 'block';
                                                }
                                            }
                                        });
                                    </script>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button class="btn btn-primary w-100 d-flex align-items-center justify-content-center" type="submit">Laporkan</button>
                    </form>

                    <script>
                        function calculateNominal() {
                            const volume = parseFloat(document.getElementById('volume_sampah').value) || 0;
                            const jenis_sampah = document.querySelector('input[name="jenis_sampah"]:checked')?.value;

                            let nominal = 0;

                            @if($settingBiaya)
                                if (jenis_sampah === 'organik') {
                                    nominal = volume * {{ $settingBiaya->biaya_organik }};
                                } else if (jenis_sampah === 'anorganik') {
                                    nominal = volume * {{ $settingBiaya->biaya_anorganik }};
                                } else if (jenis_sampah === 'campuran') {
                                    nominal = volume * {{ $settingBiaya->biaya_campuran }};
                                }
                            @endif

                            document.getElementById('nominalDisplay').textContent = 'Rp ' + nominal.toLocaleString('id-ID');
                        }

                        document.getElementById('volume_sampah').addEventListener('input', calculateNominal);
                        document.querySelectorAll('input[name="jenis_sampah"]').forEach(radio => {
                            radio.addEventListener('change', calculateNominal);
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Nav -->
    <div class="footer-nav-area" id="footerNav">
        <div class="container px-0">
            @include('components.footer')
        </div>
    </div>
@endsection
