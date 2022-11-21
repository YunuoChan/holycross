const BLANK = '';


/*---------------------------------

-----------------------------------*/
$('#addStudentModalCall').on('click', function () {

    $('#studentModalBtn').html(BLANK);
    $('#studentModalBtn').append(btnModalElement('addStudentBtn', 'Add Student'));
    resetStudentModal();
    studentCoursePickOnChange();
    initAddStudent();
   
    $('#addStudentRecord').modal('toggle');
    
})



/*---------------------------------

-----------------------------------*/
function initAddStudent() {
    $('#addStudentBtn').on('click', function () {
        // WEB SERVICE CALL 
        $.ajax({
            url:        '/admin/student/save',
            type:       'POST',
            dataType:   'json',
            headers:    {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data:   {
                name              : $('#studentName').val(),
                studentId         : $('#studentIdNo').val(),
                course            : $('#coursePicker-student').val(),
                section           : $('#studentSection').val(),
                yearlevel         : $('#studentYearlevel').val(),
                fromAdmin         : 1, // IF ADDED ON ADMIN SIDE
            }
        }).then(function(data) {
            console.log('STUDENT ADDED');
            successSave();
            $('#addStudentRecord').modal('hide');
            resetStudentModal();
            loadStudentRecord();

        }).fail(function(error) {
            console.log('Backend Error', error);
            internalServerError()
        });
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
        if (data.courses.length > 0) {
            $(id).html(BLANK);
            $(id).append('<option value="All">All Courses</option>');
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
function loadSectionRecord(id, course, yrlvl) {
    // WEB SERVICE CALL 
    $.ajax({
        url:        '/admin/section/show/specific',
        type:       'GET',
        dataType:   'json',
        headers:    {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data:   {
            courseId : course,
            yearLevel: yrlvl
        }
    }).then(function(data) {
        console.log('fetchSection: ', data);
        $(id).html(BLANK);
        if (data.sections.length > 0) {
            data.sections.forEach(function(section) {
                $(id).append('<option value="'+ section.id +'">'+ section.section_code.trim() +'</option>');
            })
            $('#addStudentBtn').prop('disabled', false);
        } else {
            $(id).append('<option value="0">No section found in redord</option>');
            $('#addStudentBtn').prop('disabled', true);
        }
    }).fail(function(error) {
        console.log('Backend Error', error);
        internalServerError();
    });
}


$('#coursePicker-student').on('change', function () {
    studentCoursePickOnChange();
});

$('#studentYearlevel').on('change', function () {
    studentCoursePickOnChange();
});



function studentCoursePickOnChange() {
    if ($.isNumeric($('#coursePicker-student').val())) {
        loadSectionRecord('#studentSection', $('#coursePicker-student').val(), $('#studentYearlevel').val())
    } else {
        $('#studentSection').html(BLANK);
        $('#studentSection').append('<option value="0">No course found in redord</option>');
        $('#addStudentBtn').prop('disabled', true);
    }
}


/*---------------------------------

-----------------------------------*/
function loadStudentRecord() {
    // WEB SERVICE CALL 
    $.ajax({
        url:        '/admin/student/show',
        type:       'GET',
        dataType:   'json',
        headers:    {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        // data:   {
        
        // }
    }).then(function(data) {
        console.log('fetchStudentTable: ', data);
        $('#studentTable').html(BLANK);
        if (data.students.length > 0) {
            data.students.forEach(function(student) {
                $('#studentTable').append(tableElement(student));
                initTrashStudents(student.id)
                editStudentRecord(student.id) 
            });
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
        elm += '     <td class="vertical-center">'+ data.student_id_no +'</th> ';
        elm += '     <td class="vertical-center">'+ data.name +'</td> ';
        elm += '     <td class="vertical-center">'+ data.course.course_code +'</td> ';
        elm += '     <td class="vertical-center">'+ data.section.section_code +'</td> ';
        if (data.year_level == 1) {
            elm += '     <td class="vertical-center">First Year</td> ';
        } else  if (data.year_level == 2) {
            elm += '     <td class="vertical-center">Second Year</td> ';
        } else  if (data.year_level == 3) {
            elm += '     <td class="vertical-center">Third Year</td> ';
        } else  if (data.year_level == 4) {
            elm += '     <td class="vertical-center">Fourth Year</td> ';
        } else {
            elm += '     <td class="vertical-center">First Year</td> ';
        }
        elm += '     <td class="vertical-center">'+ data.status +'</td> ';
        elm += '     <td class="vertical-center"> ';
        elm += '        <div class="d-flex justify-content-center">'
        if (data.status == 'ACT') {
            elm += '         <button type="button" class="btn btn-success mx-1" id="editStudent-'+ data.id +'"><i class="fas fa-edit"></i>Edit</button> ';
            elm += '         <button type="button" class="btn btn-danger" id="trashStudent-'+ data.id +'"><i class="fas fa-trash"></i></i>Trash</button> ';
        }
        elm += '        </div>'
        elm += '     </td> ';
        elm += ' </tr> ';
    return elm;
}


/*---------------------------------
    TRASH SECTION
-----------------------------------*/
function initTrashStudents(id) {
    $('#trashStudent-'+ id).on('click', function() {
        bootbox.confirm({
            title: "Trash Student Record?",
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
                    trashStudent(id)
                }
            }
        });
    });
}

function trashStudent(id) {
    $.ajax({
        url:        '/admin/student/trash',
        type:       'POST',
        dataType:   'json',
        headers:    {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data:   {
            id : id
        }
    }).then(function(data) {
        loadStudentRecord();

        // TOASTER
        successDelete();
    }).fail(function(error) {
        console.log('Backend Error', error);
        internalServerError();
    });
}


function resetStudentModal() {
    $('#studentIdNo').val(BLANK);
    $('#studentName').val(BLANK);
    $('#coursePicker-student').val('All');
    $('#studentYearlevel').val(1).trigger('change');
    $('#studentSection').html(BLANK);
    $('#studentSection').append('<option value="0">No course found in redord</option>');
}

/*---------------------------------

-----------------------------------*/
function editStudentRecord(id) {
    $('#editStudent-' + id).on('click', function() {
        // WEB SERVICE CALL 
        $.ajax({
            url:        '/admin/student/edit',
            type:       'GET',
            dataType:   'json',
            headers:    {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data:   {
                id : id
            }
        }).then(function(data) {
            console.log('fetchStudent: ', data);
            resetStudentModal();
            // APPEND DATA 
            $('#studentIdNo').val(data.student.student_id_no);
            $('#studentName').val(data.student.name);
            $('#coursePicker-student').val(data.student.course.id);
            $('#studentYearlevel').val(data.student.year_level).trigger('change');
            setTimeout(function () {
                $('#studentSection').val(data.student.section.id).trigger('change');
            }, 1000);


            $('#studentModalBtn').html(BLANK);
            $('#studentModalBtn').append(btnModalElement('updateStudentBtn-'+ id, 'Update Student Info'));
            initUpdateStudent(id);
            $('#addStudentRecord').modal('toggle');

        }).fail(function(error) {
            console.log('Backend Error', error);
            internalServerError();
        });
    }); 
}



function initUpdateStudent(id) {
    $('#updateStudentBtn-'+ id).on('click', function() {
        $('#addStudentRecord').modal('hide');
        bootbox.confirm({
            title: "Update Section Info?",
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
                    updateStudent(id)
                }
            }
        });
    });
}


function updateStudent(id) {
    // WEB SERVICE CALL 
    $.ajax({
        url:        '/admin/student/update',
        type:       'POST',
        dataType:   'json',
        headers:    {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data:   {
            id                : id,
            name              : $('#studentName').val(),
            studentId         : $('#studentIdNo').val(),
            course            : $('#coursePicker-student').val(),
            section           : $('#studentSection').val(),
            yearlevel         : $('#studentYearlevel').val(),
            fromAdmin         : 1, // IF ADDED ON ADMIN SIDE
        }
    }).then(function(data) {
        console.log('fetchsection: ', data);

        $('#addStudentRecord').modal('hide');
        resetStudentModal()
       loadStudentRecord()

        // TOASTER
        successUpdate();
    }).fail(function(error) {
        console.log('Backend Error', error);
        internalServerError();
    });
}