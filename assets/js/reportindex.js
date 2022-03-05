$(document).ready(function() {

	$('#l_report').addClass('active');

	$('#trandate_s').datepicker({ format: 'M dd, yyyy' });
	$('#trandate_e').datepicker({ format: 'M dd, yyyy' });

	$('#content-wrapper').on('change', '#nearlyexpirydate', function() {
        var checkval = $(this).prop("checked");
        $('#myspinner').show();
        $.get('medicine/expiry', {'checkval':checkval}, function(data){
            data = JSON.parse(data);
            if (data) {
            	console.log(data);
            	var len = data.res.length;
            	var str = '';
            	for (var i = 0; i < len; i++) {
            		str += '<tr>';
                        str += '<td>' + data.res[i].libdesc + '</td>';
                        str += '<td>' + data.res[i].unitcode + '</td>';
                        str += '<td>' + data.res[i].libdprice + '</td>';
                        str += '<td>' + data.res[i].libdqtyrem + '</td>';
                        str += '<td>' + (data.res[i].libdexp == null ? '-' : data.res[i].libdexp) + '</td>';
                    str += '</tr>';
            	}
            } else {
                Swal.fire({icon: 'error', title: 'Oops...', text: 'Error! Please try again!'});
            }

            $('#tblreport').html(str);
        })
        .always(function() {
            $('#myspinner').hide();
        });
    });


	$('#content-wrapper').on('change', '#supplynearlyexpirydate', function() {
        var checkval = $(this).prop("checked");
        $('#myspinner').show();
        $.get('supply/expiry', {'checkval':checkval}, function(data){
            data = JSON.parse(data);
            if (data) {
            	console.log(data);
            	var len = data.res.length;
            	var str = '';
            	for (var i = 0; i < len; i++) {
            		str += '<tr>';
                        str += '<td>' + data.res[i].libdesc + '</td>';
                        str += '<td>' + data.res[i].unitcode + '</td>';
                        str += '<td>' + data.res[i].libdprice + '</td>';
                        str += '<td>' + data.res[i].libdqtyrem + '</td>';
                        str += '<td>' + (data.res[i].libdexp == null ? '-' : data.res[i].libdexp) + '</td>';
                    str += '</tr>';
            	}
            } else {
            	Swal.fire({icon: 'error', title: 'Oops...', text: 'Error! Please try again!'});
            }

            $('#tblreport').html(str);
        })
        .always(function() {
            $('#myspinner').hide();
        });
    });


    $('#content-wrapper').on('change', '#foodnearlyexpirydate', function() {
        var checkval = $(this).prop("checked");
        $('#myspinner').show();
        $.get('food/expiry', {'checkval':checkval}, function(data){
            data = JSON.parse(data);
            if (data) {
            	console.log(data);
            	var len = data.res.length;
            	var str = '';
            	for (var i = 0; i < len; i++) {
            		str += '<tr>';
                        str += '<td>' + data.res[i].libdesc + '</td>';
                        str += '<td>' + data.res[i].unitcode + '</td>';
                        str += '<td>' + data.res[i].libdprice + '</td>';
                        str += '<td>' + data.res[i].libdqtyrem + '</td>';
                        str += '<td>' + (data.res[i].libdexp == null ? '-' : data.res[i].libdexp) + '</td>';
                    str += '</tr>';
            	}
            } else {
            	Swal.fire({icon: 'error', title: 'Oops...', text: 'Error! Please try again!'});
            }

            $('#tblreport').html(str);
        })
        .always(function() {
            $('#myspinner').hide();
        });
    });



    $('#content-wrapper').on('change', '#vaccinenearlyexpirydate', function() {
        var checkval = $(this).prop("checked");
        $('#myspinner').show();
        $.get('vaccine/expiry', {'checkval':checkval}, function(data){
            data = JSON.parse(data);
            if (data) {
            	console.log(data);
            	var len = data.res.length;
            	var str = '';
            	for (var i = 0; i < len; i++) {
            		str += '<tr>';
                        str += '<td>' + data.res[i].libdesc + '</td>';
                        str += '<td>' + data.res[i].unitcode + '</td>';
                        str += '<td>' + data.res[i].libdprice + '</td>';
                        str += '<td>' + data.res[i].libdqtyrem + '</td>';
                        str += '<td>' + (data.res[i].libdexp == null ? '-' : data.res[i].libdexp) + '</td>';
                    str += '</tr>';
            	}
            } else {
            	Swal.fire({icon: 'error', title: 'Oops...', text: 'Error! Please try again!'});
            }

            $('#tblreport').html(str);
        })
        .always(function() {
            $('#myspinner').hide();
        });
    });













/*delete below*/

	$('#content-wrapper').on('change', '#s_form', function(){
		var sid = $('option:selected', this).attr('data-sid');
		if (sid == '3') {
			$('#trandate_s').show(100);
			$('#trandate_e').show(100);
		} else {
			$('#trandate_s').hide(100);
			$('#trandate_e').hide(100);
		}

		$('#trandate_s').val('');
		$('#trandate_e').val('');
	});
});

