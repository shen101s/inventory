$(document).ready(function() {
	'use strict';

    $('#l_employees').addClass('active');

	$('#tbl_dt_empindex').DataTable({
        'processing': true,
        'serverSide': true,
        'responsive':true,
        'autoWidth':false,
        'ajax': {
            'url': 'employees/dtempindex',
            error: function () {
                console.log('error');
            }
        },
        'stateSave': true,
        'columns': [
            { 'data': 'efname' },
            { 'data': 'emname' },
            { 'data': 'elname' },
            { 'data': 'eposition' },
            { 'data': 'estatus' },
            { 'data': 'empid',
                "orderable": false,
                "searchable": false,
                "render": function(data,type,row,meta) {
                    var a = '<a href="javascript:void(0);" data-empid="'+row.empid+'" title="edit" name="editemp" ><i class="fa fa-edit"></i></a>';
                    return a;
                } 
            }
        ]
    });

    $('#content-wrapper').on('click', '#emp_add', function() {
        $('#m_i_title').html('Add Employee');
        $('#m_empid').val('');
        $('#m_efname').val('');
        $('#m_emname').val('');
        $('#m_elname').val('');
        $('#m_eposition').val('');
        $('#m_estatus').val('');

        $('#modal_empindex').modal({
            backdrop: 'static',
            'keyboard': false
        });
    });


    $('#content-wrapper').on('click', 'a[name="editemp"]', function() {
        $('#m_i_title').html('Edit Employee');
        var empid = $(this).attr('data-empid');
        $('#m_empid').val(empid);

        $('#myspinner').show();
        $.get('employees/empedit', {'empid':empid}, function(data){
            data = JSON.parse(data);

            $('#m_efname').val(data.res[0].efname);
            $('#m_emname').val(data.res[0].emname);
            $('#m_elname').val(data.res[0].elname);
            $('#m_eposition').val(data.res[0].eposition);
            $('#m_estatus').val(data.res[0].estatus);

            $('#modal_empindex').modal({
                backdrop: 'static',
                'keyboard': false
            });     
        })
        .always(function() {
            $('#myspinner').hide();
        });
    });

});

