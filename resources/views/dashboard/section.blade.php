@extends('dashboard')

@section('head')
    <title>HCC | Section</title>

    <link href="{{ asset('/css/dashboard/section.css') }}" rel="stylesheet" type="text/css">
@stop

@section('content')
    <div id="viewport">
        <div class="mb-4 d-flex justify-content-between">
            <div class="d-flex">
                <div class="mr-4 d-flex justify-content-center flex-column">
                    <h1 class="d-flex justify-content-center flex-column mb-0">SECTION</h1>
                </div>
                <button type="button" class="btn btn-outline-primary btn-lg" id="addSectModalCall">Add Section</button>    
            </div>
        </div>

        <div class="d-flex justify-content-end mb-4">
            {{-- SEARCH --}}                
            <div class="input-group w-25 mr-3">
                <select class="form-control" id="coursePickerFilter-section">
                </select>
            </div>
            <div class="input-group w-25 mr-3">
                <select class="form-control" id="yearLevelFilter-section">
                    <option value="All">All Year Level</option>
                    <option value="1">First year</option>
                    <option value="2">Second year</option>
                    <option value="3">Third year</option>
                    <option value="4">Fourth year</option>
                </select>
            </div>
            <div class="input-group w-25">
                <input type="text" class="form-control" id="searchField-section" placeholder="Search.." aria-label="Search.." aria-describedby="basic-addon2">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" id="searchField-section" type="button"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </div>
        <div>
            <table class="table">
                <thead class="thead-dark">
                  <tr>
                    <th width="15%" scope="col" class="vertical-center">Course</th>
                    <th width="10%"scope="col" class="vertical-center">Section Code</th>
                    <th width="10%" scope="col" class="vertical-center">Year Level</th>
                    <th width="10%" scope="col" class="vertical-center">Status</th>
                    <th width="20%"scope="col" class="vertical-center">Control</th>
                  </tr>
                </thead>
                <tbody id="sectionTable">
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('page-script')
   
<script src="/js/dashboard/section.js"></script>

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

        loadSectionRecord();
        loadCourses('#coursePicker-section')
        loadCourses('#coursePickerFilter-section', 1)
    });

    function validation() {
        if ($('#sectionCode').val() == '') {
            alert('section code is blank');
        }

      
    }


</script>
@stop
