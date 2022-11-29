
{{-- SCHOOLYEAR --}}
<div class="modal fade" id="addSchoolYearRecord" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top: 140px">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add School Year Record</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" data-bs-dismiss="modal">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="mb-3">
            <small class="text-muted sub-title">
              <strong>Note:</strong><em>All fields marked with an asterisk (<span class="required-asterisk">*</span>) are required.</em>
            </small>  
          </div>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label pt-0">School Year</label>
            <div class="d-flex justify-content-between ml-3">
              <div class="d-flex justify-content-start w-50 mr-2">
                <div class="d-flex justify-content-center flex-column">
                  <label for="sySelectFromPicker" class="m-0 pr-2">From<span class="required-asterisk">*</span></label>
                </div>
                <select class="form-control" id="sySelectFromPicker"></select>
              </div>
              <div class="d-flex justify-content-start w-50 ml-2">
                <div class="d-flex justify-content-center flex-column">
                  <label for="sySelectToPicker" class="m-0 pr-2">To<span class="required-asterisk">*</span></label>
                </div>
                <select class="form-control" id="sySelectToPicker"></select>
              </div>
            </div> <div class="form-group w-75 mt-4">
              <label for="sySemester">Semester<span class="required-asterisk">*</span></label>
              <select class="form-control" id="sySemester">
                <option value="1">First Semester</option>
                <option value="2">Second Semester
                </option>
              </select>
            </div>
          </div>


        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary w-25" id="saveNewSy">Add S.Y.</button>
      </div>
    </div>
  </div>
</div>


{{-- SUBJECT --}}
<div class="modal fade" id="addSubjectRecord" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top: 50px">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header modal-header-custom">
        <h5 class="modal-title">Add New Subject</h5>
        <button type="button" class="close white-color" data-dismiss="modal" aria-label="Close" data-bs-dismiss="modal">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="mb-3">
            <small class="text-muted sub-title">
              <strong>Note:</strong><em>All fields marked with an asterisk (<span class="required-asterisk">*</span>) are required.</em>
            </small>  
          </div>
          <div class="d-flex justify-content-start">
            <div class="form-group w-25 mr-3">
              <label for="subjectCode">Subject Code<span class="required-asterisk">*</span></label>
              <input type="text" class="form-control" id="subjectCode" placeholder="Code" maxlength="10">
            </div>
            <div class="form-group w-75">
              <label for="subjectName">Subject<span class="required-asterisk">*</span></label>
              <input type="text" class="form-control" id="subjectName" placeholder="Subject Name" maxlength="35">
            </div>
          </div>
          <div class="form-group">
            <label for="coursePicker-subject">Select Course<span class="required-asterisk">*</span></label>
            <select class="form-control" id="coursePicker-subject">
            </select>
            {{-- <label for="subjectDescription">Description</label>
            <textarea class="form-control" id="subjectDescription" rows="3" placeholder="Description" maxlength="254"></textarea> --}}
          </div>
          <div class="d-flex justify-content-start">
            <div class="form-group w-25 mr-3">
              <label for="subjectUnit">Unit</label>
              <input type="number" class="form-control" id="subjectUnit" placeholder="Unit" min=".5">
            </div>
            <div class="form-group w-75">
              <label for="subjectYearlevel">Year Level<span class="required-asterisk">*</span></label>
              <select class="form-control" id="subjectYearlevel">
                <option value="1">First year</option>
                <option value="2">Second year</option>
                <option value="3">Third year</option>
                <option value="4">Fouth year</option>
              </select>
            </div>
          </div>

          <div class="d-flex justify-content-start">
            <div class="form-group w-50 mr-3">
              <label for="subjectTime">Time to Consume<span class="required-asterisk">*</span></label>
              <select class="form-control" id="subjectTime">
                <option selected disabled>Time to Consume</option>
                <option value="0.25">15mins</option>
                <option value="0.5">30mins</option>
                <option value=".75">45mins</option>
                <option value="1">1hr</option>
                <option value="1.5">1hr 30mins</option>
                <option value="2">2hrs</option>
                <option value="2.5">2hrs 30mins</option>
                <option value="3">3hrs</option>
                <option value="3.5">3hrs 30mins</option>
                <option value="4">4hrs</option>
                <option value="4.5">4hrs 30mins</option>
                <option value="5">5hrs</option>
                <option value="5.5">5hrs 30mins</option>
                <option value="6">6hrs</option>
                <option value="6.5">6hrs 30mins</option>
                <option value="7">7hrs</option>
                <option value="7.5">7hrs 30mins</option>
                <option value="8">8hrs</option>
              </select>
            </div>
            <div class="form-group w-50">
              <label for="subjectRoomNo">Room</label>
              <input type="text" class="form-control" id="subjectRoomNo" placeholder="Room No" maxlength="10">
            </div>
          </div>
          
        </form>
      </div>
      <div class="modal-footer" id="subjectModalBtn">
        <button type="button" class="btn btn-primary w-25" id="saveNewSubject">Add Subject</button>
      </div>
    </div>
  </div>
