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
        <link href="{{ asset('/plugin/jquery-toast/jquery.toast.min.css') }}" rel="stylesheet" type="text/css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>

        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"/>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css"/>
        <script src="/js/welcome.js"></script>
        <script src="/plugin/jquery-toast/jquery.toast.min.js" type="text/javascript"></script>
        
        @vite(['resources/sass/app.scss', 'resources/js/app.js'])

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
                                <form>
                                    <input type="search" id="studentIdNo" required placeholder="Type your student ID Number">
                                    <a onclick="checkSched();"><i class="fa fa-search search-icon"></i></a>
                                </form>
                            </div>


                            <div>
                                <div class="d-flex justify-content-center mb-3">
                                    <h1>Shedule Viewer</h1>
                                </div>
                                <div class="d-flex justify-content-center mb-5 mx-5">
                                    <div class="mr-3 w-25">
                                        <div class="card">
                                            <div class="d-flex justify-content-center my-5">
                                                <img class="card-img-top w-50" src="/img/logo.jpg" alt="Holy Cross Student" height="auto">
                                            </div>
                                            <div class="card-body py-0 px-4 pb-5">
                                                <p class="card-title font-35-rem mb-0"><strong><span id="studentName">John Doe</span></strong></p>
                                                <p class="card-text mb-0"><strong><span id="schoolYear">S.Y. 2022 - 2023</span></strong></p>
                                                <p class="card-text mb-0">Student No: <strong><span id="studentNo">John Doe</span></strong></p>
                                                <p class="card-text mb-0"><strong><span id="studentCourse">BCSS</span></strong></p>
                                            </div>
                                        </div>
                                    </div>
                                    <table class="table w-75">
                                        <thead class="sched-head">
                                          <tr>
                                            <th width="13%" scope="col" class="vertical-center uppercase">Subject Code</th>
                                            <th width="15%" scope="col" class="vertical-center uppercase">Section</th>
                                            <th width="10%" scope="col" class="vertical-center uppercase">Days</th>
                                            <th width="18%"scope="col" class="vertical-center uppercase">Time</th>
                                            <th width="15%" scope="col" class="vertical-center uppercase">Professor</th>
                                            <th width="10%" scope="col" class="vertical-center uppercase">Room</th>
                                          </tr>
                                        </thead>
                                        <tbody id="studentScheduleTable">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div>
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


                        
            const clearInput = () => {
            const input = document.getElementsByTagName("input")[0];
                input.value = "";
            }
        })
    </script>
    <script>
        jQuery(function($) {
           

            // const clearBtn = document.getElementById("clear-btn");
            // clearBtn.addEventListener("click", clearInput);


        });
     </script>
</html>
