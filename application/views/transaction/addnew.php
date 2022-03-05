<?php $this->load->view("page/headerlink"); ?>
<body id="body">
    <?php $this->load->view("page/headerpage"); ?>
    <div class="content-scroll wrapper">
        
        <?php $this->load->view("page/leftpage"); ?>
        <div class="content-wrapper" id="content-wrapper">
            <section class="content section">
                <div class="container-fluid">
                    <div class="row">
                        <input type="hidden" class="form-control input-sm" id="trans_transid" name="trans_transid" value="<?php echo (strlen(trim($transid)) !== 0 ? $this->my_encrypt->encode($transid) : $transid);?>"> 
                        <input type="hidden" class="form-control input-sm" id="trans_oid" name="trans_oid" value="<?php echo $this->my_encrypt->encode($oid);?>" >

                        <div id="trans_serv_med" style="display: <?php echo (strlen(trim($transid)) !== 0 ? 'block' : 'none');?>;">
                            <div class="col-md-6">
                                <div class="panel panel-default panel-default-blue">
                                    <div class="panel-header">
                                        SERVICE RENDERED <span class="required"><?php echo (isset($trans[0]['trannumber']) ? ' ['.$trans[0]['trannumber'] . '] ' : '');?></span>

                                        <span class="pull-right">
                                            <button type="button" class="btn btn-primary btn-sm" id="print"><i class="fa fa-print"></i> Print</button>
                                        </span>

                                    </div>

                                    <div class="panel-header">
                                        <div class="" style="text-align: center; margin-bottom: 15px;">
                                            CATEGORIES
                                            <select class="form-control input-sm form-control-new" id="trans_serv_sel">
                                                <option value="0">Select...</option>
                                                <?php 
                                                    $len = count($serv);
                                                    for ($i=0; $i < $len; $i++) { 
                                                ?>
                                                        <option value="<?php echo $serv[$i]['sid'];?>" data-sdescription="<?php echo $serv[$i]['sdescription'];?>"><?php echo $serv[$i]['sdescription'];?></option>
                                                <?php
                                                    }
                                                ?>                                      
                                            </select>
                                        </div>

                                        <form class="form-inline">
                                            <div class="form-group">
                                                <label for="">Transaction Date </label>
                                                <input type="text" class="form-control input-sm" id="trans_date" value="<?php echo (isset($trans[0]['trandate']) ? $trans[0]['trandate'] : '');?>" disabled>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Client Name </label>
                                                <input type="text" class="form-control input-sm" value="<?php echo isset($own[0]['ofname']) ? $own[0]['ofname'] . " " . $own[0]['omname'] . " " . $own[0]['olname'] : '';?>" disabled>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="panel-body" style="margin-top: 0px;">
                                        <table class="table table-striped table-hovered">
                                            <thead>
                                                <tr>
                                                    <th>Cat</th>
                                                    <th>Des</th>
                                                    <th>Unit</th>
                                                    <th>Price</th>
                                                    <th style="width: 80px;">Qty</th>
                                                    <th style="width: 80px;">&#8369; Disc</th>
                                                    <th>Amount</th>
                                                    <!-- <th>C/o</th> -->
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbody_addnew_serv">
                                                <?php 
                                                    $len = count($transserv);
                                                    #$lenemp = count($emp);
                                                    $totamount = 0.00;
                                                    for ($i=0; $i < $len; $i++) { 
                                                        $discount = $transserv[$i]['tslibdqty'] * $transserv[$i]['tsdiscount'];
                                                        $amount = ($transserv[$i]['libdprice'] * $transserv[$i]['tslibdqty']) - $discount;

                                                        $totamount += $amount;
                                                ?>
                                                        <tr>
                                                            <td>
                                                                <?php echo $transserv[$i]['scode'];?>
                                                            </td>
                                                            <td><?php echo $transserv[$i]['libdesc'];?></td>
                                                            <td><?php echo $transserv[$i]['unitcode'];?></td>
                                                            <td style="text-align: right;" class="libdprice"><?php echo $transserv[$i]['libdprice'];?></td>
                                                            <td><input type="number" class="form-control input-sm" name="tslibdqty" placeholder="0" value="<?php echo $transserv[$i]['tslibdqty']; ?>" disabled></td>
                                                            <td><input type="number" class="form-control input-sm" name="tsdiscount" placeholder="0" value="<?php echo $transserv[$i]['tsdiscount']; ?>" disabled></td>

                                                            <td style="text-align: right;" class="libdamount"><?php echo $amount; ?></td>
                                                            <!-- <td>
                                                                <select class="form-control input-sm" name="tsempid" disabled>
                                                                    <option value="">...</option>
                                                                    <?php 
                                                                        /*for ($j=0; $j < $lenemp; $j++) { 
                                                                            $sel = $transserv[$i]['empid'] === $emp[$j]['empid'] ? 'selected' : '';*/
                                                                    ?>
                                                                            <option value="<?php #echo $emp[$j]['empid'];?>" <?php #echo $sel;?>><?php #echo $emp[$j]['elname'];?></option>
                                                                    <?php 
                                                                        #}
                                                                    ?>
                                                                </select>
                                                            </td> -->
                                                            <td>
                                                                <a href="javascript:void(0);" name="trans_add_a" data-transservid="<?php echo $this->my_encrypt->encode($transserv[$i]['transservid']);?>" data-tslibdid="<?php echo $this->my_encrypt->encode($transserv[$i]['tslibdid']);?>" style="display:none;"><i class="fa fa-save"></i></a>
                                                                <span name="trans_add_span" style="display:none;"> | </span>

                                                                <a href="javascript:void(0);" name="trans_cancel_a" data-transservid="<?php echo $this->my_encrypt->encode($transserv[$i]['transservid']);?>" style="display:none;"><i class="fa fa-times"></i></a>
                                                                
                                                                <a href="javascript:void(0);" data-transservid="<?php echo $this->my_encrypt->encode($transserv[$i]['transservid']);?>" name="trans_edit_a" ><i class="fa fa-edit"></i></a> 

                                                                <span name="trans_edit_span"> | </span>

                                                                <a href="javascript:void(0);" name="trans_del_a" data-transservid="<?php echo $this->my_encrypt->encode($transserv[$i]['transservid']);?>" ><i class="fa fa-trash"></i></a>

                                                            </td>
                                                        </tr>
                                                <?php
                                                    }
                                                ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="6" class="total" style="text-align: right; font-weight: 800;">Total</td>
                                                    <td class="total" style="text-align: right; font-weight: 800;" id="totamount"><?php echo number_format($totamount, 2); ?></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="panel panel-default panel-default-green" id="div_pnl_serv" style="display: none;">
                                    <!-- <div class="panel-header">
                                        Select <span id="tbl_serv"></span>
                                    </div> -->
                                    <div class="panel-header">
                                        Add Item/Services
                                    </div>

                                    <div class="panel-body">
                                        <table class="table table-striped" id="tbl_dt_transadd">
                                            <thead>
                                                <tr>
                                                    <th>Description</th>
                                                    <th>Unit</th>
                                                    <th>Price</th>
                                                    <th>Qty Rem</th>
                                                    <th>Expiration</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <?php $this->load->view('page/footerpage');?>
    <script type="text/javascript" src="<?php echo base_url() . 'assets/js/transactionadd.js'; ?>"></script>
</body>