</div>


{{-- SECTION --}}
<div class="modal fade" id="addSectionRecord" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top: 50px">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header modal-header-custom">
        <h5 class="modal-title">Add New Section</h5>
        <button type="button" class="close white-color" data-dismiss="modal" aria-label="Close" data-bs-dismiss="modal">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="mb-3">
            <small class="text-muted sub-title">
              <strong>Note:</strong><em>All fields marked with an asterisk (<span class="required-asterisk">*</span>) are required.</em>
            </small>  
          </div>
          <div class="d-flex justify-content-start">
            <div class="form-group w-50 mr-3 mb-0">
              <label for="sectionCode">Section Code<span class="required-asterisk">*</span></label>
              <input type="text" class="form-control" id="sectionCode" placeholder="Code" maxlength="10">
            </div>
            <div class="form-group w-50">
              <label for="coursePicker-section">Select Course<span class="required-asterisk">*</span></label>
              <select class="form-control" id="coursePicker-section">
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="sectionYearlevel">Year Level<span class="required-asterisk">*</span></label>
            <select class="form-control" id="sectionYearlevel">
              <option value="1">First year</option>
              <option value="2">Second year</option>
              <option value="3">Third year</option>
              <option value="4">Fouth year</option>
            </select>
          </div>
        </form>
      </div>
      <div class="modal-footer" id="sectionModalBtn">
      </div>
    </div>
  </div>
</div>



{{-- SECTION SUBJETC --}}
<div class="modal fade" id="addSectionSubjectRecord" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top: 50px">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header modal-header-custom">
        <h5 class="modal-title">Add Subject in Section</h5>
        <button type="button" class="close white-color" data-dismiss="modal" aria-label="Close" data-bs-dismiss="modal">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="d-flex justify-content-start">
            <div class="form-group mr-3">
              <div id="addSectionSubjectSection">
                <h3>Section</h3>
                <p>Code</p>
              </div>
             
            </div>
          </div>
          <div class="form-group">
            <label><h4>Subjects</h4></label>  
            <div class="ml-3" id="sectionSubjectPicker">
              
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer" id="sectionSubjecModalBtn">
      </div>
    </div>
  </div>
</div>


{{-- GENERATE SCHEDULE --}}
<div class="modal fade" id="generateScheduleModal" tabindex="-1" role="dialog" aria-hidden="true" style="margin-top: 50px">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header modal-header-custom">
        <h5 class="modal-title">Generate Scheduler</h5>
        <button type="button" class="close white-color" data-dismiss="modal" aria-label="Close" data-bs-dismiss="modal">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="mb-3">
            <small class="text-muted sub-title">
              <strong>Note:</strong><em>All fields marked with an asterisk (<span class="required-asterisk">*</span>) are required.</em>
            </small>  
          </div>
          <div class="d-flex justify-content-start">
            <div class="form-group mr-3 w-100">
                <label for="coursePicker-generate-sched">Select Course<span class="required-asterisk">*</span></label>
                <select class="form-control" id="coursePicker-generate-sched">
                </select>
            </div>
          </div>
          <div class="form-group">
            <label for="generateSchedYearlevel">Year Level<span class="required-asterisk">*</span></label>
            <select class="form-control" id="generateSchedYearlevel">
              <option value="1">First year</option>
              <option value="2">Second year</option>
              <option value="3">Third year</option>
              <option value="4">Fouth year</option>
            </select>
          </div>
        </form>
      </div>
      <div class="modal-footer" id="generateScheduleBtnDiv">
      </div>
    </div>
  </div>
