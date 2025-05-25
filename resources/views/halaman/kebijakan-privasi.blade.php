@extends('layouts.app')

@section('title', 'SH | Kebijakan Privasi')

@section('content')

    @include('components.alert')

    <!-- Back Button -->
    <div class="login-back-button">
        <a href="{{ route('auth.register') }}">
            <i class="bi bi-arrow-left-short"></i>
        </a>
    </div>

    <!-- Page Content Wrapper -->
    <div class="page-content-wrapper py-3">
        <div class="container">
        <div class="card">
            <div class="card-body">
            <h6>KEBIJAKAN PRIVASI</h6>
            <p>Dengan menggunakan atau mengakses layanan dengan cara apa pun, Anda mengakui bahwa Anda menerima praktik dan kebijakan yang diuraikan dalam Kebijakan Privasi ini, dan Anda dengan ini menyetujui bahwa kami akan mengumpulkan, menggunakan, dan membagikan informasi Anda dengan cara berikut.</p>
            <h6>DATA APA YANG KAMI KUMPULKAN DAN MENGAPA KAMI MENGUMPULKANNYA</h6>
            <p>Seperti kebanyakan situs web, kami mengumpulkan informasi tertentu (seperti penyedia layanan seluler, sistem operasi, dll.) secara otomatis dan menyimpannya dalam file log. Kami menggunakan informasi ini, yang tidak mengidentifikasi pengguna individu, untuk menganalisis tren, mengelola situs web, melacak pergerakan pengguna di sekitar situs web, dan mengumpulkan informasi demografis tentang basis pengguna kami secara keseluruhan. Kami dapat menghubungkan beberapa data yang dikumpulkan secara otomatis ini dengan Informasi Identitas Pribadi tertentu.</p>
            <h6>INFORMASI IDENTITAS PRIBADI</h6>
            <p>Jika Anda adalah Klien, saat Anda mendaftar dengan kami melalui Situs Web kami, kami akan meminta beberapa informasi identitas pribadi, seperti nama depan dan belakang Anda, nama perusahaan, alamat email, alamat penagihan, dan informasi kartu kredit. Anda dapat meninjau dan memperbarui informasi identitas pribadi ini di profil Anda dengan masuk dan mengedit informasi tersebut di dasbor Anda. Jika Anda memutuskan untuk menghapus semua informasi Anda, kami dapat membatalkan akun Anda. Kami dapat menyimpan salinan arsip catatan Anda sebagaimana diwajibkan oleh hukum atau untuk tujuan bisnis yang wajar.</p>
            <p>Karena sifat Layanan, kecuali untuk membantu Klien dengan masalah teknis tertentu yang terbatas atau sebagaimana diwajibkan oleh hukum, kami tidak akan mengakses Konten apa pun yang Anda unggah ke Layanan.</p>
            <p>Beberapa Informasi Identitas Pribadi juga dapat diberikan kepada perantara dan pihak ketiga yang membantu kami dengan Layanan, tetapi mereka tidak dapat menggunakan informasi tersebut selain untuk membantu kami menyediakan Layanan. Namun, kecuali sebagaimana diatur dalam Kebijakan Privasi ini, kami tidak akan menyewakan atau menjual Informasi Identitas Pribadi Anda kepada pihak ketiga.</p>
            <h6>PENGGUNAAN INFORMASI</h6>
            <p>Bagi Klien kami, kami menggunakan informasi pribadi terutama untuk menyediakan Layanan dan menghubungi Klien kami terkait aktivitas akun, versi baru, dan penawaran produk, atau komunikasi lain yang relevan dengan Layanan. Kami tidak menjual atau membagikan informasi identitas pribadi atau informasi lain dari Pengguna Akhir kepada pihak ketiga mana pun, kecuali, tentu saja, kepada Klien yang situs webnya Anda gunakan.</p>
            <p>Jika Anda menghubungi kami melalui email atau dengan mengisi formulir pendaftaran, kami dapat menyimpan catatan informasi kontak dan korespondensi Anda dan dapat menggunakan alamat email Anda, serta informasi apa pun yang Anda berikan kepada kami dalam pesan Anda, untuk merespons Anda. Selain itu, kami dapat menggunakan informasi pribadi yang dijelaskan di atas untuk mengirimkan informasi kepada Anda mengenai Layanan. Jika Anda memutuskan kapan saja bahwa Anda tidak lagi ingin menerima informasi atau komunikasi semacam itu dari kami, kirimkan email kepada kami dan minta untuk dihapus dari daftar kami. Keadaan di mana kami dapat membagikan informasi tersebut dengan pihak ketiga dijelaskan di bawah ini dalam “Mematuhi Proses Hukum”.</p>
            <h6>PENYIMPANAN DAN KEAMANAN INFORMASI</h6>
            <p class="mb-0">Kami mengoperasikan jaringan data yang aman yang dilindungi oleh firewall standar industri dan sistem perlindungan kata sandi. Kebijakan keamanan dan privasi kami secara berkala ditinjau dan ditingkatkan sesuai kebutuhan, dan hanya individu yang berwenang yang memiliki akses ke informasi yang diberikan oleh Klien kami.</p>
        </div>
        </div>
    </div>

    <!-- Footer Nav -->
    {{-- <div class="footer-nav-area" id="footerNav">
        <div class="container px-0">
            @include('components.footer')
        </div>
    </div> --}}
@endsection

