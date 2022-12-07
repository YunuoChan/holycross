<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
    
        <title>ADMIN | Holy Cross College</title>
        @vite(['resources/sass/app.scss', 'resources/js/app.js'])   
        <link href="{{ asset('/css/dashboard.css') }}" rel="stylesheet" type="text/css">
        <!-- Bootstrap CSS CDN -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
        <link href="{{ asset('/plugin/jquery-toast/jquery.toast.min.css') }}" rel="stylesheet" type="text/css">
        {{-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script> --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
        <script src="/js/dashboard.js" type="text/javascript"></script>
        <script src="/plugin/jquery-toast/jquery.toast.min.js" type="text/javascript"></script>
        <script src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" type="text/javascript"></script>
        <script src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" type="text/javascript"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" type="text/javascript"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.2/bootbox.min.js" type="text/javascript"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    
        
        <!-- Scripts -->
       
        @yield('head')

    </head>
    <body>
        <main style="height: 100vh;">
            <section class="p-0" id="content">
                <div class="wrapper">
                    <!-- Sidebar  -->
                    <nav id="sidebar">
                        <div class="sidebar-header">
                            {{--
                            
                            <small id="activeSYSidebarIndicator">Active</small> --}}
                            <a type="button" href="{{ route('landing-welcome') }}" class="white-color" title="Holy Cross College">
                            <div class="d-flex">
                                <div class="mr-2">
                                    <img src="/img/logo.jpg"  style="width: 100px; height: 100px" class="rounded-circle"/>
                                </div>
                                <div class="d-flex justify-content-center flex-column">
                                    <h4>Holy Cross College</h4>
                                </div>
                            </div>
                            </a>
                            
                        </div>
            
                        <ul class="list-unstyled components">
                            <h4 class="px-4 my-4">RECORD</h4>
                            <li id="li-dashboard" name="dashboard-menu" class="active">
                                <a href="{{ route('home') }}"  onclick="selectDashboardMenu('dashboard');">Dashboard</a>
                            </li>
                            <li id="li-course" name="dashboard-menu">
                                <a href="{{ route('manage.course') }}" onclick="selectDashboardMenu('course');">Course</a>
                            </li>
                            <li id="li-professor" name="dashboard-menu">
                                <a href="{{ route('professor') }}"  onclick="selectDashboardMenu('professor');">Professor</a>
                                {{-- <a onclick="openDropdown('professor')" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Professor</a>
                                <ul class="collapse list-unstyled ml-3" id="professorSubmenu">
                                    <li id="li-professor-list-submenu">
                                        <a href="{{ route('professor') }}" onclick="selectDashboardMenu('professor', 'professor-list');" class="white-color">Professor List</a>
                                    </li>
                                    <li id="li-professor-subject-submenu">
                                        <a href="{{ route('professor.subject') }}" onclick="selectDashboardMenu('professor', 'professor-subject');" class="white-color">Assign Subject</a>
                                    </li>

                                </ul> --}}
                            </li>
                        </ul>

                        <ul class="list-unstyled components">
                            <h4 class="px-4 my-4">SCHOOL YEAR</h4>
                            <li id="li-section" name="dashboard-menu">
                                <a href="{{ route('section') }}" onclick="selectDashboardMenu('section', 'section-list');">Section</a>
                            </li>
                            <li id="li-subject" name="dashboard-menu">
                                <a href="{{ route('subject') }}" onclick="selectDashboardMenu('subject');">Subject</a>
                            </li>
                            <li  id="li-student" name="dashboard-menu">
                                <a href="{{ route('student') }}" onclick="selectDashboardMenu('student');" >Student</a>
                            </li>
                            
                            <li id="li-generate-schedule" name="dashboard-menu">
                                <a href="{{ route('generate.schedule') }}" onclick="selectDashboardMenu('generate-schedule');" >Generate Schedule</a>
                            </li>
                            <li id="li-professor-subject" name="dashboard-menu">
                                <a href="{{ route('professor.subject') }}" onclick="selectDashboardMenu('professor-subject');">Professor Subject</a>
                            </li>
                        </ul>

                        <ul class="list-unstyled components">
                            <h4 class="px-4 my-4">MAINTENANCE</h4>
                            <li  id="li-schoolyear" name="dashboard-menu">
                                <a href="{{ route('schoolyear') }}" onclick="selectDashboardMenu('schoolyear');" >Manage School Year</a>
                            </li>
                            <li  id="li-accounts" name="dashboard-menu">
                                <a href="{{ route('accounts') }}" onclick="selectDashboardMenu('accounts');">Admin Accounts</a>
                            </li>
                            
                        </ul>
                    </nav>
            
                    <!-- Page Content  -->
                    <div id="content">
                        <nav class="navbar navbar-expand-lg navbar-light bg-light">
                            <div class="container-fluid">
            
                                <div class="d-flex w-100">
                                    <div class="d-flex justify-content-center flex-column">
                                        <div class="d-flex">
                                            <div class="mr-2">
                                                <button type="button" id="sidebarCollapse" class="btn btn-info" title="Hide Sidebar">
                                                    <i class="fas fa-align-left"></i>
                                                </button>
                                                <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                                    <i class="fas fa-align-justify"></i>
                                                </button>
                                            </div>
        
                                            <div class="mr-2">
                                                <a type="button" href="{{ route('landing-welcome') }}" class="btn btn-info" title="Homepage">
                                                    <i class="fas fa-home"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="mx-2 pl-3 b-left-gray d-flex justify-content-center flex-column w-50">
                                        <div>
                                            {{-- <h3>Currently updating <b><span id="selectedSY"></span></b> S.Y.</h3>  --}}
                                            <small for="selectSYDashborad">Selected Schoolyear</small>  
                                            <h4 id="selectSYDashboradSidebar" class="mb-0"></h4>
                                            <a id="swictSchoolyearCallModal" class="hover-a"><small>Switch Schoolyear</small> </a>
                                            {{-- <select class="form-control w-50" id="selectSYDashborad"></select>--}}
                                        </div>
                                    </div>

                                </div>
                                
                                
            
                                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                    <ul class="nav navbar-nav ml-auto">
                                        @guest
                                            @if (Route::has('login'))
                                                <li class="nav-item">
                                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                                </li>
                                            @endif
                                        @else
                                            <li class="nav-item dropdown">
                                                <a id="navbarDropdown" class="nav-link dropdown-toggle" style="text-transform:uppercase;" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                                    {{ Auth::user()->name }}<img src="/img/img_avatar.png" alt="{{ Auth::user()->name }}" style="margin-left: 10px; vertical-align: middle; width: 50px; height: 50px; border-radius: 50%" class="avatar">  
                                                </a>
                        
                                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                                        onclick="event.preventDefault();
                                                                    document.getElementById('logout-form').submit();">
                                                        {{ __('Logout') }}
                                                    </a>
                        
                                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                        @csrf
                                                    </form>
                                                </div>
                                            </li>
                                        @endguest   
                                    </ul>
                                </div>
                            </div>
                        </nav>
            
                        @yield('content')
                    </div>
                </div>
            </section>
        </main>

        {{-- INCLUDE FOOTER --}}
    </body>
    @include('components.modal')

    @yield('page-script')
    <script type="text/javascript">
        $('#sidebarCollapse').on('click', function () {
            $('#sidebar').toggleClass('active');
        });

        // initOnchange();
        // loadSchoolyearRecordActive();
        loadSchoolyearRecordToEdit();

        // MODAL SWITCH CALL BTN INIT   
        initOncallModalSwitch();


        if (localStorage.getItem('current_page') == '') {
            selectDashboardMenu('dashboard')
        } else {
            if (localStorage.getItem('submenu') == null || localStorage.getItem('submenu') == 'null') {
                selectDashboardMenu(localStorage.getItem('current_page'))
            } else {
                selectDashboardMenu(localStorage.getItem('current_page'), localStorage.getItem('submenu'))
            }
        }


     </script>
</html>
