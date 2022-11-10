

function selectDashboardMenu(selected) {

    $('li[name="dashboard-menu"]').each(function() {
        $(this).removeClass('active');
    });

    $('#li-'+ selected).addClass('active');

    localStorage.setItem('current_page', selected);
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
        icon: 'success'
    })
}

function successDelete() {
    $.toast({
        heading: 'Delete Success!',
        text: 'Record successfully deleted!',
        showHideTransition: 'slide',
        icon: 'success'
    })
}

function successSave() {
    $.toast({
        heading: 'Save Success!',
        text: 'Record successfully saved!',
        showHideTransition: 'slide',
        icon: 'success'
    })
}