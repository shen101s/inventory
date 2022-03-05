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
                                    Category Details of <span><?php echo $serv[0]['sdescription'];?></span>
                                    <input type="hidden" name="hiddensid" id="hiddensid" value="<?php echo $this->my_encrypt->encode($serv[0]['sid']);?>">
                                    <span class="pull-right">
                                        <a href="javascript:void(0);" id="serv_adddetail" title="Add <?php echo $serv[0]['sdescription'];?>" class="btn btn-success "><i class="fa fa-plus-square"></i> Add <?php echo $serv[0]['scode'];?></a>
                                    </span>
                                </div>
                                <div class="panel-body">

                                    <table class="table table-striped" id="tbl_dt_servindex">
                                        <thead>
                                            <tr>
                                                <th>Items/Services</th>
                                                <th>Status</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-6" id="divdesc" style="display: none;">
                            <div class="panel panel-default">
                                <div class="panel-header">
                                    <input type="hidden" name="serv_indlibid_desc" id="serv_indlibid_desc">
                                    Description of <span id="serv_inddesc" style="text-decoration: underline;">...</span>
                                    <span class="pull-right">
                                        <a href="javascript:void(0);" id="serv_adddesc" title="Add Description" class="btn btn-success "><i class="fa fa-plus-square"></i> Add Description</a>
                                    </span>
                                </div>
                                <div class="panel-body">

                                    <table class="table table-striped" id="tbl_dt_servindexdesc">
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

                        </div>

                        <div class="col-md-6" id="divprice" style="display: none;">
                            <div class="panel panel-default">
                                <div class="panel-header">
                                    <input type="hidden" name="serv_indlibdescid" id="serv_indlibdescid">
                                    Price of <span id="serv_indprice" style="text-decoration: underline;">...</span>
                                    <span class="pull-right">
                                        <a href="javascript:void(0);" id="serv_addprice" title="Add Price" class="btn btn-success "><i class="fa fa-plus-square"></i> Add Price</a>
                                    </span>
                                </div>
                                <div class="panel-body">
                                    <table class="table table-striped table-bordered" id="tbl_dt_servindexprice">
                                        <thead>
                                            <tr class="text-center">
                                                <th>Barcode</th>
                                                <th>Unit</th>
                                                <th>Price</th>
                                                <th title="Beginning Balance">Beginning Bal</th>
                                                <th title="Remaining Balance">Remaining Bal</th>
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

    <div class="modal fade" id="modal_servindex" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="m_i_title">Add</h4>
                </div>

                <form method="post" id="m_form_saveservices">
                    <div class="modal-body">
                        <input type="hidden" name="m_serv_qsid" value="<?php echo $this->my_encrypt->encode($serv[0]['sid']);?>">
                        <input type="hidden" id="m_serv_libid" name="m_serv_libid">
                        <div class="form-group">
                            <label for="m_serv_libdesc">Item/Service <span class="required"> *</span></label>
                            <input type="text" class="form-control " id="m_serv_libdesc" name="m_serv_libdesc" placeholder="start typing here..." required="required">
                        </div>
                        <div class="form-group">
                            <label for="m_serv_libstatus">Status <span class="required"> *</span></label>
                            <select class="form-control " id="m_serv_libstatus" name="m_serv_libstatus" required="required">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary " data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary " id="m_serv_detailssave">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="modal_servindexdesc" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="m_i_titledesc">Add Description</h4>
                </div>

                <form method="get" id="m_form_saveservicesdesc">
                    <div class="modal-body">
                        <input type="hidden" name="m_serv_qsid" id="m_serv_qsid" value="<?php echo $this->my_encrypt->encode($serv[0]['sid']);?>">
                        <input type="hidden" id="m_serv_libdescid" name="m_serv_libdescid">
                        <input type="hidden" id="m_serv_libid_desc" name="m_serv_libid_desc">

                        <div class="form-group">
                            <label for="m_serv_libdesc">Description <span class="required"> *</span></label>
                            <input type="text" class="form-control " id="m_serv_libdescitem" name="m_serv_libdescitem" placeholder="start typing here..." required="required">
                        </div>
                        <div class="form-group">
                            <label for="m_serv_libstatus">Status <span class="required"> *</span></label>
                            <select class="form-control " id="m_serv_libdescstatus" name="m_serv_libdescstatus" required="required">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary " id="m_serv_detailssave_desc">Save changes</button>
                        <button type="button" class="btn btn-secondary " data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>




    <div class="modal fade" id="modal_servindexprice" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="m_i_titleprice">Add Price</h4>
                </div>

                <form method="post" id="m_form_saveprice">
                    <div class="modal-body">     
                        <input type="hidden" id="m_serv_libdescid_price" name="m_serv_libdescid_price">           
                        <input type="hidden" id="m_serv_libdid" name="m_serv_libdid">

                        <div class="form-group">
                            <label for="m_serv_libdbarcode">Barcode</label>
                            <input type="text" class="form-control " id="m_serv_libdbarcode" name="m_serv_libdbarcode" placeholder="AUTO GENERATED" readonly>
                        </div>


                        <div class="form-group">
                            <label for="m_serv_unit">Unit <span class="required"> *</span></label>
                            <select class="form-control " id="m_serv_unit" name="m_serv_unit" required="required">
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
                            <label for="m_serv_libdprice">Price <span class="required"> *</span></label>
                            <input type="text" class="form-control " id="m_serv_libdprice" name="m_serv_libdprice" placeholder="start typing here..." required="required">
                        </div>

                        <div class="form-group">
                            <label for="m_serv_libdqty">Beginning Qty <span class="required">(0 for N/A)</span></label>
                            <input type="number" class="form-control " id="m_serv_libdqty" name="m_serv_libdqty" placeholder="start typing here...">
                        </div>

                        <div class="form-group">
                            <label for="m_serv_libdexp">Expiration Date </label>
                            <input type="text" class="form-control " id="m_serv_libdexp" name="m_serv_libdexp" placeholder="start typing here...">
                        </div>

                        <div class="form-group">
                            <label for="m_serv_libdstatus">Status <span class="required"> *</span></label>
                            <select class="form-control " id="m_serv_libdstatus" name="m_serv_libdstatus" required="required">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary " id="m_serv_saveprice">Save changes</button>
                        <button type="button" class="btn btn-secondary " data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="modal_print_barcode" role="dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="modal-title-print_barcode">Print Barcode</h4>
                </div>
                <div class="modal-body">
                    <div id="print_div" class="text-center">
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning " id="print"><i class="fa fa-print"></i> Print</button>
                    <button type="button" class="btn btn-secondary " data-dismiss="modal" id="brmodalclose"><i class="fa fa-window-close"></i> Close</button>
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade" id="modal_adjust_qty" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="modal-title-adjust_qty">Adjust Quantity</h4>
                </div>
                <form method="post" id="m_form_adjustqty">
                    <div class="modal-body">         
                        <input type="hidden" id="adj_transservid" name="adj_transservid">
                        <input type="hidden" id="adj_tslibdid" name="adj_tslibdid">

                        <div class="form-group form-group-mb row">
                            <label for="adj_libdbarcode" class="col-sm-2 col-form-label">Barcode</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="adj_libdbarcode" readonly="readonly">
                            </div>

                            <label for="adj_libdesc" class="col-sm-2 col-form-label">Item</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="adj_libdesc" readonly="readonly">
                            </div>
                        </div>

                        <div class="form-group form-group-mb row">
                            <label for="adj_libdescitem" class="col-sm-2 col-form-label">Item Description</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="adj_libdescitem" readonly="readonly">
                            </div>
                        </div>

                        <div class="form-group form-group-mb row">
                            <label for="adj_tslibdqty" class="col-sm-2 col-form-label">Qty<span class="required">*</span></label>
                            <div class="col-sm-4">
                                <input type="number" class="form-control" id="adj_tslibdqty" name="adj_tslibdqty" style="text-align: right;" placeholder="0">
                            </div>
                            <!-- <label for="" class="col-sm-6 col-form-label">
                                <div>
                                    <table style="width: 100%; border-bottom: unset;" class="required">
                                        <tbody>
                                            <tr>
                                                <td rowspan="2" style="font-size: 10px;">NOTE:</td>
                                                <td style="font-size: 10px;">+ value: to subtract stock qty</td>
                                            </tr>
                                            <tr>
                                                <td style="font-size: 10px;">- value: to add stock qty</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </label> -->
                        </div>

                        <div class="form-group form-group-mb row">
                            <label for="adj_tsremarks" class="col-sm-2 col-form-label">Remarks<span class="required">*</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" id="adj_tsremarks" name="adj_tsremarks" placeholder="Start typing here..."></textarea>
                            </div>
                        </div>
                
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary " id="m_serv_saveadjustqty"><i class="fa fa-save"></i> Save changes</button>
                        <button type="button" class="btn btn-secondary " data-dismiss="modal"><i class="fa fa-window-close"></i> Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="modal_stockcard" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="modal-title-stockcard">Stock Card</h4>
                </div>
                <div class="modal-body">         
                    <input type="hidden" id="sc_libdid" name="m_serv_libdid_qty">
                    <div>
                        <div style="margin-bottom: 15px;">
                            <form>
                                <div class="form-group form-group-mb row">
                                    <label for="sc_libdbarcode" class="col-sm-2 col-form-label">Barcode</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="sc_libdbarcode" readonly="readonly">
                                    </div>

                                    <label for="sc_libdesc" class="col-sm-2 col-form-label">Item</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="sc_libdesc" readonly="readonly">
                                    </div>
                                </div>

                                <div class="form-group form-group-mb row">
                                    <label for="sc_libdescitem" class="col-sm-2 col-form-label">Item Description</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="sc_libdescitem" readonly="readonly">
                                    </div>
                                </div>

                                <div class="form-group form-group-mb row">
                                    <label for="sc_unitcode" class="col-sm-2 col-form-label">Unit</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="sc_unitcode" readonly="readonly">
                                    </div>

                                    <label for="sc_libdprice" class="col-sm-2 col-form-label">Unit Cost</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="sc_libdprice" readonly="readonly" style="text-align: right;">
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="text-right" style="margin-bottom: 10px;">
                            <span>
                                <a href="javascript:void(0);" id="adjustqty" title="Adjust Qty" class="btn btn-success "><i class="fa fa-plus-square"></i> Adjust Quantity</a>
                            </span>
                        </div>
                        <table class="table table-striped table-hovered table-bordered">
                            <thead>
                                <tr>
                                    <th title="Beginning Qty">Beg. Qty</th>
                                    <th title="Transaction COde">Trans. Code</th>
                                    <th title="Issue Qty">Issue Qty</th>
                                    <th title="Remaining Qty">Rem. Qty</th>
                                    <th title="Discount">Discount</th>
                                    <th title="Remarks">Remarks</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="tbody_stockcard">
                                
                            </tbody>
                        </table>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary " data-dismiss="modal"><i class="fa fa-window-close"></i> Close</button>
                </div>
            </div>
        </div>
    </div>




    <?php $this->load->view('page/footerpage');?>
    <script type="text/javascript" src="<?php echo base_url() . 'assets/credits/print/printThis.js';?>"></script>
    <script type="text/javascript" src="<?php echo base_url() . 'assets/js/servicesdetail.js'; ?>"></script>
</body>