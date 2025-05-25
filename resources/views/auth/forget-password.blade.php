@extends('layouts.app')

@section('title', 'SH | Lupa Kata Sandi')

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

    {{-- Alert Success --}}
    @if (session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle"></i>
        <span>{{ session('success') }}</span>
        <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

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
      <img class="login-intro-img" src="{{ asset('img/bg-img/37.png') }}" alt="">
    </div>

    <!-- Forget Password Form -->
    <div class="register-form mt-4">
      <form action="{{ route('auth.password.email') }}" method="POST">
        @csrf
        <div class="form-group text-start mb-3">
          <input class="form-control" type="email" name="email" placeholder="Masukkan alamat email Anda" required>
        </div>
        <button class="btn btn-primary w-100" type="submit">Kirim Kode Pemulihan</button>
      </form>
    </div>
  </div>
</div>

@endsection