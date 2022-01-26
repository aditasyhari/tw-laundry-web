<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>TW - @yield('title')</title>
    <link rel='shortcut icon' type='image/x-icon' href="{{ asset('backend/assets/img/favicon.ico') }}" />
    <link rel="stylesheet" href="{{ asset('backend/assets/css/app.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/components.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/custom.css') }}">

    @yield('css')

</head>

<body>
  <div class="loader"></div>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>
      
      <!-- Navbar -->
      @include('backend.layouts.navbar')
      
      <!-- Sidebar -->
      @include('backend.layouts.sidebar')

      <!-- Content -->
      @yield('content')
      
      <!-- Footer -->
      @include('backend.layouts.footer')
      
    </div>
  </div>

  <script src="{{ asset('backend/assets/js/app.min.js') }}"></script>
  <script src="{{ asset('backend/assets/bundles/apexcharts/apexcharts.min.js') }}"></script>
  <script src="{{ asset('backend/assets/js/page/index.js') }}"></script>
  <script src="{{ asset('backend/assets/js/scripts.js') }}"></script>
  <script src="{{ asset('backend/assets/js/custom.js') }}"></script>

  @yield('js')

</body>

</html>