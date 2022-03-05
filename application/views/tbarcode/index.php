<?php $this->load->view("page/headerlink"); ?>
<style type="text/css">
    .table-bordered>tbody>tr>td, .table-bordered>tbody>tr>th, 
    .table-bordered>tfoot>tr>td, .table-bordered>tfoot>tr>th, 
    .table-bordered>thead>tr>td, .table-bordered>thead>tr>th {
        border: 1px solid #b8b8b8 !important;
    }


    .form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control {
        background-color: #ddd;
        opacity: 1;
    }
</style>
<body class="">
    <?php $this->load->view("page/headerpage"); ?>

    <div class="content-scroll wrapper">
        <?php #$this->load->view("page/leftpage"); ?>
        <div class="content-wrapper" id="content-wrapper" style="margin-left: 0px; padding-top: unset;">
            <section class="content section">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-md-9">
                            <div class="panel panel-default" style="margin-bottom: 10px; background-color: #1d3b45;">
                                <div class="panel-header" style="display: flex; color: #fff;">
                                    <div style="width: 10%;">
                                        <form class="form-inline">
                                            <div class="form-group">
                                                <label style="font-weight: 600;">BILLING</label>
                                            </div>
                                        </form>
                                    </div>    

                                    <div style="width: 90%; text-align: right;">
                                        <form class="form-inline">
                                            <div class="form-group">
                                                <label for="">Client Name </label>
                                                <input type="hidden" class="form-control input-lg" id="inp_oid">
                                                <input type="text" class="form-control input-lg" id="inp_clientname" readonly>
                                                <label for="">
                                                    <a href="javascript:void(0);" id="search_client" class="btn btn-primary btn-lg" title="Search"><i class="fa fa-search"></i></a>
                                                    <a href="javascript:void(0);" id="search_cancel" class="btn btn-warning btn-lg" title="Cancel"><i class="fa fa-times"></i></a>
                                                </label>
                                            </div>
                                        </form>
                                    </div>                                
                                </div>
                                <div class="panel-body" style="padding-left: 0px; padding-right: 0px; padding-bottom: 0px;">
                                    <div style="margin-bottom: 85px;">
                                        <form method="post">
                                            <div class="form-group col-md-6">
                                                <label style="font-size: 12px;" class="text-muted">[F1] Item
                                                    <a href="javascript:void(0);" id="brsearchitem" class="" title="[F10] Search Item"><i class="fa fa-search"></i></a>
                                                </label>
                                                <input type="text" class="form-control input-lg" id="bcscan" placeholder="Scan item" autofocus>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label style="font-size: 12px;" class="text-muted">[F2] Qty</label>
                                                <input type="number" class="form-control input-lg" id="bcqty" placeholder="00" style="text-align: right;">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label style="font-size: 12px;" class="text-muted">[F3] Discount/Item &#8369;</label>
                                                <input type="number" class="form-control input-lg" id="bcdiscount" placeholder="00" style="text-align: right;">
                                            </div>
                                        </form>

                                        <!-- <form class="form-inline">
                                            <div class="form-group col-md-6" style="margin: 5px 0px;">
                                                <label>[F1] Item 
                                                    <a href="javascript:void(0);" id="brsearchitem" class="btn btn-primary " title="[F10] Search Item"><i class="fa fa-search"></i></a>
                                                </label>
                                                <input type="text" class="form-control " id="bcscan" placeholder="Scan item" autofocus style="">
                                            </div>
                                            <div class="form-group col-md-6 text-right" style="margin: 5px 0px;">
                                                <label>[F2] Qty</label>
                                                <input type="number" class="form-control " id="bcqty" placeholder="00" style="text-align: right;">
                                            </div>
                                            <div class="form-group col-md-6 text-right" style="margin: 5px 0px;">
                                                <label>[F3] Disc/Item &#8369;</label>
                                                <input type="number" class="form-control " id="bcdiscount" placeholder="00" style="text-align: right;">
                                            </div>
                                        </form> -->
                                    </div>

                                    <div style="background-color: #ddd; min-height: 427px; padding: 15px;">
                                        <table class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th class="text-center" style="width: 5px;"></th>
                                                    <th class="text-center">Item</th>
                                                    <th class="text-center">Unit</th>
                                                    <th class="text-center">Price</th>
                                                    <th class="text-center">Qty</th>
                                                    <th class="text-center">Discount/item</th>
                                                    <th class="text-center">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbody_barcode">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3" style="margin-bottom: 0px; padding-left: unset;">
                            <div class="panel panel-default" style="background-color: #204b5a; border-color: #203b43; color: #fff; box-shadow: unset;">
                                <div class="panel-header">
                                    <form class="form-inline" style="margin-bottom: 21px;">
                                        <div class="form-group">
                                            <label style="font-weight: 600;">SUMMARY</label>
                                        </div>
                                    </form>
                                </div>
                                <div class="panel-body" style="min-height: 525px;">
                                    <form class="form-horizontal" style="margin-bottom: 30px;">
                                        <div class="form-group">
                                            <label for="bcsummarytot" class="col-sm-5 control-label fs-large"><b>Total</b></label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control input-lg" id="bcsummarytot" style="text-align: right;" placeholder="0.00" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="bcsummarytendered" class="col-sm-5 control-label fs-large"><b>[F4] Cash</b></label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control input-lg" id="bcsummarytendered" style="text-align: right;" placeholder="0.00">
                                            </div>
                                        </div>
                                        <hr style="border-top: 2px solid #cbc8c8;">
                                        <div class="form-group">
                                            <label for="bcsummarychange" class="col-sm-5 control-label fs-large"><b>Change</b></label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control input-lg" id="bcsummarychange" style="text-align: right;" placeholder="0.00" disabled>
                                            </div>
                                        </div>
                                    </form>


                                    <div class="form-group"><a href="javascript:void(0);" class="btn btn-success btn-lg btn-block disabled" id="brsavetrans" title="Save Transaction"> [F6] Save Transaction</a></div>  
                                    <div class="form-group"><a href="javascript:void(0);" class="btn btn-success btn-lg btn-block disabled" id="brcanceltrans" title="Cancel Transaction">[F7] Cancel Transaction</a></div>
                                    <div class="form-group"><a href="javascript:void(0);" class="btn btn-success btn-lg btn-block disabled" id="brdiscountitem" title="Discount Item">[F8] Edit Item</a></div>
                                    <div class="form-group"><a href="javascript:void(0);" class="btn btn-success btn-lg btn-block disabled" id="brdeleteitem" title="Delete Item">[F9] Delete Item</a></div>
                                    <!-- <div class="form-group"><a href="javascript:void(0);" class="btn btn-success btn-lg btn-block" id="brsearchitem" title="Search Item">[F10] Search Item</a></div> -->
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>


    <div class="modal fade" id="modal_br_success" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" id="brmodalclosetimes">&times;</button>
                    <h4 class="modal-title" id="modal-title-trans_pet_his_msg">Message</h4>
                </div>
                <div class="modal-body">
                    <div id="print_div">
                        <div class="text-center" style="margin-bottom: 15px; font-weight: 700;">
                            <div>
                                <img src="<?php echo base_url() . 'assets/img/r8agripetf.png';?>" class="print-header">
                            </div>
                            <div>Main Office: Address here...</div>
                            <div>Satellite Office: Address here...</div>
                        </div>
                        
                        <table class="table-receipt" style="margin-bottom: 5px;">
                            <tbody>
                                <tr>
                                    <td id="brtrannumber">0000000000</td>
                                    <td id="brdategenerated" style="text-align: right;">MMM DD, YYYY HH:MM:SS</td>
                                </tr>
                                <tr>
                                    <td colspan="2" id="brclientname"></td>
                                </tr>
                            </tbody>
                        </table>

                        <div id="div_receipt">
                            
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="javascript:void(0);" class="btn btn-warning " id="print"><i class="fa fa-print"></i> Print</a>
                    <button type="button" class="btn btn-secondary " data-dismiss="modal" id="brmodalclose">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_br_discount" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" id="brmodalclosetimes">&times;</button>
                    <h4 class="modal-title" id="modal-title-trans_pet_his">Discount</h4>
                </div>
                <div class="modal-body" style="text-align: center;">
                    <form class="form-horizontal" >
                        <input type="hidden" class="form-control " id="mod_br_libdid" value="">

                        <div class="form-group">
                            <label for="bcsummarytot" class="col-sm-4 control-label"><b>Item</b></label>
                            <div class="col-sm-8">
                                <textarea class="form-control " id="mod_br_item" disabled rows="2"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="bcsummarytot" class="col-sm-4 control-label"><b>Qty</b></label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control " id="mod_br_qty" style="text-align: right;" placeholder="00">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="bcsummarytendered" class="col-sm-4 control-label"><b>Discount/Item</b></label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control " id="mod_br_discount" style="text-align: right;" placeholder="00">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary " id="brmodaldiscountsubmit">Submit</button>
                    <button type="button" class="btn btn-secondary " data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>



    <!-- search item -->
    <div class="modal fade" id="modal_bc_search" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="">Search Item</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" >
                        <div class="form-group">
                            <div class="col-sm-8">
                            </div>
                            <div class="col-sm-4">
                                <input type="text" class="form-control " id="modal_inp_bc_search" placeholder="Search item...">
                            </div>
                        </div>
                    </form>

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Barcode</th>
                                <th>Item</th>
                                <th>Unit</th>
                                <th>Price</th>
                                <th>Expiry Date</th>
                            </tr>
                        </thead>
                        <tbody id="modal_tbody_search_item">
                            <tr>
                                <td colspan="5" class="text-center">No data available in table</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary " data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- client name -->
    <div class="modal fade" id="modal_client_name" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" id="brmodalclosetimes">&times;</button>
                    <h4 class="modal-title" id="modal-title-client_name">Search Client</h4>
                </div>
                <div class="modal-body">
                    <div style="margin-bottom: 10px;">
                        <a href="javascript:void(0);" class="btn btn-primary " id="a_add_client_name"><i class="fa fa-plus-square"></i> Add Client</a>
                    </div>
                    <table class="table table-striped" id="tbl_dt_client_name">
                        <thead>
                            <tr>
                                <th>FirstName</th>
                                <th>MiddleName</th>
                                <th>LastName</th>
                                <th>Address</th>
                                <th>Contact#</th>
                                <th></th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary " data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <?php $this->load->view('modal/client_modal');?>
    <?php #$this->load->view('modal/pet_modal');?>


    <?php $this->load->view('page/footerpage');?>

    <script type="text/javascript" src="<?php echo base_url() . 'assets/js/billingindex.js'; ?>"></script>
</body>