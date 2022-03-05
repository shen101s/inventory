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
                                    Stock Issuance <u><?php echo date('M d, Y H:i:s');?></u>
                                </div>
                                <div class="panel-body">
                                    <div style="text-align: right; margin-bottom: 15px;">
                                        <form class="form-inline" method="get">
                                            <div class="form-group">
                                                <label>Start Date </label>
                                                <input type="text" class="form-control input-sm" id="trandate_s" name="startdate" placeholder="Start Date" value="<?php echo $startdate;?>">
                                            </div>
                                            <div class="form-group">
                                                <label>End Date </label>
                                                <input type="text" class="form-control input-sm" id="trandate_e" name="enddate" placeholder="End date" value="<?php echo $enddate;?>">
                                            </div>
                                            <button type="submit" class="btn btn-success btn-sm" title="Generate Report"><i class="fa fa-location-arrow"></i> Generate</button>
                                            <button type="button" class="btn btn-primary btn-sm" id="print"><i class="fa fa-print"></i> Print</button>
                                        </form>
                                    </div>
                                    <div class="c-report-print-div">
                                        <div class="c-report-print-as-of-div"><b>Stock Issuance as of <u><?php echo date('M d, Y H:i:s');?></u></b></div>
                                        <table class="table table-striped table-hovered table-bordered">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">Date</th>
                                                    <th class="text-center">Item/Service</th>
                                                    <th class="text-center">Unit</th>
                                                    <th class="text-center">Unit Cost</th>
                                                    <th class="text-center">Qty</th>
                                                    <th class="text-center">Discount</th>
                                                    <th class="text-center">Remarks</th>
                                                    <th class="text-center">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tblreport">
                                                <?php 
                                                    $grand_total_amount = 0;
                                                    $len = count($res);
                                                    for ($i=0; $i < $len; $i++) { 
                                                    
                                                        if ($res[$i]['tslocation'] === 'ADJ') {
                                                            $total_amount_disp = '-';
                                                        } else {
                                                            $total_amount = ($res[$i]['tslibdqty'] * $res[$i]['libdprice']) - ($res[$i]['tslibdqty'] * $res[$i]['tsdiscount']);
                                                            $grand_total_amount += ($total_amount * 1);
                                                            $total_amount_disp = number_format($total_amount, 2);
                                                        }
                                                ?>
                                                        <tr>
                                                            <td><?php echo date('M d, Y', strtotime($res[$i]['trandate']));?></td>
                                                            <td><?php echo $res[$i]['libdesc'] . '-' . $res[$i]['libdescitem'];?></td>
                                                            <td><?php echo $res[$i]['unitcode'];?></td>
                                                            <td class="text-right"><?php echo number_format($res[$i]['libdprice'], 2);?></td>
                                                            <td class="text-right"><?php echo $res[$i]['tslibdqty'];?></td>
                                                            <td class="text-right"><?php echo $res[$i]['tsdiscount'] == '0.00' ? '' : number_format($res[$i]['tsdiscount'], 2);?></td>

                                                            <td><?php echo $res[$i]['tsremarks'];?></td>
                                                            <td class="text-right"><?php echo $total_amount_disp;?></td>
                                                        </tr>
                                                <?php 
                                                    }

                                                    if ($len === 0) {
                                                ?>
                                                        <tr>
                                                            <td colspan="8" style="text-align: center;">No data available in table</td>
                                                        </tr>
                                                <?php 
                                                    }
                                                ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th class="text-right" colspan="7">GRAND TOTAL</th>
                                                    <th class="text-right"><?php echo number_format($grand_total_amount, 2);?></th>
                                                </tr>
                                            </tfoot>

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
    <script type="text/javascript" src="<?php echo base_url() . 'assets/js/reportstockissuance.js'; ?>"></script>
</body>