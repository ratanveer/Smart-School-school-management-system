<div class="content-wrapper" style="min-height: 946px;">
    <section class="content-header">
        <h1>
            <?php echo $this->lang->line('general_form_elements'); ?>
            <small><?php echo $this->lang->line('preview'); ?></small>
        </h1>       
    </section>   
    <section class="content">
        <div class="row"> 
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?php echo $title; ?></h3>
                        <div class="box-tools pull-right">
                            <div class="has-feedback">
                                <input type="text" class="form-control input-sm" placeholder="Search Mail">
                                <span class="glyphicon glyphicon-search form-control-feedback"></span>
                            </div>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="mailbox-controls">                           
                            <a href="<?php echo base_url(); ?>teacher/classes/create" class="btn btn-primary btn-sm checkbox-toggle addcourse" data-toggle="tooltip" title="<?php echo $this->lang->line('add_class'); ?>" ><i class="fa fa-plus"></i> <?php echo $this->lang->line('add_class'); ?></a>
                            <div class="pull-right">
                                1-50/200
                                <div class="btn-group">
                                    <button class="btn btn-default btn-sm"><i class="fa fa-chevron-left"></i></button>
                                    <button class="btn btn-default btn-sm"><i class="fa fa-chevron-right"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive mailbox-messages">
                            <table class="table table-hover table-striped">
                                <tbody>
                                    <?php
                                    $count = 1;
                                    foreach ($classlist as $class) {
                                        ?>
                                        <tr>
                                            <td><?php echo $count . "."; ?></td>
                                            <td class="mailbox-name"><a href="<?php echo base_url(); ?>teacher/classs/view/<?php echo $class['id'] ?>"> <?php echo $class['class'] ?></a></td>
                                            <td class="mailbox-date">
                                                <a href="<?php echo base_url(); ?>teacher/classes/view/<?php echo $class['id'] ?>" class="btn btn-info btn-xs"  data-toggle="tooltip" title="<?php echo $this->lang->line('show'); ?>" >
                                                    <i class="fa fa-reorder"></i>
                                                </a>
                                                <a href="<?php echo base_url(); ?>teacher/classes/edit/<?php echo $class['id'] ?>" class="btn btn-default btn-xs"  data-toggle="tooltip" title="<?php echo $this->lang->line('edit'); ?>">
                                                    <i class="fa fa-pencil"></i>
                                                </a>
                                                <a href="<?php echo base_url(); ?>teacher/classes/addsection/<?php echo $class['id'] ?>"class="btn btn-default btn-xs"  data-toggle="tooltip" title="<?php echo $this->lang->line('add_section'); ?>">
                                                    <i class="fa fa-plus"></i>
                                                </a>
                                                <a href="<?php echo base_url(); ?>teacher/classes/delete/<?php echo $class['id'] ?>"class="btn btn-default btn-xs"  data-toggle="tooltip" title="<?php echo $this->lang->line('delete'); ?>" onclick="return confirm('Are you sure you want to delete this item?');">
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
                    <div class="box-footer">
                        <div class="mailbox-controls">
                            <div class="pull-right">
                                1-50/200
                                <div class="btn-group">
                                    <button class="btn btn-default btn-sm"><i class="fa fa-chevron-left"></i></button>
                                    <button class="btn btn-default btn-sm"><i class="fa fa-chevron-right"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>