</div>



{{-- STUDENT --}}
<div class="modal fade" id="addStudentRecord" tabindex="-1" role="dialog" aria-hidden="true" style="margin-top: 50px">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header modal-header-custom">
        <h5 class="modal-title">Add Student Record</h5>
        <button type="button" class="close white-color" data-dismiss="modal" aria-label="Close" data-bs-dismiss="modal">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="mb-3">
            <small class="text-muted sub-title">
              <strong>Note:</strong><em>All fields marked with an asterisk (<span class="required-asterisk">*</span>) are required.</em>
            </small>  
          </div>
          <div class="d-flex justify-content-start">
            <div class="form-group w-50 mr-3">
              <label for="studentIdNo">Student Id Number<span class="required-asterisk">*</span></label>
              <input type="text" class="form-control" id="studentIdNo" placeholder="Id Number" maxlength="10">
            </div>
          </div>
          <div class="form-group">
            <label for="studentName">Student Name<span class="required-asterisk">*</span></label>
            <input type="text" class="form-control" id="studentName" placeholder="Student Name" maxlength="35">
          </div>
          <div class="d-flex justify-content-start">
            <div class="form-group w-50 mr-3">
              <label for="coursePicker-student">Select Course<span class="required-asterisk">*</span></label>
              <select class="form-control" id="coursePicker-student">
              </select>
            </div>
            <div class="form-group w-50">
              <label for="studentYearlevel">Year Level<span class="required-asterisk">*</span></label>
              <select class="form-control" id="studentYearlevel">
                <option value="1">First year</option>
                <option value="2">Second year</option>
                <option value="3">Third year</option>
                <option value="4">Fouth year</option>
              </select>
             
            </div>
          </div>
          <div class="form-group w-50"  id="studentSectionDiv">
            <label for="studentSection">Section<span class="required-asterisk">*</span></label>
              <select class="form-control" id="studentSection">
              </select>
          </div>
        </form>
      </div>
      <div class="modal-footer" id="studentModalBtn">
      </div>
    </div>
  </div>
</div>




{{-- PROFESSOR --}}
<div class="modal fade" id="addProfessorRecord" tabindex="-1" role="dialog" aria-hidden="true" style="margin-top: 50px">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header modal-header-custom">
        <h5 class="modal-title">Add Professor Record</h5>
        <button type="button" class="close white-color" data-dismiss="modal" aria-label="Close" data-bs-dismiss="modal">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="mb-3">
            <small class="text-muted sub-title">
              <strong>Note:</strong><em>All fields marked with an asterisk (<span class="required-asterisk">*</span>) are required.</em>
            </small>  
          </div>
          <div class="d-flex justify-content-start">
            <div class="form-group w-50 mr-3">
              <label for="professorIdNo">Professor Id Number<span class="required-asterisk">*</span></label>
              <input type="text" class="form-control" id="professorIdNo" placeholder="Id Number" maxlength="10">
            </div>
            <div class="form-group w-50 mr-3">
              <label for="coursePicker-professor">Select Department</label>
              <select class="form-control" id="coursePicker-professor">
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="professorName">Professor Name<span class="required-asterisk">*</span></label>
            <input type="text" class="form-control" id="professorName" placeholder="Professor Name" maxlength="35">
          </div>
        </form>
      </div>
      <div class="modal-footer" id="professorModalBtn">
      </div>
    </div>
  </div>
