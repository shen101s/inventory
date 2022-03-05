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
                                    <div style="text-align: right; margin: 5px;">
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
                                        </form>
                                    </div>

                                    <div style="margin: 0 5px; text-align: center;"><u><h5>Commission</h5></u></div>
                                    <table class="table table-striped table-hovered">
                                        <thead>
                                            <tr>
                                                <th>Description</th>
                                                <th>Qty</th>
                                                <th>Price</th>
                                                <th>Conducted by</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tblreport">
                                            <?php 
                                                $len = count($res);
                                                for ($i=0; $i < $len; $i++) { 
                                            ?>
                                                    <tr>
                                                        <td><?php echo $res[$i]['libdesc'];?></td>
                                                        <td><?php echo $res[$i]['tslibdqty'];?></td>
                                                        <td><?php echo $res[$i]['libdprice'] * $res[$i]['tslibdqty'];?></td>
                                                        <td><?php echo $res[$i]['empname'];?></td>
                                                    </tr>
                                            <?php 
                                                }

                                                if ($len === 0) {
                                            ?>
                                                    <tr>
                                                        <td colspan="4" style="text-align: center;">No data available in table</td>
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