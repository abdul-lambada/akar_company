<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="{{ asset('public_template/img/fav.png') }}">
    <title>@yield('title', config('app.name'))</title>

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,500,600" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('public_template/css/linearicons.css') }}">
    <link rel="stylesheet" href="{{ asset('public_template/css/owl.carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('public_template/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public_template/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('public_template/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('public_template/css/main.css') }}">
    @stack('styles')
</head>
<body>
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