@extends('layouts.app')

@section('title', 'Pesan')

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
            <div class="single-setting-panel">
                <div class="form-check form-switch mb-2">
                    <input class="form-check-input" type="checkbox" id="darkSwitch">
                    <label class="form-check-label" for="darkSwitch">Dark mode</label>
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
                <h6 class="mb-0">Pesan</h6>
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
    <!-- Tabel Pesan Penolakan -->
    <div class="container">
        <div class="element-heading mt-3 d-flex justify-content-between align-items-center">
            <h6>Tabel Pesan Penolakan Laporan Sampah</h6>
            <div>
                <!-- Tombol untuk ke admin.notifications.create -->
                <a href="{{ route('admin.notifications.create') }}" class="btn btn-success btn-sm">Kirim Pesan</a>
                <button id="toggleTableButton" class="btn btn-secondary btn-sm">Sembunyikan Tabel</button>
            </div>
        </div>
        <div id="notificationTable" class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Pelapor</th>
                                <th>Alasan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($notifications as $notification)
                                <tr>
                                    <td>{{ $notification->data['laporan_id'] }}</td>
                                    <td>{{ $notification->data['alasan'] ?? 'Tidak ada alasan yang diberikan.' }}</td>
                                    <td>
                                        <a href="{{ $notification->data['url'] }}" class="btn btn-primary btn-sm">Lihat Laporan</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">Tidak ada notifikasi dengan alasan penolakan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer Nav -->
<div class="footer-nav-area" id="footerNav">
    <div class="container px-0">
        @include('components.footer2')
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggleButton = document.getElementById('toggleTableButton');
        const tableContainer = document.getElementById('notificationTable');

        toggleButton.addEventListener('click', function () {
            if (tableContainer.style.display === 'none') {
                tableContainer.style.display = 'block';
                toggleButton.textContent = 'Sembunyikan Tabel';
            } else {
                tableContainer.style.display = 'none';
                toggleButton.textContent = 'Tampilkan Tabel';
            }
        });
    });
</script>
@endsection