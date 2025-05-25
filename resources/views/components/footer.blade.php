<div class="footer-nav position-relative shadow-sm">
    <ul class="h-100 d-flex align-items-center justify-content-between ps-0">
        
        <!--Beranda-->
        <li @if(Route::currentRouteName() === 'beranda') class="active" @endif>
            <a href="{{ route('beranda') }}">
                <i class="bi bi-house"></i>
                <span>Beranda</span>
            </a>
        </li>

        <!--Lapor Sampah-->
        <li @if(Route::currentRouteName() === 'lapor-sampah.create') class="active" @endif>
            @if (Auth::check())
                <a href="{{ route('lapor-sampah.create') }}">
                    <i class="bi bi-megaphone"></i>
                    <span>Lapor </span>
                </a>
            @else
                <a href="{{ route('auth.login-form') }}">
                    <i class="bi bi-megaphone"></i>
                    <span>Lapor </span>
                </a>
            @endif
        </li>

        <!--Riwayat Lapor-->
        <li @if(Route::currentRouteName() === 'riwayat-lapor') class="active" @endif>
            @if (Auth::check())
                <a href="{{ route('riwayat-lapor') }}">
                    <i class="bi bi-clock-history"></i>
                    <span>Riwayat </span>
                </a>
            @else
                <a href="{{ route('auth.login-form') }}">
                    <i class="bi bi-clock-history"></i>
                    <span>Riwayat </span>
                </a>
            @endif
        </li>

        <!--Pembayaran-->
        <li @if(Route::currentRouteName() === 'pembayaran.daftar-bayar') class="active" @endif>
            <a href="{{ route('pembayaran.daftar-bayar') }}">
                <i class="bi bi-cash-coin"></i>
                <span>Pembayaran</span>
            </a>
        </li>

        <!--Pesan Masuk-->
        <li @if(Route::currentRouteName() === 'pesan-masuk') class="active" @endif>
            <a href="{{ route('pesan-masuk') }}">
                @if (Auth::check())
                    @php
                        $unreadNotificationsCount = Auth::user()->unreadNotifications->filter(function ($notification) {
                            return isset($notification->data['laporan_id']);
                        })->count();
                    @endphp
                    @if ($unreadNotificationsCount > 0)
                        <span class="position-absolute top 0 start-50 translate-small badge rounded-pill bg-danger small">
                            {{ $unreadNotificationsCount }}
                            <span class="visually-hidden">unread messages</span>
                        </span>
                    @endif
                @endif
                <i class="bi bi-chat-dots"></i>
                <span>Pesan</span>
            </a>
        </li>
        <!--Dashboard Akun-->
        <li @if(Route::currentRouteName() === 'warga.dashboard') class="active" @endif>
            @if (Auth::check())
                @if (Auth::user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="bi bi-person"></i>
                        <span>Admin</span>
                    </a>
                @elseif (Auth::user()->role === 'tim_operasional')
                    <a href="{{ route('tim-operasional.dashboard') }}">
                        <i class="bi bi-person"></i>
                        <span>Tim Operasional</span>
                    </a>
                @elseif (Auth::user()->role === 'user')
                    <a href="{{ route('warga.dashboard') }}">
                        <i class="bi bi-person"></i>
                        <span>{{ Auth::user()->name }}</span>
                    </a>
                @endif
            @else
                <a href="{{ route('auth.login-form') }}">
                    <i class="bi bi-person"></i>
                    <span>Login</span>
                </a>
            @endif
        </li>
    </ul>
</div>
