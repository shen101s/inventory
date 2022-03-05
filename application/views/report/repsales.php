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
                                    Sales Summary Report as of <u><?php echo date('M d, Y H:i:s');?></u>
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
                                        <div class="c-report-print-as-of-div"><b>Sales Summary Report as of <u><?php echo date('M d, Y H:i:s');?></u></b></div>
                                        <table class="table table-striped table-hovered table-bordered">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">Date</th>
                                                    <th class="text-center">DMMS</th>
                                                    <th class="text-center">Vaccine</th>
                                                    <th class="text-center">Deworming</th>
                                                    <th class="text-center">Other Supplies</th>
                                                    <th class="text-center">Dog Food</th>
                                                    <th class="text-center">Vet Services</th>
                                                    <th class="text-center">Grooming Services</th>
                                                    <th class="text-center">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tblreport">
                                                <?php 
                                                    $total = 0;
                                                    $totdmms_tot = 0;
                                                    $totvax_tot = 0;
                                                    $totdw_tot = 0;
                                                    $totos_tot = 0;
                                                    $totdf_tot = 0;
                                                    $totvs_tot = 0;
                                                    $totgs_tot = 0;

                                                    $len = count($res);
                                                    for ($i=0; $i < $len; $i++) { 
                                                        $totdmms = $res[$i]['totdmms'];
                                                        $totvax = $res[$i]['totvax'];
                                                        $totdw = $res[$i]['totdw'];
                                                        $totos = $res[$i]['totos'];
                                                        $totdf = $res[$i]['totdf'];
                                                        $totvs = $res[$i]['totvs'];
                                                        $totgs = $res[$i]['totgs'];

                                                        $totdmms_tot += $totdmms;
                                                        $totvax_tot += $totvax;
                                                        $totdw_tot += $totdw;
                                                        $totos_tot += $totos;
                                                        $totdf_tot += $totdf;
                                                        $totvs_tot += $totvs;
                                                        $totgs_tot += $totgs;


                                                        $subtotal = $totdmms + $totvax + $totdw + $totos + $totdf + $totvs + $totgs;
                                                        $total += $subtotal;

                                                ?>
                                                        <tr>
                                                            <td style="text-align: center;"><?php echo date('M d, Y', strtotime($res[$i]['trandate']));?></td>
                                                            <td style="text-align: right;"><?php echo ($totdmms == '0.00' ? '' : $totdmms);?></td>
                                                            <td style="text-align: right;"><?php echo ($totvax == '0.00' ? '' : $totvax);?></td>
                                                            <td style="text-align: right;"><?php echo ($totdw == '0.00' ? '' : $totdw);?></td>
                                                            <td style="text-align: right;"><?php echo ($totos == '0.00' ? '' : $totos);?></td>
                                                            <td style="text-align: right;"><?php echo ($totdf == '0.00' ? '' : $totdf);?></td>
                                                            <td style="text-align: right;"><?php echo ($totvs == '0.00' ? '' : $totvs);?></td>
                                                            <td style="text-align: right;"><?php echo ($totgs == '0.00' ? '' : $totgs);?></td>
                                                            <td style="text-align: right;"><?php echo ($subtotal == '0.00' ? '' : number_format($subtotal, 2));?></td>
                                                        </tr>
                                                <?php 
                                                    }

                                                    if ($len === 0) {
                                                ?>
                                                        <tr>
                                                            <td colspan="9" style="text-align: center;">No data available in table</td>
                                                        </tr>
                                                <?php 
                                                    }
                                                ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th style="text-align: right;">TOTAL </th>
                                                    <th style="text-align: right;"><?php echo ($totdmms_tot == '0.00' ? '-' : number_format($totdmms_tot, 2));?></th>
                                                    <th style="text-align: right;"><?php echo ($totvax_tot == '0.00' ? '-' : number_format($totvax_tot, 2));?></th>
                                                    <th style="text-align: right;"><?php echo ($totdw_tot == '0.00' ? '-' : number_format($totdw_tot, 2));?></th>
                                                    <th style="text-align: right;"><?php echo ($totos_tot == '0.00' ? '-' : number_format($totos_tot, 2));?></th>
                                                    <th style="text-align: right;"><?php echo ($totdf_tot == '0.00' ? '-' : number_format($totdf_tot, 2));?></th>
                                                    <th style="text-align: right;"><?php echo ($totvs_tot == '0.00' ? '-' : number_format($totvs_tot, 2));?></th>
                                                    <th style="text-align: right;"><?php echo ($totgs_tot == '0.00' ? '-' : number_format($totgs_tot, 2));?></th>
                                                    <th style="text-align: right;"><?php echo ($total == '0.00' ? '-' : number_format($total, 2));?></th>
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
    <script type="text/javascript" src="<?php echo base_url() . 'assets/js/reportsales.js'; ?>"></script>
</body>