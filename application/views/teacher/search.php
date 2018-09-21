<?php
$currency_symbol = $this->customlib->getSchoolCurrencyFormat();
?>
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
        height: 10%;
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
            <i class="fa fa-user"></i> <?php echo $this->lang->line('search_student'); ?></h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <?php
                if (isset($resultlist)) {
                    ?>
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true"><i class="fa fa-list"></i> <?php echo $this->lang->line('student_lists'); ?></a></li>
                            <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false"><i class="fa fa-newspaper-o"></i> <?php echo $this->lang->line('detailed_view'); ?></a></li>

                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active table-responsive no-padding" id="tab_1">
							<div class="download_label"><?php echo $this->lang->line('student_lists'); ?></div>
                                <table class="table table-striped table-bordered table-hover example">
                                    <thead>
                                        <tr>
                                            <th><?php echo $this->lang->line('admission_no'); ?></th>
                                            <th><?php echo $this->lang->line('student_name'); ?></th>
                                            <th><?php echo $this->lang->line('class'); ?></th>
                                            <th><?php echo $this->lang->line('father_name'); ?></th>
                                            <th><?php echo $this->lang->line('date_of_birth'); ?></th>
                                            <th><?php echo $this->lang->line('gender'); ?></th>
                                            <th><?php echo $this->lang->line('category'); ?></th>
                                            <th><?php echo $this->lang->line('mobile_no'); ?></th>

                                            <th class="text-right"><?php echo $this->lang->line('action'); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (empty($resultlist)) {
                                            ?>
                                            <tr>
                                                <td colspan="9" class="text-danger text-center"><?php echo $this->lang->line('no_record_found'); ?></td>

                                            </tr>
                                            <?php
                                        } else {
                                            $count = 1;
                                            foreach ($resultlist as $student) {
                                                ?>
                                                <tr>
                                                    <td><?php echo $student['admission_no']; ?></td>
                                                    <td>
                                                        <a href="<?php echo base_url(); ?>teacher/student/view/<?php echo $student['id']; ?>"><?php echo $student['firstname'] . " " . $student['lastname']; ?>
                                                        </a>
                                                    </td>
                                                    <td><?php echo $student['class'] . "(" . $student['section'] . ")" ?></td>
                                                    <td><?php echo $student['father_name']; ?></td>

                                                    <td><?php echo date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($student['dob'])); ?></td>
                                                    <td><?php echo $student['gender']; ?></td>
                                                    <td><?php echo $student['category']; ?></td>
                                                    <td><?php echo $student['mobileno']; ?></td>

                                                    <td class="pull-right">
                                                        <a href="<?php echo base_url(); ?>teacher/student/view/<?php echo $student['id'] ?>" class="btn btn-default btn-xs"  data-toggle="tooltip" title="<?php echo $this->lang->line('show'); ?>" >
                                                            <i class="fa fa-reorder"></i>
                                                        </a>
                                                        <a href="<?php echo base_url(); ?>teacher/student/edit/<?php echo $student['id'] ?>" class="btn btn-default btn-xs"  data-toggle="tooltip" title="<?php echo $this->lang->line('edit'); ?>">
                                                            <i class="fa fa-pencil"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <?php
                                                $count++;
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>                           
                            <div class="tab-pane" id="tab_2">
                                <?php
                                $count = 1;
                                foreach ($resultlist as $student) {
                                    ?>

                                    <div class="carousel-row">
                                        <div class="slide-row">
                                            <div id="carousel-2" class="carousel slide slide-carousel" data-ride="carousel">
                                                <div class="carousel-inner">
                                                    <div class="item active">
                                                        <a href="<?php echo base_url(); ?>teacher/student/view/<?php echo $student['id'] ?>"> <img class="img-responsive img-thumbnail width150" alt="Cinque Terre"  src="<?php echo base_url() . $student['image'] ?>" alt="Image"></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="slide-content">
                                                <h4><a href="<?php echo base_url(); ?>teacher/student/view/<?php echo $student['id'] ?>"> <?php echo $student['firstname'] . " " . $student['lastname'] ?></a></h4>
                                                <div class="row">
                                                    <div class="col-xs-6 col-md-6">
                                                        <address>
                                                            <strong><b><?php echo $this->lang->line('class'); ?>: </b><?php echo $student['class'] . "(" . $student['section'] . ")" ?></strong><br>
                                                            <b><?php echo $this->lang->line('admission_no'); ?>: </b><?php echo $student['admission_no'] ?><br/>
                                                            <b><?php echo $this->lang->line('date_of_birth'); ?>:</b>
                                                            <?php echo date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($student['dob'])); ?><br>
                                                            <b><?php echo $this->lang->line('gender'); ?>:&nbsp;&nbsp;</b><?php echo $student['gender'] ?><br>
                                                        </address>
                                                    </div>
                                                    <div class="col-xs-6 col-md-6">
                                                        <b><?php echo $this->lang->line('local_identification_no'); ?> : &nbsp;&nbsp;</b><?php echo $student['samagra_id'] ?><br>
                                                        <b><?php echo $this->lang->line('guardian_name'); ?> :&nbsp;&nbsp;</b><?php echo $student['guardian_name'] ?><br>
                                                        <b><?php echo $this->lang->line('guardian_phone'); ?>: </b> <abbr title="Phone"><i class="fa fa-phone-square"></i>&nbsp;&nbsp;</abbr> <?php echo $student['guardian_phone'] ?><br>
                                                        <b><?php echo $this->lang->line('current_address'); ?>:&nbsp;&nbsp;</b><?php echo $student['current_address'] ?>, <?php echo $student['city'] ?><br>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="slide-footer">
                                                <span class="pull-right buttons">
                                                    <a href="<?php echo base_url(); ?>teacher/student/view/<?php echo $student['id'] ?>" class="btn btn-default btn-xs"  data-toggle="tooltip" title="<?php echo $this->lang->line('show'); ?>" >
                                                        <i class="fa fa-reorder"></i>
                                                    </a>
                                                    <a href="<?php echo base_url(); ?>teacher/student/edit/<?php echo $student['id'] ?>" class="btn btn-default btn-xs"  data-toggle="tooltip" title="<?php echo $this->lang->line('edit'); ?>">
                                                        <i class="fa fa-pencil"></i>
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
                        </div>                       
                    </div>
                    <?php
                }
                ?>
            </div> 
        </div> 
    </section>
</div>