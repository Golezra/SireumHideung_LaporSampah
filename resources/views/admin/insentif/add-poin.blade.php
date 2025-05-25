@extends('layouts.app')

@section('title', 'Tambah Poin')

@section('content')

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
                <p class="mb-0">Settings</p>
                <div class="btn-close" id="settingCardClose"></div>
            </div>

            <div class="single-setting-panel">
                <div class="form-check form-switch mb-2">
                    <input class="form-check-input" type="checkbox" id="availabilityStatus" checked>
                    <label class="form-check-label" for="availabilityStatus">Availability status</label>
                </div>
            </div>

            <div class="single-setting-panel">
                <div class="form-check form-switch mb-2">
                    <input class="form-check-input" type="checkbox" id="sendMeNotifications" checked>
                    <label class="form-check-label" for="sendMeNotifications">Send me notifications</label>
                </div>
            </div>

            <div class="single-setting-panel">
                <div class="form-check form-switch mb-2">
                    <input class="form-check-input" type="checkbox" id="darkSwitch">
                    <label class="form-check-label" for="darkSwitch">Dark mode</label>
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
                <a href="{{ route('admin.dashboard') }}">
                    <i class="bi bi-arrow-left-short"></i>
                </a>
            </div>

            <!-- Page Title -->
            <div class="page-heading">
                <h6 class="mb-0">Manajemen Insentif</h6>
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
    <!-- Element Heading -->
    <div class="container">
        <div class="element-heading">
            <p class="text-center">Silakan isi form di bawah ini untuk menambahkan poin kepada pengguna.</p>
        </div>
    </div>

    <div class="container mb-4">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.insentif.add-poin') }}" method="POST">
                    @csrf
                    <meta name="csrf-token" content="{{ csrf_token() }}">
                    <!-- Nama Pengguna -->
                    <div class="form-group">
                        <label class="form-label" for="search">Nama Pengguna</label>
                        <input type="text" id="search" class="form-control" placeholder="Ketik Nama Pengguna" name="search" required autocomplete="off">
                        <ul id="search-results" class="list-group mt-2" style="display: none;"></ul>
                    </div>
                    <input type="hidden" name="user_id" id="user_id">

                    <!-- Masukan Jumlah Poin -->
                    <div class="form-group">
                        <label class="form-label" for="poin">Jumlah Poin</label>
                        <input type="number" name="poin" id="poin" class="form-control" placeholder="Masukan Jumlah Poin" required>
                    </div>
                    
                    <!-- Tombol Tambah Poin -->
                    <div class="container">
                        <div class="card">
                            <div class="card-body text-center">
                                <button type="submit" class="btn btn-info" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Jika ingin menambahkan poin kepada pengguna lain, silakan ketikan nama pengguna di kolom nama pengguna">Tambah Poin</button>
                            </div>
                        </div>
                    </div>
                    <!-- Masukan Keterangan -->
                    {{-- <div class="container mt-3" style="opacity: 0.3;">
                        <div class="card">
                            <div class="card-body">
                                <div class="accordion accordion-flush accordion-style-one" id="accordionStyle1">
                                    <!-- Single Accordion -->
                                    <div class="accordion-item">
                                        <div class="accordion-header" id="accordionTwo">
                                            <h6 class="collapsed" data-bs-toggle="collapse" data-bs-target="#accordionStyleTwo" aria-expanded="false" aria-controls="accordionStyleTwo">Pengingat!<i class="bi bi-chevron-down"></i></h6>
                                        </div>
                                        <div class="accordion-collapse collapse" id="accordionStyleTwo" aria-labelledby="accordionTwo" data-bs-parent="#accordionStyle1">
                                            <div class="accordion-body">
                                                <p class="mb-0" style="opacity: 0.6;">Jika ingin menambahkan poin kepada pengguna lain, silakan ketikan nama/RT pengguna di kolom nama pengguna.
                                                    <span style="color: red;">*</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </form>
            </div>
        </div>
    </div>

    <!-- Tabel User -->
    <div class="container mt-4">
        <div class="element-heading text-center">
            <h5>Daftar Pengguna</h5>
            <p>Berikut adalah daftar pengguna yang terdaftar di sistem.</p>
        </div>
    </div>

    <div class="container">
        <div class="card">
            <div class="card-body">
                <table class="table mb-0 table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Nama</th>
                            <th scope="col">Alamat</th>
                            <th scope="col">Poin</th>
                            <th scope="col">Jumlah lapor</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->rt }}</td>
                            <td>{{ $user->poin }}</td>
                            <td>{{ $user->jumlah_lapor }}</td>
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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('search');
        const searchResults = document.getElementById('search-results');

        searchInput.addEventListener('input', function () {
            const query = this.value;

            // Jika input kosong, sembunyikan hasil pencarian
            if (!query) {
                searchResults.style.display = 'none';
                searchResults.innerHTML = '';
                return;
            }

            // Kirim permintaan AJAX ke server
            fetch(`{{ route('admin.insentif.autocomplete') }}?query=${query}`, {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    searchResults.style.display = 'block';
                    searchResults.innerHTML = '';

                    // Tampilkan hasil pencarian
                    if (data.length > 0) {
                        data.forEach(user => {
                            const li = document.createElement('li');
                            li.className = 'list-group-item';
                            li.textContent = `${user.name} (Poin: ${user.poin}, Alamat: ${user.rt}, Jumlah Lapor: ${user.jumlah_lapor})`;
                            li.addEventListener('click', () => {
                                document.getElementById('user_id').value = user.id;
                                searchInput.value = user.name;
                                searchResults.style.display = 'none';
                            });
                            searchResults.appendChild(li);
                        });
                    } else {
                        searchResults.innerHTML = '<li class="list-group-item text-muted">Tidak ada hasil ditemukan</li>';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });
    });
</script>
