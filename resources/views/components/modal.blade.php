
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
          <div class="form-group">
            <label for="recipient-name" class="col-form-label pt-0">School Year</label>
            <div class="d-flex justify-content-between ml-3">
              <div class="d-flex justify-content-start w-50 mr-2">
                <div class="d-flex justify-content-center flex-column">
                  <label for="sySelectFromPicker" class="m-0 pr-2">From</label>
                </div>
                <select class="form-control" id="sySelectFromPicker"></select>
              </div>
              <div class="d-flex justify-content-start w-50 ml-2">
                <div class="d-flex justify-content-center flex-column">
                  <label for="sySelectToPicker" class="m-0 pr-2">To</label>
                </div>
                <select class="form-control" id="sySelectToPicker"></select>
              </div>
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
          <div class="d-flex justify-content-start">
            <div class="form-group w-25 mr-3">
              <label for="subjectCode">Subject Code</label>
              <input type="text" class="form-control" id="subjectCode" placeholder="Code" maxlength="10">
            </div>
            <div class="form-group w-75">
              <label for="subjectName">Subject</label>
              <input type="text" class="form-control" id="subjectName" placeholder="Subject Name" maxlength="35">
            </div>
          </div>
          <div class="form-group">
            <label for="coursePicker-subject">Select Course</label>
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
              <label for="subjectYearlevel">Year Level</label>
              <select class="form-control" id="subjectYearlevel">
                <option value="1">First year</option>
                <option value="2">Second year</option>
                <option value="3">Third year</option>
                <option value="4">Fouth year</option>
              </select>
            </div>
          </div>

          <div class="form-group w-50">
            <label for="subjectTime">Time to Consume</label>
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
          {{-- <label for="subjectAvailability">Schedule Availability</label>
          <div class="p-3 card">
            <div class="d-flex justify-content-start">
              <div class="form-group w-50 mr-3">
                <label for="subjectAvailability">Day/s Need to Take per Week</label>
                <select class="form-control" id="subjectAvailability">
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                  <option value="6">6</option>
                  <option value="7">7</option>
                </select>
              </div>
             
            </div>
          </div> --}}
          
        </form>
      </div>
      <div class="modal-footer" id="subjectModalBtn">
        <button type="button" class="btn btn-primary w-25" id="saveNewSubject">Add Subject</button>
      </div>
    </div>
  </div>
</div>


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
          <div class="d-flex justify-content-start">
            <div class="form-group w-50 mr-3 mb-0">
              <label for="sectionCode">Section Code</label>
              <input type="text" class="form-control" id="sectionCode" placeholder="Code" maxlength="10">
            </div>
            <div class="form-group w-50">
              <label for="coursePicker-section">Select Course</label>
              <select class="form-control" id="coursePicker-section">
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="sectionYearlevel">Year Level</label>
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
          <div class="d-flex justify-content-start">
            <div class="form-group mr-3 w-100">
                <label for="coursePicker-generate-sched">Select Course</label>
                <select class="form-control" id="coursePicker-generate-sched">
                </select>
            </div>
          </div>
          <div class="form-group">
            <label for="generateSchedYearlevel">Year Level</label>
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