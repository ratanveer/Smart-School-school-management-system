<div class="content-wrapper" style="min-height: 946px;">    
    <section class="content-header">
        <h1>
            <i class="glyphicon glyphicon-th"></i> <?php echo $this->lang->line('manage'); ?> <small><?php echo $this->lang->line('fee_type'); ?></small>        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?php echo $title; ?></h3>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <div class="box-body no-padding">
                        <div class="mailbox-controls">
                            <a href="<?php echo base_url(); ?>teacher/classes/create" class="btn btn-primary btn-sm"  data-toggle="tooltip" title="Add Class">
                                <i class="fa fa-plus"></i> <?php echo $this->lang->line('add_class'); ?>
                            </a>
                            <div class="pull-right">
                            </div>
                        </div>
                        <div class="table-responsive mailbox-messages">
                            <table class="table table-hover table-striped">
                                <tbody>
                                    <tr>
                                        <td><?php echo $this->lang->line('class'); ?></td>
                                        <td class="mailbox-name"><a href="<?php echo base_url(); ?>classes/view/<?php echo $class['id'] ?>"> <?php echo $class['class'] ?></a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="mailbox-controls">   
                            <div class="pull-right">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>