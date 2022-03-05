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
                                    Species
                                    <span class="pull-right">
                                        <a href="javascript:void(0);" id="specadd" title="add unit" class="btn btn-success btn-sm"><i class="fa fa-plus-square"></i> Add Species</a>
                                    </span>
                                </div>
                                <div class="panel-body">

                                    <table class="table table-striped" id="tbl_dt_unitindex">
                                        <thead>
                                            <tr>
                                                <th>Description</th>
                                                <th>Status</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6" id="div_spec" style="display: none;">
                            <div class="panel panel-default">
                                <div class="panel-header">
                                    <input type="hidden" name="inp_specid" id="inp_specid">
                                    List of <span id="span_specdesc" style="text-decoration: underline;">...</span> Breed
                                    <span class="pull-right">
                                        <a href="javascript:void(0);" id="breedadd" title="Add Price" class="btn btn-success btn-sm"><i class="fa fa-plus-square"></i> Add  Breed</a>
                                    </span>
                                </div>
                                <div class="panel-body">
                                    <table class="table table-striped" id="tbl_dt_breedindex">
                                        <thead>
                                            <tr>
                                                <th>Description</th>
                                                <th>Status</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <div class="modal fade" id="modal_specindex" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="m_title">Add Species</h4>
                </div>

                <form id="form_species" method="post">
                    <div class="modal-body">     
                        <input type="hidden" id="m_specid" name="m_specid"> 
                        <div class="form-group">
                            <label for="m_specdesc">Description <span class="required"> *</span></label>
                            <input type="text" class="form-control input-sm" id="m_specdesc" name="m_specdesc" placeholder="start typing here..." required="required">
                        </div>
                        <div class="form-group">
                            <label for="m_specstatus">Status <span class="required"> *</span></label>
                            <select class="form-control input-sm" id="m_specstatus" name="m_specstatus" required="required">
                                <option value="">Select...</option>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary btn-sm" id="m_specsave">Save changes</button>
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="modal_breedindex" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="m_title_b">Add Breed</h4>
                </div>

                <form id="form_breed" method="post">
                    <div class="modal-body">     
                        <input type="hidden" id="m_specid_" name="m_specid"> 
                        <input type="hidden" id="m_breedid" name="m_breedid"> 
                        <div class="form-group">
                            <label for="m_breeddesc">Description <span class="required"> *</span></label>
                            <input type="text" class="form-control input-sm" id="m_breeddesc" name="m_breeddesc" placeholder="start typing here..." required="required">
                        </div>
                        <div class="form-group">
                            <label for="m_breedstatus">Status <span class="required"> *</span></label>
                            <select class="form-control input-sm" id="m_breedstatus" name="m_breedstatus" required="required">
                                <option value="">Select...</option>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary btn-sm" id="m_breedsave">Save changes</button>
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php $this->load->view('page/footerpage');?>
    <script type="text/javascript" src="<?php echo base_url() . 'assets/js/speciesindex.js'; ?>"></script>
</body>