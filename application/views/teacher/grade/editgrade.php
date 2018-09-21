<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-map-o"></i> <?php echo $this->lang->line('examinations'); ?> <small><?php echo $this->lang->line('student_fee1'); ?></small>  </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-4">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?php echo $this->lang->line('edit_grade'); ?></h3>
                    </div>
                    <form action="<?php echo site_url('teacher/grade/edit/' . $id) ?>"  id="employeeform" name="employeeform" method="post" accept-charset="utf-8">
                        <div class="box-body">
                            <?php if ($this->session->flashdata('msg')) { ?>
                                <?php echo $this->session->flashdata('msg') ?>
                            <?php } ?>
                            <?php
                            if (isset($error_message)) {
                                echo "<div class='alert alert-danger'>" . $error_message . "</div>";
                            }
                            ?>  
                            <?php echo $this->customlib->getCSRF(); ?>
                            <input type="hidden" name="id" value="<?php echo set_value('id', $editgrade['id']); ?>" >
                            <div class="form-group">
                                <label for="exampleInputEmail1"><?php echo $this->lang->line('grade_name'); ?></label>
                                <input autofocus="" id="name" name="name" type="text" class="form-control"  value="<?php echo set_value('name', $editgrade['name']); ?>" />
                                <span class="text-danger"><?php echo form_error('name'); ?></span>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1"><?php echo $this->lang->line('percent_from'); ?></label>
                                <input id="mark_from" name="mark_from"  type="text" class="form-control"  value="<?php echo set_value('mark_from', $editgrade['mark_from']); ?>" />
                                <span class="text-danger"><?php echo form_error('mark_from'); ?></span>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1"><?php echo $this->lang->line('percent_upto'); ?></label>
                                <input id="mark_upto" name="mark_upto"  type="text" class="form-control"  value="<?php echo set_value('mark_upto', $editgrade['mark_upto']); ?>" />
                                <span class="text-danger"><?php echo form_error('mark_upto'); ?></span>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1"><?php echo $this->lang->line('description'); ?></label>
                                <textarea class="form-control" id="description" name="description" rows="3" ><?php echo set_value('description', $editgrade['description']); ?></textarea>
                                <span class="text-danger"><?php echo form_error('description'); ?></span>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>
                        </div>
                    </form>
                </div>
            </div>          
            <div class="col-md-8">                
                <div class="box box-primary">
                    <div class="box-header ptbnull">
                        <h3 class="box-title titlefix"><?php echo $this->lang->line('grade_list'); ?></h3>
                        <div class="box-tools pull-right">

                        </div>
                    </div>
                    <div class="box-body">
                        <div class="mailbox-controls">
                            <div class="pull-right">
                            </div>
                        </div>
                        <div class="table-responsive mailbox-messages">
						<div class="download_label"><?php echo $this->lang->line('grade_list'); ?></div>
                            <table class="table table-striped table-bordered table-hover example">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('grade_name'); ?>
                                        </th>
                                        <th><?php echo $this->lang->line('percent_from'); ?></th>
                                        <th><?php echo $this->lang->line('percent_upto'); ?></th>
                                        <th class="text-right"><?php echo $this->lang->line('action'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $count = 1;
                                    foreach ($listgrade as $grade) {
                                        ?>
                                        <tr>
                                            <td class="mailbox-name">
                                                <a href="#" data-toggle="popover" class="detail_popover" ><?php echo $grade['name'] ?></a>
                                                <div class="fee_detail_popover" style="display: none">
                                                    <?php
                                                    if ($grade['description'] == "") {
                                                        ?>
                                                        <p class="text text-danger"><?php echo $this->lang->line('no_description'); ?></p>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <p class="text text-info"><?php echo $grade['description']; ?></p>
                                                        <?php
                                                    }
                                                    ?>
                                                </div>
                                            </td>
                                            <td class="mailbox-name"> <?php echo $grade['mark_from'] ?></td>
                                            <td class="mailbox-name"> <?php echo $grade['mark_upto'] ?></td>
                                            <td class="mailbox-date pull-right">
                                                <a href="<?php echo base_url(); ?>teacher/grade/edit/<?php echo $grade['id'] ?>" class="btn btn-default btn-xs"  data-toggle="tooltip" title="<?php echo $this->lang->line('edit'); ?>">
                                                    <i class="fa fa-pencil"></i>
                                                </a>
                                                <a href="<?php echo base_url(); ?>teacher/grade/delete/<?php echo $grade['id'] ?>"class="btn btn-default btn-xs"  data-toggle="tooltip" title="<?php echo $this->lang->line('delete'); ?>" onclick="return confirm('Are you sure you want to delete this item?');">
                                                    <i class="fa fa-remove"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php
                                        $count++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
        <div class="row">           
            <div class="col-md-12">
            </div>
        </div>
    </section>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('#postdate').datepicker({
            format: "dd-mm-yyyy",
            autoclose: true
        });
    });
</script>
<script>
    $(document).ready(function () {
        $('.detail_popover').popover({
            placement: 'right',
            trigger: 'hover',
            container: 'body',
            html: true,
            content: function () {
                return $(this).closest('td').find('.fee_detail_popover').html();
            }
        });
    });
</script>