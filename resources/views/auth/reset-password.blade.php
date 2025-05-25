@extends('layouts.app')

@section('title', 'SH | Mengatur ulang kata sandi')

@section('content')

<!-- Back Button -->
<div class="login-back-button">
  <a href="{{ route('auth.login-form') }}">
    <i class="bi bi-arrow-left-short"></i>
  </a>
</div>

<!-- Login Wrapper Area -->
<div class="login-wrapper d-flex align-items-center justify-content-center">
  <div class="custom-container">

    {{-- Alert Error --}}
    @if (session('error'))
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle"></i>
        <span>{{ session('error') }}</span>
        <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    {{-- Validation Errors --}}
    @if ($errors->any())
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle"></i>
        @foreach ($errors->all() as $error)
          <span>{{ $error }}</span>
        @endforeach
        <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    <div class="text-center px-4">
      <img class="login-intro-img" src="{{ asset('img/bg-img/reset-password.png') }}" alt="">
    </div>

    <!-- Reset Password Form -->
    <div class="register-form mt-4">
      <form action="{{ route('password.update') }}" method="POST">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <div class="form-group text-start mb-3">
          <input class="form-control" type="email" name="email" placeholder="Masukkan alamat email Anda" required>
        </div>
        <div class="form-group text-start mb-3">
          <input class="form-control" type="password" name="password" placeholder="Masukkan password baru" required>
        </div>
        <div class="form-group text-start mb-3">
          <input class="form-control" type="password" name="password_confirmation" placeholder="Konfirmasi password baru" required>
        </div>
        <button class="btn btn-primary w-100" type="submit">Reset Password</button>
      </form>
    </div>
  </div>
</div>

@endsection