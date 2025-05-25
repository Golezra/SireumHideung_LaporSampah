<div class="footer-nav position-relative footer-style-four shadow-sm">
  <ul class="h-100 d-flex align-items-center justify-content-between ps-0">
    <li @if(Route::currentRouteName() === 'tim-operasional.laporan.menunggu') class="active" @endif>
      <a href="{{ route('tim-operasional.laporan.menunggu') }}">
      <i class="bi bi-truck"></i>
      </a>
      <span>Angkut</span>
    </li>

    <li @if(Route::currentRouteName() === 'tim-operasional.laporan.diangkut') class="active" @endif>
      <a href="{{ route('tim-operasional.laporan.diangkut') }}">
      <i class="bi bi-check-circle"></i>
      </a>
      <span>Diangkut</span>
    </li>

    <li @if(Route::currentRouteName() === 'tim-operasional.dashboard') class="active" @endif>
      <a href="{{ route('tim-operasional.dashboard') }}">
      <i class="bi bi-person"></i>
      </a>
      <span>Dashboard</span>
    </li>

    <li @if(Route::currentRouteName() === 'tim-operasional.penagihan') class="active" @endif>
      <a href="{{ route('tim-operasional.penagihan') }}">
      <i class="bi bi-cash-coin"></i>
      </a>
      <span>Tagih Tunai</span>
    </li>

    {{-- <li>
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
  </li> --}}

    <li>
      <a href="{{ asset('beranda') }}">
        <i class="bi bi-house"></i>
      </a>
      <span>Beranda</span>
    </li>

    {{-- <li>
      <a href="{{ route('halaman.setting') }}">
        <i class="bi bi-gear"></i>
      </a>
      <span>Settings</span>
    </li> --}}
  </ul>
</div>