<style type="text/css">
    .liststyle1 {
        margin: 0;
        list-style: none;
        line-height: 28px;
    }
</style>

<?php $currency_symbol = $this->customlib->getSchoolCurrencyFormat(); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <section class="content-header">
        <h1>
            <i class="fa fa-money"></i> <?php echo $this->lang->line('fees_collection'); ?></h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-4">
                <!-- Horizontal Form -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?php echo $this->lang->line('add_fees_master') . " : " . $this->setting_model->getCurrentSessionName(); ?></h3>
                    </div><!-- /.box-header -->
                    <form id="form1" action="<?php echo base_url() ?>admin/feemaster"  id="feemasterform" name="feemasterform" method="post" accept-charset="utf-8">
                        <div class="box-body">
                            <?php if ($this->session->flashdata('msg')) { ?>
                                <?php echo $this->session->flashdata('msg') ?>
                            <?php } ?>

                            <?php echo $this->customlib->getCSRF(); ?>
                            <div class="row">
                                <div class="col-md-12">

                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><?php echo $this->lang->line('fees_group'); ?></label>

                                        <select autofocus="" id="fee_groups_id" name="fee_groups_id" class="form-control" >
                                            <option value=""><?php echo $this->lang->line('select'); ?></option>
                                            <?php
                                            foreach ($feegroupList as $feegroup) {
                                                ?>
                                                <option value="<?php echo $feegroup['id'] ?>"<?php
                                                if (set_value('fee_groups_id') == $feegroup['id']) {
                                                    echo "selected =selected";
                                                }
                                                ?>><?php echo $feegroup['name'] ?></option>

                                                <?php
                                                $count++;
                                            }
                                            ?>
                                        </select>
                                        <span class="text-danger"><?php echo form_error('fee_groups_id'); ?></span>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><?php echo $this->lang->line('fees_type'); ?></label>

                                        <select  id="feetype_id" name="feetype_id" class="form-control" >
                                            <option value=""><?php echo $this->lang->line('select'); ?></option>
                                            <?php
                                            foreach ($feetypeList as $feetype) {
                                                ?>
                                                <option value="<?php echo $feetype['id'] ?>"<?php
                                                if (set_value('feetype_id') == $feetype['id']) {
                                                    echo "selected =selected";
                                                }
                                                ?>><?php echo $feetype['type'] ?></option>

                                                <?php
                                                $count++;
                                            }
                                            ?>
                                        </select>
                                        <span class="text-danger"><?php echo form_error('feetype_id'); ?></span>
                                    </div>


                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><?php echo $this->lang->line('due_date'); ?></label>
                                        <input id="due_date" name="due_date" placeholder="" type="text" class="form-control"  value="<?php echo set_value('due_date'); ?>" readonly="readonly"/>
                                        <span class="text-danger"><?php echo form_error('due_date'); ?></span>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><?php echo $this->lang->line('amount'); ?></label>
                                        <input id="amount" name="amount" placeholder="" type="text" class="form-control"  value="<?php echo set_value('amount'); ?>" />
                                        <span class="text-danger"><?php echo form_error('amount'); ?></span>
                                    </div>

                                </div>
                                <div class="col-md-6">

                                </div>
                            </div>

                        </div><!-- /.box-body -->

                        <div class="box-footer">

                            <button type="submit" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>
                        </div>
                    </form>
                </div>

            </div><!--/.col (right) -->
            <!-- left column -->

            <div class="col-md-8">
                <!-- Horizontal Form -->
                <div class="box box-primary">
                    <div class="box-header ptbnull">
                        <h3 class="box-title titlefix"><?php echo $this->lang->line('fees_master_list') . " : " . $this->setting_model->getCurrentSessionName(); ?></h3>

                    </div><!-- /.box-header -->

                    <div class="box-body">
                        <div class="download_label"><?php echo $this->lang->line('fees_master_list') . " : " . $this->setting_model->getCurrentSessionName(); ?></div>
                        <div class="table-responsive mailbox-messages">
                            <table class="table table-striped table-bordered table-hover example">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('fees_group'); ?></th>
                                        <th><?php echo $this->lang->line('fees_code'); ?></th>

                                        <th class="text-right"><?php echo $this->lang->line('action'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($feemasterList as $feegroup) {
                                        ?>
                                        <tr>
                                            <td class="mailbox-name">
                                                <a href="#" data-toggle="popover" class="detail_popover"><?php echo $feegroup->group_name; ?></a>


                                            </td>


                                            <td class="mailbox-name">
                                                <ul class="liststyle1">
                                                    <?php
                                                    foreach ($feegroup->feetypes as $feetype_key => $feetype_value) {
                                                        ?>
                                                        <li> <i class="fa fa-money"></i>  
                                                            <?php echo $feetype_value->code . " " . $currency_symbol . $feetype_value->amount; ?> &nbsp;&nbsp;
                                                            <a href="<?php echo base_url(); ?>admin/feemaster/edit/<?php echo $feetype_value->id ?>"   data-toggle="tooltip" title="<?php echo $this->lang->line('edit'); ?>">
                                                                <i class="fa fa-pencil"></i>
                                                            </a>&nbsp;
                                                            <a href="<?php echo base_url(); ?>admin/feemaster/delete/<?php echo $feetype_value->id ?>" data-toggle="tooltip" title="<?php echo $this->lang->line('delete'); ?>" onclick="return confirm('Are you sure you want to delete this item?');">
                                                                <i class="fa fa-remove"></i>
                                                            </a>

                                                        </li>

                                                        <?php
                                                    }
                                                    ?>
                                                </ul>
                                            </td>

                                            <td class="mailbox-date pull-right">
                                                <a href="<?php echo base_url(); ?>admin/feemaster/assign/<?php echo $feegroup->id ?>" 
                                                   class="btn btn-default btn-xs" data-toggle="tooltip" title="<?php echo $this->lang->line('assign / view'); ?>">
                                                    <i class="fa fa-tag"></i>
                                                </a>
                                                <a href="<?php echo base_url(); ?>admin/feemaster/deletegrp/<?php echo $feegroup->id ?>" class="btn btn-default btn-xs"  data-toggle="tooltip" title="<?php echo $this->lang->line('delete'); ?>" onclick="return confirm('Are you sure you want to delete this item?');">
                                                    <i class="fa fa-remove"></i>
                                                </a>

                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>

                                </tbody>
                            </table><!-- /.table -->
                        </div><!-- /.mail-box-messages -->
                    </div><!-- /.box-body -->


                    </form>
                </div>

            </div><!--/.col (right) -->
            <!-- left column -->


        </div>
        <div class="row">
            <!-- left column -->

            <!-- right column -->
            <div class="col-md-12">

            </div><!--/.col (right) -->
        </div>   <!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<script type="text/javascript">
    $(document).ready(function () {
        var date_format = '<?php echo $result = strtr($this->customlib->getSchoolDateFormat(), ['d' => 'dd', 'm' => 'mm', 'Y' => 'yyyy',]) ?>';

        $('#date').datepicker({
            //  format: "dd-mm-yyyy",
            format: date_format,
            autoclose: true
        });

        $("#btnreset").click(function () {
            $("#form1")[0].reset();
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

        var date_format = '<?php echo $result = strtr($this->customlib->getSchoolDateFormat(), ['d' => 'dd', 'm' => 'mm', 'Y' => 'yyyy',]) ?>';
        $('#due_date').datepicker({
            format: date_format,
            autoclose: true
        });
    });


</script>