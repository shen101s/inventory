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
                                    Barcode Lists
                                    <span class="pull-right">
                                        <form method="get">
                                            Category
                                            <select class="form-control input-sm form-control-new" name="category">
                                                <option value="all">All</option>
                                                <?php 
                                                    $len = count($serv);
                                                    for ($i=0; $i < $len; $i++) { 
                                                        $sel = ($serv[$i]['sid'] === $this->input->get('category')) ? 'selected' : '';
                                                ?>
                                                        <option value="<?php echo $serv[$i]['sid'];?>" <?php echo $sel;?> data-sdescription="<?php echo $serv[$i]['sdescription'];?>"><?php echo $serv[$i]['sdescription'];?></option>
                                                <?php
                                                    }
                                                ?>                                      
                                            </select>

                                            <!-- Display
                                            <select class="form-control input-sm form-control-new" name="display">
                                                <option value="barcode" <?php #echo ($this->input->get('display') === 'barcode') ? 'selected' : '';?>>Barcode Only</option>
                                                <option value="barcodeitem" <?php #echo ($this->input->get('display') === 'barcodeitem') ? 'selected' : '';?>>Barcode &amp; Item</option>                                   
                                            </select> -->

                                            <button type="submit" class="btn btn-success btn-sm" id="m_client_submit"><i class="fa fa-location-arrow"></i> Generate</button>
                                            <button type="button" class="btn btn-primary btn-sm" id="print"><i class="fa fa-print"></i> Print</button>
                                        </form>
                                    </span>
                                </div>
                                <div class="panel-body">
                                    <div id="barcode_div">
                                        <?php 
                                            $len = count($bclist);
                                            for ($i=0; $i < $len; $i++) { 
                                        ?>
                                                <div style="float: left; margin-bottom: 15px;">
                                                    <div>
                                                        <?php echo '<img class="barcode" style="margin-bottom: -10px;" alt="" src="'.base_url().'assets/barcode/barcode.php?text='.$bclist[$i]['libdbarcode'].'&codetype=code128&orientation=horizontal&size=18&print=true"/>'; ?>
                                                    </div>
                                                    <div class="text-center item-desc" style="font-size: 9px; padding: 0 5px;"><?php echo $bclist[$i]['libdesc'] . ' (' . $bclist[$i]['libdescitem'] . ')';?></div>
                                                </div>
                                        <?php 
                                            }
                                        ?>
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
    <script type="text/javascript" src="<?php echo base_url() . 'assets/js/barcodeindex.js'; ?>"></script>
</body>