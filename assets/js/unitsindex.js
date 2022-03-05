$(document).ready(function() {
	'use strict';

    $('#l_unit').addClass('active');

	$('#tbl_dt_unitindex').DataTable({
        'responsive':true,
        'autoWidth':false,
        'processing': true,
        'serverSide': true,
        'stateSave': true,
        'ajax': {
            'url': 'unit/dtunitindex',
            error: function () {
                console.log('error');
            }
        },
        'columns': [
            { 'data': 'unitcode' },
            { 'data': 'unitdesc' },
            { 'data': 'unitstatus' },
            { 'data': 'unitid',
                "orderable": false,
                "searchable": false,
                "render": function(data,type,row,meta) {
                    var a = '<a href="javascript:void(0);" data-unitid="'+row.unitid+'" title="edit" name="editunit"><i class="fa fa-edit"></i></a>';
                    return a;
                } 
            }
        ]
    });

	
	$('#content-wrapper').on('click', '#unit_add', function() {
		$('#m_i_title').html('Add Unit');
		$('#m_unitid').val('');
		$('#m_unitcode').val('');
		$('#m_unitdesc').val('');
		$('#m_unitstatus').val('');

		$('#modal_unitindex').modal({
			backdrop: 'static',
			'keyboard': false
		});
	});


	$('#content-wrapper').on('click', 'a[name="editunit"]', function() {
		$('#m_i_title').html('Edit Unit');
		var unitid = $(this).attr('data-unitid');
		$('#m_unitid').val(unitid);

		$('#myspinner').show();
        $.get('unit/unitedit', {'unitid':unitid}, function(data){
            data = JSON.parse(data);

           	$('#m_unitcode').val(data.res[0].unitcode);
			$('#m_unitdesc').val(data.res[0].unitdesc);
			$('#m_unitstatus').val(data.res[0].unitstatus);

          	$('#modal_unitindex').modal({
				backdrop: 'static',
				'keyboard': false
			});  	
        })
        .always(function() {
            $('#myspinner').hide();
        });
	});
});
