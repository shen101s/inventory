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
                                    Stock Inventory Report as of <u><?php echo date('M d, Y H:i:s');?></u>
                                </div>
                                <div class="panel-body">
                                    <div style="padding-bottom: 15px; text-align: right;">
                                        <form method="get">
                                            Category
                                            <select class="form-control form-control-new" name="category">
                                                <option value="">Select</option>
                                                <?php 
                                                    $len = count($serv);
                                                    for ($i=0; $i < $len; $i++) { 
                                                        $sel = ($sid == $serv[$i]['sid']) ? 'selected' : '';
                                                ?>
                                                        <option data-sid="<?php echo $serv[$i]['sid'];?>" value="<?php echo $this->my_encrypt->encode($serv[$i]['sid']);?>" <?php echo $sel;?> ><?php echo $serv[$i]['sdescription'];?></option>
                                                <?php 
                                                    }
                                                ?>                                     
                                            </select>

                                            Stock
                                            <select class="form-control form-control-new" name="stock">
                                                <option value="all" <?php echo ($stock === 'stock' ? 'selected' : '');?> >All Stock</option>
                                                <option value="stockonhand" <?php echo ($stock === 'stockonhand' ? 'selected' : '');?> >Stock on hand</option>
                                                <option value="outofstock"  <?php echo ($stock === 'outofstock' ? 'selected' : '');?> >Out of stock</option>          
                                            </select>
                                            <button type="submit" class="btn btn-success btn-mb" id="m_client_submit"><i class="fa fa-location-arrow"></i> Generate</button>
                                            <button type="button" class="btn btn-primary btn-mb" id="print"><i class="fa fa-print"></i> Print</button>
                                        </form>
                                    </div>

                                    <div class="c-report-print-div">
                                        <div class="c-report-print-as-of-div"><b>Stock Inventory Report as of <u><?php echo date('M d, Y H:i:s');?></u></b></div>
                                        <table class="table table-hovered table-bordered" id="tblreport">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">Barcode</th>
                                                    <th class="text-center">Item/Services</th>
                                                    <th class="text-center">Expiration</th>
                                                    <th class="text-center">Unit</th>
                                                    <th class="text-center">Unit Cost</th>
                                                    <th class="text-center">Beginning Balance</th>
                                                    <th class="text-center">Running Balance</th>
                                                </tr>
                                            </thead>
                                            <tbody> 
                                                <?php 
                                                    $six_mos_date = date('Y-m-d', strtotime('+6 months'));

                                                    $len = count($res);
                                                    for ($i=0; $i < $len; $i++) { 
                                                        $libdexp = ($res[$i]['libdexp'] === '0000-00-00' || $res[$i]['libdexp'] === NULL ? '' : date('M d, Y', strtotime($res[$i]['libdexp'])) );

                                                        $tr_class = '';
                                                        $curr_date = date('Y-m-d');
                                                        if (strlen(trim($libdexp)) > 0 && $curr_date <= date('Y-m-d', strtotime($libdexp)) && date('Y-m-d', strtotime($libdexp)) <= $six_mos_date) {
                                                            $tr_class = 'alert-warning';
                                                        } elseif (strlen(trim($libdexp)) > 0 && $curr_date > date('Y-m-d', strtotime($libdexp))) {
                                                            $tr_class = 'alert-danger';
                                                        }

                                                ?>
                                                        <tr class="<?php echo $tr_class;?>">
                                                            <td><?php echo $res[$i]['libdbarcode'];?></td>
                                                            <td><?php echo $res[$i]['libdesc']. '(' . $res[$i]['libdescitem'] . ')';?></td>
                                                            <td><?php echo $libdexp;?></td>
                                                            <td><?php echo $res[$i]['unitcode'];?></td>
                                                            <td class="text-right"><?php echo $res[$i]['libdprice'];?></td>
                                                            <td class="text-right"><?php echo ($res[$i]['libdqty'] == 0 ? '' : $res[$i]['libdqty']);?></td>
                                                            <td class="text-right"><?php echo ($res[$i]['libdqty'] == 0 ? '' : $res[$i]['libdqtyrem']);?></td>
                                                            
                                                        </tr>
                                                <?php 
                                                    }

                                                    if ($len === 0) {
                                                ?>
                                                        <tr>
                                                            <td colspan="7" class="text-center">No data available in table</td>
                                                        </tr>
                                                <?php
                                                    }
                                                ?>
                                            </tbody>
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
    <script type="text/javascript" src="<?php echo base_url() . 'assets/js/reportstockinventory.js'; ?>"></script>
</body>