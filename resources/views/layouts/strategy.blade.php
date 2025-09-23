<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>@yield('title', config('app.name'))</title>
  <meta name="description" content="@yield('meta_description', config('app.name'))">
  <meta name="keywords" content="@yield('meta_keywords', '')">

  <!-- Favicons -->
  @if(config('app.logo'))
    @php($logo = config('app.logo'))
    @php($logoUrl = \Illuminate\Support\Str::startsWith($logo, ['http://','https://','storage/','/']) ? $logo : 'storage/'.$logo)
    <link href="{{ asset($logoUrl) }}" rel="icon">
  @endif

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700&family=Montserrat:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('Strategy/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('Strategy/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('Strategy/assets/vendor/aos/aos.css') }}" rel="stylesheet">
  <link href="{{ asset('Strategy/assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
  <link href="{{ asset('Strategy/assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="{{ asset('Strategy/assets/css/main.css') }}" rel="stylesheet">

</head>

<body class="index-page">

  <header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container position-relative d-flex align-items-center justify-content-between">
      <a href="{{ route('home') }}" class="logo d-flex align-items-center me-auto me-xl-0">
        @if(config('app.logo'))
          @php($logo = config('app.logo'))
          @php($logoUrl = \Illuminate\Support\Str::startsWith($logo, ['http://','https://','storage/','/']) ? $logo : 'storage/'.$logo)
          <img src="{{ asset($logoUrl) }}" alt="Logo">
        @else
          <h1 class="sitename">{{ config('app.name') }}</h1>
        @endif
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a></li>
          <li><a href="{{ route('public.services') }}" class="{{ request()->routeIs('public.services') ? 'active' : '' }}">Services</a></li>
          <li><a href="{{ route('public.portfolio') }}" class="{{ request()->routeIs('public.portfolio') ? 'active' : '' }}">Portfolio</a></li>
          <li><a href="{{ route('public.contact') }}" class="{{ request()->routeIs('public.contact') ? 'active' : '' }}">Contact</a></li>
          <li>
            <a class="btn btn-sm btn-success ms-lg-3" target="_blank" href="https://wa.me/{{ preg_replace('/\D/', '', config('app.company_whatsapp', '')) }}">
              <i class="bi bi-whatsapp"></i> WhatsApp
            </a>
          </li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>
    </div>
  </header>

  <main class="main">
    @yield('content')
  </main>

  <footer id="footer" class="footer light-background">
    <div class="container">
      <div class="row gy-4">
        <div class="col-lg-6 col-md-12 footer-info">
          <a href="{{ route('home') }}" class="logo d-flex align-items-center">
            @if(config('app.logo'))
              @php($logo = config('app.logo'))
              @php($logoUrl = \Illuminate\Support\Str::startsWith($logo, ['http://','https://','storage/','/']) ? $logo : 'storage/'.$logo)
              <img src="{{ asset($logoUrl) }}" alt="Logo">
            @else
              <span>{{ config('app.name') }}</span>
            @endif
          </a>
          <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All Rights Reserved.</p>
        </div>
      </div>
    </div>
  </footer>

  <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="{{ asset('Strategy/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('Strategy/assets/vendor/php-email-form/validate.js') }}"></script>
  <script src="{{ asset('Strategy/assets/vendor/aos/aos.js') }}"></script>
  <script src="{{ asset('Strategy/assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
  <script src="{{ asset('Strategy/assets/vendor/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
  <script src="{{ asset('Strategy/assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
  <script src="{{ asset('Strategy/assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
  <script src="{{ asset('Strategy/assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>

  <!-- Template Main JS File -->
  <script src="{{ asset('Strategy/assets/js/main.js') }}"></script>

</body>

</html>