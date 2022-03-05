$(document).ready(function() {
	'use strict';

    $('#l_barcode').addClass('active');


    /**
     * display toal amount
     */
    var displayTotalAmountOnly = function() {
        var totamount = 0;
        $('.brlibdamount').each(function(){
            totamount += parseFloat($(this).text());  // Or this.innerHTML, this.innerText
        });
        $('#bcsummarytot').val(totamount.toFixed(2));
        
    }


    /**
     * Display change in summary section
     */
    var displayChangeSummary = function() {
        var bcsummarytot = $('#bcsummarytot').val();
        var bcsummarytendered = $.trim($('#bcsummarytendered').val());
        var change = bcsummarytendered - bcsummarytot;
        $('#bcsummarychange').val(change.toFixed(2));

        if (bcsummarytendered.length > 0) {
            $('#brsavetrans').removeClass('disabled');
        } else {
            $('#brsavetrans').addClass('disabled');
        }
    }

    $('#bcsummarytendered').on('keyup',function(e) {
        displayChangeSummary();
        if(e.which == 13) { /* Enter */
            savetransaction();
        }
    });


    /**
     * Add items using barcode
     */
    var additem = function(barcode, bcqty, bcdiscount, libdid, enc) {
        $('#myspinner').show();
        $.get('billing/additem', {'barcode':barcode, 'libdid':libdid, 'enc':enc}, function(data){
            data = JSON.parse(data);

            var str = '';
            var len = data.res.length;
            if (len > 0) {
                if ((data.res[0].libdqty * 1) > 0 && (data.res[0].libdqtyrem * 1) < (bcqty * 1)) {
                    Swal.fire({icon: 'warning', title: 'Oops...', text: ('Remaining balance is ' + data.res[0].libdqtyrem) });
                } else {
                    var subtotal = (data.res[0].libdprice * bcqty) - (bcdiscount * bcqty);
                    str += '<tr>';
                        str += '<td><input type="checkbox" name="brlibdid[]" data-libdbarcode="' + data.res[0].libdbarcode + '"data-brqty="' + bcqty + '" data-brdiscount="' + bcdiscount + '" value="' + data.res[0].libdid + '"></td>';
                        //str += '<td>' + ($('#tbody_barcode tr').length + 1) + '</td>';
                        str += '<td class="tditem">' + data.res[0].libdesc + '</td>';
                        str += '<td>' + data.res[0].unitcode + '</td>';
                        str += '<td style="text-align:right;"  class="tdprice">' + data.res[0].libdprice + '</td>';
                        str += '<td style="text-align:right;"  class="tdqty">' + bcqty + '</td>';
                        str += '<td style="text-align:right;"  class="tddiscount">' + bcdiscount + '</td>';
                        str += '<td style="text-align:right;" class="brlibdamount">' + subtotal.toFixed(2) + '</td>';
                    str += '</tr>';
                    $('#bcscan').val('');
                }

            } else {
                Swal.fire({icon: 'error', title: 'Oops...', text: 'Item not found'});
            }
           
            $('#tbody_barcode').append(str);
            displayTotalAmountOnly();
            displayChangeSummary();

            $('#bcqty').val('');
            $('#bcdiscount').val('');
            
        })
        .always(function() {
            $('#myspinner').hide();
        });
    };


    /**
     * get all checked items
     */
    var getcheckeditems = function() {
        var transdet = [];
        var transdet_ = [];
        $('input[name="brlibdid[]"]').each(function() {
            var brqty = $(this).attr('data-brqty');
            var brdiscount = $(this).attr('data-brdiscount');
            var brlibdid = $(this).val();

            transdet_ = [brlibdid, brqty, brdiscount];
            transdet.push(transdet_);
        });

        return transdet;
    };

    var savetransaction = function() {
        var bcsummarychange = $('#bcsummarychange').val();
        var bcsummarytendered = $('#bcsummarytendered').val();
        var inp_oid = $('#inp_oid').val();

        if (($.trim(bcsummarytendered)).length === 0) {
            Swal.fire({icon: 'error', title: 'Oops...', text: '"CASH" must not be empty!'})
        } else if ($.isNumeric(bcsummarytendered) && bcsummarychange < 0) {
            Swal.fire({icon: 'error', title: 'Oops...', text: '"CHANGE" must not be negative!'}) 
        } else if ($.isNumeric(bcsummarytendered) && bcsummarychange >= 0) {
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
                    var transdet = getcheckeditems();
                    $('#myspinner').show();
                    $.get('billing/savetrans', {'transdet':transdet, 'trancash':bcsummarytendered, 'oid':inp_oid}, function(data){
                        data = JSON.parse(data);
                        if (data.res == false) {
                            Swal.fire({icon: 'error', title: 'Oops...', text: 'Something went wrong!'})
                        } else {
                            $('#modal-title-trans_pet_his_msg').html('Message: Success!');

                            var cash = 0.00;
                            if (data.transact.length > 0) {
                                $('#brtrannumber').html('TC: ' + data.transact[0].trannumber);
                                $('#brdategenerated').html(data.transact[0].trandateadded);

                                var clientname = (data.transact[0].oid == null || data.transact[0].oid == 0) ? '' : (data.transact[0].ofname + ' ' + data.transact[0].olname);
                                $('#brclientname').html(clientname);

                                cash = data.transact[0].trancash * 1;
                            }
                            
                            $('#div_receipt').html(receiptHtml(data.itemlist, cash));

                            $('#modal_br_success').modal({
                                backdrop: 'static',
                                'keyboard': false
                            });
                        }
                    })
                    .always(function() {
                        $('#myspinner').hide();
                    });
                }
            })


            // Swal.fire({
            //     title: 'Do you want to save?',
            //     icon: 'question',
            //     showCancelButton: true,
            //     confirmButtonColor: '#3085d6',
            //     cancelButtonColor: '#d33',
            //     confirmButtonText: 'Yes, delete it!'
            // }).then((result) => {
            //     if (result.isConfirmed) {
            //         Swal.fire(
            //             'Deleted!',
            //             'Your file has been deleted.',
            //             'success'
            //         )
            //     }
            // })

            // var cnfrm = confirm('Save Transaction?');
            // if (cnfrm) {
            //     var transdet = getcheckeditems();

            //     $('#myspinner').show();
            //     $.get('billing/savetrans', {'transdet':transdet, 'trancash':bcsummarytendered, 'oid':inp_oid}, function(data){
            //         data = JSON.parse(data);
            //         if (data.res == false) {
            //             alert('Ooppss!, There\s something wrong!');
            //         } else {
            //             $('#modal-title-trans_pet_his_msg').html('Message: Success!');

            //             var cash = 0.00;
            //             if (data.transact.length > 0) {
            //                 $('#brtrannumber').html('TC: ' + data.transact[0].trannumber);
            //                 $('#brdategenerated').html(data.transact[0].trandateadded);

            //                 var clientname = (data.transact[0].oid == null || data.transact[0].oid == 0) ? '' : (data.transact[0].ofname + ' ' + data.transact[0].olname);
            //                 $('#brclientname').html(clientname);

            //                 cash = data.transact[0].trancash * 1;
            //             }
                        
            //             $('#div_receipt').html(receiptHtml(data.itemlist, cash));

            //             $('#modal_br_success').modal({
            //                 backdrop: 'static',
            //                 'keyboard': false
            //             });
            //         }
            //     })
            //     .always(function() {
            //         $('#myspinner').hide();
            //     });
            // }
        } else {
            Swal.fire({icon: 'error', title: 'Oops...', text: 'Cash value must be numeric!'});
        }
    };

    var deletetransaction = function() {
        var cnfrm = confirm('Delete item?');
        if (cnfrm) {
            $('#myspinner').show();
            $('#tbody_barcode').find('input[name="brlibdid[]"]').each(function(){
                if($(this).is(':checked')){
                    $(this).parents('tr').remove();
                }
            });
            displayTotalAmountOnly();
            displayChangeSummary();
            $('#myspinner').hide();
        }
    };

    var canceltransaction = function() {
        var cnfrm = confirm('Cancel Transaction?');
        if (cnfrm) {
            location.reload();
        }
    }

    var discountitem = function() {
        var inpcheckbox = $('input[name="brlibdid[]"]:checked');
        if (inpcheckbox.length === 1) {
            $('#mod_br_item').val($(inpcheckbox).parents('tr').find('.tditem').html());
            $('#mod_br_qty').val($(inpcheckbox).parents('tr').find('.tdqty').html());
            $('#mod_br_discount').val($(inpcheckbox).parents('tr').find('.tddiscount').html());
            $('#mod_br_libdid').val($(inpcheckbox).val());

            $('#modal_br_discount').modal({
                backdrop: 'static',
                'keyboard': false
            });    
        } else {
            Swal.fire({icon: 'warning', title: 'Oops...', text: 'Select only one item to add discount!'});
        }
    }

    /** 
     * Edit discount item in checked row
     */

     // TODO remove selected item first then call the add item
     // not related in modal. in billin add column for barcode number
    $('#modal_br_discount').on('click', '#brmodaldiscountsubmit', function() {
        var libdid = $('#mod_br_libdid').val();
        var bcqty = $('#mod_br_qty').val();
        var bcdiscount = $('#mod_br_discount').val();

        // start delete old item
        $('#myspinner').show();
        $('#tbody_barcode').find('input[name="brlibdid[]"]').each(function(){
            if($(this).is(':checked')){
                $(this).parents('tr').remove();
            }
        });
        displayTotalAmountOnly();
        displayChangeSummary();
        $('#myspinner').hide();
        // end delete old item


        additem(-1, bcqty, bcdiscount, libdid, 'YES');
        $('#modal_br_discount').modal('hide');


        // var inpcheckbox = $('input[name="brlibdid[]"]:checked');
        // var price = $(inpcheckbox).parents('tr').find('.tdprice').html();
        // var subtotal = (price * qty) - (discount * qty);

        // $(inpcheckbox).parents('tr').find('.brlibdamount').html(subtotal.toFixed(2));
        // $(inpcheckbox).parents('tr').find('.tdqty').html(qty);
        // $(inpcheckbox).parents('tr').find('.tddiscount').html(discount);    

        // $(inpcheckbox).attr('data-brqty', qty);
        // $(inpcheckbox).attr('data-brdiscount', discount);


        // $('input[name="brlibdid[]"]').prop("checked", false);

        // displayTotalAmountOnly();
        // displayChangeSummary();
        // $('#modal_br_discount').modal('hide');    
    });

    $('#bcscan').on('keypress',function(e) {
        if(e.which == 13) {
            var barcode = $.trim($(this).val());
            var bcqty = $.trim($('#bcqty').val());
            var bcdiscount =  $.trim($('#bcdiscount').val());

            bcqty = bcqty.length === 0 ? 1 : bcqty;
            bcdiscount = bcdiscount.length === 0 ? 0 : bcdiscount;
            additem(barcode, bcqty, bcdiscount, -1, 'NO');


            $('#brdeleteitem').removeClass('disabled');
            $('#brdiscountitem').removeClass('disabled');
            $('#brcanceltrans').removeClass('disabled');
            $('#brsavetrans').removeClass('disabled');
        }
    });


    /* focus modal*/
    $("#modal_br_success").on('shown.bs.modal', function(){
        $(this).find('#print').focus();
    });

    $("#modal_br_discount").on('shown.bs.modal', function(){
        $(this).find('#mod_br_discount').focus();
    });



    
    

    $('#content-wrapper').on('click', '#brsavetrans', function() {
        savetransaction();
    });

    $('#content-wrapper').on('click', '#brdeleteitem', function() {
        deletetransaction();
    });

    $('#content-wrapper').on('click', '#brcanceltrans', function() {
        canceltransaction();
    });

    $('#content-wrapper').on('click', '#brdiscountitem', function() {
        discountitem();
    });

    $('body').keydown(function(event) {
        if(event.which == 112) { //F1
            $('#bcscan').focus();
            return false;
        } else if(event.which == 113) { //F2
            $('#bcqty').focus();
            return false;
        } else if(event.which == 114) { //F3
            $('#bcdiscount').focus();
            return false;
        } else if(event.which == 115) { //F4
            $('#bcsummarytendered').focus();
            return false;
        } else if(event.which == 116) { //F5
            return false;
        } else if(event.which == 117) { //F6
            if ($('#brsavetrans').hasClass('disabled') == false) {
                savetransaction();
            }
            return false;
        } else if(event.which == 118) { //F7
            if ($('#brcanceltrans').hasClass('disabled') == false) {
                canceltransaction();
            }
            return false;
        } else if(event.which == 119) { //F8
            if ($('#brdiscountitem').hasClass('disabled') == false) {
                discountitem();
            }
            return false;
        } else if(event.which == 120) { //F9
            if ($('#brdeleteitem').hasClass('disabled') == false) {
                deletetransaction();
            }
            return false;            
        } else if(event.which == 121) { //F10
            modal_brsearchitem();
            return false;            
        }

    });


    $('#content-wrapper').on('click', '#tbody_barcode td', function() {
        var check_ = $(this).parent('tr').find('input:checkbox')
        check_.prop("checked", !check_.prop("checked"));
    });


    $('#content-wrapper').on('click', '#brsearchitem', function() {
        modal_brsearchitem();
    });

    var modal_brsearchitem = function() {
        $('#modal_inp_bc_search').val('');
        var str = '<tr><td colspan="5" class="text-center">No data available in table</td></tr>';
        $('#modal_tbody_search_item').html(str);

        $('#modal_bc_search').modal({
            backdrop: 'static',
            'keyboard': false
        });

        $('#modal_bc_search').on('shown.bs.modal', function () {
            $('#modal_inp_bc_search').focus();
        });

    };


    $('#modal_bc_search').on('keypress', '#modal_inp_bc_search', function(e) {
        if(e.which == 13) { /* Enter */
            var search_item = $.trim($(this).val());
            if (search_item.length === 0) {
                return false;
            }

            $('#myspinner').show();
            $.get('billing/searchitem', {'search_item':search_item}, function(data){
                data = JSON.parse(data);
                var str = '';
                var len = data.res.length;
                for (var i = 0; i < len; i++) {
                    str += '<tr>';
                        str += '<td><input type="hidden" value="'+data.res[i].libdid+'" name="sel_search_item">' + data.res[i].libdbarcode + '</td>';
                        str += '<td>' + data.res[i].libdesc + '</td>';
                        str += '<td>' + data.res[i].unitcode + '</td>';
                        str += '<td>' + data.res[i].libdprice + '</td>';
                        str += '<td>' + data.res[i].libdexp + '</td>';
                        //str += '<td><a href="javascript:void(0);" data-libdid="'+data.res[i].libdid+'" name="sel_search_item"><i class="fa fa-location-arrow"></i></a></td>';
                    str += '</tr>';
                }
                
                if (len === 0) {
                    str += '<tr><td colspan="5" class="text-center">No data available in table</td></tr>';
                }

                $('#modal_tbody_search_item').html(str);
            })
            .always(function() {
                $('#myspinner').hide();
            });

             e.preventDefault();
        } 
    });


    $('#modal_bc_search').on('click', '#modal_tbody_search_item td', function() {
        //var  libdid = $(this).attr('data-libdid');
        var  libdid = $(this).parent('tr').find('input[name="sel_search_item"]').val();

        if (libdid === undefined) {
            return false;
        }

        var bcqty = $.trim($('#bcqty').val());
        var bcdiscount =  $.trim($('#bcdiscount').val());

        bcqty = bcqty.length === 0 ? 1 : bcqty;
        bcdiscount = bcdiscount.length === 0 ? 0 : bcdiscount;
        additem(-1, bcqty, bcdiscount, libdid, 'NO');

        $('#brdeleteitem').removeClass('disabled');
        $('#brdiscountitem').removeClass('disabled');
        $('#brcanceltrans').removeClass('disabled');
        //$('#brsavetrans').removeClass('disabled');

        $('#modal_bc_search').modal('hide');
    });





    
    $('#content-wrapper').on('click', '#search_cancel', function() {
        $('#inp_clientname').val('');
        $('#inp_oid').val('');
    });

    $('#content-wrapper').on('click', '#search_client', function() {
        $('#myspinner').show();
        var table = $('#tbl_dt_client_name').DataTable( {
            'responsive':true,
            'autoWidth':false,
            'processing': true,
            'serverSide': true,
            'stateSave': true,
            'destroy': true,
            'ajax': {
                url: 'dtownerdata',
                error: function () {
                    console.log('error');
                }
            },
            'columns': [
                { 'data': 'ofname' },
                { 'data': 'omname' },
                { 'data': 'olname' },
                { 'data': 'oaddress' },
                { 'data': 'ocontactnum' },
                { 'data': 'oid',
                    "orderable": false,
                    "searchable": false,
                    "render": function(data,type,row,meta) {
                        var a = '';
                        a += '<a href="javascript:void(0);" data-oid="'+row.oid+'" data-clientname="'+row.ofname+' '+row.olname+'" title="select owner"  name="selectowner"></a>';
                        return a;
                    } 
                }

            ],
            'columnDefs': [ {
                'targets': [0,1],
                'orderable': false,
            }],
            'order': [[0, 'desc']],
            'initComplete': function(settings, json) {
                $('#modal_client_name').modal({
                    backdrop:'static',
                    keyboard: false
                });
                $('#myspinner').hide();
            }
        });


        $('.dataTables_filter input').unbind().keyup(function(e) {
            if(e.keyCode == 13) {
                var value = $(this).val();
                table.search(value).draw();
            }
        });

    });

    

    $('#modal_client_name').on('click', '#a_add_client_name', function() {
        $('#modal_client_name').modal('hide');    

        $('#modal-title-trans').html('Add Client');
        $('#m_oid').val('');
        $('#m_fname').val('');
        $('#m_mname').val('');
        $('#m_lname').val('');
        $('#m_address').val('');
        $('#m_contactnum').val('');
        $('#m_emailadd').val('');
        $('#m_page').val('BILLING');

        $('#modal_trans').modal({
            backdrop: 'static',
            keyboard: false
        });
    });

    $('#modal_trans').on('click', '#m_client_submit', function(e) {
        e.preventDefault();

        var fname = $.trim($('#m_fname').val());
        var lname = $.trim($('#m_lname').val());
        var address = $.trim($('#m_address').val());
        var contactnum = $.trim($('#m_contactnum').val());

        if (fname.length === 0 || lname.length === 0 || address.length === 0 || contactnum.length === 0) {
            Swal.fire({icon: 'warning', title: 'Oops...', text: 'Required field must not be empty!'});
        } else {
            $('#myspinner').show();
            $.post('transsave', $('#transsave').serialize(), function(data){
                data = JSON.parse(data);
                $('#inp_oid').val(data.res.m_oid);
                $('#inp_clientname').val(data.res.clientname);
                $('#modal_trans').modal('hide'); 
            })
            .always(function() {
                $('#myspinner').hide();
            });
        }
    });


    // var displaypet = function(pet) {
    //     var str = '<option value="">--Select--</option>';
    //     var len = pet.length;
    //     for (var i = 0; i < len; i++) {
    //         str += '<option value="' + pet[i].pid + '">' + pet[i].pname + '</option>';
    //     }
    //     return str;
    // };

    $('#modal_client_name').on('click', '#tbl_dt_client_name tbody tr td', function() {
        var  oid = $(this).parent('tr').find('a[name="selectowner"]').attr('data-oid');
        var  clientname = $(this).parent('tr').find('a[name="selectowner"]').attr('data-clientname');


        if (oid === undefined) {
            return false;
        }
        
        $('#inp_oid').val(oid);
        $('#inp_clientname').val(clientname);
        $('#modal_client_name').modal('hide');

        // var oid = $(this).attr('data-oid');
        // $('#inp_oid').val(oid);
        // $('#inp_clientname').val($(this).attr('data-clientname'));
        // $('#modal_client_name').modal('hide');
    });



    // /* start pet*/
    // $('#m_fpetbday').datepicker({ format: 'M dd, yyyy' });
    // $('#modal_trans_pet').on('change', '#m_fpetspecies', function() {
    //     var specid = $(this).val();
        
    //     $('#myspinner').show();
    //     $.get('selectbreed', {'specid':specid} , function(data){
    //         data = JSON.parse(data);
    //         var breedhtml = breedHtml(data.breed);
    //         $('#m_fpetbreed').html(breedhtml);
    //     })
    //     .always(function() {
    //         $('#myspinner').hide();
    //     });
    // });


    // /*save pet*/
    // $('#modal_trans_pet').on('click', '#m_pet_add', function() {
    //     var m_fpetname = $.trim($('#m_fpetname').val());
    //     var m_fpetbday = $.trim($('#m_fpetbday').val());
    //     var m_fpetspecies = $.trim($('#m_fpetspecies').val());
    //     var m_fpetbreed = $.trim($('#m_fpetbreed').val());
    //     var m_fpetgender = $.trim($('#m_fpetgender').val());

    //     var m_pid = $.trim($('#m_pid').val());
    //     var m_oidpet = $.trim($('#m_oidpet').val());


    //     if (m_fpetname.length === 0 || m_fpetbday.length === 0 || m_fpetspecies.length === 0 ||
    //             m_fpetbreed.length === 0 || m_fpetgender.length === 0) {
    //         alert('Required field must not be empty!')
    //     }  else {
    //         $('#myspinner').show();
    //         $.post('savepet', {'m_pid':m_pid, 'm_oidpet':m_oidpet, 'm_fpetname':m_fpetname, 'm_fpetbday':m_fpetbday, 'm_fpetspecies':m_fpetspecies, 'm_fpetbreed':m_fpetbreed, 'm_fpetgender':m_fpetgender} , function(data){
    //             data = JSON.parse(data);
    //             if (data.res) {
    //                 $('#m_pid').val('');
    //                 $('#m_fpetname').val('');
    //                 $('#m_fpetbday').val('');
    //                 $('#m_fpetspecies').val('');
    //                 $('#m_fpetbreed').val('');
    //                 $('#m_fpetgender').val('');

    //                 petHtml(data.pet, data.species, data.breed);

    //                 var spechtml = specHtml(data.species);
    //                 var breedhtml = breedHtml(data.breed);

    //                 $('#m_fpetspecies').html(spechtml);
    //                 $('#m_fpetbreed').html(breedhtml);

    //                 $('#sel_pid').html(displaypet(data.pet));

    //             } else {
    //                 alert('Error! Please check your connection.');
    //             }
                
    //         })
    //         .always(function() {
    //             $('#myspinner').hide();
    //         });
    //     }
    // });

    // /* update pet*/
    // $('#modal_trans_pet').on('click', 'a[name="m_pet_add_m"]', function() {
    //     var tr = $(this).parents('tr');


    //     var m_fpetname = $.trim(tr.find('input[name="m_fpetname"]').val());
    //     var m_fpetbday = $.trim(tr.find('input[name="m_fpetbday"]').val());
    //     var m_fpetspecies = $.trim(tr.find('select[name="m_fpetspecies"]').val());
    //     var m_fpetbreed = $.trim(tr.find('select[name="m_fpetbreed"]').val());
    //     var m_fpetgender = $.trim(tr.find('select[name="m_fpetgender"]').val());

    //     var m_pid = $(this).attr('data-pid');
    //     var m_oidpet = $(this).attr('data-oid');


    //     if (m_fpetname.length === 0 || m_fpetbday.length === 0 || m_fpetspecies.length === 0 ||
    //             m_fpetbreed.length === 0 || m_fpetgender.length === 0) { 
    //         alert('Required field must not be empty!')
    //     }  else {
    //         $('#myspinner').show();
    //         $.post('savepet', {'m_pid':m_pid, 'm_oidpet':m_oidpet, 'm_fpetname':m_fpetname, 'm_fpetbday':m_fpetbday, 'm_fpetspecies':m_fpetspecies, 'm_fpetbreed':m_fpetbreed, 'm_fpetgender':m_fpetgender} , function(data){
    //             data = JSON.parse(data);

    //             console.log(data);
    //             if (data.res) {
    //                 $('#m_pid').val('');
    //                 $('#m_fpetname').val('');
    //                 $('#m_fpetbday').val('');
    //                 $('#m_fpetspecies').val('');
    //                 $('#m_fpetbreed').val('');
    //                 $('#m_fpetgender').val('');

    //                 petHtml(data.pet, data.species, data.breed);

    //             } else {
    //                 alert('Error! Please check your connection.');
    //             }
                
    //         })
    //         .always(function() {
    //             $('#myspinner').hide();
    //         });
    //     }
    // });

    

    // $('#modal_trans_pet').on('click', 'a[name="m_pet_delete"]', function() {
    //     var cnfrm = confirm('Delete this data?');
    //     if (cnfrm) {
    //         var pid = $(this).attr('data-pid');
    //         var oid = $(this).attr('data-oid');
    //         $('#myspinner').show();
    //         $.post('deletepet', {'pid':pid, 'oid':oid} , function(data){
    //             data = JSON.parse(data);
    //             console.log(data);
    //             if (data.res) {
    //                 petHtml(data.pet, data.species, data.breed);
    //             } else {
    //                 alert('Error! Please check your connection.');
    //             }
                
    //         })
    //         .always(function() {
    //             $('#myspinner').hide();
    //         });   
    //     }
    // });

    // /*cancel*/
    // $('#modal_trans_pet').on('click', '#m_pet_cancel', function() {
    //     var oid = $('#m_oidpet').val();
    //     $('#myspinner').show();
    //     $.get('selectpet', {'oid':oid} , function(data){
    //         data = JSON.parse(data);

    //         $('#m_pid').val('');
    //         $('#m_fpetname').val('');
    //         $('#m_fpetbday').val('');
    //         $('#m_fpetspecies').val('');
    //         $('#m_fpetbreed').val('');
    //         $('#m_fpetgender').val('');

    //         petHtml(data.pet, data.species, data.breed);
    //         var spechtml = specHtml(data.species);
    //         var breedhtml = breedHtml(data.breed);

    //         $('#m_fpetspecies').html(spechtml);
    //         $('#m_fpetbreed').html(breedhtml);
    //     })
    //     .always(function() {
    //         $('#myspinner').hide();
    //     });
    // });


    // $('#modal_trans_pet').on('click', 'a[name="m_pet_edit"]', function() {
    //     var pid = $(this).attr('data-pid');        
    //     $('#m_pet_tbody_details tr').removeClass('highlighted');
    //     $(this).closest('tr').addClass('highlighted');

    //     $('#myspinner').show();
    //     $.get('editpet', {'pid':pid} , function(data){
    //         data = JSON.parse(data);

    //         var spechtml = specHtml(data.species);
    //         var breedhtml = breedHtml(data.breed);

    //         $('#m_fpetspecies').html(spechtml);
    //         $('#m_fpetbreed').html(breedhtml);

    //         $('#m_pid').val(data.res[0].pid);
    //         $('#m_fpetname').val(data.res[0].pname);
    //         $('#m_fpetbday').val(data.res[0].pbday);
    //         $('#m_fpetspecies').val(data.res[0].specid);
    //         $('#m_fpetbreed').val(data.res[0].breedid);
    //         $('#m_fpetgender').val(data.res[0].pgender);
    //     })
    //     .always(function() {
    //         $('#myspinner').hide();
    //     });
    // });

    // $('#content-wrapper').on('click', '#add_pet', function() {
    //     var oid = $.trim($('#inp_oid').val());

    //     $('#m_oidpet').val(oid);
    //     var fullname = $.trim($(this).attr('data-fullname'));
    //     $('#modal-title-trans_pet').html('Pet(s) of <u id="p_ownername">' + fullname + '</u>');

    //     $('#m_pid').val('');
    //     $('#m_fpetname').val('');
    //     $('#m_fpetbday').val('');
    //     $('#m_fpetspecies').val('');
    //     $('#m_fpetbreed').val('');
    //     $('#m_fpetgender').val('');

    //     $('#myspinner').show();
    //     $.get('selectpet', {'oid':oid} , function(data){
    //         data = JSON.parse(data);

    //         petHtml(data.pet, data.species, data.breed);
    //         var spechtml = specHtml(data.species);
    //         var breedhtml = []; //breedHtml(data.breed);

    //         $('#m_fpetspecies').html(spechtml);
    //         $('#m_fpetbreed').html(breedhtml);

    //         $('#modal_trans_pet').modal({
    //             backdrop: 'static',
    //             keyboard: false
    //         });
    //     })
    //     .always(function() {
    //         $('#myspinner').hide();
    //     });
    // });



    var setDefault = function() {
        $('#tbody_barcode').html('');

        $('#bcsummarytot').val('');
        $('#bcsummarytendered').val('');
        $('#bcsummarychange').val('');
        
        $('#bcscan').val('');
        $('#bcqty').val('');
        $('#bcdiscount').val('');

        $('#inp_clientname').val('');
        $('#inp_oid').val('');
        
        $('#brdeleteitem').addClass('disabled');
        $('#brdiscountitem').addClass('disabled');
        $('#brcanceltrans').addClass('disabled');
        $('#brsavetrans').addClass('disabled');
    }

    $('#modal_br_success').on('click', '#brmodalclose, #brmodalclosetimes', function() {
        setDefault();
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

});

