<style type="text/css">

    @media print
    {
        .no-print, .no-print *
        {
            display: none !important;
        }
    }
    .option_grade{
        display: none;
    }
</style>
<?php
$currency_symbol = $this->customlib->getSchoolCurrencyFormat();
?>
<div class="content-wrapper" style="min-height: 946px;">   
    <section class="content-header">
        <h1>
            <i class="fa fa-user-plus"></i> <?php echo $this->lang->line('my_profile'); ?> <small><?php echo $this->lang->line('student1'); ?></small>        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-3">                
                <div class="box box-primary">
                    <div class="box-body box-profile">
                        <img class="profile-user-img img-responsive img-circle" src="<?php echo base_url() . $student['image'] ?>" alt="User profile picture">
                        <h3 class="profile-username text-center"><?php echo $student['firstname'] . " " . $student['lastname']; ?></h3>
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
            <div class="col-md-9">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#activity" data-toggle="tab" aria-expanded="true"><?php echo $this->lang->line('profile'); ?></a></li>
                        <li class=""><a href="#fee" data-toggle="tab" aria-expanded="true"><?php echo $this->lang->line('fees'); ?></a></li>
                        <li class=""><a href="#exam" data-toggle="tab" aria-expanded="true"><?php echo $this->lang->line('exam'); ?></a></li>
                        <li class=""><a href="#documents" data-toggle="tab" aria-expanded="true"><?php echo $this->lang->line('documents'); ?></a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="activity">
                            <div class="tshadow mb25 bozero">
                                <div class="table-responsive around10 pt0">
                                    <table class="table table-hover table-striped">
                                        <tbody>  
                                            <tr>
                                                <td class="col-md-4"><?php echo $this->lang->line('admission_date'); ?></td>
                                                <td class="col-md-5">                                            
                                                    <?php echo date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($student['admission_date'])); ?></td>
                                            </tr>
                                            <tr>
                                                <td><?php echo $this->lang->line('date_of_birth'); ?></td>
                                                <td><?php echo date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($student['dob'])); ?></td>
                                            </tr>
                                            <tr>
                                                <td><?php echo $this->lang->line('category'); ?></td>
                                                <td>
                                                    <?php
                                                    foreach ($category_list as $value) {
                                                        if ($student['category_id'] == $value['id']) {
                                                            echo $value['category'];
                                                        }
                                                    }
                                                    ?>  
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><?php echo $this->lang->line('mobile_no'); ?></td>
                                                <td><?php echo $student['mobileno']; ?></td>
                                            </tr>
                                            <tr>
                                                <td><?php echo $this->lang->line('cast'); ?></td>
                                                <td><?php echo $student['cast']; ?></td>
                                            </tr>
                                            <tr>
                                                <td><?php echo $this->lang->line('religion'); ?></td>
                                                <td><?php echo $student['religion']; ?></td>
                                            </tr>
                                            <tr>
                                                <td><?php echo $this->lang->line('email'); ?></td>
                                                <td><?php echo $student['email']; ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div></div> 
                            <div class="tshadow mb25 bozero">   
                                <h3 class="pagetitleh2"><?php echo $this->lang->line('address'); ?> <?php echo $this->lang->line('detail'); ?></h3>
                                <div class="table-responsive around10 pt0">
                                    <table class="table table-hover table-striped"><tbody>
                                            <tr>
                                                <td><?php echo $this->lang->line('current_address'); ?></td>
                                                <td><?php echo $student['current_address']; ?></td>
                                            </tr>
                                            <tr>
                                                <td><?php echo $this->lang->line('permanent_address'); ?></td>
                                                <td><?php echo $student['permanent_address']; ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div> 
                            <div class="tshadow mb25 bozero">      
                                <h3 class="pagetitleh2"><?php echo $this->lang->line('parent'); ?> / <?php echo $this->lang->line('guardian_details'); ?> </h3>
                                <div class="table-responsive around10 pt0">
                                    <table class="table table-hover table-striped">
                                        <tr>
                                            <td  class="col-md-4"><?php echo $this->lang->line('father_name'); ?></td>
                                            <td  class="col-md-5"><?php echo $student['father_name']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><?php echo $this->lang->line('father_phone'); ?></td>
                                            <td><?php echo $student['father_phone']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><?php echo $this->lang->line('father_occupation'); ?></td>
                                            <td><?php echo $student['father_occupation']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><?php echo $this->lang->line('mother_name'); ?></td>
                                            <td><?php echo $student['mother_name']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><?php echo $this->lang->line('mother_phone'); ?></td>
                                            <td><?php echo $student['mother_phone']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><?php echo $this->lang->line('mother_occupation'); ?></td>
                                            <td><?php echo $student['mother_occupation']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><?php echo $this->lang->line('guardian_name'); ?></td>
                                            <td><?php echo $student['guardian_name']; ?></td>
                                        </tr>
                                          <tr>
                                            <td><?php echo $this->lang->line('guardian_email'); ?></td>
                                            <td><?php echo $student['guardian_email']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><?php echo $this->lang->line('guardian_relation'); ?></td>
                                            <td><?php echo $student['guardian_relation']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><?php echo $this->lang->line('guardian_phone'); ?></td>
                                            <td><?php echo $student['guardian_phone']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><?php echo $this->lang->line('guardian_occupation'); ?></td>
                                            <td><?php echo $student['guardian_occupation']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><?php echo $this->lang->line('guardian_address'); ?></td>
                                            <td><?php echo $student['guardian_address']; ?></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div> 
                            <div class="tshadow mb25  bozero">    
                                <h3 class="pagetitleh2"><?php echo $this->lang->line('miscellaneous_details'); ?></h3>
                                <div class="table-responsive around10 pt0">
                                    <table class="table table-hover table-striped">
                                        <tbody>
                                            <tr>
                                                <td  class="col-md-4"><?php echo $this->lang->line('previous_school_details'); ?></td>
                                                <td  class="col-md-5"><?php echo $student['previous_school']; ?></td>
                                            </tr>
                                            <tr>
                                                <td  class="col-md-4"><?php echo $this->lang->line('national_identification_no'); ?></td>
                                                <td  class="col-md-5"><?php echo $student['adhar_no']; ?></td>
                                            </tr>
                                            <tr>
                                                <td><?php echo $this->lang->line('local_identification_no'); ?></td>
                                                <td><?php echo $student['samagra_id']; ?></td>
                                            </tr>
                                            <tr>
                                                <td><?php echo $this->lang->line('bank_account_no'); ?></td>
                                                <td><?php echo $student['bank_account_no']; ?></td>
                                            </tr>
                                            <tr>
                                                <td><?php echo $this->lang->line('bank_name'); ?></td>
                                                <td><?php echo $student['bank_name']; ?></td>
                                            </tr>
                                            <tr>
                                                <td><?php echo $this->lang->line('ifsc_code'); ?></td>
                                                <td><?php echo $student['ifsc_code']; ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div> 
                        </div>
                        <div class="tab-pane" id="fee">

                            <?php
                            if (empty($student_due_fee) && empty($student_discount_fee)) {
                                ?>
                                <div class="alert alert-danger">
                                    <?php echo $this->lang->line('no_record_found'); ?>
                                </div>
                                <?php
                            } else {
                                ?>
                                <table class="table table-hover table-striped">

                                    <thead>
                                        <tr>
                                            <th><?php echo $this->lang->line('fees_group'); ?></th>
                                            <th><?php echo $this->lang->line('fees_code'); ?></th>
                                            <th class="text text-left"><?php echo $this->lang->line('due_date'); ?></th>
                                            <th class="text text-left"><?php echo $this->lang->line('status'); ?></th>
                                            <th class="text text-right"><?php echo $this->lang->line('amount'); ?> <span><?php echo "(" . $currency_symbol . ")"; ?></span></th>
                                            <th class="text text-right"><?php echo $this->lang->line('payment_id'); ?></th>
                                            <th class="text text-left"><?php echo $this->lang->line('mode'); ?></th>
                                            <th class="text text-left"><?php echo $this->lang->line('date'); ?></th>


                                            <th class="text text-right" ><?php echo $this->lang->line('discount'); ?> <span><?php echo "(" . $currency_symbol . ")"; ?></span></th>
                                            <th class="text text-right"><?php echo $this->lang->line('fine'); ?> <span><?php echo "(" . $currency_symbol . ")"; ?></span></th>
                                            <th class="text text-right"><?php echo $this->lang->line('paid'); ?> <span><?php echo "(" . $currency_symbol . ")"; ?></span></th>
                                            <th class="text text-right"><?php echo $this->lang->line('balance'); ?> <span><?php echo "(" . $currency_symbol . ")"; ?></span></th>


                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $total_amount = "0";
                                        $total_deposite_amount = "0";
                                        $total_fine_amount = "0";
                                        $total_discount_amount = "0";
                                        $total_balance_amount = "0";
                                        $alot_fee_discount = 0;
                                        foreach ($student_due_fee as $key => $fee) {

                                            foreach ($fee->fees as $fee_key => $fee_value) {
                                                $fee_paid = 0;
                                                $fee_discount = 0;
                                                $fee_fine = 0;



                                                if (!empty($fee_value->amount_detail)) {
                                                    $fee_deposits = json_decode(($fee_value->amount_detail));

                                                    foreach ($fee_deposits as $fee_deposits_key => $fee_deposits_value) {
                                                        $fee_paid = $fee_paid + $fee_deposits_value->amount;
                                                        $fee_discount = $fee_discount + $fee_deposits_value->amount_discount;
                                                        $fee_fine = $fee_fine + $fee_deposits_value->amount_fine;
                                                    }
                                                }
                                                $total_amount = $total_amount + $fee_value->amount;
                                                $total_discount_amount = $total_discount_amount + $fee_discount;
                                                $total_deposite_amount = $total_deposite_amount + $fee_paid;
                                                $total_fine_amount = $total_fine_amount + $fee_fine;
                                                $feetype_balance = $fee_value->amount - ($fee_paid + $fee_discount);
                                                $total_balance_amount = $total_balance_amount + $feetype_balance;
                                                ?>
                                                <?php
                                                if ($feetype_balance > 0 && strtotime($fee_value->due_date) < strtotime(date('Y-m-d'))) {
                                                    ?>
                                                    <tr class="danger">
                                                        <?php
                                                    } else {
                                                        ?>
                                                    <tr class="dark-gray">
                                                        <?php
                                                    }
                                                    ?>


                                                    <td><?php
                                                        echo $fee_value->name;
                                                        ?></td>
                                                    <td><?php echo $fee_value->code; ?></td>
                                                    <td class="text text-left">

                                                        <?php
                                                        if ($fee_value->due_date == "0000-00-00") {
                                                            
                                                        } else {

                                                            echo date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($fee_value->due_date));
                                                        }
                                                        ?>
                                                    </td>
                                                    <td class="text text-left">
                                                        <?php
                                                        if ($feetype_balance == 0) {
                                                            ?><span class="label label-success"><?php echo $this->lang->line('paid'); ?></span><?php
                                                        } else if (!empty($fee_value->amount_detail)) {
                                                            ?><span class="label label-warning"><?php echo $this->lang->line('partial'); ?></span><?php
                                                        } else {
                                                            ?><span class="label label-danger"><?php echo $this->lang->line('unpaid'); ?></span><?php
                                                            }
                                                            ?>

                                                    </td>
                                                    <td class="text text-right"><?php echo $fee_value->amount; ?></td>

                                                    <td></td>
                                                    <td></td>
                                                    <td></td>


                                                    <td class="text text-right"><?php
                                                        echo (number_format($fee_discount, 2, '.', ''));
                                                        ?></td>
                                                    <td class="text text-right"><?php
                                                        echo (number_format($fee_fine, 2, '.', ''));
                                                        ?></td>
                                                    <td class="text text-right"><?php
                                                        echo (number_format($fee_paid, 2, '.', ''));
                                                        ?></td>
                                                    <td class="text text-right"><?php
                                                        $display_none = "ss-none";
                                                        if ($feetype_balance > 0) {
                                                            $display_none = "";


                                                            echo (number_format($feetype_balance, 2, '.', ''));
                                                        }
                                                        ?>

                                                    </td>




                                                </tr>

                                                <?php
                                                if (!empty($fee_value->amount_detail)) {

                                                    $fee_deposits = json_decode(($fee_value->amount_detail));

                                                    foreach ($fee_deposits as $fee_deposits_key => $fee_deposits_value) {
                                                        ?>
                                                        <tr class="white-td">
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td class="text-right"><img src="<?php echo base_url(); ?>backend/images/table-arrow.png" alt="" /></td>
                                                            <td class="text text-center">


                                                                <a href="#" data-toggle="popover" class="detail_popover" > <?php echo $fee_value->student_fees_deposite_id . "/" . $fee_deposits_value->inv_no; ?></a>
                                                                <div class="fee_detail_popover" style="display: none">
                                                                    <?php
                                                                    if ($fee_deposits_value->description == "") {
                                                                        ?>
                                                                        <p class="text text-danger"><?php echo $this->lang->line('no_description'); ?></p>
                                                                        <?php
                                                                    } else {
                                                                        ?>
                                                                        <p class="text text-info"><?php echo $fee_deposits_value->description; ?></p>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </div>


                                                            </td>
                                                            <td class="text text-center"><?php echo $fee_deposits_value->payment_mode; ?></td>
                                                            <td class="text text-center">

                                                                <?php echo date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($fee_deposits_value->date)); ?>
                                                            </td>
                                                            <td class="text text-right"><?php echo (number_format($fee_deposits_value->amount_discount, 2, '.', '')); ?></td>
                                                            <td class="text text-right"><?php echo (number_format($fee_deposits_value->amount_fine, 2, '.', '')); ?></td>
                                                            <td class="text text-right"><?php echo (number_format($fee_deposits_value->amount, 2, '.', '')); ?></td>


                                                            <td></td>



                                                        </tr>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                                <?php
                                            }
                                        }
                                        ?>
                                        <?php
                                        if (!empty($student_discount_fee)) {

                                            foreach ($student_discount_fee as $discount_key => $discount_value) {
                                                ?>
                                                <tr class="dark-light">
                                                    <td align="left"> <?php echo $this->lang->line('discount'); ?> </td>
                                                    <td align="left">
                                                        <?php echo $discount_value['code']; ?>
                                                    </td>
                                                    <td align="left"></td>
                                                    <td align="left" class="text text-left">
                                                        <?php
                                                        if ($discount_value['status'] == "applied") {
                                                            ?>
                                                            <a href="#" data-toggle="popover" class="detail_popover" >

                                                                <?php echo $this->lang->line('discount_of') . " " . $currency_symbol . $discount_value['amount'] . " " . $this->lang->line($discount_value['status']) . " : " . $discount_value['payment_id']; ?>

                                                            </a>
                                                            <div class="fee_detail_popover" style="display: none">
                                                                <?php
                                                                if ($fee_deposits_value->description == "") {
                                                                    ?>
                                                                    <p class="text text-danger"><?php echo $this->lang->line('no_description'); ?></p>
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                    <p class="text text-danger"><?php echo $discount_value['student_fees_discount_description'] ?></p>
                                                                    <?php
                                                                }
                                                                ?>

                                                            </div>
                                                            <?php
                                                        } else {
                                                            echo '<p class="text text-danger">' . $this->lang->line('discount_of') . " " . $currency_symbol . $discount_value['amount'] . " " . $this->lang->line($discount_value['status']);
                                                        }
                                                        ?>

                                                    </td>
                                                    <td></td>
                                                    <td class="text text-left"></td>
                                                    <td class="text text-left"></td>
                                                    <td class="text text-left"></td>
                                                    <td  class="text text-right">
                                                        <?php
                                                        $alot_fee_discount = $alot_fee_discount;
                                                        ?>
                                                    </td>
                                                    <td></td>
                                                    <td></td>
                                                    <td ></td>

                                                </tr>
                                                <?php
                                            }
                                        }
                                        ?>


                                        <tr class="box box-solid total-bg">
                                            <td ></td>
                                            <td ></td>
                                            <td ></td>
                                            <td class="text text-right" ><?php echo $this->lang->line('grand_total'); ?></td>
                                            <td class="text text-right"><?php
                                                echo ($currency_symbol . number_format($total_amount, 2, '.', ''));
                                                ?></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>


                                            <td class="text text-right"><?php
                                                echo ($currency_symbol . number_format($total_discount_amount + $alot_fee_discount, 2, '.', ''));
                                                ?></td>
                                            <td class="text text-right"><?php
                                                echo ($currency_symbol . number_format($total_fine_amount, 2, '.', ''));
                                                ?></td>
                                            <td class="text text-right"><?php
                                                echo ($currency_symbol . number_format($total_deposite_amount, 2, '.', ''));
                                                ?></td>

                                            <td class="text text-right"><?php
                                                echo ($currency_symbol . number_format($total_balance_amount - $alot_fee_discount, 2, '.', ''));
                                                ?></td> 

                                        </tr>
                                    </tbody>
                                </table>
                                <?php
                            }
                            ?>

                        </div>                       
                        <div class="tab-pane" id="documents">
                            <div class="timeline-header no-border">
                                <button type="button"  data-student-session-id="<?php echo $student['student_session_id'] ?>" class="btn btn-xs btn-primary pull-right myTransportFeeBtn mb10"> <i class="fa fa-upload"></i>  <?php echo $this->lang->line('upload_documents'); ?></button>

                                <div class="table-responsive" style="clear: both;">                          
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>
                                                    <?php echo $this->lang->line('title'); ?>
                                                </th>
                                                <th>
                                                    <?php echo $this->lang->line('file'); ?> <?php echo $this->lang->line('name'); ?>
                                                </th>
                                                <th class="mailbox-date text-right">
                                                    <?php echo $this->lang->line('action'); ?>
                                                </th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php
                                            if (empty($student_doc)) {
                                                ?>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="3" class="text-danger text-center"><?php echo $this->lang->line('no_record_found'); ?></td>
                                                </tr>
                                            </tfoot>
                                            <?php
                                        } else {
                                            foreach ($student_doc as $value) {
                                                ?>
                                                <tr>
                                                    <td><?php echo $value['title']; ?></td>
                                                    <td><?php echo $value['doc']; ?></td>
                                                    <td class="mailbox-date text-right">
                                                        <a href="<?php echo base_url(); ?>user/user/download/<?php echo $value['student_id'] . "/" . $value['doc']; ?>"class="btn btn-default btn-xs"  data-toggle="tooltip" title="<?php echo $this->lang->line('download'); ?>">
                                                            <i class="fa fa-download"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div> 
                            </div>
                            </table>
                        </div>                        
                        <div class="tab-pane" id="exam">
                            <div class="tshadow mb25"> 
                                <?php
                                if (empty($examSchedule)) {
                                    ?>
                                    <div class="alert alert-danger">
                                        <?php echo $this->lang->line('no_record_found'); ?>
                                    </div>
                                    <?php
                                } else {
                                    $counter = 1;
                                    foreach ($examSchedule as $key => $value) {
                                        ?>
                                        <div id="<?php echo 'print_view' . $counter ?>">
                                            <h4 class="pagetitleh"><?php echo $value['exam_name']; ?></h4>
                                            <?php
                                            if (empty($value['exam_result'])) {
                                                ?>
                                                <div class="alert alert-info"><?php echo $this->lang->line('no_result_prepare'); ?></div>
                                                <?php
                                            } else {
                                                ?>
                                                <div class="table-responsive borgray around10">  
												<div class="download_label"><?php echo $this->lang->line('exam_marks_report'); ?></div>
                                                    <table class="table table-striped table-hover tmb0 example">
                                                        <thead>
                                                            <tr>
                                                                <th>
                                                                    <?php echo $this->lang->line('subject'); ?>
                                                                </th>
                                                                <th>
                                                                    <?php echo $this->lang->line('full_marks'); ?>
                                                                </th>
                                                                <th>
                                                                    <?php echo $this->lang->line('passing_marks'); ?>
                                                                </th>
                                                                <th>
                                                                    <?php echo $this->lang->line('obtain_marks'); ?>
                                                                </th>
                                                                <th class="text text-right">
                                                                    <?php echo $this->lang->line('result'); ?>
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $obtain_marks = 0;
                                                            $total_marks = 0;
                                                            $result = "Pass";
                                                            $exam_results_array = $value['exam_result'];
                                                            $s = 0;
                                                            foreach ($exam_results_array as $result_k => $result_v) {
                                                                $total_marks = $total_marks + $result_v['full_marks'];
                                                                ?>
                                                                <tr>
                                                                    <td>  <?php
                                                                        echo $result_v['exam_name'] . " (" . substr($result_v['exam_type'], 0, 2) . ".) ";
                                                                        ?></td>
                                                                    <td><?php echo $result_v['full_marks']; ?></td>
                                                                    <td><?php echo $result_v['passing_marks']; ?></td>
                                                                    <td>
                                                                        <?php
                                                                        if ($result_v['attendence'] == "pre") {
                                                                            echo $get_marks_student = $result_v['get_marks'];
                                                                            $passing_marks_student = $result_v['passing_marks'];
                                                                            if ($result == "Pass") {
                                                                                if ($get_marks_student < $passing_marks_student) {
                                                                                    $result = "Fail";
                                                                                }
                                                                            }
                                                                            $obtain_marks = $obtain_marks + $result_v['get_marks'];
                                                                        } else {
                                                                            $result = "Fail";
                                                                            echo ($result_v['attendence']);
                                                                        }
                                                                        ?>
                                                                    </td>
                                                                    <td class="text text-center">
                                                                        <?php
                                                                        if ($result_v['attendence'] == "pre") {
                                                                            $passing_marks_student = $result_v['passing_marks'];

                                                                            if ($get_marks_student < $passing_marks_student) {
                                                                                echo "<span class='label pull-right bg-red'>" . $this->lang->line('fail') . "</span>";
                                                                            } else {
                                                                                echo "<span class='label pull-right bg-green'>" . $this->lang->line('pass') . "</span>";
                                                                            }
                                                                        } else {
                                                                            echo "<span class='label pull-right bg-red'>" . $this->lang->line('fail') . "</span>";
                                                                            $s++;
                                                                        }
                                                                        ?>
                                                                    </td>
                                                                </tr>
                                                                <?php
                                                                if ($s == count($exam_results_array)) {
                                                                    $obtain_marks = 0;
                                                                }
                                                            }
                                                            ?>
                                                              <tr class="hide">
                                                            <td><?php echo $this->lang->line('exam').": ".$value['exam_name']; ?></td>
                                                            <td>
                                                                <?php
                                                                if ($result == "Pass") {
                                                                    ?>
                                                                    <b class='text text-success'><?php echo $this->lang->line('result') .": ". $result; ?></b>
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                    <b class='text text-danger'><?php echo $this->lang->line('result') .": ". $result; ?></b>
                                                                    <?php
                                                                }
                                                                ?></td>
                                                            <td><?php
                                                                echo $this->lang->line('grand_total') . ": " . $obtain_marks . "/" . $total_marks;
                                                                ;
                                                                ?></td>
                                                            <td><?php
                                                                $foo = ($obtain_marks * 100) / $total_marks;
                                                                echo $this->lang->line('percentage') .": ". number_format((float) $foo, 2, '.', '');
                                                                ?></td>
                                                            <td><?php
                                                                if (!empty($gradeList)) {
                                                                    foreach ($gradeList as $key => $value) {
                                                                        if ($foo >= $value['mark_from'] && $foo <= $value['mark_upto']) {
                                                                            ?>
                                                                            <?php echo $this->lang->line('grade') . " : " . $value['name']; ?>
                                                                            <?php
                                                                            break;
                                                                        }
                                                                    }
                                                                }
                                                                ?></td>

                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>  
                                                <div class="row">
                                                    <div class="col-md-12" style="margin-bottom: 10px">
                                                        <div class="bgtgray mb0">
                                                            <?php
                                                            $foo = "";
                                                            ?>                                               <div class="col-md-12 option_grade">
                                                                <div class="description-header"><?php echo $this->lang->line('grand_total'); ?>:
                                                                    <span class="description-text"><?php echo $obtain_marks . "/" . $total_marks; ?></span>
                                                                </div>
                                                                <div class="description-header"><?php echo $this->lang->line('percentage'); ?>:
                                                                    <span class="description-text"><?php
                                                                        $foo = ($obtain_marks * 100) / $total_marks;
                                                                        echo number_format((float) $foo, 2, '.', '');
                                                                        ?>
                                                                    </span>
                                                                </div>
                                                                <div class="description-header"><?php echo $this->lang->line('result'); ?>:
                                                                    <span class="description-text">
                                                                        <?php
                                                                        if ($result == "Pass") {
                                                                            ?>
                                                                            <b><?php echo $result; ?></b>
                                                                            <?php
                                                                        } else {
                                                                            ?>
                                                                            <b><?php echo $result; ?></b>
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                    </span>
                                                                </div>
                                                                <div class="description-header">
                                                                    <span class="description-text"><?php
                                                                        if (!empty($gradeList)) {
                                                                            foreach ($gradeList as $key => $value) {
                                                                                if ($foo >= $value['mark_from'] && $foo <= $value['mark_upto']) {
                                                                                    ?>
                                                                                    <?php echo $this->lang->line('grade') . ": " . $value['name']; ?>
                                                                                    <?php
                                                                                    break;
                                                                                }
                                                                            }
                                                                        }
                                                                        ?></span>
                                                                </div>

                                                            </div> 
                                                            <div class="col-sm-3 pull no-print">
                                                                <div class="description-block">
                                                                    <h5 class="description-header"><?php echo $this->lang->line('result'); ?>:
                                                                        <span class="description-text">
                                                                            <?php
                                                                            if ($result == "Pass") {
                                                                                ?>
                                                                                <span class='label bg-green'><?php echo $result; ?></span>
                                                                                <?php
                                                                            } else {
                                                                                ?>
                                                                                <span class='label bg-red'><?php echo $result; ?></span>
                                                                                <?php
                                                                            }
                                                                            ?>
                                                                        </span>
                                                                    </h5>
                                                                </div>                                                   
                                                            </div>
                                                            <div class="col-sm-3 border-right no-print">
                                                                <div class="description-block">
                                                                    <h5 class="description-header"><?php echo $this->lang->line('grand_total'); ?>:
                                                                        <span class="description-text"><?php echo $obtain_marks . "/" . $total_marks; ?></span>
                                                                    </h5>
                                                                </div>                                                   
                                                            </div>
                                                            <div class="col-sm-3 border-right no-print">
                                                                <div class="description-block">
                                                                    <h5 class="description-header"><?php echo $this->lang->line('percentage'); ?>:
                                                                        <span class="description-text"><?php
                                                                            $foo = ($obtain_marks * 100) / $total_marks;
                                                                            echo number_format((float) $foo, 2, '.', '') . '%';
                                                                            ?>
                                                                        </span>
                                                                    </h5>
                                                                </div>                                                   
                                                            </div>                                                

                                                            <div class="col-sm-3 border-right no-print">
                                                                <div class="description-block">
                                                                    <h5 class="description-header">
                                                                        <span class="description-text"><?php
                                                                            if (!empty($gradeList)) {
                                                                                foreach ($gradeList as $key => $value) {
                                                                                    if ($foo >= $value['mark_from'] && $foo <= $value['mark_upto']) {
                                                                                        ?>
                                                                                        <?php echo $this->lang->line('grade') . ": " . $value['name']; ?>
                                                                                        <?php
                                                                                        break;
                                                                                    }
                                                                                }
                                                                            }
                                                                            ?></span>
                                                                    </h5>
                                                                </div>                                                   
                                                            </div>                                              
                                                        </div></div></div>
                                            <?php }
                                            ?>
                                        </div>
                                        <?php
                                        $counter++;
                                    }
                                }
                                ?>
                            </div>  
                        </div>                        
                    </div>
                </div>
            </div>
    </section> 
</div>

<div class="modal fade" id="myTransportFeesModal" role="dialog">
    <div class="modal-dialog">        
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title title text-center transport_fees_title"></h4>
            </div>
            <div class="">
                <div class="form-horizontal">
                    <div class="">
                        <input  type="hidden" class="form-control" id="transport_student_session_id"  value="0" readonly="readonly"/>
                        <form id="form1" action="<?php echo site_url('student/create_doc') ?>"  id="employeeform" name="employeeform" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                            <?php echo $this->customlib->getCSRF(); ?>
                            <div id='upload_documents_hide_show'>                                                  
                                <input type="hidden" name="student_id" value="<?php echo $student_doc_id; ?>" id="student_id">
                                <h4><?php echo $this->lang->line('upload_documents1'); ?></h4>
                                <div class="col-md-12">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1"><?php echo $this->lang->line('title'); ?></label>
                                            <input id="first_title" name="first_title" placeholder="" type="text" class="form-control"  value="<?php echo set_value('first_title'); ?>" />
                                            <span class="text-danger"><?php echo form_error('first_title'); ?></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6"> 
                                        <div class="form-group">                                          
                                            <label for="exampleInputEmail1"><?php echo $this->lang->line('Documents'); ?></label>
                                            <div class="mml15" style="margin-top:5px; border:0; outline:none;">
                                                <input id="first_doc_id" name="first_doc" placeholder="" type="file" class="filestyle form-control"  value="<?php echo set_value('first_doc'); ?>" />
                                                <span class="text-danger"><?php echo form_error('first_doc'); ?></span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer" style="clear:both">
                                <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><?php echo $this->lang->line('cancel'); ?></button>
                                <button type="submit" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>
                            </div>
                        </form>
                    </div>                   
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var base_url = '<?php echo base_url() ?>';
    function printDiv(elem) {
        Popup(jQuery(elem).html());
    }

    function Popup(data)
    {

        var frame1 = $('<iframe />');
        frame1[0].name = "frame1";
        frame1.css({"position": "absolute", "top": "-1000000px"});
        $("body").append(frame1);
        var frameDoc = frame1[0].contentWindow ? frame1[0].contentWindow : frame1[0].contentDocument.document ? frame1[0].contentDocument.document : frame1[0].contentDocument;
        frameDoc.document.open();
        frameDoc.document.write('<html>');
        frameDoc.document.write('<head>');
        frameDoc.document.write('<title></title>');
        frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/bootstrap/css/bootstrap.min.css">');
        frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/dist/css/font-awesome.min.css">');
        frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/dist/css/ionicons.min.css">');
        frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/dist/css/AdminLTE.min.css">');
        frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/dist/css/skins/_all-skins.min.css">');
        frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/plugins/iCheck/flat/blue.css">');
        frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/plugins/morris/morris.css">');
        frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/plugins/jvectormap/jquery-jvectormap-1.2.2.css">');
        frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/plugins/datepicker/datepicker3.css">');
        frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/plugins/daterangepicker/daterangepicker-bs3.css">');
        frameDoc.document.write('</head>');
        frameDoc.document.write('<body>');
        frameDoc.document.write(data);
        frameDoc.document.write('</body>');
        frameDoc.document.write('</html>');
        frameDoc.document.close();
        setTimeout(function () {
            window.frames["frame1"].focus();
            window.frames["frame1"].print();
            frame1.remove();
        }, 500);


        return true;
    }
</script>
<script type="text/javascript">
   $(document).ready(function () {
    $.extend( $.fn.dataTable.defaults, {
    searching: false,
    ordering:  false,
    paging: false,
    bSort: false,
    info: false
   });
    });

    $(document).ready(function () {
        $('.detail_popover').popover({
            placement: 'right',
            title: '',
            trigger: 'hover',
            container: 'body',
            html: true,
            content: function () {
                return $(this).closest('td').find('.fee_detail_popover').html();
            }
        });
    });

    $(document).ready(function () {
        $('table.display').DataTable();
    });


</script>


<script type="text/javascript">

    $(".myTransportFeeBtn").click(function () {
        $("span[id$='_error']").html("");
        $('#transport_amount').val("");
        $('#transport_amount_discount').val("0");
        $('#transport_amount_fine').val("0");
        var student_session_id = $(this).data("student-session-id");
        $('.transport_fees_title').html("<b>Upload Document</b>");
        $('#transport_student_session_id').val(student_session_id);
        $('#myTransportFeesModal').modal({
            backdrop: 'static',
            keyboard: false,
            show: true
        });
    });
</script>
