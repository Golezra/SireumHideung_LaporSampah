@extends('layouts.app')

@section('title', 'Ganti Kata Sandi')

@section('content')
<div class="login-wrapper d-flex align-items-center justify-content-center">
    <div class="custom-container">
        <div class="text-center px-4">
            <h4>Ganti Kata Sandi</h4>
        </div>

        <!-- Alert Error -->
        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-x-circle"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <!-- Alert Success -->
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <!-- Change Password Form -->
        <div class="register-form mt-4">
            <form action="{{ route('auth.change-password') }}" method="POST">
                @csrf
                <div class="form-group text-start mb-3">
                    <label for="email">Email</label>
                    <input class="form-control" type="email" name="email" placeholder="Masukkan email Anda" required>
                </div>
                <div class="form-group text-start mb-3">
                    <label for="recovery_code">Kode Keamanan</label>
                    <input class="form-control" type="text" name="recovery_code" placeholder="Masukkan kode keamanan 6 digit" required>
                </div>
                <div class="form-group text-start mb-3">
                    <label for="password">Kata Sandi Baru</label>
                    <input class="form-control" type="password" name="password" placeholder="Masukkan kata sandi baru" required>
                </div>
                <div class="form-group text-start mb-3">
                    <label for="password_confirmation">Konfirmasi Kata Sandi</label>
                    <input class="form-control" type="password" name="password_confirmation" placeholder="Ulangi kata sandi baru" required>
                </div>
                <button class="btn btn-primary w-100" type="submit">Perbarui Kata Sandi</button>
            </form>
        </div>
    </div>
</div>
@endsection