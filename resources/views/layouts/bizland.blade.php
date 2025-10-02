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
    /* Theme tokens */
    :root{
      --brand-primary: {{ config('app.brand_primary', '#2563eb') }};
      --brand-accent:  {{ config('app.brand_accent',  '#f59e0b') }};
      --bg: #ffffff; --text: #0f172a; --muted: #475569; --card: #ffffff; --border: #e5e7eb;
    }
    html.dark{
      --bg: #0b1220; --text: #e5eefc; --muted: #a5b4fc; --card: #0f172a; --border: #1f2937;
    }
    body{ background: var(--bg); color: var(--text); }
    .card{ background: var(--card); border-color: var(--border); }
    .text-muted{ color: var(--muted) !important; }
    /* Badge adjustments for dark mode */
    html.dark .badge.bg-secondary{ background-color: #334155 !important; color:#e5eefc; }
    html.dark .badge.bg-light, html.dark .badge.text-bg-light{ background-color: #1f2937 !important; color:#e5eefc !important; border-color:#374151 !important; }
    html.dark .badge.bg-info{ background-color:#0ea5e9 !important; color:#052c4e !important; }

    /* Card hover subtle based on theme */
    .card{ transition: box-shadow .18s ease, transform .18s ease; }
    .card:hover{ transform: translateY(-2px); box-shadow: 0 1rem 2rem rgba(0,0,0,.12); }
    html.dark .card:hover{ box-shadow: 0 1rem 2rem rgba(0,0,0,.5); }

    /* Links contrast in dark mode */
    html.dark a{ color: color-mix(in srgb, var(--brand-primary) 80%, #fff 20%); }
    html.dark a:hover{ color: color-mix(in srgb, var(--brand-primary) 90%, #fff 10%); }

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
            <li><a href="{{ route('public.products') }}" class="{{ request()->routeIs('public.products') ? 'active' : '' }}">Produk</a></li>
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
    <div class="d-flex align-items-center gap-2">
      <button id="themeToggle" class="btn btn-outline-secondary btn-sm" type="button" aria-label="Tema">
        <i class="bi bi-moon-stars" id="themeIcon"></i>
      </button>
    </div>
  </header>

  <main class="main">
    <x-loader />
    <x-section-animator />
    @yield('content')
  </main>

  <footer id="footer" class="footer">
    @php
      $brandName = config('app.name', 'BizLand');
      $contactEmail = config('app.contact_email') ?: config('mail.from.address');
      $contactPhone = config('app.contact_phone');
      $address = config('app.office_address');
      $waNumber = config('app.whatsapp_number');
      $socialFacebook = config('app.social_facebook');
      $socialInstagram = config('app.social_instagram');
      $socialLinkedin = config('app.social_linkedin');
      $socialTwitter = config('app.social_twitter');
      $officeLat = config('app.office_lat');
      $officeLng = config('app.office_lng');
      $officeHours = config('app.office_hours');
      $hasSocial = !empty($socialFacebook) || !empty($socialInstagram) || !empty($socialLinkedin) || !empty($socialTwitter);
    @endphp

    <div class="footer-top">
      <div class="container">
        <div class="row gy-4">
          <div class="col-lg-4 col-md-6">
            <h4 class="mb-2">{{ $brandName }}</h4>
            <p class="text-muted mb-3">Kami berkomitmen memberikan layanan profesional untuk kebutuhan digital bisnis Anda.</p>
            <a href="{{ route('public.order.create') }}" class="btn btn-primary btn-sm">Mulai Order</a>
          </div>
          <div class="col-lg-3 col-md-6">
            <h5 class="mb-2">Kontak</h5>
            <ul class="list-unstyled small">
              @if(!empty($address))
                @php
                  $mapUrl = null;
                  if (!empty($officeLat) && !empty($officeLng)) {
                    $mapUrl = 'https://www.google.com/maps?q=' . $officeLat . ',' . $officeLng;
                  } elseif (!empty($address)) {
                    $mapUrl = 'https://www.google.com/maps?q=' . rawurlencode($address);
                  }
                @endphp
                <li class="mb-2">
                  <i class="bi bi-geo-alt me-2"></i>
                  @if($mapUrl)
                    <a href="{{ $mapUrl }}" target="_blank" rel="noopener" class="text-decoration-none">{{ $address }}</a>
                  @else
                    {{ $address }}
                  @endif
                </li>
              @endif
              @if(!empty($contactPhone))
                <li class="mb-2"><i class="bi bi-telephone me-2"></i>{{ $contactPhone }}</li>
              @endif
              @if(!empty($contactEmail))
                <li class="mb-2"><i class="bi bi-envelope me-2"></i><a class="text-decoration-none" href="mailto:{{ $contactEmail }}">{{ $contactEmail }}</a></li>
              @endif
              <li class="mb-2">
                <i class="bi bi-clock me-2"></i>
                {{ $officeHours ?: 'Senin–Jumat 09:00–17:00' }}
              </li>
            </ul>
          </div>
          <div class="col-lg-3 col-md-6">
            <h5 class="mb-2">Tautan</h5>
            <ul class="list-unstyled footer-links">
              <li><a class="text-decoration-none" href="{{ route('public.index') }}">Beranda</a></li>
              <li><a class="text-decoration-none" href="{{ route('public.about') }}">Tentang</a></li>
              <li><a class="text-decoration-none" href="{{ route('public.products') }}">Produk</a></li>
              <li><a class="text-decoration-none" href="{{ route('public.portfolio') }}">Portfolio</a></li>
              <li><a class="text-decoration-none" href="{{ route('public.contact') }}">Kontak</a></li>
            </ul>
            @if($hasSocial)
              <div class="col-lg-2 col-md-6">
                <h5 class="mb-2">Ikuti Kami</h5>
                <div class="d-flex gap-2">
                  @if(!empty($socialFacebook))
                    <a href="{{ $socialFacebook }}" target="_blank" rel="noopener" class="btn btn-outline-secondary btn-sm rounded-circle" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                  @endif
                  @if(!empty($socialInstagram))
                    <a href="{{ $socialInstagram }}" target="_blank" rel="noopener" class="btn btn-outline-secondary btn-sm rounded-circle" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                  @endif
                  @if(!empty($socialLinkedin))
                    <a href="{{ $socialLinkedin }}" target="_blank" rel="noopener" class="btn btn-outline-secondary btn-sm rounded-circle" aria-label="LinkedIn"><i class="bi bi-linkedin"></i></a>
                  @endif
                  @if(!empty($socialTwitter))
                    <a href="{{ $socialTwitter }}" target="_blank" rel="noopener" class="btn btn-outline-secondary btn-sm rounded-circle" aria-label="Twitter"><i class="bi bi-twitter-x"></i></a>
                  @endif
                </div>
              </div>
            @endif
          </div>
        </div>
      </div>
    </div>

    <div class="container border-top pt-3 mt-3">
      <div class="d-flex flex-column flex-md-row align-items-center justify-content-between gap-2 small">
        <div class="copyright mb-1 mb-md-0">
          &copy; <strong><span>{{ $brandName }}</span></strong> {{ date('Y') }}. All Rights Reserved
        </div>
        <div class="d-flex align-items-center gap-3">
          @if(!empty($contactEmail))
            <a href="mailto:{{ $contactEmail }}" class="text-decoration-none"><i class="bi bi-envelope me-1"></i>{{ $contactEmail }}</a>
          @endif
          @if(!empty($waNumber))
            @php
              $waDigits = preg_replace('/\D/','',(string) $waNumber);
              if (\Illuminate\Support\Str::startsWith($waDigits,'0')) { $waDigits = '62'.substr($waDigits,1); }
            @endphp
            <a href="https://wa.me/{{ $waDigits }}" target="_blank" rel="noopener" class="text-decoration-none"><i class="bi bi-whatsapp me-1"></i>{{ $waNumber }}</a>
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
  <script src="{{ asset('BizLand/assets/vendor/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
  <script src="{{ asset('BizLand/assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
  <script src="{{ asset('BizLand/assets/js/main.js') }}"></script>
  
  <!-- Interactive polish: skeletons, smooth scroll, and AOS init -->
  <style>
    /* Skeleton shimmer for images/blocks */
    .skeleton{ position: relative; background: #e9edf3; overflow: hidden; }
    .skeleton::after{ content:""; position:absolute; inset:0; transform: translateX(-100%);
      background: linear-gradient(90deg, rgba(255,255,255,0) 0%, rgba(255,255,255,.55) 50%, rgba(255,255,255,0) 100%);
      animation: skeletonShimmer 1.3s infinite; }
    @keyframes skeletonShimmer{ 0%{ transform: translateX(-100%);} 100%{ transform: translateX(100%);} }
    /* Subtle fade-in for media */
    .img-fade{ opacity:0; transition: opacity .35s ease; }
    .img-fade.is-loaded{ opacity:1; }
  </style>
  <script>
    (function(){
      // Respect reduced motion
      var prefersReduced = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

      // Init AOS once vendors are ready
      if (typeof AOS !== 'undefined') {
        AOS.init({
          once: true,
          duration: prefersReduced ? 0 : 600,
          easing: 'ease-out-cubic',
          offset: 80,
          disable: prefersReduced
        });
      }

      // Smooth anchor scrolling within page
      document.addEventListener('click', function(e){
        var a = e.target.closest('a[href^="#"]');
        if (!a) return;
        var href = a.getAttribute('href');
        if (href.length <= 1) return;
        var target = document.querySelector(href);
        if (!target) return;
        e.preventDefault();
        try { target.scrollIntoView({ behavior: prefersReduced ? 'auto' : 'smooth', block: 'start' }); } catch(_) { location.hash = href; }
      });

      // Progressive image enhancement: lazy + skeleton + fade
      var imgs = document.querySelectorAll('main img');
      imgs.forEach(function(img){
        if (!img.hasAttribute('loading')) img.setAttribute('loading', 'lazy');
        if (!img.hasAttribute('decoding')) img.setAttribute('decoding', 'async');
        if (!img.classList.contains('img-fade')) img.classList.add('img-fade');
        // apply skeleton only if not already visible (no background/transparent PNG edge-cases ignored)
        if (!img.classList.contains('no-skeleton')) {
          var ph = document.createElement('span');
          ph.className = 'skeleton';
          // Wrap image with skeleton container
          var wrap = document.createElement('span');
          wrap.style.display = 'inline-block';
          wrap.style.position = 'relative';
          // Insert wrapper before image
          img.parentNode.insertBefore(wrap, img);
          wrap.appendChild(ph);
          wrap.appendChild(img);
          // Size placeholder to image when it loads
          function onLoad(){
            img.classList.add('is-loaded');
            ph.remove();
          }
          if (img.complete) { onLoad(); } else { img.addEventListener('load', onLoad, { once: true }); img.addEventListener('error', onLoad, { once: true }); }
        }
      });
    })();
  </script>
  <style>
    /* Loader styles */
    .app-loader{position:fixed;inset:0;background:rgba(255,255,255,.95);z-index:2000;transition:opacity .3s ease, visibility .3s ease}
    .app-loader.hidden{opacity:0;visibility:hidden}

    /* Micro-interactions for cards (portfolio & general items) */
    .portfolio .card, .portfolio-item .card { transition: transform .18s ease, box-shadow .18s ease; }
    .portfolio .card:hover, .portfolio-item .card:hover { transform: translateY(-4px); box-shadow: 0 12px 24px rgba(0,0,0,.12); }
    .portfolio .card img { transition: transform .25s ease; }
    .portfolio .card:hover img { transform: scale(1.02); }

    /* Testimonials spacing & typography refinement */
    #testimonials .swiper-slide .p-4 { line-height: 1.75; }
    #testimonials .swiper-slide p { font-size: 1.05rem; }
    #testimonials .swiper-slide .small { letter-spacing: .2px; }
  </style>
  <script>
    (function(){
      // Theme toggle with persistence
      try{
        var saved = localStorage.getItem('theme');
        if (saved === 'dark' || (!saved && window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
          document.documentElement.classList.add('dark');
        }
        var btn = document.getElementById('themeToggle');
        var ico = document.getElementById('themeIcon');
        function syncIcon(){ ico && (ico.className = document.documentElement.classList.contains('dark') ? 'bi bi-brightness-high' : 'bi bi-moon-stars'); }
        syncIcon();
        if (btn) btn.addEventListener('click', function(){
          document.documentElement.classList.toggle('dark');
          localStorage.setItem('theme', document.documentElement.classList.contains('dark') ? 'dark' : 'light');
          syncIcon();
        });
      }catch(e){}

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
