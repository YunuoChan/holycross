const BLANK = '';

const DAYS        	= {
    days: [
        {
            id	: 'monday',
            day	: 'Monday',
            limit : 8,
        },
        {
            id	: 'tuesday',
            day	: 'Tuesday',
            limit : 8,
        },
        {
            id	: 'wednesday',
            day	: 'Wednesday',
            limit : 8,
        }, 
        {
            id	: 'thursday',
            day	: 'Thursday',
            limit : 8,
        },
        {
            id	: 'friday',
            day	: 'Friday',
            limit : 8,
        },
        {
            id	: 'saturday',
            day	: 'Saturday',
            limit : 8,
        },
        {
            id	: 'monday',
            day	: 'Monday',
            limit : 8,
        },
        {
            id	: 'tuesday',
            day	: 'Tuesday',
            limit : 8,
        },
        {
            id	: 'wednesday',
            day	: 'Wednesday',
            limit : 8,
        }, 
        {
            id	: 'thursday',
            day	: 'Thursday',
            limit : 8,
        },
        {
            id	: 'friday',
            day	: 'Friday',
            limit : 8,
        },
        {
            id	: 'saturday',
            day	: 'Saturday',
            limit : 8,
        },
        {
            id	: 'monday',
            day	: 'Monday',
            limit : 8,
        },
        {
            id	: 'tuesday',
            day	: 'Tuesday',
            limit : 8,
        },
        {
            id	: 'wednesday',
            day	: 'Wednesday',
            limit : 8,
        }, 
        {
            id	: 'thursday',
            day	: 'Thursday',
            limit : 8,
        },
        {
            id	: 'friday',
            day	: 'Friday',
            limit : 8,
        },
        {
            id	: 'saturday',
            day	: 'Saturday',
            limit : 8,
        }
    ]
};

