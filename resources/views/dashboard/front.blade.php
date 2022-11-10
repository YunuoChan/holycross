@extends('dashboard')

@section('head')
    <title>HCC | Dashboard</title>
@stop

@section('content')
    <div id="viewport">
        <h1>Hello World!</h1>
    </div>
@endsection

@section('page-script')
   
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
