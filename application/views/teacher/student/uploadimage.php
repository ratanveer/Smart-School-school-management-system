<div class="content-wrapper"> 
    <section class="content-header">
        <h1>
            <i class="glyphicon glyphicon-th"></i> <?php echo $this->lang->line('manage'); ?> <small><?php echo $this->lang->line('school_logo'); ?></small>        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">             
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?php echo $this->lang->line('add_image'); ?></h3>
                        <div class="pull-right box-tools">
                        </div>
                    </div>  
                    <form action="<?php echo site_url('teacher/student/doupload/' . $id) ?>"  id="employeeform" name="employeeform" method="post" accept-charset="utf-8"  enctype="multipart/form-data" >
                        <div class="box-body">
                            <?php echo $this->customlib->getCSRF(); ?>
                            <?php echo validation_errors(); ?>
                            <div class="form-group">
                                <label for="exampleInputFile"><?php echo $this->lang->line('select_logo'); ?></label>
                                <input type='file' name='userfile' size='20' />
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="button" class="btn btn-default"><?php echo $this->lang->line('cancel'); ?></button>
                            <button type="submit" class="btn btn-info pull-right"><?php echo $this->lang->line('import'); ?></button>
                        </div>
                    </form>
                </div>  
            </div>
        </div>
    </section>
</div>