@extends('dashboard')

@section('head')
    <title>HCC | Dashboard</title>

    <link href="{{ asset('/css/dashboard/front.css') }}" rel="stylesheet" type="text/css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css" rel="stylesheet" type="text/css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.2/css/bootstrap.min.css" rel="stylesheet" type="text/css">
@stop

@section('content')
    <div id="viewport">
        
        <div class="min-w-screen min-h-screen bg-gray-200 flex items-center justify-center px-5">
            <div class="card-header py-3 mb-5">
                <div class="d-flex justify-content-between">
                    <div>
                        <h1>DASHBOARD</h1>
                    </div>
                    <div class="d-flex justify-content-center flex-column w-75">
                        <div class="d-flex justify-content-end">
                            <div class="d-flex justify-content-end w-25">
                                <select class="form-control " id="yearLevelDashboard">
                                    <option value="All">All Year Level</option>
                                    <option value="1">First year</option>
                                    <option value="2">Second year</option>
                                    <option value="3">Third year</option>
                                    <option value="4">Fourth year</option>
                                </select>   
                            </div>
                            <div class="d-flex justify-content-end ml-3 w-25">
                                <select class="form-control " id="dashboardCourse">
                                </select>
                            </div>
                        </div>
                       
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center">
                <div class="w-75">
                    <div class="row justify-content-md-center">
                        {{-- STUDENT --}}
                        <div class="col col-lg-4 my-3">
                            <div class="rounded-lg shadow-sm mb-4">
                                <div class="rounded-lg bg-white shadow-lg md:shadow-xl relative overflow-hidden">
                                    <div class="px-3 pt-8 pb-10 text-center relative z-10">
                                        <h4 class="font-1rem text-uppercase color-gray mt-4">Students</h4>
                                        <h3 class="text-3xl text-gray-700 font-semibold leading-tight my-3" id="dasboardStudentCount"></h3>
                                        <a href="{{ route('student') }}">See Record<i class="ml-3 fas fa-arrow-circle-right"></i></a>
                                    </div>
                                    <div class="absolute bottom-0 inset-x-0">
                                        <canvas id="chart1" height="70"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- PROF --}}
                        <div class="col col-lg-4 my-3">
                            <div class="rounded-lg shadow-sm mb-4">
                                <div class="rounded-lg bg-white shadow-lg md:shadow-xl relative overflow-hidden">
                                    <div class="px-3 pt-8 pb-10 text-center relative z-10">
                                        <h4 class="font-1rem text-uppercase color-gray mt-4">Professor</h4>
                                        <h3 class="text-3xl text-gray-700 font-semibold leading-tight my-3" id="dasboardProfessorCount"></h3>
                                        <a href="{{ route('professor') }}">See Record<i class="ml-3 fas fa-arrow-circle-right"></i></a>
                                    </div>
                                    <div class="absolute bottom-0 inset-x-0">
                                        <canvas id="chart2" height="70"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                         {{-- COURSE --}}
                         <div class="col col-lg-4 my-3">
                            <div class="rounded-lg shadow-sm mb-4">
                                <div class="rounded-lg bg-white shadow-lg md:shadow-xl relative overflow-hidden">
                                    <div class="px-3 pt-8 pb-10 text-center relative z-10">
                                        <h4 class="font-1rem text-uppercase color-gray mt-4">Cousre</h4>
                                        <h3 class="text-3xl text-gray-700 font-semibold leading-tight my-3" id="dasboardCourseCount"></h3>
                                        <a href="{{ route('course') }}">See Record<i class="ml-3 fas fa-arrow-circle-right"></i></a>
                                    </div>
                                    <div class="absolute bottom-0 inset-x-0">
                                        <canvas id="chart3" height="70"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- SECTION --}}
                        <div class="col col-lg-4 my-3">
                            <div class="rounded-lg shadow-sm mb-4">
                                <div class="rounded-lg bg-white shadow-lg md:shadow-xl relative overflow-hidden">
                                    <div class="px-3 pt-8 pb-10 text-center relative z-10">
                                        <h4 class="font-1rem text-uppercase color-gray mt-4">Section</h4>
                                        <h3 class="text-3xl text-gray-700 font-semibold leading-tight my-3" id="dasboardSectionCount"></h3>
                                        <a href="{{ route('section') }}">See Record<i class="ml-3 fas fa-arrow-circle-right"></i></a>
                                    </div>
                                    <div class="absolute bottom-0 inset-x-0">
                                        <canvas id="chart4" height="70"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                         {{-- SUBJECT --}}
                         <div class="col col-lg-4 my-3">
                            <div class="rounded-lg shadow-sm mb-4">
                                <div class="rounded-lg bg-white shadow-lg md:shadow-xl relative overflow-hidden">
                                    <div class="px-3 pt-8 pb-10 text-center relative z-10">
                                        <h4 class="font-1rem text-uppercase color-gray mt-4">Subject</h4>
                                        <h3 class="text-3xl text-gray-700 font-semibold leading-tight my-3" id="dasboardSubjectCount"></h3>
                                        <a href="{{ route('subject') }}">See Record<i class="ml-3 fas fa-arrow-circle-right"></i></a>
                                    </div>
                                    <div class="absolute bottom-0 inset-x-0">
                                        <canvas id="chart5" height="70"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>     
        </div>
    </div>
@endsection

@section('page-script')

    <script src="/js/dashboard/front.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js" type="text/javascript"></script>
   
    <script>
        $(document).ready(function() {
            if (localStorage.getItem('current_page') == '') {
                selectDashboardMenu('dashboard')
            } else {
                if (localStorage.getItem('submenu') == null || localStorage.getItem('submenu') == 'null') {
                    selectDashboardMenu(localStorage.getItem('current_page'))
                } else {
                    selectDashboardMenu(localStorage.getItem('current_page'), localStorage.getItem('submenu'))
                }
            }

            loadCourses('#dashboardCourse', 1);
            loadStatistics();
            initChart()
        });
    </script>
  
@stop
