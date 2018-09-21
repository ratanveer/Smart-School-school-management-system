<div class="content-wrapper" style="min-height: 946px;">   
    <section class="content-header">
        <h1>
            <i class="fa fa-user-secret"></i>  <?php echo $this->lang->line('profile'); ?>
        </h1>
    </section>  
    <section class="content">
        <div class="row">         
            <div class="col-md-4">
                <div class="box box-primary">
                    <div class="box-body box-profile">                 
                        <img class="profile-user-img img-responsive img-circle" src="<?php echo base_url() . $teacher['image'] ?>" alt="User profile picture">
                        <h3 class="profile-username text-center"><?php echo $teacher['name'] ?></h3> 
                        <ul class="list-group list-group-unbordered">
                            <li class="list-group-item">
                                <b><?php echo $this->lang->line('gender'); ?></b> <a class="pull-right text-aqua"><?php echo $teacher['sex'] ?></a>
                            </li>
                            <li class="list-group-item">
                                <b><?php echo $this->lang->line('date_of_birth'); ?></b> <a class="pull-right text-aqua">                    
                                    <?php echo date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($teacher['dob'])); ?>
                                </a>
                            </li>
                            <li class="list-group-item">
                                <b><?php echo $this->lang->line('phone'); ?></b> <a class="pull-right text-aqua"><?php echo $teacher['phone'] ?></a>
                            </li> 
                            <li class="list-group-item">
                                <b><?php echo $this->lang->line('email'); ?></b> <a class="pull-right text-aqua"><?php echo $teacher['email'] ?></a>
                            </li>
                            <li class="list-group-item">
                                <b><?php echo $this->lang->line('address'); ?></b> <a class="pull-right text-aqua"><?php echo $teacher['address'] ?></a>
                            </li>                    
                        </ul> 
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="box box-primary">
                    <div class="box-header ptbnull">
                        <h3 class="box-title titlefix"><?php echo $this->lang->line('subjects'); ?></h3>
                    </div>
                    <div class="box-body">
                        <div class="mailbox-controls"> 
                        </div>
                        <div class="table-responsive mailbox-messages"> 
						<div class="download_label"><?php echo $this->lang->line('subject_list'); ?></div>
                            <table class="table table-hover table-striped example">                           
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('class'); ?></th>                                        
                                        <th class="text-right"><?php echo $this->lang->line('subject'); ?></th>
                                    </tr>
                                </thead>                            
                                <tbody>
                                    <?php
                                    if (empty($teachersubject)) {
                                        ?>

                                        <?php
                                    } else {
                                        $count = 1;
                                        foreach ($teachersubject as $subject) {
                                            ?>

                                            <tr>
                                                <td class="mailbox-name"><?php echo $subject->class . " (" . $subject->section . ")" ?></td>
                                                <td class="mailbox-name pull-right"> <?php echo $subject->name; ?></td>

                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>          
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>