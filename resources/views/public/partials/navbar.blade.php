@php
    // Determine active link helper
    function active_class($route) {
        return request()->routeIs($route) ? 'active' : '';
    }
@endphp
<div id="navbar-fixed-apecsaos">
    <nav class="navbar navbar-default">
        <div class="container">
            <div class="col-md-12">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-apecsaos" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="{{ route('public.index') }}">
                        <img src="{{ asset('template_fe/assets/images/logo/logo.png') }}" alt="ApecsaOS">
                    </a>
                </div>
                <div class="collapse navbar-collapse" id="navbar-apecsaos">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="{{ active_class('public.index') }}"><a href="{{ route('public.index') }}">Home</a></li>
                        <li class="{{ active_class('public.about') }}"><a href="{{ route('public.about') }}">About Us</a></li>
                        <li class="{{ active_class('public.services') }}"><a href="{{ route('public.services') }}">Services</a></li>
                        <li class="{{ active_class('public.portfolio') }}"><a href="{{ route('public.portfolio') }}">Portfolio</a></li>
                        <li class="{{ active_class('public.career') }}"><a href="{{ route('public.career') }}">Careers</a></li>
                        <li class="{{ active_class('public.contact') }}"><a href="{{ route('public.contact') }}">Contact Us</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</div>