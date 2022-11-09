


function selectDashboardMenu(selected) {

    $('li[name="dashboard-menu"]').each(function() {
        $(this).removeClass('active');
    });

    $('#li-'+ selected).addClass('active');

    localStorage.setItem('current_page', selected);
}