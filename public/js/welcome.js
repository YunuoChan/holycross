const BLANK = '';

function customToaster(heading, text, icon) {
    $.toast({
        heading: heading,
        text: text,
        showHideTransition: 'slide',
        position: 'bottom-right',
        icon: icon
    })
}

function checkSched() {
    var studentId = $('#studentIdNo').val();
    if (studentId.trim() == BLANK) {
        customToaster('Blank Student ID', 'Please input Student Id!', 'error')
        return false;
    }
    loadScheduleRecord()
}


/*---------------------------------

-----------------------------------*/
function loadScheduleRecord() {
    // WEB SERVICE CALL 
    $.ajax({
        url:        '/student/schedule/get',
        type:       'GET',
        dataType:   'json',
        headers:    {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data:   {
            studentId : $('#studentIdNo').val()
        }
    }).then(function(data) {
        console.log('studentScheduleTable: ', data);
        $('#studentScheduleTable').html(BLANK);
        if (data.students) {
            data.students.section.section_subjects.forEach(function(student) {
                    $('#studentScheduleTable').append(tableDataElement(student, data.students.section));
                // initTrashSections(section.id)
                // editSectionRecord(section.id)
            });
        } else {
            customToaster('No Record Found', 'We can\'t seems to find your record. Please try another ID number', 'warning')
        }
    }).fail(function(error) {
        console.log('Backend Error', error);
        internalServerError();
    });
}


/*---------------------------------

-----------------------------------*/
function tableDataElement(subject, section) {
    var elm = BLANK;
        elm += ' <tr class="bg-color-cust" height="70px"> ';
        elm += '     <td class="vertical-center">'+ subject.subject.subject_code +'</th> ';
        elm += '     <td class="vertical-center">'+ section.section_code +'</td> ';
        elm += '     <td class="vertical-center">'+ subject.generated_schedules[0].day +'</td> ';
        elm += '     <td class="vertical-center">'+ subject.generated_schedules[0].from +' - '+ subject.generated_schedules[0].to +'</td> ';
        // if (data.year_level == 1) {
        //     elm += '     <td class="vertical-center">First Year</td> ';
        // } else  if (data.year_level == 2) {
        //     elm += '     <td class="vertical-center">Second Year</td> ';
        // } else  if (data.year_level == 3) {
        //     elm += '     <td class="vertical-center">Third Year</td> ';
        // } else  if (data.year_level == 4) {
        //     elm += '     <td class="vertical-center">Fourth Year</td> ';
        // } else {
        //     elm += '     <td class="vertical-center">First Year</td> ';
        // }
        elm += '     <td class="vertical-center">TBA</td> ';
        elm += '     <td class="vertical-center">'+ subject.subject.room_no +'</td> ';
        // elm += '     <td class="vertical-center"> ';
        // elm += '        <div class="d-flex justify-content-center">'
        // if (data.status == 'ACT') {
        //     elm += '         <button type="button" class="btn btn-success mx-1" id="editStudent-'+ data.id +'"><i class="fas fa-edit"></i>Edit</button> ';
        //     elm += '         <button type="button" class="btn btn-danger" id="trashStudent-'+ data.id +'"><i class="fas fa-trash"></i></i>Trash</button> ';
        // }
        // elm += '        </div>'
        // elm += '     </td> ';
        elm += ' </tr> ';
    return elm;
}