</div>




{{-- SECTION SUBJETC --}}
<div class="modal fade" id="addProfessorSubjectRecord" tabindex="-1" role="dialog" aria-hidden="true" style="margin-top: 50px">
  <div class="modal-dialog" role="document">
    <div class="modal-content modal-specific">
      <div class="modal-header modal-header-custom">
        <h5 class="modal-title">Assign Subject for Professor</h5>
        <button type="button" class="close white-color" data-dismiss="modal" aria-label="Close" data-bs-dismiss="modal">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="d-flex justify-content-start mb-3">
            <div class="form-group mr-3">
              <div class="d-flex">
                <img class="card-img-top w-15 h-15" src="/img/logo.jpg" alt="Holy Cross Student" height="auto">
                <div class="ml-3 d-flex justify-content-center flex-column">
                  <div>
                    <h3 id="profName"></h3>
                    <div class="d-flex">
                      <p class="mb-0">ID Number: </p> <span id="profIdNo"></span> 
                    </div>
                    <div class="d-flex">
                      <p class="mb-0">Department: </p> <span id="deptName"></span> 
                    </div>  
                  </div>
                </div>
              </div>
             
            </div>
          </div>
          <div class="tableFixHead form-group">

            <h4>Choose Subject</h4>
            <table class="table">
              <thead class="thead-dark">
                <tr>
                  <th width="10%" scope="col" class="vertical-center">Year Level</th>
                  <th width="15%" scope="col" class="vertical-center">Course & Section</th>
                  <th width="15%" scope="col" class="vertical-center">Subject</th>
                  <th width="15%"scope="col" class="vertical-center">Day and Time</th>
                </tr>
              </thead>
              <div>
                <tbody id="appendSubjectTable">
                </tbody>  
              </div>
            </table>
          </div>

          <div class="mt-4">
            <h4>Selected Subject</h4>
            <div class="list-group tableFixHead" id="toAssignSubject">
              
            </div>
          </div>

        </form>
      </div>
      <div class="modal-footer" id="professorSubjectModalBtn">
      </div>
    </div>
  </div>
</div>



{{-- SECTION SUBJETC --}}
<div class="modal fade" id="studentImportModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top: 50px">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header modal-header-custom">
        <h5 class="modal-title">Add Student via CSV File</h5>
        <button type="button" class="close white-color" data-dismiss="modal" aria-label="Close" data-bs-dismiss="modal">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="mb-4">
          <div class="d-flex">
            <h4>Instruction</h4>
          </div>
          <ul>
            <li><a class="btn btn-success" href="{{ route('download-samplecsv') }}">Download Sample CSV</a> File Template</li>
            <li>Add all the fields needed (StudentId, Name, and SectionCode)</li>
            <li>Once done, browse the CSV file and import</li>
          </ul>
        </div>
        <div class="mb-4">
          <div class="d-flex">
            <h5>#Note</h5>
          </div>
          <ul>
            <li>Duplicated Student Id will be ignored</li>
            <li>Missing fields will also be ignore and will not be added on the database</li>
            <li>Only matching data will be added (mostly on section code)</li>
            <li>Do not remove the first line(studentId,name,sectionCode) in the CSV Template. Record will not be validated</li>
            <li>Add the record accordingly in the CSV.</li>
          </ul>
        </div>

        <form action="{{ route('file-import') }}" method="POST" enctype="multipart/form-data">
          <h4>Import CSV</h4>
          @csrf
          <div class="form-group mb-4" style="max-width: 500px; margin: 0 auto;">
              <div class="custom-file text-left">
                  <input type="file" name="file" class="custom-file-input" id="customFile">
                  <label class="custom-file-label" for="customFile">Choose file</label>
              </div>
          </div>
          <div class="d-flex justify-content-end">
            <button class="btn btn-primary">Import data</button>
          </div>
        </form>
      </div>
      <div class="modal-footer" id="sectionSubjecModalBtn">
      </div>
    </div>
  </div>
</div>





