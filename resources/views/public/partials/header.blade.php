<!-- ======= Public Site Header ======= -->
<header class="default-header">
  <div class="sticky-header">
    <div class="container">
      <div class="header-content d-flex justify-content-between align-items-center">
        <!-- Site Logo -->
        <div class="logo">
          @php($appLogo = config('app.logo'))
          @php($hasLogo = !empty($appLogo) && \Illuminate\Support\Facades\Storage::disk('public')->exists($appLogo))
          <a href="{{ url('/') }}#top" class="smooth d-inline-flex align-items-center">
            @if($hasLogo)
              <img src="{{ asset('storage/'.$appLogo) }}" alt="{{ config('app.name') }} Logo" class="logo-img">
            @else
              <img src="{{ asset('public_template/img/logo.png') }}" alt="{{ config('app.name') }} Logo" class="logo-img">
            @endif
            <span class="logo-text text-uppercase fw-bold d-none d-md-inline text-white">{{ config('app.name') }}</span>
          </a>
        </div>
        <!-- /Site Logo -->
        <div class="right-bar d-flex align-items-center">
          <!-- Navigation -->
          <nav class="d-flex align-items-center">
            <ul class="main-menu">
              <li><a href="{{ url('/') }}#top">Home</a></li>
              <li><a href="{{ url('/') }}#services">Services</a></li>
              <li><a href="{{ url('/') }}#portfolio">Portfolio</a></li>
              <li><a href="{{ url('/') }}#team">Team</a></li>
              <li><a href="{{ url('/') }}#blog">Blog</a></li>
              <li><a href="{{ url('/') }}#contact">Contact</a></li>
            </ul>
            <!-- Mobile Trigger -->
            <a href="#" class="mobile-btn"><span class="lnr lnr-menu"></span></a>
          </nav>
          <!-- /Navigation -->

          <!-- Search -->
          <div class="search relative">
            <span class="lnr lnr-magnifier"></span>
            <form action="{{ route('public.search') }}" class="search-field" method="GET">
              <input type="text" name="q" placeholder="Search here" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Search here'">
              <button class="search-submit" aria-label="Search"><span class="lnr lnr-magnifier"></span></button>
            </form>
          </div>
          <!-- /Search -->

          <!-- Social Icons -->
          <div class="header-social d-flex align-items-center">
            <a href="#" aria-label="Facebook"><i class="fa fa-facebook"></i></a>
            <a href="#" aria-label="Twitter"><i class="fa fa-twitter"></i></a>
            <a href="#" aria-label="LinkedIn"><i class="fa fa-linkedin"></i></a>
          </div>
          <!-- /Social Icons -->
        </div>
      </div>
    </div>
  </div>
</header>
<!-- ======= End Public Site Header ======= -->