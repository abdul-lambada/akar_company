<!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center">
  <div class="d-flex align-items-center justify-content-between">
    <a href="{{ url('/') }}" class="logo d-flex align-items-center">
      @php($appLogo = config('app.logo'))
      @if(!empty($appLogo))
        <img src="{{ asset('storage/'.$appLogo) }}" alt="Logo">
      @else
        <img src="{{ asset('NiceAdmin/assets/img/logo.png') }}" alt="Logo">
      @endif
      <span class="d-none d-lg-block">{{ config('app.name', 'AKAR Company') }}</span>
    </a>
    <i class="bi bi-list toggle-sidebar-btn"></i>
  </div>
  <div class="search-bar">
    <form class="search-form d-flex align-items-center" method="GET" action="#">
      <input type="text" name="query" placeholder="Search" title="Enter search keyword">
      <button type="submit" title="Search"><i class="bi bi-search"></i></button>
    </form>
  </div>
  <nav class="header-nav ms-auto">
    <ul class="d-flex align-items-center">
      <li class="nav-item d-block d-lg-none">
        <a class="nav-link nav-icon search-bar-toggle" href="#">
          <i class="bi bi-search"></i>
        </a>
      </li>
      <li class="nav-item dropdown pe-3">
        <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
          <img src="{{ auth()->check() && auth()->user()->avatar ? asset('storage/'.auth()->user()->avatar) : asset('NiceAdmin/assets/img/profile-img.jpg') }}" alt="Profile" class="rounded-circle">
          <span class="d-none d-md-block dropdown-toggle ps-2">{{ auth()->check() ? (auth()->user()->full_name ?? auth()->user()->username ?? 'User') : 'Guest' }}</span>
        </a>
        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
          <li class="dropdown-header">
            <h6>{{ auth()->check() ? (auth()->user()->full_name ?? auth()->user()->username ?? 'User') : 'Guest' }}</h6>
            <span>{{ auth()->check() ? (auth()->user()->role ?? 'User') : 'Unauthenticated' }}</span>
          </li>
          <li><hr class="dropdown-divider"></li>
          <li>
            <a class="dropdown-item d-flex align-items-center" href="{{ route('profile.index') }}">
              <i class="bi bi-person"></i>
              <span>My Profile</span>
            </a>
          </li>
          <li><hr class="dropdown-divider"></li>
          <li>
            <a class="dropdown-item d-flex align-items-center" href="{{ route('settings.index') }}">
              <i class="bi bi-gear"></i>
              <span>Settings</span>
            </a>
          </li>
          <li><hr class="dropdown-divider"></li>
          @auth
          <li>
            <form method="POST" action="{{ route('logout') }}" class="w-100 d-flex align-items-center px-3 py-2">
              @csrf
              <button type="submit" class="dropdown-item d-flex align-items-center p-0 border-0 bg-transparent w-100">
                <i class="bi bi-box-arrow-right me-2"></i>
                <span>Sign Out</span>
              </button>
            </form>
          </li>
          @else
          <li>
            <a class="dropdown-item d-flex align-items-center" href="{{ route('login') }}">
              <i class="bi bi-box-arrow-in-right"></i>
              <span>Sign In</span>
            </a>
          </li>
          @endauth
        </ul>
      </li>
    </ul>
  </nav>
</header>
<!-- End Header -->