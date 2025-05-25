@extends('layouts.app')

@section('title', 'Edit Profil')

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
                    <a href="{{ route('warga.dashboard') }}">
                        <i class="bi bi-arrow-left-short"></i>
                    </a>
                </div>
                <div class="page-heading">
                    <h6 class="mb-0">Ubah Profil</h6>
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
            <div class="card user-info-card mb-3">
                <div class="card-body">
                    <form action="{{ route('warga.update-profil') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <!-- Foto Profil Saat Ini -->
                        <div class="mb-3 text-center position-relative">
                            <label class="form-label d-block mb-2">Foto Profil</label>
                            <div class="position-relative d-inline-block">
                                <img src="{{ asset(Auth::user()->foto_profil ?? 'img/foto-profil/default-fotoprofil.png') }}" alt="Foto Profil" class="rounded-circle shadow" style="width: 100px; height: 100px; object-fit: cover; border: 2px solid #f8f9fa;">
                                
                                <!-- Ikon Pensil -->
                                <a href="javascript:void(0);" onclick="document.getElementById('pict').click();" class="position-absolute" style="top: 5px; right: 5px; text-decoration: none;">
                                    <i class="bi bi-pencil-fill text-white bg-primary rounded-circle p-2" style="font-size: 1rem;"></i>
                                </a>
                            </div>
                        </div>

                        <!-- Ubah Foto Profil -->
                        <div class="mb-3">
                            <input type="file" name="pict" id="pict" class="form-control d-none" accept="image/*" capture="camera">
                        </div>

                        <!-- Nama -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ $user->name }}" placeholder="Masukkan Nama Lengkap Anda" required>
                            <small id="nameAlert" class="text-danger d-none">Nama lengkap tidak boleh mengandung angka atau simbol seperti !@#$%^&*(),.<>/?=+-_</small>
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Saat Ini</label>
                            <input type="email" name="email" id="email" class="form-control" value="{{ $user->email }}" readonly>
                        </div>

                        <!-- RT -->
                        <div class="mb-3">
                            <label for="rt" class="form-label">RT</label>
                            <select name="rt" id="rt" class="form-control" required>
                                <option value="12" {{ $user->rt == '12' ? 'selected' : '' }}>RT 12</option>
                                <option value="13" {{ $user->rt == '13' ? 'selected' : '' }}>RT 13</option>
                            </select>
                        </div>

                        <!-- No. Telepon -->
                        <div class="mb-3">
                            <label for="phone_number" class="form-label">No. Telepon</label>
                            <input type="text" name="phone_number" id="phone_number" class="form-control" value="{{ $user->phone_number }}" placeholder="Masukkan No. Telepon Anda" required>
                            <small id="phoneAlert" class="text-danger d-none">Nomor telepon harus dimulai dengan 0, memiliki panjang antara 8-15 karakter, dan hanya berisi digit.</small>
                        </div>

                        <!-- NIK -->
                        <div class="mb-3">
                            <label for="nik" class="form-label">NIK</label>
                            <input type="text" name="nik" id="nik" class="form-control" value="{{ $user->nik }}" placeholder="Masukkan NIK Anda" required>
                            <small id="nikAlert" class="text-danger d-none">NIK harus terdiri dari 16 digit.</small>
                        </div>

                        <!-- Tombol Simpan -->
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </form>
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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const nikInput = document.getElementById('nik');
            const nikAlert = document.getElementById('nikAlert');

            nikInput.addEventListener('input', function () {
                if (nikInput.value.length === 16) {
                    nikAlert.classList.add('d-none'); // Sembunyikan peringatan
                } else {
                    nikAlert.classList.remove('d-none'); // Tampilkan peringatan
                }
            });

            const phoneInput = document.getElementById('phone_number');
            const phoneAlert = document.getElementById('phoneAlert');

            phoneInput.addEventListener('input', function () {
                const phoneValue = phoneInput.value;
                const phoneRegex = /^0\d{7,14}$/; // Nomor harus dimulai dengan 0 dan panjang 8-15 digit

                if (phoneRegex.test(phoneValue)) {
                    phoneAlert.classList.add('d-none'); // Sembunyikan peringatan jika valid
                } else {
                    phoneAlert.classList.remove('d-none'); // Tampilkan peringatan jika tidak valid
                }
            });

            const nameInput = document.getElementById('name');
            const nameAlert = document.getElementById('nameAlert');

            nameInput.addEventListener('input', function () {
                const nameValue = nameInput.value;
                const nameRegex = /^[a-zA-Z\s]+$/; // Hanya huruf dan spasi yang diperbolehkan

                if (nameRegex.test(nameValue)) {
                    nameAlert.classList.add('d-none'); // Sembunyikan peringatan jika valid
                } else {
                    nameAlert.classList.remove('d-none'); // Tampilkan peringatan jika tidak valid
                }
            });

            document.getElementById('pict').addEventListener('click', function () {
                console.log('Input file dipicu');
            });

            const pictInput = document.getElementById('pict');
            const profileImage = document.querySelector('img[alt="Foto Profil"]');

            pictInput.addEventListener('change', function (event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        profileImage.src = e.target.result; // Ganti src gambar dengan file yang diunggah
                    };
                    reader.readAsDataURL(file); // Membaca file sebagai URL data
                }
            });
        });
    </script>
@endsection