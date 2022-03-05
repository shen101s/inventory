$(document).ready(function() {
    $('#l_services').addClass('active');
    
	$('#tbl_dt_servindex').DataTable({
        'processing': true,
        'serverSide': true,
        'stateSave': true,
        'responsive':true,
        'autoWidth':false,
        'ajax': {
            'url': 'categories/dtservindex',
            error: function () {
                console.log('error');
            }
        },
        'columns': [
            { 'data': 'scode' },
            { 'data': 'sdescription' },
            { 'data': 'sstatus' },
            { 'data': 'sid',
                "orderable": false,
                "searchable": false,
                "render": function(data,type,row,meta) {
                    var a = '<a href="categories/details?qsid='+$.trim(row.sid)+'" title="Category details" name="detailservice"><i class="fa fa-location-arrow"></i></a>';
                    //a += ' | <a href="javascript:void(0);" data-sid="'+row.sid+'" title="edit service" name="editservice"><i class="fa fa-edit"></i></a>';
                    return a;
                } 
            }
        ]
    });

	$('#content-wrapper').on('click', '#serv_add', function() {
		$('#m_title').html('Add Service');
		$('#m_serv_sid').val('');

		$('#m_serv_code').val('');
		$('#m_serv_desc').val('');
		$('#m_serv_status').val('');


		$('#modal_servindex').modal({
			backdrop: 'static',
			'keyboard': false
		});
	});

	$('#content-wrapper').on('click', 'a[name="editservice"]', function() {
		$('#m_title').html('Edit Service');
		var sid = $(this).attr('data-sid');
		$('#m_serv_sid').val(sid);

		$('#myspinner').show();
        $.get('categories/editservice', {'sid':sid}, function(data){
            data = JSON.parse(data);
			$('#m_serv_code').val(data.res[0].scode);
			$('#m_serv_desc').val(data.res[0].sdescription);
			$('#m_serv_status').val(data.res[0].sstatus);
           	
          	$('#modal_servindex').modal({
				backdrop: 'static',
				'keyboard': false
			});  	
        })
        .always(function() {
            $('#myspinner').hide();
        });
	});

	
	
});
