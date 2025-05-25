@extends('layouts.app')

@section('title', 'Manage Users')

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
            <!-- Tombol Kembali ke Dashboard Admin -->
            <div class="back-button">
                <a href="{{ route('admin.dashboard') }}">
                    <i class="bi bi-arrow-left-short"></i>
                </a>
            </div>

            <!-- Page Title -->
            <div class="page-heading">
                <h6 class="mb-0">Mengelola Pengguna</h6>
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

<!-- Page Content -->
<div class="page-content-wrapper py-3">
    <div class="container">
        <div class="card-body">
            <!-- Tabel User -->
            <div class="page-content-wrapper py-3">
                <div class="container">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive table-responsive-sm">
                                <table class="table table-bordered table-striped table-sm w-100" id="dataTable">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>Nama</th>
                                            <th>Alamat</th>
                                            <th>Role</th>
                                            <th>Jumlah Lapor</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->rt }}</td>
                                                <td>{{ ucfirst($user->role) }}</td>
                                                <td>{{ $user->jumlah_lapor }}</td>
                                                <td class="d-flex flex-column flex-sm-row gap-2">
                                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning btn-sm" title="Lihat Lengkap atau Ubah">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </a>
                                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirmDelete(event)">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" title="Apakah Anda yakin untuk menghapus pengguna?">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
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
    </div>
</div>
        <!-- Footer Nav -->
        <div class="footer-nav-area" id="footerNav">
            <div class="container px-0">
                <!-- Footer Content -->
                @include('components.footer2')
            </div>
        </div>
<style>
    .table-responsive {
        overflow-x: auto;
    }
    table {
        width: 100%;
    }
    @media (max-width: 576px) {
        .table-responsive {
            overflow-x: scroll;
        }
        table {
            display: block;
        }
    }
</style>

<script>
    function confirmDelete(event) {
        event.preventDefault(); // Mencegah form dikirim langsung

        // Tampilkan alert konfirmasi
        const userConfirmed = confirm('Apakah Anda yakin ingin menghapus pengguna ini?');

        if (userConfirmed) {
            // Jika pengguna memilih "OK", kirim form
            event.target.submit();
        } else {
            // Jika pengguna memilih "Cancel", batalkan penghapusan
            return false;
        }
    }
</script>
    
@endsection