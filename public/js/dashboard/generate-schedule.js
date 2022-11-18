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
        }
    ]
};

/*---------------------------------

-----------------------------------*/
function loadCourses(id) {
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
            $(id).append('<option value="all">All Courses</option>');
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



function yearCard(section, mark) {
    var elm = BLANK;
        elm += ' <div class="col col-lg-4"> ';
        if (section.year_level == 1) {

        } 
            elm += ' <div class="card border-'+ mark +' my-3"> ';
            elm += '     <div class="card-header"><h3 class="mb-0">'+ section.section_code +'</h3>'+ section.section +'</div> ';
            elm += '     <div class="card-body text-'+ mark +'"> ';
            // if (section.section_subjects.length > 0) {
            //     // elm += '     <h5 class="card-title">Subjects</h5> ';
               
            //     elm += ' <table class="table"> ';
            //     elm += tableHead();    
            //     elm += '    <tbody> ';
            //     section.section_subjects.forEach(function(subject) {
            //         elm += '        <tr> ';
            //         elm += '            <td>'+ subject.subject.subject_code +' - '+ subject.subject.subject +'</td> ';
            //         elm += '             <td class="vertical-center"> ';
            //         elm += '                <div class="d-flex justify-content-center"> ';
            //         // elm += '                    <button type="button" class="btn btn-success mx-1" id="viewSectionSubject-'+ subject.id +'"><i class="fas fa-eye"></i></button> ';
            //         elm += '                    <button type="button" class="btn btn-danger" id="trashSectionSubject-'+ subject.subject_id +'-'+ subject.section_id +'"><i class="fas fa-trash"></i></i></button> ';
            //         elm += '                </div> ';
            //         elm += '            </td> ';
            //         elm += '        </tr> ';
            //     });
            //     elm += '    </tbody> ';
            //     elm += ' </table> ';
            //         // elm += '         <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card content.</p> ';    
              
            // } else {
                elm += '         <h5 class="card-title">No schedule generated yet</h5> ';
            // }
            elm += '     </div> ';
            // elm += '     <div class="card-footer bg-transparent border-'+ mark +' d-flex justify-content-end"><button type="button" class="btn btn-outline-primary btn-lg" id="addSectModalCallFirstYear-'+ section.id +'"><i class="fas fa-edit mr-2"></i> Edit</button></div> ';
            elm += ' </div> ';
        elm += ' </div> ';

    return elm;
}



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
            courseId : $('#coursePicker-generate-sched').val()
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

            // callSubjectSectionAddModal(section.id)
            // if (section.section_subjects.length > 0) {
            //     section.section_subjects.forEach(function(subject) {
            //         initRemoveSubject(subject.subject_id, section.id)
            //     });
            // }
            
             
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
        $('#generateSchedFirstYear').show();
        $('#generateSchedSecondYear').show();
        $('#generateSchedThirdYear').show();
        $('#generateSchedFourthYear').show();
    } else {
        $('#generateSchedFirstYear').hide();
        $('#generateSchedSecondYear').hide();
        $('#generateSchedThirdYear').hide();
        $('#generateSchedFourthYear').hide();
    }
}



$('#generateSchedFirstYear').on('click', function () {
     // WEB SERVICE CALL 
     $.ajax({
        url:        '/admin/schedule/generate/data',
        type:       'GET',
        dataType:   'json',
        headers:    {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: {
            courseId : $('#coursePicker-generate-sched').val(),
            yearLevel: 1
        }
    }).then(function(data) {
        console.log('loadSectionSubjectRecord: ', data);

    }).fail(function(error) {
        console.log('Backend Error', error);
        internalServerError();
    });
});


$('#generater').on('click', function (){
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
                console.log(arr[i]);
                var limitation = (day.limit - arr[i].time)
                if (limitation >= 1) {
                    console.log('A');
                    day.subjects.push(arr[i]); 
                    day.limit = (day.limit - arr[i].time);
                    arr.splice(i, 1);
                } else {
                    console.log('B');
                    break;
                }
            }
        });

        $.ajax({
            url:        '/admin/schedule/generate/save',
            type:       'POST',
            dataType:   'json',
            headers:    {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {
                days : DAYS
            }
        }).then(function(data) {
            console.log('SAVE DATA: ', data);

        }).fail(function(error) {
            console.log('Backend Error', error);
            internalServerError();
        });
    }).fail(function(error) {
        console.log('Backend Error', error);
        internalServerError();
    });
});