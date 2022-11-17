<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
    
        <title>ADMIN | Holy Cross College</title>
        <link href="{{ asset('/css/dashboard.css') }}" rel="stylesheet" type="text/css">
        <!-- Bootstrap CSS CDN -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
        <link href="{{ asset('/plugin/jquery-toast/jquery.toast.min.css') }}" rel="stylesheet" type="text/css">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
        <script src="/js/dashboard.js" type="text/javascript"></script>
        <script src="/plugin/jquery-toast/jquery.toast.min.js" type="text/javascript"></script>
        <script src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" type="text/javascript"></script>
        <script src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" type="text/javascript"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" type="text/javascript"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.2/bootbox.min.js" type="text/javascript"></script>
    
        
        <!-- Scripts -->
        @vite(['resources/sass/app.scss', 'resources/js/app.js'])
        @yield('head')

    
    </head>
    <body>
        <main style="height: 100vh;">
            <section class="p-0" id="content">
                <div class="wrapper">
                    <!-- Sidebar  -->
                    <nav id="sidebar">
                        <div class="sidebar-header">
                            <h2>Holy Cross College</h2>
                            <h4>S.Y. 2022 - 2023 </h4>
                        </div>
            
                        <ul class="list-unstyled components">
                            <h4 class="px-4 my-4">RECORD</h4>
                            {{-- <li class="active">
                                <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Home</a>
                                <ul class="collapse list-unstyled" id="homeSubmenu">
                                    <li>
                                        <a href="#">Home 1</a>
                                    </li>
                                    <li>
                                        <a href="#">Home 2</a>
                                    </li>
                                    <li>
                                        <a href="#">Home 3</a>
                                    </li>
                                </ul>
                            </li> --}}
                            <li id="li-dashboard" name="dashboard-menu" class="active">
                                <a href="{{ route('home') }}"  onclick="selectDashboardMenu('dashboard');">Dashboard</a>
                            </li>
                            <li id="li-professor" name="dashboard-menu">
                                <a href="#" onclick="selectDashboardMenu('professor');">Professor</a>
                            </li>
                            {{-- <li>
                                <a href="#Submenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle" onclick="openDropdown('prof')">Prof</a>
                                <ul class="list-unstyled collapse" id="profSubmenu" style="">
                                    <li>
                                        <a href="#">Page 1</a>
                                    </li>
                                    <li>
                                        <a href="#">Page 2</a>
                                    </li>
                                    <li>
                                        <a href="#">Page 3</a>
                                    </li>
                                </ul>
                            </li> --}}
                            <li id="li-subject" name="dashboard-menu">
                                <a href="{{ route('subject') }}" onclick="selectDashboardMenu('subject');">Subject</a>
                            </li>
                            <li id="li-section" name="dashboard-menu">
                                <a href="{{ route('section') }}" onclick="selectDashboardMenu('section', 'section-list');">Section</a>
                                {{-- <a onclick="openDropdown('section')" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Section</a>
                                <ul class="collapse list-unstyled ml-3" id="sectionSubmenu">
                                    <li id="li-section-list-submenu">
                                        <a href="{{ route('section') }}" onclick="selectDashboardMenu('section', 'section-list');" class="white-color">Section List</a>
                                    </li>
                                    <li id="li-section-subject-submenu">
                                        <a href="{{ route('section.subject') }}" onclick="selectDashboardMenu('section', 'section-subject');" class="white-color">Section Subject</a>
                                    </li>
                                    <li id="li-section-schedule-submenu">
                                        <a href="#" onclick="selectDashboardMenu('section', 'section-schedule');" class="white-color">Generate Section Schedule</a>
                                    </li>
                                </ul> --}}
                            </li>
                            <li name="dashboard-menu">
                                <a href="#">Student</a>
                            </li>
                            <li name="dashboard-menu">
                                <a href="#">Schedule</a>
                            </li>
                            <li id="li-generate-schedule" name="dashboard-menu">
                                <a href="{{ route('generate.schedule') }}" onclick="selectDashboardMenu('generate-schedule');" >Generate Schedule</a>
                            </li>
                        </ul>

                        <ul class="list-unstyled components">
                            <h4 class="px-4 my-4">MAINTENANCE</h4>
                            <li name="dashboard-menu">
                                <a href="#">Admin Accounts</a>
                            </li>
                            <li name="dashboard-menu">
                                <a href="#">Switch School year</a>
                            </li>
                        </ul>
                    </nav>
            
                    <!-- Page Content  -->
                    <div id="content">
            
                        <nav class="navbar navbar-expand-lg navbar-light bg-light">
                            <div class="container-fluid">
            
                                <button type="button" id="sidebarCollapse" class="btn btn-info">
                                    <i class="fas fa-align-left"></i>
                                    
                                </button>
                                <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                    <i class="fas fa-align-justify"></i>
                                </button>
            
                                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                    <ul class="nav navbar-nav ml-auto">
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
