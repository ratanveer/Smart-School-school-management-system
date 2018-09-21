<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="theme-color" content="#424242" />
        <title>Tam Advance School Management System</title>
        <link href="<?php echo base_url(); ?>backend/images/s-favican.png" rel="shortcut icon" type="image/x-icon">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
        <link rel="stylesheet" href="<?php echo base_url(); ?>backend/usertemplate/assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>backend/usertemplate/assets/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>backend/usertemplate/assets/css/form-elements.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>backend/usertemplate/assets/css/style.css">
        <style type="text/css">
            .inner-bg {padding: 10px 0 170px 0;}
            .width100, .width50{font-size: 12px !important;}
            body{background: #424242;}        
            .discover{margin-top: -90px;position: relative;z-index: -1;}
            .form-bottom {box-shadow: 0px 0px 30px rgba(0, 0, 0, 0.35);}
            .gradient{margin-top: 40px;text-align: right;padding: 10px;background: rgb(72,72,72);
                      background: -moz-linear-gradient(left, rgba(72,72,72,1) 1%, rgba(73,73,73,1) 44%, rgba(73,73,73,1) 100%);
                      background-image: linear-gradient(to right, rgba(72, 72, 72, 0.23) 1%, rgba(37, 37, 37, 0.64) 44%, rgba(73, 73, 73, 0) 100%);
                      background-position-x: initial;
                      background-position-y: initial;
                      background-size: initial;
                      background-repeat-x: initial;
                      background-repeat-y: initial;
                      background-attachment: initial;
                      background-origin: initial;
                      background-clip: initial;
                      background-color: initial;
                      background: -webkit-linear-gradient(left, rgba(72,72,72,1) 1%,rgb(73, 73, 73) 44%,rgba(73,73,73,1) 100%);
                      background: linear-gradient(to right, rgba(72, 72, 72, 0.23) 1%,rgba(37, 37, 37, 0.64) 44%,rgba(73, 73, 73, 0) 100%);
                      filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#484848', endColorstr='#494949',GradientType=1 );}        
            @media (min-width: 320px) and (max-width: 991px){
                .width100{width: 100% !important;display: block !important;
                          float: left !important; margin-bottom: 5px !important;
                          border-radius: 2px !important;}
                .width50{width: 50% !important;
                         margin-bottom: 5px !important;
                         display: block !important;
                         border-radius:2px 0px 0px 2px !important;
                         float: left !important;
                         margin-left: 0px !important; }
                .widthright50{width: 50% !important;
                              display: block !important;
                              margin-bottom: 5px !important;
                              border-radius: 0px 2px 2px 0px !important;
                              float: left !important;margin-left: 0px !important;} }
            input[type="text"], input[type="password"], textarea, textarea.form-control {
                height: 40px;border: 1px solid #999;}

            input[type="text"]:focus, input[type="password"]:focus, textarea:focus, textarea.form-control:focus {border: 1px solid #424242;}

            button.btn {height: 40px;line-height: 40px;}
            .logowidth{padding-right: 120px; /*height: 50px;*/}        
            @media(max-width:767px){
                .discover{margin-top: 10px}
                .gradient {text-align: center;}
                .logowidth{padding-right:0px;}     
            }  
            @media(min-width:768px) and (max-width:992px){
                .discover{margin-top: 10px}
                .logowidth{padding-right:0px;} 
                .gradient {text-align: center;}  
            }
        </style>
    </head>

    <body>
        <!-- Top content -->
        <div class="top-content">
            <div class="inner-bg">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12 text">
                            <div class="gradient">
                                <img src="<?php echo base_url(); ?>backend/images/s_logo.png" class="logowidth">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-12 form-box">
                            <div class="form-top">
                                <div class="form-top-left">
                                    <h3 class="font-white"><?php echo $this->lang->line('user_login'); ?></h3>
                                </div>
                                <div class="form-top-right">
                                </div>
                            </div>
                            <div class="form-bottom" style="padding-bottom: 5px;">
                                <?php
                                if (isset($error_message)) {
                                    echo "<div class='alert alert-danger'>" . $error_message . "</div>";
                                }
                                ?>
                                <?php
                                if ($this->session->flashdata('message')) {
                                    echo "<div class='alert alert-success'>" . $this->session->flashdata('message') . "</div>";
                                };
                                ?>
                                <form action="<?php echo site_url('site/userlogin') ?>" method="post">
                                    <?php echo $this->customlib->getCSRF(); ?>
                                    <div class="form-group">
                                        <label class="sr-only" for="form-username">
                                            <?php echo $this->lang->line('username'); ?></label>
                                        <input type="text" name="username" placeholder="<?php echo $this->lang->line('username'); ?>" class="form-username form-control" id="email"> <span class="text-danger"><?php echo form_error('username'); ?></span>
                                    </div>
                                    <div class="form-group">
                                        <label class="sr-only" for="form-password">Password</label>
                                        <input type="password" name="password" placeholder="<?php echo $this->lang->line('password'); ?>" class="form-password form-control" id="password"> <span class="text-danger"><?php echo form_error('password'); ?></span>
                                    </div>
                                    <button type="submit" class="btn">
                                        <?php echo $this->lang->line('sign_in'); ?></button>
                                </form>
                                
                                <p><a href="<?php echo site_url('site/ufpassword') ?>" class="forgot"> <i class="fa fa-key"></i> <?php echo $this->lang->line('forgot_password'); ?></a> </p> 
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 discover">
                            <img src="<?php echo base_url(); ?>backend/usertemplate/assets/img/backgrounds/discover.png">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="<?php echo base_url(); ?>backend/usertemplate/assets/js/jquery-1.11.1.min.js"></script>
        <script src="<?php echo base_url(); ?>backend/usertemplate/assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>backend/usertemplate/assets/js/jquery.backstretch.min.js"></script>
    </body>

</html>