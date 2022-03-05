$(document).ready(function() {
	'use strict';
	$('#l_services').addClass('active');
	
	$('#m_serv_libdexp').datepicker({ format: 'M dd, yyyy' });

    var servindex = function(sid) {
		$('#myspinner').show();
		$('#tbl_dt_servindex').DataTable({
	        'processing': true,
	        'serverSide': true,
	        'stateSave': true,
	        'responsive':true,
        	'autoWidth':false,
	        'ajax': {
	            'url': 'dtservdetails',
	            data: function (d) {
	            	d.sid = sid;
	            },
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
	                    var a = '<a href="javascript:void(0);" data-libid="'+row.libid+'" title="select" name="select"><i class="fa fa-location-arrow"></i></a> ';
	                    a += '<a href="javascript:void(0);" data-libid="'+row.libid+'" title="edit" name="editservdetails"><i class="fa fa-edit"></i></a>';
	                    return a;
	                } 
	            }
	        ]
	        ,
        	initComplete:function( settings, json){
	        	$('#myspinner').hide();
	        }
	    });
	};

	servindex($('#hiddensid').val());



	var dtmedprice = function(libdescid) {
		$('#myspinner').show();
		$('#tbl_dt_servindexprice').DataTable({
	        'processing': true,
	        'serverSide': true,
	        'destroy': true,
	        'stateSave': true,
	        'responsive':true,
        	'autoWidth':false,
        	'scrollX': true,
	        'ajax': {
	            'url': 'dtservindexprice',
	            data: function (d) {
	            	d.libdescid = libdescid;
	            },
            	error: function () {
	                console.log('error');
	        	}
	        },
	        'columns': [
	        	{ 'data': 'libdbarcode',
	                "render": function(data,type,row,meta) {
	                    var a = '<a href="javascript:void(0);" data-libdbarcode="'+row.libdbarcode+'" title="barcode" name="printbarcode">'+row.libdbarcode+'</a>';
	                    return a;
	                } 
	            },
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
	                    var a = '<a href="javascript:void(0);" data-libdid="'+row.libdid+'" title="edit" name="editprice"><i class="fa fa-edit"></i></a> ';
	                    a += '<a href="javascript:void(0);" data-libdbarcode="'+row.libdbarcode+'" data-libdid="'+row.libdid+'" title="Stock card" name="stockcard"><i class="fa fa-archive"></i></a>';
	                    return a;
	                } 
	            }
	        ],
        	initComplete:function( settings, json){
	        	$('#myspinner').hide();
	        }
	    });
	};


	var dtmeddesc = function(libid) {
		$('#myspinner').show();
		$('#tbl_dt_servindexdesc').DataTable({
	        'processing': true,
	        'serverSide': true,
	        'destroy': true,
	        'stateSave': true,
	        'responsive':true,
        	'autoWidth':false,
        	'scrollX': true,
	        'ajax': {
	            'url': 'dtservindexdesc',
	            data: function (d) {
	            	d.libid = libid;
	            },
            	error: function () {
	                console.log('error');
	        	}
	        },
	        'columns': [
	        	{ 'data': 'libdescitem' },
	            { 'data': 'libdescstatus' },
	            { 'data': 'libdescid',
	                "orderable": false,
	                "searchable": false,
	                "render": function(data,type,row,meta) {
	                	var a = '<a href="javascript:void(0);" data-libdescid="'+row.libdescid+'" title="select" name="selectdesc"><i class="fa fa-location-arrow"></i></a> ';
	                    a += '<a href="javascript:void(0);" data-libdescid="'+row.libdescid+'" title="edit" name="editdesc"><i class="fa fa-edit"></i></a>';
	                    return a;
	                } 
	            }
	        ],
        	initComplete:function( settings, json){
	        	$('#myspinner').hide();
	        }
	    });
	};



	$('#content-wrapper').on('click', 'a[name="select"]', function() {
		$('#divdesc').show(100);
		$('#divprice').hide(100);

		var libid = $.trim($(this).attr('data-libid'));
		$('#serv_indlibid_desc').val(libid);

		var medname = $(this).closest('tr').find('td:eq(0)').text() + ' (' + $(this).closest('tr').find('td:eq(1)').text() + ')';
		$('#serv_inddesc').html(medname);

		dtmeddesc(libid);
	});


	$('#content-wrapper').on('click', '#serv_adddesc', function() {
		$('#m_i_titledesc').html('Add Description of ' + $('#serv_inddesc').text());
		$('#m_serv_libid_desc').val($.trim($('#serv_indlibid_desc').val()));
		$('#m_serv_libdescid').val('');
		$('#m_serv_libdescitem').val('');
		$('#m_serv_libdescstatus').val('1');

		$('#modal_servindexdesc').modal({
			backdrop: 'static',
			'keyboard': false
		});
	});



	/*save description*/
	$('#modal_servindexdesc').on('click', '#m_serv_detailssave_desc', function() {
		$('#myspinner').show();
        $.get('servdetailssavedesc', $('#m_form_saveservicesdesc').serialize(), function(data){
            data = JSON.parse(data);
            if (data) {
            	var libid = $('#m_serv_libid_desc').val();
            	dtmeddesc(libid);
            } else {
            	Swal.fire({icon: 'error', title: 'Oops...', text: 'Something went wrong!'})
            }
        })
        .always(function() {
        	$('#modal_servindexdesc').modal('hide');
            $('#myspinner').hide();
        });
	});


	/*edit description*/
	$('#content-wrapper').on('click', 'a[name="editdesc"]', function() {
		$('#m_i_titledesc').html('Edit Description of ' + $('#serv_inddesc').text());

		var libdescid = $(this).attr('data-libdescid');
		$('#m_serv_libdescid').val(libdescid);

		$('#myspinner').show();
        $.get('servdescedit', {'libdescid':libdescid}, function(data){
            data = JSON.parse(data);

           	$('#m_serv_libid_desc').val(data.res[0].libid);
			$('#m_serv_libdescitem').val(data.res[0].libdescitem);
			$('#m_serv_libdescstatus').val(data.res[0].libdescstatus);

          	$('#modal_servindexdesc').modal({
				backdrop: 'static',
				'keyboard': false
			});  	
        })
        .always(function() {
            $('#myspinner').hide();
        });
	});



	/*start price*/
	$('#content-wrapper').on('click', 'a[name="selectdesc"]', function() {
		$('#divprice').show(100);
		$('#div_ind_price').show(100);
		var libdescid = $.trim($(this).attr('data-libdescid'));
		$('#serv_indlibdescid').val(libdescid);

		var medname = $('#serv_inddesc').text() + ' ' + $(this).closest('tr').find('td:eq(0)').text() + ' (' + $(this).closest('tr').find('td:eq(1)').text() + ')';
		$('#serv_indprice').html(medname);

		dtmedprice(libdescid);
	});
	/*end price*/



	//delete below









	


	$('#content-wrapper').on('click', '#serv_adddetail', function() {
		$('#m_i_title').html('Add');
		$('#m_serv_libid').val('');
		$('#m_serv_libdesc').val('');
		$('#m_serv_libstatus').val('1');

		$('#modal_servindex').modal({
			backdrop: 'static',
			'keyboard': false
		});
	});


	/*save services*/
	$('#modal_servindex').on('click', '#m_serv_detailssave', function() {
		$('#myspinner').show();
        $.post('servdetailssave', $('#m_form_saveservices').serialize(), function(data){
            data = JSON.parse(data);
            if (data) {
            	location.reload();
            } else {
            	Swal.fire({icon: 'error', title: 'Oops...', text: 'Something went wrong!'})
            }
        })
        .always(function() {
            $('#myspinner').hide();
        });
	});

	/*edit services*/
	$('#content-wrapper').on('click', 'a[name="editservdetails"]', function() {
		$('#m_i_title').html('Edit');
		var libid = $(this).attr('data-libid');
		$('#m_serv_libid').val(libid);

		$('#myspinner').show();
        $.get('servdetailsedit', {'libid':libid}, function(data){
            data = JSON.parse(data);
			$('#m_serv_libdesc').val(data.res[0].libdesc);
			$('#m_serv_libstatus').val(data.res[0].libstatus);
           	
          	$('#modal_servindex').modal({
				backdrop: 'static',
				'keyboard': false
			});  	
        })
        .always(function() {
            $('#myspinner').hide();
        });
	});



	/** price */
	$('#content-wrapper').on('click', '#serv_addprice', function() {
		$('#m_i_titleprice').html('Add Price of ' + $('#serv_indprice').text());
		$('#m_serv_libdescid_price').val($.trim($('#serv_indlibdescid').val()));

		$('#m_serv_libdbarcode').val('');
		$('#m_serv_libdid').val('');
		$('#m_serv_unit').val('');
		$('#m_serv_libdprice').val('');
		$('#m_serv_libdqty').val('');
		$('#m_serv_libdexp').val('');
		$('#m_serv_libdstatus').val('1');
		

		$('#modal_servindexprice').modal({
			backdrop: 'static',
			'keyboard': false
		});
	});

	$('#content-wrapper').on('click', 'a[name="editprice"]', function() {
		$('#m_i_titleprice').html('Edit Price');

		var libdid = $(this).attr('data-libdid');
		$('#m_serv_libdid').val(libdid);

		$('#myspinner').show();
        $.get('servpriceedit', {'libdid':libdid}, function(data){
            data = JSON.parse(data);
           
           	$('#m_serv_libdbarcode').val(data.res[0].libdbarcode);
			$('#m_serv_unit').val(data.res[0].unitid);
			$('#m_serv_libdprice').val(data.res[0].libdprice);
			$('#m_serv_libdqty').val(data.res[0].libdqty);
			$('#m_serv_libdexp').val(data.res[0].libdexp);
			$('#m_serv_libdstatus').val(data.res[0].libdstatus);


          	$('#modal_servindexprice').modal({
				backdrop: 'static',
				'keyboard': false
			});  	
        })
        .always(function() {
            $('#myspinner').hide();
        });
	});

	

	$('#modal_servindexprice').on('click', '#m_serv_saveprice', function() {
		var unit = $('#m_serv_unit').val();
		var price = $('#m_serv_libdprice').val();
		var status = $('#m_serv_libdstatus').val();

		if (unit.length === 0 || status.length === 0 || price.length === 0) {
			Swal.fire({icon: 'warning', title: 'Oops...', text: 'Required field must not be empty!'});
			return false;
		}


		Swal.fire({
                title: 'Do you want to save?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Confirm',
                allowOutsideClick: false,
                allowEscapeKey: false
        }).then((result) => {
            if (result.isConfirmed) {
            	$('#myspinner').show();
		        $.post('servsaveprice', $('#m_form_saveprice').serialize(), function(data){
		            data = JSON.parse(data);
					var libdescid = $('#serv_indlibdescid').val();
					dtmedprice(libdescid);
		        })
		        .always(function() {
		            $('#myspinner').hide();
		            $('#modal_servindexprice').modal('hide');
		        });
            }
        })
	});


	$('#tbl_dt_servindexprice').on('click', 'a[name="printbarcode"]', function() {
		$('#print_div').html('');

		var barcode = $(this).attr('data-libdbarcode');
		var base_url = window.location.origin + '/r8agripet/';
		var str = '<img class="barcode" style="margin-bottom: -10px;" alt="" src="'+base_url+'assets/barcode/barcode.php?text='+barcode+'&codetype=code128&orientation=horizontal&size=20&print=true"/>';
		$('#print_div').html(str);
		$('#modal_print_barcode').modal({
			backdrop: 'static',
			'keyboard': false
		}); 
	});


	$('#print').click(function(){
        $('#print_div').printThis();
    });


    $('body').bind('keydown', function(e){
        if(e.ctrlKey && e.keyCode == 80){
            $('#print').click();
            return false;
        }
    });


    $('#modal_stockcard').on('click', '#adjustqty', function() {
    	var libdid = $.trim($('#sc_libdid').val());
    	$('#adj_transservid').val('');
    	$('#adj_tslibdid').val(libdid);

    	$('#adj_libdbarcode').val($('#sc_libdbarcode').val());
    	$('#adj_libdesc').val($('#sc_libdesc').val());
    	$('#adj_libdescitem').val($('#sc_libdescitem').val());
    	$('#adj_tslibdqty').val('');
    	$('#adj_tsremarks').val('');

    	$('#modal_stockcard').modal('hide');
    	$('#modal_adjust_qty').modal({
			backdrop: 'static',
			'keyboard': false
		}); 
    });


	$('#modal_stockcard').on('click', 'a[name="editadjustqty"]', function() {
		var libdid = $.trim($('#sc_libdid').val());
    	var transservid = $.trim($(this).attr('data-transservid'));

    	$('#myspinner').show();
        $.get('serveditadjustqty', {'transservid':transservid}, function(data){
            data = JSON.parse(data);
        
        	$('#adj_transservid').val(transservid);
	    	$('#adj_tslibdid').val(libdid);

	    	$('#adj_libdbarcode').val($('#sc_libdbarcode').val());
	    	$('#adj_libdesc').val($('#sc_libdesc').val());
	    	$('#adj_libdescitem').val($('#sc_libdescitem').val());

	    	if (data.res.length > 0) {
		    	$('#adj_tslibdqty').val(data.res[0].tslibdqty);
		    	$('#adj_tsremarks').val(data.res[0].tsremarks);
		    }

          	$('#modal_adjust_qty').modal({
				backdrop: 'static',
				'keyboard': false
			});  	
        })
        .always(function() {
        	$('#modal_stockcard').modal('hide');
            $('#myspinner').hide();
        });
    });



    


    $('#modal_adjust_qty').on('click', '#m_serv_saveadjustqty', function() {
		var qty = $('#adj_tslibdqty').val();
		var remarks = $('#adj_tsremarks').val();

		if (qty.length === 0 || remarks.length === 0) {
			Swal.fire({icon: 'warning', title: 'Oops...', text: 'Required field must not be empty!'});
			return false;
		} else if (qty < 0) {
			Swal.fire({icon: 'warning', title: 'Oops...', text: 'Quantity must not be negative!'});
			return false;
		}

		Swal.fire({
                title: 'Do you want to save?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Confirm',
                allowOutsideClick: false,
                allowEscapeKey: false
        }).then((result) => {
            if (result.isConfirmed) {
            	$('#myspinner').show();
		        $.post('servsaveadjustqty', $('#m_form_adjustqty').serialize(), function(data){
		            data = JSON.parse(data);
					var libdescid = $('#serv_indlibdescid').val();
					dtmedprice(libdescid);
		        })
		        .always(function() {
		            $('#myspinner').hide();
		            $('#modal_adjust_qty').modal('hide');

		            var libdid = $('#sc_libdid').val();
		            displayStockCard(libdid);
		        });
            }
        })
	});


	/*stock card*/
	$('#tbl_dt_servindexprice').on('click', 'a[name="stockcard"]', function() {
    	var libdid = $(this).attr('data-libdid');
    	$('#sc_libdid').val('');

    	displayStockCard(libdid);
    });


    var displayStockCard = function(libdid) {
    	$('#myspinner').show();
        $.get('stockcard', {'libdid':libdid}, function(data){
            data = JSON.parse(data);
        
        	if (data.res_head.length > 0) {
        		$('#sc_libdid').val(libdid);
        		$('#sc_libdbarcode').val(data.res_head[0].libdbarcode);
        		$('#sc_libdesc').val(data.res_head[0].libdesc);
        		$('#sc_libdescitem').val(data.res_head[0].libdescitem);
        		$('#sc_unitcode').val(data.res_head[0].unitcode);
        		$('#sc_libdprice').val(data.res_head[0].libdprice);
        	}

        	var str = stockcardHtml(data.res_head, data.res);
        	$('#tbody_stockcard').html(str);

          	$('#modal_stockcard').modal({
				backdrop: 'static',
				'keyboard': false
			});  	
        })
        .always(function() {
            $('#myspinner').hide();
        });
    };


});
