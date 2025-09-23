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
                            <li><a href="{{ route('home') }}">Home</a></li>
                            <li><a href="{{ route('public.services') }}">Services</a></li>
                            <li><a href="{{ route('public.portfolio') }}">Portfolio</a></li>
                            <li><a href="{{ route('public.blog') }}">Blog</a></li>
                            <li><a href="{{ route('public.team') }}">Team</a></li>
                            <li><a href="{{ route('public.about') }}">About</a></li>
                            <li><a href="{{ route('public.contact') }}">Contact</a></li>
                        </ul>
                        <a href="#" class="mobile-btn"><span class="lnr lnr-menu"></span></a>
                    </nav>
                    <div class="search relative">
                        <span class="lnr lnr-magnifier"></span>
                        <form action="{{ route('public.search') }}" method="get" class="search-field">
                            <input type="text" name="q" value="{{ request('q') }}" placeholder="Search here" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Search here'">
                            <button class="search-submit" type="submit"><span class="lnr lnr-magnifier"></span></button>
                        </form>
                    </div>
                    <div class="header-social d-flex align-items-center">
                        @if(config('app.company_whatsapp'))
                            <a href="https://wa.me/{{ preg_replace('/\D/', '', config('app.company_whatsapp')) }}" target="_blank" rel="noopener"><i class="fa fa-whatsapp"></i></a>
                        @endif
                        <a href="#"><i class="fa fa-facebook"></i></a>
                        <a href="#"><i class="fa fa-twitter"></i></a>
                        <a href="#"><i class="fa fa-linkedin"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- End Header Area -->