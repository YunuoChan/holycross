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


function internalServerError() {
    $.toast({
        heading: 'Backend Error!',
        text: 'Something went wrong. Please try again!',
        showHideTransition: 'plain',
        position: 'top-right',
        icon: 'warning'
    })
}

function checkSchedStudent() {

    $('#searchSchedStudent').on('click', function (e) {
        var studentId = $('#studentIdNo').val();
        if (studentId.trim() == BLANK) {
            customToaster('Blank Student ID', 'Please input Student Id!', 'error')
            return false;
        }
        loadScheduleRecord()
    });
}


function checkSchedProf() {

    $('#searchSchedprof').on('click', function (e) {
        var profIdNo = $('#profIdNo').val();
        if (profIdNo.trim() == BLANK) {
            customToaster('Blank ID Number', 'Please input Id Number!', 'error')
            return false;
        }
        loadProfScheduleRecord()
    });
}




/*---------------------------------

-----------------------------------*/
function loadProfScheduleRecord() {
    // WEB SERVICE CALL 
    $.ajax({
        url:        '/professor/schedule/get',
        type:       'GET',
        dataType:   'json',
        headers:    {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data:   {
            professorId : $('#profIdNo').val()
        }
    }).then(function(data) {
        console.log('PROFScheduleTable: ', data);
        $('#profScheduleTable').html(BLANK);
        if (data.professor.length > 0) {
            $('#profInfo').removeClass('d-none');
            if (data.professor[0].professor_subjects.length > 0) {
                console.log(data.professor[0].professor_subjects);
                data.professor[0].professor_subjects.forEach(function(prof) {
                    $('#profScheduleTable').append(tableDatProfElement(prof));
                    $('#professorName').text(data.professor[0].name);
                    $('#professorNo').text(data.professor[0].professor_id_no);
                    $('#professorCourse').text(data.professor[0].course.course_code);
    
                });
            } else {
                $('#profScheduleTable').append(showNoSchedAvalable());
            }
            
        } else {
            $('#profInfo').addClass('d-none');
            $('#profScheduleTable').append(showNoDataAvalable());
            customToaster('No Record Found', 'We can\'t seems to find your record. Please try another ID number', 'info')
        }
    }).fail(function(error) {
        console.log('Backend Error', error);
        internalServerError();
    });
}




/*---------------------------------

-----------------------------------*/
function tableDatProfElement(data) {
    var elm = BLANK;
        elm += ' <tr class="bg-color-cust" height="70px"> ';
        elm += '     <td class="vertical-center"><div><p class="mb-0">'+ data.generated_sched.section_subject.subject.subject_code +' </p><small>'+ data.generated_sched.section_subject.subject.subject+'</small></div></th> ';
        elm += '     <td class="vertical-center">'+ data.generated_sched.section_subject.section.section_code +'</td> ';
        elm += '     <td class="vertical-center">'+ data.generated_sched.day +'</td> ';
        elm += '     <td class="vertical-center">'+ data.generated_sched.from +' - '+ data.generated_sched.to +'</td> ';
        elm += '     <td class="vertical-center">'+ data.generated_sched.section_subject.subject.room_no +'</td> ';
        elm += ' </tr> ';
    return elm;
}



function initFinder() {
    $('#iAmStudentDiv').on('click', function () {
        loadSchoolyearRecordActive()
        $('#findStudentDiv').removeClass('d-none');
        $('#chooseFinderDiv').addClass('d-none');
        $('#findProfDiv').addClass('d-none');
        $('#studentScheduleTable').html(BLANK);
        $('#studentScheduleTable').append(showSearchAvalable());
    });
    
    $('#iAmProfDiv').on('click', function () {
        loadSchoolyearRecordActive()
        $('#findProfDiv').removeClass('d-none');
        $('#chooseFinderDiv').addClass('d-none');
        $('#findStudentDiv').addClass('d-none');
        $('#profScheduleTable').html(BLANK);
        $('#profScheduleTable').append(showSearchAvalable());
    });

    
}


function showNoSchedAvalable() {
    
    var s = '';
    s+= '<tr>';  
	s+= '   <td colspan="100%">';
	s+= '	    <div id="noRecordContainer">';
	s+= '	    	<div class="d-flex flex-row justify-content-center">';
	s+= '	    		<div style="font-size: 5em;">';
	s+= '	    			<i class="fas fa-box-open"></i> ';
	s+= '	    		</div>';
	s+= '	    	</div>';
	s+= '	    	<div class="d-flex flex-row justify-content-center">';
	s+= '	    		<div> No schedule to be shown as of the moment. Please comeback later.';
	s+= '	    		</div>';
	s+= '	    	</div>';
	s+= '	    </div>';
	s+= '   </td>';
	s+=	'</tr>';

    return s;
}

function showNoDataAvalable() {
    
    var s = '';
    s+= '<tr>';  
	s+= '   <td colspan="100%">';
	s+= '	    <div id="noRecordContainer">';
	s+= '	    	<div class="d-flex flex-row justify-content-center">';
	s+= '	    		<div style="font-size: 5em;">';
	s+= '	    			<i class="fas fa-box-open"></i> ';
	s+= '	    		</div>';
	s+= '	    	</div>';
	s+= '	    	<div class="d-flex flex-row justify-content-center">';
	s+= '	    		<div> We can\'t seems to find your record. Please try another ID number';
	s+= '	    		</div>';
	s+= '	    	</div>';
	s+= '	    </div>';
	s+= '   </td>';
	s+=	'</tr>';

    return s;
}


function showSearchAvalable() {
    
    var s = '';

    s+= '<tr>';  
	s+= '   <td colspan="100%">';
	s+= '	    <div id="noRecordContainer">';
	s+= '	    	<div class="d-flex flex-row justify-content-center">';
	s+= '	    		<div style="font-size: 5em;">';
	s+= '	    			<i class="fa fa-search"></i>  ';
	s+= '	    		</div>';
	s+= '	    	</div>';
	s+= '	    	<div class="d-flex flex-row justify-content-center">';
    s+= '	    		<div> Search your schedule...';
    s+= '	    		</div>';
	s+= '	    	</div>';
	s+= '	    </div>';
	s+= '   </td>';
	s+=	'</tr>';

    return s;
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
            $('#studentInfo').removeClass('d-none');
            data.students.section.section_subjects.forEach(function(student) {
                $('#studentScheduleTable').append(tableDataElement(student, data.students.section));
                $('#studentName').text(data.students.name);
                $('#studentNo').text(data.students.student_id_no);

                $('#studentCourse').text(data.students.course.course_code);

                $('#schoolYear').text('S.Y. ' + data.students.section.schoolyear.sy_from +' - '+ data.students.section.schoolyear.sy_to);
            });
        } else {
            $('#studentInfo').addClass('d-none');
            $('#studentScheduleTable').append(showNoDataAvalable());
            customToaster('No Record Found', 'We can\'t seems to find your record. Please try another ID number', 'info')
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
        elm += '     <td class="vertical-center"><div><p class="mb-0">'+ subject.subject.subject_code +' </p><small>'+ subject.subject.subject+'</small></div></th> ';
        elm += '     <td class="vertical-center">'+ section.section_code +'</td> ';
        elm += '     <td class="vertical-center">'+ subject.generated_schedules[0].day +'</td> ';
        elm += '     <td class="vertical-center">'+ subject.generated_schedules[0].from +' - '+ subject.generated_schedules[0].to +'</td> ';

        if (subject.generated_schedules[0].professor_subject) {
            elm += '     <td class="vertical-center">'+ subject.generated_schedules[0].professor_subject.professor.name +'</td> ';
        } else {
            elm += '     <td class="vertical-center">TBA</td> ';
        }
        elm += '     <td class="vertical-center">'+ subject.subject.room_no +'</td> ';
        elm += ' </tr> ';
    return elm;
}




function loadSchoolyearRecordActive() {
    // WEB SERVICE CALL 
    $.ajax({
        url:        '/admin/schoolyear/get',
        type:       'GET',
        dataType:   'json',
        headers:    {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        // data:   {
        
        // }
    }).then(function(data) {
        console.log(data);
        if (data.schoolyears.length > 0) {
            data.schoolyears.forEach(function(schoolyear) {
                if (schoolyear.is_active == 1) {
                    $('#syLabelShowStudent').text('S.Y. '+ schoolyear.sy_from + ' - ' + schoolyear.sy_to);
                    $('#syLabelShowProfessor').text('S.Y. '+ schoolyear.sy_from + ' - ' + schoolyear.sy_to);
                }
            });
        } 
    }).fail(function(error) {
        console.log('Backend Error', error);
        internalServerError();
    });
}
