<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name'))</title>

    {{--  Stylesheets from template_fe  --}}
    <link rel="icon" type="image/ico" href="{{ asset('template_fe/assets/images/logo/favicon.ico') }}"/>
    <link rel="stylesheet" href="{{ asset('template_fe/assets/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('template_fe/assets/css/font-awesome.css') }}">
    <link rel="stylesheet" href="{{ asset('template_fe/assets/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template_fe/assets/css/revolution-slider.css') }}">
    <link rel="stylesheet" href="{{ asset('template_fe/assets/css/owl.carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('template_fe/assets/css/owl.transitions.css') }}">
    <link rel="stylesheet" href="{{ asset('template_fe/assets/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('template_fe/assets/css/main-responsive.css') }}">

    @stack('styles')
</head>
<body>
<div class="apecsaos-wrapper">
    {{-- Navbar --}}
    @include('public.partials.navbar')

    {{-- Main content --}}
    @yield('content')

    {{-- Footer --}}
    @include('public.partials.footer')
</div>

{{-- Scripts --}}
<script src="{{ asset('template_fe/assets/js/jquery-3.1.0.min.js') }}"></script>
<script src="{{ asset('template_fe/assets/js/bootstrap.js') }}"></script>
<script src="{{ asset('template_fe/assets/js/owl.carousel.js') }}"></script>
<script src="{{ asset('template_fe/assets/js/revolution.min.js') }}"></script>
<script src="{{ asset('template_fe/assets/js/main.js') }}"></script>

@stack('scripts')
</body>
</html>