@extends('layouts.app')

@section('content')

    @include('components.alert')

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
            <div class="header-content position-relative d-flex align-items-center justify-content-between">
                <div class="back-button">
                    <a href="{{ route('tim-operasional.dashboard') }}">
                        <i class="bi bi-arrow-left-short"></i>
                    </a>
                </div>
                <div class="page-heading">
                    <h6 class="mb-0">Laporan Menunggu Diangkut</h6>
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
            <h6 class="mt-4">Daftar Laporan Menunggu Diangkut</h6>
        </div>

        <div class="container">
            <div class="card shadow-sm mt-4">
                <div class="card-body">
                    <form action="{{ route('tim-operasional.laporan.menunggu') }}" method="GET" class="d-flex align-items-center">
                        <div class="flex-grow-1 me-2">
                            <label for="pelapor-autocomplete" class="form-label">Cari Pelapor</label>
                            <input type="text" id="pelapor-autocomplete" name="pelapor" class="form-control" placeholder="Masukkan nama pelapor" value="{{ request('pelapor') }}">
                            <ul id="autocomplete-results" class="list-group mt-2" style="display: none;"></ul>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">Cari</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="top-products-area product-list-wrap py-3">
            <div class="container">
                <div class="row g-3">
                    @forelse ($laporan as $item)
                        <!-- Modal untuk Foto Sampah -->
                        <div class="modal fade" id="fotoModal{{ $item->id }}" tabindex="-1" aria-labelledby="fotoModalLabel{{ $item->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="fotoModalLabel{{ $item->id }}">Foto Sampah</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body text-center">
                                        <img src="{{ asset('storage/' . $item->foto_sampah) }}" alt="Foto Sampah" class="img-fluid" style="cursor: zoom-in;" onclick="this.style.transform = this.style.transform === 'scale(2)' ? 'scale(1)' : 'scale(2)'; this.style.transition = 'transform 0.3s ease-in-out';">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="card single-product-card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="card-side-img">
                                            <a class="product-thumbnail d-block">
                                                <img src="{{ asset('storage/' . $item->foto_sampah) }}" alt="Foto Sampah" style="width: 100px; height: 100px; object-fit: cover; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#fotoModal{{ $item->id }}">
                                            </a>
                                        </div>
                                        <div class="card-content px-4 py-2">
                                            <div>
                                                <p class="fw-bold mb-1">Pelapor: <span class="fst-italic fw-normal">{{ $item->user->name ?? 'Tidak diketahui' }}</span></p>
                                                <p class="fw-bold mb-1">Jenis sampah: <span class="fst-italic fw-normal">{{ ucfirst($item->jenis_sampah) }}</span></p>
                                                <p class="fw-bold mb-1">Berat sampah: <span class="fst-italic fw-normal">{{ $item->berat_sampah }} KG</span></p>
                                                <p class="fw-bold mb-1">Nominal: <span class="fst-italic fw-normal">Rp.{{ number_format($item->nominal, 0, ',', '.') }}</span></p>
                                                <p class="fw-bold mb-0">Lokasi: <span class="fst-italic fw-normal">{{ $item->keterangan_lokasi_sampah }}</span></p>
                                            </div>
                                            <div class="mt-3 d-flex gap-2">
                                                <form action="{{ route('riwayat-lapor.ubah-status', ['id' => $item->id, 'status' => 'diangkut']) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-success btn-sm d-flex align-items-center">
                                                        <i class="bi bi-truck me-1"></i> Angkut
                                                    </button>
                                                </form>
                                            </div>
                                            <div class="position-absolute top-0 end-0 me-3 mt-2">
                                                <span class="badge bg-primary primary rounded-pill">{{ ucfirst($item->status) }}</span>
                                            </div>
                                            <div class="fst-italic position-absolute bottom-0 end-0 me-3 mb-2">
                                                <small class="text-muted">{{ $item->created_at->translatedFormat('d F Y H:i') }}</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <p class="text-center">Tidak ada laporan menunggu diangkut.</p>
                        </div>
                    @endforelse
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('#pelapor-autocomplete').on('input', function () {
            let query = $(this).val();

            if (query.length > 2) {
                $.ajax({
                    url: "{{ route('tim-operasional.autocomplete.pelapor') }}",
                    type: "GET",
                    data: { query: query },
                    success: function (data) {
                        let results = $('#autocomplete-results');
                        results.empty();

                        if (data.length > 0) {
                            results.show();
                            data.forEach(function (item) {
                                results.append(`<li class="list-group-item">${item.name}</li>`);
                            });
                        } else {
                            results.hide();
                        }
                    }
                });
            } else {
                $('#autocomplete-results').hide();
            }
        });

        $(document).on('click', '#autocomplete-results li', function () {
            let selectedName = $(this).text();
            $('#pelapor-autocomplete').val(selectedName);
            $('#autocomplete-results').hide();
        });
    });
</script>
