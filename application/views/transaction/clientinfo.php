<?php $this->load->view("page/headerlink"); ?>
<body id="body">
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
                                    <span>ADD NEW </span> Pet Name
                                </div>
                                <div class="panel-body">
                                    <form action="transsave" method="post">

                                        <div class="form-group col-md-12">
                                            <label for="trans_serv">Pet Name:</label>

                                            <table class="table table-striped table-bordered table-hovered">
                                                <thead>
                                                    <tr>
                                                        <td>Name</td>
                                                        <td>Birth Date</td>
                                                        <td>Species</td>
                                                        <td>Breed</td>
                                                        <td>Gender</td>
                                                        <td>Vaccination History</td>
                                                        <td></td>
                                                    </tr>
                                                </thead>
                                                <tbody id="m_pet_tbody">
                                                    <tr>
                                                        <td>
                                                            <input type="text" class="form-control input-sm" id="m_fpetname" placeholder="start typing here...">
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control input-sm" id="m_petbday" placeholder="start typing here...">
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control input-sm" id="m_fpetname" placeholder="start typing here...">
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control input-sm" id="m_fpetname" placeholder="start typing here...">
                                                        </td>
                                                        <td>
                                                            <select class="form-control input-sm">
                                                                <option value="">Select...</option>
                                                                <option value="Male">Male</option>
                                                                <option value="Female">Female</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <textarea placeholder="start typing here..." rows="2"></textarea>
                                                        </td>
                                                        <td>
                                                            <a href="javascript:void(0);" id="m_pet_add" class="btn btn-primary btn-sm">Save</a>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                       
                                    </form>

                                 
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </section>
        </div>
    </div>



    <?php $this->load->view('page/footerpage');?>
    <script type="text/javascript" src="<?php echo base_url() . 'assets/js/transaction.js'; ?>"></script>
</body>