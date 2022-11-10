
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
            <label for="subjectDescription">Description</label>
            <textarea class="form-control" id="subjectDescription" rows="3" placeholder="Description" maxlength="254"></textarea>
          </div>
          <div class="d-flex justify-content-start">
            <div class="form-group w-25 mr-3">
              <label for="subjectUnit">Unit</label>
              <input type="number" class="form-control" id="subjectUnit" placeholder="Unit" min=".5">
            </div>
            <div class="form-group w-75">
              <label for="subjectTime">Time to Consume</label>
              {{-- <input type="text" class="form-control hasDatepicker" id="subjectTime" placeholder="Subject Time to Consume" maxlength="35"> --}}
              <select class="form-control" id="subjectTime">
                <option selected disabled>Time to Consume</option>
                <option value="00:15:00">15mins</option>
                <option value="00:30:00">30mins</option>
                <option value="00:45:00">45mins</option>
                <option value="01:00:00">1h</option>
                <option value="02:00:00">2h</option>
                <option value="03:00:00">3h</option>
                <option value="04:00:00">4h</option>
                <option value="05:00:00">5h</option>
                <option value="24:00:00">1d</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="subjectYearlevel">Year Level</label>
            <select class="form-control" id="subjectYearlevel">
              <option value="1">First year</option>
              <option value="2">Second year</option>
              <option value="3">Third year</option>
              <option value="4">Fouth year</option>
            </select>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary w-25" id="saveNewSubject">Add Subject</button>
      </div>
    </div>
  </div>
</div>