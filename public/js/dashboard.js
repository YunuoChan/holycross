

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
    var elm = BLANK;
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
    
    var s = BLANK;

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