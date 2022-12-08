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
    <body class="antialiased bg-sy" style="background-image: url('/img/bgnew.jpeg');">
        <main style="font-size: 1.6rem !important;">
            <section id="content my-5">
                <div class="containter my-5">
                        <div class="d-flex justify-content-center">
                            <div id="timedate" class="display-sm-sched ">
                                <div id="time" class="d-flex justify-content-center" style="font-size:80px;">
                                </div>
                                <div class="d-flex justify-content-center" id="date" style="font-size:30px;" >
                                </div>
                            </div>                            
                        </div>
                    <div id="homeView">
                        <div class="d-flex justify-content-center">
                            <div>
                                <img class="card-img-top w-15 h-15" src="/img/logo-new.png" alt="Holy Cross Student" height="200px" width="200px">
                            </div>
                        </div>
                        
                        <div id="chooseFinderDiv" class="pt-5">
                            <div class="d-flex justify-content-center">
                                <h1>
                                    WELCOME TO HCC!
                                </h1>
                            </div>
                            <div class="d-flex justify-content-center">
                                <div class="w-75">
                                    <div class="row justify-content-md-center">
                                        {{-- I AM STUDENT --}}
                                        <div class="col col-lg-4 my-3" id="iAmStudentDiv">
                                            <div class="iam-border">
                                                <img class="card-img-top" src="/img/student.png"  alt="Card image cap">
                                                <div class="iam-px-50 mb-5">
                                                    <div class="text-center">
                                                        <h3 class="font-s-3rem">
                                                            I AM STUDENT
                                                        </h3>
                                                        <small>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- I AM TEACHER --}}
                                        <div class="col col-lg-4 my-3" id="iAmProfDiv">
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
                            </div>
                        </div>    
                    </div>


                   
                    <div class="d-none" id="findProfDiv">
                        <div class="d-flex justify-content-center mt-3">
                            <div class="text-center">
                                <img class="card-img-top w-50" src="/img/teacher.png"  alt="Card image cap">
                                <h3 class="font-s-3rem">
                                    I AM PROFESSOR
                                </h3>
                                <p id="syLabelShowProfessor" class="mb-0"></p>
                                <p id="syLabelShowProfessorSemester"></p>
                            </div>
                        </div>

                        <div class=" d-flex justify-content-center  mb-0">
                            <div class="d-flex justify-content-center flex-column">
                                <button class="button button5 mr-2" id="homeBtnSchedProf"><i class="fas fa-home ifont-s"></i></button>                             
                            </div>
                            <div class="wrapper">
                                <div class="searchBar">
                                    <input id="searchProfId" type="text" name="searchProfId" class="searchQueryInput text-center" placeholder="Your ID Number"/>
                                    <div>
                                        <button id="searchProfSubmit" type="submit" class="searchQuerySubmit"  name="searchProfSubmit">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                   
                                </div>
                            </div>
                            
                        </div>

                        <div class="mt-5 pt-5 d-none" id="profSchedTable">
                            <div class="d-flex justify-content-center mb-3 text-center d-none" id="professorNameDiv">
                                <h1>Hi <span id="professorName"></span>, here's your shedule for this week!</h1>
                            </div>
                            <div class="d-flex justify-content-center mb-5 mx-5">
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

                        <div class="mt-5 pt-5" id="profSchedTableFirst">
                            <div class="d-flex justify-content-center mb-5 mx-5">
                                <img class="card-img-top w-25 h-25" src="/img/logo-new.png" alt="Holy Cross Student" height="200px" width="200px">
                            </div>
                        </div>
                    </div>
                    
                    {{-- FIND STUDENT SCHED --}}
                    <div class="d-none" id="findStudentDiv">

                        <div class="d-flex justify-content-center mt-3">
                            <div class="text-center">
                                <img class="card-img-top w-50" src="/img/student.png"  alt="Card image cap">
                                <h3 class="font-s-3rem">
                                    I AM STUDENT
                                </h3>
                                <p id="syLabelShowStudent" class="mb-0"></p>
                                <p id="syLabelShowStudentSemester"></p>
                            </div>
                        </div>
                        <div class=" d-flex justify-content-center  mb-0">
                            <div class="d-flex justify-content-center flex-column">
                                <button class="button button5 mr-2" id="homeBtnSchedStudent"><i class="fas fa-home ifont-s"></i></button>                             
                            </div>
                            <div class="wrapper">
                                <div class="searchBar">
                                    <input id="searchStudentID" type="text" name="searchStudentID" class="searchQueryInput text-center" placeholder="Your Student ID Number"/>
                                    <div>
                                        <button id="searchStudentSubmit" type="submit" class="searchQuerySubmit" name="searchStudentSubmit">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                   
                                </div>
                            </div>
                        </div>
                        <div class=" d-flex justify-content-center  mb-0">
                            <p class="card-text mb-0"><strong><span id="syLabelShow"></span></strong></p>
                        </div>


                        <div class="mt-5 pt-5 d-none" id="studentSchedTable">
                            <div class="d-flex justify-content-center mb-3 text-center" id="studentNameDiv">
                                <h1>Hi <span id="studentName"></span>, here's your shedule for this week!</h1>
                            </div>
                            <div class="d-flex justify-content-center mb-5 division-mx">
                                <div class="tableFixHead w-75-screen">
                                    <table class="table">
                                        <thead>
                                          <tr>
                                            <th width="20%" scope="col" class="vertical-center uppercase th-color">Subject</th>
                                            <th width="10%" scope="col" class="vertical-center uppercase th-color">Section</th>
                                            <th width="10%" scope="col" class="vertical-center uppercase th-color">Days</th>
                                            <th width="18%"scope="col" class="vertical-center uppercase th-color">Time</th>
                                            <th width="15%" scope="col" class="vertical-center uppercase th-color">Professor</th>
                                            <th width="5%" scope="col" class="vertical-center uppercase th-color">Room</th>
                                          </tr>
                                        </thead>
                                        <tbody id="studentScheduleTable">
                                        </tbody>
                                    </table>
                                </div>
                                
                            </div>
                        </div>

                        <div class="mt-5 pt-5" id="studentSchedTableFirst">
                            <div class="d-flex justify-content-center mb-5 mx-5">
                                <img class="card-img-top w-25 h-25" src="/img/logo-new.png" alt="Holy Cross Student" height="200px" width="200px">
                            </div>
                        </div>
                    </div>
                                    
                </div>
            </section>
        </main>
    </body>

    <script>
        $(document).ready(function() {
            runClock();
            initFinder();
            checkSchedStudent();
            checkSchedProf();
            loadSchoolyearRecordActive();
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
