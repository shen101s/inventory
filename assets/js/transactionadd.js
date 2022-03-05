$(document).ready(function() {
    'use strict';
    $('#l_trans').addClass('active');
    
    $('#trans_date').datepicker({ format: 'M dd, yyyy' }).datepicker("setDate", new Date());

    $('#content-wrapper').on('change', '#trans_serv_sel', function() {
    	$("#div_pnl_serv").show(100);
    	$('#tbl_serv').html($(this).find(':selected').attr('data-sdescription'));
    	
    	var sid = $(this).val();
        dtmedprice(sid);
    });


    var dtmedprice = function(sid) {
		$('#myspinner').show();
		$('#tbl_dt_transadd').DataTable({
			'responsive': true,
			'autoWidth': false,
	        'processing': true,
	        'serverSide': true,
	        'destroy': true,
	        'stateSave': true,
	        'ajax': {
	            'url':  localStorage.getItem('sysname_') + '/transaction/selectmed',
	            data: function (d) {
	            	d.sid = sid;
	            },
            	error: function () {
	                console.log('error');
	        	}
	        },
	        'columns': [
                { 'data': 'libdesc' },                                
	            { 'data': 'unitcode' },
	            { 'data': 'libdprice' },
	            { 'data': 'libdqtyrem' },
	            { 'data': 'libdexp' },
	            { 'data': 'libdid',
	                "orderable": false,
	                "searchable": false,
	                "render": function(data,type,row,meta) {
	                    var a = '<a href="javascript:void(0);" data-libdid="'+row.libdid+'" title="Add" name="addserv"><i class="fa fa-plus-square"></i></a>';
	                    return a;
	                } 
	            }
	        ],
        	initComplete:function( settings, json){
	        	$('#myspinner').hide();
	        }
	    });
	};

	var displaytransserv = function(data) {
		var str = '';
        var len = data.transserv.length;
        // var lenemp = data.emp.length;
        var totamount = 0, amount=0, discount=0;
        var sel = '';
        for (var i = 0; i < len; i++) {
        	discount = data.transserv[i].tslibdqty * data.transserv[i].tsdiscount;
            amount = (data.transserv[i].libdprice * data.transserv[i].tslibdqty) - discount;

            totamount += amount;

        	//totamount += (data.transserv[i].libdprice * data.transserv[i].tslibdqty);
        	str += '<tr>';
	            str += '<td>' + data.transserv[i].scode + '</td>';
	            str += '<td>' + data.transserv[i].libdesc + '</td>';
	            str += '<td>' + data.transserv[i].unitcode + '</td>';
	            str += '<td style="text-align: right;" class="libdprice">' + data.transserv[i].libdprice + '</td>';
	            str += '<td><input type="number" class="form-control input-sm" name="tslibdqty" placeholder="0" value="'+data.transserv[i].tslibdqty+'" disabled></td>';
	            str += '<td><input type="number" class="form-control input-sm" name="tsdiscount" placeholder="0" value="'+data.transserv[i].tsdiscount+'" disabled></td>';

	            str += '<td style="text-align: right;" class="libdamount">' + amount.toFixed(2) + '</td>';

	            /*str += '<td>';
	                str += '<select class="form-control input-sm" name="tsempid" disabled>';
	                    str += '<option value="">...</option>';
                        for (var j=0; j < lenemp; j++) { 
                        	sel = data.transserv[i].empid === data.emp[j].empid ? 'selected' : '';
                            str += '<option value="'+data.emp[j].empid+'" '+sel+'>'+data.emp[j].elname+'</option>';
                        }
	                str += '</select>';
	            str += '</td>';*/


	            str += '<td>';
	                str += '<a href="javascript:void(0);" name="trans_add_a" data-transservid="'+data.transserv[i].transservid+'" data-tslibdid="'+data.transserv[i].tslibdid+'" style="display:none;"><i class="fa fa-save"></i></a> ';
	                str += '<span name="trans_add_span" style="display:none;"> | </span>';
	                str += '<a href="javascript:void(0);" name="trans_cancel_a" data-transservid="'+data.transserv[i].transservid+'" style="display:none;"><i class="fa fa-times"></i></a>';

	                str += '<a href="javascript:void(0);" data-transservid="'+data.transserv[i].transservid+'" name="trans_edit_a"><i class="fa fa-edit"></i></a> ';
	                str += '<span name="trans_edit_span"> | </span>';
	                str += '<a href="javascript:void(0);" name="trans_del_a" data-transservid="'+data.transserv[i].transservid+'" ><i class="fa fa-trash"></i></a>';
	            str += '</td>';
	        str += '</tr>';
        }

        $('#tbody_addnew_serv').html(str);
        $('#totamount').html(numberWithCommas(totamount.toFixed(2)));
	}


	var displayTotalAmountOnly = function() {
		var totamount = 0;
		$('.libdamount').each(function(){
		    totamount += parseFloat($(this).text());  // Or this.innerHTML, this.innerText
		});
		$('#totamount').html(numberWithCommas(totamount.toFixed(2)));
	}


	$('#content-wrapper').on('click', 'a[name="addserv"]', function() {
		var libdid = $(this).attr('data-libdid');

		$('#myspinner').show();
        $.get(localStorage.getItem('sysname_') + '/transaction/addserv', {'libdid':libdid}, function(data){
            data = JSON.parse(data);
            var str = '';
            var len = data.res.length;
            // var lenemp = data.emp.length;
            for (var i = 0; i < len; i++) {
            	str += '<tr>';
		            str += '<td>' + data.res[i].scode + '</td>';
		            str += '<td>' + data.res[i].libdesc + '</td>';
		            str += '<td>' + data.res[i].unitcode + '</td>';
		            str += '<td style="text-align: right;" class="libdprice">' + data.res[i].libdprice + '</td>';
		            str += '<td><input type="number" class="form-control input-sm" name="tslibdqty" placeholder="0" value="1"></td>';
		            str += '<td><input type="number" class="form-control input-sm" name="tsdiscount" placeholder="0" value="0"></td>';

		            str += '<td style="text-align: right;" class="libdamount">' + data.res[i].libdprice + '</td>';

		            /*str += '<td>';
		                str += '<select class="form-control input-sm" name="tsempid">';
		                    str += '<option value="">...</option>';
	                        for (var j=0; j < lenemp; j++) { 
	                            str += '<option value="'+data.emp[j].empid+'">'+data.emp[j].elname+'</option>';
	                        }
		                str += '</select>';
		            str += '</td>';*/

		            str += '<td>';
		                str += '<a href="javascript:void(0);" name="trans_add_a" data-transservid="" data-tslibdid="'+data.res[i].libdid+'" ><i class="fa fa-save"></i></a> ';
		                str += '<span name="trans_add_span"> | </span>';
		                str += '<a href="javascript:void(0);" name="trans_cancel_a" data-transservid=""><i class="fa fa-times"></i></a>';

		                str += '<a href="javascript:void(0);" data-transservid="" name="trans_edit_a" style="display:none;"><i class="fa fa-edit"></i></a> ';
		                str += '<span name="trans_edit_span" style="display:none;"> | </span>';
		                str += '<a href="javascript:void(0);" name="trans_del_a" data-transservid="" style="display:none;"><i class="fa fa-trash"></i></a> ';
		            str += '</td>';
		        str += '</tr>';
            }

            $('#tbody_addnew_serv').append(str);
            displayTotalAmountOnly();
        })
        .always(function() {
            $('#myspinner').hide();
        });
	});

	$('#tbl_trans_det').on('click', '#trans_edit', function() {
		$('#trans_date').prop('disabled', false);
		$('#trans_pet').prop('disabled', false);
		$('#trans_pur').prop('disabled', false);
		$('#trans_remarks').prop('disabled', false);

		$('#trans_save').show(100);
		$('#trans_cancel').show(100);
		$('#trans_edit').hide(100);
	});

	$('#content-wrapper').on('click', '#trans_save', function() {
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
                var trans_date = $('#trans_date').val();
				var trans_oid = $('#trans_oid').val();
				var trans_pet = $('#trans_pet').val();
				var trans_pur = $('#trans_pur').val();
				var trans_remarks = $('#trans_remarks').val();
				var trans_transid = $('#trans_transid').val();

				$('#myspinner').show();
		        $.get(localStorage.getItem('sysname_') + '/transaction/transave', {'trans_transid':trans_transid, 'trans_oid':trans_oid, 'trans_pet':trans_pet, 'trans_remarks':trans_remarks, 'trans_date':trans_date, 'trans_pur':trans_pur}, function(data){
		            data = JSON.parse(data);
		            console.log(data); 
		            if (data.res) {
		            	window.location.href = window.location.origin+localStorage.getItem('sysname_') + '/transaction/clientselect/addnew?o='+data.oid+'&trans='+data.transid;
		            }
		        })
		        .always(function() {
		            $('#myspinner').hide();
		        });
            }
        })

	});


	$('#content-wrapper').on('click', 'a[name="trans_add_a"]', function() {
		var transservid = $(this).attr('data-transservid');
		var transid = $('#trans_transid').val();
		var tslibdid = $(this).attr('data-tslibdid');
		var tslibdqty = $(this).parents('tr').find('input[name="tslibdqty"]').val();
		var tsdiscount = $(this).parents('tr').find('input[name="tsdiscount"]').val();

		// var tsempid = $(this).parents('tr').find('select[name="tsempid"]').val();
		

		$('#myspinner').show();
        $.get(localStorage.getItem('sysname_') + '/transaction/transervsave', {'transservid':transservid, 'transid':transid, 'tslibdid':tslibdid, 'tslibdqty':tslibdqty, 'tsdiscount':tsdiscount}, function(data){
            data = JSON.parse(data);
            if (data.res) {
            	displaytransserv(data);	
            } else {
            	Swal.fire({icon: 'error', title: 'Oops...', text: 'Something went wrong!'});
            }
        })
        .always(function() {
            $('#myspinner').hide();

            var sid = $('#trans_serv_sel').val();
    		dtmedprice(sid);
        });
		
	});


	$('#tbody_addnew_serv').on('keyup click', 'input[name="tslibdqty"], input[name="tsdiscount"]', function() {
		var tr = $(this).parents('tr');
		var libdprice = tr.find('td.libdprice').text();

		var tslibdqty = tr.find('input[name="tslibdqty"]').val();
		var tsdiscount = tr.find('input[name="tsdiscount"]').val();

		var discount = tslibdqty * tsdiscount;
		var libdamount = (parseFloat(tslibdqty) * libdprice) - discount;
		tr.find('td.libdamount').text(libdamount.toFixed(2));

		var totamount = 0;
		var libdamountclass = $('.libdamount');
		for(var i = 0; i < libdamountclass.length; i++){
		    totamount += ($(libdamountclass[i]).text() * 1);
		}
		$('#totamount').html(numberWithCommas(totamount.toFixed(2)));
	});

	/*$('#tbody_addnew_serv').on('keyup click', 'input[name="tslibdqty"]', function() {
		var tr = $(this).parents('tr');
		var libdprice = tr.find('td.libdprice').text();
		var libdamount = parseFloat($(this).val()) * libdprice;
		tr.find('td.libdamount').text(libdamount.toFixed(2));

		var totamount = 0;
		var libdamountclass = $('.libdamount');
		for(var i = 0; i < libdamountclass.length; i++){
		    totamount += ($(libdamountclass[i]).text() * 1);
		}
		$('#totamount').html(totamount.toFixed(2));
	});*/

	$('#tbody_addnew_serv').on('keyup click', 'a[name="trans_edit_a"]', function() {
		var tr = $(this).parents('tr');
		tr.find('a[name="trans_add_a"], a[name="trans_cancel_a"]').show();
		tr.find('a[name="trans_edit_a"], a[name="trans_del_a"]').hide();

		tr.find('span[name="trans_add_span"]').show();
		tr.find('span[name="trans_edit_span"]').hide();

		tr.find('input[name="tslibdqty"]').prop('disabled', false);
		tr.find('input[name="tsdiscount"]').prop('disabled', false);

		// tr.find('select[name="tsempid"]').prop('disabled', false);
	});


	$('#tbl_trans_det').on('click', '#trans_cancel', function() {
		Swal.fire({
            title: 'Cancel this data?',
            text: "This page will reload",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Confirm',
            allowOutsideClick: false,
            allowEscapeKey: false
        }).then((result) => {
            if (result.isConfirmed) {
                location.reload();
            }
        })
	});

	$('#tbody_addnew_serv').on('click', 'a[name="trans_cancel_a"]', function() {
		location.reload();
	});

	$('#tbody_addnew_serv').on('click', 'a[name="trans_del_a"]', function() {
		Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Confirm',
            allowOutsideClick: false,
            allowEscapeKey: false
        }).then((result) => {
            if (result.isConfirmed) {
                var transservid = $(this).attr('data-transservid');
				var transid = $('#trans_transid').val();
				$('#myspinner').show();
		        $.get(localStorage.getItem('sysname_') + '/transaction/transervdel', {'transservid':transservid, 'transid':transid}, function(data){
		            data = JSON.parse(data); 
		            if (data.res) {
		            	displaytransserv(data);	
		            } else {
		            	Swal.fire({icon: 'error', title: 'Oops...', text: 'Something went wrong!'});
		            }
		        })
		        .always(function() {
		            $('#myspinner').hide();

		            var sid = $('#trans_serv_sel').val();
	        		dtmedprice(sid);
		        });
            }
        })
	});

	
});
