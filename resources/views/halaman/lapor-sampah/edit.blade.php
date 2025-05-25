@extends('layouts.app')

@section('title', 'SH | Edit Laporan Sampah')

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
            <!-- Header Content -->
            <div class="header-content position-relative d-flex align-items-center justify-content-between">
                <!-- Back Button -->
                <div class="back-button">
                    <a href="{{ route('pesan-masuk') }}">
                        <i class="bi bi-arrow-left-short"></i>
                    </a>
                </div>

                <!-- Page Title -->
                <div class="page-heading">
                    <h6 class="mb-0">Ubah Laporan Sampah</h6>
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

    <div class="container">
        <div class="page-content-wrapper py-3">
            <div class="card">
                <div class="card-body">
                    <!-- Alasan Penolakan -->
                    @if ($notification)
                        <div class="d-flex align-items-center">
                            <strong class="me-2">Alasan Penolakan:</strong>
                            <p class="mb-0 text-nowrap bg-gray" style="width: 8rem;">{{ $notification->data['alasan'] ?? 'Tidak ada alasan yang diberikan.' }}</p>
                        </div>
                    @endif
                    <p class="card-text">Pastikan semua informasi yang Anda masukkan sudah benar.</p>

                    <form action="{{ route('lapor-sampah.update', $laporan->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="lokasi_sampah" class="form-label">Lokasi Sampah</label>
                            <input type="text" name="lokasi_sampah" id="lokasi_sampah" class="form-control" value="{{ $laporan->lokasi_sampah }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="keterangan_lokasi" class="form-label">Keterangan Lokasi Sampah</label>
                            <input type="text" name="keterangan_lokasi" id="keterangan_lokasi" class="form-control" value="{{ $laporan->keterangan_lokasi }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="jenis_sampah" class="form-label">Jenis Sampah</label>
                            <select name="jenis_sampah" id="jenis_sampah" class="form-select" required>
                                <option value="organik" {{ $laporan->jenis_sampah == 'organik' ? 'selected' : '' }}>Organik</option>
                                <option value="anorganik" {{ $laporan->jenis_sampah == 'anorganik' ? 'selected' : '' }}>Anorganik</option>
                                <option value="campuran" {{ $laporan->jenis_sampah == 'campuran' ? 'selected' : '' }}>Campuran</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="volume_sampah" class="form-label">Volume/berat Sampah (Kg)</label>
                            <input type="number" name="volume_sampah" id="volume_sampah" class="form-control" value="{{ $laporan->volume_sampah }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="foto_sampah" class="form-label">Foto Sampah</label>
                            
                            <!-- Tampilkan Foto Sampah -->
                            @if ($laporan->foto_sampah)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $laporan->foto_sampah) }}" alt="Foto Sampah Lama" class="img-fluid rounded" style="max-width: 200px; max-height: 200px;">
                                    <p class="text-muted">Foto sampah saat ini.</p>
                                </div>
                            @else
                                <p class="text-muted">Tidak ada foto sampah yang diunggah.</p>
                            @endif

                            <input type="file" name="foto_sampah" id="foto_sampah" class="form-control" onchange="previewFotoSampah(event)">
                            <small class="text-muted">Kosongkan jika tidak ingin mengganti foto.</small>

                            <!-- Preview Foto Sampah Baru -->
                            <div class="mt-3" id="preview-container" style="display: none;">
                                <p class="text-muted">Foto sampah baru:</p>
                                <img id="preview-foto-sampah" class="img-fluid rounded" style="max-width: 200px; max-height: 200px;">
                            </div>
                        </div>

                        <script>
                            function previewFotoSampah(event) {
                                const previewContainer = document.getElementById('preview-container');
                                const previewImage = document.getElementById('preview-foto-sampah');
                                const file = event.target.files[0];

                                if (file) {
                                    const reader = new FileReader();
                                    reader.onload = function(e) {
                                        previewImage.src = e.target.result;
                                        previewContainer.style.display = 'block';
                                    };
                                    reader.readAsDataURL(file);
                                } else {
                                    previewContainer.style.display = 'none';
                                }
                            }
                        </script>

                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </form>
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
@endsection