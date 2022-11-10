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
            elm += '     <div class="card-header"><h3>'+ section.section +'</h3>'+ section.section_code +'</div> ';
            elm += '     <div class="card-body text-'+ mark +'"> ';
            if (section.section_subjects.length > 0) {
                elm += '     <h5 class="card-title">Subjects</h5> ';
               
                elm += ' <table class="table"> ';
                elm += tableHead();    
                elm += '    <tbody> ';
                section.section_subjects.forEach(function(subject) {
                    elm += '        <tr> ';
                    elm += '            <td>'+ subject.subject.subject_code +' - '+ subject.subject.subject +'</td> ';
                    elm += '             <td class="vertical-center"> ';
                    elm += '                <div class=""> ';
                    elm += '                    <button type="button" class="btn btn-success mx-1" id="viewSectionSubject-'+ subject.id +'"><i class="fas fa-eye"></i></button> ';
                    elm += '                    <button type="button" class="btn btn-danger" id="trashSectionSubject-'+ subject.id +'"><i class="fas fa-trash"></i></i></button> ';
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
             
        });
    }).fail(function(error) {
        console.log('Backend Error', error);
        internalServerError();
    });
}


function callSubjectSectionAddModal(id) {

    $('#addSectModalCallFirstYear-'+ id ).on('click', function() {
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

        }).fail(function(error) {
            console.log('Backend Error', error);
            internalServerError();
        });
    });
    
    // $('#addSectionSubjectSection').html(BLANK);
    // $('#addSectionSubjectSection').append('<h3>'+ section.section +'</h3><p>'+ section.section_code+'</p>');
    
    // $('#addSectionSubjectRecord').modal('toggle');
}