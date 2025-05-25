<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Pembayaran Berhasil</title>
</head>
<body>
    <p>Halo {{ $user->name }},</p>
    <p>Pembayaran Anda untuk laporan sampah dengan ID <b>{{ $laporan->id }}</b> telah <b>berhasil</b>.</p>
    <p>Terima kasih telah menggunakan layanan kami.</p>
</body>
</html>