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
        var profIdNo = $('#searchProfId').val();
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
            professorId : $('#searchProfId').val()
        }
    }).then(function(data) {
        console.log('PROFScheduleTable: ', data);
        $('#profScheduleTable').html(BLANK);
        if (data.professor.length > 0) {
            $('#profInfo').removeClass('d-none');
            $('#profScheduleTable').show();
            if (data.professor[0].professor_subjects.length > 0) {
                console.log(data.professor[0].professor_subjects);
                data.professor[0].professor_subjects.forEach(function(prof) {
                    $('#professorNameDiv').removeClass('d-none')
                    $('#profScheduleTable').append(tableDatProfElement(prof));
                    $('#professorName').text(data.professor[0].name);
                    $('#professorNo').text(data.professor[0].professor_id_no);
                    $('#professorCourse').text(data.professor[0].course.course_code);
    
                });
            } else {
                $('#professorNameDiv').addClass('d-none')
                $('#profScheduleTable').append(showNoDataAvalable());
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
        
        $('#homeView').fadeOut();
        $('#findProfDiv').fadeOut();
        $('#studentSchedTable').fadeOut();
        $('#findStudentDiv').fadeIn();
        $('#studentSchedTableFirst').fadeIn();
        
        $('#findStudentDiv').removeClass('d-none');
        $('#homeView').addClass('d-none');
        $('#findProfDiv').addClass('d-none');
        $('#studentSchedTable').addClass('d-none');
        $('#searchStudentID').val(BLANK);
        $('#studentScheduleTable').html(BLANK);
        $('#studentScheduleTable').append(showSearchAvalable());
    });
    
    $('#iAmProfDiv').on('click', function () {
        $('#homeView').fadeOut();
        $('#findStudentDiv').fadeOut();
        $('#profScheduleTable').fadeOut();
        $('#findProfDiv').fadeIn();
        $('#profSchedTableFirst').fadeIn();

        $('#findProfDiv').removeClass('d-none');
        $('#homeView').addClass('d-none');
        $('#findStudentDiv').addClass('d-none');
        $('#profScheduleTable').html(BLANK);
        $('#profSchedTable').addClass('d-none');
        
        $('#searchProfId').val(BLANK);
        $('#profScheduleTable').append(showSearchAvalable());
    });

    $('#searchProfSubmit').on('click', function () {
        var profId = $('#searchProfId').val();
        if (profId.trim() == BLANK) {
            customToaster('Invalid ID Number', 'Please input ID Number!', 'warning');
            return false;
        } else {
            loadProfScheduleRecord();
            $('#profSchedTableFirst').fadeOut();
            $('#profSchedTable').fadeIn();
           
            setInterval(() => {
                $('#profSchedTable').removeClass('d-none');
            }, 500);
            
        }
    });

    $('#searchStudentSubmit').on('click', function () {
        var profId = $('#searchStudentID').val();
        if (profId.trim() == BLANK) {
            customToaster('Invalid ID Number', 'Please input ID Number!', 'warning');
            return false;
        } else {
         
            loadScheduleRecord();
            $('#studentSchedTableFirst').fadeOut(); 
            $('#studentSchedTable').fadeIn();
            setInterval(() => {
                $('#studentSchedTable').removeClass('d-none');
            }, 500);
           
        }
    });


    $('#homeBtnSchedProf').on('click', function () {
        $('#findProfDiv').addClass('d-none');
        $('#homeView').removeClass('d-none');
        $('#findStudentDiv').addClass('d-none');
        $('#homeView').fadeIn();
        $('#findStudentDiv').fadeOut();
        $('#findProfDiv').fadeOut();
        $('#profScheduleTable').html(BLANK);
    });

    $('#homeBtnSchedStudent').on('click', function () {
        $('#findProfDiv').addClass('d-none');
        $('#homeView').removeClass('d-none');
        $('#homeView').fadeIn();
        $('#findStudentDiv').fadeOut();
        $('#findProfDiv').fadeOut();
        $('#findStudentDiv').addClass('d-none');
        $('#profScheduleTable').html(BLANK);
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
            studentId : $('#searchStudentID').val()
        }
    }).then(function(data) {
        console.log('studentScheduleTable: ', data);
        $('#studentScheduleTable').html(BLANK);
        if (data.students) {
            // $('#studentInfo').removeClass('d-none');
            $('#studentSchedTable').fadeIn();
            data.students.section.section_subjects.forEach(function(student) {
                $('#studentScheduleTable').append(tableDataElement(student, data.students.section));
                $('#studentNameDiv').removeClass('d-none');
                $('#studentName').text(data.students.name);
                $('#studentNo').text(data.students.student_id_no);
                $('#studentCourse').text(data.students.course.course_code);
                $('#schoolYear').text('S.Y. ' + data.students.section.schoolyear.sy_from +' - '+ data.students.section.schoolyear.sy_to);
            });
        } else {
            $('#studentNameDiv').addClass('d-none');
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
        elm += '     <td class="vertical-center"><div><p class="mb-0"><strong>'+ subject.subject.subject_code +' </strong></p><small>'+ subject.subject.subject+'</small></div></th> ';
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
                    $('#syLabelShowStudent').append('<b>S.Y. '+ schoolyear.sy_from + ' - ' + schoolyear.sy_to +'</b>');
                    $('#syLabelShowProfessor').append('<b>S.Y. '+ schoolyear.sy_from + ' - ' + schoolyear.sy_to+'</b>');
                    if (schoolyear.semester == 1) {
                        $('#syLabelShowStudentSemester').text('First Semester');
                        $('#syLabelShowProfessorSemester').text('First Semester');
                    } else {
                        $('#syLabelShowStudentSemester').text('Second Semester');
                        $('#syLabelShowProfessorSemester').text('Second Semester');
                    }
                    
                }
            });
        } 
    }).fail(function(error) {
        console.log('Backend Error', error);
        internalServerError();
    });
}



function runClock() {
    setInterval(function() {
        var date_obj = new Date();
        var hour = date_obj.getHours();
        var minute = date_obj.getMinutes();
        // AM PM
        var amPM = (hour > 11) ? "PM" : "AM";
        // HOUR
        if (hour > 12) {
            hour -= 12;
        } else if(hour == 0) {
            hour = "12";
        }
        // MINUTE
        if (minute < 10) {
            minute = "0" + minute;
        }

        $('#time').html(BLANK);
        $('#time').append('<span>'+ hour + ' : ' + minute + ' : '+ date_obj.getSeconds() + amPM+'<span>');
        $('#date').text(date_obj.toDateString());
        
    }, 1000);

  }
  // END CLOCK SCRIPT