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
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and me/
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
            <![endif]-->

    </head>
    <body class="hold-transition skin-blue fixed sidebar-mini">
        <div class="wrapper">
            <header class="main-header" id="alert">            
                <a href="<?php echo base_url(); ?>admin/admin/dashboard" class="logo">                 
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
                            <form class="navbar-form navbar-left search-form" role="search"  action="<?php echo site_url('admin/admin/search'); ?>" method="POST">
                                <?php echo $this->customlib->getCSRF(); ?>
                                <div class="input-group" style="padding-top:3px;">
                                    <input type="text" name="search_text" class="form-control search-form search-form3" placeholder="<?php echo $this->lang->line('search_by_name,_roll_no,_enroll_no,_national_identification_no,_local_identification_no_etc..'); ?>">
                                    <span class="input-group-btn">
                                        <button type="submit" name="search" id="search-btn" style="padding: 3px 12px !important;border-radius: 0px 30px 30px 0px; background: #fff;" class="btn btn-flat"><i class="fa fa-search"></i></button>
                                    </span>
                                </div>
                            </form>
                            <div class="navbar-custom-menu">
                                <ul class="nav navbar-nav"> 

                                    <li class="dropdown">
                                        <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false"><?php echo $this->customlib->getAdminSessionUserName(); ?>
                                            <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                                        </a>
                                        <ul class="dropdown-menu dropdown-user">
                                            <li><a href="<?php echo base_url(); ?>admin/admin/changepass"><i class="fa fa-key"></i> <?php echo $this->lang->line('change_password'); ?></a>
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
        <form class="navbar-form navbar-left search-form2" role="search"  action="<?php echo site_url('admin/admin/search'); ?>" method="POST">
            <?php echo $this->customlib->getCSRF(); ?>
            <div class="input-group ">
                <input type="text" name="search_text" class="form-control search-form" placeholder="<?php echo $this->lang->line('search_by_name,_roll_no,_enroll_no,_national_identification_no,_local_identification_no_etc..'); ?>">
                <span class="input-group-btn">
                    <button type="submit" name="search" id="search-btn" style="padding: 3px 12px !important;border-radius: 0px 30px 30px 0px; background: #fff;" class="btn btn-flat"><i class="fa fa-search"></i></button>
                </span>
            </div>
        </form>  

        <ul class="sessionul fixedmenu">
            <li class="removehover">
                <a data-toggle="modal" data-target="#sessionModal"><?php echo $this->lang->line('current_session') . ": " . $this->setting_model->getCurrentSessionName(); ?><i class="fa fa-pencil pull-right"></i></a>


            </li>
            <li class="dropdown">
                <a class="dropdown-toggle drop5" data-toggle="dropdown" href="#" aria-expanded="false">
                    <?php echo $this->lang->line('quick_links'); ?> <span class="glyphicon glyphicon-th pull-right"></span>
                </a>
                <ul class="dropdown-menu verticalmenu" style="min-width:194px;font-size:10pt;left:3px;">
                    <li role="presentation"><a style="color:#282828; font-weight:600;padding:6px 20px;" role="menuitem" tabindex="-1" href="<?php echo base_url(); ?>student/search"><i class="fa fa-user-plus"></i><?php echo $this->lang->line('student_details'); ?></a></li>
                    <li role="presentation"><a style="color:#282828; font-weight:600;padding:6px 20px;" role="menuitem" tabindex="-1" href="<?php echo base_url(); ?>studentfee"><i class="fa fa-money"></i><?php echo $this->lang->line('collect_fees'); ?></a></li>
					<li role="presentation"><a style="color:#282828; font-weight:600;padding:6px 20px;" role="menuitem" tabindex="-1" href="<?php echo base_url(); ?>admin/income"> &nbsp;<i class="fa fa-usd"></i> <?php echo $this->lang->line('add_income'); ?></a></li>
                    <li role="presentation"><a style="color:#282828; font-weight:600;padding:6px 20px;" role="menuitem" tabindex="-1" href="<?php echo base_url(); ?>admin/expense"><i class="fa fa-credit-card"></i><?php echo $this->lang->line('add_expense'); ?></a></li>
                    <li role="presentation"><a style="color:#282828; font-weight:600;padding:6px 20px;" role="menuitem" tabindex="-1" href="<?php echo base_url(); ?>admin/stuattendence"><i class="fa fa-calendar-check-o"></i><?php echo $this->lang->line('student_attendance'); ?></a></li>
                    <li role="presentation"><a style="color:#282828; font-weight:600;padding:6px 20px;" role="menuitem" tabindex="-1" href="<?php echo base_url(); ?>admin/exam"><i class="fa fa-map-o"></i><?php echo $this->lang->line('exam_list'); ?></a></li>
                    <li role="presentation"><a style="color:#282828; font-weight:600;padding:6px 20px;" role="menuitem" tabindex="-1" href="<?php echo base_url(); ?>admin/examschedule"><i class="fa fa-columns"></i><?php echo $this->lang->line('exam_schedule'); ?></a></li>
                    <li role="presentation"><a style="color:#282828; font-weight:600;padding:6px 20px;" role="menuitem" tabindex="-1" href="<?php echo base_url(); ?>admin/timetable"><i class="fa fa-calendar-times-o"></i><?php echo $this->lang->line('class_timetable'); ?></a></li>
                    <li role="presentation"><a style="color:#282828; font-weight:600;padding:6px 20px;" role="menuitem" tabindex="-1" href="<?php echo base_url(); ?>admin/teacher"><i class="fa fa-user-secret"></i></i><?php echo $this->lang->line('teachers'); ?></a></li>
                    <li role="presentation"><a style="color:#282828; font-weight:600;padding:6px 20px;" role="menuitem" tabindex="-1" href="<?php echo base_url(); ?>admin/content"><i class="fa fa-download"></i><?php echo $this->lang->line('upload_content'); ?></a></li>
                    <li role="presentation"><a style="color:#282828; font-weight:600;padding:6px 20px;" role="menuitem" tabindex="-1" href="<?php echo base_url(); ?>admin/book/getall"><i class="fa fa-book"></i><?php echo $this->lang->line('library_-_books'); ?></a></li>
					<li role="presentation"><a style="color:#282828; font-weight:600;padding:6px 20px;" role="menuitem" tabindex="-1" href="<?php echo base_url(); ?>admin/itemstock"><i class="fa fa-object-group"></i><?php echo $this->lang->line('add_item_stock'); ?></a></li>
                    <li role="presentation"><a style="color:#282828; font-weight:600;padding:6px 20px;" role="menuitem" tabindex="-1" href="<?php echo base_url(); ?>admin/route"><i class="fa fa-bus"></i><?php echo $this->lang->line('transport_-_routes'); ?></a></li>
                    <li role="presentation"><a style="color:#282828; font-weight:600;padding:6px 20px;" role="menuitem" tabindex="-1" href="<?php echo base_url(); ?>admin/hostelroom"><i class="fa fa-building-o"></i><?php echo $this->lang->line('hostel_-_rooms'); ?></a></li>
                    <li role="presentation"><a style="color:#282828; font-weight:600;padding:6px 20px;" role="menuitem" tabindex="-1" href="<?php echo base_url(); ?>admin/notification"><i class="fa fa-bullhorn"></i><?php echo $this->lang->line('notice_board'); ?></a></li>
					<li role="presentation"><a style="color:#282828; font-weight:600;padding:6px 20px;" role="menuitem" tabindex="-1" href="<?php echo base_url(); ?>admin/mailsms/compose"><i class="fa fa-envelope-o"></i><?php echo $this->lang->line('send_email_/_sms'); ?></a></li>
                </ul>
            </li>
        </ul>                 
        <ul class="sidebar-menu verttop">
            <li class="treeview <?php echo set_Topmenu('Student Information'); ?>">
                <a href="#">
                    <i class="fa fa-user-plus"></i> <span><?php echo $this->lang->line('student_information'); ?></span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="<?php echo set_Submenu('student/search'); ?>"><a href="<?php echo base_url(); ?>student/search"><i class="fa fa-angle-double-right"></i> <?php echo $this->lang->line('student_details'); ?></a></li>
                    <li class="<?php echo set_Submenu('student/create'); ?>"><a href="<?php echo base_url(); ?>student/create"><i class="fa fa-angle-double-right"></i> <?php echo $this->lang->line('student_admission'); ?></a></li>
                    <li class="<?php echo set_Submenu('category/index'); ?>"><a href="<?php echo base_url(); ?>category"><i class="fa fa-angle-double-right"></i> <?php echo $this->lang->line('student_categories'); ?></a></li>
                    <li class="<?php echo set_Submenu('stdtransfer/index'); ?>"><a href="<?php echo base_url(); ?>admin/stdtransfer"><i class="fa fa-angle-double-right"></i> <?php echo $this->lang->line('promote_students'); ?></a></li>
                </ul>
            </li>
            <li class="treeview <?php echo set_Topmenu('Fees Collection'); ?>">
                <a href="#">
                    <i class="fa fa-money"></i> <span> <?php echo $this->lang->line('fees_collection'); ?></span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="<?php echo set_Submenu('studentfee/index'); ?>"><a href="<?php echo base_url(); ?>studentfee"><i class="fa fa-angle-double-right"></i> <?php echo $this->lang->line('collect_fees'); ?></a></li>
                    <li class="<?php echo set_Submenu('admin/feemaster'); ?>"><a href="<?php echo base_url(); ?>admin/feemaster"><i class="fa fa-angle-double-right"></i> <?php echo $this->lang->line('fees_master'); ?></a></li>
                    <li class="<?php echo set_Submenu('admin/feegroup'); ?>"><a href="<?php echo base_url(); ?>admin/feegroup"><i class="fa fa-angle-double-right"></i> <?php echo $this->lang->line('fees_group'); ?></a></li>
                    <li class="<?php echo set_Submenu('feetype/index'); ?>"><a href="<?php echo base_url(); ?>admin/feetype"><i class="fa fa-angle-double-right"></i> <?php echo $this->lang->line('fees_type'); ?></a></li>
                    <li class="<?php echo set_Submenu('admin/feediscount'); ?>"><a href="<?php echo base_url(); ?>admin/feediscount"><i class="fa fa-angle-double-right"></i> <?php echo $this->lang->line('fees_discount'); ?></a></li>
                    <li class="<?php echo set_Submenu('studentfee/searchpayment'); ?>"><a href="<?php echo base_url(); ?>studentfee/searchpayment"><i class="fa fa-angle-double-right"></i> <?php echo $this->lang->line('search_fees_payment'); ?></a></li>
                    <li class="<?php echo set_Submenu('studentfee/feesearch'); ?>"><a href="<?php echo base_url(); ?>studentfee/feesearch"><i class="fa fa-angle-double-right"></i> <?php echo $this->lang->line('search_due_fees'); ?> </a></li>
                    <li class="<?php echo set_Submenu('studentfee/reportbyname'); ?>"><a href="<?php echo base_url(); ?>studentfee/reportbyname"><i class="fa fa-angle-double-right"></i> <?php echo $this->lang->line('fees_statement'); ?></a></li>                               
                    <li class="<?php echo set_Submenu('transaction/studentacademicreport'); ?>"><a href="<?php echo base_url(); ?>admin/transaction/studentacademicreport"><i class="fa fa-angle-double-right"></i>
                            <?php echo $this->lang->line('balance_fees_report'); ?></a></li>
                    <li class="<?php echo set_Submenu('accountant/index'); ?>"><a href="<?php echo base_url(); ?>admin/accountant"><i class="fa fa-angle-double-right"></i> <?php echo $this->lang->line('accountants'); ?></a></li>
                </ul>
            </li>
            <li class="treeview <?php echo set_Topmenu('Income'); ?>">
                <a href="#">
                    <i class="fa fa-usd"></i> <span><?php echo $this->lang->line('income'); ?></span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="<?php echo set_Submenu('income/index'); ?>"><a href="<?php echo base_url(); ?>admin/income"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('add_income'); ?></a></li>
                    <li class="<?php echo set_Submenu('income/incomesearch'); ?>"><a href="<?php echo base_url(); ?>admin/income/incomesearch"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('search_income'); ?></a></li>
                    <li class="<?php echo set_Submenu('incomeshead/index'); ?>"><a href="<?php echo base_url(); ?>admin/incomehead"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('income_head'); ?></a></li>
                </ul>
            </li>

            <li class="treeview <?php echo set_Topmenu('Expenses'); ?>">
                <a href="#">
                    <i class="fa fa-credit-card"></i> <span><?php echo $this->lang->line('expenses'); ?></span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="<?php echo set_Submenu('expense/index'); ?>"><a href="<?php echo base_url(); ?>admin/expense"><i class="fa fa-angle-double-right"></i> <?php echo $this->lang->line('add_expense'); ?></a></li>
                    <li class="<?php echo set_Submenu('expense/expensesearch'); ?>"><a href="<?php echo base_url(); ?>admin/expense/expensesearch"><i class="fa fa-angle-double-right"></i> <?php echo $this->lang->line('search_expense'); ?></a></li>
                    <li class="<?php echo set_Submenu('expenseshead/index'); ?>"><a href="<?php echo base_url(); ?>admin/expensehead"><i class="fa fa-angle-double-right"></i> <?php echo $this->lang->line('expense_head'); ?></a></li>
                </ul>
            </li>
            <li class="treeview <?php echo set_Topmenu('Attendance'); ?>">
                <a href="#">
                    <i class="fa fa-calendar-check-o"></i> <span><?php echo $this->lang->line('attendance'); ?></span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="<?php echo set_Submenu('stuattendence/index'); ?>"><a href="<?php echo base_url(); ?>admin/stuattendence"><i class="fa fa-angle-double-right"></i> <?php echo $this->lang->line('student_attendance'); ?></a></li>
                    <li class="<?php echo set_Submenu('stuattendence/attendenceReport'); ?>"><a href="<?php echo base_url(); ?>admin/stuattendence/attendencereport"><i class="fa fa-angle-double-right"></i> <?php echo $this->lang->line('attendance_by_date'); ?></a></li>
                    <li class="<?php echo set_Submenu('stuattendence/classattendencereport'); ?>"><a href="<?php echo base_url(); ?>admin/stuattendence/classattendencereport"><i class="fa fa-angle-double-right"></i> <?php echo $this->lang->line('attendance_report'); ?></a></li>
                </ul>
            </li>
            <li class="treeview <?php echo set_Topmenu('Examinations'); ?>">
                <a href="#">
                    <i class="fa fa-map-o"></i> <span><?php echo $this->lang->line('examinations'); ?></span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="<?php echo set_Submenu('exam/index'); ?>"><a href="<?php echo base_url(); ?>admin/exam"><i class="fa fa-angle-double-right"></i> <?php echo $this->lang->line('exam_list'); ?></a></li>
                    <li class="<?php echo set_Submenu('examschedule/index'); ?>"><a href="<?php echo base_url(); ?>admin/examschedule"><i class="fa fa-angle-double-right"></i> <?php echo $this->lang->line('exam_schedule'); ?></a></li>
                    <li class="<?php echo set_Submenu('mark/index'); ?>"><a href="<?php echo base_url(); ?>admin/mark"><i class="fa fa-angle-double-right"></i> <?php echo $this->lang->line('marks_register'); ?></a></li>
                    <li class="<?php echo set_Submenu('grade/index'); ?>"><a href="<?php echo base_url(); ?>admin/grade"><i class="fa fa-angle-double-right"></i> <?php echo $this->lang->line('marks_grade'); ?></a></li>
                </ul>
            </li>
            <li class="treeview <?php echo set_Topmenu('Academics'); ?>">
                <a href="#">
                    <i class="fa fa-mortar-board"></i> <span><?php echo $this->lang->line('academics'); ?></span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="<?php echo set_Submenu('timetable/index'); ?>"><a href="<?php echo base_url(); ?>admin/timetable"><i class="fa fa-angle-double-right"></i> <?php echo $this->lang->line('class_timetable'); ?></a></li>
                    <li class="<?php echo set_Submenu('teacher/assignTeacher'); ?>"><a href="<?php echo base_url(); ?>admin/teacher/assignteacher"><i class="fa fa-angle-double-right"></i> <?php echo $this->lang->line('assign_subjects'); ?></a></li>
                    <li class="<?php echo set_Submenu('subject/index'); ?>"><a href="<?php echo base_url(); ?>admin/subject"><i class="fa fa-angle-double-right"></i> <?php echo $this->lang->line('subjects'); ?></a></li>
                    <li class="<?php echo set_Submenu('teacher/index'); ?>"><a href="<?php echo base_url(); ?>admin/teacher"><i class="fa fa-angle-double-right"></i> <?php echo $this->lang->line('teachers'); ?></a></li>
                    <li class="<?php echo set_Submenu('classes/index'); ?>"><a href="<?php echo base_url(); ?>classes"><i class="fa fa-angle-double-right"></i> <?php echo $this->lang->line('class'); ?></a></li>
                    <li class="<?php echo set_Submenu('sections/index'); ?>"><a href="<?php echo base_url(); ?>sections"><i class="fa fa-angle-double-right"></i> <?php echo $this->lang->line('sections'); ?></a></li>
                </ul>
            </li>
            <li class="treeview <?php echo set_Topmenu('Download Center'); ?>">
                <a href="#">
                    <i class="fa fa-download"></i> <span><?php echo $this->lang->line('download_center'); ?></span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="<?php echo set_Submenu('content/index'); ?>"><a href="<?php echo base_url(); ?>admin/content"><i class="fa fa-angle-double-right"></i> <?php echo $this->lang->line('upload_content'); ?></a></li>
                    <li class="<?php echo set_Submenu('content/assignment'); ?>"><a href="<?php echo base_url(); ?>admin/content/assignment"><i class="fa fa-angle-double-right"></i> <?php echo $this->lang->line('assignments'); ?></a></li>
                    <li class="<?php echo set_Submenu('content/studymaterial'); ?>"><a href="<?php echo base_url(); ?>admin/content/studymaterial"><i class="fa fa-angle-double-right"></i> <?php echo $this->lang->line('study_material'); ?></a></li>
                    <li class="<?php echo set_Submenu('content/syllabus'); ?>"><a href="<?php echo base_url(); ?>admin/content/syllabus"><i class="fa fa-angle-double-right"></i> <?php echo $this->lang->line('syllabus'); ?></a></li>
                    <li class="<?php echo set_Submenu('content/other'); ?>"><a href="<?php echo base_url(); ?>admin/content/other"><i class="fa fa-angle-double-right"></i> <?php echo $this->lang->line('other_downloads'); ?></a></li>
                </ul>
            </li>
            <li class="treeview <?php echo set_Topmenu('Library'); ?>">
                <a href="#">
                    <i class="fa fa-book"></i> <span><?php echo $this->lang->line('library'); ?></span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">

                    <li class="<?php echo set_Submenu('book/index'); ?>"><a href="<?php echo base_url(); ?>admin/book"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('add_book'); ?></a></li>
                    <li class="<?php echo set_Submenu('book/getall'); ?>">
                        <a href="<?php echo base_url(); ?>admin/book/getall"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('book_list'); ?></a></li>
                    <li class="<?php echo set_Submenu('member/index'); ?>"><a href="<?php echo base_url(); ?>admin/member"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('issue_return'); ?></a></li>
                    <li class="<?php echo set_Submenu('member/student'); ?>"><a href="<?php echo base_url(); ?>admin/member/student"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('add_student'); ?></a></li>
                    <li class="<?php echo set_Submenu('member/teacher'); ?>"><a href="<?php echo base_url(); ?>admin/member/teacher"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('add_teacher'); ?></a></li>
                    <li class="<?php echo set_Submenu('librarian/index'); ?>"><a href="<?php echo base_url(); ?>admin/librarian"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('librarians'); ?></a></li>
                </ul>
            </li>
            <li class="treeview <?php echo set_Topmenu('Inventory'); ?>">
                <a href="#">
                    <i class="fa fa-object-group"></i> <span><?php echo $this->lang->line('inventory'); ?></span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="<?php echo set_Submenu('issueitem/index'); ?>"><a href="<?php echo base_url(); ?>admin/issueitem"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('issue_item'); ?></a></li>
                    <li class="<?php echo set_Submenu('Itemstock/index'); ?>"><a href="<?php echo base_url(); ?>admin/itemstock"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('add_item_stock'); ?></a></li>
                    <li class="<?php echo set_Submenu('Item/index'); ?>"><a href="<?php echo base_url(); ?>admin/item"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('add_item'); ?></a></li>
                    <li class="<?php echo set_Submenu('itemcategory/index'); ?>"><a href="<?php echo base_url(); ?>admin/itemcategory"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('item_category'); ?></a></li>
                    <li class="<?php echo set_Submenu('itemstore/index'); ?>"><a href="<?php echo base_url(); ?>admin/itemstore"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('item_store'); ?></a></li>
                    <li class="<?php echo set_Submenu('itemsupplier/index'); ?>"><a href="<?php echo base_url(); ?>admin/itemsupplier"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('item_supplier'); ?></a></li>
                </ul>
            </li>
            <li class="treeview <?php echo set_Topmenu('Transport'); ?>">
                <a href="#">
                    <i class="fa fa-bus"></i> <span><?php echo $this->lang->line('transport'); ?></span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="<?php echo set_Submenu('route/index'); ?>"><a href="<?php echo base_url(); ?>admin/route"><i class="fa fa-angle-double-right"></i> <?php echo $this->lang->line('routes'); ?></a></li>
                    <li class="<?php echo set_Submenu('vehicle/index'); ?>"><a href="<?php echo base_url(); ?>admin/vehicle"><i class="fa fa-angle-double-right"></i> <?php echo $this->lang->line('vehicles'); ?></a></li>
                    <li class="<?php echo set_Submenu('vehroute/index'); ?>"><a href="<?php echo base_url(); ?>admin/vehroute"><i class="fa fa-angle-double-right"></i> <?php echo $this->lang->line('assign_vehicle'); ?></a></li>
                </ul>
            </li>
            <li class="treeview <?php echo set_Topmenu('Hostel'); ?>">
                <a href="#">
                    <i class="fa fa-building-o"></i> <span><?php echo $this->lang->line('hostel'); ?></span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="<?php echo set_Submenu('hostelroom/index'); ?>"><a href="<?php echo base_url(); ?>admin/hostelroom"><i class="fa fa-angle-double-right"></i> <?php echo $this->lang->line('hostel_rooms'); ?></a></li>
                    <li class="<?php echo set_Submenu('roomtype/index'); ?>"><a href="<?php echo base_url(); ?>admin/roomtype"><i class="fa fa-angle-double-right"></i> <?php echo $this->lang->line('room_type'); ?></a></li>
                    <li class="<?php echo set_Submenu('hostel/index'); ?>"><a href="<?php echo base_url(); ?>admin/hostel"><i class="fa fa-angle-double-right"></i> <?php echo $this->lang->line('hostel'); ?></a></li>
                </ul>
            </li>
            <li class="treeview <?php echo set_Topmenu('Communicate'); ?>">
                <a href="#">
                    <i class="fa fa-bullhorn"></i> <span><?php echo $this->lang->line('communicate'); ?></span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="<?php echo set_Submenu('notification/index'); ?>"><a href="<?php echo base_url(); ?>admin/notification"><i class="fa fa-angle-double-right"></i> <?php echo $this->lang->line('notice_board'); ?></a></li>
                    <li class="<?php echo set_Submenu('notification/add'); ?>"><a href="<?php echo base_url(); ?>admin/notification/add"><i class="fa fa-angle-double-right"></i> <?php echo $this->lang->line('send_message'); ?></a></li>
                    <li class="<?php echo set_Submenu('mailsms/compose'); ?>"><a href="<?php echo base_url(); ?>admin/mailsms/compose"><i class="fa fa-angle-double-right"></i> <?php echo $this->lang->line('send_email_/_sms'); ?></a></li>
                    <li class="<?php echo set_Submenu('mailsms/index'); ?>"><a href="<?php echo base_url(); ?>admin/mailsms/index"><i class="fa fa-angle-double-right"></i> <?php echo $this->lang->line('email_/_sms_log'); ?></a></li>
                </ul>
            </li>
            <li class="treeview <?php echo set_Topmenu('Reports'); ?>">
                <a href="#">
                    <i class="fa fa-line-chart"></i> <span><?php echo $this->lang->line('reports'); ?></span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="<?php echo set_Submenu('student/studentreport'); ?>"><a href="<?php echo base_url(); ?>student/studentreport"><i class="fa fa-angle-double-right"></i>
                            <?php echo $this->lang->line('student_report'); ?></a></li>
                    <li class="<?php echo set_Submenu('reportbyname/index'); ?>"><a href="<?php echo base_url(); ?>studentfee/reportbyname"><i class="fa fa-angle-double-right"></i> <?php echo $this->lang->line('fees_statement'); ?></a></li>
                    <li class="<?php echo set_Submenu('transaction/studentacademicreport'); ?>"><a href="<?php echo base_url(); ?>admin/transaction/studentacademicreport"><i class="fa fa-angle-double-right"></i>
                            <?php echo $this->lang->line('balance_fees_report'); ?></a></li>                               
                    <li class="<?php echo set_Submenu('transaction/searchtransaction'); ?>"> <a href="<?php echo base_url(); ?>admin/transaction/searchtransaction"><i class="fa fa-angle-double-right"></i> <?php echo $this->lang->line('transaction_report'); ?></a></li>
                    <li class="<?php echo set_Submenu('stuattendence/classattendencereport'); ?>"><a href="<?php echo base_url(); ?>admin/stuattendence/classattendencereport"><i class="fa fa-angle-double-right"></i> <?php echo $this->lang->line('attendance_report'); ?></a></li>
                    <li class="<?php echo set_Submenu('mark/index'); ?>"><a href="<?php echo base_url(); ?>admin/mark"><i class="fa fa-angle-double-right"></i> <?php echo $this->lang->line('exam_marks_report'); ?></a></li>
					<li class="<?php echo set_Submenu('userlog/index'); ?>"><a href="<?php echo base_url(); ?>admin/userlog"><i class="fa fa-angle-double-right"></i> <?php echo $this->lang->line('user_log'); ?></a></li>
                </ul>
            </li>
            <li class="treeview <?php echo set_Topmenu('System Settings'); ?>">
                <a href="#">
                    <i class="fa fa-gears"></i> <span><?php echo $this->lang->line('system_settings'); ?></span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="<?php echo set_Submenu('schsettings/index'); ?>"><a href="<?php echo base_url(); ?>schsettings"><i class="fa fa-angle-double-right"></i> <?php echo $this->lang->line('general_settings'); ?></a></li>
                    <li class="<?php echo set_Submenu('sessions/index'); ?>"><a href="<?php echo base_url(); ?>sessions"><i class="fa fa-angle-double-right"></i> <?php echo $this->lang->line('session_setting'); ?></a></li>
                    <li class="<?php echo set_Submenu('notification/setting'); ?>"><a href="<?php echo base_url(); ?>admin/notification/setting"><i class="fa fa-angle-double-right"></i> <?php echo $this->lang->line('notification_setting'); ?></a></li>
                    <li class="<?php echo set_Submenu('smsconfig/index'); ?>"><a href="<?php echo base_url(); ?>smsconfig"><i class="fa fa-angle-double-right"></i> <?php echo $this->lang->line('sms_setting'); ?></a></li>
                    <li class="<?php echo set_Submenu('emailconfig/index'); ?>"><a href="<?php echo base_url(); ?>emailconfig"><i class="fa fa-angle-double-right"></i> <?php echo $this->lang->line('email_setting'); ?></a></li>
                    <li class="<?php echo set_Submenu('admin/paymentsettings'); ?>"><a href="<?php echo base_url(); ?>admin/paymentsettings"><i class="fa fa-angle-double-right"></i> <?php echo $this->lang->line('payment_methods'); ?></a></li>
                    <li class="<?php echo set_Submenu('admin/backup'); ?>"><a href="<?php echo base_url(); ?>admin/admin/backup"><i class="fa fa-angle-double-right"></i> <?php echo $this->lang->line('backup / restore'); ?></a></li>
                    <li class="<?php echo set_Submenu('language/index'); ?>"><a href="<?php echo base_url(); ?>admin/language"><i class="fa fa-angle-double-right"></i> <?php echo $this->lang->line('languages'); ?></a></li>  
                    <?php
                    $adminsess = $this->session->userdata('admin');
                    if ($adminsess['username'] == "Admin") {
                        ?>
                        <li class="<?php echo set_Submenu('adminusers/index'); ?>"><a href="<?php echo base_url(); ?>admin/adminuser"><i class="fa fa-angle-double-right"></i> <?php echo $this->lang->line('admin_users'); ?></a></li>  
                        <?php
                    }
                    ?>
                    <li class="<?php echo set_Submenu('users/index'); ?>"><a href="<?php echo base_url(); ?>admin/users"><i class="fa fa-angle-double-right"></i> <?php echo $this->lang->line('users'); ?></a></li> 
                    
                </ul>
            </li>
        </ul>
    </section>             
</aside>  
