<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Holy Cross College') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="{{ asset('/css/custom.css') }}" rel="stylesheet"  type="text/css">
    <link href="{{ asset('/css/font-awesome.min.css') }}" rel="stylesheet"  type="text/css">
    <link href="{{ asset('/css/schoolyear.css') }}" rel="stylesheet" type="text/css">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.7.0/css/all.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">


    <link href="{{ asset('/plugin/jquery-toast/jquery.toast.min.css') }}" rel="stylesheet" type="text/css">


   {{-- LINK NAV AND FOOTER --}}
   <link href="{{ asset('/css/landing.css') }}" rel="stylesheet" type="text/css">
   <link href="{{ asset('/css/footer.css') }}" rel="stylesheet" type="text/css">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @yield('head')
</head>
<body>
    <div id="app">
        {{-- INCLUDE NAV --}}
        @include('layouts/nav')
        <main style="height: 100vh; font-size: 1.6rem !important;">
            @yield('content')
        </main>
        @include('layouts/footer')
    </div>
</body>
@include('components.modal')
@yield('page-script')

<script src="/plugin/jquery-toast/jquery.toast.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.2/bootbox.min.js"></script>
<script src="/js/global.js"></script>
<script>
        jQuery(function($) {
            $(window).on('scroll', function() {
                if ($(this).scrollTop() >= 200) {
                    $('.navbar').addClass('fixed-top');
                } else if ($(this).scrollTop() == 0) {
                    $('.navbar').removeClass('fixed-top');
                }
            });
            
            function adjustNav() {
                var winWidth = $(window).width(),
                    dropdown = $('.dropdown'),
                    dropdownMenu = $('.dropdown-menu');
                
                if (winWidth >= 768) {
                    dropdown.on('mouseenter', function() {
                        $(this).addClass('show')
                            .children(dropdownMenu).addClass('show');
                    });
                    
                    dropdown.on('mouseleave', function() {
                        $(this).removeClass('show')
                            .children(dropdownMenu).removeClass('show');
                    });
                } else {
                    dropdown.off('mouseenter mouseleave');
                }
            }
            
            $(window).on('resize', adjustNav);
            
            adjustNav();
        });
     </script>
</html>
