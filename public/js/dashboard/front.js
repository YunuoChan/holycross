const BLANK = '';

/*---------------------------------

-----------------------------------*/
function loadStatistics() {
    // WEB SERVICE CALL 
    $.ajax({
        url:        '/get/statistics',
        type:       'GET',
        dataType:   'json',
        headers:    {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data:   {
            yearlvl : $('#yearLevelDashboard').val(),
            course  : $('#dashboardCourse').val(),
        }
    }).then(function(data) {
        console.log('STATISTICS: ', data);

        $('#dasboardStudentCount').text(data.studentCount);
        $('#dasboardProfessorCount').text(data.professorCount);
        $('#dasboardCourseCount').text(data.courseCount);
        $('#dasboardSectionCount').text(data.sectionCount);
        $('#dasboardSubjectCount').text(data.subjectCount);
       
    }).fail(function(error) {
        console.log('Backend Error', error);
        internalServerError();
    });
}


$('#yearLevelDashboard').on('change', function () {
    loadStatistics();
});


$('#dashboardCourse').on('change', function () {
    loadStatistics();
});



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

function initChart() {
    const chartOptions = {
        maintainAspectRatio: false,
        legend: {
            display: false,
        },
        tooltips: {
            enabled: false,
        },
        elements: {
            point: {
                radius: 0
            },
        },
        scales: {
            xAxes: [{
                gridLines: false,
                scaleLabel: false,
                ticks: {
                    display: false
                }
            }],
            yAxes: [{
                gridLines: false,
                scaleLabel: false,
                ticks: {
                    display: false,
                    suggestedMin: 0,
                    suggestedMax: 10
                }
            }]
        }
    };


    //
    var ctx = document.getElementById('chart1').getContext('2d');
    var chart = new Chart(ctx, {
        type: "line",
        data: {
            labels: [1, 2, 1, 3, 5, 4, 7],
            datasets: [
                {
                    backgroundColor: "rgba(101, 116, 205, 0.1)",
                    borderColor: "rgba(101, 116, 205, 0.8)",
                    borderWidth: 2,
                    data: [3, 6, 4, 1, 2, 4, 7],
                },
            ],
        },
        options: chartOptions
    });
    //
    var ctx = document.getElementById('chart2').getContext('2d');
    var chart = new Chart(ctx, {
        type: "line",
        data: {
            labels: [2, 3, 2, 9, 7, 7, 4],
            datasets: [
                {
                    backgroundColor: "rgba(246, 109, 155, 0.1)",
                    borderColor: "rgba(246, 109, 155, 0.8)",
                    borderWidth: 2,
                    data: [2, 3, 2, 9, 7, 7, 4],
                },
            ],
        },
        options: chartOptions
    });
    
    //
    var ctx = document.getElementById('chart3').getContext('2d');
    var chart = new Chart(ctx, {
        type: "line",
        data: {
            labels: [2, 5, 1, 3, 2, 6, 7],
            datasets: [
                {
                    backgroundColor: "rgba(246, 153, 63, 0.1)",
                    borderColor: "rgba(246, 153, 63, 0.8)",
                    borderWidth: 2,
                    data: [2, 5, 1, 3, 2, 6, 7],
                },
            ],
        },
        options: chartOptions
    });

    //
    var ctx = document.getElementById('chart4').getContext('2d');
    var chart = new Chart(ctx, {
        type: "line",
        data: {
            labels: [2, 5, 1, 3, 2, 6, 7],
            datasets: [
                {
                    backgroundColor: "rgba(123, 122, 34, 0.1)",
                    borderColor: "rgba(123, 122, 34, 0.8)",
                    borderWidth: 2,
                    data: [2, 8, 1, 3, 2, 6, 7],
                },
            ],
        },
        options: chartOptions
    });

    //
    var ctx = document.getElementById('chart5').getContext('2d');
    var chart = new Chart(ctx, {
        type: "line",
        data: {
            labels: [2, 9, 3, 1, 7, 6, 7],
            datasets: [
                {
                    backgroundColor: "rgba(98, 170, 2, 0.1)",
                    borderColor: "rgba(98, 170, 2, 0.8)",
                    borderWidth: 2,
                    data: [2, 9, 3, 1, 7, 6, 7],
                },
            ],
        },
        options: chartOptions
    });
}