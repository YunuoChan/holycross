const BLANK = '';

$('#adminAddAccountsModalCall').on('click', function () {

    $('#accountsModalBtn').html(BLANK);
    $('#accountsModalBtn').append(btnModalElement('addAccountsBtn', 'Register'));
    // initAddAccounts();
    $('#addAdminAccountModal').modal('toggle');
});



$('#searchBtn-account').on('click', function () {
    loadAccounts();
});

$('#searchField-account').on('blur keyup', function () {
    loadAccounts();
});


/*---------------------------------

-----------------------------------*/
function loadAccounts() {

    var keyword = $('#searchField-account').val();
    // WEB SERVICE CALL 
    $.ajax({
        url:        '/admin/accounts/show',
        type:       'GET',
        dataType:   'json',
        headers:    {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data:   {
            keyword : keyword.trim()
        }
    }).then(function(data) {
        console.log('fetchACCOUNTS: ', data);
        $('#accountsTable').html(BLANK);
        if (data.userAccounts.length > 0) {
            data.userAccounts.forEach(function(account) {
                $('#accountsTable').append(tableElement(account, data.curUserId));
                initTrashAccount(account.id)
            })
        } else {
            $('#accountsTable').append(showNoDataTableAvalable());
        }
    }).fail(function(error) {
        console.log('Backend Error', error);
        internalServerError();
    });
}


/*---------------------------------

-----------------------------------*/
function tableElement(data, curUserId) {
    var elm = BLANK;
        elm += ' <tr> ';
        elm += '     <td class="vertical-center">'+ data.name +'</td> ';
        elm += '     <td class="vertical-center">'+ data.email +'</th> ';
        elm += '     <td class="vertical-center">'+ data.created_at +'</td> ';
        elm += '     <td class="vertical-center"> ';
        elm += '        <div class="d-flex justify-content-start">'
        if (curUserId != data.id) {
            elm += '         <button type="button" class="btn btn-danger" id="trashAccount-'+ data.id +'"><i class="fas fa-trash"></i></i>Delete</button> ';
        } else {
            elm += '         <small>You can\'t delete your account while logged on.</small> ';
        }
        
        elm += '        </div>'
        elm += '     </td> ';
        elm += ' </tr> ';
    return elm;
}



/*---------------------------------
    TRASH SECTION
-----------------------------------*/
function initTrashAccount(id) {
    $('#trashAccount-'+ id).on('click', function() {
        bootbox.confirm({
            title: "Delete Account?",
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
                    trashAccount(id)
                }
            }
        });
    });
}

/*---------------------------------

-----------------------------------*/
function trashAccount(id) {
    $.ajax({
        url:        '/admin/accounts/trash',
        type:       'POST',
        dataType:   'json',
        headers:    {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data:   {
            id : id
        }
    }).then(function(data) {
        loadAccounts();
    }).fail(function(error) {
        console.log('Backend Error', error);
        internalServerError();
    });
}