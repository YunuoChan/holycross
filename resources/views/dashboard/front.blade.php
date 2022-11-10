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
                selectDashboardMenu(localStorage.setItem('current_page'))
            }
        });
    </script>
  
@stop
