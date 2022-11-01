@extends('layouts.app')

@section('head')
    <title>HCC | School Year</title>
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css"> --}}
    <link href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.2/css/bootstrap.css" rel="stylesheet"/>
    <link href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.css" rel="stylesheet"/>
@stop

@section('content')
<div class="bg-sy" style="background-image: url('/img/hcc.jpg');">
  <div class="bg-opacity">
    <div class="container pt-4">
      {{-- ACTIVE SHOOLYEAR --}}
      <div id="activeSY">
      </div>

      <div class="mt-5 ">
        {{-- ADD RECORD --}}
        <div class="d-flex justify-content-center mt-5 mb-4">
          <a class="text-deco-n py-3 px-5 border-1-add-sy" id="addNewSchoolYearRecord" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-plus"></i>   Add New Record</a>
        </div>

        {{-- RECORD --}}
        <div class="">
          <div id="recordListSY" class="py-5 row col-md-12 justify-content-center height-with-scroll">
          </div>
        </div>
      </div>
    </div>
  </div>

</div>
@endsection



@section('page-script')
    <script src="/js/schoolyear.js"></script>
    {{-- <script src=" https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script> --}}
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.2/js/bootstrap.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/js/bootstrap-datetimepicker.min.js"></script>
    
   
    <script>
       $(document).ready(function() {
            loadSchoolyearRecord();
          });
    </script>
  
@stop
