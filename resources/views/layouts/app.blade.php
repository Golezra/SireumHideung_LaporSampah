<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Sireum Hideung - PWA Mobile">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate, max-age=0">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!-- Theme Color -->
    <meta name="theme-color" content="#0134d4">

    <!-- Mobile Web App Capable -->
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Title -->
    <title>@yield('title')</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('img/core-img/ant.svg') }}">
    <!-- Apple Touch Icon -->
    <link rel="apple-touch-icon" href="{{ asset('img/icons/icon-96x96.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('img/icons/icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="167x167" href="{{ asset('img/icons/icon-167x167.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/icons/icon-180x180.png') }}">

    <!-- Style CSS -->
    <link rel="stylesheet" href="{{ asset('style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/uicons-bold-rounded.css') }}">

    <!-- Web App Manifest -->
    {{-- <link rel="manifest" href="{{ secure_asset('manifest.json') }}"> --}}
</head>

<body>
    <!-- Preloader -->
    @include('components.preloader')

    <!-- Internet Connection Status -->
    <div class="internet-connection-status" id="internetStatus"></div>

    @yield('content')

    <!-- All JavaScript Files -->
    <script src="{{ asset('js') }}/internet-status.js"></script>
    <script src="{{ asset('js') }}/venobox.min.js"></script>
    <script src="{{ asset('js') }}/countdown.js"></script>
    <script src="{{ asset('js') }}/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js') }}/rangeslider.min.js"></script>
    <script src="{{ asset('js') }}/tiny-slider.js"></script>
    <script src="{{ asset('js') }}/vanilla-dataTables.min.js"></script>
    <script src="{{ asset('js') }}/index.js"></script>
    <script src="{{ asset('js') }}/imagesloaded.pkgd.min.js"></script>
    <script src="{{ asset('js') }}/isotope.pkgd.min.js"></script>
    <script src="{{ asset('js') }}/dark-rtl.js"></script>
    <script src="{{ asset('js') }}/active.js"></script>
    <script src="{{ asset('js') }}/pwa.js"></script>
    <script src="{{ asset('js') }}/slideToggle.min.js"></script>
    <!-- Leaflet JS -->
    @stack('leaflet')

    @section('scripts')
        <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('js/internet-status.js') }}"></script>
        <script src="{{ asset('js/dark-rtl.js') }}"></script>
        <script src="{{ asset('js/pswmeter.js') }}"></script>
        <script src="{{ asset('js/active.js') }}"></script>
        <script src="{{ asset('js/pwa.js') }}"></script>
        <script src="{{ asset('js/countdown.js') }}"></script>
    @endsection

</body>

</html>
