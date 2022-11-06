
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