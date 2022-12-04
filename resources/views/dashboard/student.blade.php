@extends('dashboard')

@section('head')
    <title>HCC | Students</title>

    <link href="{{ asset('/css/dashboard/student.css') }}" rel="stylesheet" type="text/css">
@stop

@section('content')
    <div id="viewport">
        <div class="mb-4 d-flex justify-content-between">
            <div class="d-flex">
                <div class="mr-4 d-flex justify-content-center flex-column">
                    <h1 class="d-flex justify-content-center flex-column mb-0">STUDENT</h1>
                </div>
                <button type="button" class="btn btn-outline-primary btn-lg mr-3" id="addStudentModalCall">Add Student</button>    
                <button type="button" class="btn btn-outline-primary btn-lg" id="importCSVStudentModalCall">Import CSV</button>

               
            </div>
        </div>
        <div class="d-flex justify-content-end mb-4">
            {{-- SEARCH --}}                
            <div class="input-group w-25 mr-3">
                <select class="form-control" id="coursePickerFilter-student">
                </select>
            </div>
            <div class="input-group w-25 mr-3">
                <select class="form-control" id="yearLevelFilter-student">
                    <option value="All">All Year Level</option>
                    <option value="1">First year</option>
                    <option value="2">Second year</option>
                    <option value="3">Third year</option>
                    <option value="4">Fouth year</option>
                </select>
            </div>
            <div class="input-group w-25">
                <input type="text" class="form-control" id="searchField-student" placeholder="Search.." aria-label="Search.." aria-describedby="basic-addon2">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" id="searchBtn-student" type="button"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </div>
        <div>
            <table class="table">
                <thead class="thead-dark">
                  <tr>
                    <th width="10%" scope="col" class="vertical-center">Student ID No</th>
                    <th width="15%" scope="col" class="vertical-center">Name</th>
                    <th width="10%" scope="col" class="vertical-center">Course</th>
                    <th width="10%"scope="col" class="vertical-center">Section</th>
                    <th width="10%" scope="col" class="vertical-center">Year Level</th>
                    <th width="10%" scope="col" class="vertical-center">Status</th>
                    <th width="15%"scope="col" class="vertical-center">Control</th>
                  </tr>
                </thead>
                <tbody id="studentTable">
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('page-script')
   
<script src="/js/dashboard/student.js"></script>

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

        // loadSectionRecord();
        loadCourses('#coursePicker-student')
        loadCourses('#coursePickerFilter-student')
        loadSectionRecord();
        loadStudentRecord();
        studentCoursePickOnChange();
        initUploadNameChange('#customFile', '#uploadCSVStudent');

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

    function validation() {
        if ($('#studentIdNo').val() == '') {
            alert('student id is blank');
        }

        if ($('#studentName').val() == '') {
            alert('student name is blank');
        }
    }
</script>
@stop
