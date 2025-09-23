<!DOCTYPE html>
<html lang="{{ str_replace('_','-', config('app.locale', 'id')) }}" class="no-js">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="{{ asset('public_template/img/fav.png') }}">
    <title>@yield('title', config('app.name'))</title>

    <!-- Base Meta: Description / Canonical / Open Graph / Twitter -->
    <meta name="description" content="@yield('meta_description', config('app.meta_description', 'Solusi layanan digital, desain, dan pengembangan oleh ' . config('app.name')))">
    <link rel="canonical" href="{{ url()->current() }}">
    
    <meta property="og:site_name" content="{{ config('app.name') }}">
    <meta property="og:title" content="@yield('title', config('app.name'))">
    <meta property="og:description" content="@yield('meta_description', config('app.meta_description', 'Solusi layanan digital, desain, dan pengembangan oleh ' . config('app.name')))">
    <meta property="og:type" content="@yield('meta_og_type', 'website')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ config('app.og_image') ? asset('storage/' . config('app.og_image')) : (config('app.logo') ? asset('storage/' . config('app.logo')) : asset('public_template/img/logo.png')) }}">
    
    <meta name="twitter:card" content="summary_large_image">
    @stack('meta')
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,500,600" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('public_template/css/linearicons.css') }}">
    <link rel="stylesheet" href="{{ asset('public_template/css/owl.carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('public_template/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public_template/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('public_template/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('public_template/css/main.css') }}">
    
    <!-- UI Consistency: container + spacing -->
    <style>
      :root{
        --section-py-sm: 3rem;
        --section-py-md: 4.5rem;
        --section-py-lg: 6rem;
      }
      /* Container width refinement on very large screens */
      @media (min-width: 1400px){
        .container{ max-width: 1200px; }
      }
      /* Unify vertical rhythm across sections */
      .section-gap,
      .section-full{ padding-top: var(--section-py-sm); padding-bottom: var(--section-py-sm); }
      @media (min-width: 768px){
        .section-gap, .section-full{ padding-top: var(--section-py-md); padding-bottom: var(--section-py-md); }
      }
      @media (min-width: 1200px){
        .section-gap, .section-full{ padding-top: var(--section-py-lg); padding-bottom: var(--section-py-lg); }
      }
      /* Section headers */
      .section-title, .product-area-title{ margin-bottom: 2rem; }
      .section-title p, .product-area-title p{ letter-spacing: .08em; font-weight: 600; opacity: .85; margin-bottom: .5rem; }
      .section-title h2, .product-area-title h2,
      .section-title .h1, .product-area-title .h1{ margin-bottom: 0; line-height: 1.2; }
      /* Grid item default gap to reduce repetitive mb-* in cols */
      .row > [class*='col-']{ margin-bottom: 1.5rem; }
      @media (min-width: 768px){ .row > [class*='col-']{ margin-bottom: 2rem; } }
      /* Button alignment */
      .primary-btn{ display: inline-flex; align-items: center; gap: .5rem; }
      /* Narrow section head helper (centered titles) */
      .product-area-title.text-center, .section-title.text-center{ max-width: 760px; margin-left: auto; margin-right: auto; }
      /* Footer spacing alignment */
      footer.section-full{ padding-top: var(--section-py-sm); padding-bottom: var(--section-py-sm); }
      @media (min-width: 768px){ footer.section-full{ padding-top: var(--section-py-md); padding-bottom: var(--section-py-md); } }
      @media (min-width: 1200px){ footer.section-full{ padding-top: var(--section-py-lg); padding-bottom: var(--section-py-lg); } }
      /* Utilities */
      .mt-section{ margin-top: var(--section-py-sm); }
      .mb-section{ margin-bottom: var(--section-py-sm); }
    </style>

    @stack('styles')
</head>
<body class="has-fixed-header">
    <div id="top"></div>

    @include('public.partials.header')

    <main>
        @yield('content')
    </main>

    @include('public.partials.footer')

    <script src="{{ asset('public_template/js/vendor/jquery-2.2.4.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="{{ asset('public_template/js/vendor/bootstrap.min.js') }}"></script>
    <script src="{{ asset('public_template/js/jquery.ajaxchimp.min.js') }}"></script>
    <script src="{{ asset('public_template/js/jquery.sticky.js') }}"></script>
    <script src="{{ asset('public_template/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('public_template/js/mixitup.min.js') }}"></script>
    <script src="{{ asset('public_template/js/main.js') }}"></script>
    @stack('scripts')
</body>
</html>