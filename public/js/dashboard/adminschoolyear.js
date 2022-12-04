const BLANK = '';



$('#addSchoolyearModalCall').on('click', function () {
    
    var min = new Date().getFullYear();
    min1 = min;
    max = min + 20,
    $('#sySelectFromPicker').html(BLANK);

    for (var i = min1; i<=max; i++){
        var opt = document.createElement('option');
        opt.value = i;
        opt.innerHTML = i;
        $('#sySelectFromPicker').append(opt);
    }

    var min = new Date().getFullYear();
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
        successSave();
    }).fail(function(error) {
        console.log('Backend Error', error);
        internalServerError();
    });
});



function loadSchoolyearRecordAdmin() {
    // WEB SERVICE CALL 
    $.ajax({
        url:        '/admin/schoolyear/get',
        type:       'GET',
        dataType:   'json',
        headers:    {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        // data:   {
        
        // }
    }).then(function(data) {
        console.log('fetchAdminSchoolyearTable: ', data);
        $('#adminSchoolyearTable').html(BLANK);
        $('#activeSchoolyearDiv').html(BLANK);
        if (data.schoolyears.length > 0) {
            data.schoolyears.forEach(schoolyear => {

                if (localStorage.getItem('__schoolYear_selected') != schoolyear.id) {
                    $('#adminSchoolyearTable').append(tableElement(schoolyear));
                    var activeSY = 'S.Y. '+ schoolyear.sy_from +' - '+ schoolyear.sy_to;
                    initSetActiveSy(schoolyear.id, activeSY);
                    initTrashSy(schoolyear.id)
                }
                    
                if (schoolyear.is_active == 1) {
                    var activeSY = 'S.Y. '+ schoolyear.sy_from +' - '+ schoolyear.sy_to;
                    $('#activeSchoolyearDiv').html(BLANK);
                    $('#activeSchoolyearDiv').append(syElement(schoolyear));
                    $('#activeSYSidebar').text(activeSY);
                    $('#activeSYSidebarIndicator').show();
                }
            });
        } 
        
        

    }).fail(function(error) {
        console.log('Backend Error', error);
        internalServerError();
    });
}



/*---------------------------------

-----------------------------------*/
function tableElement(data) {
    var elm = BLANK;
        elm += ' <tr> ';
        elm += '     <td class="vertical-center">'+ data.sy_from +' - '+ data.sy_to +'</td> ';
        if (data.semester == 1) {
            elm += '     <td class="vertical-center">First Semester</td> ';
        } else {
            elm += '     <td class="vertical-center">Second Semester</td> ';
        }
        elm += '     <td class="vertical-center">'+ data.user.name +'</td> ';
        elm += '     <td class="vertical-center">'+ data.created_at +'</td> ';
        elm += '     <td class="vertical-center">'+ data.status +'</td> ';
        elm += '     <td class="vertical-center"> ';
        var cur = new Date().getFullYear();
        if (parseInt(cur) < parseInt(data.sy_to)) {
            elm += '        <div class="d-flex justify-content-start">'
            if (data.status == 'ACT') {
                elm += '         <button type="button" class="btn btn-success mx-1" id="setActiveSchoolyear-'+ data.id +'"><i class="fas fa-edit"></i>Set As Active</button> ';
                // if (localStorage.getItem('__schoolYear_selected') != data.id) {
                    elm += '         <button type="button" class="btn btn-danger" id="trashSchoolyear-'+ data.id +'"><i class="fas fa-trash"></i></i>Delete</button> ';
                // }
            }
            elm += '        </div>'
        }
        elm += '     </td> ';
        elm += ' </tr> ';
    return elm;
}



function syElement(data) {

    var s = '';
    s +=    ' <div class="card border-success mb-3" style="max-width: 18rem;"> ';
    s +=    '     <div class="card-header"> ';
    s +=    '       <h3 class="mb-0"><b>'+ data.sy_from +' - '+ data.sy_to +'</b></h3> ';
    s +=    '       <small class="mb-3">Schoolyear</small> ';
    s +=    '     </div> ';
    s +=    '     <div class="card-body text-success"> ';
    s +=    '           <div class="d-flex justify-content-center">';
    s +=    '               <img src="/img/logo.jpg"  style="width: 100px; height: 100px" class="rounded-circle"/> ';
    s +=    '           </div> ';
    s +=    '           <div>';
    s +=    '               <div class="d-flex justify-content-center">';
    if (data.semester == 1) {
        s +=    '                   <h4 class="text-muted mb-0"><b>First Semester</b></h4> ';
    } else {
        s +=    '                   <h4 class="text-muted mb-0"><b>Second Semester</b></h4> ';
    }
    s +=    '               </div> ';
    s +=    '               <div class="d-flex justify-content-center">';
    s +=    '                   <p class="text-muted mb-0"><b>'+ data.user.name +'</b></p> ';
    s +=    '               </div> ';
    s +=    '               <div class="d-flex justify-content-center">';
    s +=    '                   <small class="text-muted mb-0">'+ data.created_at +'</small> ';
    s +=    '               </div> ';
    if (data.is_active == 1) {
        s +=    '               <div class="d-flex justify-content-center">';
        s +=    '                   <p class="text-success mb-0">Active</p> ';
        s +=    '               </div> ';
        }
    
    s +=    '           </div> ';
    
    s +=    '     </div> ';
    s +=    ' </div> ';

    return s;
}



function initSetActiveSy(id, sy) {
    $('#setActiveSchoolyear-'+ id).on('click', function () {
        bootbox.confirm({
            title: "Updtate Active Schoolyear?",
            message: "Changing the active record will delete the previously active. Are you sure you want to change the active schoolyear?",
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
                    setActiveSy(id, sy)
                }
            }
        });
    });
}

function setActiveSy(id, sy) {
    $.ajax({
        url:        '/admin/manage/schoolyear/setactive',
        type:       'POST',
        dataType:   'json',
        headers:    {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data:   {
            id : id
        }
    }).then(function(data) {
        loadSchoolyearRecord();
        $('#activeSYSidebar').text(sy);
        $('#activeSYSidebarIndicator').show();
        successUpdate();
        
    }).fail(function(error) {
        console.log('Backend Error', error);
        internalServerError();
    });
}


function initTrashSy(id) {
    $('#trashSchoolyear-'+ id).on('click', function () {
        bootbox.confirm({
            title: "Delete Schoolyear Record?",
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
                    deleteSy(id)
                }
            }
        });
    });
}


function deleteSy(id) {
    $.ajax({
        url:        '/admin/manage/schoolyear/trash',
        type:       'POST',
        dataType:   'json',
        headers:    {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data:   {
            id : id
        }
    }).then(function(data) {
        localStorage.setItem('__schoolYear_selected', id);
        setCookie('__schoolYear_selected', id, 1);
        loadSchoolyearRecord();
        successUpdate();
        
    }).fail(function(error) {
        console.log('Backend Error', error);
        internalServerError();
    });
}