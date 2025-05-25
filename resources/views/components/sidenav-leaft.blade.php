<button class="btn-close btn-close-white text-reset" type="button" data-bs-dismiss="offcanvas"
      aria-label="Close"></button>

    <div class="offcanvas-body p-0">
      <div class="sidenav-wrapper">
        <!-- Sidenav Profile -->
        <div class="sidenav-profile bg-gradient">
          <div class="sidenav-style1"></div>

          <!-- User Thumbnail -->
          <div class="user-profile">
            <img src="{{ asset(Auth::user()->foto_profil ?? 'img/foto-profil/default-fotoprofil.png') }}" alt="">
          </div>

          <!-- User Info -->
          <div class="user-info">
            <h6 class="user-name mb-0">{{ Auth::user()->name }}</h6>
            <span>
                @if (Auth::user()->role === 'user')
                    Warga
                @elseif (Auth::user()->role === 'tim_operasional')
                    Tim Operasional
                @elseif (Auth::user()->role === 'admin')
                    Admin
                @endif
            </span>
            <p class="mb-0 text-white">{{ Auth::user()->rt ?? 'Tidak diketahui' }}</p> <!-- Menampilkan RT -->
          </div>
        </div>

        <!-- Sidenav Nav -->
        <ul class="sidenav-nav ps-0">
          <li>
            <a href="{{asset('home')}}"><i class="bi bi-house-door"></i>Beranda</a>
          </li>

          <li>
            @if (Auth::user()->role === 'warga')
                <a href="{{ route('warga.dashboard') }}"><i class="bi bi-house-door"></i> Dashboard Warga</a>
            @elseif (Auth::user()->role === 'tim_operasional')
                <a href="{{ route('tim-operasional.dashboard') }}"><i class="bi bi-house-door"></i> Dashboard Tim Operasional</a>
            @elseif (Auth::user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}"><i class="bi bi-house-door"></i> Dashboard Admin</a>
            @endif
          </li>

          <li>
            <a href="{{ route('warga.dashboard') }}"><i class="bi bi-person"></i> Akun
              <span class="badge bg-danger rounded-pill ms-2"></span>
            </a>
          </li>
          
            <li>
            <a href="#">
              <i class="bi bi-chat-dots"></i>Pesan
              {{-- @if (Auth::check())
                @php
                  $unreadNotificationsCount = Auth::user()->unreadNotifications
                    ->filter(fn($notification) => isset($notification->data['laporan_id']))
                    ->count();
                @endphp
                @if ($unreadNotificationsCount > 0)
                  <span class="badge bg-danger rounded-pill ms-2">
                    {{ $unreadNotificationsCount }}
                    <span class="visually-hidden">unread messages</span>
                  </span>
                @endif
              @endif --}}
            </a>
            </li>

          <li>
            <a href="#"><i class="bi bi-cash-coin"></i> Pembayaran
              <span class="badge bg-success rounded-pill ms-2"></span>
            </a>
          </li>
          
          <li>
            <a href="#"><i class="bi bi-trash"></i> Sampah</a>
            <ul>
              <li>
                <a href="#">Lapor Sampah</a>
              </li>
              <li>
                <a href="#">Riwayat Lapor</a>
              </li>
            </ul>
          </li>
          <li>
            <a href="#"><i class="bi bi-gear"></i>Pengaturan</a>
          </li>
          <li>
            <div class="night-mode-nav">
              <i class="bi bi-moon"></i>Mode Gelap
              <div class="form-check form-switch">
                <input class="form-check-input form-check-success" id="darkSwitch" type="checkbox">
              </div>
            </div>
          </li>
          <li>
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="bi bi-box-arrow-right"></i>Keluar Akun
            </a>
            <form id="logout-form" action="{{ route('auth.logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
          </li>
        </ul>

        <!-- Social Info -->
        <div class="social-info-wrap">
          <a href="#">
            <i class="bi bi-instagram"></i>
          </a>
          <a href="#">
            <i class="bi bi-facebook"></i>
          </a>
          <a href="#">
            <i class="bi bi-tiktok"></i>
          </a>
          <a href="#">
            <i class="bi bi-telegram"></i>
          </a>
          <a href="#">
            <i class="bi bi-linkedin"></i>
          </a>
        </div>

        <!--alamat -->
        <div class="copyright-info">
          <p>Jl. Gemposari Ciranggon,</p>
          <p>Desa Gempolsari RT 12-13,</p>
          <p>Kecamatan Patokbeusi,</p>
          <p>Kabupaten Subang, Jawa Barat</p>
          <p>41263</p>
        </div>
        
        <!-- Copyright Info -->
        <div class="copyright-info">
          <p>
            <span id="copyrightYear"></span>
            &copy; Made by <a href="#"> Dilan Ariandi</a>
          </p>
            <p><a href="https://www.instagram.com/stttexmaco/">Mahasiswa STT Texmaco</a></p>
            <p><a href="https://www.instagram.com/himatiftexmaco/">Program Studi Teknik Informatika D3</a></p>
        </div>
      </div>
    </div>