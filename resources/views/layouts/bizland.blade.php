<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>@yield('title', 'BizLand')</title>
  <meta name="description" content="@yield('meta_description', '')">
  <meta name="keywords" content="@yield('meta_keywords', '')">

  <link href="{{ asset('BizLand/assets/img/favicon.png') }}" rel="icon">
  <link href="{{ asset('BizLand/assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&family=Open+Sans:wght@300;400;500;600;700;800&family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

  <link href="{{ asset('BizLand/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('BizLand/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('BizLand/assets/vendor/aos/aos.css') }}" rel="stylesheet">
  <link href="{{ asset('BizLand/assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
  <link href="{{ asset('BizLand/assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

  <link href="{{ asset('BizLand/assets/css/main.css') }}" rel="stylesheet">
  @stack('styles')
</head>
<body class="@yield('body_class', 'index-page')">
  <header id="header" class="header sticky-top">
    <div class="topbar d-flex align-items-center">
      <div class="container d-flex justify-content-center justify-content-md-between">
        <div class="contact-info d-flex align-items-center">
          <i class="bi bi-envelope d-flex align-items-center"><a href="mailto:contact@example.com">contact@example.com</a></i>
          <i class="bi bi-phone d-flex align-items-center ms-4"><span>+1 5589 55488 55</span></i>
        </div>
        <div class="social-links d-none d-md-flex align-items-center">
          <a href="#" class="twitter"><i class="bi bi-twitter-x"></i></a>
          <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
          <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
          <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
        </div>
      </div>
    </div>

    <div class="branding d-flex align-items-cente">
      <div class="container position-relative d-flex align-items-center justify-content-between">
        @php
          $logo = config('app.logo');
          $logoUrl = null;
          if (!empty($logo)) {
              if (\Illuminate\Support\Str::startsWith($logo, ['http://', 'https://', '/'])) {
                  $logoUrl = $logo;
              } else {
                  $logoUrl = \Illuminate\Support\Facades\Storage::url($logo);
              }
          }
          // Fallback to template logo if not configured
          $logoUrl = $logoUrl ?: asset('BizLand/assets/img/logo.png');
        @endphp
        <a href="{{ route('public.index') }}" class="logo d-flex align-items-center text-decoration-none">
          <img src="{{ $logoUrl }}" alt="{{ config('app.name', 'BizLand') }} logo" class="rounded-circle me-2" style="width: 40px; height: 40px; object-fit: cover;">
          <h1 class="sitename m-0">{{ config('app.name', 'BizLand') }}</h1>
        </a>

        <nav id="navmenu" class="navmenu">
          <ul>
            <li><a href="{{ route('public.index') }}" class="{{ request()->routeIs('public.index') ? 'active' : '' }}">Home</a></li>
            <li><a href="{{ route('public.about') }}" class="{{ request()->routeIs('public.about') ? 'active' : '' }}">About</a></li>
            <li><a href="{{ route('public.services') }}" class="{{ request()->routeIs('public.services') ? 'active' : '' }}">Services</a></li>
            <li><a href="{{ route('public.portfolio') }}" class="{{ request()->routeIs('public.portfolio') ? 'active' : '' }}">Portfolio</a></li>
            <li><a href="{{ route('public.team') }}" class="{{ request()->routeIs('public.team') ? 'active' : '' }}">Team</a></li>
            <li><a href="{{ route('public.blog') }}" class="{{ request()->routeIs('public.blog') ? 'active' : '' }}">Blog</a></li>
            <li><a href="{{ route('public.contact') }}" class="{{ request()->routeIs('public.contact') ? 'active' : '' }}">Contact</a></li>
          </ul>
          <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>
      </div>
    </div>
  </header>

  <main class="main">
    @yield('content')
  </main>

  <footer id="footer" class="footer">
    <div class="container">
      <div class="copyright">
        &copy; <strong><span>{{ config('app.name', 'BizLand') }}</span></strong> {{ date('Y') }}. All Rights Reserved
      </div>
    </div>
  </footer>

  <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <script src="{{ asset('BizLand/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('BizLand/assets/vendor/aos/aos.js') }}"></script>
  <script src="{{ asset('BizLand/assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
  <script src="{{ asset('BizLand/assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
  <script src="{{ asset('BizLand/assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>
  <script src="{{ asset('BizLand/assets/js/main.js') }}"></script>
  @stack('scripts')
</body>
</html>
