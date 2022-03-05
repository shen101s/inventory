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
                                    Total Sales
                                    <span class="pull-right">
                                        <select class="form-control input-sm" id="totalsalespermonth">
                                            <?php 
                                                $yy = date('Y') * 1; 
                                                for ($i=$yy; $i>2021; $i--) {
                                            ?>
                                                    <option value="<?php echo $i;?>" <?php echo ($i === $yy-1 ? 'selected':''); ?> ><?php echo $i;?></option>
                                            <?php } ?>
                                        </select>
                                    </span>
                                </div>
                                <div class="panel-body">
                                    <canvas id="lineChart"></canvas>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="panel panel-default">
                                <div class="panel-header">
                                    6 months nearly expiry item(s)
                                </div>
                                <div class="panel-body">
                                    <table class="table table-striped table-hovered">
                                        <thead>
                                            <tr>
                                                <th>Category</th>
                                                <th>Item</th>
                                                <th>Unit</th>
                                                <th>Price</th>
                                                <th>Qty</th>
                                                <th>Expiration</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $len = count($exp);
                                                for ($i=0; $i < $len; $i++) { 
                                            ?>
                                                    <tr>
                                                        <td><?php echo $exp[$i]['scode'];?></td>
                                                        <td><?php echo $exp[$i]['libdesc'] . '-' . $exp[$i]['libdescitem'];?></td>
                                                        <td><?php echo $exp[$i]['unitcode'];?></td>
                                                        <td><?php echo $exp[$i]['libdprice'];?></td>
                                                        <td><?php echo ($exp[$i]['libdqty'] == 0 ? '' : $exp[$i]['libdqtyrem']);?></td>
                                                        <td><?php echo ($exp[$i]['libdexp'] === NULL) ? '-' : date('M d, Y', strtotime($exp[$i]['libdexp']));?></td>
                                                    </tr>
                                            <?php 
                                                }

                                                if ($len === 0) {
                                            ?>
                                                    <tr>
                                                        <td colspan="6" class="text-center">No data available in table</td>
                                                    </tr>
                                            <?php 
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="panel panel-default">
                                <div class="panel-header">
                                    Expired item(s)
                                </div>
                                <div class="panel-body">
                                    <table class="table table-striped table-hovered">
                                        <thead>
                                            <tr>
                                                <th>Category</th>
                                                <th>Item</th>
                                                <th>Unit</th>
                                                <th>Price</th>
                                                <th>Qty</th>
                                                <th>Expiration</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $len = count($expd);
                                                for ($i=0; $i < $len; $i++) { 
                                            ?>
                                                    <tr>
                                                        <td><?php echo $expd[$i]['scode'];?></td>
                                                        <td><?php echo $expd[$i]['libdesc'] . '-' . $expd[$i]['libdescitem'];?></td>
                                                        <td><?php echo $expd[$i]['unitcode'];?></td>
                                                        <td><?php echo $expd[$i]['libdprice'];?></td>
                                                        <td><?php echo ($expd[$i]['libdqty'] == 0 ? '' : $expd[$i]['libdqtyrem']);?></td>
                                                        <td><?php echo ($expd[$i]['libdexp'] === NULL) ? '-' : date('M d, Y', strtotime($expd[$i]['libdexp']));?></td>
                                                    </tr>
                                            <?php 
                                                }

                                                if ($len === 0) {
                                            ?>
                                                    <tr>
                                                        <td colspan="6" class="text-center">No data available in table</td>
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
</body>

<script type="text/javascript" src="<?php echo base_url() . 'assets/credits/chartjs/Chart.min.js'?>"></script>
<script type="text/javascript">
    $(function() {
        $('#l_home').addClass('active');

        var totalsalespermonth = function(yy) {
            $.get('totalsalespermonth', {'yy':yy}, function(data){
                data = JSON.parse(data);
                console.log(data);

                if ($('#lineChart').length ){
                    var ctx = document.getElementById("lineChart");
                    var lineChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                            datasets: [{
                                    label: "DMMS",
                                    borderColor: "rgba(3, 88, 106, 0.70)",
                                    pointBorderWidth: 1,
                                    fill: false,
                                    data: data.totdmms
                                },
                                {
                                    label: "Vaccine",
                                    borderColor: "#26811b",
                                    pointBorderWidth: 1,
                                    fill: false,
                                    data: data.totvax
                                },
                                {
                                    label: "Deworming",
                                    borderColor: "#8e5ea2",
                                    pointBorderWidth: 1,
                                    fill: false,
                                    data: data.totdw
                                },
                                {
                                    label: "Other Supplies",
                                    borderColor: "#88900b",
                                    pointBorderWidth: 1,
                                    fill: false,
                                    data: data.totos
                                },
                                {
                                    label: "Dog Food",
                                    borderColor: "#c45850",
                                    pointBorderWidth: 1,
                                    fill: false,
                                    data: data.totdf
                                },
                                {
                                    label: "Vet Services",
                                    borderColor: "#187967",
                                    pointBorderWidth: 1,
                                    fill: false,
                                    data: data.totvs
                                },
                                {
                                    label: "Grooming Services",
                                    borderColor: "#c6d261",
                                    pointBorderWidth: 1,
                                    fill: false,
                                    data: data.totgs
                                }

                            ]
                        },

                        options: {
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true
                                    },

                                }]
                            }
                        }
                    });
                }
            });    
        };

        var today = new Date();
        var yy = today.getFullYear();
        totalsalespermonth(yy);

        $('#content-wrapper').on('change', '#totalsalespermonth', function() {
            var yy_ = $(this).val();
            totalsalespermonth(yy_);
        });


    });
</script>

