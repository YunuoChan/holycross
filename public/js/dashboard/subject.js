const BLANK = '';



/*---------------------------------

-----------------------------------*/
function loadSubjectRecord() {
    // WEB SERVICE CALL 
    $.ajax({
        url:        '/admin/subject/show',
        type:       'GET',
        dataType:   'json',
        headers:    {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    }).then(function(data) {
        console.log('fetchSubject: ', data);
        $('#subjectTable').html(BLANK);
        if (data.subjects.length > 0) {
            data.subjects.forEach(function(subject) {
                $('#subjectTable').append(tableElement(subject));
                initTrashSubject(subject.id);
                editSubjectRecord(subject.id);
            });
        }
    }).fail(function(error) {
        console.log('Backend Error', error);
       internalServerError()
    });
}





/*---------------------------------

-----------------------------------*/
function loadCourses(id) {
    // WEB SERVICE CALL 
    $.ajax({
        url:        '/admin/course/get',
        type:       'GET',
        dataType:   'json',
        headers:    {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        // data:   {
        
        // }
    }).then(function(data) {
        console.log('fetchCourse: ', data);
        $(id).html(BLANK);
        if (data.courses.length > 0) {
            data.courses.forEach(function(course) {
                $(id).append('<option value="'+ course.id +'">'+ course.course_code +'</option>');
            })
        } else {
            $(id).append('<option value="0">No course found in redord</option>');
        }
    }).fail(function(error) {
        console.log('Backend Error', error);
        internalServerError();
    });
}







/*---------------------------------

-----------------------------------*/
function tableElement(subject) {
    var elm = BLANK;
        elm += ' <tr> ';
        elm += '     <td class="vertical-center">'+ subject.course.course_code +'</td> ';
        elm += '     <td class="vertical-center">'+ subject.subject_code +'</td> ';
        elm += '     <td class="vertical-center">'+ subject.subject +'</th> ';
        elm += '     <td class="vertical-center">'+ subject.unit +'</td> ';
        elm += '     <td class="vertical-center">'+ subject.time_to_consume +'</td> ';
        if (subject.year_level == 1) {
            elm += '     <td class="vertical-center">First Year</td> ';
        } else  if (subject.year_level == 2) {
            elm += '     <td class="vertical-center">Second Year</td> ';
        } else  if (subject.year_level == 3) {
            elm += '     <td class="vertical-center">Third Year</td> ';
        } else  if (subject.year_level == 4) {
            elm += '     <td class="vertical-center">Fourth Year</td> ';
        } else {
            elm += '     <td class="vertical-center">First Year</td> ';
        }
       
        elm += '     <td class="vertical-center">'+ subject.status +'</td> ';
        elm += '     <td class="vertical-center"> ';
        elm += '        <div class="d-flex justify-content-center">'
        // elm += '         <button type="button" class="btn btn-primary" id="viewSubject-'+ subject.id +'"><i class="fas fa-eye"></i>View</button> ';
        if (subject.status == 'ACT') {
            elm += '         <button type="button" class="btn btn-success mx-1" id="editSubject-'+ subject.id +'"><i class="fas fa-edit"></i>Edit</button> ';
            elm += '         <button type="button" class="btn btn-danger" id="trashSubject-'+ subject.id +'"><i class="fas fa-trash"></i></i>Trash</button> ';
        }
        elm += '        </div>'
        elm += '     </td> ';
        elm += ' </tr> ';
    return elm;
}



/*---------------------------------

-----------------------------------*/
$('#addSubjModalCall').on('click', function () {
    resetSubjectModal();
    // $('#subjectTime').val('00:15:00').trigger('change');
    // $('#subjectYearlevel').val(1).trigger('change');
    $('#subjectModalBtn').html(BLANK);
    $('#subjectModalBtn').append(btnModalElement('saveNewSubject', 'Add New Subject'));
    initAddSubject() 
    
    $('#addSubjectRecord').modal('toggle');
})


/*---------------------------------

-----------------------------------*/
function initAddSubject() {
    $('#saveNewSubject').on('click', function () {
        // WEB SERVICE CALL 
        $.ajax({
            url:        '/admin/subject/save',
            type:       'POST',
            dataType:   'json',
            headers:    {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data:   {
                subject             : $('#subjectName').val(),
                subjectCode         : $('#subjectCode').val(),
                subjectUnit         : $('#subjectUnit').val(),
                subjectTime         : $('#subjectTime').val(),
                subjectYearlevel    : $('#subjectYearlevel').val(),
                // subjectAvailability : $('#subjectAvailability').val(),
                course              : $('#coursePicker-subject').val()
            }
        }).then(function(data) {
            resetSubjectModal();
            loadSubjectRecord();
            $('#addSubjectRecord').modal('hide');

            // TOASTER
            successSave();
        }).fail(function(error) {
            console.log('Backend Error', error);
            internalServerError();
        });
    });
}



/*---------------------------------

-----------------------------------*/
function resetSubjectModal() {
    $('#subjectName').val(BLANK);
    $('#subjectCode').val(BLANK);
    $('#subjectDescription').val(BLANK);
    $('#subjectUnit').val(BLANK);
    $('#subjectTime').val('00:15:00').trigger('change');
    $('#subjectYearlevel').val(1).trigger('change');
    // $('#subjectAvailability').val(1).trigger('change');
    
}

/*---------------------------------

-----------------------------------*/
function initTrashSubject(id) {
    $('#trashSubject-'+ id).on('click', function() {
        bootbox.confirm({
            title: "Delete Subject?",
            message: "Are you sure you want to delete this record?",
            buttons: {
                cancel: {
                    label: '<i class="fas fa-times"></i> Cancel'
                },
                confirm: {
                    label: '<i class="fas fa-trash"></i> Yes, Please!'
                }
            },
            callback: function (result) {
                if (result) {
                    trashSubject(id)
                }
            }
        });
    });
}

function trashSubject(id) {
    $.ajax({
        url:        '/admin/subject/trash',
        type:       'POST',
        dataType:   'json',
        headers:    {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data:   {
            id : id
        }
    }).then(function(data) {
        resetSubjectModal();
        loadSubjectRecord();
        
        // TOASTER
        successDelete();
    }).fail(function(error) {
        console.log('Backend Error', error);
        internalServerError();
    });
}



/*---------------------------------

-----------------------------------*/
function editSubjectRecord(id) {
    $('#editSubject-' + id).on('click', function() {
        // WEB SERVICE CALL 
        $.ajax({
            url:        '/admin/subject/edit',
            type:       'GET',
            dataType:   'json',
            headers:    {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data:   {
                id : id
            }
        }).then(function(data) {
            console.log('fetchSubject: ', data);
            $('#subjectName').val(data.subject.subject);
            $('#subjectCode').val(data.subject.subject_code);
            $('#subjectUnit').val(data.subject.unit);
            $('#subjectTime').val(data.subject.time_to_consume).trigger('change');
            $('#subjectYearlevel').val(data.subject.year_level).trigger('change');
            // $('#subjectAvailability').val(data.subject.availability_per_week).trigger('change');
            $('#coursePicker-subject').val(data.subject.course.id).trigger('change');
            $('#subjectModalBtn').html(BLANK);
            $('#subjectModalBtn').append(btnModalElement('updateSubjectBtn-'+ id, 'Update Subject Info'));
            initUpdateSubject(id);
            $('#addSubjectRecord').modal('toggle');

        }).fail(function(error) {
            console.log('Backend Error', error);
           internalServerError();
        });
    }); 
}

function initUpdateSubject(id) {
    $('#updateSubjectBtn-'+ id).on('click', function() {
        $('#addSubjectRecord').modal('hide');
        bootbox.confirm({
            title: "Update Subject Info?",
            message: "Are you sure you want to update this record?",
            buttons: {
                cancel: {
                    label: '<i class="fas fa-times"></i> Cancel'
                },
                confirm: {
                    label: '<i class="fas fa-trash"></i> Yes, Please!'
                }
            },
            callback: function (result) {
                if (result) {
                    updateSubject(id)
                }
            }
        });
    });
}


function updateSubject(id) {
    // WEB SERVICE CALL 
    $.ajax({
        url:        '/admin/subject/update',
        type:       'POST',
        dataType:   'json',
        headers:    {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data:   {
            id                  : id,
            subject             : $('#subjectName').val(),
            subjectCode         : $('#subjectCode').val(),
            subjectUnit         : $('#subjectUnit').val(),
            subjectTime         : $('#subjectTime').val(),
            subjectYearlevel    : $('#subjectYearlevel').val(),
            course              : $('#coursePicker-subject').val()
        }
    }).then(function(data) {
        console.log('fetchsubject: ', data);

        $('#addSubjectRecord').modal('hide');
        resetSubjectModal();
        loadSubjectRecord();

        // TOASTER
        successUpdate();
    }).fail(function(error) {
        console.log('Backend Error', error);
        internalServerError();
    });

}