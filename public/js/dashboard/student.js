const BLANK = '';


/*---------------------------------

-----------------------------------*/
$('#addStudentModalCall').on('click', function () {

    $('#studentModalBtn').html(BLANK);
    $('#studentModalBtn').append(btnModalElement('addStudentBtn', 'Add Student'));
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
        $('#studentSectionDiv').show();
        loadSectionRecord('#studentSection', $('#coursePicker-student').val(), $('#studentYearlevel').val())
    } else {
        $('#studentSectionDiv').hide();
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
                // initTrashSections(section.id)
                // editSectionRecord(section.id)
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