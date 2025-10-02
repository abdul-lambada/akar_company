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
      /* Auto contrast resolved colors for text on brand backgrounds */
      --on-primary: #ffffff; --on-accent: #0b1220;
      /* Bridge to Bootstrap vars */
      --bs-primary: var(--brand-primary);
      --bs-link-color: var(--brand-primary);
      /* Bridge to BizLand vendor vars so vendor CSS follows our theme */
      --background-color: var(--bg);
      --default-color: var(--text);
      --heading-color: var(--text);
      --accent-color: var(--brand-primary);
      --surface-color: var(--card);
      --contrast-color: var(--on-primary);
      --nav-color: var(--text);
      --nav-hover-color: var(--brand-primary);
      --nav-mobile-background-color: var(--card);
      --nav-dropdown-background-color: var(--card);
      --nav-dropdown-color: var(--text);
      --nav-dropdown-hover-color: var(--brand-primary);
    }
    html.dark{
      --bg: #0b1220; --text: #e5eefc; --muted: #a5b4fc; --card: #0f172a; --border: #1f2937;
      --on-primary: #ffffff; --on-accent: #0b1220;
      /* Update vendor bridges in dark mode */
      --background-color: var(--bg);
      --default-color: var(--text);
      --heading-color: var(--text);
      --accent-color: var(--brand-primary);
      --surface-color: var(--card);
      --contrast-color: var(--on-primary);
      --nav-color: var(--text);
      --nav-hover-color: var(--brand-primary);
      --nav-mobile-background-color: var(--card);
      --nav-dropdown-background-color: var(--card);
      --nav-dropdown-color: var(--text);
      --nav-dropdown-hover-color: var(--brand-primary);
    }
    body{ background: var(--bg); color: var(--text); }
    /* Global surfaces follow theme tokens */
    .section{ background: var(--bg); color: var(--text); }
    .light-background{ background: color-mix(in srgb, var(--bg) 92%, #fff 8%); }
    html.dark .light-background{ background: color-mix(in srgb, var(--bg) 92%, #000 8%); }
    .dark-background{ background: color-mix(in srgb, var(--bg) 80%, #000 20%); color: var(--text); }
    .header, .footer{ background: var(--card); border-color: var(--border); }
    .border, .border-top, .border-bottom, .border-start, .border-end{ border-color: var(--border) !important; }
    .card{ background: var(--card); border-color: var(--border); }
    .text-muted{ color: var(--muted) !important; }
    /* Map common fixed-color utilities to theme tokens */
    .bg-white{ background-color: #ffffff !important; }
    html.dark .bg-white{ background-color: var(--card) !important; }
    .text-dark{ color: #0f172a !important; }
    html.dark .text-dark{ color: var(--text) !important; }
    .text-black{ color: #000 !important; }
    html.dark .text-black{ color: var(--text) !important; }
    html.dark .bg-light{ background-color: color-mix(in srgb, var(--bg) 92%, #000 8%) !important; }
    html.dark .text-bg-light{ background-color: color-mix(in srgb, var(--bg) 92%, #000 8%) !important; color: var(--text) !important; border-color: var(--border) !important; }
    html.dark .border-white{ border-color: var(--border) !important; }
    /* Badge adjustments for dark mode */
    html.dark .badge.bg-secondary{ background-color: #334155 !important; color:#e5eefc; }
    html.dark .badge.bg-light, html.dark .badge.text-bg-light{ background-color: #1f2937 !important; color:#e5eefc !important; border-color:#374151 !important; }
    html.dark .badge.bg-info{ background-color:#0ea5e9 !important; color:#052c4e !important; }

    /* Bootstrap components: dark variants */
    html.dark .navbar, html.dark .offcanvas, html.dark .dropdown-menu, html.dark .modal-content,
    html.dark .list-group, html.dark .accordion-item, html.dark .toast{ background-color: var(--card); color: var(--text); border-color: var(--border); }
    html.dark .dropdown-menu, html.dark .offcanvas, html.dark .modal-content{ border-color: var(--border); }
    html.dark .list-group-item{ background-color: var(--card); color: var(--text); border-color: var(--border); }
    html.dark .form-control, html.dark .form-select, html.dark .input-group-text,
    html.dark .form-check-input{ background-color: color-mix(in srgb, var(--card) 92%, #000 8%); color: var(--text); border-color: var(--border); }
    html.dark .form-control::placeholder{ color: color-mix(in srgb, var(--text) 55%, #fff 45%); }
    html.dark .form-control:focus, html.dark .form-select:focus{ border-color: color-mix(in srgb, var(--brand-primary) 60%, var(--border) 40%); box-shadow: 0 0 0 .25rem rgba(37,99,235,.25); }
    html.dark .table{ color: var(--text); }
    html.dark .table thead th{ background: color-mix(in srgb, var(--card) 92%, #000 8%); border-color: var(--border); }
    html.dark .table td, html.dark .table th{ border-color: var(--border); }
    html.dark .table-striped > tbody > tr:nth-of-type(odd) { background-color: color-mix(in srgb, var(--card) 96%, #000 4%); }
    html.dark .pagination .page-link{ background: var(--card); color: var(--text); border-color: var(--border); }
    html.dark .pagination .page-item.active .page-link{ background: var(--brand-primary); color: #fff; border-color: var(--brand-primary); }
    html.dark .breadcrumb{ --bs-breadcrumb-divider-color: var(--muted); }
    html.dark .breadcrumb .breadcrumb-item, html.dark .breadcrumb .breadcrumb-item a{ color: var(--muted); }
    html.dark .alert{ background-color: color-mix(in srgb, var(--card) 92%, #000 8%); color: var(--text); border-color: var(--border); }
    html.dark hr{ border-color: var(--border); opacity: 1; }
    html.dark code, html.dark pre{ background: #0b213f; color: #e5eefc; }

    /* Navigation menu + mobile dropdown */
    html.dark .navmenu a{ color: var(--text); }
    html.dark .navmenu a.active:after, html.dark .navmenu a:hover:after{ background: var(--brand-primary); }
    html.dark .navmenu ul{ background: var(--card); }

    /* Readability upgrades for dark mode: ensure sufficient contrast for dimmed text */
    html.dark p, html.dark li, html.dark small, html.dark .small, html.dark .lead{ color: color-mix(in srgb, var(--text) 88%, #fff 12%) !important; }
    html.dark .text-muted{ color: color-mix(in srgb, var(--text) 70%, #fff 30%) !important; }
    html.dark .breadcrumbs, html.dark .page-title, html.dark .page-title .breadcrumbs ol li, html.dark .page-title .breadcrumbs ol li a{ color: color-mix(in srgb, var(--text) 80%, #fff 20%) !important; }
    html.dark .section-title p{ color: var(--text) !important; }
    html.dark .section-title .description-title{ color: color-mix(in srgb, var(--brand-primary) 85%, #fff 15%) !important; }

    /* Cards & links */
    html.dark .card .card-title, html.dark .card .card-title a, html.dark a.card-title{ color: var(--text) !important; }
    html.dark .card .card-text{ color: color-mix(in srgb, var(--text) 82%, #fff 18%) !important; }
    html.dark .card a:not(.btn):not(.stretched-link){ color: color-mix(in srgb, var(--brand-primary) 90%, #fff 10%) !important; }

    /* Service/portfolio/blog helper sections from vendor CSS */
    html.dark .services .service-item p,
    html.dark .featured-services .service-item p,
    html.dark .portfolio .portfolio-item .portfolio-info p,
    html.dark .blog .entry-meta, html.dark .blog .entry-content p{
      color: color-mix(in srgb, var(--text) 82%, #fff 18%) !important;
    }

    /* Outline buttons contrast in dark */
    html.dark .btn-outline-secondary{ color: color-mix(in srgb, var(--text) 90%, #fff 10%) !important; border-color: color-mix(in srgb, var(--text) 35%, var(--border) 65%) !important; }
    html.dark .btn-outline-secondary:hover{ background: color-mix(in srgb, var(--text) 8%, var(--card) 92%) !important; }
    html.dark .btn-outline-dark{ color: var(--text) !important; border-color: color-mix(in srgb, var(--text) 35%, var(--border) 65%) !important; }
    html.dark .btn-outline-light{ color: var(--text) !important; border-color: var(--border) !important; }

    /* Inputs inside dark cards sometimes get low-contrast placeholder */
    html.dark .form-control::placeholder{ color: color-mix(in srgb, var(--text) 65%, #fff 35%) !important; }

    /* Text utilities */
    html.dark .text-secondary{ color: color-mix(in srgb, var(--text) 75%, #fff 25%) !important; }
    html.dark .text-body{ color: var(--text) !important; }
    html.dark .text-white-50{ color: color-mix(in srgb, #ffffff 60%, var(--text) 40%) !important; }

    /* Subtle variants */
    html.dark .text-bg-secondary{ background-color: #334155 !important; color:#e5eefc !important; }
    html.dark .text-bg-info{ background-color:#0ea5e9 !important; color:#052c4e !important; }
    html.dark .text-bg-success{ background-color:#22c55e !important; color:#052c4e !important; }

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
    .btn-get-started{ color: var(--on-primary); }
    .btn-get-started:hover{background: color-mix(in srgb, var(--brand-primary, #2563eb) 85%, #000 15%); color: var(--on-primary); transform: translateY(-1px); box-shadow: 0 8px 18px rgba(37,99,235,.22)}
    /* Ensure bootstrap primary buttons use auto on-color */
    .btn.btn-primary, .btn-primary{ background: var(--brand-primary) !important; border-color: var(--brand-primary) !important; color: var(--on-primary) !important; }
    .btn-primary:hover, .btn-primary:focus{ background: color-mix(in srgb, var(--brand-primary) 85%, #000 15%) !important; border-color: color-mix(in srgb, var(--brand-primary) 85%, #000 15%) !important; color: var(--on-primary) !important; }
    .btn-outline-primary{ color: var(--brand-primary) !important; border-color: var(--brand-primary) !important; }
    .btn-outline-primary:hover{ background: var(--brand-primary) !important; color: var(--on-primary) !important; }

    /* Map utility colors to brand tokens */
    .bg-primary, .text-bg-primary{ background-color: var(--brand-primary) !important; color: var(--on-primary) !important; }
    .border-primary{ border-color: var(--brand-primary) !important; }
    .link-primary{ color: var(--brand-primary) !important; }
    .text-primary{ color: var(--brand-primary) !important; }
    .badge.bg-primary, .badge.text-bg-primary{ background-color: var(--brand-primary) !important; color: var(--on-primary) !important; }
    .alert-primary{ background-color: color-mix(in srgb, var(--brand-primary) 15%, var(--card) 85%) !important; border-color: color-mix(in srgb, var(--brand-primary) 40%, var(--border) 60%) !important; color: var(--text) !important; }
    /* Soft brand badge used by section headings */
    .badge-brand-soft{ background: color-mix(in srgb, var(--brand-primary) 12%, #fff 88%) !important; color: var(--brand-primary) !important; border: 1px solid color-mix(in srgb, var(--brand-primary) 30%, #fff 70%) !important; }
    html.dark .badge-brand-soft{ background: color-mix(in srgb, var(--brand-primary) 16%, var(--bg) 84%) !important; color: color-mix(in srgb, var(--brand-primary) 85%, #fff 15%) !important; border-color: color-mix(in srgb, var(--brand-primary) 30%, var(--border) 70%) !important; }

    /* Accent helpers (custom) */
    .btn-accent{ background: var(--brand-accent) !important; border-color: var(--brand-accent) !important; color: var(--on-accent) !important; }
    .btn-accent:hover, .btn-accent:focus{ background: color-mix(in srgb, var(--brand-accent) 85%, #000 15%) !important; border-color: color-mix(in srgb, var(--brand-accent) 85%, #000 15%) !important; color: var(--on-accent) !important; }
    .bg-accent, .text-bg-accent{ background-color: var(--brand-accent) !important; color: var(--on-accent) !important; }
    .border-accent{ border-color: var(--brand-accent) !important; }
    .badge.bg-accent, .badge.text-bg-accent{ background-color: var(--brand-accent) !important; color: var(--on-accent) !important; }
    /* Additional component mappings */
    .nav-pills .nav-link.active, .nav-pills .show > .nav-link{ background: var(--brand-primary) !important; color: var(--on-primary) !important; }
    .list-group-item.active{ background: var(--brand-primary) !important; border-color: var(--brand-primary) !important; color: var(--on-primary) !important; }
    .progress-bar{ background-color: var(--brand-primary) !important; }
    .form-check-input:checked{ background-color: var(--brand-primary) !important; border-color: var(--brand-primary) !important; }
    .form-switch .form-check-input:checked{ background-color: var(--brand-primary) !important; border-color: var(--brand-primary) !important; }
    .page-link:hover{ color: var(--on-primary) !important; background: color-mix(in srgb, var(--brand-primary) 15%, var(--card) 85%) !important; border-color: var(--brand-primary) !important; }
    .btn-link{ color: var(--brand-primary) !important; }
    .form-range::-webkit-slider-thumb{ background: var(--brand-primary); }
    .form-range::-moz-range-thumb{ background: var(--brand-primary); }
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
            <li class="nav-item ms-xl-2 mt-2 mt-xl-0">
              <button id="themeToggle" class="btn btn-outline-secondary btn-sm" type="button" aria-label="Tema">
                <i class="bi bi-moon-stars" id="themeIcon"></i>
              </button>
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
      // Skip images in header/hero or those explicitly opted-out with .no-skeleton
      var imgs = document.querySelectorAll('main img');
      imgs.forEach(function(img){
        // Skip header/hero or opted-out
        if (img.closest('header') || img.closest('#hero') || img.closest('.hero') || img.classList.contains('no-skeleton')) { return; }
        if (!img.hasAttribute('loading')) img.setAttribute('loading', 'lazy');
        if (!img.hasAttribute('decoding')) img.setAttribute('decoding', 'async');
        if (!img.classList.contains('img-fade')) img.classList.add('img-fade');
        // apply skeleton only if not already visible (no background/transparent PNG edge-cases ignored)
        {
          var ph = document.createElement('span');
          ph.className = 'skeleton';
          // Wrap image with skeleton container
          var wrap = document.createElement('span');
          wrap.style.display = 'block';
          wrap.style.position = 'relative';
          wrap.style.width = '100%';
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
        function hexToRgb(hex){ hex = (hex||'').trim(); if (hex.startsWith('rgb')){ try{ return hex.match(/\d+/g).map(Number).slice(0,3); }catch(e){ return [37,99,235]; } } hex = hex.replace('#',''); if (hex.length===3){ hex = hex.split('').map(function(c){return c+c;}).join(''); } var int = parseInt(hex,16); if (isNaN(int)) return [37,99,235]; return [(int>>16)&255,(int>>8)&255,int&255]; }
        function relLum(c){ var a=c.map(function(v){v/=255; return v<=0.03928? v/12.92: Math.pow((v+0.055)/1.055,2.4);}); return 0.2126*a[0]+0.7152*a[1]+0.0722*a[2]; }
        function contrastRatio(bg, fg){ var L1 = relLum(bg), L2 = relLum(fg); var hi=Math.max(L1,L2), lo=Math.min(L1,L2); return (hi+0.05)/(lo+0.05); }
        function pickOnColor(bgHex){ var bg = hexToRgb(bgHex); var white=[255,255,255], black=[0,0,0]; var cWhite = contrastRatio(bg, white); var cBlack = contrastRatio(bg, black); // prefer >=4.5, else higher
          if (cWhite>=4.5 && cWhite>=cBlack) return '#ffffff';
          if (cBlack>=4.5 && cBlack>cWhite) return '#000000';
          return cWhite>=cBlack? '#ffffff':'#000000'; }
        function setAutoContrast(){
          try{
            var cs = getComputedStyle(document.documentElement);
            var bp = cs.getPropertyValue('--brand-primary').trim() || '#2563eb';
            var ba = cs.getPropertyValue('--brand-accent').trim() || '#f59e0b';
            document.documentElement.style.setProperty('--on-primary', pickOnColor(bp));
            document.documentElement.style.setProperty('--on-accent', pickOnColor(ba));
          }catch(e){}
        }
        syncIcon();
        setAutoContrast();
        if (btn) btn.addEventListener('click', function(){
          document.documentElement.classList.toggle('dark');
          localStorage.setItem('theme', document.documentElement.classList.contains('dark') ? 'dark' : 'light');
          syncIcon();
          setAutoContrast();
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
