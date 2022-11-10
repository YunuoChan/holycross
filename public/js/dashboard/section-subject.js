const BLANK = '';


function tableHead() {
    var elm = BLANK;
        elm += ' <thead class="thead-dark"> ';
        elm += '     <tr> ';
        elm += '         <th width="60%" scope="col" class="vertical-center">Subject</th> ';
        elm += '         <th width="40%"scope="col" class="vertical-center">Controls</th> ';
        elm += '     </tr> ';
        elm += ' </thead> ';
    return elm;
}

function yearCard(section, mark) {
    var elm = BLANK;
        elm += ' <div class="col col-lg-4"> ';
        if (section.year_level == 1) {

        } 
            elm += ' <div class="card border-'+ mark +' my-3"> ';
            elm += '     <div class="card-header"><h3 class="mb-0">'+ section.section_code +'</h3>'+ section.section +'</div> ';
            elm += '     <div class="card-body text-'+ mark +'"> ';
            if (section.section_subjects.length > 0) {
                // elm += '     <h5 class="card-title">Subjects</h5> ';
               
                elm += ' <table class="table"> ';
                elm += tableHead();    
                elm += '    <tbody> ';
                section.section_subjects.forEach(function(subject) {
                    elm += '        <tr> ';
                    elm += '            <td>'+ subject.subject.subject_code +' - '+ subject.subject.subject +'</td> ';
                    elm += '             <td class="vertical-center"> ';
                    elm += '                <div class="d-flex justify-content-center"> ';
                    // elm += '                    <button type="button" class="btn btn-success mx-1" id="viewSectionSubject-'+ subject.id +'"><i class="fas fa-eye"></i></button> ';
                    elm += '                    <button type="button" class="btn btn-danger" id="trashSectionSubject-'+ subject.subject_id +'-'+ subject.section_id +'"><i class="fas fa-trash"></i></i></button> ';
                    elm += '                </div> ';
                    elm += '            </td> ';
                    elm += '        </tr> ';
                });
                elm += '    </tbody> ';
                elm += ' </table> ';
                    // elm += '         <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card content.</p> ';    
              
            } else {
                elm += '         <h5 class="card-title">No subject for this section</h5> ';
            }
            elm += '     </div> ';
            elm += '     <div class="card-footer bg-transparent border-'+ mark +' d-flex justify-content-end"><button type="button" class="btn btn-outline-primary btn-lg" id="addSectModalCallFirstYear-'+ section.id +'"><i class="fas fa-edit mr-2"></i> Edit</button></div> ';
            elm += ' </div> ';
        elm += ' </div> ';

    return elm;
}

function initCarousel() {
   // Developed at agap2
   $('.carosel-control-right').click(function() {
    $(this).blur();
    $(this).parent().find('.carosel-item').first().insertAfter($(this).parent().find('.carosel-item').last());
  });
  $('.carosel-control-left').click(function() {
    $(this).blur();
    $(this).parent().find('.carosel-item').last().insertBefore($(this).parent().find('.carosel-item').first());
  });
}


/*---------------------------------
|    CALL MODAL
-----------------------------------*/
function initCallModal(year, val) {
    $('#addSectModalCall'+ year +'Year').on('click', function () {
        $('#sectionModalBtn').html(BLANK);
        $('#sectionModalBtn').append(btnModalElement('addNewSectionBtn', 'Add Section'));
        resetSectionModal()
        initAdd();
        $('#sectionYearlevel').val(val).trigger('change');
        $('#addSectionRecord').modal('toggle');
    })
}


/*---------------------------------
|
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
                section             : $('#sectionName').val(),
                sectionCode         : $('#sectionCode').val(),
                sectionYearlevel    : $('#sectionYearlevel').val()
            }
        }).then(function(data) {
            resetSectionModal();
            $('#addSectionRecord').modal('hide');
            successSave();
        }).fail(function(error) {
            console.log('Backend Error', error);
            internalServerError()
        });
    });
}

/*---------------------------------

-----------------------------------*/
function resetSectionModal() {
    $('#sectionName').val(BLANK);
    $('#sectionCode').val(BLANK);
    $('#sectionYearlevel').val(1).trigger('change');
}