/*---------------------------------

-----------------------------------*/
function loadCourses(id, isAllExist) {
    // WEB SERVICE CALL 
    $.ajax({
        url:        '/admin/course/get',
        type:       'GET',
        dataType:   'json',
        headers:    {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    }).then(function(data) {
        console.log('fetchCourse: ', data);
        if (data.courses.length > 0) {
            $(id).html(BLANK);
            if (isAllExist == 1) {
                $(id).append('<option value="All">All Department</option>');
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




function tableHead() {
    var elm = BLANK;
        elm += ' <thead class="thead-dark"> ';
        elm += '     <tr> ';
        elm += '         <th width="20%" scope="col" class="vertical-center">Subject</th> ';
        elm += '         <th width="20%"scope="col" class="vertical-center">Schedule Day</th> ';
        elm += '         <th width="30%"scope="col" class="vertical-center">Time</th> ';
        elm += '         <th width="20%"scope="col" class="vertical-center">Professor</th> ';
        elm += '         <th width="10%"scope="col" class="vertical-center">Room</th> ';
        elm += '     </tr> ';
        elm += ' </thead> ';
    return elm;
}

function yearCard(section, mark) {
    var elm = BLANK;
        elm += ' <div class="col col-lg-6"> ';
        if (section.year_level == 1) {

        } 
            elm += ' <div class="card border-'+ mark +' my-3"> ';
            elm += '     <div class="card-header"><h3 class="mb-0">'+ section.section_code +'</h3>'+ section.course.course_code +'</div> ';
            elm += '     <div class="card-body text-'+ mark +' p-1"> ';
            if (section.section_subjects.length > 0) {    
                elm += ' <div class="tableFixHead">';

        
                elm += ' <table class="table"> ';
                elm += tableHead();    
                elm += '    <tbody> ';
                section.section_subjects.forEach(function(subject) {
                    elm += '        <tr> ';
                    elm += '            <td>'+ subject.subject.subject_code +'</td> ';
                    if (subject.generated_schedules.length > 0) {
                        elm += '            <td class="vertical-center">'+ subject.generated_schedules[0].day +' </td> ';
                    } else {
                        elm += '            <td class="vertical-center">TBA </td> ';
                    }
                    elm += '            ';
                    console.log('GEN-SCHED: ', subject.generated_schedules[0]);
                    elm += '            <td class="vertical-center">'+ subject.generated_schedules[0].from +' - '+ subject.generated_schedules[0].to +'</td> ';
                    elm += '            <td class="vertical-center">TBA </td> ';
                    elm += '            <td class="vertical-center">'+ subject.subject.room_no +' </td> ';
                    elm += '        </tr> ';
                });
                elm += '    </tbody> ';
                elm += ' </table> ';
                elm += ' </div>     ';      
              
            } else {
                elm += '         <h5 class="card-title ml-3">No schedule generated yet</h5> ';
            }
            elm += '     </div> ';
            elm += ' </div> ';
        elm += ' </div> ';

    return elm;
}


$('#coursePickerFilter-generatedSched').on('change', function () {
    loadSectionSubjectRecord()
});

/*---------------------------------

-----------------------------------*/
function loadSectionSubjectRecord() {
    // WEB SERVICE CALL 
    $.ajax({
        url:        '/admin/schedule/generate/show',
        type:       'GET',
        dataType:   'json',
        headers:    {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: {
            courseId : $('#coursePickerFilter-generatedSched').val()
        }
    }).then(function(data) {
        console.log('loadSectionSubjectRecord: ', data);

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
             
        });
    }).fail(function(error) {
        console.log('Backend Error', error);
        internalServerError();
    });
}


$('#coursePicker-generate-sched').on('change', function() {
    loadSectionSubjectRecord();

    courseOnchange();
});

function courseOnchange() {
    if ($.isNumeric($('#coursePicker-generate-sched').val())) {
        $('#generateScheduleBtn').prop('disabled', false);
    } else {
        $('#generateScheduleBtn').prop('disabled', true);
    }
}


/*---------------------------------

-----------------------------------*/
$('#generateSchedFirstYear').on('click', function () {

    $('#generateScheduleBtnDiv').html(BLANK);
    $('#generateScheduleBtnDiv').append(btnModalElement('generateScheduleBtn', 'Generate Schedule'));
    initGenerateSchedule();
    courseOnchange();
    $('#generateScheduleModal').modal('toggle');
});




/*---------------------------------
    TRASH SECTION
-----------------------------------*/
function initGenerateSchedule() {
    $('#generateScheduleBtn').on('click', function() {
        bootbox.confirm({
            title: "Generate Schedule?",
            message: "Are you sure you want to generate new schedule? <b>Doing so will overwrite the existing schedule(if any).</b>",
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
                    generateSchedule()
                }
            }
        });
    });
}


/*---------------------------------

-----------------------------------*/
function generateSchedule() {
    if (!$.isNumeric($('#coursePicker-generate-sched').val())) {
        $('#generateScheduleBtn').prop('disabled', true);
        customToaster('Fields incomplete!', 'Please select course.', 'warning')
        $('#generateScheduleModal').modal('hide');
        return false;
    }
    $('#generateScheduleBtn').prop('disabled', true);
    $('#generateScheduleModal').modal('hide');
    customToaster('Please Wait!', 'Generating schedule...', 'info')
    // WEB SERVICE CALL 
    $.ajax({
        url:        '/admin/schedule/generate/data',
        type:       'GET',
        dataType:   'json',
        headers:    {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: {
            courseId : $('#coursePicker-generate-sched').val(),
            yearLevel: $('#generateSchedYearlevel').val()
        }
    }).then(function(data) {
        console.log('loadSectionSubjectRecord: ', data);

        setTimeout(function() {   
            designateSectionAndSchedule($('#coursePicker-generate-sched').val(), $('#generateSchedYearlevel').val());
        }, 1000);

    }).fail(function(error) {
        console.log('Backend Error', error);
        internalServerError();
    });
}

function designateSectionAndSchedule(course, yearLevel) {
    // WEB SERVICE CALL 
    $.ajax({
        url:        '/admin/schedule/generate/gets',
        type:       'GET',
        dataType:   'json',
        headers:    {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        // data: {
        //     courseId : $('#coursePicker-generate-sched').val(),
        //     yearLevel: 1
        // }
    }).then(function(data) {
        console.log('loadSectionSubjectRecord GETE: ', data);

        var arr = [];

        data.sectionSubjs.forEach(function(subject) {
            data = {
                id : subject.id,
                time : subject.subject.time_to_consume
            }

            arr.push(data)
        });
        
        
        DAYS.days.forEach(function(day, index) {

            limit = day.limit;
            day.subjects = [];
            for(var i = 0; i < arr.length; i++) {
                var limitation = (day.limit - arr[i].time)
                if (limitation >= 1) {
                    day.subjects.push(arr[i]); 
                    day.limit = (day.limit - arr[i].time);
                    arr.splice(i, 1);
                } else {
                    break;
                }
            }
        });


        DAYS.days.forEach(function(day, index) {
            if (day.subjects.length > 0) {
                var startTime = '7:00:00';
                day.subjects.forEach(function(subj, index) {

                    subj.from = moment(startTime, 'HH:mm:ss').format('LT');;
                    toMinute = (parseFloat(subj.time) / 0.25);
                    minute = (toMinute * 15)
                    startTime = moment(startTime, 'HH:mm:ss').add(minute, 'minutes').format('LT');
                    subj.to = startTime;
                })
            }
           
        });

        // SAVE GENERATED
        $.ajax({
            url:        '/admin/schedule/generate/save',
            type:       'POST',
            dataType:   'json',
            headers:    {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {
                days : DAYS,
                course : course,
                yearLevel : yearLevel
            }
        }).then(function(data) {
            console.log('SAVE DATA: ', data);
            customToaster('Success!', 'Schedule generated successfully.', 'success');
            loadSectionSubjectRecord();
        }).fail(function(error) {
            console.log('Backend Error', error);
            internalServerError();
        });
        
    }).fail(function(error) {
        console.log('Backend Error', error);
        internalServerError();
    });
}
