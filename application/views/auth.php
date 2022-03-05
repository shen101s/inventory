<?php $this->load->view("page/headerlink"); ?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'assets/css/auth.css';?>">

<style type="text/css">

html body {
    background: #1d3b45;
}	

.container {
	margin-top: 5%;
	box-shadow: 0 4px 8px 0 #10753b, 0 6px 20px 0 #10753b;
	width: min-content;
    background: #e0dede;
    border-radius: 4px;
}


#login form{
    width: 225px;
}
#login, .logo{
    display: inline-block;
    width: 49%;
}
#login{
    border-right:1px solid #9cb9a9;
    padding: 0px 10px;
    width: 50%;
}


#login form span.fa {
    background-color: #fbfbfb;
    border: 1px solid #0b502c40;
    color: #258352;
    border-radius: 3px 0px 0px 3px;
    display: block;
    float: left;
    height: 45px;
    font-size: 17px;
    line-height: 47px;
    text-align: center;
    width: 40px;
}

#login form input {
    height: 45px;
}

#login form input[type="text"], input[type="password"] {
    margin-bottom: 1em;
    padding: 0 10px;
    width: 185px;
    border: 1px solid #0b502c40;
    color: #0b502c;
}


.middle {
  display: flex;
  width: 500px;
}

.btn-success {
    color: #fff;
    background-color: #258352;
    border: 1px solid #d0c8c824;
}

.main {
    margin-bottom: 25px;
}

hr {

}
</style>


    <div class="wrapper">
        <div class="main">
            <div class="container">
                <center style="margin-bottom: 20px; margin-top: 10px;">
                    <div style="text-align: center; font-weight: 600;">
                        <span style="color: #28854e; text-shadow: 4px 4px 10px #37813d; font-size: 35px;">V E T C L I N I C</span>
                    </div>
                    <div style="text-align: center; font-weight: 600;">
                        <span style="color: #28854e;">"YOUR PARTNER FOR COMPLETE ANIMAL HEALTH CARE"</span>
                    </div>

                    <hr>
                    <p style="color: #0b502c;">Please log in to start your session.</p>
                    <div class="middle">
                        <div id="login">
                            <form action="validate" method="post">
                                <fieldset style="margin-top: 7px;">
                                    <p><span class="fa fa-user"></span><input type="text"  Placeholder="Username" name="authuname"  autocomplete="off" required autofocus></p>
                                    <p><span id="spanpassid" class="fa fa-eye-slash"></span><input type="password"  Placeholder="Password" name="authpword"  autocomplete="off" required></p>

                                    <div><input type="submit" value="Log In" class="btn btn-success btn-block"></div>
                                </fieldset>
                            </form>


                        </div>
                        <div class="logo">
                            <img src="<?php echo base_url() . 'assets/img/logo.png';?>" alt="Logo" style="border-radius:50%; width:100%; padding: 0 22px; opacity:0.9">
                        </div>
                    </div>
                </center>
            </div>

        </div>
    </div>

<?php $this->load->view('page/footerpage');?>
<script type="text/javascript">
    $(document).ready(function() {
        'use strict';

        $('#login').on('click', '#spanpassid', function() {
            var pwordtype = $('input[name="authpword"]').attr('type');
            if (pwordtype === 'password') {
                $('input[name="authpword"]').attr('type', 'text');

                $('#spanpassid').removeClass('fa-eye-slash');
                $('#spanpassid').addClass('fa-eye');
            } else {
                $('input[name="authpword"]').attr('type', 'password');
                $('#spanpassid').removeClass('fa-eye');
                $('#spanpassid').addClass('fa-eye-slash');
            }
        });
    });
    
</script>
