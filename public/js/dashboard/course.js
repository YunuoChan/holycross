const BLANK = '';


$('#adminAddCourseModalCall').on('click', function () {

    $('#courseModalBtn').html(BLANK);
    $('#courseModalBtn').append(btnModalElement('addCourseBtn', 'Add Course'));
    initAddCourse();
    $('#addCourseRecord').modal('toggle');
});



function initAddCourse() {
    $('#addCourseBtn').on('click', function () {
        $('#addCourseRecord').modal('hide');
        // WEB SERVICE CALL 
        $.ajax({
            url:        '/admin/course/save',
            type:       'POST',
            dataType:   'json',
            headers:    {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data:   {
                name              : $('#courseName').val(),
                courseCode        : $('#courseCode').val(),
            }
        }).then(function(data) {
            console.log('STUDENT ADDED');

            if (data.status == 66) {
                customToaster('<b>Failed to Add!</b>', data.message, 'warning')
                resetCourseModal();
                return false;
            }

            loadCoursesData();
            resetCourseModal();

        }).fail(function(error) {
            console.log('Backend Error', error);
            internalServerError()
        });
    });
}



function resetCourseModal() {
    $('#courseName').val(BLANK);
    $('#courseCode').val(BLANK);
    $('#addCourseRecord').modal('hide');
}

$('#searchBtn-course').on('click', function () {
    loadCoursesData();
});

$('#searchField-course').on('blur keyup', function () {
    loadCoursesData();
});


/*---------------------------------

-----------------------------------*/
function loadCoursesData() {

    var keyword = $('#searchField-course').val();
    // WEB SERVICE CALL 
    $.ajax({
        url:        '/admin/manage/course/show',
        type:       'GET',
        dataType:   'json',
        headers:    {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data:   {
            keyword : keyword.trim()
        }
    }).then(function(data) {
        console.log('fetchCourses: ', data);
        $('#courseTable').html(BLANK);
        if (data.courses.length > 0) {
            data.courses.forEach(function(course) {
                $('#courseTable').append(tableElement(course));
                editCourseRecord(course.id)
                initTrashCourse(course.id)
            })
        } else {
            $('#courseTable').append(showNoDataTableAvalable());
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
        elm += '     <td class="vertical-center">'+ data.course_code +'</td> ';
        elm += '     <td class="vertical-center">'+ data.course_name +'</th> ';
        elm += '     <td class="vertical-center">'+ data.status +'</td> ';
        elm += '     <td class="vertical-center"> ';
        elm += '        <div class="d-flex justify-content-start">'
        if (data.status == 'ACT') {
            elm += '         <button type="button" class="btn btn-success mx-1" id="editCourse-'+ data.id +'"><i class="fas fa-edit"></i>Edit</button> ';
            elm += '         <button type="button" class="btn btn-danger" id="trashCourse-'+ data.id +'"><i class="fas fa-trash"></i></i>Delete</button> ';
        }
        elm += '        </div>'
        elm += '     </td> ';
        elm += ' </tr> ';
    return elm;
}



/*---------------------------------

-----------------------------------*/
function editCourseRecord(id) {
    $('#editCourse-' + id).on('click', function() {
        // WEB SERVICE CALL 
        $.ajax({
            url:        '/admin/course/edit',
            type:       'GET',
            dataType:   'json',
            headers:    {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data:   {
                id : id
            }
        }).then(function(data) {
            console.log('fetchStudent: ', data);
            resetCourseModal();
            $('#courseName').val(data.course.course_name);
            $('#courseCode').val(data.course.course_code);
           
            $('#courseModalBtn').html(BLANK);
            $('#courseModalBtn').append(btnModalElement('updateCourseBtn-'+ id, 'Update Course Info'));
            initUpdateCourse(id);
            $('#addCourseRecord').modal('toggle');

        }).fail(function(error) {
            console.log('Backend Error', error);
            internalServerError();
        });
    }); 
}




/*---------------------------------

-----------------------------------*/
function initUpdateCourse(id) {
    $('#updateCourseBtn-'+ id).on('click', function() {
        $('#addCourseRecord').modal('hide');
        bootbox.confirm({
            title: "Update Course Info?",
            message: "Are you sure you want to update this record?",
            buttons: {
                cancel: {
                    label: '<i class="fas fa-times"></i> Cancel'
                },
                confirm: {
                    label: '<i class="fas fa-check"></i> Yes, Please!'
                }
            },
            callback: function (result) {
                if (result) {
                    updateCourse(id)
                }
            }
        });
    });
}

/*---------------------------------

-----------------------------------*/
function updateCourse(id) {
    // WEB SERVICE CALL 
    $.ajax({
        url:        '/admin/course/update',
        type:       'POST',
        dataType:   'json',
        headers:    {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data:   {
            id                : id,
            name              : $('#courseName').val(),
            courseCode        : $('#courseCode').val(),
        }
    }).then(function(data) {
        console.log('fetchsection: ', data);

        if (data.status == 66) {
            customToaster('<b>Failed to Update!</b>', data.message, 'warning')
            resetCourseModal();
            return false;
        }
      
        loadCoursesData();
        resetCourseModal();

        // TOASTER
        successUpdate();
    }).fail(function(error) {
        console.log('Backend Error', error);
        internalServerError();
    });
}





/*---------------------------------
    TRASH SECTION
-----------------------------------*/
function initTrashCourse(id) {
    $('#trashCourse-'+ id).on('click', function() {
        bootbox.confirm({
            title: "Delete Course?",
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
                    trashCourse(id)
                }
            }
        });
    });
}

/*---------------------------------

-----------------------------------*/
function trashCourse(id) {
    $.ajax({
        url:        '/admin/course/trash',
        type:       'POST',
        dataType:   'json',
        headers:    {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data:   {
            id : id
        }
    }).then(function(data) {
        loadCoursesData();
        resetCourseModal();

        // TOASTER
        successDelete();
    }).fail(function(error) {
        console.log('Backend Error', error);
        internalServerError();
    });
}

