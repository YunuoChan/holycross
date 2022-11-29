

function selectDashboardMenu(selected, submenu = null) {

    $('li[name="dashboard-menu"]').each(function() {
        $(this).removeClass('active');
    });

    $('#li-'+ selected).addClass('active');

    localStorage.setItem('current_page', selected);
    localStorage.setItem('submenu', submenu);

    if (submenu) {
        $('#'+ selected +'Submenu').addClass('show');
        $('li#li-'+ submenu +'-submenu').addClass('active-white');
    }
}


function btnModalElement(id, verbiage) {
    var elm = '';
        elm += ' <button type="button" class="btn btn-primary px-4" id="'+ id +'">'+ verbiage +'</button>';

    return elm;
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

function successUpdate() {
    $.toast({
        heading: 'Update Success!',
        text: 'Record successfully updated!',
        showHideTransition: 'slide',
        position: 'top-right',
        icon: 'success'
    })
}

function successDelete() {
    $.toast({
        heading: 'Delete Success!',
        text: 'Record successfully deleted!',
        showHideTransition: 'slide',
        position: 'top-right',
        icon: 'success'
    })
}

function successSave() {
    $.toast({
        heading: 'Save Success!',
        text: 'Record successfully saved!',
        showHideTransition: 'slide',
        position: 'top-right',
        icon: 'success'
    })
}


function customToaster(heading, text, icon) {
    $.toast({
        heading: heading,
        text: text,
        showHideTransition: 'slide',
        position: 'top-right',
        icon: icon
    })
}


function openDropdown(page) {

    if ($('#'+ page +'Submenu').hasClass('show')) {
        $('#'+ page +'Submenu').removeClass('show');
        
    } else {
        $('#'+ page +'Submenu').addClass('show');
    }
}

function showNoDataAvalable() {
    
    var s = '';

    s+= '<div class="d-flex justify-content-center">';  
    s+= '<tr>';  
	s+= '   <td colspan="100%">';
	s+= '	    <div id="noRecordContainer">';
	s+= '	    	<div class="d-flex flex-row justify-content-center">';
	s+= '	    		<div style="font-size: 5em;">';
	s+= '	    			<i class="fas fa-box-open"></i> ';
	s+= '	    		</div>';
	s+= '	    	</div>';
	s+= '	    	<div class="d-flex flex-row justify-content-center">';
	s+= '	    		<div> No record found...';
	s+= '	    		</div>';
	s+= '	    	</div>';
	s+= '	    </div>';
	s+= '   </td>';
	s+=	'</tr>';
    s+= '</div>';  

    return s;
}


function showNoDataTableAvalable() {
    
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
	s+= '	    		<div> No record found...';
	s+= '	    		</div>';
	s+= '	    	</div>';
	s+= '	    </div>';
	s+= '   </td>';
	s+=	'</tr>';

    return s;
}


//define a function to set cookies
function setCookie(name,value,days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days*24*60*60*1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "")  + expires + "; path=/";
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
        console.log('fetchAdminSchoolyearTable ____: ', data);
        if (data.schoolyears.length > 0) {
            var activeCount = 0;
            $('#schoolyearListOnModal').html('');
            data.schoolyears.forEach(function(schoolyear) {
                if (schoolyear.is_active == 0) {
                    if (schoolyear.id != localStorage.getItem('__schoolYear_selected')) {
                        $('#schoolyearListOnModal').append(appendSchoolyearElement(schoolyear));
                        initSwitchSY(schoolyear.id)
                    } 
                
                    if (schoolyear.id == localStorage.getItem('__schoolYear_selected')) {
                        $('#currentSYToModal').text('S.Y. '+ schoolyear.sy_from + ' - ' + schoolyear.sy_to);
                    }
                } else {
                    $('#activeSYToModal').text('S.Y. '+ schoolyear.sy_from + ' - ' + schoolyear.sy_to);
                }
            });
        } 
    }).fail(function(error) {
        console.log('Backend Error', error);
        internalServerError();
    });
}



function appendSchoolyearElement(data) {
    console.log(data);
    var elm = '';
        elm += ' <a id="schoolyear-'+ data.id +'" class="list-group-item list-group-item-action list-group-item-info d-flex justify-content-between"> ';
        elm += '     <div class="d-flex justify-content-center flex-column"> ';
        elm += '        <div> ';
        elm += '            <label class="mb-0"><strong>S.Y. '+ data.sy_from +' - '+ data.sy_to +'</strong></label> ';
        elm += '        </div> ';
        elm += '        <small>'+ data.user.name +'</small>';
        // elm += '        <small>'+ data[2] +'</small>';
        elm += '     </div> ';
        elm += '     <div class="d-flex justify-content-center flex-column"> ';
        elm += '        <button type="button" class="btn btn-danger" id="switchSchoolYearTo-'+ data.id +'">Switch</button> ';
        elm += '     </div> ';
        elm += ' </a> ';

    return elm;
}

function initSwitchSY(id) {
    $('#switchSchoolYearTo-'+ id).on('click', function () {
        localStorage.setItem('__schoolYear_selected', id);
        setCookie('__schoolYear_selected', id, 1);
        location.reload();
    })
    
}

function loadSchoolyearRecordToEdit() {
    // WEB SERVICE CALL 
    $.ajax({
        url:        '/admin/schoolyear/get/edit',
        type:       'GET',
        dataType:   'json',
        headers:    {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        // data:   {
        
        // }
    }).then(function(data) {
        console.log('fetchAdminSchoolyearTable: ', data);
        $('#selectSYDashboradSidebar').text('S.Y. '+data.schoolyearEdit.sy_from +' - ' +  data.schoolyearEdit.sy_to);

    }).fail(function(error) {
        console.log('Backend Error', error);
        internalServerError();
    });
}


function initOncallModalSwitch() {
    $('#swictSchoolyearCallModal').on('click', function () {

        loadSchoolyearRecordActive();
        $('#switchSchoolYearModal').modal('toggle');
    });
}


