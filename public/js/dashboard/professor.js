const BLANK = '';

$('#addProfessorModalCall').on('click', function () {

    $('#professorModalBtn').html(BLANK);
    $('#professorModalBtn').append(btnModalElement('addProfessorBtn', 'Add Professor'));
    initAddProfessor();
    $('#addProfessorRecord').modal('toggle');
    
});

$('#importCSVProfessorModalCall').on('click', function () {
    $('#professorImportModal').modal('toggle');
})


/*---------------------------------

-----------------------------------*/
function loadCourses(id, isAllExist) {
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
        if (data.courses.length > 0) {
            $(id).html(BLANK);
            if (isAllExist == 1) {
                $(id).append('<option value="All">All Department</option>');
            }
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
function initAddProfessor() {
    $('#addProfessorBtn').on('click', function () {
        // WEB SERVICE CALL 
        $.ajax({
            url:        '/admin/professor/save',
            type:       'POST',
            dataType:   'json',
            headers:    {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data:   {
                name              : $('#professorName').val(),
                profId            : $('#professorIdNo').val(),
                course            : $('#coursePicker-professor').val(),
            }
        }).then(function(data) {
            console.log('STUDENT ADDED');

            if (data.status == 66) {
                customToaster('<b>Failed to Add!</b>', data.message, 'warning')
                resetProfessorModal();
                return false;
            }
            successSave();
            $('#addProfessorRecord').modal('hide');
            resetProfessorModal();
            loadProfessorRecord();

        }).fail(function(error) {
            console.log('Backend Error', error);
            internalServerError()
        });
    });
}


/*---------------------------------

-----------------------------------*/
function resetProfessorModal() {
    $('#professorName').val(BLANK);
    $('#professorIdNo').val(BLANK)
}


$('#coursePickerFilter-professor').on('change', function () {
    loadProfessorRecord();
});

$('#searchBtn-professor').on('click', function () {
    loadProfessorRecord();
});

$('#searchField-professor').on('blur keyup', function () {
    loadProfessorRecord();
});
/*---------------------------------

-----------------------------------*/
function loadProfessorRecord() {
    var keyword = $('#searchField-professor').val();
    // WEB SERVICE CALL 
    $.ajax({
        url:        '/admin/professor/show',
        type:       'GET',
        dataType:   'json',
        headers:    {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data:   {
            courseFilter : $('#coursePickerFilter-professor').val(),
            keyword : keyword.trim()
        }
    }).then(function(data) {
        console.log('fetchProfTable: ', data);
        $('#professorTable').html(BLANK);
        if (data.professors.length > 0) {
            data.professors.forEach(function(prof) {
                $('#professorTable').append(tableElement(prof));
                initTrashProfessor(prof.id)
                editProfessorRecord(prof.id) 
            });
        } else {
            $('#professorTable').append(showNoDataTableAvalable());
        }
    }).fail(function(error) {
        console.log('Backend Error', error);
        internalServerError();
    });
}


/*---------------------------------

-----------------------------------*/
function tableElement(data) {
    var elm = BLANK;
        elm += ' <tr> ';
        elm += '     <td class="vertical-center">'+ data.course.course_code +'</td> ';
        elm += '     <td class="vertical-center">'+ data.professor_id_no +'</th> ';
        elm += '     <td class="vertical-center">'+ data.name +'</td> ';
        // elm += '     <td class="vertical-center">'+ data.status +'</td> ';
        elm += '     <td class="vertical-center"> ';
        elm += '        <div class="d-flex justify-content-start">'
        if (data.status == 'ACT') {
            elm += '         <button type="button" class="btn btn-success mx-1" id="editProfessor-'+ data.id +'"><i class="fas fa-edit"></i>Edit</button> ';
            elm += '         <button type="button" class="btn btn-danger" id="trashProfessor-'+ data.id +'"><i class="fas fa-trash"></i></i>Delete</button> ';
        }
        elm += '        </div>'
        elm += '     </td> ';
        elm += ' </tr> ';
    return elm;
}




/*---------------------------------
    TRASH SECTION
-----------------------------------*/
function initTrashProfessor(id) {
    $('#trashProfessor-'+ id).on('click', function() {
        bootbox.confirm({
            title: "Delete Professor Record?",
            message: "Are you sure you want to delete this record?",
            buttons: {
                cancel: {
                    label: '<i class="fas fa-times"></i> Cancel'
                },
                confirm: {
                    label: '<i class="fas fa-check"></i>Yes, Please!'
                }
            },
            callback: function (result) {
                if (result) {
                    trashProfessor(id)
                }
            }
        });
    });
}

/*---------------------------------

-----------------------------------*/
function trashProfessor(id) {
    $.ajax({
        url:        '/admin/professor/trash',
        type:       'POST',
        dataType:   'json',
        headers:    {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data:   {
            id : id
        }
    }).then(function(data) {
        loadProfessorRecord();

        // TOASTER
        successDelete();
    }).fail(function(error) {
        console.log('Backend Error', error);
        internalServerError();
    });
}



/*---------------------------------

-----------------------------------*/
function editProfessorRecord(id) {
    $('#editProfessor-' + id).on('click', function() {
        // WEB SERVICE CALL 
        $.ajax({
            url:        '/admin/professor/edit',
            type:       'GET',
            dataType:   'json',
            headers:    {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data:   {
                id : id
            }
        }).then(function(data) {
            console.log('fetchStudent: ', data);
            resetProfessorModal();
            $('#professorName').val(data.professor.name);
            $('#professorIdNo').val(data.professor.professor_id_no);
            $('#coursePicker-professor').val(data.professor.course.id).trigger('change');
           
            $('#professorModalBtn').html(BLANK);
            $('#professorModalBtn').append(btnModalElement('updateProfessorBtn-'+ id, 'Update Professor Info'));
            initUpdateProfessor(id);
            $('#addProfessorRecord').modal('toggle');

        }).fail(function(error) {
            console.log('Backend Error', error);
            internalServerError();
        });
    }); 
}


/*---------------------------------

-----------------------------------*/
function initUpdateProfessor(id) {
    $('#updateProfessorBtn-'+ id).on('click', function() {
        $('#addProfessorRecord').modal('hide');
        bootbox.confirm({
            title: "Update Professor Info?",
            message: "Are you sure you want to update this record?",
            buttons: {
                cancel: {
                    label: '<i class="fas fa-times"></i> Cancel'
                },
                confirm: {
                    label: '<i class="fas fa-pencil-alt"></i> Yes, Please!'
                }
            },
            callback: function (result) {
                if (result) {
                    updateStudent(id)
                }
            }
        });
    });
}

/*---------------------------------

-----------------------------------*/
function updateStudent(id) {
    // WEB SERVICE CALL 
    $.ajax({
        url:        '/admin/professor/update',
        type:       'POST',
        dataType:   'json',
        headers:    {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data:   {
            id                : id,
            name              : $('#professorName').val(),
            profId            : $('#professorIdNo').val(),
            course            : $('#coursePicker-professor').val(),
        }
    }).then(function(data) {
        console.log('fetchsection: ', data);

        if (data.status == 66) {
            customToaster('<b>Failed to Update!</b>', data.message, 'warning')
            resetProfessorModal();
            return false;
        }

        $('#addProfessorRecord').modal('hide');
        resetProfessorModal();
        loadProfessorRecord();

        // TOASTER
        successUpdate();
    }).fail(function(error) {
        console.log('Backend Error', error);
        internalServerError();
    });
}