<div class="content-wrapper" style="min-height: 946px;">
    <section class="content-header">
        <h1>
            <i class="fa fa-user-plus"></i> <?php echo $this->lang->line('student_information'); ?><small><?php echo $this->lang->line('student1'); ?></small>        </h1>
    </section>    
    <section class="content">
        <div class="row">
            <div class="col-md-3">            
                <div class="box box-primary">
                    <div class="box-body box-profile">
                        <img class="profile-user-img img-responsive img-circle" src="<?php echo base_url() . $student['image'] ?>" alt="User profile picture">
                        <h3 class="profile-username text-center"><?php echo $student['firstname'] . " " . $student['lastname']; ?></h3>
                        <ul class="list-group list-group-unbordered">
                            <li class="list-group-item">
                                <b><?php echo $this->lang->line('admission_no'); ?></b> <a class="pull-right text-aqua"><?php echo $student['admission_no']; ?></a>
                            </li>
                            <li class="list-group-item">
                                <b><?php echo $this->lang->line('roll_no'); ?></b> <a class="pull-right text-aqua"><?php echo $student['roll_no']; ?></a>
                            </li>
                            <li class="list-group-item">
                                <b><?php echo $this->lang->line('class'); ?></b> <a class="pull-right text-aqua"><?php echo $student['class']; ?></a>
                            </li>
                            <li class="list-group-item">
                                <b><?php echo $this->lang->line('section'); ?></b> <a class="pull-right text-aqua"><?php echo $student['section']; ?></a>
                            </li>
                            <li class="list-group-item">
                                <b><?php echo $this->lang->line('rte'); ?></b> <a class="pull-right text-aqua"><?php echo $student['rte']; ?></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="box box-primary">
                    <div class="box-header ptbnull">
                        <h3 class="box-title titlefix">
                            <?php echo $this->lang->line('class_timetable'); ?>
                        </h3>
                    </div>
                    <div class="box-body">
                        <?php
                        if (!empty($result_array)) {
                            ?>
                            <div class="table-responsive">
                                <div class="download_label"><?php echo $this->lang->line('class_timetable'); ?></div>
                                <table class="table table-bordered table-hover example">
                                    <thead>
                                        <tr>
                                            <th>
                                                <?php echo $this->lang->line('subject'); ?>
                                            </th>
                                            <?php foreach ($getDaysnameList as $key => $value) {
                                                ?>
                                                <th class="text text-center">
                                                    <?php echo $value; ?>
                                                </th>
                                            <?php }
                                            ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($result_array as $key => $timetable) {
                                            ?>
                                            <tr>
                                                <th><?php echo $key; ?></th>
                                                <?php
                                                foreach ($timetable as $key => $value) {
                                                    $status = $value->status;
                                                    if ($status == "Yes") {
                                                        ?>
                                                        <td class="text text-center">
                                                            <div class="attachment-block clearfix">
                                                                <?php
                                                                if ($value->start_time != "" && $value->end_time != "") {
                                                                    ?>
                                                                    <strong class="text-green"><?php echo $value->start_time; ?></strong>
                                                                    <b class="text text-center">-</b>
                                                                    <strong class="text-green"><?php echo $value->end_time; ?></strong><br/>
                                                                    <strong class="text-green"><?php echo $this->lang->line('room_no'); ?>:<?php echo $value->room_no; ?>:</strong>
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                    <b class="text text-center"><?php echo $this->lang->line('not'); ?> <br/><?php echo $this->lang->line('scheduled'); ?></b><br/>
                                                                    <strong class="text-green"></strong>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </div>
                                                        </td>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <td class="text text-center">
                                                            <div class="attachment-block clearfix">
                                                                <strong class="text-red"><?php echo $value->start_time; ?></strong><br/>
                                                            </div>
                                                        </td>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php
                        } else {
                            ?>
                            <div class="alert alert-info"><?php echo $this->lang->line('no_record_found'); ?></div>
                            <?php
                        }
                        ?>
                    </div>  
                </div>
            </div>
        </div>
</div>
</section>
</div>