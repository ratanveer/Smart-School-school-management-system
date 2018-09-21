<?php
$currency_symbol = $this->customlib->getSchoolCurrencyFormat();


?>

<div class="content-wrapper" style="min-height: 946px;">
    <section class="content-header">
        <h1>
            <i class="fa fa-user-plus"></i> <?php echo $this->lang->line('student_information'); ?> <small><?php echo $this->lang->line('student1'); ?></small></h1>
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
                                <b><?php echo $this->lang->line('admission_no'); ?></b> <a class="pull-right"><?php echo $student['admission_no']; ?></a>
                            </li>
                            <li class="list-group-item">
                                <b><?php echo $this->lang->line('roll_no'); ?></b> <a class="pull-right"><?php echo $student['roll_no']; ?></a>
                            </li>
                            <li class="list-group-item">
                                <b><?php echo $this->lang->line('class'); ?></b> <a class="pull-right"><?php echo $student['class']; ?></a>
                            </li>
                            <li class="list-group-item">
                                <b><?php echo $this->lang->line('section'); ?></b> <a class="pull-right"><?php echo $student['section']; ?></a>
                            </li>
                            <li class="list-group-item">
                                <b><?php echo $this->lang->line('rte'); ?></b> <a class="pull-right"><?php echo $student['rte']; ?></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            <?php echo $this->lang->line('fees'); ?>
                        </h3>
                    </div>
                    <div class="box-body">
                        <?php
                        if (empty($student_due_fee)) {
                            ?>
                            <div class="alert alert-danger">
                                No fees Found.
                            </div>
                            <?php
                        } else {
                            ?>
                            <div class="table-responsive">  

                                <table class="table table-striped table-hover">

                                    <thead>
                                        <tr>
                                            <th align="left"><?php echo $this->lang->line('fees_group'); ?></th>
                                            <th align="left"><?php echo $this->lang->line('fees_code'); ?></th>
                                            <th align="left" class="text text-center"><?php echo $this->lang->line('due_date'); ?></th>
                                            <th align="left" class="text text-left"><?php echo $this->lang->line('status'); ?></th>
                                            <th class="text text-right"><?php echo $this->lang->line('amount') ?> <span><?php echo "(" . $currency_symbol . ")"; ?></span></th>
                                            <th class="text text-left"><?php echo $this->lang->line('payment_id'); ?></th>
                                            <th class="text text-left"><?php echo $this->lang->line('mode'); ?></th>
                                            <th class="text text-left"><?php echo $this->lang->line('date'); ?></th>
                                            <th class="text text-right" ><?php echo $this->lang->line('discount'); ?> <span><?php echo "(" . $currency_symbol . ")"; ?></span></th>
                                            <th class="text text-right"><?php echo $this->lang->line('fine'); ?> <span><?php echo "(" . $currency_symbol . ")"; ?></span></th>
                                            <th class="text text-right"><?php echo $this->lang->line('paid'); ?> <span><?php echo "(" . $currency_symbol . ")"; ?></span></th>
                                            <th class="text text-right"><?php echo $this->lang->line('balance'); ?> <span><?php echo "(" . $currency_symbol . ")"; ?></span></th>
                                            <th class="text text-right"><?php echo $this->lang->line('action'); ?></th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $total_amount = "0";
                                        $total_deposite_amount = "0";
                                        $total_fine_amount = "0";
                                        $total_discount_amount = "0";
                                        $total_balance_amount = "0";

                                        foreach ($student_due_fee as $key => $fee) {

                                            foreach ($fee->fees as $fee_key => $fee_value) {
                                                $fee_paid = 0;
                                                $fee_discount = 0;
                                                $fee_fine = 0;
                                                $alot_fee_discount = 0;


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
                                                    <tr class="danger font12">
                                                        <?php
                                                    } else {
                                                        ?>
                                                    <tr class="dark-gray">
                                                        <?php
                                                    }
                                                    ?>


                                                    <td align="left"><?php
                                                        echo $fee_value->name;
                                                        ?></td>
                                                    <td align="left"><?php echo $fee_value->code; ?></td>
                                                    <td align="left" class="text text-center">

                                                        <?php
                                                        if ($fee_value->due_date == "0000-00-00") {
                                                            
                                                        } else {

                                                            echo date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($fee_value->due_date));
                                                        }
                                                        ?>
                                                    </td>
                                                    <td align="left" class="text text-left">
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

                                                    <td class="text text-left"></td>
                                                    <td class="text text-left"></td>
                                                    <td class="text text-left"></td>
                                                    <td class="text text-right"><?php
                                                        echo (number_format($fee_discount, 2, '.', ''));
                                                        ?></td>
                                                    <td class="text text-right"><?php
                                                        echo (number_format($fee_fine, 2, '.', ''));
                                                        ?></td>
                                                    <td class="text text-right"><?php
                                                        echo (number_format($fee_paid, 2, '.', ''));
                                                        ?></td>
                                                    <td class="text text-right">
                                                        <?php
                                                        $display_none = "ss-none";
                                                        if ($feetype_balance > 0) {
                                                            $display_none = "";
                                                            echo (number_format($feetype_balance, 2, '.', ''));
                                                        }
                                                        ?>

                                                    </td>

                                                    <td>
                                                        <div class="btn-group pull-right"> 
                                                            <?php
                                                            if($payment_method){
                                                                
                                                            if ($feetype_balance > 0) {
                                                                ?>
                                                                <a href="<?php echo base_url() . 'parent/payment/pay/' . $fee->id . "/" . $fee_value->fee_groups_feetype_id . "/" . $student['id'] ?>" class="btn btn-xs btn-primary pull-right myCollectFeeBtn"><i class="fa fa-money"></i> Pay</a>
                                                                <?php
                                                            }
                                                            }
                                                            ?>




                                                        </div>        
                                                    </td>


                                                </tr>

                                                <?php
                                                if (!empty($fee_value->amount_detail)) {

                                                    $fee_deposits = json_decode(($fee_value->amount_detail));

                                                    foreach ($fee_deposits as $fee_deposits_key => $fee_deposits_value) {
                                                        ?>
                                                        <tr class="white-td">
                                                            <td align="left"></td>
                                                            <td align="left"></td>
                                                            <td align="left"></td>
                                                            <td align="left"></td>
                                                            <td class="text-right"><img src="<?php echo base_url(); ?>backend/images/table-arrow.png" alt="" /></td>
                                                            <td class="text text-left">


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
                                                            <td class="text text-left"><?php echo $fee_deposits_value->payment_mode; ?></td>
                                                            <td class="text text-left">

                                                                <?php echo date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($fee_deposits_value->date)); ?>
                                                            </td>
                                                            <td class="text text-right"><?php echo ( number_format($fee_deposits_value->amount_discount, 2, '.', '')); ?></td>
                                                            <td class="text text-right"><?php echo ( number_format($fee_deposits_value->amount_fine, 2, '.', '')); ?></td>
                                                            <td class="text text-right"><?php echo ( number_format($fee_deposits_value->amount, 2, '.', '')); ?></td>
                                                            <td></td>


                                                            <td class="text text-right">

                                                            </td>
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
                                                                if ($discount_value['student_fees_discount_description'] == "") {
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
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                        ?>
                                        <tr class="box box-solid total-bg">
                                            <td align="left" ></td>
                                            <td align="left" ></td>
                                            <td align="left" ></td>
                                            <td align="left" class="text text-left" ><?php echo $this->lang->line('grand_total'); ?></td>
                                            <td class="text text-right"><?php
                                                echo ($currency_symbol . number_format($total_amount, 2, '.', ''));
                                                ?></td>
                                            <td class="text text-left"></td>
                                            <td class="text text-left"></td>
                                            <td class="text text-left"></td>

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
                                            <td class="text text-right"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>  
                            <?php
                        }
                        ?>

                    </div>
                </div>
            </div>
        </div>
</div>
</section>
</div>

<script>
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
</script>