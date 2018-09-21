<link rel="stylesheet" href="<?php echo base_url(); ?>backend/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
<script src="<?php echo base_url(); ?>backend/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-bullhorn"></i> <?php echo $this->lang->line('communicate'); ?> <small><?php echo $this->lang->line('student_fee1'); ?></small>
        </h1>
  <!--        <ul class="breadcrumb"><li><a href="/"><i class="fa fa-home"></i>Home</a></li>
  <li><a href="#">Fee Management</a></li>
  <li class="active">Student</li>
  </ul>   -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-solid1">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-commenting-o"></i> <?php echo $this->lang->line('notice_board'); ?></h3>
                        <div class="box-tools pull-right">
                            <a href="<?php echo base_url() ?>teacher/notification/add" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> <?php echo $this->lang->line('post_new_message'); ?></a>


                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="box-group" id="accordion">

                            <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                            <?php if (empty($notificationlist)) {
                                ?>
                                <div class="alert alert-info"><?php echo $this->lang->line('no_record_found'); ?></div>
                                <?php
                            } else {
                                foreach ($notificationlist as $key => $notification) {
                                    ?>
                                    <div class="panel box box-primary">
                                        <div class="box-header with-border">
                                            <h4 class="box-title">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $notification['id']; ?>" aria-expanded="false" class="collapsed">
                                                    <?php echo $notification['title']; ?>
                                                </a>


                                            </h4>
                                            <div class="pull-right">


                                                <a href="<?php echo base_url() ?>teacher/notification/edit/<?php echo $notification['id'] ?>" class="" data-toggle="tooltip" title="<?php echo $this->lang->line('edit'); ?>" data-original-title="<?php echo $this->lang->line('add'); ?>">
                                                    <i class="fa fa-pencil"></i>
                                                </a>
                                                &nbsp;                                              <a href="<?php echo base_url() ?>teacher/notification/delete/<?php echo $notification['id'] ?>" class="" data-toggle="tooltip" title="<?php echo $this->lang->line('delete'); ?>" data-original-title="<?php echo $this->lang->line('add'); ?>">
                                                    <i class="fa fa-remove"></i>
                                                </a>

                                            </div>
                                        </div>
                                        <div id="collapse<?php echo $notification['id']; ?>" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                                            <div class="box-body">
                                                <div class="row">

                                                    <div class="col-md-9">

                                                        <?php echo $notification['message']; ?>
                                                    </div><!-- /.col -->
                                                    <div class="col-md-3">

                                                        <div class="box box-solid">

                                                            <div class="box-body no-padding">
                                                                <ul class="nav nav-pills nav-stacked">
                                                                    <li><i class="fa fa-calendar-check-o"></i> <?php echo $this->lang->line('publish_date'); ?> : <?php echo date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($notification['publish_date'])); ?> </li>
                                                                    <li><i class="fa fa-calendar"></i> <?php echo $this->lang->line('notice_date'); ?> : <?php echo date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($notification['date'])); ?> </li>

                                                                </ul>
                                                                <h4 class="text text-primary"> <?php echo $this->lang->line('message_to'); ?></h4>
                                                                <ul class="nav nav-pills nav-stacked">
                                                                    <li><i class="fa fa-user" aria-hidden="true"></i> <?php echo $this->lang->line('student'); ?> : <?php echo $notification['visible_student']; ?> </li>
                                                                    <li>

                                                                        <i class="fa fa-user" aria-hidden="true"></i>
                                                                        <?php echo $this->lang->line('parent'); ?> : <?php echo $notification['visible_parent']; ?>
                                                                    </li>
                                                                    <li>

                                                                        <i class="fa fa-user" aria-hidden="true"></i>
                                                                        <?php echo $this->lang->line('teacher'); ?> : <?php echo $notification['visible_teacher']; ?>
                                                                    </li>

                                                                </ul>
                                                            </div><!-- /.box-body -->
                                                        </div><!-- /. box -->

                                                    </div><!-- /.col -->
                                                </div><!-- /.row -->


                                            </div>
                                        </div>
                                    </div>

                                    <?php
                                }
                            }
                            ?>


                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>

            </div>

            <!-- right column -->
        </div>
</div>

</section><!-- /.content -->
</div><!-- /.content-wrapper -->





<script type="text/javascript">
    $(document).ready(function () {
        var date_format = '<?php echo $result = strtr($this->customlib->getSchoolDateFormat(), ['d' => 'dd', 'm' => 'mm', 'Y' => 'yyyy',]) ?>';
        $('.date').datepicker({
            // format: "dd-mm-yyyy",

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