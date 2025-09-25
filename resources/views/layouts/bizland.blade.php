<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>@yield('title', 'BizLand')</title>
  <meta name="description" content="@yield('meta_description', '')">
  <meta name="keywords" content="@yield('meta_keywords', '')">

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
    $logoUrl = $logoUrl ?: asset('BizLand/assets/img/logo.png');
  @endphp
  <link href="{{ $logoUrl }}" rel="icon">
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
  <style>
    /* Global button style aligned to brand */
    /* .btn-get-started{
      display:inline-flex; align-items:center; justify-content:center;
      background: var(--brand-primary, #2563eb); color:#fff; border:0; border-radius:.5rem;
      padding:.5rem 9rem; min-height: 30px; line-height:1.1; font-weight:500;
      transition:.18s ease; box-shadow: 0 4px 14px rgba(37,99,235,.18)
    } */
    .btn-get-started:hover{background: color-mix(in srgb, var(--brand-primary, #2563eb) 85%, #000 15%); color:#fff; transform: translateY(-1px); box-shadow: 0 8px 18px rgba(37,99,235,.22)}
    /* Navbar active underline */
    .navmenu a{position:relative}
    .navmenu a.active:after, .navmenu a:hover:after{content:""; position:absolute; left:0; right:0; bottom:-6px; height:3px; background: var(--brand-primary, #2563eb); border-radius:2px}
  </style>
  @stack('styles')
</head>
<body class="@yield('body_class', 'index-page')">
  <header id="header" class="header sticky-top">
    <div class="topbar d-flex align-items-center">
      <div class="container d-flex justify-content-center justify-content-md-between">
        <div class="contact-info d-flex align-items-center">
          <i class="bi bi-envelope d-flex align-items-center"><a href="mailto:akar@gmail.com">akar@gmail.com</a></i>
          <i class="bi bi-phone d-flex align-items-center ms-4"><span>085156553226</span></i>
        </div>
        <div class="social-links d-none d-md-flex align-items-center">
          <!-- <a href="#" class="twitter"><i class="bi bi-twitter-x"></i></a> -->
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
          <ul class="align-items-center">
            <li><a href="{{ route('public.index') }}" class="{{ request()->routeIs('public.index') ? 'active' : '' }}">Beranda</a></li>
            <li><a href="{{ route('public.about') }}" class="{{ request()->routeIs('public.about') ? 'active' : '' }}">Tentang</a></li>
            <li><a href="{{ route('public.services') }}" class="{{ request()->routeIs('public.services') ? 'active' : '' }}">Layanan</a></li>
            <li><a href="{{ route('public.portfolio') }}" class="{{ request()->routeIs('public.portfolio') ? 'active' : '' }}">Portfolio</a></li>
            <li><a href="{{ route('public.team') }}" class="{{ request()->routeIs('public.team') ? 'active' : '' }}">Tim</a></li>
            <li><a href="{{ route('public.blog') }}" class="{{ request()->routeIs('public.blog') ? 'active' : '' }}">Blog</a></li>
            <li><a href="{{ route('public.contact') }}" class="{{ request()->routeIs('public.contact') ? 'active' : '' }}">Kontak</a></li>
            <li class="nav-item ms-xl-2 mt-2 mt-xl-0">
              <a href="{{ route('public.order.create') }}" class="btn btn-primary fw-semibold px-3 py-2 text-white" role="button">Order Sekarang</a>
            </li>
          </ul>
          <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>
      </div>
    </div>
  </header>

  <main class="main">
    <x-loader />
    <x-section-animator />
    @yield('content')
  </main>

  <footer id="footer" class="footer">
    <div class="container">
      @php
        $footerEmail = 'akar@gmail.com';
        $footerWa = config('app.whatsapp_number');
      @endphp
      <div class="d-flex flex-column flex-md-row align-items-center justify-content-between gap-2 small">
        <div class="copyright mb-1 mb-md-0">
          &copy; <strong><span>{{ config('app.name', 'BizLand') }}</span></strong> {{ date('Y') }}. All Rights Reserved
        </div>
        <div class="d-flex align-items-center gap-3">
          @if(!empty($footerEmail))
            <a href="mailto:{{ $footerEmail }}" class="text-decoration-none"><i class="bi bi-envelope me-1"></i>{{ $footerEmail }}</a>
          @endif
          @if(!empty($footerWa))
            @php
              $waDigits = preg_replace('/\D/','',(string) $footerWa);
              if (\Illuminate\Support\Str::startsWith($waDigits,'0')) { $waDigits = '62'.substr($waDigits,1); }
            @endphp
            <a href="https://wa.me/{{ $waDigits }}" target="_blank" rel="noopener" class="text-decoration-none"><i class="bi bi-whatsapp me-1"></i>{{ $footerWa }}</a>
          @endif
        </div>
      </div>
    </div>
  </footer>

  <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  @php
    // Nomor WA dari config/env agar mudah diganti
    $waRaw = config('app.whatsapp_number', '085156553226');
    // Normalisasi nomor WA ke format internasional (Indonesia default 62)
    $waDigits = preg_replace('/\D/', '', (string) $waRaw);
    if (\Illuminate\Support\Str::startsWith($waDigits, '0')) {
      $waInternational = '62' . substr($waDigits, 1);
    } else {
      $waInternational = $waDigits;
    }
    $waMessage = 'Halo, saya ingin konsultasi gratis.';
    $waLink = 'https://wa.me/' . $waInternational . '?text=' . rawurlencode($waMessage);
    // Auto-open seconds dari config (0 = nonaktif). Hanya aktif di halaman Home.
    $waAutoOpenSeconds = (int) (config('app.whatsapp_auto_open_seconds', 0));
    $waAutoOpenEnabled = $waAutoOpenSeconds > 0 && request()->routeIs('public.index');
  @endphp

  <style>
    .wa-toggle { position: fixed; left: 20px; bottom: 20px; width: 56px; height: 56px; display: flex; align-items: center; justify-content: center; z-index: 1055; box-shadow: 0 6px 20px rgba(0,0,0,.2); }
    .wa-popup { position: fixed; left: 20px; bottom: 90px; width: 320px; max-width: calc(100% - 40px); display: none; z-index: 1055; border-radius: .75rem; }
    .wa-popup.show { display: block; }
    .wa-popup .card-header { background: #25D366; color: #fff; }
    /* Icon attention animation */
    .wa-toggle .bi-whatsapp { animation: waPulse 1.8s ease-in-out infinite; transform-origin: center; }
    @keyframes waPulse {
      0% { transform: scale(1); filter: drop-shadow(0 0 0 rgba(37,211,102,.0)); }
      50% { transform: scale(1.08); filter: drop-shadow(0 0 10px rgba(37,211,102,.35)); }
      100% { transform: scale(1); filter: drop-shadow(0 0 0 rgba(37,211,102,.0)); }
    }
    @media (max-width: 576px) { .wa-toggle { left: 16px; bottom: 16px; } .wa-popup { left: 16px; bottom: 84px; } }
  </style>

  <button id="waToggleBtn" class="wa-toggle btn btn-success rounded-circle" aria-label="WhatsApp Chat">
    <i class="bi bi-whatsapp fs-3"></i>
    <span class="visually-hidden">Buka WhatsApp</span>
  </button>

  <div id="waPopup" class="wa-popup card shadow-lg">
    <div class="card-header d-flex align-items-center justify-content-between">
      <div class="fw-semibold">Konsultasi Gratis</div>
      <button type="button" class="btn-close btn-close-white" aria-label="Tutup" id="waCloseBtn"></button>
    </div>
    <div class="card-body">
      <p class="mb-3">Hai! Tim kami siap membantu Anda. Klik tombol di bawah untuk mulai chat via WhatsApp.</p>
      <a href="{{ $waLink }}" target="_blank" rel="noopener" class="btn btn-success w-100"><i class="bi bi-whatsapp me-2"></i>Chat via WhatsApp</a>
      <div class="form-text mt-2">Nomor: {{ $waRaw }}</div>
    </div>
  </div>

  <script src="{{ asset('BizLand/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('BizLand/assets/vendor/aos/aos.js') }}"></script>
  <script src="{{ asset('BizLand/assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
  <script src="{{ asset('BizLand/assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
  <script src="{{ asset('BizLand/assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>
  <script src="{{ asset('BizLand/assets/js/main.js') }}"></script>
  <style>
    /* Loader styles */
    .app-loader{position:fixed;inset:0;background:rgba(255,255,255,.95);z-index:2000;transition:opacity .3s ease, visibility .3s ease}
    .app-loader.hidden{opacity:0;visibility:hidden}
  </style>
  <script>
    (function(){
      // Hide loader after window load
      var appLoader = document.getElementById('appLoader');
      if (appLoader){
        window.addEventListener('load', function(){
          setTimeout(function(){ appLoader.classList.add('hidden'); }, 150);
        });
      }

      // WhatsApp popup logic (single IIFE)
      var toggleBtn = document.getElementById('waToggleBtn');
      var popup = document.getElementById('waPopup');
      var closeBtn = document.getElementById('waCloseBtn');
      var chatBtn = popup ? popup.querySelector('a.btn.btn-success') : null;

      function togglePopup(e){ if (e) e.preventDefault(); if (!popup) return; popup.classList.toggle('show'); }
      function closePopup(){ if (!popup) return; popup.classList.remove('show'); }

      if (toggleBtn) toggleBtn.addEventListener('click', togglePopup);
      if (closeBtn) closeBtn.addEventListener('click', closePopup);
      document.addEventListener('click', function(e){
        if (!popup) return;
        var isInside = popup.contains(e.target) || (toggleBtn && toggleBtn.contains(e.target));
        if (!isInside) closePopup();
      });

      // gtag tracking jika tersedia
      function track(eventName, label){
        if (typeof gtag === 'function') {
          try {
            gtag('event', eventName, { event_category: 'engagement', event_label: label || 'whatsapp', value: 1 });
          } catch (err) {}
        }
      }
      if (toggleBtn) toggleBtn.addEventListener('click', function(){ track('whatsapp_toggle_click', 'toggle'); });
      if (chatBtn) chatBtn.addEventListener('click', function(){ track('whatsapp_chat_click', 'chat_button'); });

      // Auto-open setelah X detik pada halaman tertentu (Home)
      var autoOpenEnabled = {{ $waAutoOpenEnabled ? 'true' : 'false' }};
      var autoOpenSeconds = {{ $waAutoOpenSeconds }};
      var autoCloseSeconds = {{ (int) config('app.whatsapp_auto_close_seconds', 6) }}; // default 6s
      if (autoOpenEnabled && autoOpenSeconds > 0 && toggleBtn) {
        setTimeout(function(){
          if (popup && !popup.classList.contains('show')) {
            popup.classList.add('show');
            track('whatsapp_popup_auto_open', 'auto_open');
            if (autoCloseSeconds > 0) {
              setTimeout(function(){
                if (popup.classList.contains('show')) {
                  popup.classList.remove('show');
                  track('whatsapp_popup_auto_close', 'auto_close');
                }
              }, autoCloseSeconds * 1000);
            }
          }
        }, autoOpenSeconds * 1000);
      }
    })();
  </script>
  @stack('scripts')
</body>
</html>
