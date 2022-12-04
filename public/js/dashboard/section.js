const BLANK = '';


$('#coursePickerFilter-section').on('change', function () {
    loadSectionRecord() 
});


$('#yearLevelFilter-section').on('change', function () {
    loadSectionRecord() 
});

$('#searchBtn-section').on('click', function () {
   loadSectionRecord();
});

$('#searchField-section').on('blur', function () {
   loadSectionRecord();
});



/*---------------------------------

-----------------------------------*/
function loadSectionRecord() {

    var keyword = $('#searchField-section').val();
    // WEB SERVICE CALL 
    $.ajax({
        url:        '/admin/section/show',
        type:       'GET',
        dataType:   'json',
        headers:    {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data:   {
            courseFilter    : $('#coursePickerFilter-section').val(),
            yearLevelFilter : $('#yearLevelFilter-section').val(),
            keyword         : keyword.trim()
        }
    }).then(function(data) {
        console.log('fetchSection: ', data);
        $('#sectionTable').html(BLANK);
        if (data.sections.length > 0) {
            data.sections.forEach(function(section) {
                $('#sectionTable').append(tableElement(section));
                initTrashSections(section.id)
                editSectionRecord(section.id)
            });
        } else {
            $('#sectionTable').append(showNoDataTableAvalable());
        }
    }).fail(function(error) {
        console.log('Backend Error', error);
        internalServerError();
    });
}



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
        $(id).html(BLANK);
        if (data.courses.length > 0) {
            if (isAllExist == 1) {
                $(id).append('<option value="All">All Course</option>');
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
function tableElement(data) {
    var elm = BLANK;
        elm += ' <tr> ';
        elm += '     <td class="vertical-center">'+ data.course.course_code +'</th> ';
        elm += '     <td class="vertical-center">'+ data.section_code +'</td> ';
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
        elm += '        <div class="d-flex">'
        // elm += '         <button type="button" class="btn btn-primary" id="viewSubject-'+ data.id +'"><i class="fas fa-eye"></i>View</button> ';
        if (data.status == 'ACT') {
            elm += '         <button type="button" class="btn btn-success mx-1" id="editSection-'+ data.id +'"><i class="fas fa-edit"></i>Edit</button> ';
            elm += '         <button type="button" class="btn btn-danger" id="trashSection-'+ data.id +'"><i class="fas fa-trash"></i></i>Delete</button> ';
        }
        elm += '        </div>'
        elm += '     </td> ';
        elm += ' </tr> ';
    return elm;
}


/*---------------------------------
    CALL MODAL
-----------------------------------*/
$('#addSectModalCall').on('click', function () {
    $('#sectionModalBtn').html(BLANK);
    $('#sectionModalBtn').append(btnModalElement('addNewSectionBtn', 'Add Section'));
    resetSectionModal()
    initAdd();
    $('#addSectionRecord').modal('toggle');
    
})


/*---------------------------------

-----------------------------------*/
function initAdd() {
    $('#addNewSectionBtn').on('click', function () {
        // WEB SERVICE CALL 
        $.ajax({
            url:        '/admin/section/save',
            type:       'POST',
            dataType:   'json',
            headers:    {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data:   {
                course              : $('#coursePicker-section').val(),
                sectionCode         : $('#sectionCode').val(),
                sectionYearlevel    : $('#sectionYearlevel').val()
            }
        }).then(function(data) {
            resetSectionModal();
            loadSectionRecord();
            $('#addSectionRecord').modal('hide');
            $.toast({
                heading: 'Success!',
                text: 'Record successfully saved!',
                showHideTransition: 'slide',
                icon: 'success'
            })
        }).fail(function(error) {
            console.log('Backend Error', error);
            internalServerError()
        });
    });
}

/*---------------------------------

-----------------------------------*/
function resetSectionModal() {
    // $('#sectionName').val(BLANK);
    $('#sectionCode').val(BLANK);
    $('#sectionYearlevel').val(1).trigger('change');
}


/*---------------------------------
    TRASH SECTION
-----------------------------------*/
function initTrashSections(id) {
    $('#trashSection-'+ id).on('click', function() {
        bootbox.confirm({
            title: "Delete Section?",
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
                    trashSection(id)
                }
            }
        });
    });
}

function trashSection(id) {
    $.ajax({
        url:        '/admin/section/trash',
        type:       'POST',
        dataType:   'json',
        headers:    {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data:   {
            id : id
        }
    }).then(function(data) {
        resetSectionModal();
        loadSectionRecord();

        // TOASTER
        successDelete();
    }).fail(function(error) {
        console.log('Backend Error', error);
        internalServerError();
    });
}

/*---------------------------------

-----------------------------------*/
function editSectionRecord(id) {
    $('#editSection-' + id).on('click', function() {
        // WEB SERVICE CALL 
        $.ajax({
            url:        '/admin/section/edit',
            type:       'GET',
            dataType:   'json',
            headers:    {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data:   {
                id : id
            }
        }).then(function(data) {
            console.log('fetchsection: ', data);
            $('#sectionCode').val(data.section.section_code);
            $('#sectionYearlevel').val(data.section.year_level).trigger('change');
            $('#coursePicker-section').val(data.section.course.id).trigger('change');
           
            $('#sectionModalBtn').html(BLANK);
            $('#sectionModalBtn').append(btnModalElement('updateSectionBtn-'+ id, 'Update Section Info'));
            initUpdateSection(id);
            $('#addSectionRecord').modal('toggle');

        }).fail(function(error) {
            console.log('Backend Error', error);
            internalServerError();
        });
    }); 
}

function initUpdateSection(id) {
    $('#updateSectionBtn-'+ id).on('click', function() {
        $('#addSectionRecord').modal('hide');
        bootbox.confirm({
            title: "Update Section Info?",
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
                    updateSection(id)
                }
            }
        });
    });
}


function updateSection(id) {
    // WEB SERVICE CALL 
    $.ajax({
        url:        '/admin/section/update',
        type:       'POST',
        dataType:   'json',
        headers:    {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data:   {
            id                  : id,
            course              : $('#coursePicker-section').val(),
            sectionCode         : $('#sectionCode').val(),
            sectionYearlevel    : $('#sectionYearlevel').val()
        }
    }).then(function(data) {
        console.log('fetchsection: ', data);

        $('#addSectionRecord').modal('hide');
        resetSectionModal();
        loadSectionRecord();

        // TOASTER
        successUpdate();
    }).fail(function(error) {
        console.log('Backend Error', error);
        internalServerError();
    });

}