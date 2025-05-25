@extends('layouts.app')

@section('title', 'SH | Login')

@section('content')

@include('components.alert')

  <!-- Back Button -->
  <div class="login-back-button">
    <a href="{{ url('/') }}">
      <i class="bi bi-arrow-left-short"></i>
    </a>
  </div>

  <!-- Login Wrapper Area -->
  <div class="login-wrapper d-flex align-items-center justify-content-center">
    <div class="custom-container">
      <div class="text-center px-4">
        <img class="login-intro-img" src="{{ asset('img/bg-img/login.png') }}" alt="">
      </div>

      @if(session('error'))
        <div class="alert alert-danger">
          {{ session('error') }}
        </div>
      @endif
      
      @if(session('success'))
        <div class="alert alert-success">
          {{ session('success') }}
        </div>
      @endif

      <!-- Register Form -->
      <div class="register-form mt-4">
        <h6 class="mb-3 text-center">Masuk untuk melanjutkan ke Lapor Sampah - Sireum Hideung</h6>

        <form action="{{ route('auth.login') }}" method="POST">
          @csrf
          <div class="form-group">
            <input class="form-control" type="email" value="{{ old('email') }}" name="email" placeholder="Masukkan Email">
          </div>

          <div class="form-group position-relative">
            <input class="form-control" name="password" id="psw-input" type="password" placeholder="Masukkan Kata Sandi">
            <div class="position-absolute" id="password-visibility">
              <i class="bi bi-eye"></i>
              <i class="bi bi-eye-slash"></i>
            </div>
          </div>

          <button name="submit" class="btn btn-primary w-100" type="submit">Masuk</button>
        </form>
      </div>

      <!-- Login Meta -->
      <div class="login-meta-data text-center">
        <a class="stretched-link forgot-password d-block mt-3 mb-1" href="{{ route('auth.password.request') }}">Lupa
          Password?</a>
        <p class="mb-0">Belum punya akun? <a class="stretched-link" href="{{ route('auth.register') }}">Daftar Sekarang</a></p>
      </div>
    </div>
  </div>
@endsection