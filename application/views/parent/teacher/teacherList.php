<div class="content-wrapper" style="min-height: 946px;">
    <section class="content-header">
        <h1>
            <i class="fa fa-user-secret"></i> <?php echo $this->lang->line('teachers'); ?></h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary" id="tachelist">
                    <div class="box-body">
                        <div class="table-responsive mailbox-messages">
						<div class="download_label"><?php echo $this->lang->line('teachers'); ?></div>
                            <table class="table table-striped table-bordered table-hover example">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('teacher_name'); ?></th>
                                        <th><?php echo $this->lang->line('email'); ?></th>
                                        <th><?php echo $this->lang->line('date_of_birth'); ?></th>
                                        <th class="text text-right"><?php echo $this->lang->line('phone'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($teacherlist)) {
                                        ?>
                                        <tr>
                                            <td colspan="12" class="text-danger text-center"><?php echo $this->lang->line('no_record_found'); ?></td>
                                        </tr>
                                        <?php
                                    } else {
                                        $count = 1;
                                        foreach ($teacherlist as $teacher) {
                                            ?>
                                            <tr>
                                                <td class="mailbox-name"> <?php echo $teacher['name'] ?></td>
                                                <td class="mailbox-name"> <?php echo $teacher['email'] ?></td>
                                                <td class="mailbox-name"> <?php echo date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($teacher['dob'])); ?></td>
                                                <td class="text text-right"> <?php echo $teacher['phone'] ?></td>
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
                    <div class="box-footer">
                        <div class="mailbox-controls"> 
                        </div>
                    </div>
                </div>
            </div>
        </div>  
    </section>
</div>