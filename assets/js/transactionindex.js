$(document).ready(function() {
	$('#l_trans').addClass('active');

    var dtable = function() {
    	var table = $('#tbl_dt_transindex').DataTable({
            'responsive':true,
            'autoWidth':false,
            'processing': true,
            'serverSide': true,
            'stateSave': true,
            'ajax': {
                'url': 'transaction/dttransindex',
                error: function () {
                    console.log('error');
                }
            },
            'columns': [
                { 'data': 'trannumber' },
                { 'data': 'trandate' },
                { 'data': 'fullname' },
                { 'data': 'totamount' },
                { 'data': 'transid',
                    "orderable": false,
                    "searchable": false,
                    "render": function(data,type,row,meta) {
                        var a = '<a href="'+window.location.origin+localStorage.getItem('sysname_') + '/transaction/clientselect/addnew?o='+row.oid+'&trans='+row.transid+'" title="Edit" name="transedit" ><i class="fa fa-edit"></i></a>';
                        return a;
                    } 
                }
            ]
        });


        $('.dataTables_filter input').unbind().keyup(function(e) {
            if(e.keyCode == 13) {
                var value = $(this).val();
                table.search(value).draw();
            }
        });
        
    };

    dtable();


    $('#tbl_dt_transindex').on('click', 'a[name="transdel"]', function() {
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
                var transid = $(this).attr('data-transid');
                $('#myspinner').show();
                $.post(localStorage.getItem('sysname_') + '/transaction/deltrans', {'transid':transid}, function(data){
                    data = JSON.parse(data);
                    if (data.res) {
                        Swal.fire({icon: 'success', title: 'Success', text: 'Successfully deleted!'});
                    } else {
                        Swal.fire({icon: 'error', title: 'Oops...', text: 'Something went wrong!'});
                    }
                    location.reload();
                })
                .always(function() {
                    $('#myspinner').hide();
                });
            }
        })
    });
	
    $('#tbl_dt_transindex').on('click', 'a[name="pethist"]', function() {
        var pid = $(this).attr('data-pid');
        $('#myspinner').show();
        $.get('selpethistory', {'pid':pid}, function(data){
            data = JSON.parse(data);
            var str = '';
            var len = data.res.length;
            for (var i = 0; i < len; i++) {
                str += '<tr>';
                str += '<td>' + data.res[i].phdesc + '</td>';
                str += '<td>' + data.res[i].phdate + '</td>';
                str += '<td>' + data.res[i].phremarks + '</td>';
                str += '</tr>';
            }

            if (len === 0) {
                str += '<tr><td colspan="3" style="text-align:center;">No data available in table</td></tr>';
            }

            $('#m_pet_his_ttbody_details').html(str);
            
            $('#modal_pet_history').modal({
                backdrop: 'static',
                keyboard: false
            });
        })
        .always(function() {
            $('#myspinner').hide();
        });


        
    });
});
