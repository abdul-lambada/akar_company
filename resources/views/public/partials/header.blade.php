<!-- Start Header Area -->
<header class="default-header">
    <div class="sticky-header">
        <div class="container">
            <div class="header-content d-flex justify-content-between align-items-center">
                <div class="logo">
                    <a href="{{ route('home') }}">
                        @if(config('app.logo'))
                            <img class="site-logo" src="{{ asset('storage/'.config('app.logo')) }}" alt="{{ config('app.name') }}">
                        @else
                            <img class="site-logo" src="{{ asset('public_template/img/logo.png') }}" alt="{{ config('app.name') }}">
                        @endif
                    </a>
                </div>
                <div class="right-bar d-flex align-items-center">
                    <nav class="d-flex align-items-center">
                        <ul class="main-menu">
                            <li class="{{ request()->routeIs('home') ? 'active' : '' }}"><a href="{{ route('home') }}">Home</a></li>
                            <li class="{{ request()->routeIs('public.services') ? 'active' : '' }}"><a href="{{ route('public.services') }}">Services</a></li>
                            <li class="{{ request()->routeIs('public.portfolio') ? 'active' : '' }}"><a href="{{ route('public.portfolio') }}">Portfolio</a></li>
                            <li class="{{ request()->routeIs('public.blog') ? 'active' : '' }}"><a href="{{ route('public.blog') }}">Blog</a></li>
                            <li class="{{ request()->routeIs('public.team') ? 'active' : '' }}"><a href="{{ route('public.team') }}">Team</a></li>
                            <li class="{{ request()->routeIs('public.about') ? 'active' : '' }}"><a href="{{ route('public.about') }}">About</a></li>
                            <li class="{{ request()->routeIs('public.contact') ? 'active' : '' }}"><a href="{{ route('public.contact') }}">Contact</a></li>
                        </ul>
                        <a href="#" class="mobile-btn"><span class="lnr lnr-menu"></span></a>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- End Header Area -->