$(document).ready(function() {
	'use strict';

	$('#m_med_libdexp').datepicker({ format: 'M dd, yyyy' });
	$('#tbl_dt_medindex').DataTable({
        'processing': true,
        'serverSide': true,
        'stateSave': true,
        'responsive':true,
        'autoWidth':false,
        'ajax': {
            'url': 'supplies/dtsuppindex',
            error: function () {
                console.log('error');
            }
        },
        'columns': [
            { 'data': 'libdesc' },
            { 'data': 'libstatus' },
            { 'data': 'libid',
                "orderable": false,
                "searchable": false,
                "render": function(data,type,row,meta) {
                    var a = '<a href="javascript:void(0);" data-libid="'+row.libid+'" title="select" name="select" class="btn btn-primary btn-xs">select</a> ';
                    a += '<a href="javascript:void(0);" data-libid="'+row.libid+'" title="edit" name="editmed" class="btn btn-warning btn-xs">edit</a>';
                    return a;
                } 
            }
        ]
    });
});
