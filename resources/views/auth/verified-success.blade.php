@extends('layouts.app')

@section('title', 'Verifikasi Berhasil')

@section('content')
<style>
    .center-verified-success {
        min-height: 80vh;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 16px;
        width: 100%;
        box-sizing: border-box;
        word-break: break-word;
        text-align: center;
    }
    @media (max-width: 576px) {
        .center-verified-success h4 {
            font-size: 1.2rem;
        }
        .center-verified-success p {
            font-size: 1rem;
        }
    }
</style>

<div class="center-verified-success">
    <img src="{{ asset('img/core-img/icon.png') }}" alt="Logo" style="height:60px; margin-bottom: 16px;">
    <h4>Selamat, Email Anda Berhasil Diverifikasi!</h4>
    <p>Silakan login untuk melanjutkan ke Lapor Sampah - Sireum Hideung.</p>
</div>
<div style="width:100%;text-align:center;margin-top:32px;font-size:0.95rem;color:#888;">
    &copy; 2025 Dilan Ariandi<br>
    Mahasiswa Teknik Informatika D3<br>
    STT Texmaco - Subang
</div>
@endsection