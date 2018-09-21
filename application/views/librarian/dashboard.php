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
                        <img class="profile-user-img img-responsive img-circle" src="<?php echo base_url() . $librarian['image'] ?>" alt="User profile picture">
                        <h3 class="profile-username text-center"><?php echo $librarian['name'] ?></h3> 
                        <ul class="list-group list-group-unbordered">
                            <li class="list-group-item">
                                <b><?php echo $this->lang->line('gender'); ?></b> <a class="pull-right text-aqua"><?php echo $librarian['sex'] ?></a>
                            </li>
                            <li class="list-group-item">
                                <b><?php echo $this->lang->line('date_of_birth'); ?></b> <a class="pull-right text-aqua">                    
                                    <?php echo date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($librarian['dob'])); ?>
                                </a>
                            </li>
                            <li class="list-group-item">
                                <b><?php echo $this->lang->line('phone'); ?></b> <a class="pull-right text-aqua"><?php echo $librarian['phone'] ?></a>
                            </li> 
                            <li class="list-group-item">
                                <b><?php echo $this->lang->line('email'); ?></b> <a class="pull-right text-aqua"><?php echo $librarian['email'] ?></a>
                            </li>
                            <li class="list-group-item">
                                <b><?php echo $this->lang->line('address'); ?></b> <a class="pull-right text-aqua"><?php echo $librarian['address'] ?></a>
                            </li>                    
                        </ul> 
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>