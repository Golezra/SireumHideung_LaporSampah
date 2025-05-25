<div class="footer-nav position-relative horizontal-scroll">
    <ul class="h-100 d-flex align-items-center justify-content-between ps-0">
      <li @if(Route::currentRouteName() === 'admin.dashboard') class="active" @endif>
        <a href="{{ route('admin.dashboard') }}">
          <i class="bi bi-person"></i>
            <span>Dashboard</span>
        </a>
      </li>

      <li @if(Route::currentRouteName() === 'admin.users.index') class="active" @endif>
        <a href="{{ route('admin.users.index') }}">
          <i class="bi bi-people"></i>
            <span>Pengguna</span>
        </a>
      </li>

      <li @if(Route::currentRouteName() === 'admin.reports.index') class="active" @endif>
        <a href="{{ route('admin.reports.index') }}">
          <i class="bi bi-bar-chart"></i>
            <span>Laporan</span>
        </a>
      </li>

      <li @if(Route::currentRouteName() === 'admin.insentif.add-poin') class="active" @endif>
        <a href="{{ route('admin.insentif.add-poin') }}">
          <i class="bi bi-gift"></i>
            <span>Insentif</span>
        </a>
      </li>

      <li @if(Route::currentRouteName() === 'admin.settings.index') class="active" @endif>
        <a href="{{ route('admin.settings.index') }}">
          <i class="bi bi-gear"></i>
            <span>Pengaturan</span>
        </a>
      </li>

      <li @if(Route::currentRouteName() === 'admin.validasi.index') class="active" @endif>
        <a href="{{ route('admin.validasi.index') }}" class="position-relative">
            <i class="bi bi-check-circle"></i>
            <span>Validasi</span>
            @if(isset($pendingCount) && $pendingCount > 0)
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size:0.7em;">
                    {{ $pendingCount }}
                </span>
            @endif
        </a>
      </li>

      <li @if(Route::currentRouteName() === 'admin.notifications') class="active" @endif>
        <a href="{{ route('admin.notifications') }}">
          <i class="bi bi-bell"></i>
            <span>Notifikasi</span>
        </a>
      </li>

      <li>
        <a href="#">
          <i class="bi bi-newspaper"></i>
          <span>Konten</span>
        </a>
      </li>

      <li>
        <a href="{{ asset('beranda') }}">
          <i class="bi bi-house"></i>
            <span>Beranda</span>
        </a>
      </li>

        <li>
            @if (Auth::check())
                <a href="{{ route('auth.logout') }}">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Logout</span>
                </a>
            @else
                <a href="{{ route('auth.login-form') }}">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Login</span>
                </a>
            @endif
    </ul>
  </div>
</div>