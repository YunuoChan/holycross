const BLANK = '';



function loadSchoolyearRecord() {
    // WEB SERVICE CALL 
    $.ajax({
        url:        '/admin/schoolyear/get',
        type:       'GET',
        dataType:   'json',
        // data:   {
        
        // }
    }).then(function(data) {
        console.log('fetchUsers: ', data);
        $('#recordListSY').html(BLANK);
        data.schoolyears.forEach(schoolyear => {
            if (schoolyear.is_active == 0) {
                $('#recordListSY').append(syElement(schoolyear));
                initRemoveSY(schoolyear.id)
                initProceed(schoolyear.id)
            } else {
                $('#activeSY').html(BLANK);
                $('#activeSY').append(syElement(schoolyear));
                initProceed(schoolyear.id)
            }
        });

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

function syElement(data) {

    var s = '';
    s +=    ' <div class="card border-success mb-3 mx-3" style="max-width: 18rem;"> ';
    s +=    '     <div class="card-header"> ';
    if (data.semester == 1) {
        s +=    '                   <small class="mt-3 mb-0"><b>First Semester</b></small> ';
    } else {
        s +=    '                   <small class="mt-3 mb-0"><b>Second Semester</b></small> ';
    }
    s +=    '       <h3 class="mb-0"><b>S.Y. '+ data.sy_from +' - '+ data.sy_to +'</b></h3> ';
    if (data.is_active == 1) {
    s +=    '       <p class="t text-success mb-0">Active</p> ';
    }
    s +=    '     </div> ';
    s +=    '     <div class="card-body text-success"> ';
    s +=    '       <div class="d-flex mb-3">';
    s +=    '           <div class="d-flex justify-content-center flex-column mr-3  ">';
    s +=    '               <img src="/img/logo.jpg"  style="width: 100px; height: 100px" class="rounded-circle"/> ';
    s +=    '           </div> ';
    s +=    '           <div class="d-flex justify-content-center flex-column">';
    s +=    '               <p class="text-muted mb-0">Created by <b>'+ data.user.name +'</b></p> ';
    s +=    '               <small class="text-muted mb-0">'+ data.created_at +'</small> ';
    s +=    '           </div> ';
    s +=    '       </div> ';
    // if (data.is_active == 0) {
        if (data.is_active == 0) {
            s +=    '       <div class="card-footer bg-transparent border-warning px-0 pb-0 text-right d-flex justify-content-between"> ';
            s +=    '           <div class="d-flex justify-content-center flex-column"> ';
            s +=    '               <button class="remove-sy border-n badge rounded-pill badge-remove" id="removeSYRecord-'+ data.id +'" data-id="'+ data.id +'"><i class="fas fa-trash-alt"></i> <span>Delete</span></button> ';
            s +=    '           </div> ';
        } else {
            s +=    '       <div class="card-footer bg-transparent border-warning px-0 pb-0 text-right d-flex justify-content-end"> ';
        }
        s +=    '                <a class="select-sy btn btn-link m-0 text-reset text-deco-n" role="button" data-ripple-color="primary" id="proceedSYRecord-'+ data.id +'" data-id="'+ data.id +'">Proceed <i class="fas fa-arrow-right"></i></a>';
    // } 
    // else {
    //     s +=    '       <div class="card-footer bg-transparent border-warning px-0 pb-0 text-right d-flex justify-content-end"> ';
    //     s +=    '           <a class="select-sy btn btn-link m-0 text-reset text-deco-n" role="button" data-ripple-color="primary" id="proceedSYRecord-'+ data.id +'" data-id="'+ data.id +'">Proceed <i class="fas fa-arrow-right"></i></a>';
    // }
    
    s +=    '       </div> ';
    s +=    '     </div> ';
    s +=    ' </div> ';

    return s;
}

function initProceed(id) {
    $('#proceedSYRecord-'+ id).on('click', function() {
        localStorage.setItem('__schoolYear_selected', id);
        setCookie('__schoolYear_selected', id, 1);
        localStorage.setItem('current_page', 'dashboard');
        localStorage.setItem('submenu', BLANK);
        window.location.href = "/home";
    });
}

function initRemoveSY(id) {

    $('#removeSYRecord-'+ id).on('click', function() {
        bootbox.confirm({
            title: "Delete SY Record?",
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
                    trashSYRecord(id)
                }
            }
        });
    });
}

function trashSYRecord(id) {
    // WEB SERVICE CALL 
    $.ajax({
        url:        '/admin/schoolyear/trash',
        type:       'POST',
        dataType:   'json',
        headers:    {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data:   {
            id : id
        }
    }).then(function(data) {
        loadSchoolyearRecord();
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

$('#addNewSchoolYearRecord').on('click', function() {
    console.log('modal call');

    var min = new Date().getFullYear(),
    min1 = min;
    max = min + 20,
    $('#sySelectFromPicker').html(BLANK);

    for (var i = min1; i<=max; i++){
        var opt = document.createElement('option');
        opt.value = i;
        opt.innerHTML = i;
        $('#sySelectFromPicker').append(opt);
    }

    var min = new Date().getFullYear(),
    min1 = min+1;
    max = min + 20,
    $('#sySelectToPicker').html(BLANK);

    for (var i = min1; i<=max; i++){
        var opt = document.createElement('option');
        opt.value = i;
        opt.innerHTML = i;
        $('#sySelectToPicker').append(opt);
    }

    $('#addSchoolYearRecord').modal('toggle');
});



$('#sySelectToPicker').on('change', function () {
    if ($(this).val() == $('#sySelectFromPicker').val()) {
        $.toast({
            heading: 'Invalid year!',
            text: 'Year should not be same!',
            showHideTransition: 'plain',
            position: 'top-right',
            icon: 'warning'
        })
    }
});

$('#sySelectFromPicker').on('change', function () {
    if ($(this).val() == $('#sySelectToPicker').val()) {
        $.toast({
            heading: 'Invalid year!',
            text: 'Year should not be same!',
            showHideTransition: 'plain',
            position: 'top-right',
            icon: 'warning'
        })
    }
});



$('#saveNewSy').on('click', function() {

    if ($('#sySelectToPicker').val() == $('#sySelectFromPicker').val()) {
        $.toast({
            heading: 'Invalid year!',
            text: 'Year should not be same!',
            showHideTransition: 'plain',
            position: 'top-right',
            icon: 'warning'
        })
        return false;
    }
    // WEB SERVICE CALL 
    $.ajax({
        url:        '/admin/schoolyear/save',
        type:       'POST',
        dataType:   'json',
        headers:    {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data:   {
            syfrom: $('#sySelectFromPicker').val(),
            syto  : $('#sySelectToPicker').val(),
            semester : $('#sySemester').val()
        }
    }).then(function(data) {
        console.log('fetchUsers: ', data);
        loadSchoolyearRecord();
        $('#addSchoolYearRecord').modal('hide');

        if (data.status == 66) {
            customToaster('Failed to Add!', data.message, 'warning')
            resetStudentModal();
            $('#addStudentRecord').modal('hide');
            return false;
        }

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