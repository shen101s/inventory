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
                                    Supplies
                                    <span class="pull-right">
                                        <a href="javascript:void(0);" class="btn btn-success btn-sm" id="med_addsupp">Add Supplies</a>
                                    </span>
                                </div>
                                <div class="panel-body">

                                    <table class="table table-striped" id="tbl_dt_suppindex">
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


                        <div class="col-md-6">
                            <div class="panel panel-default" id="div_ind_price" style="display: none;">
                                <div class="panel-header">
                                	<input type="hidden" name="med_indlibid" id="med_indlibid">
                                    Price of <span id="med_indprice" style="text-decoration: underline;">...</span>
                                    <span class="pull-right">
                                        <a href="javascript:void(0);" class="btn btn-success btn-sm" id="med_addprice">Add Price</a>
                                    </span>
                                </div>
                                <div class="panel-body">

                                    <table class="table table-striped" id="tbl_dt_medindexprice">
                                        <thead>
                                            <tr>
                                                <th>Unit</th>
                                                <th>Price</th>
                                                <th>Qty</th>
                                                <th>Qty Remaining</th>
                                                <th>Expiration</th>
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

    <div class="modal fade" id="modal_medindex" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="m_i_title">Add Medicine</h4>
                </div>

                <form action="medicines/medsave" method="post">
                    <div class="modal-body">     
                        <input type="hidden" id="m_med_libid" name="m_med_libid">               
                        <!-- <div class="form-group">
                            <label for="m_med_libcodename">Generic Name <span class="required"> *</span></label>
                            <input type="text" class="form-control input-sm" id="m_med_libcodename" name="m_med_libcodename" placeholder="start typing here..." required="required">
                        </div> -->
                        <div class="form-group">
                            <label for="m_med_libdesc">Description <span class="required"> *</span></label>
                            <input type="text" class="form-control input-sm" id="m_med_libdesc" name="m_med_libdesc" placeholder="start typing here..." required="required">
                        </div>
                        <div class="form-group">
                            <label for="m_med_libstatus">Status <span class="required"> *</span></label>
                            <select class="form-control input-sm" id="m_med_libstatus" name="m_med_libstatus" required="required">
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


    <div class="modal fade" id="modal_medindexprice" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="m_i_titleprice">Add Price</h4>
                </div>

                <form method="post" id="m_form_saveprice">
                    <div class="modal-body">     
                        <input type="hidden" id="m_med_libid_price" name="m_med_libid_price">           
                        <input type="hidden" id="m_med_libdid" name="m_med_libdid">
                        <div class="form-group">
                            <label for="m_med_unit">Unit <span class="required"> *</span></label>
                            <select class="form-control input-sm" id="m_med_unit" name="m_med_unit" required="required">
                                <option value="">Select...</option>
                                <?php 
                                	$len = count($unit);
                                	for ($i=0; $i < $len; $i++) { 
                                ?>
                                		<option value="<?php echo $unit[$i]['unitid'];?>"><?php echo $unit[$i]['unitdesc'];?></option>
                                <?php 
                                	}
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="m_med_libdprice">Price <span class="required"> *</span></label>
                            <input type="text" class="form-control input-sm" id="m_med_libdprice" name="m_med_libdprice" placeholder="start typing here..." required="required">
                        </div>

                        <div class="form-group">
                            <label for="m_med_libdqty">Qty <span class="required"> *</span></label>
                            <input type="number" class="form-control input-sm" id="m_med_libdqty" name="m_med_libdqty" placeholder="start typing here..." required="required">
                        </div>

                        <div class="form-group">
                            <label for="m_med_libdexp">Expiration Date <span class="required"> *</span></label>
                            <input type="text" class="form-control input-sm" id="m_med_libdexp" name="m_med_libdexp" placeholder="start typing here..." required="required">
                        </div>

                        <div class="form-group">
                            <label for="m_med_libdstatus">Status <span class="required"> *</span></label>
                            <select class="form-control input-sm" id="m_med_libdstatus" name="m_med_libdstatus" required="required">
                                <option value="">Select...</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary btn-sm" id="m_med_saveprice">Save changes</button>
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <?php $this->load->view('page/footerpage');?>
    <script type="text/javascript" src="<?php echo base_url() . 'assets/js/suppliesindex.js'; ?>"></script>
</body>