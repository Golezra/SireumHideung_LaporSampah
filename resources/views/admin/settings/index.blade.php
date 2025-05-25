@extends('layouts.app')

@section('title', 'Admin Settings')

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
        <!-- Header Content -->
        <div class="header-content position-relative d-flex align-items-center justify-content-between">
            <!-- Back Button -->
            <div class="back-button">
                <a href="{{ route('admin.users.index') }}">
                    <i class="bi bi-arrow-left-short"></i>
                </a>
            </div>

            <!-- Page Title -->
            <div class="page-heading">
                <h6 class="mb-0">Pengaturan Sistem</h6>
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

<div class="page-content-wrapper py-3">
    <div class="container">
        <div class="element-heading">
            <h6 class="mb-0">Pengaturan Sistem</h6>
            <p class="mb-0">Pengaturan sistem untuk admin</p>
        </div>
    </div>
    <div class="container mt-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Pengaturan Biaya Sampah</h5>
    
                
                    @if(session('success'))
                        <div class="alert custom-alert-two alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert custom-alert-two alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-x-circle"></i>
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
    
                <form action="{{ route('admin.settings.update') }}" method="POST">
                    @csrf
    
                    <div class="mb-3">
                        <label for="biaya_organik" class="form-label">Biaya Sampah Organik (per liter)</label>
                        <input type="number" class="form-control" id="biaya_organik" name="biaya_organik" value="{{ $settingbiayas->biaya_organik }}" step="0.01" required>
                    </div>
    
                    <div class="mb-3">
                        <label for="biaya_anorganik" class="form-label">Biaya Sampah Anorganik (per Liter)</label>
                        <input type="number" class="form-control" id="biaya_anorganik" name="biaya_anorganik" value="{{ $settingbiayas->biaya_anorganik }}" step="0.01" required>
                    </div>
    
                    <div class="mb-3">
                        <label for="biaya_campuran" class="form-label">Biaya Sampah Campuran (per Liter)</label>
                        <input type="number" class="form-control" id="biaya_campuran" name="biaya_campuran" value="{{ $settingbiayas->biaya_campuran }}" step="0.01" required>
                    </div>
    
                    <button type="submit" class="btn btn-primary">Ubah</button>
                </form>
            </div>
        </div>
        <div class="card mt-4">
            <div class="card-body">
                <h5 class="card-title">Riwayat Perubahan Biaya</h5>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Biaya Organik</th>
                            <th>Biaya Anorganik</th>
                            <th>Biaya Campuran</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(\App\Models\SettingBiaya::orderBy('created_at', 'desc')->get() as $setting)
                            <tr>
                                <td>{{ $setting->created_at->format('d-m-Y H:i') }}</td>
                                <td>{{ number_format($setting->biaya_organik, 2) }}</td>
                                <td>{{ number_format($setting->biaya_anorganik, 2) }}</td>
                                <td>{{ number_format($setting->biaya_campuran, 2) }}</td>
                                <td>{{ $setting->is_active ? 'Aktif' : 'Tidak Aktif' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Footer Nav -->
<div class="footer-nav-area" id="footerNav">
    <div class="container px-0">
        <!-- Footer Content -->
        @include('components.footer2')
    </div>
</div>

@endsection