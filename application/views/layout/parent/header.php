<!DOCTYPE html>
<html <?php echo $this->customlib->getRTL(); ?>>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo $this->customlib->getAppName(); ?></title>      
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <meta name="theme-color" content="#424242" />
        <link href="<?php echo base_url(); ?>backend/images/s-favican.png" rel="shortcut icon" type="image/x-icon">
        <link rel="stylesheet" href="<?php echo base_url(); ?>backend/bootstrap/css/bootstrap.min.css">  
        <link rel="stylesheet" href="<?php echo base_url(); ?>backend/dist/css/style-main.css">


        <?php
        $this->load->view('layout/theme');
        ?>
        <?php
        if ($this->customlib->getRTL() != "") {
            ?>
            <!-- Bootstrap 3.3.5 RTL -->
            <link rel="stylesheet" href="<?php echo base_url(); ?>backend/rtl/bootstrap-rtl/css/bootstrap-rtl.min.css"/>  
            <!-- Theme RTL style -->
            <link rel="stylesheet" href="<?php echo base_url(); ?>backend/rtl/dist/css/AdminLTE-rtl.min.css" />
            <link rel="stylesheet" href="<?php echo base_url(); ?>backend/rtl/dist/css/ss-rtlmain.css">
            <link rel="stylesheet" href="<?php echo base_url(); ?>backend/rtl/dist/css/skins/_all-skins-rtl.min.css" />

            <?php
        } else {
            
        }
        ?>
        <link rel="stylesheet" href="<?php echo base_url(); ?>backend/dist/css/font-awesome.min.css">      
        <link rel="stylesheet" href="<?php echo base_url(); ?>backend/dist/css/ionicons.min.css">       

        <link rel="stylesheet" href="<?php echo base_url(); ?>backend/plugins/iCheck/flat/blue.css">      
        <link rel="stylesheet" href="<?php echo base_url(); ?>backend/plugins/morris/morris.css">       
        <link rel="stylesheet" href="<?php echo base_url(); ?>backend/plugins/jvectormap/jquery-jvectormap-1.2.2.css">        
        <link rel="stylesheet" href="<?php echo base_url(); ?>backend/plugins/datepicker/datepicker3.css">       
        <link rel="stylesheet" href="<?php echo base_url(); ?>backend/plugins/daterangepicker/daterangepicker-bs3.css">      
        <link rel="stylesheet" href="<?php echo base_url(); ?>backend/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>backend/sweet-alert/sweetalert2.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>backend/dist/css/custom_style.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>backend/datepicker/css/bootstrap-datetimepicker.css">
         <!--print table-->
        <link href="<?php echo base_url(); ?>backend/dist/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>backend/dist/datatables/css/buttons.dataTables.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>backend/dist/datatables/css/dataTables.bootstrap.min.css" rel="stylesheet">
        <script src="<?php echo base_url(); ?>backend/custom/jquery.min.js"></script>
        <script src="<?php echo base_url(); ?>backend/dist/js/moment.min.js"></script>
        <script src="<?php echo base_url(); ?>backend/datepicker/js/bootstrap-datetimepicker.js"></script>
        <script src="<?php echo base_url(); ?>backend/datepicker/date.js"></script>       
        <script src="<?php echo base_url(); ?>backend/dist/js/jquery-ui.min.js"></script>
        <script src="<?php echo base_url(); ?>backend/js/school-custom.js"></script>
        <script type="text/javascript">
            var baseurl = "<?php echo base_url(); ?>";
        </script>
     
    </head>
    <body class="hold-transition skin-blue fixed sidebar-mini">
        <div class="wrapper">
            <header class="main-header" id="alert">            
                <a href="<?php echo base_url(); ?>parent/parents/dashboard" class="logo">                   
                    <span class="logo-mini">S S</span>                  
                    <span class="logo-lg"><img src="<?php echo base_url(); ?>backend/images/s_logo.png" alt="<?php echo $this->customlib->getAppName() ?>" /></span>
                </a>              
                <nav class="navbar navbar-static-top" role="navigation">                  
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                    <div class="col-md-5 col-sm-3 col-xs-5">     
                        <span href="#" class="sidebar-session">
                            <?php echo $this->setting_model->getCurrentSchoolName(); ?>
                        </span>
                    </div>    
                    <div class="col-md-7 col-sm-9 col-xs-7">
                        <div class="pull-right">    
                            <div class="navbar-custom-menu">
                                <ul class="nav navbar-nav"> 

                                    <li class="dropdown">
                                        <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false"><?php echo $this->customlib->getStudentSessionUserName();
                            ?>
                                            <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                                        </a>
                                        <ul class="dropdown-menu dropdown-user">
                                            <li><a href="<?php echo base_url(); ?>parent/parents/changepass"><i class="fa fa-key"></i><?php echo $this->lang->line('change_password'); ?></a>
                                            </li>
                                            <li class="divider"></li>
                                            <li><a href="<?php echo base_url(); ?>site/logout"><i class="fa fa-sign-out fa-fw"></i> <?php echo $this->lang->line('logout'); ?></a>
                                            </li>
                                        </ul>                              
                                    </li>  
                                </ul>
                            </div>
                        </div>
                    </div>  
                </nav>
            </header>
            <aside class="main-sidebar" id="alert2">              
                <section class="sidebar" id="sibe-box"> 
                    <ul class="sessionul fixedmenu"> 
                        <li class="removehover accurrent">
                            <?php echo $this->lang->line('current_session') . ": " . $this->setting_model->getCurrentSessionName(); ?>
                        </li>      
                    </ul>               
                    <ul class="sidebar-menu verttop38">
                        <li class="treeview <?php echo set_Topmenu('My Children'); ?>">
                            <a href="#">
                                <i class=" fa fa-users"></i> <span>
                                    <?php echo $this->lang->line('my_children'); ?></span> <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu ">
                                <?php
                                $ch = $this->session->userdata('parent_childs');
                                foreach ($ch as $key_ch => $value_ch) {
                                    ?>
                                    <li class="<?php echo set_Submenu('parent/parents/getStudent'); ?>" ><a href="<?php echo base_url(); ?>parent/parents/getstudent/<?php echo $value_ch['student_id'] ?>"><i class="fa fa-angle-double-right"></i> <?php echo $value_ch['name'] ?></a></li>
                                    <?php
                                }
                                ?>
                            </ul>
                        </li>
                        <li class="treeview <?php echo set_Topmenu('Fees'); ?>">
                            <a href="#">
                                <i class="fa fa-money"></i> <span><?php echo $this->lang->line('fees'); ?></span> <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <?php
                                $ch = $this->session->userdata('parent_childs');
                                foreach ($ch as $key_ch => $value_ch) {
                                    ?>
                                    <li class="<?php echo set_Submenu('parent/parents/getFees'); ?>" ><a href="<?php echo base_url(); ?>parent/parents/getfees/<?php echo $value_ch['student_id'] ?>"><i class="fa fa-angle-double-right"></i> <?php echo $value_ch['name'] ?></a></li>
                                    <?php
                                }
                                ?>
                            </ul>
                        </li>
                        <li class="treeview <?php echo set_Topmenu('Time Table'); ?>">
                            <a href="#">
                                <i class="fa fa-calendar-times-o"></i> <span><?php echo $this->lang->line('class_timetable'); ?></span> <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <?php
                                $ch = $this->session->userdata('parent_childs');
                                foreach ($ch as $key_ch => $value_ch) {
                                    ?>
                                    <li class="<?php echo set_Submenu('parent/parents/gettimetable'); ?>"><a href="<?php echo base_url(); ?>parent/parents/gettimetable/<?php echo $value_ch['student_id'] ?>"><i class="fa fa-angle-double-right"></i> <?php echo $value_ch['name'] ?></a></li>
                                    <?php
                                }
                                ?>
                            </ul>
                        </li>
                        <li class="treeview <?php echo set_Topmenu('Attendance'); ?>">
                            <a href="#">
                                <i class="fa fa-calendar-check-o"></i> <span><?php echo $this->lang->line('attendance'); ?></span> <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <?php
                                $ch = $this->session->userdata('parent_childs');
                                foreach ($ch as $key_ch => $value_ch) {
                                    ?>
                                    <li class="<?php echo set_Submenu('parent/parents/getattendence'); ?>"><a href="<?php echo base_url(); ?>parent/parents/getattendence/<?php echo $value_ch['student_id'] ?>"><i class="fa fa-angle-double-right"></i> <?php echo $value_ch['name'] ?></a></li>
                                    <?php
                                }
                                ?>
                            </ul>
                        </li>
                        <li class="treeview <?php echo set_Topmenu('Examination'); ?>">
                            <a href="#">
                                <i class="fa fa-map-o"></i> <span><?php echo $this->lang->line('examinations'); ?></span> <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu ">
                                <?php
                                $ch = $this->session->userdata('parent_childs');
                                foreach ($ch as $key_ch => $value_ch) {
                                    ?>
                                    <li class="<?php echo set_Submenu('parent/parents/getexams'); ?>"><a href="<?php echo base_url(); ?>parent/parents/getexams/<?php echo $value_ch['student_id'] ?>"><i class="fa fa-angle-double-right"></i> <?php echo $value_ch['name'] ?></a></li>
                                    <?php
                                }
                                ?>
                            </ul>
                        </li>
                        <li class="treeview <?php echo set_Topmenu('Notification'); ?>">
                            <a href="<?php echo base_url(); ?>parent/notification">
                                <i class="fa fa-envelope"></i> <span><?php echo $this->lang->line('notice_board'); ?></span>
                                <?php
                                $ntf = $this->customlib->getParentunreadNotification();

                                if ($ntf) {
                                    ?>
                                    <small class="label pull-right bg-red">
                                        <?php echo $ntf; ?>
                                    </small>
                                    <?php
                                }
                                ?>
                            </a>
                        </li>
                        <li class="treeview <?php echo set_Topmenu('Subjects'); ?>">
                            <a href="#">
                                <i class="fa fa-language"></i> <span><?php echo $this->lang->line('subjects'); ?></span> <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <?php
                                $ch = $this->session->userdata('parent_childs');
                                foreach ($ch as $key_ch => $value_ch) {
                                    ?>
                                    <li class="<?php echo set_Submenu('parent/parents/getsubject'); ?>"><a href="<?php echo base_url(); ?>parent/parents/getsubject/<?php echo $value_ch['student_id'] ?>"><i class="fa fa-angle-double-right"></i> <?php echo $value_ch['name'] ?></a></li>
                                    <?php
                                }
                                ?>
                            </ul>
                        </li>
                        <li class="<?php echo set_Submenu('teacher/index'); ?>"><a href="<?php echo base_url(); ?>parent/teacher"><i class="fa fa-user-secret"></i> <?php echo $this->lang->line('teachers'); ?></a></li>
                        <li class="<?php echo set_Topmenu('Library'); ?>"><a href="<?php echo base_url(); ?>parent/book"><i class="fa fa-book"></i> <?php echo $this->lang->line('library_books'); ?></a></li>
                        <li class="treeview <?php echo set_Topmenu('Transport'); ?>"><a href="<?php echo base_url(); ?>parent/route"><i class="fa fa-bus"></i> <?php echo $this->lang->line('transport_routes'); ?></a></li>
                        <li class="<?php echo set_Submenu('hostel/index'); ?>"><a href="<?php echo base_url(); ?>parent/hostel"><i class="fa fa-building-o"></i> <?php echo $this->lang->line('hostel'); ?></a></li>
                    </ul>
                </section>              
            </aside>  