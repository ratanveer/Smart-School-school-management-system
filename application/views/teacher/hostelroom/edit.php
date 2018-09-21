<?php
$currency_symbol = $this->customlib->getSchoolCurrencyFormat();
?>
<div class="content-wrapper">    
    <section class="content-header">
        <h1>
            <i class="fa fa-building-o"></i> <?php echo $this->lang->line('hostel'); ?> <small><?php echo $this->lang->line('student_fees1'); ?></small>
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-4">                
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?php echo $this->lang->line('edit_hostel_room'); ?></h3>
                    </div>
                    <form action="<?php echo site_url('teacher/hostelroom/edit/' . $id) ?>"  id="employeeform" name="employeeform" method="post" accept-charset="utf-8">
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
                            <input type="hidden" name="id" value="<?php echo set_value('id', $hostelroom['id']); ?>" >
                            <div class="form-group">
                                <label for="exampleInputEmail1"><?php echo $this->lang->line('no_of_bed'); ?></label>
                                <input autofocus="" id="amount" name="no_of_bed" placeholder="" type="text" class="form-control"  value="<?php echo set_value('no_of_bed', $hostelroom['no_of_bed']); ?>" />
                                <span class="text-danger"><?php echo form_error('no_of_bed'); ?></span>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1"><?php echo $this->lang->line('hostel'); ?></label>
                                <select  id="hostel_id" name="hostel_id" class="form-control" >
                                    <option value=""><?php echo $this->lang->line('select'); ?></option>
                                    <?php
                                    foreach ($hostellist as $hostel) {
                                        ?>
                                        <option value="<?php echo $hostel['id'] ?>"<?php
                                        if (set_value('hostel_id', $hostelroom['hostel_id']) == $hostel['id']) {
                                            echo "selected =selected";
                                        }
                                        ?>><?php echo $hostel['hostel_name'] ?></option>
                                                <?php
                                                $count++;
                                            }
                                            ?>
                                </select>
                                <span class="text-danger"><?php echo form_error('hostel_id'); ?></span>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1"><?php echo $this->lang->line('room_type'); ?></label>
                                <select  id="room_type_id" name="room_type_id" class="form-control" >
                                    <option value=""><?php echo $this->lang->line('select'); ?></option>
                                    <?php
                                    foreach ($roomtypelist as $roomtype) {
                                        ?>
                                        <option value="<?php echo $roomtype['id'] ?>"<?php
                                        if (set_value('room_type_id', $hostelroom['room_type_id']) == $roomtype['id']) {
                                            echo "selected =selected";
                                        }
                                        ?>><?php echo $roomtype['room_type'] ?></option>

                                        <?php
                                        $count++;
                                    }
                                    ?>
                                </select>
                                <span class="text-danger"><?php echo form_error('room_type_id'); ?></span>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1"><?php echo $this->lang->line('room_no_name'); ?></label>
                                <input id="amount" name="room_no" placeholder="" type="text" class="form-control"  value="<?php echo set_value('room_no', $hostelroom['room_no']); ?>" />
                                <span class="text-danger"><?php echo form_error('room_no'); ?></span>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1"><?php echo $this->lang->line('cost_per_bed'); ?></label>
                                <input id="amount" name="cost_per_bed" placeholder="" type="text" class="form-control"  value="<?php echo set_value('cost_per_bed', $hostelroom['cost_per_bed']); ?>" />
                                <span class="text-danger"><?php echo form_error('cost_per_bed'); ?></span>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1"><?php echo $this->lang->line('description'); ?></label>
                                <textarea class="form-control" id="description" name="description" placeholder="" rows="3" placeholder=""><?php echo set_value('description', $hostelroom['description']); ?></textarea>
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
                        <h3 class="box-title titlefix"><?php echo $this->lang->line('hostel_room_list'); ?></h3>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="mailbox-controls">                           
                            <div class="pull-right">
                            </div>
                        </div>
                        <div class="table-responsive mailbox-messages">
						<div class="download_label"><?php echo $this->lang->line('hostel_room_list'); ?></div>
                            <table class="table table-striped table-bordered table-hover example">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('room_no_name'); ?></th>
                                        <th><?php echo $this->lang->line('hostel'); ?></th>
                                        <th><?php echo $this->lang->line('room_type'); ?></th>
                                        <th><?php echo $this->lang->line('no_of_bed'); ?></th>
                                        <th><?php echo $this->lang->line('cost_per_bed'); ?></th>
                                        <th class="text-right"><?php echo $this->lang->line('action'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($hostelroomlist)) {
                                        ?>
                                        <tr>
                                            <td colspan="12" class="text-danger text-center"><?php echo $this->lang->line('no_record_found'); ?></td>
                                        </tr>
                                        <?php
                                    } else {
                                        $count = 1;
                                        foreach ($hostelroomlist as $hostelroom) {
                                            ?>
                                            <tr>
                                                <td class="mailbox-name">
                                                    <a href="#" data-toggle="popover" class="detail_popover" ><?php echo $hostelroom['room_no'] ?></a>
                                                    <div class="fee_detail_popover" style="display: none">
                                                        <?php
                                                        if ($hostelroom['description'] == "") {
                                                            ?>
                                                            <p class="text text-danger"><?php echo $this->lang->line('no_description'); ?></p>
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <p class="text text-info"><?php echo $hostelroom['description']; ?></p>
                                                            <?php
                                                        }
                                                        ?>
                                                    </div>
                                                </td>
                                                <td class="mailbox-name"> <?php echo $hostelroom['hostel_name'] ?></td>
                                                <td class="mailbox-name"> <?php echo $hostelroom['room_type'] ?></td>
                                                <td class="mailbox-name"> <?php echo $hostelroom['no_of_bed'] ?></td>
                                                <td class="mailbox-name"> <?php echo $currency_symbol . $hostelroom['cost_per_bed'] ?></td>
                                                <td class="mailbox-date pull-right">
                                                    <a href="<?php echo base_url(); ?>teacher/hostelroom/edit/<?php echo $hostelroom['id'] ?>" class="btn btn-default btn-xs"  data-toggle="tooltip" title="<?php echo $this->lang->line('edit'); ?>">
                                                        <i class="fa fa-pencil"></i>
                                                    </a>
                                                    <a href="<?php echo base_url(); ?>teacher/hostelroom/delete/<?php echo $hostelroom['id'] ?>"class="btn btn-default btn-xs"  data-toggle="tooltip" title="<?php echo $this->lang->line('delete'); ?>" onclick="return confirm('Are you sure you want to delete this item?');">
                                                        <i class="fa fa-remove"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <?php
                                        }
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