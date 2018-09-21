

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-gears"></i> <?php echo $this->lang->line('system_settings'); ?>
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- left column -->
                <form id="form1" action="<?php echo site_url('admin/notification/setting') ?>"  id="employeeform" name="employeeform" method="post" accept-charset="utf-8">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-commenting-o"></i> <?php echo $this->lang->line('notification_setting'); ?></h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <?php
                            $last_key = count($notificationMethods);
                            $i = 1;
                            foreach ($notificationMethods as $note_key => $note_value) {
                                $mail_checked = "";
                                $sms_checked = "";
                                $post_back = checkExists($notificationlist, $note_key);
                                if ($post_back) {
                                    $mail_checked = ($post_back['is_mail']) ? "checked=checked" : "";
                                    $sms_checked = ($post_back['is_sms']) ? "checked=checked" : "";
                                }

                                $hr = "";

                                if ($i != $last_key) {
                                    $hr = "<hr>";
                                }
                                ?>

                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="hidden" name="key_array[]" value="<?php echo $note_key ?>">
                                        <label class="control-label col-lg-2">
                                            <?php echo $note_value; ?>
                                            </label>

                                        <div class="col-lg-10">
                                            <label class="checkbox-inline">
                                                <input type="checkbox" name="<?php echo $note_key ?>_mail" value="1" <?php echo $mail_checked; ?>> <?php echo $this->lang->line('email'); ?>
                                            </label>
                                            <label class="checkbox-inline">
                                                <input type="checkbox" name="<?php echo $note_key ?>_sms" value="1" <?php echo $sms_checked; ?>> <?php echo $this->lang->line('sms'); ?>
                                            </label>

                                        </div>
                                    </div>
                                </div>

                                <?php
                                echo $hr;
                                $i++;
                            }
                            ?>
                        </div>  
                        <div class="box-footer">
                            <button type="submit" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>
                        </div>   
                </form>                 
            </div>

        </div>
</div><!--./wrapper-->

</section><!-- /.content -->
</div>

<?php

function checkExists($notificationlist, $key) {

    foreach ($notificationlist as $not_key => $not_value) {
        if ($not_value->type == $key) {
            return array(
                'is_mail' => $not_value->is_mail,
                'is_sms' => $not_value->is_sms
            );
        }
    }
    return false;
}
?>