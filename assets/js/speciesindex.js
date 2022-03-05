$(document).ready(function() {
	'use strict';

    $('#l_species').addClass('active');
    
    var dtspecies = function() {
    	$('#tbl_dt_unitindex').DataTable({
            'processing': true,
            'serverSide': true,
            'destroy': true,
            'stateSave': true,
            'responsive':true,
            'autoWidth':false,
            'ajax': {
                'url': 'species/dtspeciesindex',
                error: function () {
                    console.log('error');
                }
            },
            'columns': [
                { 'data': 'specdesc' },
                { 'data': 'specstatus' },
                { 'data': 'specid',
                    "orderable": false,
                    "searchable": false,
                    "render": function(data,type,row,meta) {
                        var a = '<a href="javascript:void(0);" data-specid="'+row.specid+'" title="Add Breed" name="specselect"><i class="fa fa-location-arrow"></i></a> | ';
                        a += '<a href="javascript:void(0);" data-specid="'+row.specid+'" title="Edit" name="specedit"><i class="fa fa-edit"></i></a>';
                        return a;
                    } 
                }
            ]
        });
    }

    dtspecies();


    /* encrypted specid */
    var dtbreed = function(specid) {
        $('#myspinner').show();
        $('#tbl_dt_breedindex').DataTable({
            'processing': true,
            'serverSide': true,
            'destroy': true,
            'stateSave': true,
            'responsive':true,
            'autoWidth':false,
            'ajax': {
                'url': 'dtbreedindex',
                data: function (d) {
                    d.specid = specid;
                },
                error: function () {
                    console.log('error');
                }
            },
            'columns': [
                { 'data': 'breeddesc' },
                { 'data': 'breedstatus' },
                { 'data': 'breedid',
                    "orderable": false,
                    "searchable": false,
                    "render": function(data,type,row,meta) {
                        var a = '<a href="javascript:void(0);" data-breedid="'+row.breedid+'" title="Edit breed" name="editbreed"><i class="fa fa-edit"></i></a>';
                        return a;
                    } 
                }
            ],
            initComplete:function( settings, json){
                $('#myspinner').hide();
            }
        });
    };


    $('#content-wrapper').on('click', 'a[name="specselect"]', function() {
        $('#div_spec').show(100);

        var specid = $.trim($(this).attr('data-specid'));
        $('#inp_specid').val(specid);

        var medname = $(this).closest('tr').find('td:eq(0)').text();
        $('#span_specdesc').html(medname);

        dtbreed(specid);
    });

	
	$('#content-wrapper').on('click', '#specadd', function() {
		$('#m_i_title').html('Add Species');
		$('#m_specid').val('');
		$('#m_specdesc').val('');
		$('#m_specstatus').val('');

		$('#modal_specindex').modal({
			backdrop: 'static',
			'keyboard': false
		});
	});

    $('#content-wrapper').on('click', 'a[name="specedit"]', function() {
        $('#m_i_title').html('Edit Species');

        var specid = $(this).attr('data-specid')
        $('#m_specid').val(specid);

        $('#myspinner').show();
        $.get('species/editspec', {'specid':specid}, function(data){
            data = JSON.parse(data);

            $('#m_specdesc').val(data.res[0].specdesc);
            $('#m_specstatus').val(data.res[0].specstatus);

            $('#modal_specindex').modal({
                backdrop: 'static',
                'keyboard': false
            });
        })
        .always(function() {
            $('#myspinner').hide();
        }); 
    });

    
    $('#modal_specindex').on('click', '#m_specsave', function() {
        var specdesc = $('#m_specdesc').val();
        var specstatus = $('#m_specstatus').val();

        if (specdesc.length === 0 || specstatus.length === 0) {
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
                $.post('species/savespec', $('#form_species').serialize(), function(data){
                    data = JSON.parse(data);
                    if (data.res) {
                        Swal.fire({icon: 'success', title: 'Success', text: 'Successfully saved!'});
                    } else {
                        Swal.fire({icon: 'error', title: 'Oops...', text: 'Something went wrong!'})
                    }
                    
                    dtspecies();
                })
                .always(function() {
                    $('#myspinner').hide();
                    $('#modal_specindex').modal('hide');
                });
            }
        })
    });



    /*start breed*/
    
    $('#content-wrapper').on('click', '#breedadd', function() {
        $('#m_title_b').html('Add <u>' + $('#span_specdesc').html() + '</u> Breed');
        $('#m_breedid').val('');
        $('#m_specid_').val($('#inp_specid').val());
        $('#m_breeddesc').val('');
        $('#m_breedstatus').val('');

        $('#modal_breedindex').modal({
            backdrop: 'static',
            'keyboard': false
        });
    });

    $('#modal_breedindex').on('click', '#m_breedsave', function() {
        var breeddesc = $('#m_breeddesc').val();
        var breedstatus = $('#m_breedstatus').val();

        if (breeddesc.length === 0 || breedstatus.length === 0) {
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
                $.post('species/savebreed', $('#form_breed').serialize(), function(data){
                    data = JSON.parse(data);
                    if (data.res) {
                        Swal.fire({icon: 'success', title: 'Success', text: 'Successfully saved!'});
                    } else {
                        Swal.fire({icon: 'error', title: 'Oops...', text: 'Something went wrong!'});
                    }


                    var specid = $('#inp_specid').val();
                    dtbreed(specid);
                })
                .always(function() {
                    $('#myspinner').hide();
                    $('#modal_breedindex').modal('hide');
                });
            }
        })
    });


    /* edit is not working pa */

	$('#content-wrapper').on('click', 'a[name="editbreed"]', function() {
        $('#m_title_b').html('Add <u>' + $('#span_specdesc').html() + '</u> Breed');
		var breedid = $(this).attr('data-breedid');
		$('#m_breedid').val(breedid);

		$('#myspinner').show();
        $.get('species/editbreed', {'breedid':breedid}, function(data){
            data = JSON.parse(data);

           	$('#m_specid_').val(data.res[0].specid);
			$('#m_breeddesc').val(data.res[0].breeddesc);
			$('#m_breedstatus').val(data.res[0].breedstatus);

          	$('#modal_breedindex').modal({
				backdrop: 'static',
				'keyboard': false
			});  	
        })
        .always(function() {
            $('#myspinner').hide();
        });
	});
});
