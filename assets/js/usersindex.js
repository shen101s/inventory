$(document).ready(function() {
	'use strict';

    $('#l_users').addClass('active');

	$('#tbl_dt_usersindex').DataTable({
        'processing': true,
        'serverSide': true,
        'responsive':true,
        'autoWidth':false,
        'ajax': {
            'url': 'users/dtuserindex',
            error: function () {
                console.log('error');
            }
        },
        'stateSave': true,
        'columns': [
            { 'data': 'uname' },
            { 'data': 'fname' },
            { 'data': 'mname' },
            { 'data': 'lname' },
            { 'data': 'privilege' },
            { 'data': 'status' },
            { 'data': 'lid',
                "orderable": false,
                "searchable": false,
                "render": function(data,type,row,meta) {
                    var a = '<a href="javascript:void(0);" data-lid="'+row.lid+'" title="edit" name="edituser" ><i class="fa fa-edit"></i></a> ';
                    a += '<a href="javascript:void(0);" data-lid="'+row.lid+'" title="change password" name="editpassword" ><i class="fa fa-lock"></i></a>';
                    return a;
                } 
            }
        ]
    });

    $('#content-wrapper').on('click', '#user_add', function() {
        $('#m_i_title').html('Add User');
        $('.div-add').show(100);

        $('#m_lid').val('');
        $('#m_uname').val('');
        $('#m_pword').val('');
        $('#m_fname').val('');
        $('#m_mname').val('');
        $('#m_lname').val('');
        $('#m_privilege').val('');
        $('#m_status').val('');

        $('#modal_userindex').modal({
            backdrop: 'static',
            'keyboard': false
        });
    });


    $('#content-wrapper').on('click', 'a[name="edituser"]', function() {
        $('#m_i_title').html('Edit User');
        $('.div-add').hide(100);

        var lid = $(this).attr('data-lid');
        $('#m_lid').val(lid);

        $('#myspinner').show();
        $.get('users/useredit', {'lid':lid}, function(data){
            data = JSON.parse(data);

            $('#m_uname').val(data.res[0].uname);
            $('#m_pword').val('******');

            $('#m_fname').val(data.res[0].fname);
            $('#m_mname').val(data.res[0].mname);
            $('#m_lname').val(data.res[0].lname);
            $('#m_privilege').val(data.res[0].privilege);
            $('#m_status').val(data.res[0].status);

            $('#modal_userindex').modal({
                backdrop: 'static',
                'keyboard': false
            });     
        })
        .always(function() {
            $('#myspinner').hide();
        });
    });


    $('#content-wrapper').on('click', 'a[name="editpassword"]', function() {
        var lid = $(this).attr('data-lid');
        $('#m_pw_lid').val(lid);

        $('#modal_userpassword').modal({
            backdrop: 'static',
            'keyboard': false
        });
    });



    

});

