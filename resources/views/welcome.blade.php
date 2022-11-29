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
        <script src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" type="text/javascript"></script>
        <script src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" type="text/javascript"></script>
        {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css"/> --}}
        <script src="/js/welcome.js"></script>
        <script src="/plugin/jquery-toast/jquery.toast.min.js" type="text/javascript"></script>
        
        @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    </head>
    <body class="antialiased">
        {{-- INCLUDE NAV --}}
        @include('layouts/nav')


        <main style="font-size: 1.6rem !important;">
            <section id="content">
                <div class="bg-sy" style="background-image: url('/img/hcc-front.jpg');">
                    <div class="bg-opacity">
                        <div class="container" style="height: 200vh; background-color: rgb(223 222 222 / 70%);">
                            <div class="mt-5" id="chooseFinderDiv">
                                <div class="d-flex justify-content-center mt-5">
                                    <h1>
                                        WELCOME TO HCC!
                                    </h1>
                                </div>
                                <div class="d-flex justify-content-center mt-5">
                                    <div class="d-flex justify-content-center w-30 mx-3" id="iAmStudentDiv">
                                        <div class="iam-border">
                                            <img class="card-img-top" src="/img/student.png"  alt="Card image cap">
                                            <div class="iam-px-50  mb-5">
                                                <div class="text-center">
                                                    <h3 class="font-s-3rem">
                                                        I AM STUDENT
                                                    </h3>
                                                    <small>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="d-flex justify-content-center w-30 mx-3" id="iAmProfDiv">
                                        <div class="iam-border">
                                            <img class="card-img-top" src="/img/teacher.png"  alt="Card image cap">
                                            <div class="iam-px-50  mb-5">
                                                <div class="text-center">
                                                    <h3 class="font-s-3rem">
                                                        I AM TEACHER
                                                    </h3>
                                                    <small>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                            </div>
                            

                            {{-- FIND PROFESSOR SCHED --}}
                            <div class="d-none" id="findProfDiv">
                                <div class="d-flex justify-content-center mt-5">
                                    <div class="text-center">
                                        <img class="card-img-top w-50" src="/img/teacher.png"  alt="Card image cap">
                                        <h3 class="font-s-3rem">
                                            I AM PROFESSOR
                                        </h3>
                                        <p id="syLabelShowProfessor" class="mb-0"></p>
                                        <p id="syLabelShowProfessorSemester"></p>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-start flex-column mt-5">
                                    <div class="w-50 inputIDFrom">
                                        <div class="mb-4">
                                            <input type="text" id="profIdNo" class="text-center" required placeholder="Input your ID Number">
                                        </div>
                                        <div class="d-flex justify-content-center">
                                            <button type="button" class="btn btn-outline-primary btn-lg mr-3" id="searchSchedprof"><i class="fa fa-search"></i>Find My Schedule</button>  
                                        </div>
                                    </div>
                                </div>
    
    
                                <div class="mt-5 pt-5">
                                    <div class="d-flex justify-content-center mb-3">
                                        <h1>View Your Schedule</h1>
                                    </div>
                                    <div class="d-flex justify-content-center mb-5 mx-5">
                                        <div class="mr-3 w-25">
                                            <div class="card">
                                                <div class="d-flex justify-content-center my-5">
                                                    <img class="card-img-top w-50" src="/img/logo.jpg" alt="Holy Cross Student" height="auto">
                                                </div>
                                                <div class="card-body py-0 px-4 pb-5 d-none" id="profInfo">
                                                    <p class="card-title font-35-rem mb-0"><strong><span id="professorName">John Doe</span></strong></p>
                                                    <p class="card-text mb-0"><strong><span id="syLabelShowProfessor">S.Y. 2022 - 2023</span></strong></p>
                                                    <p class="card-text mb-0">Professor No: <strong><span id="professorNo">John Doe</span></strong></p>
                                                    <p class="card-text mb-0"><strong><span id="professorCourse">BCSS</span></strong></p>
                                                </div>
                                            </div>
                                        </div>
                                        <table class="table w-75">
                                            <thead class="sched-head">
                                              <tr>
                                                <th width="13%" scope="col" class="vertical-center uppercase">Subject</th>
                                                <th width="15%" scope="col" class="vertical-center uppercase">Section</th>
                                                <th width="10%" scope="col" class="vertical-center uppercase">Days</th>
                                                <th width="18%"scope="col" class="vertical-center uppercase">Time</th>
                                                <th width="10%" scope="col" class="vertical-center uppercase">Room</th>
                                              </tr>
                                            </thead>
                                            <tbody id="profScheduleTable">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            
                            {{-- FIND STUDENT SCHED --}}
                            <div class="d-none" id="findStudentDiv">

                                <div class="d-flex justify-content-center mt-5">
                                    <div class="text-center">
                                        <img class="card-img-top w-50" src="/img/student.png"  alt="Card image cap">
                                        <h3 class="font-s-3rem">
                                            I AM STUDENT
                                        </h3>
                                        <p id="syLabelShowStudent" class="mb-0"></p>
                                        <p id="syLabelShowStudentSemester"></p>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-center flex-column">
                                    <div class="w-50 inputIDFrom">
                                        <div class="mb-4">
                                            <input type="text" id="studentIdNo" class="text-center" required placeholder="Type your student ID Number">
                                        </div>
                                        <div class="d-flex justify-content-center">
                                            <button type="button" class="btn btn-outline-primary btn-lg mr-3" id="searchSchedStudent"><i class="fa fa-search"></i>Find My Schedule</button>  
                                        </div>
                                    </div>
                                </div>
    
    
                                <div class="mt-5 pt-5">
                                    <div class="d-flex justify-content-center mb-3">
                                        <h1>View Your Shedule</h1>
                                    </div>
                                    <div class="d-flex justify-content-center mb-5 mx-5">
                                        <div class="mr-3 w-25">
                                            <div class="card">
                                                <div class="d-flex justify-content-center my-5">
                                                    <img class="card-img-top w-50" src="/img/logo.jpg" alt="Holy Cross Student" height="auto">
                                                </div>
                                                <div class="card-body py-0 px-4 pb-5 d-none" id="studentInfo">
                                                    <p class="card-title font-35-rem mb-0"><strong><span id="studentName">John Doe</span></strong></p>
                                                    <p class="card-text mb-0"><strong><span id="syLabelShow">S.Y. 2022 - 2023</span></strong></p>
                                                    <p class="card-text mb-0">Student No: <strong><span id="studentNo">John Doe</span></strong></p>
                                                    <p class="card-text mb-0"><strong><span id="studentCourse">BCSS</span></strong></p>
                                                </div>
                                            </div>
                                        </div>
                                        <table class="table w-75">
                                            <thead class="sched-head">
                                              <tr>
                                                <th width="13%" scope="col" class="vertical-center uppercase">Subject</th>
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
            initFinder();
            checkSchedStudent();
            checkSchedProf();
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
