<aside class="main-sidebar" id="main-sidebar">
    <section class="sidebar">
        <div class="fs-border">
            <div class="clearfix">
                <div class="profile_pic">
                    <img src="<?php echo base_url() . 'assets/img/user.png'; ?>" alt="..." class="profile_img">
                </div>
                <div class="profile_info">
                    <span>Welcome,</span><br>
                    <span><b><?php echo $this->session->userdata('fname');?></b></span>
                </div>
            </div>
        </div>

        <div class="fs-border">
            <div class="sidebar-wrapper">
                <ul class="nav">
                    <li class="list-header">GENERAL</li>
                    <li id="l_home">
                        <a href="<?php echo base_url();?>">
                            <i class="fa fa-house-damage"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li id="l_trans">
                        <a href="<?php echo base_url() . 'transaction';?>">
                            <i class="fa fa-retweet"></i>
                            <p>Transaction</p>
                        </a>
                    </li>
                    <li id="l_barcode">
                        <a href="<?php echo base_url() . 'billing';?>">
                            <i class="fa fa-barcode"></i>
                            <p>Billing</p>
                        </a>
                    </li>
                    <li id="l_client">
                        <a href="<?php echo base_url() . 'client';?>">
                            <i class="fa fa-users"></i>
                            <p>Client</p>
                        </a>
                    </li>
                    <li class="nav-item dropdown l_report" style="line-height: 30px;">
                        <!-- dropdown-toggle -->
                        <a class="nav-link arrow-right" id="navreport" data-toggle="collapse" href="#lib-collapse" role="button" aria-expanded="false" aria-controls="lib-collapse">
                            <i class="fas fa-chart-pie"></i>
                            <p>Report</p>
                        </a>
                        <div class="collapse" id="lib-collapse">
                            <ul class="nav flex-column" id="navbar_lib" style="margin-left: 10px;">
                                <li class="nav-item" id="l_report_salessummary">
                                    <a class="nav-link" href="<?php echo base_url().'report/sales';?>"><i class="fas fa-file-alt"></i> Sales Summary</a>
                                </li>
                                <li class="nav-item" id="l_report_stockissuance">
                                    <a class="nav-link" href="<?php echo base_url().'report/stockissuance';?>"><i class="fas fa-book-open"></i> Stock Issuance</a>
                                </li>
                                <li class="nav-item" id="l_report_stockinventory">
                                    <a class="nav-link" href="<?php echo base_url().'report/stockinventory';?>"><i class="fas fa-book-open"></i> Stock Inventory</a>
                                </li>
                                <!-- <li class="nav-item" id="l_report_expiryitem">
                                    <a class="nav-link" href="<?php #echo base_url().'report/expiryitem';?>"><i class="fas fa-book-open"></i> Expiry Item</a>
                                </li> -->
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>


            <div class="sidebar-wrapper">
                <ul class="nav">
                    <li class="list-header">LIBRARY</li>      
                    <!-- <li id="l_employees">
                        <a href="<?php #echo base_url() . 'employees';?>">
                            <i class="fa fa-users"></i>
                            <p>Employees</p>
                        </a>
                    </li> -->

                    <li id="l_users">
                        <a href="<?php echo base_url() . 'users';?>">
                            <i class="fa fa-users"></i>
                            <p>Users</p>
                        </a>
                    </li>
                    

                    <li id="l_services">
                        <a href="<?php echo base_url() . 'categories';?>">
                            <i class="fas fa-cogs"></i>
                            <p>Items/Services</p>
                        </a>
                    </li>
                    <li id="l_barcodelist">
                        <a href="<?php echo base_url() . 'barcode';?>">
                            <i class="fa fa-barcode"></i>
                            <p>Barcode Lists</p>
                        </a>
                    </li>
                    
                    <li id="l_unit">
                        <a href="<?php echo base_url() . 'unit';?>">
                            <i class="fas fa-pencil-ruler"></i>
                            <p>Unit</p>
                        </a>
                    </li>
                    <li id="l_species">
                        <a href="<?php echo base_url() . 'species';?>">
                            <i class="fas fa-dog"></i>
                            <p>Species</p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

    </section>
</aside>