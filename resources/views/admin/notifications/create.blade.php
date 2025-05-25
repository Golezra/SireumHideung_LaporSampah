@extends('layouts.app')

@section('title', 'Kirim Pesan')

@section('content')
<div class="page-content-wrapper py-3">
    <div class="container">
        <h4 class="mb-4">Kirim Pesan</h4>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.notifications.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="role" class="form-label">Kirim ke</label>
                <select name="role" id="role" class="form-select" required>
                    <option value="warga">Warga</option>
                    <option value="tim-operasional">Tim Operasional</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Pesan</label>
                <textarea name="content" id="content" class="form-control" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Kirim Pesan</button>
        </form>
    </div>
</div>
@endsection