/*---------------------------------

-----------------------------------*/
function loadSectionSubjectRecord() {
    // WEB SERVICE CALL 
    $.ajax({
        url:        '/admin/section/subject/show',
        type:       'GET',
        dataType:   'json',
        headers:    {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    }).then(function(data) {
        console.log('fetchSection: ', data);

        $('#firstYearSectionDiv').html(BLANK);
        $('#secondYearSectionDiv').html(BLANK);
        $('#thirdYearSectionDiv').html(BLANK);
        $('#fourthYearSectionDiv').html(BLANK);
        data.sections.forEach(function(section) {
            if (section.year_level == 1) {
                $('#firstYearSectionDiv').append(yearCard(section, 'secondary'));
            } else if (section.year_level == 2) {
                $('#secondYearSectionDiv').append(yearCard(section, 'primary'));
            } else if (section.year_level == 3) {
                $('#thirdYearSectionDiv').append(yearCard(section, 'info'));
            } else if (section.year_level == 4) {
                $('#fourthYearSectionDiv').append(yearCard(section, 'success'));
            } 

            callSubjectSectionAddModal(section.id)
            if (section.section_subjects.length > 0) {
                section.section_subjects.forEach(function(subject) {
                    initRemoveSubject(subject.subject_id, section.id)
                });
            }
            
             
        });
    }).fail(function(error) {
        console.log('Backend Error', error);
        internalServerError();
    });
}

function initRemoveSubject(subject, section) {
    $('#trashSectionSubject-'+ subject +'-'+ section).on('click', function() {
        bootbox.confirm({
            title: "Remove Section?",
            message: "Are you sure you want to remove subject to this section?",
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
                    confirmRemoveSubject(subject, section)
                }
            }
        });
    });
    
}
function confirmRemoveSubject(subject, section) {
    // WEB SERVICE CALL 
    $.ajax({
        url:        '/admin/section/subject/destroy',
        type:       'POST',
        dataType:   'json',
        headers:    {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data:   {
            section     : section,
            subject     : subject
        }
    }).then(function(data) {
        loadSectionSubjectRecord();
        $('#addSectionSubjectRecord').modal('hide');

        // TOASTER
        successDelete();
    }).fail(function(error) {
        console.log('Backend Error', error);
        internalServerError()
    });
}

function callSubjectSectionAddModal(id) {

    $('#addSectModalCallFirstYear-'+ id).on('click', function() {
        // WEB SERVICE CALL 
        $.ajax({
            url:        '/admin/section/subject/get/sectiondata',
            type:       'GET',
            dataType:   'json',
            headers:    {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data:   {
                id : id
            }
        }).then(function(data) {
            console.log('fetchsection: ', data);

            $('#addSectionSubjectSection').html(BLANK);
            $('#addSectionSubjectSection').append('<h3 class="mb-0">'+ data.section[0].section_code +'</h3><p>'+ data.section[0].section +'</p>');
            $('#sectionSubjectPicker').html(BLANK);
            data.subjects.forEach(function(subject) {
                $('#sectionSubjectPicker').append(subjectSectionElement(subject, data.section[0].id));
            });
            
            if (data.section[0].section_subjects.length > 0) {
                data.section[0].section_subjects.forEach(function(subsect) {
                    $('#subject-'+ subsect.subject_id).prop('checked', true)
                });
            }
            $('#sectionSubjecModalBtn').html(BLANK);
            $('#sectionSubjecModalBtn').append(btnModalElement('saveSubjectSection-'+data.section[0].id, 'Save Section Subject'));
            initSave(data.section[0].id)
            $('#addSectionSubjectRecord').modal('toggle');
        }).fail(function(error) {
            console.log('Backend Error', error);
            internalServerError();
        });
    });
}

function subjectSectionElement(subject, section) {

    var elm = BLANK;
        elm += ' <div class="form-check form-switch"> ';
        elm += '     <input class="form-check-input" type="checkbox" name="subject-'+ section +'" id="subject-'+ subject.id +'" data-id="'+ subject.id +'"> ';
        elm += '     <label class="form-check-label" for="subject-'+ subject.id +'">'+ subject.subject_code +' | '+ subject.subject +'</label> ';
        elm += ' </div> ';

    return elm;
}



/*---------------------------------

-----------------------------------*/
function initSave(id) {
    $('#saveSubjectSection-'+ id).on('click', function () {

        var sectionSelected = [];
        $('input[name="subject-'+ id +'"]:checked').map( function(index, elm) {
            sectionSelected.push($(elm).attr('data-id'));
        });

        // WEB SERVICE CALL 
        $.ajax({
            url:        '/admin/section/subject/update',
            type:       'POST',
            dataType:   'json',
            headers:    {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data:   {
                section             : id,
                sectionSelected     : sectionSelected
            }
        }).then(function(data) {
            loadSectionSubjectRecord();
            $('#addSectionSubjectRecord').modal('hide');

            // TOASTER
            successSave();
        }).fail(function(error) {
            console.log('Backend Error', error);
            internalServerError()
        });
    });
}
