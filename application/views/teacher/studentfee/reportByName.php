<?php
$currency_symbol = $this->customlib->getSchoolCurrencyFormat();
?>
<div class="content-wrapper" style="min-height: 946px;">   
    <section class="content-header">
        <h1>
            <i class="fa fa-money"></i> <?php echo $this->lang->line('fees_collection'); ?>       </h1>
    </section>  
    <section class="content">
        <div class="row"> 
            <div class="col-md-12"> 
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-search"></i> <?php echo $this->lang->line('select_criteria'); ?></h3>
                    </div>
                    <form action="<?php echo site_url('teacher/studentfee/reportbyname') ?>"  method="post" accept-charset="utf-8">
                        <div class="box-body">
                            <?php echo $this->customlib->getCSRF(); ?>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><?php echo $this->lang->line('class'); ?></label>
                                        <select autofocus="" id="class_id" name="class_id" class="form-control" >
                                            <option value=""><?php echo $this->lang->line('select'); ?></option>
                                            <?php
                                            foreach ($classlist as $class) {
                                                ?>
                                                <option value="<?php echo $class['id'] ?>" <?php if (set_value('class_id') == $class['id']) echo "selected=selected" ?>><?php echo $class['class'] ?></option>
                                                <?php
                                                $count++;
                                            }
                                            ?>
                                        </select>
                                        <span class="text-danger"><?php echo form_error('class_id'); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><?php echo $this->lang->line('section'); ?></label>
                                        <select  id="section_id" name="section_id" class="form-control" >
                                            <option value=""><?php echo $this->lang->line('select'); ?></option>
                                        </select>
                                        <span class="text-danger"><?php echo form_error('section_id'); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><?php echo $this->lang->line('student'); ?></label>
                                        <select  id="student_id" name="student_id" class="form-control" >
                                            <option value=""><?php echo $this->lang->line('select'); ?></option>
                                        </select>
                                        <span class="text-danger"><?php echo form_error('student_id'); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="reset" class="btn btn-default"><?php echo $this->lang->line('reset'); ?></button>
                            <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-search"></i> <?php echo $this->lang->line('search'); ?></button>
                        </div>
                    </form>
                </div>
                </section>
                <?php
                if (isset($student_due_fee)) {
                    ?>
                    <section class="invoice" style="margin: 10px 15px;">                       
                        <div class="row">
                            <div class="col-xs-12">
                                <h2 class="page-header">
                                    <i class="fa fa-file-text-o"></i> <?php echo $this->lang->line('school_management'); ?>
                                    <small class="pull-right"><?php echo $this->lang->line('date'); ?>: <?php echo date($this->customlib->getSchoolDateFormat()); ?></small>
                                </h2>
                            </div>
                        </div>                       
                        <div class="row invoice-info">
                            <div class="col-sm-4 invoice-col">
                                <b><?php echo $this->lang->line('student'); ?> <?php echo $this->lang->line('name'); ?>: <?php echo $student['firstname'] . " " . $student['lastname']; ?></b> <br>
                                <b><?php echo $this->lang->line('class'); ?>: <?php echo $student['class'] . " (" . $student['section'] . ")" ?></b> <br>
                            </div>
                            <div class="col-sm-4 invoice-col">
                                <b><?php echo $this->lang->line('father_name'); ?>: <?php echo $student['father_name']; ?></b><br>
                                <b><?php echo $this->lang->line('mother_name'); ?>: <?php echo $student['mother_name']; ?></b><br>
                            </div>
                            <div class="col-sm-4 invoice-col">
                                <b><?php echo $this->lang->line('date_of_birth'); ?>: </b> <?php echo date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($student['dob'])); ?><br>
                                <b><?php echo $this->lang->line('admission_no'); ?>: <?php echo $student['admission_no']; ?></b> <br>
                            </div>
                        </div>                       
                        <div class="row">
                            <div class="col-xs-12 table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th><?php echo $this->lang->line('invoice_no'); ?></th>
                                            <th><?php echo $this->lang->line('date'); ?></th>
                                            <th><?php echo $this->lang->line('category'); ?></th>
                                            <th><?php echo $this->lang->line('type'); ?></th>
                                            <th><?php echo $this->lang->line('mode'); ?></th>
                                            <th><?php echo $this->lang->line('status'); ?></th>
                                            <th><?php echo $this->lang->line('amount'); ?></th>
                                            <th><?php echo $this->lang->line('fine'); ?></th>
                                            <th><?php echo $this->lang->line('discount'); ?></th>
                                            <th class="pull-right"><?php echo $this->lang->line('total'); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $target_amount = "0";
                                        $deposite_amount = "0";
                                        foreach ($student_due_fee as $key => $fee) {
                                            $target_amount = $target_amount + $fee['amount'];
                                            $cls = "";
                                            $total_row = "xxx";
                                            $payment_status = "<span class='label label-success'>" . $this->lang->line('paid') . "</span>";
                                            if ($fee['date'] == "xxx") {
                                                $cls = "text-red";
                                                $payment_status = "<span class='label label-danger'>" . $this->lang->line('unpaid') . "</span>";
                                            } else {
                                                $deposite_amount = $deposite_amount + $fee['amount'];
                                                $total_row = number_format(($fee['amount'] + $fee['fine']) - $fee['discount'], 2, '.', '');
                                            }
                                            ?>
                                            <tr>
                                                <td ><a href="#" class="<?php echo $cls; ?>"><?php echo $fee['invoiceno']; ?></a></td>
                                                <td class="<?php echo $cls; ?>">
                                                    <?php
                                                    if ($fee['date'] != "xxx") {

                                                        echo date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($fee['date']));
                                                    } else {
                                                        echo $fee['date'];
                                                    }
                                                    ?>
                                                </td>
                                                <td><?php echo $fee['category']; ?></td>
                                                <td><?php echo $fee['type']; ?></td>
                                                <td>
                                                    <?php
                                                    if ($fee['payment_mode'] == "xxx") {
                                                        ?><span class="text text-red"><?php echo $fee['payment_mode'] ?></span><?php
                                                    } else {

                                                        echo $fee['payment_mode'];
                                                    }
                                                    ?></td>
                                                <td><?php echo $payment_status; ?></td>
                                                <td><?php echo ($currency_symbol . $fee['amount']); ?></td>
                                                <td class="<?php echo $cls; ?>"><?php echo ($currency_symbol . $fee['fine']); ?></td>
                                                <td class="<?php echo $cls; ?>"><?php echo ($currency_symbol . $fee['discount']); ?></td>
                                                <td class="<?php echo $cls; ?> pull-right"><?php echo ($currency_symbol . $total_row); ?></td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">                           
                            <div class="col-xs-6">
                            </div>
                            <div class="col-md-6">
                                <p class="lead"><?php echo $this->lang->line('balance_details'); ?></p>
                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <th style="width:50%"><?php echo $this->lang->line('total_fees'); ?>:</th>
                                                <td><?php echo ($currency_symbol . number_format($target_amount, 2, '.', '')); ?></td>
                                            </tr>
                                            <tr>
                                                <th> <?php echo $this->lang->line('total_paid_fees'); ?>:</th>
                                                <td><?php echo ($currency_symbol . number_format($deposite_amount, 2, '.', '')); ?></td>
                                            </tr>
                                            <tr>
                                                <th><?php echo $this->lang->line('total_balance'); ?>:</th>
                                                <td><?php echo ($currency_symbol . number_format(($target_amount - $deposite_amount), 2, '.', '')); ?></td>
                                            </tr>
                                        </tbody></table>
                                </div>
                            </div>
                        </div>                     
                        <div class="row no-print">
                            <div class="col-xs-12">                              
                                <a class="btn btn-primary pull-right" href="<?php echo base_url(); ?>teacher/studentfee/addfee/<?php echo $student_id; ?>"><i class="fa fa-credit-card"></i>  <?php echo $this->lang->line('collect_fees'); ?></a>
                                <a href="<?php echo base_url(); ?>teacher/report/pdfStudentFeeRecord/<?php echo $class_id; ?>/<?php echo $section_id ?>/<?php echo $student_id; ?>" class="btn bg-orange pull-right" style="margin-right: 5px;"><i class="fa fa-download"></i>  <?php echo $this->lang->line('download_pdf'); ?></a>
                            </div>
                        </div>
                    </section>
                    <?php
                } else {
                    
                }
                ?>
            </div>
            <script type="text/javascript">
                function getSectionByClass(class_id, section_id) {
                    if (class_id != "" && section_id != "") {
                        $('#section_id').html("");
                        var base_url = '<?php echo base_url() ?>';
                        var div_data = '<option value=""><?php echo $this->lang->line('select'); ?></option>';
                        $.ajax({
                            type: "GET",
                            url: base_url + "teacher/sections/getByClass",
                            data: {'class_id': class_id},
                            dataType: "json",
                            success: function (data) {
                                $.each(data, function (i, obj)
                                {
                                    var sel = "";
                                    if (section_id == obj.section_id) {
                                        sel = "selected";
                                    }
                                    div_data += "<option value=" + obj.section_id + " " + sel + ">" + obj.section + "</option>";
                                });
                                $('#section_id').append(div_data);
                            }
                        });
                    }
                }

                $(document).ready(function () {
                    $(document).on('change', '#class_id', function (e) {
                        $('#section_id').html("");
                        var class_id = $(this).val();
                        var base_url = '<?php echo base_url() ?>';
                        var div_data = '<option value=""><?php echo $this->lang->line('select'); ?></option>';
                        $.ajax({
                            type: "GET",
                            url: base_url + "teacher/sections/getByClass",
                            data: {'class_id': class_id},
                            dataType: "json",
                            success: function (data) {
                                $.each(data, function (i, obj)
                                {
                                    div_data += "<option value=" + obj.section_id + ">" + obj.section + "</option>";
                                });

                                $('#section_id').append(div_data);
                            }
                        });
                    });
                    $(document).on('change', '#section_id', function (e) {
                        getStudentsByClassAndSection();

                    });

                    var class_id = $('#class_id').val();
                    var section_id = '<?php echo set_value('section_id') ?>';
                    getSectionByClass(class_id, section_id);
                    if (class_id != "" || section_id != "") {
                        postbackStudentsByClassAndSection(class_id, section_id);
                    }
                });
                function getStudentsByClassAndSection() {
                    $('#student_id').html("");
                    var class_id = $('#class_id').val();
                    var section_id = $('#section_id').val();
                    var student_id = '<?php echo set_value('student_id') ?>';
                    var base_url = '<?php echo base_url() ?>';
                    var div_data = '<option value=""><?php echo $this->lang->line('select'); ?></option>';
                    $.ajax({
                        type: "GET",
                        url: base_url + "teacher/student/getByClassAndSection",
                        data: {'class_id': class_id, 'section_id': section_id},
                        dataType: "json",
                        success: function (data) {
                            $.each(data, function (i, obj)
                            {
                                var sel = "";
                                if (section_id == obj.section_id) {
                                    sel = "selected=selected";
                                }
                                div_data += "<option value=" + obj.id + ">" + obj.firstname + " " + obj.lastname + "</option>";
                            });
                            $('#student_id').append(div_data);
                        }
                    });
                }

                function postbackStudentsByClassAndSection(class_id, section_id) {
                    $('#student_id').html("");
                    var student_id = '<?php echo set_value('student_id') ?>';
                    var base_url = '<?php echo base_url() ?>';
                    var div_data = '<option value=""><?php echo $this->lang->line('select'); ?></option>';
                    $.ajax({
                        type: "GET",
                        url: base_url + "teacher/student/getByClassAndSection",
                        data: {'class_id': class_id, 'section_id': section_id},
                        dataType: "json",
                        success: function (data) {
                            $.each(data, function (i, obj)
                            {
                                var sel = "";
                                if (student_id == obj.id) {
                                    sel = "selected=selected";
                                }
                                div_data += "<option value=" + obj.id + " " + sel + ">" + obj.firstname + " " + obj.lastname + "</option>";
                            });
                            $('#student_id').append(div_data);
                        }
                    });
                }
            </script>