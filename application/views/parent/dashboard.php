<style type="text/css">
    @media print
    {
        .no-print, .no-print *
        {
            display: none !important;
        }
    }
</style>
<?php
$currency_symbol = $this->customlib->getSchoolCurrencyFormat();
?>
<div class="content-wrapper" style="min-height: 946px;">  
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> <?php echo $this->lang->line('my_children'); ?> <small><?php echo $this->lang->line('student1'); ?></small>        </h1>
    </section>
    <section class="content">
        <div class="row">
            <?php
            foreach ($student_list as $key => $student) {
                ?>
                <div class="col-md-3">     
                    <div class="box box-primary">
                        <div class="box-body box-profile">
                            <img class="profile-user-img img-responsive img-circle" src="<?php echo base_url() . $student['image'] ?>" alt="User profile picture">
                            <h3 class="profile-username text-center">
                                <a href="<?php echo site_url('parent/parents/getStudent/' . $student['id']); ?>"> <?php echo $student['firstname'] . " " . $student['lastname']; ?></a>
                            </h3>
                            <ul class="list-group list-group-unbordered">
                                <li class="list-group-item">
                                    <b><?php echo $this->lang->line('admission_no'); ?></b> <a class="pull-right text-aqua"><?php echo $student['admission_no']; ?></a>
                                </li>
                                <li class="list-group-item">
                                    <b><?php echo $this->lang->line('roll_no'); ?></b> <a class="pull-right text-aqua"><?php echo $student['roll_no']; ?></a>
                                </li>
                                <li class="list-group-item">
                                    <b><?php echo $this->lang->line('class'); ?></b> <a class="pull-right text-aqua"><?php echo $student['class']; ?></a>
                                </li>
                                <li class="list-group-item">
                                    <b><?php echo $this->lang->line('section'); ?></b> <a class="pull-right text-aqua"><?php echo $student['section']; ?></a>
                                </li>
                                <li class="list-group-item">
                                    <b><?php echo $this->lang->line('rte'); ?></b> <a class="pull-right text-aqua"><?php echo $student['rte']; ?></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </section>
</div>