<style type="text/css">

    /*REQUIRED*/
    .carousel-row {
        margin-bottom: 10px;
    }

    .slide-row {
        padding: 0;
        background-color: #ffffff;
        min-height: 150px;
        border: 1px solid #e7e7e7;
        overflow: hidden;
        height: auto;
        position: relative;
    }

    .slide-carousel {
        width: 20%;
        float: left;
        display: inline-block;
    }

    .slide-carousel .carousel-indicators {
        margin-bottom: 0;
        bottom: 0;
        background: rgba(0, 0, 0, .5);
    }

    .slide-carousel .carousel-indicators li {
        border-radius: 0;
        width: 20px;
        height: 6px;
    }

    .slide-carousel .carousel-indicators .active {
        margin: 1px;
    }

    .slide-content {
        position: absolute;
        top: 0;
        left: 20%;
        display: block;
        float: left;
        width: 80%;
        max-height: 76%;
        padding: 1.5% 2% 2% 2%;
        overflow-y: auto;
    }

    .slide-content h4 {
        margin-bottom: 3px;
        margin-top: 0;
    }

    .slide-footer {
        position: absolute;
        bottom: 0;
        left: 20%;
        width: 78%;
        height: 20%;
        margin: 1%;
    }

    /* Scrollbars */
    .slide-content::-webkit-scrollbar {
        width: 5px;
    }

    .slide-content::-webkit-scrollbar-thumb:vertical {
        margin: 5px;
        background-color: #999;
        -webkit-border-radius: 5px;
    }

    .slide-content::-webkit-scrollbar-button:start:decrement,
    .slide-content::-webkit-scrollbar-button:end:increment {
        height: 5px;
        display: block;
    }
</style>

<div class="content-wrapper" style="min-height: 946px;">   
    <section class="content-header">
        <h1>
            <i class="fa fa-user-plus"></i> <?php echo $this->lang->line('student_information'); ?> <small><?php echo $this->lang->line('student'); ?></small>        </h1>
    </section>  
    <section class="content">
        <div class="row">          
            <div class="col-md-12">            
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?php echo $title; ?></h3>
                    </div>
                    <div class="box-body no-padding">
                        <?php
                        $count = 1;
                        foreach ($studentlist as $student) {
                            ?>
                            <div class="row carousel-row">
                                <div class="col-xs-8 col-xs-offset-2 slide-row">
                                    <div id="carousel-2" class="carousel slide slide-carousel" data-ride="carousel">
                                        <div class="carousel-inner">
                                            <div class="item active">
                                                <img src="<?php echo base_url() . $student['image'] ?>" alt="Image">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="slide-content">
                                        <h4><a href="<?php echo base_url(); ?>teacher/student/view/<?php echo $student['id'] ?>"> <?php echo $student['firstname'] . " " . $student['firstname'] ?></a></h4>
                                        <address>
                                            <strong><?php echo $student['class'] . "(" . $student['section'] . ")" ?></strong><br>
                                            <b><?php echo $this->lang->line('admission_no'); ?>: </b><?php echo $student['admission_no'] ?><br/>

                                            <b><?php echo $this->lang->line('roll_no'); ?> : </b><?php echo $student['roll_no'] ?><br>
                                            <b>
                                                <?php echo $this->lang->line('date_of_birth'); ?> : </b>
                                            <?php echo date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($student['dob'])); ?>
                                            <br>
                                            <abbr title="Phone"><i class="fa fa-phone-square"></i>&nbsp;&nbsp;</abbr> <?php echo $student['mobileno'] ?>
                                        </address>
                                        <address>
                                            <a href="mailto:#"><i class="fa fa-at"></i>&nbsp;&nbsp;<?php echo $student['email'] ?></a>
                                        </address>
                                    </div>
                                    <div class="slide-footer">
                                        <span class="pull-right buttons">
                                            <a href="<?php echo base_url(); ?>student/view/<?php echo $student['id'] ?>" class="btn btn-info btn-xs"  data-toggle="tooltip" title="<?php echo $this->lang->line('show'); ?>" >
                                                <i class="fa fa-reorder"></i> <?php echo $this->lang->line('view'); ?>
                                            </a>
                                            <a href="<?php echo base_url(); ?>student/edit/<?php echo $student['id'] ?>" class="btn btn-warning btn-xs"  data-toggle="tooltip" title="<?php echo $this->lang->line('edit'); ?>">
                                                <i class="fa fa-pencil"></i> <?php echo $this->lang->line('eidt'); ?>
                                            </a>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <?php
                            $count++;
                        }
                        ?>
                    </div>
                    <div class="box-footer">
                        <div class="mailbox-controls"> 
                            <div class="pull-right">
                                1-50/200
                                <div class="btn-group">
                                    <button class="btn btn-default btn-sm"><i class="fa fa-chevron-left"></i></button>
                                    <button class="btn btn-default btn-sm"><i class="fa fa-chevron-right"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $("#btnreset").click(function () {
            $("#form1")[0].reset();
        });
    });
</script>