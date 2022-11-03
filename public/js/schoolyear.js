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
       // showError('Something went wrong');
    });
}

function syElement(data) {
    var s = '';
    if (data.is_active == 0) {
        s +=    ' <div class="col-md-5 justify-content-center"> ';
        s +=    '     <div class="m-2"> ';
    } else {
        s +=    ' <div class="d-flex justify-content-center"> ';
        s +=    '     <div class="w-50 mx-2"> '; 

    }
    s +=    '         <div class="card"> ';
        s +=    '         <div class="card-body"> ';
        s +=    '             <div class="d-flex justify-content-between"> ';
                    // {{-- SY INFO --}}
        s +=    '             <div class="d-flex align-items-center"> ';
        s +=    '                 <img src="/img/logo.jpg" alt="" style="width: 45px; height: 45px" class="rounded-circle"/> ';
        s +=    '                 <div class="ms-3"> ';
        s +=    '                 <h4 class="fw-bold mb-1"><b>S.Y. '+ data.sy_from +' - '+ data.sy_to +'</b></h4> ';
        s +=    '                  <p class="text-muted mb-0">Created by '+ data.user.name +'</p> ';
        s +=    '                 <small class="text-muted mb-0">'+ data.created_at +'</small> ';
        s +=    '                 </div> ';
        s +=    '             </div> ';
                    // {{-- REMOVE SY --}}
        s +=    '              <div class="d-flex justify-content-start flex-column"> ';
        if (data.is_active == 0) {
            s +=    '                 <button class="remove-sy border-n badge rounded-pill badge-remove" id="removeSYRecord-'+ data.id +'" data-id="'+ data.id +'"><i class="fas fa-trash-alt"></i></button> ';
        } else {
            s +=    '                 <span class="badge rounded-pill badge-success">Active</span> '; 
        }
        s +=    '             </div> ';
        s +=    '             </div> ';
        s +=    '         </div> ';
                    // {{--SY  BUTTON--}}
        s +=    '         <div class="card-footer border-0 bg-light p-2 d-flex justify-content-end"> ';
        s +=    '             <a class="select-sy btn btn-link m-0 text-reset text-deco-n" role="button" data-ripple-color="primary" id="proceedSYRecord-'+ data.id +'" data-id="'+ data.id +'">Proceed <i class="fas fa-arrow-right"></i></a> ';
        s +=    '         </div> ';
    s +=    '         </div> ';
    s +=    '     </div> ';
    s +=    ' </div> ';

    return s;
}

function initProceed(id) {
    $('#proceedSYRecord-'+ id).on('click', function() {
        localStorage.setItem('__schoolYear_selected', id);
        setCookie('__schoolYear_selected', id, 1);
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
    min1 = min-2;
    max = min + 20,
    $('#sySelectFromPicker').html(BLANK);

    for (var i = min1; i<=max; i++){
        var opt = document.createElement('option');
        opt.value = i;
        opt.innerHTML = i;
        $('#sySelectFromPicker').append(opt);
    }

    var min = new Date().getFullYear(),
    min1 = min-1;
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
            syto  : $('#sySelectToPicker').val()
        }
    }).then(function(data) {
        console.log('fetchUsers: ', data);
        loadSchoolyearRecord();
        $('#addSchoolYearRecord').modal('hide');
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