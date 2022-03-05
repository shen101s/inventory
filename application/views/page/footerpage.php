<style type="text/css">
	#myspinner {
		position: fixed;
		bottom: 0px;
		right: 0px;
		background: rgba(0, 0, 0, 0.3);
		z-index: 1050; 
		width: 100%;
		height: 100%;
	}

	.myspinnerstyle {
		font-size: 50px; 
		z-index: 1047; 
		position: absolute; 
		top: 35%; 
		left: 48%;
	}	
</style>

<?php if ($this->session->userdata('loggedin')) { ?>
	<div class="footer-scroll">
		<img src="<?php echo base_url() . 'assets/img/f.png';?>" style="height: 35px; float: right; margin-right: 20px;">
		<p style="margin-top: 10px;">Vet Clinic Name: Your partner for complete animal health care!</p>
	</div>

	<div class="modal fade" id="modal_changepassword" role="dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" id="brmodalclosetimes">&times;</button>
                    <h4 class="modal-title" id="modal-title-changepassword">Change Password</h4>
                </div>
                <div class="modal-body">
                    <form id="form_changepassword" method="post">
                    	<input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />

                        <div class="form-group">
                            <label for="currentpassword">Current Password <span class="required"> *</span></label>
                            <input type="password" class="form-control input-sm" id="currentpassword" name="currentpassword" placeholder="start typing here..." required="required">
                        </div>
                        <div class="form-group">
                            <label for="newpassword">New Password <span class="required"> *</span></label>
                            <input type="password" class="form-control input-sm" id="newpassword" name="newpassword" placeholder="start typing here...">
                        </div>
                        <div class="form-group">
                            <label for="confirmpassword">Confirm Password <span class="required"> *</span></label>
                            <input type="password" class="form-control input-sm" id="confirmpassword" name="confirmpassword" placeholder="start typing here..." required="required">
                        </div>
	                </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-sm" id="m_cp_savechanges">Save changes</button>
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

<?php } ?>

<span id="myspinner" style="display: none;">
	<i class="fa fa-spinner fa-spin myspinnerstyle"></i><br>
	<h3 style="font-weight:800; z-index: 1047; position: absolute; top: 40%; left: 45%; padding-top: 20px;">L o a d i n g...</h3>
</span>

<script type="text/javascript" src="<?php echo base_url() . 'assets/credits/jquery.min.js'; ?>"></script>
<script type="text/javascript" src="<?php echo base_url() . 'assets/credits/bootstrap/js/bootstrap.min.js'; ?>"></script>
<script type="text/javascript" src="<?php echo base_url() . 'assets/credits/datatable/datatables.min.js'; ?>"></script>
<script type="text/javascript" src="<?php echo base_url() . 'assets/credits/toastr/toastr.min.js'; ?>"></script>
<script type="text/javascript" src="<?php echo base_url() . 'assets/credits/datepicker/bootstrap-datepicker.js'; ?>"></script>

<script type="text/javascript" src="<?php echo base_url() . 'assets/credits/select2/js/select2.full.min.js'; ?>"></script>
<script type="text/javascript" src="<?php echo base_url() . 'node_modules/sweetalert2/dist/sweetalert2.min.js'; ?>"></script>

<script type="text/javascript" src="<?php echo base_url() . 'assets/js/master.js'; ?>"></script>
<script type="text/javascript" src="<?php echo base_url() . 'assets/credits/print/printThis.js';?>"></script>

<script type="text/javascript">
	$(function() {
		<?php if ($this->session->flashdata('success')) { ?>
		    toastr.success("<?php echo $this->session->flashdata('success'); ?>");
		<?php } else if($this->session->flashdata('error')) {  ?>
		    toastr.error("<?php echo $this->session->flashdata('error'); ?>");
		<?php } else if($this->session->flashdata('warning')) {  ?>
		    toastr.warning("<?php echo $this->session->flashdata('warning'); ?>");
		<?php } else if($this->session->flashdata('info')) {  ?>
		    toastr.info("<?php echo $this->session->flashdata('info'); ?>");
		<?php } ?>


		$('#logout').on('click', function() {
	        var cnfrm = confirm('Continue Logout?');
	        if (cnfrm) {
	            window.location.href = '<?php echo base_url() . 'logout';?>';
	        }
	    });



	    function date_time() {
	        var date = new Date;
	        var year = date.getFullYear();
	        var month = date.getMonth();
	        var months = new Array('January', 'February', 'March', 'April', 'May', 'June', 'Jully', 'August', 'September', 'October', 'November', 'December');
	        var d = date.getDate();
	        var day = date.getDay();
	        var days = new Array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
	        var h = date.getHours();
	        if ( h<10 ) {
	            h = "0"+h;
	        }
	        var m = date.getMinutes();
	        if ( m<10 ) {
	            m = "0"+m;
	        }

	        var s = date.getSeconds();
	        if ( s<10 ) {
	            s = "0"+s;
	        }

	        var result = '' + days[day] + ' ' + months[month] + ' ' + d + ', ' + year + ' ' + h + ':' + m + ':' + s;
	        $('#date_time').html(result);
	        setTimeout(date_time, 1000)
	    }
	    
	    date_time();


	    $('#sidebar-nav').on('click', '#changepassword', function() {
	    	$('#m_cp_savechanges').prop('disabled', true);
	    	$('#modal_changepassword').modal({
                backdrop: 'static',
                'keyboard': false
            });
	    });

	    $('#modal_changepassword').on('keyup', '#currentpassword, #newpassword, #confirmpassword', function() {
		    var currentpassword = $.trim($('#currentpassword').val());
		    var newpassword = $.trim($('#newpassword').val());
		    var confirmpassword = $.trim($('#confirmpassword').val());

		     if (currentpassword.length === 0) {
	            $('#m_cp_savechanges').prop('disabled', true);
	            return false;
	        }

		    if (newpassword.length < 6 || confirmpassword.length < 6 ) {
		        $('#m_cp_savechanges').prop('disabled', true);
		    } else {
		        $('#m_cp_savechanges').prop('disabled', true);
		        if (newpassword === confirmpassword) {
		            $('#m_cp_savechanges').prop('disabled', false);    
		        }
		    }
		});



	    $('#modal_changepassword').on('click', '#m_cp_savechanges', function() {
	    	$('#myspinner').show();
	        $.get('changepassword', $('#form_changepassword').serialize(), function(data){
	            data = JSON.parse(data);
	            if (data.res == 1) {
	            	alert('Please login to start new session!');
	            	location.reload();
	            } else if (data.res == 0) {
	            	alert('Incorrect current password!');
	            } else {
	            	alert('Oops.. There\'s something wrong!');
	            }
	        })
	        .always(function() {
	            $('#myspinner').hide();
	        });
	    });



	    $('#navreport').on('click', function() {
            if ($(this).attr('aria-expanded') == 'false') {
                $(this).removeClass('arrow-right');
                $(this).addClass('arrow-down');
            } else {
                $(this).removeClass('arrow-down');
                $(this).addClass('arrow-right');
            }
        });

	});
</script>