{{-- SCHOOLYEAR SWITCH ADMIN --}}
<div class="modal fade" id="switchSchoolYearModal" tabindex="-1" role="dialog" aria-hidden="true" style="margin-top: 50px">
  <div class="modal-dialog" role="document">
    <div class="modal-content modal-specific">
      <div class="modal-header modal-header-custom">
        <h5 class="modal-title">Assign Subject for Professor</h5>
        <button type="button" class="close white-color" data-dismiss="modal" aria-label="Close" data-bs-dismiss="modal">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="d-flex justify-content-start mb-3">
            <div class="col-lg-6 px-0">
              <small class="mb-0">Current</small> 
              <h4 id="currentSYToModal"></h4> 
            </div>
            <div class="col-lg-6 px-0">
              <small class="mb-0">Active</small> 
              <h4 id="activeSYToModal"></h4> 
            </div>  
          </div>

          <div class="mt-4">
            <p class="mb-0">Select Schoolyear</p>
            <div class="list-group tableFixHead" id="schoolyearListOnModal">
            </div>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>



{{-- PROFESSOR --}}
<div class="modal fade" id="addCourseRecord" tabindex="-1" role="dialog" aria-hidden="true" style="margin-top: 50px">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header modal-header-custom">
        <h5 class="modal-title">Add Course</h5>
        <button type="button" class="close white-color" data-dismiss="modal" aria-label="Close" data-bs-dismiss="modal">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="mb-3">
            <small class="text-muted sub-title">
              <strong>Note:</strong><em>All fields marked with an asterisk (<span class="required-asterisk">*</span>) are required.</em>
            </small>  
          </div>
          <div class="form-group w-50 mr-3 mb-0">
            <label for="courseCode">Course Code<span class="required-asterisk">*</span></label>
            <input type="text" class="form-control" id="courseCode" placeholder="Course code" maxlength="10">
          </div>
          <div class="form-group">
            <label for="courseName">Course<span class="required-asterisk">*</span></label>
            <input type="text" class="form-control" id="courseName" placeholder="Course name" maxlength="50">
          </div>
      </div>
      <div class="modal-footer" id="courseModalBtn">
      </div>
    </div>
  </div>
</div>



{{-- ACCOUNTS --}}
<div class="modal fade" id="addAdminAccountModal" tabindex="-1" role="dialog" aria-hidden="true" style="margin-top: 50px">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header modal-header-custom">
        <h5 class="modal-title">Add Course</h5>
        <button type="button" class="close white-color" data-dismiss="modal" aria-label="Close" data-bs-dismiss="modal">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="mb-3">
            <small class="text-muted sub-title">
              <strong>Note:</strong><em>All fields marked with an asterisk (<span class="required-asterisk">*</span>) are required.</em>
            </small>  
          </div>
          <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="row mb-3">
              <div class="form-group mr-3 mb-0">
                <label for="name">{{ __('Name') }}<span class="required-asterisk">*</span></label>
                <div>
                  <input id="name" type="text" placeholder="Please input name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                  @error('name')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
                </div>
              </div>
            </div>

            <div class="row mb-3">

              <div class="form-group mr-3 mb-0">
                <label for="email">{{ __('Email Address') }}<span class="required-asterisk">*</span></label>

                <div>
                    <input id="email" type="email" placeholder="Email Address" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
              </div>
            </div>

            <div class="d-flex justify-content-start">
              <div class="row mb-3 mr-3">
                  <label for="password">{{ __('Password') }}<span class="required-asterisk">*</span></label>
                  <div>
                      <input id="password" type="password" placeholder="Password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                      @error('password')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                  </div>
              </div>

              <div class="row mb-3">
                  <label for="password-confirm">{{ __('Confirm Password') }}<span class="required-asterisk">*</span></label>
                  <div>
                      <input id="password-confirm" type="password" placeholder="Confirm Password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                  </div>
              </div>
            </div>

            <div class="row mb-0">
                <div class="d-flex justify-content-end mt-3">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Register') }}
                    </button>
                </div>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>


