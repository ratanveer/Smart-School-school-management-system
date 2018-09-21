<div class="content-wrapper" style="min-height: 946px;">
    <section class="content-header">
        <h1>
            <i class="fa fa-gears"></i> <?php echo $this->lang->line('system_settings'); ?>
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-8">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-database"></i> <?php echo $this->lang->line('backup_history'); ?></h3>
                        <div class="box-tools pull-right">
                            <form id="form1" action="<?php echo site_url('admin/admin/backup') ?>"  id="employeeform" name="employeeform" method="post" accept-charset="utf-8" role="form">
                                <?php echo $this->customlib->getCSRF(); ?>
                                <button class="btn btn-primary btn-sm btn-info" type="submit" name="backup" value="backup"><i class="fa fa-plus-square-o"></i>   <?php echo $this->lang->line('create_backup'); ?></button>
                            </form>
                        </div>
                    </div>
                    <div class="box-body">


                        <?php if ($this->session->flashdata('msg')) { ?>
                            <?php echo $this->session->flashdata('msg') ?>
                        <?php } ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive mailbox-messages">
                                    <table class="table table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th><?php echo $this->lang->line('backup_files'); ?></th>
                                                <th class="text-left" colspan="4">
                                                    <?php echo $this->lang->line('action'); ?>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $count = 1;
                                            foreach ($dbfileList as $data) {
                                                ?>
                                                <tr>
                                                    <td width="80%" class="mailbox-name"><a href="#"> <?php echo $data; ?></a></td>
                                                    <td class="mailbox-name">
                                                        <a href="<?php echo site_url('admin/admin/downloadbackup/' . $data) ?>" class="btn btn-success btn-xs" ><i class="fa fa-download"></i> <?php echo $this->lang->line('download'); ?></a>
                                                    </td>
                                                    <td class="mailbox-name">
                                                        <form class="formrestore" action="<?php echo site_url('admin/admin/backup') ?>"  id="employeeform" name="employeeform" method="post" accept-charset="utf-8" role="form">
                                                            <?php echo $this->customlib->getCSRF(); ?>
                                                            <input type="hidden" name="filename" value="<?php echo $data; ?>">
                                                            <button class="btn btn-primary btn-xs btn-warning" type="submit" name="backup" value="restore"><i class="fa fa-plus-square-o"></i>  <?php echo $this->lang->line('restore'); ?> </button>
                                                        </form></td>
                                                    <td class="mailbox-name">
                                                        <form class="formdelete" method="post" role="form" name="employeeform" id="employeeform" accept-charset="utf-8"  action="<?php echo site_url('admin/admin/dropbackup/' . $data); ?>" >
                                                        <?php echo $this->customlib->getCSRF(); ?>
                                                        <button class="btn btn-primary btn-xs btn-danger" type="submit" name="backup" value="restore"><i class="fa fa-trash"></i>  <?php echo $this->lang->line('delete'); ?></button>
                                                        </form></td>
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
                    </div></div></div>
            <div class="col-md-4">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title pull-left"><?php echo $this->lang->line('upload_from_local_directory'); ?></h3>
                    </div>
                    <form role="form" action="<?php echo site_url('admin/admin/backup') ?>" method="post" enctype="multipart/form-data">
                        <?php echo $this->customlib->getCSRF(); ?>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="exampleInputFile"></label>
                                <input class="filestyle form-control"  type="file" name="file" id="exampleInputFile" >
                            </div>
                            <span class="text-danger"><?php echo form_error('file'); ?></span>
                        </div> 
                        <div class="box-footer">
                            <button class="btn btn-primary btn-sm pull-right" type="submit" name="backup" value="upload"><i class="fa fa-upload"></i> <?php echo $this->lang->line('upload'); ?></button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
</div>
</div>
</div>
</div>
</div>
<script type="text/javascript">
    $('#form1').submit(function () {
        var c = confirm("Are you sure want to make current backup?");
        return c;
    });
    $('.formdelete').submit(function () {
        var c = confirm("Are you sure want to delete backup?");
        return c;
    });
    $('.formrestore').submit(function () {
        var c = confirm("Are you sure want to restore backup?");
        return c;
    });
</script>