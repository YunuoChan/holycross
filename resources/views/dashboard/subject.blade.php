@extends('dashboard')

@section('head')
    <title>HCC | Subject</title>
    {{-- <link href="{{ asset('/plugin/timeselector/timeselector.css') }}" rel="stylesheet" type="text/css"> --}}
    <link href="{{ asset('/css/dashboard/subject.css') }}" rel="stylesheet" type="text/css">
@stop

@section('content')
    <div id="viewport">

        <div class="mb-4 d-flex justify-content-between">
            <div class="d-flex">
                <div class="mr-4 d-flex justify-content-center flex-column">
                    <h1 class="d-flex justify-content-center flex-column mb-0">SUBJECT</h1>
                </div>
                <button type="button" class="btn btn-outline-primary btn-lg" id="addSubjModalCall">Add Subject</button>    
            </div>
            {{-- SEARCH --}}
            <div class="d-flex justify-content-center flex-column mb-0">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search.." aria-label="Search.." aria-describedby="basic-addon2">
                    <div class="input-group-append">
                      <button class="btn btn-outline-secondary" type="button"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <table class="table">
                <thead class="thead-dark">
                  <tr>
                    <th width="10%"scope="col" class="vertical-center">Course</th>
                    <th width="15%"scope="col" class="vertical-center">Subject Code</th>
                    <th width="15%" scope="col" class="vertical-center">Subject</th>
                    <th width="10%" scope="col" class="vertical-center">Room No</th>
                    <th width="7%"scope="col" class="vertical-center">Unit</th>
                    <th width="12%" scope="col" class="vertical-center">Time to Consume</th>
                    <th width="10%" scope="col" class="vertical-center">Year Level</th>
                    <th width="10%" scope="col" class="vertical-center">Status</th>
                    <th width="20%"scope="col" class="vertical-center">Control</th>
                  </tr>
                </thead>
                <tbody id="subjectTable">
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('page-script')
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js" type="text/javascript"></script>
    <script src="/plugin/timeselector/timeselector.js" type="text/javascript"></script> --}}
    <script src="/js/dashboard/subject.js"></script>

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

            loadSubjectRecord();
            loadCourses('#coursePicker-subject')
        });

        function validation() {
        if ($('#subjectCode').val() == '') {
            alert('Subject Code is blank');
        }

        if ($('#subjectName').val() == '') {
            alert('Subject Name is blank');
        }
        if ($('#subjectUnit').val() == '') {
            alert('Subject Unit is blank');
        }
    }








    </script>
  
@stop
