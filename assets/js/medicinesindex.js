$(document).ready(function() {
	//$('#tbl_dt_medindexprice').DataTable();

	$('#m_med_libdexp').datepicker({ format: 'M dd, yyyy' });
	$('#tbl_dt_medindex').DataTable({
        'processing': true,
        'serverSide': true,
        'stateSave': true,
        'responsive':true,
        'autoWidth':false,
        'ajax': {
            'url': 'medicines/dtmedindex',
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


	$('#content-wrapper').on('click', '#med_addmed', function() {
		$('#m_i_title').html('Add Medicine');
		$('#m_med_libid').val('');
		/*$('#m_med_libcodename').val('');*/
		$('#m_med_libdesc').val('');
		$('#m_med_libstatus').val('');

		$('#modal_medindex').modal({
			backdrop: 'static',
			'keyboard': false
		});
	});


	$('#content-wrapper').on('click', 'a[name="editmed"]', function() {
		$('#m_i_title').html('Edit Medicine');
		var libid = $(this).attr('data-libid');
		$('#m_med_libid').val(libid);

		$('#myspinner').show();
        $.get('medicines/mededit', {'libid':libid}, function(data){
            data = JSON.parse(data);
            /*console.log(data);
			$('#m_med_libcodename').val(data.res[0].libcodename);*/
			$('#m_med_libdesc').val(data.res[0].libdesc);
			$('#m_med_libstatus').val(data.res[0].libstatus);
           	
          	$('#modal_medindex').modal({
				backdrop: 'static',
				'keyboard': false
			});  	
        })
        .always(function() {
            $('#myspinner').hide();
        });
	});

	$('#content-wrapper').on('click', 'a[name="select"]', function() {
		$('#div_ind_price').show(100);
		var libid = $.trim($(this).attr('data-libid'));
		$('#med_indlibid').val(libid);

		var medname = $(this).closest('tr').find('td:eq(0)').text() + ' (' + $(this).closest('tr').find('td:eq(1)').text() + ')';
		$('#med_indprice').html(medname);

		dtmedprice(libid);
	});

	

	/** price */
	$('#content-wrapper').on('click', '#med_addprice', function() {
		$('#m_i_titleprice').html('Add Price');
		$('#m_med_libid_price').val($.trim($('#med_indlibid').val()));

		$('#m_med_libdid').val('');
		$('#m_med_unit').val('');
		$('#m_med_libdprice').val('');
		$('#m_med_libdqty').val('');
		$('#m_med_libdexp').val('');
		$('#m_med_libdstatus').val('');
		

		$('#modal_medindexprice').modal({
			backdrop: 'static',
			'keyboard': false
		});
	});


	$('#content-wrapper').on('click', 'a[name="editprice"]', function() {
		$('#m_i_titleprice').html('Edit Price');
		var libdid = $.trim($(this).attr('data-libdid'));
		var libid = $.trim($('#med_indlibid').val());

		$('#myspinner').show();
        $.get('medicines/mededitprice', {'libdid': libdid}, function(data){
            data = JSON.parse(data);

            $('#m_med_libid_price').val(libid);
			$('#m_med_libdid').val(libdid);

			var libdexp = data.res[0].libdexp;
			$('#m_med_libdexp').datepicker({ format: 'M dd, yyyy' }).datepicker("setDate", new Date(libdexp));

			$('#m_med_unit').val(data.res[0].unitid);
			$('#m_med_libdprice').val(data.res[0].libdprice);
			$('#m_med_libdqty').val(data.res[0].libdqty);
			$('#m_med_libdstatus').val(data.res[0].libdstatus);


            $('#modal_medindexprice').modal({
				backdrop: 'static',
				'keyboard': false
			});
        })
        .always(function() {
            $('#myspinner').hide();
        });


		/*$('#m_med_libid_price').val($.trim($('#med_indlibid').val()));
		$('#m_med_libdid').val('');

		$('#m_med_unit').val('');
		$('#m_med_libdprice').val('');
		$('#m_med_libdqty').val('');
		$('#m_med_libdexp').val('');
		$('#m_med_libdstatus').val('');
		

		$('#modal_medindexprice').modal({
			backdrop: 'static',
			'keyboard': false
		});*/
	});

	


	


	var dtmedprice = function(libid) {
		$('#myspinner').show();
		$('#tbl_dt_medindexprice').DataTable({
	        'processing': true,
	        'serverSide': true,
	        'destroy': true,
	        'stateSave': true,

	        'responsive':true,
        	'autoWidth':false,
	        'ajax': {
	            'url': 'medicines/dtmedindexprice',
	            data: function (d) {
	            	d.libid = libid;
	            },
            	error: function () {
	                console.log('error');
	        	}
	        },
	        'columns': [
	            { 'data': 'unitdesc' },
	            { 'data': 'libdprice' },
	            { 'data': 'libdqty' },
	            { 'data': 'libdqtyrem' },
	            { 'data': 'libdexp' },
	            { 'data': 'libdstatus' },
	            { 'data': 'libdid',
	                "orderable": false,
	                "searchable": false,
	                "render": function(data,type,row,meta) {
	                    var a = '<a href="javascript:void(0);" data-libdid="'+row.libdid+'" title="edit" name="editprice" class="btn btn-warning btn-xs">edit</a>';
	                    return a;
	                } 
	            }
	        ],
        	initComplete:function( settings, json){
	        	$('#myspinner').hide();
	        }
	    });
	};

});
