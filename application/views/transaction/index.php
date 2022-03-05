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
                                    Transactions
                                    <!-- <span class="pull-right">
                                        <a href="<?php #echo base_url() . 'transaction/clientselect';?>" class="btn btn-success btn-sm" title="Add Transaction"><i class="fa fa-plus-square"></i> Add Transaction</a>
                                    </span> -->
                                </div>
                                <div class="panel-body">

                                    <table class="table table-striped" id="tbl_dt_transindex">
                                        <thead>
                                            <tr>
                                                <th>ID #</th>
                                                <th>Date</th>
                                                <th>Client Name</th>
                                                <th>Amount</th>
                                                <th>Action</th>
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


    <div class="modal fade" id="modal_pet_history" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="modal-title-trans_pet_his">Health History</h4>
                </div>

                <form id="petsave" method="post">
                    <div class="modal-body">
                        <table class="table table-striped table-hovered">
                            <thead>
                                <tr>
                                    <th>Category</th>
                                    <th>Date</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            <tbody id="m_pet_his_ttbody_details">
                            </tbody>
                        </table>
                    
                    </div>
                </form>
            </div>
        </div>
    </div>


    <?php $this->load->view('page/footerpage');?>
    <script type="text/javascript" src="<?php echo base_url() . 'assets/js/transactionindex.js'; ?>"></script>
</body>