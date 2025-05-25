@extends('layouts.app')

@section('title', 'Validasi Laporan')

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
                <h6 class="mb-0">Validasi Laporan Sampah</h6>
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
    

    <!-- Modal untuk Zoom Foto -->
    <div class="modal fade" id="fotoModal" tabindex="-1" aria-labelledby="fotoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="fotoModalLabel">Foto Sampah</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" src="" alt="Foto Sampah" class="img-fluid" style="cursor: zoom-in;">
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Form -->
    <div class="container">
        @if (session('success'))
            <div class="alert custom-alert-two alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle"></i>
                {{ session('success') }}
                <button class="btn btn-close btn-close-white position-relative p-1 ms-auto" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert custom-alert-two alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-x-circle"></i>
                {{ session('error') }}
                <button class="btn btn-close btn-close-white position-relative p-1 ms-auto" type="button"
                    data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="card mb-4">
            <div class="card-body">
                <form action="{{ route('admin.validasi.filter') }}" method="GET" class="mb-4">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="bulan" class="form-label">Bulan</label>
                            <select name="bulan" id="bulan" class="form-select">
                                <option value="">Semua Bulan</option>
                                @foreach (range(1, 12) as $month)
                                    <option value="{{ $month }}" {{ request('bulan') == $month ? 'selected' : '' }}>
                                        {{ DateTime::createFromFormat('!m', $month)->format('F') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="tahun" class="form-label">Tahun</label>
                            <select name="tahun" id="tahun" class="form-select">
                                <option value="">Semua Tahun</option>
                                @foreach (range(2025, date('Y') + 5) as $year)
                                    <option value="{{ $year }}" {{ request('tahun') == $year ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">Cari</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Tabel Validasi -->
    <div class="container">
        <div class="element-heading mt-3">
            <h6>Tabel Validasi Laporan Sampah</h6>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table mb-0 table-hover">
                        <thead>
                            <tr>
                                <th>Foto Sampah</th>
                                <th>Nama Pelapor</th>
                                <th>Lokasi Sampah</th>
                                <th>Jenis Sampah</th>
                                <th>Volume (L)</th>
                                <th>Nominal (Rp)</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $sortedLaporan = $laporan->sortBy(function ($item) {
                                    return $item->status === 'pending' ? 0 : 1;
                                });
                            @endphp
                            @forelse ($sortedLaporan as $item)
                                <tr>
                                    <td>
                                        <img src="{{ asset('storage/' . $item->foto_sampah) }}" alt="Foto Sampah" class="img-thumbnail zoomable" style="width: 100px; height: 100px; object-fit: cover; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#fotoModal" onclick="showImageInModal('{{ asset('storage/' . $item->foto_sampah) }}')">
                                    </td>
                                    <td>{{ $item->user->name ?? 'Tidak diketahui' }}</td>
                                    <td>{{ $item->lokasi_sampah }}</td>
                                    <td>{{ ucfirst($item->jenis_sampah) }}</td>
                                    <td>{{ $item->volume_sampah }}</td>
                                    <td>
                                        @if($item->metodeBayar)
                                            Rp {{ number_format($item->metodeBayar->nominal, 0, ',', '.') }}
                                        @else
                                            <span class="text-danger">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-warning">{{ ucfirst($item->status_lapor) }}</span>
                                    </td>
                                    <td>
                                        @if ($item->status_lapor === 'pending')
                                            <form action="{{ route('admin.validasi', $item->id) }}" method="POST" style="display: inline-block;">
                                                @csrf
                                                <button type="submit" class="btn m-1 btn-sm btn-success">Validasi</button>
                                            </form>
                                            <button type="button" class="btn m-1 btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#tolakModal{{ $item->id }}">Tolak</button>
                                        @elseif ($item->status_lapor === 'ditolak')
                                            <span class="badge bg-danger">Ditolak</span>
                                        @elseif ($item->status_lapor === 'diproses')
                                            <span class="badge bg-success">Sudah Valid</span>
                                        @endif
                                    </td>
                                </tr>
                                <div class="modal fade" id="tolakModal{{ $item->id }}" tabindex="-1" aria-labelledby="tolakModalLabel{{ $item->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="{{ route('admin.validasi.tolak', $item->id) }}" method="POST">
                                                @csrf
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="tolakModalLabel{{ $item->id }}">Tolak Laporan</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="alasan">Alasan Penolakan</label>
                                                        <textarea name="alasan" id="alasan" class="form-control" rows="3" required></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-danger">Tolak</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">Tidak ada laporan untuk divalidasi.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="container mt-3 text-center">
            <a href="{{ route('admin.validasi.cetak-pdf', request()->all()) }}" class="btn m-1 btn-creative btn-danger">
                <i class="bi bi-file-earmark-pdf"></i> Cetak PDF
            </a>
        </div>
    </div>

    
</div>

<!-- Footer Nav -->
<div class="footer-nav-area" id="footerNav">
    <div class="container px-0">
        @include('components.footer2')
    </div>
</div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const images = document.querySelectorAll('.zoomable');
        images.forEach(img => {
            img.addEventListener('click', function () {
                if (this.style.transform === 'scale(3)') {
                    this.style.transform = 'scale(1)';
                } else {
                    this.style.transform = 'scale(3)';
                }
            });
        });
    });

    function showImageInModal(imageUrl) {
        const modalImage = document.getElementById('modalImage');
        modalImage.src = imageUrl;
        modalImage.style.transform = 'scale(1)'; // Reset zoom when modal is opened
    }

    document.getElementById('fotoModal').addEventListener('hidden.bs.modal', function () {
        const modalImage = document.getElementById('modalImage');
        modalImage.style.transform = 'scale(1)'; // Reset zoom when modal is closed
    });
</script>
