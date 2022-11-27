@extends('dashboard')

@section('head')
    <title>HCC | Dashboard</title>

    <link href="{{ asset('/css/dashboard/front.css') }}" rel="stylesheet" type="text/css">
@stop

@section('content')
    <div id="viewport">
        <h1>Hello World!</h1>
    </div>
@endsection

@section('page-script')
   
    <script src="/js/dashboard/front.js"></script>
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
        });
    </script>
  
@stop
