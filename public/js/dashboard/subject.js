const BLANK = '';



/*---------------------------------

-----------------------------------*/
function loadSubjectRecord() {
    // WEB SERVICE CALL 
    $.ajax({
        url:        '/admin/subject/show',
        type:       'GET',
        dataType:   'json',
        // data:   {
        
        // }
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
        $.toast({
            heading: 'Backend Error!',
            text: 'Something went wrong. Please try again!',
            showHideTransition: 'plain',
            position: 'top-right',
            icon: 'warning'
        })
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
            data:   {
                id : id
            }
        }).then(function(data) {
            console.log('fetchSubject: ', data);
            $('#subjectName').val(data.subject.subject);
            $('#subjectCode').val(data.subject.subject_code);
            $('#subjectDescription').val(data.subject.description);
            $('#subjectUnit').val(data.subject.unit);
            $('#subjectTime').val(data.subject.time_to_consume).trigger('change');
            $('#subjectYearlevel').val(data.subject.year_level).trigger('change');

            $('#addSubjectRecord').modal('toggle');

        }).fail(function(error) {
            console.log('Backend Error', error);
            $.toast({
                heading: 'Backend Error!',
                text: 'Something went wrong. Please try again!',
                showHideTransition: 'plain',
                position: 'top-right',
                icon: 'warning'
            })
        });
    }); 
}





/*---------------------------------

-----------------------------------*/
function tableElement(subject) {
    var elm = BLANK;
        elm += ' <tr> ';
        elm += '     <td class="vertical-center">'+ subject.subject +'</th> ';
        elm += '     <td class="vertical-center">'+ subject.subject_code +'</td> ';
        elm += '     <td class="vertical-center">'+ subject.description +'</td> ';
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
    $('#subjectTime').val('00:15:00').trigger('change');
    $('#subjectYearlevel').val(1).trigger('change');
    $('#addSubjectRecord').modal('toggle');
})


/*---------------------------------

-----------------------------------*/
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
            subjectDescription  : $('#subjectDescription').val(),
            subjectUnit         : $('#subjectUnit').val(),
            subjectTime         : $('#subjectTime').val(),
            subjectYearlevel    : $('#subjectYearlevel').val()
        }
    }).then(function(data) {
        resetSubjectModal();
        loadSubjectRecord();
        $('#addSubjectRecord').modal('hide');
        $.toast({
            heading: 'Success!',
            text: 'Record successfully saved!',
            showHideTransition: 'slide',
            icon: 'success'
        })
    }).fail(function(error) {
        console.log('Backend Error', error);
    // showError('Something went wrong');
    });
});


/*---------------------------------

-----------------------------------*/
function resetSubjectModal() {
    $('#subjectName').val(BLANK);
    $('#subjectCode').val(BLANK);
    $('#subjectDescription').val(BLANK);
    $('#subjectUnit').val(BLANK);
    $('#subjectTime').val('00:15:00').trigger('change');
    $('#subjectYearlevel').val(1).trigger('change');
    
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
        $.toast({
            heading: 'Success!',
            text: 'Record successfully deleted!',
            showHideTransition: 'slide',
            icon: 'success'
        })
    }).fail(function(error) {
        console.log('Backend Error', error);
    // showError('Something went wrong');
    });
}



/*---------------------------------

-----------------------------------*/
function initTimeSelect() {
   
    // $('#subjectTime').datetimepicker();
}
