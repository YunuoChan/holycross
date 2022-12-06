const BLANK = '';

var toAssignSubject = [];
var curProf = null;


function assignSubjectInit(id) {
    $('#addProfessorSubjectModalCall-'+ id).on('click', function () {

        $('#professorSubjectModalBtn').html(BLANK);
        $('#professorSubjectModalBtn').append(btnModalElement('addProfessorSubjectBtn-'+ id, 'Assign Subject'));
        // initAddProfessor();
        $('#addProfessorSubjectRecord').modal('toggle');
    });
}


$('#searchBtn-professorsubject').on('click', function () {
    loadProfessorSubjectRecord();
});

$('#searchField-professorsubject').on('blur', function () {
    loadProfessorSubjectRecord();
});



/*---------------------------------

-----------------------------------*/
function loadProfessorSubjectRecord() {
    var keyword = $('#searchField-professorsubject').val();
    // WEB SERVICE CALL 
    $.ajax({
        url:        '/admin/professor/subject/show',
        type:       'GET',
        dataType:   'json',
        headers:    {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data:   {
            keyword : keyword.trim()
        }
    }).then(function(data) {
        console.log('fetchProfTable: ', data);
        $('#professorSubjectTable').html(BLANK);
        if (data.professors.length > 0) {
            data.professors.forEach(function(prof) {
                $('#professorSubjectTable').append(tableElement(prof));
                // initTrashProfessor(prof.id)
                // editProfessorRecord(prof.id) 
                prof.professor_subjects.forEach(function (subj) {
                    initRemoveAssignedSubjectToDb(subj.id)
                });
                initCallFunctionToAssignSubject(prof.id)
            });
        } else {
            $('#professorSubjectTable').append(showNoDataTableAvalable());
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
        elm += '     <td class="vertical-center">'+ data.professor_id_no +'</th> ';
        elm += '     <td class="vertical-center">'+ data.name +'</td> ';

        if (data.professor_subjects.length > 0) {
            elm += '     <td class="vertical-center p-0">';
            elm += '       <div class="tableFixHead form-group"> ';
            elm += '         <table class="table"> ';
            elm += '             <thead class="thead-dark"> ';
            elm += '                 <tr> ';
            elm += '                 <th width="15%" scope="col" class="vertical-center thead-color ">Course & Section</th> ';
            elm += '                 <th width="15%" scope="col" class="vertical-center thead-color ">Subject</th> ';
            elm += '                 <th width="15%"scope="col" class="vertical-center thead-color ">Day and Time</th> ';
            elm += '                 <th width="5%"scope="col" class="vertical-center thead-color ">Control</th> ';
            elm += '                 </tr> ';
            elm += '              </thead> ';
            elm += '             <div> ';
            elm += '                 <tbody> ';
            data.professor_subjects.forEach(function (subj) {
                elm += ' <tr class="pointer scroll-xy"> ';
                
                elm += '     <td class="vertical-center">';
                elm += '        <div> ';
                elm +=              '<label class="mb-0">'+  subj.generated_sched.section_subject.section.course.course_code +' - '+  subj.generated_sched.section_subject.section.section_code + '</label>';
                elm += '        </div> ';
                // elm += '        <div> ';
                //     if (data.year_level == 1) {
                //         elm += '     <small>First Year</small>';
                //     } else  if (data.year_level == 2) {
                //         elm += '     <small>Second Year</small>';
                //     } else  if (data.year_level == 3) {
                //         elm += '     <small>Third Year</small>';
                //     } else  if (data.year_level == 4) {
                //         elm += '     <small>Fourth Year</small>';
                //     } else {
                //         elm += '     <small>First Year</small>';
                //     }
                // elm += '        </div> ';
                elm += '     </td> ';
                elm += '     <td class="vertical-center">'
                elm += '        <div> ';
                elm +=              '<label class="mb-0">'+  subj.generated_sched.section_subject.subject.subject_code + '</label>';
                elm += '        </div> ';
                elm += '        <div> ';
                elm +=              '<small>'+  subj.generated_sched.section_subject.subject.subject + '</small>';
                elm += '        </div> ';
                elm += '     </td> ';
                elm += '     <td class="vertical-center">'+  subj.generated_sched.day +', '+  subj.generated_sched.from +' - '+  subj.generated_sched.to +'</td> ';
                elm += '     <td class="vertical-center"><button type="button" class="btn btn-danger" id="removeSubjectToProfessorDb-'+ subj.id +'"><i class="fas fa-trash"></i></i></button> </td> ';
                elm += ' </tr> ';
            });
            elm += '                 </tbody>   ';
            elm += '             </div> ';
            elm += '         </table> ';
            elm += '       </div> ';
            elm += '    </td> ';
        } else {
            elm += '     <td class="vertical-center"><small>No assigned subject yet</small></td> ';
        }

        elm += '     <td class="vertical-center">'+ data.status +'</td> ';
        elm += '     <td class="vertical-center"> ';
        elm += '        <div class="d-flex">'
        if (data.status == 'ACT') {
            elm += '         <button type="button" class="btn btn-success mx-1" id="editProfessorSubject-'+ data.id +'"><i class="fas fa-edit"></i>Assign</button> ';
        }
        elm += '        </div>'
        elm += '     </td> ';
        elm += ' </tr> ';

    return elm;
}


function initRemoveAssignedSubjectToDb(id) {
    $('#removeSubjectToProfessorDb-'+ id).on('click', function () {
        bootbox.confirm({
            title: "Remove Subject assignation?",
            message: "Are you sure you want to remove this subject?",
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
                    initRemoveAssignedSubjectToDbApi(id)
                }
            }
        });
    });
}




/*---------------------------------

-----------------------------------*/
function initRemoveAssignedSubjectToDbApi(id) {
    $.ajax({
        url:        '/admin/professor/subject/trash',
        type:       'POST',
        dataType:   'json',
        headers:    {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data:   {
            id : id
        }
    }).then(function(data) {

        loadProfessorSubjectRecord();
        $('#addProfessorSubjectRecord').modal('hide');
        resetAssignModal();
        successDelete();
    }).fail(function(error) {
        console.log('Backend Error', error);
        internalServerError();
    });
}


function initCallFunctionToAssignSubject(profSubjId) {
    $('#editProfessorSubject-'+ profSubjId).on('click', function () {
        $('#professorSubjectModalBtn').html(BLANK);
        $('#professorSubjectModalBtn').append(btnModalElement('addProfessorSubjectBtn-'+ profSubjId, 'Assign Subject'));
        loadSubjectRecordForModal(profSubjId)
        curProf = profSubjId;
        $('#addProfessorSubjectRecord').modal('toggle');
        $('#toAssignSubject').html(BLANK);
        toAssignSubject = [];
        initSaveProfSubject(profSubjId);
        $('#toAssignSubject').append(showNoDataTableAvalable());
    });
}


function initSaveProfSubject(id) {
    $('#addProfessorSubjectBtn-'+ id).on('click', function () {
        // WEB SERVICE CALL 
        $.ajax({
            url:        '/admin/professor/subject/save',
            type:       'POST',
            dataType:   'json',
            headers:    {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data:   {
                profId            : id,
                subjects          : toAssignSubject,
            }
        }).then(function(data) {
            console.log('STUDENT ADDED');
            loadProfessorSubjectRecord();
            $('#addProfessorSubjectRecord').modal('hide');
            resetAssignModal();
            successSave();

        }).fail(function(error) {
            console.log('Backend Error', error);
            internalServerError()
        });
    });
}

function appendSubjectTable(id) {
    $('#appendSubjectTable').html(BLANK);
    $('#appendSubjectTable').html(tableElementSubject());
    initAddAssignSubject(1)
}


/*---------------------------------

-----------------------------------*/
function tableElementSubject(data) {
    var elm = BLANK;
        elm += ' <tr class="pointer scroll-xy" id="addSubjectToAssign-'+ data.id +'" data-id="'+ data.id +'" data-value="'+ data.section_subject.subject.subject_code +'='+ data.day +', '+ data.from +' - '+ data.to +'='+ data.section_subject.section.course.course_code +' - '+ data.section_subject.section.section_code +'"> ';
        if (data.section_subject.section.year_level == 1) {
            elm += '     <td class="vertical-center">First Year</td> ';
        } else  if (data.section_subject.section.year_level == 2) {
            elm += '     <td class="vertical-center">Second Year</td> ';
        } else  if (data.section_subject.section.year_level == 3) {
            elm += '     <td class="vertical-center">Third Year</td> ';
        } else  if (data.section_subject.section.year_level == 4) {
            elm += '     <td class="vertical-center">Fourth Year</td> ';
        } else {
            elm += '     <td class="vertical-center">First Year</td> ';
        }
        elm += '     <td class="vertical-center">'+ data.section_subject.section.course.course_code +' - '+ data.section_subject.section.section_code +'</td> ';
        elm += '     <td class="vertical-center">'
        elm += '        <div> ';
        elm +=              '<label class="mb-0">'+ data.section_subject.subject.subject_code + '</label>';
        elm += '        </div> ';
        elm += '        <div> ';
        elm +=              '<small>'+ data.section_subject.subject.subject + '</small>';
        elm += '        </div> ';
        elm += '     </td> ';
        elm += '     <td class="vertical-center">'+ data.day +', '+ data.from +' - '+ data.to +'</td> ';
        elm += ' </tr> ';

    return elm;
}

function initAddAssignSubject(id) {

    $('#addSubjectToAssign-'+ id).on('click', function () {
        if (toAssignSubject.length < 1 && $('a[name="selectedSubjectFromDb"]').length < 1) {
            $('#toAssignSubject').html(BLANK);
        }
        
        var isExist  = toAssignSubject.find(function(i) {
            return i == id;
        });  
        if (!isExist) {
            var info = $(this).attr('data-value');
            var data = info.split('=');
            $('#toAssignSubject').append(appendSelectedSubject(data, id));
            toAssignSubject.push(id);
            initRemoveAssigned(id);
            $(this).addClass('d-none');
        }
    });

}


function resetAssignModal() {
    $('#toAssignSubject').html(BLANK);
    toAssignSubject = [];
    curProf = null;
}

function appendSelectedSubject(data, id) {
    var elm = BLANK;
        elm += ' <a id="profSubject-'+ id +'" class="list-group-item list-group-item-action list-group-item-info d-flex justify-content-between"> ';
        elm += '     <div class="d-flex justify-content-center flex-column"> ';
        elm += '        <div> ';
        elm += '            <label class="mb-0"><strong>'+ data[0] +'</strong></label> ';
        elm += '        </div> ';
        elm += '        <small>'+ data[1] +'</small>';
        elm += '        <small>'+ data[2] +'</small>';
        elm += '     </div> ';
        elm += '     <div class="d-flex justify-content-center flex-column"> ';
        elm += '        <button type="button" class="btn btn-danger" id="removeSubjectToProfessor-'+ id +'"><i class="fas fa-trash"></i></i></button> ';
        elm += '     </div> ';
        elm += ' </a> ';

    return elm;
}


/*---------------------------------

-----------------------------------*/
function initRemoveAssigned(id) {
    $('#removeSubjectToProfessor-'+ id).on('click', function () {
        toAssignSubject.splice(toAssignSubject.findIndex(function(i){
            return i == id;
        }), 1);
    
        $('#profSubject-'+ id).remove();
        $('#addSubjectToAssign-'+ id).removeClass('d-none');

        if (toAssignSubject.length < 1) {
            $('#toAssignSubject').append(showNoDataTableAvalable());
        }
    });

}


$('#yearLevelFilter-profsubject').on('change', function () {
    loadSubjectRecordForModal(curProf);
});


$('#coursePickerFilter-profsubject').on('change', function () {
    loadSubjectRecordForModal(curProf);
});

/*---------------------------------

-----------------------------------*/
function loadSubjectRecordForModal(profId) {
    // WEB SERVICE CALL 
    $.ajax({
        url:        '/admin/professor/subject/list',
        type:       'GET',
        dataType:   'json',
        headers:    {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data:   {
            profId : profId,
            course : $('#coursePickerFilter-profsubject').val(),
            yearLvl : $('#yearLevelFilter-profsubject').val()
        }
    }).then(function(data) {
        console.log('fetchProfTable: ', data);

        $('#profName').text(data.professor.name);
        $('#profIdNo').text(data.professor.professor_id_no);
        $('#deptName').text(data.professor.course.course_code);
        $('#appendSubjectTable').html(BLANK);
        if (data.subjectLists.length > 0) {
            data.subjectLists.forEach(function(subj) {
                $('#appendSubjectTable').append(tableElementSubject(subj));
                initAddAssignSubject(subj.id)
            });
        } else {
            $('#appendSubjectTable').append(showNoDataTableAvalable());
        }
        $('#toAssignSubject').html(BLANK);
        if ( data.professor.professor_subjects.length > 0) {
            data.professor.professor_subjects.forEach(function (subj) {
                $('#addSubjectToAssign-'+ subj.id).addClass('d-none');
                $('#toAssignSubject').append(appendSelectedSubjectFromDb(subj));
                initRemoveAssignedSubjectToDbModal(subj.id)
            });
        } else {
            $('#toAssignSubject').append(showNoDataTableAvalable());
        }
       

    }).fail(function(error) {
        console.log('Backend Error', error);
        internalServerError();
    });
}



function appendSelectedSubjectFromDb(data) {
    var elm = BLANK;
        elm += ' <a id="profSubject-'+ data.id +'" name="selectedSubjectFromDb" class="list-group-item list-group-item-action list-group-item-info d-flex justify-content-between"> ';
        elm += '     <div class="d-flex justify-content-center flex-column"> ';
        elm += '        <div> ';
        elm += '            <label class="mb-0"><strong>'+ data.generated_sched.section_subject.subject.subject_code +'</strong></label> ';
        elm += '        </div> ';
        elm += '        <small>'+  data.generated_sched.day +', '+  data.generated_sched.from +' - '+  data.generated_sched.to +'</small>';
        elm += '        <small>'+ data.generated_sched.section_subject.section.course.course_code +' - '+ data.generated_sched.section_subject.section.section_code +'</small>';
        elm += '     </div> ';
        elm += '     <div class="d-flex justify-content-center flex-column"> ';
        elm += '        <button type="button" class="btn btn-danger" id="removeSubjectToProfessorDbModal-'+ data.id +'"><i class="fas fa-trash"></i></i></button> ';
        elm += '     </div> ';
        elm += ' </a> ';

    return elm;
}


function initRemoveAssignedSubjectToDbModal(id) {
    $('#removeSubjectToProfessorDbModal-'+ id).on('click', function () {
        bootbox.confirm({
            title: "Remove Subject assignation?",
            message: "Are you sure you want to remove this subject?",
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
                    initRemoveAssignedSubjectToDbApiModal(id)
                }
            }
        });
    });
}


/*---------------------------------

-----------------------------------*/
function initRemoveAssignedSubjectToDbApiModal(id) {
    $.ajax({
        url:        '/admin/professor/subject/trash',
        type:       'POST',
        dataType:   'json',
        headers:    {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data:   {
            id : id
        }
    }).then(function(data) {
        loadProfessorSubjectRecord();
        successDelete();
        $('#profSubject-'+ id).remove();
        $('#addSubjectToAssign-'+ id).removeClass('d-none');
        showNoData();
    }).fail(function(error) {
        console.log('Backend Error', error);
        internalServerError();
    });
}


function showNoData() {
    if ($('a[name="selectedSubjectFromDb"]').length < 1 && toAssignSubject.length < 1) {
        $('#toAssignSubject').append(showNoDataTableAvalable());
    }
}