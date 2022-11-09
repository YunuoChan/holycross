@extends('layouts.app')

@section('head')
    <title>HCC | Dashboard</title>

    <link href="{{ asset('/css/dashboard.css') }}" rel="stylesheet" type="text/css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css" rel="stylesheet" type="text/css">

@stop

@section('content')
    <div id="viewport">
        <!-- Sidebar -->
        <div id="sidebar">
        <header>
            <a href="#">My App</a>
        </header>
        <ul class="nav">
            <li>
                <a href="#">
                    <i class="zmdi zmdi-view-dashboard"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="zmdi zmdi-link"></i> Shortcuts
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="zmdi zmdi-widgets"></i> Overview
                </a>
            </li>
            <li>
            <a href="#">
                <i class="zmdi zmdi-calendar"></i> Events
            </a>
            </li>
            <li>
                <a href="#">
                    <i class="zmdi zmdi-info-outline"></i> About
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="zmdi zmdi-settings"></i> Services
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="zmdi zmdi-comment-more"></i> Contact
                </a>
            </li>
        </ul>
        </div>
        <!-- Content -->
        <div id="content">
        {{-- <nav class="navbar navbar-default">
            <div class="container-fluid">
            <ul class="nav navbar-nav navbar-right">
                <li>
                <a href="#"><i class="zmdi zmdi-notifications text-danger"></i>
                </a>
                </li>
                <li><a href="#">Test User</a></li>
            </ul>
            </div>
        </nav> --}}
        <div class="container-fluid">
            <h1>Simple Sidebar</h1>
            <p>
            Make sure to keep all page content within the 
            <code>#content</code>.
            </p>
        </div>
        </div>
    </div>
@endsection



@section('page-script')
   
    <script>
        $(document).ready(function() {

        });
    </script>
  
@stop
