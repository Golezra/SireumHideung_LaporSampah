@extends('layouts.app')

@section('title', 'Edit User')

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
                <h6 class="mb-0">Profil Lengkap Pengguna</h6>
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
        <div class="card user-info-card mb-3">
            <div class="card-body">
                
                @if (session('success'))
                    <div class="alert custom-alert-two alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle"></i>
                        {{ session('success') }}
                        <button class="btn btn-close btn-close-white position-relative p-1 ms-auto" type="button"
                            data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('info'))
                <div class="alert custom-alert-two alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-x-circle"></i>
                    {{ session('info') }}
                    <button class="btn btn-close btn-close-white position-relative p-1 ms-auto" type="button"
                        data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                
                <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <!-- Nama -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ $user->name }}" placeholder="Masukkan Nama Lengkap Anda" required>
                        <small id="nameAlert" class="text-danger d-none">Nama lengkap tidak boleh mengandung angka atau simbol seperti !@#$%^&*(),.<>/?=+-_</small>
                    </div>
                    
                    <!-- Foto Profil -->
                    <div class="form-group">
                        <label for="name" class="form-label">Foto Profil</label>
                        <input type="file" name="pict" id="pict" class="form-control">
                        @if($user->pict)
                            <img src="{{ asset('img/pict/' . $user->pict) }}" alt="Foto Profil" class="img-thumbnail mt-2" style="max-width: 150px;">
                        @endif
                    </div>
                    
                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Saat Ini</label>
                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                    </div>

                    <!-- Role -->
                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select name="role" id="role" class="form-control" required>
                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="tim_operasional" {{ $user->role == 'tim_operasional' ? 'selected' : '' }}>Tim Operasional</option>
                            <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                        </select>
                    </div>
            
                    <!-- Alamat RT -->
                    <div class="mb-3">
                        <label for="rt" class="form-label">Alamat</label>
                        <select name="rt" id="rt" class="form-control" required>
                            <option value="RT 12" {{ $user->rt == 'RT 12' ? 'selected' : '' }}>RT 12</option>
                            <option value="RT 13" {{ $user->rt == 'RT 13' ? 'selected' : '' }}>RT 13</option>
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
                    
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Batal</a>
                </form>
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

<script>
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
</script>
    
@endsection