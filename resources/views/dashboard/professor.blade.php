@extends('dashboard')

@section('head')
    <title>HCC | Professor</title>

    <link href="{{ asset('/css/dashboard/professor.css') }}" rel="stylesheet" type="text/css">

@stop

@section('content')
    <div id="viewport">
        <div class="mb-4 d-flex justify-content-between">
            <div class="d-flex">
                <div class="mr-4 d-flex justify-content-center flex-column">
                    <h1 class="d-flex justify-content-center flex-column mb-0">PROFESSOR</h1>
                </div>
                <button type="button" class="btn btn-outline-primary btn-lg mr-3" id="addProfessorModalCall">Add Professor</button>   
                <button type="button" class="btn btn-outline-primary btn-lg" id="importCSVProfessorModalCall">Import CSV</button> 
            </div>
        </div>
        <div class="d-flex justify-content-end mb-4">
            {{-- SEARCH --}}                
            <div class="input-group w-25 mr-3">
                <select class="form-control" id="coursePickerFilter-professor">
                </select>
            </div>
            <div class="input-group w-25">
                <input type="text" class="form-control" id="searchField-professor" placeholder="Search.." aria-label="Search.." aria-describedby="basic-addon2">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" id="searchBtn-professor" type="button"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </div>
        <div>
            <table class="table">
                <thead class="thead-dark">
                  <tr>
                    <th width="10%" scope="col" class="vertical-center">Department</th>
                    <th width="10%" scope="col" class="vertical-center">Prof ID No</th>
                    <th width="15%" scope="col" class="vertical-center">Name</th>
                    {{-- <th width="10%" scope="col" class="vertical-center">Status</th> --}}
                    <th width="15%"scope="col" class="vertical-center">Control</th>
                  </tr>
                </thead>
                <tbody id="professorTable">
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('page-script')
       
    <script src="/js/dashboard/professor.js"></script>
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

            loadCourses('#coursePicker-professor');
            loadCourses('#coursePickerFilter-professor', 1);
            loadProfessorRecord();
            initUploadNameChange('#customFileProf', '#uploadCSVProfessor');

            var status = '{{ $status }}';
            var message = '{{ $message }}';
            var countNotInsert = '{{ $notInserted }}';
            if (status != '') {
                if (status == 'success') {
                    customToaster('Success!', message, status);

                    if (parseInt(countNotInsert) > 0) {
                        customToaster('Warning', (countNotInsert-1)+' record(s) is duplicated or not valid.', 'warning')
                    }
                } else {
                    customToaster('Failed!', message, status)
                    customToaster('Warning', 'No record added.', 'warning')
                }
            }
        });
    </script>
  
@stop
