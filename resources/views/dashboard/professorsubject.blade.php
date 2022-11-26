@extends('dashboard')

@section('head')
    <title>HCC | Professor Subject</title>
    <link href="{{ asset('/css/dashboard/professorsubject.css') }}" rel="stylesheet" type="text/css">

@stop

@section('content')
    <div id="viewport">
        <div class="mb-4 d-flex justify-content-between">
            <div class="d-flex">
                <div class="mr-4 d-flex justify-content-center flex-column">
                    <h1 class="d-flex justify-content-center flex-column mb-0">ASSIGN SUBJECT FOR PROFESSOR</h1>
                </div>
                {{-- <button type="button" class="btn btn-outline-primary btn-lg mr-3" id="addProfessorSubjectModalCall">Assign Subject</button>     --}}
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
                    <th width="10%" scope="col" class="vertical-center">Prof ID No</th>
                    <th width="10%" scope="col" class="vertical-center">Name</th>
                    <th width="30%" scope="col" class="vertical-center">Subject Assigned</th>
                    <th width="8%" scope="col" class="vertical-center">Status</th>
                    <th width="5%"scope="col" class="vertical-center">Control</th>
                  </tr>
                </thead>
                <tbody id="professorSubjectTable">
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('page-script')
       
    <script src="/js/dashboard/professorsubject.js"></script>
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
    
            // loadCourses('#coursePicker-professorSubject');
            loadProfessorSubjectRecord();
        });
    </script>
  
@stop
