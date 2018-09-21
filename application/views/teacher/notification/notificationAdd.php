<link rel="stylesheet" href="<?php echo base_url(); ?>backend/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
<script src="<?php echo base_url(); ?>backend/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>

<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-bullhorn"></i> <?php echo $this->lang->line('notifications'); ?> <small><?php echo $this->lang->line('student_fee1'); ?></small>
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- left column -->
                <form id="form1" action="<?php echo base_url() ?>teacher/notification/add"  id="employeeform" name="employeeform" method="post" accept-charset="utf-8">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-commenting-o"></i> <?php echo $this->lang->line('compose_new_message'); ?></h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row"> 
                                <?php if ($this->session->flashdata('msg')) { ?>
                                    <?php echo $this->session->flashdata('msg') ?>
                                <?php } ?>
                                <?php echo $this->customlib->getCSRF(); ?>
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><?php echo $this->lang->line('title'); ?></label>
                                        <input autofocus="" id="title" name="title" placeholder="" type="text" class="form-control"  value="<?php echo set_value('title'); ?>" />
                                        <span class="text-danger"><?php echo form_error('title'); ?></span>
                                    </div>
                                    <div class="form-group"><label><?php echo $this->lang->line('message'); ?></label>
                                        <textarea id="compose-textarea" name="message" class="form-control" style="height: 300px">
                                            <?php echo set_value('message'); ?>
                                        </textarea>
                                        <span class="text-danger"><?php echo form_error('message'); ?></span>
                                    </div>

                                </div>
                                <div class="col-md-3">
                                    <div class="">
                                        <?php
                                        if (isset($error_message)) {
                                            echo "<div class='alert alert-danger'>" . $error_message . "</div>";
                                        }
                                        ?>
                                        <?php //echo validation_errors(); ?>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1"><?php echo $this->lang->line('notice_date'); ?></label>
                                            <input id="date" name="date"  placeholder="" type="text" class="form-control date"  value="<?php echo set_value('date'); ?>" />
                                            <span class="text-danger"><?php echo form_error('date'); ?></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1"><?php echo $this->lang->line('publish_on'); ?></label>
                                            <input id="publish_date" name="publish_date"  placeholder="" type="text" class="form-control date"  value="<?php echo set_value('publish_date'); ?>" />
                                            <span class="text-danger"><?php echo form_error('publish_date'); ?></span>
                                        </div>
                                        <div class="form-horizontal">
                                            <label for="exampleInputEmail1"><?php echo $this->lang->line('message_to'); ?></label>
                                            <div class="checkbox">
                                                <label><input type="checkbox" name="visible[]" value="student" <?php echo set_checkbox('visible[]', 'student', false) ?> /> <b><?php echo $this->lang->line('student'); ?>s</b> </label>
                                            </div>
                                            <div class="checkbox">
                                                <label><input type="checkbox" name="visible[]"  value="parent" <?php echo set_checkbox('visible[]', 'parent', false) ?> /> <b><?php echo $this->lang->line('parent'); ?>s </b></label>
                                            </div>
                                            <div class="checkbox">
                                                <label><input type="checkbox" name="visible[]" value="teacher" <?php echo set_checkbox('visible[]', 'teacher', false) ?> /> <b><?php echo $this->lang->line('teacher'); ?>s</b> </label>
                                            </div>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('visible[]'); ?></span>

                                    </div><!-- /.box-body -->
                                </div><!--/.col (right) -->
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <div class="pull-right">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-envelope-o"></i> <?php echo $this->lang->line('send'); ?></button>
                                </div>
                            </div>
                            <!-- /.box-footer -->
                        </div>
                        <!-- /. box -->
                    </div>
                </form>
                <!-- right column -->
            </div>
        </div>
        <div class="row">
            <!-- left column -->

            <!-- right column -->
            <div class="col-md-12">

                <!-- Horizontal Form -->

                <!-- general form elements disabled -->

            </div><!--/.col (right) -->
        </div>   <!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->





<script type="text/javascript">
    $(document).ready(function () {
        var date_format = '<?php echo $result = strtr($this->customlib->getSchoolDateFormat(), ['d' => 'dd', 'm' => 'mm', 'Y' => 'yyyy',]) ?>';

        $('.date').datepicker({
            //format: "dd-mm-yyyy",
            format: date_format,
            autoclose: true
        });

        $("#btnreset").click(function () {
            /* Single line Reset function executes on click of Reset Button */
            $("#form1")[0].reset();
        });

    });


</script>
<script>
    $(function () {
        //Add text editor
        $("#compose-textarea").wysihtml5();
    });
</script>