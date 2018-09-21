<div class="content-wrapper" style="min-height: 946px;">
    <section class="content-header">
        <h1>
            <i class="fa fa-calendar-times-o"></i> <?php echo $this->lang->line('class_timetable'); ?> </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <?php
                if (isset($result_array)) {
                    ?>
                    <div class="box box-warning">
                        <div class="box-body">
                            <?php
                            if (!empty($result_array)) {
                                ?>
                                <div class="table-responsive">
								<div class="download_label"><?php echo $this->lang->line('class_timetable'); ?></div>
                                    <table class="table  table-bordered example">
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
                                                                        <b class="text text-center">
                                                                            <b class="text text-center"><?php echo $this->lang->line('not'); ?> <br/><?php echo $this->lang->line('scheduled'); ?></b><br/>
                                                                        </b><br/>
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
            <?php
        } else {
            
        }
        ?>
    </section>
</div>