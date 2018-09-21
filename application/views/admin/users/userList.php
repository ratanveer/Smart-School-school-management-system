<style type="text/css">
    .material-switch > input[type="checkbox"] {
        display: none;   
    }

    .material-switch > label {
        cursor: pointer;
        height: 0px;
        position: relative; 
        width: 40px;  
    }

    .material-switch > label::before {
        background: rgb(0, 0, 0);
        box-shadow: inset 0px 0px 10px rgba(0, 0, 0, 0.5);
        border-radius: 8px;
        content: '';
        height: 16px;
        margin-top: -8px;
        position:absolute;
        opacity: 0.3;
        transition: all 0.4s ease-in-out;
        width: 40px;
    }
    .material-switch > label::after {
        background: rgb(255, 255, 255);
        border-radius: 16px;
        box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
        content: '';
        height: 24px;
        left: -4px;
        margin-top: -8px;
        position: absolute;
        top: -4px;
        transition: all 0.3s ease-in-out;
        width: 24px;
    }
    .material-switch > input[type="checkbox"]:checked + label::before {
        background: inherit;
        opacity: 0.5;
    }
    .material-switch > input[type="checkbox"]:checked + label::after {
        background: inherit;
        left: 20px;
    }
</style>

<div class="content-wrapper" style="min-height: 946px;">  
    <section class="content-header">
        <h1>
            <i class="fa fa-gears"></i> <?php echo $this->lang->line('system_settings'); ?>
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">        

            <div class="col-md-12">            
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs pull-right">
                        <li><a href="#tab_librarian" data-toggle="tab">Librarians</a></li>
                        <li><a href="#tab_accountant" data-toggle="tab">Accountants</a></li>
                        <li><a href="#tab_teacher" data-toggle="tab">Teachers</a></li>
                        <li><a href="#tab_parent" data-toggle="tab">Parents</a></li>                        
                        <li class="active"><a href="#tab_students" data-toggle="tab">Students</a></li>

                        <li class="pull-left header"><i class="fa fa-users"></i> <?php echo $this->lang->line('users'); ?></li>
                    </ul>
                    <div class="tab-content">

                        <div class="tab-pane active table-responsive" id="tab_students">
						<div class="download_label"><?php echo $this->lang->line('users'); ?></div>
                            <table class="table table-striped table-bordered table-hover example" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('admission_no'); ?></th>
                                        <th><?php echo $this->lang->line('student_name'); ?></th>
                                        <th><?php echo $this->lang->line('class'); ?></th>
                                        <th><?php echo $this->lang->line('father_name'); ?></th>
                                        <th><?php echo $this->lang->line('date_of_birth'); ?></th>
                                        <th><?php echo $this->lang->line('gender'); ?></th>
                                        <th><?php echo $this->lang->line('category'); ?></th>
                                        <th><?php echo $this->lang->line('mobile_no'); ?></th>

                                        <th class="text-right"><?php echo $this->lang->line('action'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($studentList)) {
                                        $count = 1;
                                        foreach ($studentList as $student) {
                                            ?>
                                            <tr>
                                                <td><?php echo $student['admission_no']; ?></td>
                                                <td>
                                                    <a href="<?php echo base_url(); ?>student/view/<?php echo $student['id']; ?>"><?php echo $student['firstname'] . " " . $student['lastname']; ?>
                                                    </a>
                                                </td>
                                                <td><?php echo $student['class'] . "(" . $student['section'] . ")" ?></td>
                                                <td><?php echo $student['father_name']; ?></td>
                                                <td><?php echo date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($student['dob'])); ?></td>
                                                <td><?php echo $student['gender']; ?></td>
                                                <td><?php echo $student['category']; ?></td>
                                                <td><?php echo $student['mobileno']; ?></td>

                                                <td class="pull-right">
                                                    <div class="material-switch pull-right">

                                                        <input id="student<?php echo $student['user_tbl_id'] ?>" name="someSwitchOption001" type="checkbox" class="chk" data-rowid="<?php echo $student['user_tbl_id'] ?>" value="checked" <?php if ($student['user_tbl_active'] == "yes") echo "checked='checked'"; ?> />
                                                        <label for="student<?php echo $student['user_tbl_id'] ?>" class="label-success"></label>
                                                    </div>

                                                </td>
                                            </tr>
                                            <?php
                                            $count++;
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane table-responsive" id="tab_parent">
						<div class="download_label"><?php echo $this->lang->line('users'); ?></div>
                            <table class="table table-striped table-bordered table-hover example" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('guardian_name'); ?></th>
                                        <th><?php echo $this->lang->line('guardian_phone'); ?></th>
                                        <th><?php echo $this->lang->line('guardian_address'); ?></th>


                                        <th class="text-right"><?php echo $this->lang->line('action'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($parentList)) {
                                        $count = 1;
                                        foreach ($parentList as $parent) {
                                            if (!empty($parent->siblings)) {
                                                $sibling = $parent->siblings;
                                                ?>
                                                <tr>
                                                    <td><?php echo $sibling[0]['guardian_name']; ?></td>
                                                    <td><?php echo $sibling[0]['guardian_phone']; ?></td>
                                                    <td><?php echo $sibling[0]['guardian_address']; ?></td>


                                                    <td class="pull-right">
                                                        <div class="material-switch pull-right">

                                                            <input id="parent<?php echo $parent->id ?>" name="someSwitchOption001" type="checkbox" class="chk" data-rowid="<?php echo $parent->id ?>" value="checked" <?php if ($parent->is_active == "yes") echo "checked='checked'"; ?> />
                                                            <label for="parent<?php echo $parent->id ?>" class="label-success"></label>
                                                        </div>

                                                    </td>
                                                </tr>
                                                <?php
                                            }


                                            $count++;
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane table-responsive" id="tab_teacher">
						<div class="download_label"><?php echo $this->lang->line('users'); ?></div>
                            <table class="table table-striped table-bordered table-hover example" cellspacing="0" width="100%">
                                <thead>
                                    <tr>

                                        <th><?php echo $this->lang->line('teacher_name'); ?></th>
                                        <th><?php echo $this->lang->line('email'); ?></th>
                                        <th><?php echo $this->lang->line('date_of_birth'); ?></th>
                                        <th><?php echo $this->lang->line('phone'); ?></th>
                                        <th class="text-right"><?php echo $this->lang->line('action'); ?>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($teacherList)) {
                                        $count = 1;
                                        foreach ($teacherList as $teacher) {
                                            ?>
                                            <tr>

                                                <td class="mailbox-name"> <a href="<?php echo base_url(); ?>admin/teacher/view/<?php echo $teacher['id']; ?>"><?php echo $teacher['name'] ?></a></td>
                                                <td class="mailbox-name"> <?php echo $teacher['email'] ?></td>
                                                <td class="mailbox-name"> <?php echo date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($teacher['dob'])); ?></td>
                                                <td class="mailbox-name"> <?php echo $teacher['phone'] ?></td>
                                                <td class="pull-right">
                                                    <div class="material-switch pull-right">

                                                        <input id="teacher<?php echo $teacher['user_tbl_id'] ?>" name="someSwitchOption001" type="checkbox" class="chk" data-rowid="<?php echo $teacher['user_tbl_id'] ?>" value="checked" <?php if ($teacher['user_tbl_active'] == "yes") echo "checked='checked'"; ?> />
                                                        <label for="teacher<?php echo $teacher['user_tbl_id'] ?>" class="label-success"></label>
                                                    </div>

                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        $count++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane table-responsive" id="tab_accountant">
						<div class="download_label"><?php echo $this->lang->line('users'); ?></div>
                            <table class="table table-striped table-bordered table-hover example" cellspacing="0" width="100%">
                                <thead>
                                    <tr>

                                        <th><?php echo $this->lang->line('name'); ?></th>
                                        <th><?php echo $this->lang->line('email'); ?></th>
                                        <th><?php echo $this->lang->line('date_of_birth'); ?></th>
                                        <th><?php echo $this->lang->line('phone'); ?></th>
                                        <th class="text-right"><?php echo $this->lang->line('action'); ?>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($accountantList)) {
                                        $count = 1;
                                        foreach ($accountantList as $accountant) {
                                            ?>
                                            <tr>

                                                <td class="mailbox-name"> <?php echo $accountant['name'] ?></td>
                                                <td class="mailbox-name"> <?php echo $accountant['email'] ?></td>
                                                <td class="mailbox-name"> <?php echo date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($accountant['dob'])); ?></td>
                                                <td class="mailbox-name"> <?php echo $accountant['phone'] ?></td>
                                                <td class="pull-right">
                                                    <div class="material-switch pull-right">

                                                        <input id="accountant<?php echo $accountant['user_tbl_id'] ?>" name="someSwitchOption001" type="checkbox" class="chk" data-rowid="<?php echo $accountant['user_tbl_id'] ?>" value="checked" <?php if ($accountant['user_tbl_active'] == "yes") echo "checked='checked'"; ?> />
                                                        <label for="accountant<?php echo $accountant['user_tbl_id'] ?>" class="label-success"></label>
                                                    </div>

                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        $count++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane table-responsive" id="tab_librarian">
						<div class="download_label"><?php echo $this->lang->line('users'); ?></div>
                            <table class="table table-striped table-bordered table-hover example" cellspacing="0" width="100%">
                                <thead>
                                    <tr>

                                        <th><?php echo $this->lang->line('name'); ?></th>
                                        <th><?php echo $this->lang->line('email'); ?></th>
                                        <th><?php echo $this->lang->line('date_of_birth'); ?></th>
                                        <th><?php echo $this->lang->line('phone'); ?></th>
                                        <th class="text-right no-print"><?php echo $this->lang->line('action'); ?>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($librarianList)) {
                                        $count = 1;
                                        foreach ($librarianList as $librarian) {
                                            ?>
                                            <tr>

                                                <td class="mailbox-name"> <?php echo $librarian['name'] ?></td>
                                                <td class="mailbox-name"> <?php echo $librarian['email'] ?></td>
                                                <td class="mailbox-name"> <?php echo date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($librarian['dob'])); ?></td>
                                                <td class="mailbox-name"> <?php echo $librarian['phone'] ?></td>
                                                <td class="pull-right">
                                                    <div class="material-switch pull-right">

                                                        <input id="librarian<?php echo $librarian['user_tbl_id'] ?>" name="someSwitchOption001" type="checkbox" class="chk" data-rowid="<?php echo $librarian['user_tbl_id'] ?>" value="checked" <?php if ($librarian['user_tbl_active'] == "yes") echo "checked='checked'"; ?> />
                                                        <label for="librarian<?php echo $librarian['user_tbl_id'] ?>" class="label-success"></label>
                                                    </div>

                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        $count++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div>
            </div> 
        </div> 
    </section>
</div>


<script type="text/javascript">
    $(document).ready(function () {

        $(document).on('click', '.chk', function () {
            var checked = $(this).is(':checked');
            var rowid = $(this).data('rowid');
            if (checked) {
                if (!confirm('Are you sure you active account?')) {
                    $(this).removeAttr('checked');
                } else {
                    var status = "yes";
                    changeStatus(rowid, status);

                }
            } else if (!confirm('Are you sure you deactive account?')) {
                $(this).prop("checked", true);
            } else {
                var status = "no";
                changeStatus(rowid, status);

            }
        });
    });

    function changeStatus(rowid, status) {


        var base_url = '<?php echo base_url() ?>';

        $.ajax({
            type: "POST",
            url: base_url + "admin/users/changeStatus",
            data: {'id': rowid, 'status': status},
            dataType: "json",
            success: function (data) {
                successMsg(data.msg);
            }
        });
    }


</script>