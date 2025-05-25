@extends('layouts.app')

@section('title', 'Keuangan')

@section('content')

    <!-- Dark Mode Switching -->
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

    <!-- RTL Mode Switching -->
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
                    <h6 class="mb-0">Keuangan</h6>
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

    <!-- Page Content -->
    <div class="page-content-wrapper py-3">
        <div class="container">
            <div class="element-heading text-center">
                <p>Berikut adalah laporan terbaru mengenai aktivitas keuangan di sistem.</p>
            </div>
        </div>

        <div class="container">
            <!-- Heading -->
            <div class="element-heading d-flex justify-content-between align-items-center mb-3">
                <!-- Tombol Tambah Transaksi -->
                <div class="d-flex justify-content-center my-4">
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addTransactionModal">Tambah Transaksi</button>
                </div>
            </div>

            <!-- Form Filter Periode -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <form action="{{ route('admin.keuangan.index') }}" method="GET">
                        <div class="row g-2">
                            <div class="col-12 col-md-4">
                                <label for="start_date" class="form-label">Tanggal Mulai</label>
                                <input type="date" name="start_date" id="start_date" class="form-control" value="{{ request('start_date') }}">
                            </div>
                            <div class="col-12 col-md-4">
                                <label for="end_date" class="form-label">Tanggal Akhir</label>
                                <input type="date" name="end_date" id="end_date" class="form-control" value="{{ request('end_date') }}">
                            </div>
                            <div class="col-12 col-md-4 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary w-100">Filter</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Ringkasan Keuangan -->
            <div class="row g-2 mb-4">
                <div class="col-12 col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body text-center">
                            <h6 class="card-title">Total Pemasukan</h6>
                            <h4 class="text-success">Rp {{ number_format($totalLunas, 0, ',', '.') }}</h4>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body text-center">
                            <h6 class="card-title">Total Pengeluaran</h6>
                            <h4 class="text-danger">Rp </h4>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body text-center">
                            <h6 class="card-title">Saldo Akhir</h6>
                            <h4 class="text-primary">Rp </h4>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabel Transaksi -->
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="card-title">Daftar Transaksi Pemasukan</h6>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Keterangan</th>
                                    <th>Metode Bayar</th>
                                    <th>Jenis Sampah</th>
                                    <th>Volume Sampah</th>
                                    <th>Lokasi Sampah</th>
                                    <th>Nominal Bayar</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transactions as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->user->name ?? '-' }}</td>
                                        <td>{{ $item->metodeBayar->keterangan ?? '-' }}</td> <!-- keterangan dari metode_bayars -->
                                        <td>{{ $item->metodeBayar->metode_bayar ?? '-' }}</td> <!-- metode bayar dari metode_bayars -->
                                        <td>{{ $item->jenis_sampah ?? '-' }}</td> <!-- dari lapor_sampah -->
                                        <td>{{ $item->volume_sampah ?? '-' }}</td> <!-- dari lapor_sampah -->
                                        <td>{{ $item->lokasi_sampah ?? '-' }}</td> <!-- dari lapor_sampah -->
                                        <td>Rp {{ number_format($item->metodeBayar->nominal ?? 0, 0, ',', '.') }}</td> <!-- nominal dari metode_bayars -->
                                        <td>{{ $item->created_at->format('d-m-Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Tabel Transaksi Pengeluaran -->
            <div class="card shadow-sm mt-4">
                <div class="card-body">
                    <h6 class="card-title">Daftar Transaksi Pengeluaran</h6>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Keterangan</th>
                                    <th>Nominal</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- @forelse ($pengeluaran as $item) --}}
                                    <tr>
                                        {{-- <td>{{ $loop->iteration }}</td> --}}
                                        {{-- <td>{{ $item->keterangan }}</td> --}}
                                        {{-- <td>Rp {{ number_format($item->nominal, 0, ',', '.') }}</td>
                                        <td>{{ $item->created_at->translatedFormat('d F Y H:i:s') }}</td> --}}
                                    </tr>
                                {{-- @empty --}}
                                    <tr>
                                        <td colspan="4" class="text-center">Belum ada transaksi pengeluaran.</td>
                                    </tr>
                                {{-- @endforelse --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Transaksi -->
    <div class="modal fade" id="addTransactionModal" tabindex="-1" aria-labelledby="addTransactionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('admin.keuangan.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addTransactionModalLabel">Tambah Transaksi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="jenis" class="form-label">Jenis Transaksi</label>
                            <select name="jenis" id="jenis" class="form-select" required>
                                <option value="pemasukan">Pemasukan</option>
                                <option value="pengeluaran">Pengeluaran</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea name="keterangan" id="keterangan" class="form-control" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="nominal" class="form-label">Nominal</label>
                            <input type="number" name="nominal" id="nominal" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer-nav-area" id="footerNav">
        <div class="container px-0">
            @include('components.footer2')
        </div>
    </div>

@endsection
