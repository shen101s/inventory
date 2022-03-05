<?php $this->load->view("page/headerlink"); ?>
<body id="body">
    <?php $this->load->view("page/headerpage"); ?>
    <div class="content-scroll wrapper">
        <?php $this->load->view("page/leftpage"); ?>
        <div class="content-wrapper" id="content-wrapper">
            <section class="content section">
                <div class="container-fluid">
                    <input type="hidden" id="remselect_hidden" value="<?php echo $remselect;?>">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-header">
                                    Select Client and Pet
                                    <span class="pull-right">
                                        <a href="javascript:void(0);" id="trans_add_owner" class="btn btn-success btn-sm"><i class="fa fa-plus-square"></i> Add Client</a> 
                                    </span>
                                </div>
                                <div class="panel-body">
                                    <table class="table table-striped" id="tbl_dt_trans">
                                        <thead>
                                            <tr>
                                                <th>FirstName</th>
                                                <th>MiddleName</th>
                                                <th>LastName</th>
                                                <th>Address</th>
                                                <th>Contact#</th>
                                                <th>Email</th>
                                                <th>PetName</th>
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

    <?php $this->load->view('modal/client_modal');?>
    <?php $this->load->view('modal/pet_modal');?>

    <div class="modal fade" id="modal_pet_history" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="modal-title-trans_pet_his">Health History</h4>
                </div>

                <form id="petsave" method="post">
                    <div class="modal-body">
                        <input type="hidden" class="form-control input-sm" id="m_pid_his" name="m_pid_his">
                        <input type="hidden" class="form-control input-sm" id="m_phid" name="m_phid">

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group-input">
                                    <div class="form-group">
                                        <label for="m_phdesc">Category <span class="required"> *</span></label>
                                        <select class="form-control input-sm" id="m_phdesc" name="m_phdesc">
                                            <option value="">Select...</option>
                                            <option value="Deworming">Deworming</option>
                                            <option value="Vaccination">Vaccination</option>
                                            <option value="Heart">Heart</option>
                                        </select>                                        
                                    </div>

                                    <div class="form-group">
                                        <label for="m_phdate">Date <span class="required"> *</span></label>
                                        <input type="text" class="form-control input-sm" id="m_phdate" name="m_phdate" placeholder="start typing here...">
                                    </div>

                                    <div class="form-group">
                                        <label for="m_phremarks">Remarks <span class="required"> *</span></label>
                                        <textarea class="form-control input-sm" id="m_phremarks" name="m_phremarks" placeholder="start typing here..." rows="3"></textarea>
                                    </div>

                                    <div class="text-right">
                                        <button type="button" class="btn btn-primary btn-sm" id="m_pet_hist_add"><i class="fa fa-save"></i> Save Changes</button>
                                        <button type="button" class="btn btn-warning btn-sm" id="m_pet_hist_cancel"><i class="fa fa-times"></i> Cancel</button>
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-8">
                                <div class="form-group-table">
                                    <table class="table table-striped table-hovered">
                                        <thead>
                                            <tr>
                                                <th>Category</th>
                                                <th>Date</th>
                                                <th style="width: 50%">Remarks</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody id="m_pet_his_ttbody_details">
                                        </tbody>
                                    </table>    
                                </div>
                            </div>
                        </div>






                        <!-- <table class="table table-striped table-hovered">
                            <thead>
                                <tr>
                                    <td>Category</td>
                                    <td>Date</td>
                                    <td style="width: 50%">Remarks <span class="required"> *</span></td>
                                    <td></td>
                                </tr>
                            </thead>
                            <tbody id="m_pet_hist_tbody">
                                <tr>
                                    <td>
                                        
                                    </td>

                                    <td>
                                        
                                    </td>
                                    <td>
                                        
                                    </td>
                                    <td>
                                        <a href="javascript:void(0);" name="m_pet_hist_add" data-phid=""><i class="fa fa-save"></i></a>
                                    </td>
                                </tr>
                            </tbody>
                            <tbody id="m_pet_his_ttbody_details">
                            </tbody>
                        </table> -->
                    
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php $this->load->view('page/footerpage');?>
    <script type="text/javascript" src="<?php echo base_url() . 'assets/js/clientindex.js'; ?>"></script>
</body>