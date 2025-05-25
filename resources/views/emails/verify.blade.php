{{-- filepath: resources/views/emails/verify.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Verifikasi Email</title>
</head>
<body style="font-family: Arial, sans-serif; background: #f8fafc; padding: 32px;">
    <div style="max-width: 480px; margin: auto; background: #fff; border-radius: 8px; box-shadow: 0 2px 8px #0001; padding: 32px;">
        <div style="text-align: center; margin-bottom: 24px;">
            <img src="{{ url('img/core-img/icon.png') }}" alt="Logo" style="height:60px;">
        </div>
        <h2 style="text-align:center;">Sampurasun!</h2>
        <p>Silakan klik tombol di bawah ini untuk verifikasi email Anda.</p>
        <div style="text-align: center; margin: 32px 0;">
            <a href="{{ $verifyUrl }}" style="background: #2563eb; color: #fff; padding: 12px 32px; border-radius: 6px; text-decoration: none; font-weight: bold;">Verifikasi Email</a>
        </div>
        <p>Jika Anda tidak membuat akun, abaikan email ini.</p>
        <p>Salam,<br>Dilan Ariandi</p>
        <hr>
        <small>Jika tombol di atas tidak berfungsi, salin dan tempel URL berikut ke browser Anda:<br>
        <a href="{{ $verifyUrl }}">{{ $verifyUrl }}</a></small>
    </div>
</body>
</html>