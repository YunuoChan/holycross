@extends('schoolyear')

@section('head')
    <title>HCC | School Year</title>
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css"> --}}
    {{-- <link href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.2/css/bootstrap.css" rel="stylesheet"/>
    <link href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.css" rel="stylesheet"/> --}}
@stop

@section('content')
<div class="bg-sy" style="background-image: url('/img/hcc-bg.jpg');">
  <div class="bg-opacity">
    <div class="container bg-opacity-schoolyear" style="height: 100vh;">
        <div class="d-flex">
          {{-- ACTIVE SHOOLYEAR --}}
          <div class="col-lg-6">  
            <div class="d-flex justify-content-center flex-column mt-5">
              <div class="d-flex justify-content-center">
                <h3 class="mt-5 color-white">Active Schoolyear</h3>
              </div>
              <div id="activeSY" class="d-flex justify-content-center">
              </div>  
            </div>
          </div>
          <div class="col-lg-6">
            <div class="mt-5 ">
              {{-- ADD RECORD --}}
              <div class="d-flex justify-content-center mt-5 mb-4">
                <a class="text-deco-n py-3 px-5 border-1-add-sy" id="addNewSchoolYearRecord" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-plus"></i>   Add New Record</a>
              </div>

              {{-- RECORD --}}
              <div class="">
                <div class="d-flex justify-content-center">
                  <h4 class="color-white">Schoolyear List</h4>
                </div>
                <div class="tableFixHead">
                  <div id="recordListSY" class="pb-3 row col-md-12 justify-content-center">
                  </div>  
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
    <script src="/js/schoolyear.js"></script>
    {{-- <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.js"></script> --}}
 
    <script>
       $(document).ready(function() {
            loadSchoolyearRecord();
          });
    </script>
  
@stop
