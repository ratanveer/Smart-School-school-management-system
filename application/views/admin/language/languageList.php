<div class="content-wrapper" style="min-height: 946px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-gears"></i> <?php echo $this->lang->line('system_settings'); ?><small><?php echo $this->lang->line('setting1'); ?></small>        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-language"></i> <?php echo $this->lang->line('language_list'); ?></h3>

                        <div class="box-tools pull-right">
                            <div class="box-tools pull-right">
                                <a href="<?php echo base_url(); ?>admin/language/create" class="btn btn-primary btn-sm"  data-toggle="tooltip" title="<?php echo $this->lang->line('add'); ?>" >
                                    <i class="fa fa-plus"></i> <?php echo $this->lang->line('add'); ?>
                                </a>
                            </div>
                        </div><!-- /.box-tools -->
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="alert alert-warning">
                            For languages other than English please install language pack first, present in your download package
                        </div>
                        <?php if ($this->session->flashdata('msg')) { ?>
                            <?php echo $this->session->flashdata('msg') ?>
                        <?php } ?>
                        <div class="table-responsive mailbox-messages">
                            <table class="table table-hover table-striped">
                                <tbody>
                                    <tr>
                                        <th>#</th>
                                        <th><?php echo $this->lang->line('language'); ?></th>
                                        <th><?php echo $this->lang->line('status'); ?></th>
                                        <th class="text-right"><?php echo $this->lang->line('action'); ?></th>
                                    </tr>
                                    <?php
                                    $count = 1;
                                    foreach ($languagelist as $language) {
                                        ?>
                                        <tr>
                                            <td><?php echo $count . "."; ?></td>
                                            <td class="mailbox-name"> <?php echo $language['language'] ?></td>
                                            <td class="mailbox-name"><?php
                                                if ($this->customlib->getSessionLanguage() == $language['id']) {
                                                    ?>
                                                    <span class="label bg-green"><?php echo $this->lang->line('active'); ?></span>
                                                    <?php
                                                } else {
                                                    
                                                }
                                                ?></td>
                                            <td class="mailbox-date text-right">
                                                <a href="<?php echo base_url(); ?>admin/language/addPharses/<?php echo $language['id'] ?>" class="btn btn-default btn-xs"  data-toggle="tooltip" title="<?php echo $this->lang->line('add/edit'); ?>" >
                                                    <i class="fa fa-plus"> <?php echo form_error('edit_pharses'); ?> </i>
                                                </a>
                                                <?php
                                                if ($language['is_deleted'] == "yes") {
                                                    ?>
                                                    <a href="<?php echo base_url(); ?>admin/language/delete/<?php echo $language['id'] ?>" class="btn btn-default btn-xs"  data-toggle="tooltip" title="<?php echo $this->lang->line('delete'); ?>"   onclick="return confirm('Are you sure you want to delete this item?');">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                    <?php
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                        <?php
                                        $count++;
                                    }
                                    ?>

                                </tbody>
                            </table><!-- /.table -->
                        </div><!-- /.mail-box-messages -->
                    </div><!-- /.box-body -->
                    <div class="box-footer">
                        <div class="mailbox-controls">
                        </div>
                    </div>
                </div>
            </div>
        </div>   <!-- /.row -->
    </section><!-- /.content -->
</div>