<?php $this->load->view("page/headerlink"); ?>
<body class="">
    <?php $this->load->view("page/headerpage"); ?>
    <div class="content-scroll wrapper">
        <?php $this->load->view("page/leftpage"); ?>
        <div class="content-wrapper" id="content-wrapper">
            <section class="content section">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="panel panel-default">
                                <div class="panel-header">
                                    Unit
                                    <span class="pull-right">
                                        <a href="javascript:void(0);" id="unit_add" title="add unit" class="btn btn-success btn-sm"><i class="fa fa-plus-square"></i> Add Unit</a>
                                    </span>
                                </div>
                                <div class="panel-body">

                                    <table class="table table-striped" id="tbl_dt_unitindex">
                                        <thead>
                                            <tr>
                                                <th>Code</th>
                                                <th>Description</th>
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

    <div class="modal fade" id="modal_unitindex" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="m_title">Add Unit</h4>
                </div>

                <form action="unit/unitsave" method="post">
                    <div class="modal-body">     
                        <input type="hidden" id="m_unitid" name="m_unitid">               
                        <div class="form-group">
                            <label for="m_unitcode">Code <span class="required"> *</span></label>
                            <input type="text" class="form-control input-sm" id="m_unitcode" name="m_unitcode" placeholder="start typing here..." required="required">
                        </div>
                        <div class="form-group">
                            <label for="m_unitdesc">Description <span class="required"> *</span></label>
                            <input type="text" class="form-control input-sm" id="m_unitdesc" name="m_unitdesc" placeholder="start typing here..." required="required">
                        </div>
                        <div class="form-group">
                            <label for="m_unitstatus">Status <span class="required"> *</span></label>
                            <select class="form-control input-sm" id="m_unitstatus" name="m_unitstatus" required="required">
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
    <script type="text/javascript" src="<?php echo base_url() . 'assets/js/unitsindex.js'; ?>"></script>
</body>