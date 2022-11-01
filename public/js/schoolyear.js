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
        $('#recordListSY').html('');
        data.schoolyears.forEach(schoolyear => {
            if (schoolyear.is_active == 0) {
                $('#recordListSY').append(syElement(schoolyear));
            } else {
                $('#activeSY').html('');
                $('#activeSY').append(syElement(schoolyear));
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
        s +=    '                 <h4 class="fw-bold mb-1"><b>S.Y. '+ data.sy_from +' - '+ data.sy_from +'</b></h4> ';
        s +=    '                  <p class="text-muted mb-0">Created by '+ data.user.name +'</p> ';
        s +=    '                 <small class="text-muted mb-0">'+ data.created_at +'</small> ';
        s +=    '                 </div> ';
        s +=    '             </div> ';
                    // {{-- REMOVE SY --}}
        s +=    '              <div class="d-flex justify-content-start flex-column"> ';
        if (data.is_active == 0) {
            s +=    '                 <button class="remove-sy border-n badge rounded-pill badge-remove" data-id="'+ data.id +'"><i class="fas fa-trash-alt"></i></button> ';
        } else {
            s +=    '                 <span class="badge rounded-pill badge-success">Active</span> '; 
        }
        s +=    '             </div> ';
        s +=    '             </div> ';
        s +=    '         </div> ';
                    // {{--SY  BUTTON--}}
        s +=    '         <div class="card-footer border-0 bg-light p-2 d-flex justify-content-end"> ';
        s +=    '             <a class="select-sy btn btn-link m-0 text-reset text-deco-n" role="button" data-ripple-color="primary" data-id="'+ data.id +'">Proceed <i class="fas fa-arrow-right"></i></a> ';
        s +=    '         </div> ';
    s +=    '         </div> ';
    s +=    '     </div> ';
    s +=    ' </div> ';

    return s;
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

    }
});

$('#sySelectFromPicker').on('change', function () {
    if ($(this).val() == $('#sySelectToPicker').val()) {

    }
});



$('#saveNewSy').on('click', function() {

    if ($('#sySelectToPicker').val() == $('#sySelectFromPicker').val()) {
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

    }).fail(function(error) {
        console.log('Backend Error', error);
    // showError('Something went wrong');
    });
});