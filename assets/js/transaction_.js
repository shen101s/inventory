$(document).ready(function() {
    'use strict';
    $('#l_trans').addClass('active');
    $('#m_fpetspecies').select2({placeholder: 'Select...', allowClear: true});
    $('#m_fpetbreed').select2({placeholder: 'Select...', allowClear: true});

    
    $('#m_phdate').datepicker({ format: 'M dd, yyyy' });


    var remselect = $('#remselect_hidden').val();
    $('#tbl_dt_trans').DataTable( {
        'responsive':true,
        'autoWidth': false,
        'processing': true,
        'serverSide': true,
        'responsive':true,
        'autoWidth':false,
        'ajax': {
            'url': 'dtownerdata',
            error: function () {
                console.log('error');
            }
        },
        'stateSave': true,
        'columns': [
            { 'data': 'ofname' },
            { 'data': 'omname' },
            { 'data': 'olname' },
            { 'data': 'oaddress' },
            { 'data': 'ocontactnum' },
            { 'data': 'oemailadd' },
            { 'data': 'pname' },
            { 'data': 'oid',
                "orderable": false,
                "searchable": false,
                "render": function(data,type,row,meta) {
                    var a = '';
                    if (remselect === 'FALSE') {
                        a += '<a href="clientselect/addnew?o='+row.oid+'" title="select owner" name="selectowner" ><i class="fa fa-location-arrow"></i></a> | ';
                    }
                    a += '<a href="javascript:void(0);" data-oid="'+row.oid+'" title="edit owner"  name="editowner"><i class="fa fa-edit"></i></a> | ';
                    a += '<a href="javascript:void(0);" data-oid="'+row.oid+'" data-fullname="'+row.ofname+' '+ row.omname + ' ' + row.olname +'"  title="Add Pet"  name="addpet"><i class="fa fa-paw"></i></a>';
                    return a;
                } 
            }
        ]
    });


    
    

    $('#body').on('click', '#trans_add_owner', function() {
        $('#modal-title-trans').html('Add Client');

        $('#m_oid').val('');
        $('#m_fname').val('');
        $('#m_mname').val('');
        $('#m_lname').val('');
        $('#m_address').val('');
        $('#m_contactnum').val('');
        $('#m_emailadd').val('');

        $('#modal_trans').modal({
            backdrop: 'static',
            keyboard: false
        });
    });

    

    $('#body').on('click', 'a[name="editowner"]', function() {
        $('#modal-title-trans').html('Edit Client');
        var oid = $.trim($(this).attr('data-oid'));
        $('#m_oid').val(oid);

        $('#myspinner').show();
        $.get('editowner', {'oid':oid}, function(data){
            data = JSON.parse(data);
            $('#m_fname').val(data.own[0].ofname);
            $('#m_mname').val(data.own[0].omname);
            $('#m_lname').val(data.own[0].olname);
            $('#m_address').val(data.own[0].oaddress);
            $('#m_contactnum').val(data.own[0].ocontactnum);
            $('#m_emailadd').val(data.own[0].oemailadd);

           $('#modal_trans').modal({
                backdrop: 'static',
                keyboard: false
            });
        })
        .always(function() {
            $('#myspinner').hide();
        });

        
    });


    

    /* start pet*/
    $('#m_fpetbday').datepicker({ format: 'M dd, yyyy' });

    $('#body').on('click', 'a[name="addpet"]', function() {
        var oid = $.trim($(this).attr('data-oid'));
        $('#m_oidpet').val(oid);
        var fullname = $.trim($(this).attr('data-fullname'));
        $('#modal-title-trans_pet').html('Pet(s) of <u id="p_ownername">' + fullname + '</u>');

        $('#m_pid').val('');
        $('#m_fpetname').val('');
        $('#m_fpetbday').val('');
        $('#m_fpetspecies').val('');
        $('#m_fpetbreed').val('');
        $('#m_fpetgender').val('');

        $('#myspinner').show();
        $.get('selectpet', {'oid':oid} , function(data){
            data = JSON.parse(data);

            petHtml(data.pet, data.species, data.breed);
            var spechtml = specHtml(data.species);
            var breedhtml = []; //breedHtml(data.breed);

            $('#m_fpetspecies').html(spechtml);
            $('#m_fpetbreed').html(breedhtml);

            $('#modal_trans_pet').modal({
                backdrop: 'static',
                keyboard: false
            });
        })
        .always(function() {
            $('#myspinner').hide();
        });
    });


    

    $('#modal_trans_pet').on('change', '#m_fpetspecies', function() {
        var specid = $(this).val();
        
        $('#myspinner').show();
        $.get('selectbreed', {'specid':specid} , function(data){
            data = JSON.parse(data);
            var breedhtml = breedHtml(data.breed);
            $('#m_fpetbreed').html(breedhtml);
        })
        .always(function() {
            $('#myspinner').hide();
        });
    });



    /*save pet*/
    $('#modal_trans_pet').on('click', '#m_pet_add', function() {
        var m_fpetname = $.trim($('#m_fpetname').val());
        var m_fpetbday = $.trim($('#m_fpetbday').val());
        var m_fpetspecies = $.trim($('#m_fpetspecies').val());
        var m_fpetbreed = $.trim($('#m_fpetbreed').val());
        var m_fpetgender = $.trim($('#m_fpetgender').val());

        var m_pid = $.trim($('#m_pid').val());
        var m_oidpet = $.trim($('#m_oidpet').val());


        if (m_fpetname.length === 0 || m_fpetbday.length === 0 || m_fpetspecies.length === 0 ||
                m_fpetbreed.length === 0 || m_fpetgender.length === 0) {
            alert('Required field must not be empty!')
        }  else {
            $('#myspinner').show();
            $.post('savepet', {'m_pid':m_pid, 'm_oidpet':m_oidpet, 'm_fpetname':m_fpetname, 'm_fpetbday':m_fpetbday, 'm_fpetspecies':m_fpetspecies, 'm_fpetbreed':m_fpetbreed, 'm_fpetgender':m_fpetgender} , function(data){
                data = JSON.parse(data);
                if (data.res) {
                    $('#m_pid').val('');
                    $('#m_fpetname').val('');
                    $('#m_fpetbday').val('');
                    $('#m_fpetspecies').val('');
                    $('#m_fpetbreed').val('');
                    $('#m_fpetgender').val('');

                    petHtml(data.pet, data.species, data.breed);

                    var spechtml = specHtml(data.species);
                    var breedhtml = breedHtml(data.breed);

                    $('#m_fpetspecies').html(spechtml);
                    $('#m_fpetbreed').html(breedhtml);

                } else {
                    alert('Error! Please check your connection.');
                }
                
            })
            .always(function() {
                $('#myspinner').hide();
            });
        }
    });

    /* update pet*/
    $('#modal_trans_pet').on('click', 'a[name="m_pet_add_m"]', function() {
        var tr = $(this).parents('tr');


        var m_fpetname = $.trim(tr.find('input[name="m_fpetname"]').val());
        var m_fpetbday = $.trim(tr.find('input[name="m_fpetbday"]').val());
        var m_fpetspecies = $.trim(tr.find('select[name="m_fpetspecies"]').val());
        var m_fpetbreed = $.trim(tr.find('select[name="m_fpetbreed"]').val());
        var m_fpetgender = $.trim(tr.find('select[name="m_fpetgender"]').val());

        var m_pid = $(this).attr('data-pid');
        var m_oidpet = $(this).attr('data-oid');


        if (m_fpetname.length === 0 || m_fpetbday.length === 0 || m_fpetspecies.length === 0 ||
                m_fpetbreed.length === 0 || m_fpetgender.length === 0) { 
            alert('Required field must not be empty!')
        }  else {
            $('#myspinner').show();
            $.post('savepet', {'m_pid':m_pid, 'm_oidpet':m_oidpet, 'm_fpetname':m_fpetname, 'm_fpetbday':m_fpetbday, 'm_fpetspecies':m_fpetspecies, 'm_fpetbreed':m_fpetbreed, 'm_fpetgender':m_fpetgender} , function(data){
                data = JSON.parse(data);

                console.log(data);
                if (data.res) {
                    $('#m_pid').val('');
                    $('#m_fpetname').val('');
                    $('#m_fpetbday').val('');
                    $('#m_fpetspecies').val('');
                    $('#m_fpetbreed').val('');
                    $('#m_fpetgender').val('');

                    petHtml(data.pet, data.species, data.breed);

                } else {
                    alert('Error! Please check your connection.');
                }
                
            })
            .always(function() {
                $('#myspinner').hide();
            });
        }
    });

    
    

    



    $('#modal_trans_pet').on('click', 'a[name="m_pet_delete"]', function() {
        var cnfrm = confirm('Delete this data?');
        if (cnfrm) {
            var pid = $(this).attr('data-pid');
            var oid = $(this).attr('data-oid');
            $('#myspinner').show();
            $.post('deletepet', {'pid':pid, 'oid':oid} , function(data){
                data = JSON.parse(data);
                console.log(data);
                if (data.res) {
                    petHtml(data.pet, data.species, data.breed);
                } else {
                    alert('Error! Please check your connection.');
                }
                
            })
            .always(function() {
                $('#myspinner').hide();
            });   
        }
    });

    /*cancel*/
    $('#modal_trans_pet').on('click', '#m_pet_cancel', function() {
        var oid = $('#m_oidpet').val();
        $('#myspinner').show();
        $.get('selectpet', {'oid':oid} , function(data){
            data = JSON.parse(data);

            $('#m_pid').val('');
            $('#m_fpetname').val('');
            $('#m_fpetbday').val('');
            $('#m_fpetspecies').val('');
            $('#m_fpetbreed').val('');
            $('#m_fpetgender').val('');

            petHtml(data.pet, data.species, data.breed);
            var spechtml = specHtml(data.species);
            var breedhtml = breedHtml(data.breed);

            $('#m_fpetspecies').html(spechtml);
            $('#m_fpetbreed').html(breedhtml);
        })
        .always(function() {
            $('#myspinner').hide();
        });
    });


    $('#modal_trans_pet').on('click', 'a[name="m_pet_edit"]', function() {
        var pid = $(this).attr('data-pid');        
        $('#m_pet_tbody_details tr').removeClass('highlighted');
        $(this).closest('tr').addClass('highlighted');

        $('#myspinner').show();
        $.get('editpet', {'pid':pid} , function(data){
            data = JSON.parse(data);

            var spechtml = specHtml(data.species);
            var breedhtml = breedHtml(data.breed);

            $('#m_fpetspecies').html(spechtml);
            $('#m_fpetbreed').html(breedhtml);

            $('#m_pid').val(data.res[0].pid);
            $('#m_fpetname').val(data.res[0].pname);
            $('#m_fpetbday').val(data.res[0].pbday);
            $('#m_fpetspecies').val(data.res[0].specid);
            $('#m_fpetbreed').val(data.res[0].breedid);
            $('#m_fpetgender').val(data.res[0].pgender);
        })
        .always(function() {
            $('#myspinner').hide();
        });
    });


    /* start pet history*/
    function pethisHtml(data) {
        var len = data.length;
        var str = '';
        for (var i = 0; i < len; i++) {
            str += '<tr>';
                str += '<td>';
                    str += data[i].phdesc;
                str += '</td>';
                str += '<td>';
                    str += data[i].phdate;
                str += '</td>';
                str += '<td>';
                    str += data[i].phremarks;
                str += '</td>';
                str += '<td>';
                    str += '<a href="javascript:void(0);" name="m_pet_hist_edit" data-phid="' + data[i].phid + '" data-oid="' + data[i].oid + '" title="Edit"><i class="fa fa-edit"></i></a> ';
                    str += '<span> | </span>';
                    str += '<a href="javascript:void(0);" name="m_pet_hist_delete" data-phid="' + data[i].phid + '" data-oid="' + data[i].oid + '" title="Delete"><i class="fa fa-trash"></i></a>';
                str += '</td>';
            str += '</tr>';
        }

        if (len === 0) {
            str = '<tr><td colspan="4" class="text-center">No data available in table</td></tr>';
        }

        $('#m_pet_his_ttbody_details').html(str);
    }


    /* start health history */
    $('#modal_trans_pet').on('click', 'a[name="m_pid_his"]', function() {
        var ownername = $.trim($(this).attr('data-ownername'));
        var petname = $.trim($(this).attr('data-petname'));
        $('#modal-title-trans_pet_his').html('Health History of <u>' + petname + '</u> ' + ' (' + ownername + ') ');


        $('#m_phdesc').val('');
        $('#m_phdate').val('');
        $('#m_phremarks').val('');

        var pid = $(this).attr('data-pid');
        $('#m_pid_his').val(pid);
        $('#m_phid').val('');

        $('#myspinner').show();
        $.get('selpethistory', {'pid':pid} , function(data){
            data = JSON.parse(data);
            pethisHtml(data.res);
            

            $('#modal_pet_history').modal({
                backdrop: 'static',
                keyboard: false
            });
        })
        .always(function() {
            $('#myspinner').hide();
        });
    });
    
    $('#modal_pet_history').on('click', '#m_pet_hist_add', function() {
        var phdesc = $('select[name="m_phdesc"]').val();
        var phdate = $('input[name="m_phdate"]').val();
        var phremarks = $('textarea[name="m_phremarks"]').val();
        var pid = $('#m_pid_his').val();
        var phid = $('#m_phid').val();

        if (phdesc.length === 0 || phdate.length === 0 || phremarks.length === 0) {
            alert('Required field must not be empty!')
        }  else {
            $('#myspinner').show();
            $.get('savepethistory', {'phdesc':phdesc, 'phdate':phdate, 'phremarks':phremarks, 'pid':pid, 'phid':phid} , function(data){
                data = JSON.parse(data);
                if (data.res) {
                    $('select[name="m_phdesc"]').val('');
                    $('input[name="m_phdate"]').val('');
                    $('textarea[name="m_phremarks"]').val('');
                    $('#m_phid').val('');

                    pethisHtml(data.pethist);
                } else {
                    alert('Error! Please check your connection.');
                }
                
            })
            .always(function() {
                $('#myspinner').hide();
            });
        }
    });



    $('#modal_pet_history').on('click', 'a[name="m_pet_hist_edit"]', function() {
        var phid = $(this).attr('data-phid');        
        var pid = $('#m_pid_his').val();
        $('#m_pet_his_ttbody_details tr').removeClass('highlighted');
        $(this).closest('tr').addClass('highlighted');

        $('#myspinner').show();
        $.get('editpethistory', {'pid':pid, 'phid':phid} , function(data){
            data = JSON.parse(data);

            //pethisHtml(data.pethist);

            $('#m_phid').val(phid);
            $('select[name="m_phdesc"]').val(data.res[0].phdesc);
            $('input[name="m_phdate"]').val(data.res[0].phdate);
            $('textarea[name="m_phremarks"]').val(data.res[0].phremarks);
        })
        .always(function() {
            $('#myspinner').hide();
        });

    });

    $('#modal_pet_history').on('click', 'a[name="m_pet_hist_delete"]', function() {
        var cnfrm = confirm('Delete this data?');
        if (cnfrm) {
            var phid = $(this).attr('data-phid');
            var pid = $('#m_pid_his').val();
            $('#myspinner').show();
            $.get('deletepethistory', {'phid':phid, 'pid':pid} , function(data){
                data = JSON.parse(data);
                console.log(data);
                if (data.res) {
                    pethisHtml(data.pethist);
                } else {
                    alert('Error! Please check your connection.');
                }
                
            })
            .always(function() {
                $('#myspinner').hide();
            });   
        }
    });


    /*cancel pet history*/
    $('#modal_pet_history').on('click', '#m_pet_hist_cancel', function() {
        $('#m_phid').val('');
        $('#m_phdesc').val('');
        $('#m_phdate').val('');
        $('#m_phremarks').val('');
        var pid = $('#m_pid_his').val();

        $('#myspinner').show();
        $.get('selpethistory', {'pid':pid} , function(data){
            data = JSON.parse(data);
            pethisHtml(data.res);
        })
        .always(function() {
            $('#myspinner').hide();
        });
    });

    /* end health history */
    
});
