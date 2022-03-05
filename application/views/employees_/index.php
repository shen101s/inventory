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
                                    Employees
                                    <span class="pull-right">
                                        <a href="javascript:void(0);" id="emp_add" title="Add Employee" class="btn btn-success btn-sm"><i class="fa fa-plus-square"></i> Add Employee</a>
                                    </span>
                                </div>
                                <div class="panel-body">

                                    <table class="table table-striped" id="tbl_dt_empindex">
                                        <thead>
                                            <tr>
                                                <th>First Name</th>
                                                <th>Middle Name</th>
                                                <th>Last Name</th>
                                                <th>Position</th>
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

    <div class="modal fade" id="modal_empindex" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="m_title">Add Employee</h4>
                </div>

                <form action="employees/empsave" method="post">
                    <div class="modal-body">     
                        <input type="hidden" id="m_empid" name="m_empid">               
                        <div class="form-group">
                            <label for="m_efname">First Name <span class="required"> *</span></label>
                            <input type="text" class="form-control input-sm" id="m_efname" name="m_efname" placeholder="start typing here..." required="required">
                        </div>
                        <div class="form-group">
                            <label for="m_emname">Middle Name </label>
                            <input type="text" class="form-control input-sm" id="m_emname" name="m_emname" placeholder="start typing here...">
                        </div>
                        <div class="form-group">
                            <label for="m_elname">Last Name <span class="required"> *</span></label>
                            <input type="text" class="form-control input-sm" id="m_elname" name="m_elname" placeholder="start typing here..." required="required">
                        </div>
                        <div class="form-group">
                            <label for="m_eposition">Position </label>
                            <input type="text" class="form-control input-sm" id="m_eposition" name="m_eposition" placeholder="start typing here...">
                        </div>

                        <div class="form-group">
                            <label for="m_estatus">Status <span class="required"> *</span></label>
                            <select class="form-control input-sm" id="m_estatus" name="m_estatus" required="required">
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

    <?php $this->load->view('page/footerpage');?>
    <script type="text/javascript" src="<?php echo base_url() . 'assets/js/empindex.js'; ?>"></script>
</body>