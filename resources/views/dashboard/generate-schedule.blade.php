@extends('dashboard')

@section('head')
    <title>HCC | Section Subject</title>

    <link href="{{ asset('/css/dashboard/generate-schedule.css') }}" rel="stylesheet" type="text/css">
@stop

@section('content')
    <div id="viewport">
            <div class="mr-4 d-flex mb-3">
                <div class="mr-4 d-flex justify-content-center flex-column">
                    <h1 class="d-flex justify-content-center mb-0">GENERATE SCHEDULE</h1>
                </div>
                <button type="button" class="btn btn-outline-primary btn-lg" id="generateSchedFirstYear">Generate Schedule</button>   
            </div>
            <div class="d-flex justify-content-end mb-4">
                {{-- SEARCH --}}                
                <div class="input-group w-25 mr-3">
                    <select class="form-control" id="coursePickerFilter-generatedSched">
                    </select>
                </div>
            </div>
            {{-- COURSE PICKER --}}
            {{-- <div class="d-flex justify-content-end">
                <div class="form-group w-25">
                    <label for="coursePicker-generate-sched">Select Course</label>
                    <select class="form-control" id="coursePicker-generate-sched">
                    </select>
                </div>  
            </div> --}}
            
            <div>
                {{-- FIRST YEAR --}}
                <div class="card my-3">
                    <div class="card-header py-3">
                        <div class="d-flex justify-content-between">
                            <h3 class="d-flex justify-content-center flex-column mb-0">First Year</h3>  
                        </div>
                    </div>
                    <div class="row mx-3" id="firstYearSectionDiv">
                        <div class="col col-lg-4">
                            <div class="card border-success my-3">
                                <div class="card-header">Header</div>
                                <div class="card-body text-success">
                                    <h5 class="card-title">Success card title</h5>
                                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col col-lg-4">
                            <div class="card border-success my-3">
                                <div class="card-header">Header</div>
                                <div class="card-body text-success">
                                    <h5 class="card-title">Success card title</h5>
                                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- SECONDYEAR --}}
                <div class="card my-3">
                    <div class="card-header py-3">
                        <div class="d-flex justify-content-between">
                            <h3 class="d-flex justify-content-center flex-column mb-0">Second Year</h3>  
                        </div>
                    </div>
                    <div class="row mx-3" id="secondYearSectionDiv">
                        <div class="col col-lg-4">
                            <div class="card border-success my-3">
                                <div class="card-header">Header</div>
                                <div class="card-body text-success">
                                    <h5 class="card-title">Success card title</h5>
                                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col col-lg-4">
                            <div class="card border-success my-3">
                                <div class="card-header">Header</div>
                                <div class="card-body text-success">
                                    <h5 class="card-title">Success card title</h5>
                                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- THIRD --}}
                <div class="card my-3">
                    <div class="card-header py-3">
                        <div class="d-flex justify-content-between">
                            <h3 class="d-flex justify-content-center flex-column mb-0">Third Year</h3>  
                        </div>
                    </div>
                    <div class="row mx-3" id="thirdYearSectionDiv">
                        <div class="col col-lg-4">
                            <div class="card border-success my-3">
                                <div class="card-header">Header</div>
                                <div class="card-body text-success">
                                    <h5 class="card-title">Success card title</h5>
                                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col col-lg-4">
                            <div class="card border-success my-3">
                                <div class="card-header">Header</div>
                                <div class="card-body text-success">
                                    <h5 class="card-title">Success card title</h5>
                                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- FOURTH --}}
                <div class="card my-3">
                    <div class="card-header py-3">
                        <div class="d-flex justify-content-between">
                            <h3 class="d-flex justify-content-center flex-column mb-0">Fourth Year</h3>  
                        </div>
                    </div>
                    <div class="row mx-3" id="fourthYearSectionDiv">
                        <div class="col col-lg-4">
                            <div class="card border-success my-3">
                                <div class="card-header">Header</div>
                                <div class="card-body text-success">
                                    <h5 class="card-title">Success card title</h5>
                                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col col-lg-4">
                            <div class="card border-success my-3">
                                <div class="card-header">Header</div>
                                <div class="card-body text-success">
                                    <h5 class="card-title">Success card title</h5>
                                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        {{-- </div> --}}
    </div>
@endsection

@section('page-script')
   
    <script src="/js/dashboard/generate-schedule.js"></script>
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

            loadCourses('#coursePicker-generate-sched', 1);
            loadCourses('#coursePickerFilter-generatedSched', 1);

            loadSectionSubjectRecord();

        });
    </script>
  
@stop
