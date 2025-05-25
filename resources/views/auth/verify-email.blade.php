@extends('layouts.app')

@section('title', 'Verifikasi Email')

@section('content')
<div class="container text-center py-5">
    <h4>Verifikasi Email Anda</h4>
    <p>Silakan cek email dan klik link verifikasi untuk mengaktifkan akun.</p>
    @if (session('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif
</div>
@endsection