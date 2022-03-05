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
                                    Generate Report as of <u><?php echo date('M d, Y g:i A');?></u>
                                    <?php $this->load->view("page/reportpage"); ?>
                                </div>
                                <div class="panel-body">
                                    <div style="margin: 0 5px; text-align: right;">
                                        <label>
                                            <input style="vertical-align: middle; margin-top: 0;" type="checkbox" id="vaccinenearlyexpirydate">Generate 6 months nearly expiry date
                                        </label>
                                    </div>

                                    <div style="margin: 0 5px; text-align: center;"><u><h5>Vaccine Inventory</h5></u></div>
                                    <table class="table table-striped table-hovered">
                                        <thead>
                                            <tr>
                                                <th>Vaccine</th>
                                                <th>Unit</th>
                                                <th>Price</th>
                                                <th>Qty Remaining</th>
                                                <th>Expiration</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tblreport">
                                            <?php 
                                                $len = count($res);
                                                for ($i=0; $i < $len; $i++) { 
                                            ?>
                                                    <tr>
                                                        <td><?php echo $res[$i]['libdesc'];?></td>
                                                        <td><?php echo $res[$i]['unitcode'];?></td>
                                                        <td><?php echo $res[$i]['libdprice'];?></td>
                                                        <td><?php echo $res[$i]['libdqtyrem'];?></td>
                                                        <td><?php echo ($res[$i]['libdexp'] === NULL) ? '-' : date('M d, Y', strtotime($res[$i]['libdexp']));?></td>
                                                    </tr>
                                            <?php 
                                                }

                                                if ($len === 0) {
                                            ?>
                                                    <tr>
                                                        <td colspan="5" style="text-align: center;">No data available in table</td>
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
            </section>
        </div>
    </div>

    <?php $this->load->view('page/footerpage');?>
    <script type="text/javascript" src="<?php echo base_url() . 'assets/js/reportindex.js'; ?>"></script>
</body>