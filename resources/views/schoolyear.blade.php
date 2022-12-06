<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        
        <title>Holy Cross College</title>
        <link href="{{ asset('/css/dashboard.css') }}" rel="stylesheet" type="text/css">
         <link href="{{ asset('/css/schoolyear.css') }}" rel="stylesheet" type="text/css">
         <link href="{{ asset('/css/search-schedule.css') }}" rel="stylesheet" type="text/css">
        <!-- Bootstrap CSS CDN -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
        <link href="{{ asset('/plugin/jquery-toast/jquery.toast.min.css') }}" rel="stylesheet" type="text/css">
        {{-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script> --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
        <script src="/js/dashboard.js" type="text/javascript"></script>
        <script src="/js/global.js" type="text/javascript"></script>
        <script src="/plugin/jquery-toast/jquery.toast.min.js" type="text/javascript"></script>
        <script src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" type="text/javascript"></script>
        <script src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" type="text/javascript"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" type="text/javascript"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.2/bootbox.min.js" type="text/javascript"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    
        {{-- LINK NAV AND FOOTER --}}
        {{-- <link href="{{ asset('/css/landing.css') }}" rel="stylesheet" type="text/css"> --}}
        <link href="{{ asset('/css/footer.css') }}" rel="stylesheet" type="text/css">

        <!-- Scripts -->
        @vite(['resources/sass/app.scss', 'resources/js/app.js'])
        @yield('head')

    </head>
    <body class="antialiased">
        @include('layouts/nav')

        <main style="height: 100vh;">
            <section class="p-0" id="content">
                @yield('content')
            </section>
        </main>
        @include('layouts/footer')

        {{-- INCLUDE FOOTER --}}
    </body>
    @include('components.modal')

    @yield('page-script')
    <script type="text/javascript">
        $(document).ready(function() {

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


        })

     </script>
</html>
