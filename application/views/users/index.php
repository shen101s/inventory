<?php $this->load->view("page/headerlink"); ?>
<body class="">
    <?php $this->load->view("page/headerpage"); ?>
    <div class="content-scroll wrapper">
        <?php $this->load->view("page/leftpage"); ?>
        <div class="content-wrapper" id="content-wrapper">
            <section class="content section">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-header">
                                    Users
                                    <span class="pull-right">
                                        <a href="javascript:void(0);" id="user_add" title="Add User" class="btn btn-success btn-sm"><i class="fa fa-plus-square"></i> Add User</a>
                                    </span>
                                </div>
                                <div class="panel-body">

                                    <table class="table table-striped" id="tbl_dt_usersindex">
                                        <thead>
                                            <tr>
                                                <th>User Name</th>
                                                <th>First Name</th>
                                                <th>Middle Name</th>
                                                <th>Last Name</th>
                                                <th>Privilege</th>
                                                <th>Status</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <div class="modal fade" id="modal_userindex" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="m_title">Add User</h4>
                </div>

                <form action="users/usersave" method="post">
                    <div class="modal-body">     
                        <input type="hidden" id="m_lid" name="m_lid">    

                        <div class="div-add">           
                            <div class="form-group">
                                <label for="m_uname">User Name <span class="required"> *</span></label>
                                <input type="text" class="form-control input-sm" id="m_uname" name="m_uname" placeholder="start typing here..." required="required">
                            </div>
                            <div class="form-group">
                                <label for="m_pword">Password <span class="required"> *</span></label>
                                <input type="password" class="form-control input-sm" id="m_pword" name="m_pword" placeholder="start typing here..." required="required">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="m_fname">First Name <span class="required"> *</span></label>
                            <input type="text" class="form-control input-sm" id="m_fname" name="m_fname" placeholder="start typing here..." required="required">
                        </div>
                        <div class="form-group">
                            <label for="m_mname">Middle Name </label>
                            <input type="text" class="form-control input-sm" id="m_mname" name="m_mname" placeholder="start typing here...">
                        </div>
                        <div class="form-group">
                            <label for="m_lname">Last Name <span class="required"> *</span></label>
                            <input type="text" class="form-control input-sm" id="m_lname" name="m_lname" placeholder="start typing here..." required="required">
                        </div>
                        
                        <div class="form-group">
                            <label for="m_privilege">Privilege <span class="required"> *</span></label>
                            <select class="form-control input-sm" id="m_privilege" name="m_privilege" required="required">
                                <option value="">Select...</option>
                                <option value="99">Superadmin</option>
                                <option value="1">Admin</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="m_status">Status <span class="required"> *</span></label>
                            <select class="form-control input-sm" id="m_status" name="m_status" required="required">
                                <option value="">Select...</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-sm">Save changes</button>
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <div class="modal fade" id="modal_userpassword" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Change Password</h4>
                </div>
                <form action="users/userchangepassword" method="post">
                    <div class="modal-body">     
                        <input type="hidden" id="m_pw_lid" name="m_pw_lid">    

                        <div class="form-group">
                            <label for="m_pword">Password <span class="required"> *</span></label>
                            <input type="password" class="form-control input-sm" id="m_pw_pword" name="m_pw_pword" placeholder="start typing here..." required="required">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-sm">Save changes</button>
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php $this->load->view('page/footerpage');?>
    <script type="text/javascript" src="<?php echo base_url() . 'assets/js/usersindex.js'; ?>"></script>
</body>