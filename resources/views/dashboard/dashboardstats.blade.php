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
            <div class="d-flex justify-content-center">
                <div class="w-75">
                    <div class="row justify-content-md-center">
                        {{-- I AM STUDENT --}}
                        <div class="col col-lg-4 my-3">
                            <div class="rounded-lg shadow-sm mb-4">
                                <div class="rounded-lg bg-white shadow-lg md:shadow-xl relative overflow-hidden">
                                    <div class="px-3 pt-8 pb-10 text-center relative z-10">
                                        <h4 class="font-1rem text-uppercase color-gray mt-4">Students</h4>
                                        <h3 class="text-3xl text-gray-700 font-semibold leading-tight my-3">3,682</h3>
                                        <a href="{{ route('student') }}">See moree<i class="ml-3 fas fa-arrow-circle-right"></i></a>
                                    </div>
                                    <div class="absolute bottom-0 inset-x-0">
                                        <canvas id="chart1" height="70"></canvas>
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

            const chartOptions = {
                maintainAspectRatio: false,
                legend: {
                    display: false,
                },
                tooltips: {
                    enabled: false,
                },
                elements: {
                    point: {
                        radius: 0
                    },
                },
                scales: {
                    xAxes: [{
                        gridLines: false,
                        scaleLabel: false,
                        ticks: {
                            display: false
                        }
                    }],
                    yAxes: [{
                        gridLines: false,
                        scaleLabel: false,
                        ticks: {
                            display: false,
                            suggestedMin: 0,
                            suggestedMax: 10
                        }
                    }]
                }
            };
            //
            var ctx = document.getElementById('chart1').getContext('2d');
            var chart = new Chart(ctx, {
                type: "line",
                data: {
                    labels: [1, 2, 1, 3, 5, 4, 7],
                    datasets: [
                        {
                            backgroundColor: "rgba(101, 116, 205, 0.1)",
                            borderColor: "rgba(101, 116, 205, 0.8)",
                            borderWidth: 2,
                            data: [3, 6, 4, 1, 2, 4, 7],
                        },
                    ],
                },
                options: chartOptions
            });
            //
            var ctx = document.getElementById('chart2').getContext('2d');
            var chart = new Chart(ctx, {
                type: "line",
                data: {
                    labels: [2, 3, 2, 9, 7, 7, 4],
                    datasets: [
                        {
                            backgroundColor: "rgba(246, 109, 155, 0.1)",
                            borderColor: "rgba(246, 109, 155, 0.8)",
                            borderWidth: 2,
                            data: [2, 3, 2, 9, 7, 7, 4],
                        },
                    ],
                },
                options: chartOptions
            });
            //
            var ctx = document.getElementById('chart3').getContext('2d');
            var chart = new Chart(ctx, {
                type: "line",
                data: {
                    labels: [2, 5, 1, 3, 2, 6, 7],
                    datasets: [
                        {
                            backgroundColor: "rgba(246, 153, 63, 0.1)",
                            borderColor: "rgba(246, 153, 63, 0.8)",
                            borderWidth: 2,
                            data: [2, 5, 1, 3, 2, 6, 7],
                        },
                    ],
                },
                options: chartOptions
            });

            //
            var ctx = document.getElementById('chart4').getContext('2d');
            var chart = new Chart(ctx, {
                type: "line",
                data: {
                    labels: [2, 5, 1, 3, 2, 6, 7],
                    datasets: [
                        {
                            backgroundColor: "rgba(246, 153, 63, 0.1)",
                            borderColor: "rgba(246, 153, 63, 0.8)",
                            borderWidth: 2,
                            data: [2, 8, 1, 3, 2, 6, 7],
                        },
                    ],
                },
                options: chartOptions
            });
        });
    </script>
  
@stop
