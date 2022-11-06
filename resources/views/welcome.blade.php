<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Holy Cross College</title>

        {{-- LINK NAV AND FOOTER --}}
        <link href="{{ asset('/css/landing.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('/css/footer.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('/css/search-schedule.css') }}" rel="stylesheet" type="text/css">
      

        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"/>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css"/>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>


    </head>
    <body class="antialiased">
        {{-- INCLUDE NAV --}}
        @include('layouts/nav')


        <main style="height: 100vh; font-size: 1.6rem !important;">
            <section id="content">
                <div class="bg-sy" style="background-image: url('/img/hcc-front.jpg');">
                    <div class="bg-opacity">
                        <div class="container" style="height: 100vh; background-color: rgb(223 222 222 / 70%);">
                            <div class="d-flex justify-content-start flex-column mt-5">
                                <form action="">
                                    <input type="search" required placeholder="Type your student ID Number">
                                    <i class="fa fa-search search-icon"></i>
                                    <a href="javascript:void(0)" id="clear-btn" class="clear-text">Clear</a>
                                </form>
                            </div>
                            
                               
                        </div>
                    </div>
                </div>
            </section>
        </main>

        {{-- INCLUDE FOOTER --}}
        @include('layouts/footer')
    </body>
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


                        
            const clearInput = () => {
            const input = document.getElementsByTagName("input")[0];
                input.value = "";
            }

            const clearBtn = document.getElementById("clear-btn");
            clearBtn.addEventListener("click", clearInput);


        });
     </script>
</html>
