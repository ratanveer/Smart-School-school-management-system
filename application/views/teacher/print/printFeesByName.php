<?php $currency_symbol = $this->customlib->getSchoolCurrencyFormat(); ?>
<style type="text/css">
    @media print {
        .col-sm-1, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-10, .col-sm-11, .col-sm-12 {
            float: left;
        }
        .col-sm-12 {
            width: 100%;
        }
        .col-sm-11 {
            width: 91.66666667%;
        }
        .col-sm-10 {
            width: 83.33333333%;
        }
        .col-sm-9 {
            width: 75%;
        }
        .col-sm-8 {
            width: 66.66666667%;
        }
        .col-sm-7 {
            width: 58.33333333%;
        }
        .col-sm-6 {
            width: 50%;
        }
        .col-sm-5 {
            width: 41.66666667%;
        }
        .col-sm-4 {
            width: 33.33333333%;
        }
        .col-sm-3 {
            width: 25%;
        }
        .col-sm-2 {
            width: 16.66666667%;
        }
        .col-sm-1 {
            width: 8.33333333%;
        }
        .col-sm-pull-12 {
            right: 100%;
        }
        .col-sm-pull-11 {
            right: 91.66666667%;
        }
        .col-sm-pull-10 {
            right: 83.33333333%;
        }
        .col-sm-pull-9 {
            right: 75%;
        }
        .col-sm-pull-8 {
            right: 66.66666667%;
        }
        .col-sm-pull-7 {
            right: 58.33333333%;
        }
        .col-sm-pull-6 {
            right: 50%;
        }
        .col-sm-pull-5 {
            right: 41.66666667%;
        }
        .col-sm-pull-4 {
            right: 33.33333333%;
        }
        .col-sm-pull-3 {
            right: 25%;
        }
        .col-sm-pull-2 {
            right: 16.66666667%;
        }
        .col-sm-pull-1 {
            right: 8.33333333%;
        }
        .col-sm-pull-0 {
            right: auto;
        }
        .col-sm-push-12 {
            left: 100%;
        }
        .col-sm-push-11 {
            left: 91.66666667%;
        }
        .col-sm-push-10 {
            left: 83.33333333%;
        }
        .col-sm-push-9 {
            left: 75%;
        }
        .col-sm-push-8 {
            left: 66.66666667%;
        }
        .col-sm-push-7 {
            left: 58.33333333%;
        }
        .col-sm-push-6 {
            left: 50%;
        }
        .col-sm-push-5 {
            left: 41.66666667%;
        }
        .col-sm-push-4 {
            left: 33.33333333%;
        }
        .col-sm-push-3 {
            left: 25%;
        }
        .col-sm-push-2 {
            left: 16.66666667%;
        }
        .col-sm-push-1 {
            left: 8.33333333%;
        }
        .col-sm-push-0 {
            left: auto;
        }
        .col-sm-offset-12 {
            margin-left: 100%;
        }
        .col-sm-offset-11 {
            margin-left: 91.66666667%;
        }
        .col-sm-offset-10 {
            margin-left: 83.33333333%;
        }
        .col-sm-offset-9 {
            margin-left: 75%;
        }
        .col-sm-offset-8 {
            margin-left: 66.66666667%;
        }
        .col-sm-offset-7 {
            margin-left: 58.33333333%;
        }
        .col-sm-offset-6 {
            margin-left: 50%;
        }
        .col-sm-offset-5 {
            margin-left: 41.66666667%;
        }
        .col-sm-offset-4 {
            margin-left: 33.33333333%;
        }
        .col-sm-offset-3 {
            margin-left: 25%;
        }
        .col-sm-offset-2 {
            margin-left: 16.66666667%;
        }
        .col-sm-offset-1 {
            margin-left: 8.33333333%;
        }
        .col-sm-offset-0 {
            margin-left: 0%;
        }
        .visible-xs {
            display: none !important;
        }
        .hidden-xs {
            display: block !important;
        }
        table.hidden-xs {
            display: table;
        }
        tr.hidden-xs {
            display: table-row !important;
        }
        th.hidden-xs,
        td.hidden-xs {
            display: table-cell !important;
        }
        .hidden-xs.hidden-print {
            display: none !important;
        }
        .hidden-sm {
            display: none !important;
        }
        .visible-sm {
            display: block !important;
        }
        table.visible-sm {
            display: table;
        }
        tr.visible-sm {
            display: table-row !important;
        }
        th.visible-sm,
        td.visible-sm {
            display: table-cell !important;
        }
    }
</style>
<html lang="en">
    <head>
        <title><?php echo $this->lang->line('fees_receipt'); ?></title>
        <link rel="stylesheet" href="<?php echo base_url(); ?>backend/bootstrap/css/bootstrap.min.css"> 
        <link rel="stylesheet" href="<?php echo base_url(); ?>backend/dist/css/AdminLTE.min.css">
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div id="content" class="col-lg-12 col-sm-12 ">
                    <div class="invoice">
                        <div class="row header text-center">
                            <div class="col-sm-2">
                                <img style="height:70px; " src="<?php echo base_url(); ?>/uploads/school_content/logo/<?php echo $settinglist[0]['image']; ?>">
                            </div>
                            <div class="col-sm-8">
                                <strong style="font-size: 20px;"><?php echo $settinglist[0]['name']; ?></strong><br>
                                <?php echo $settinglist[0]['address']; ?>
                                <?php echo $this->lang->line('phone'); ?>: <?php echo $settinglist[0]['phone']; ?><br>
                            </div>
                        </div>
                        <div class="row">                          
                            <div class="col-xs-6">
                                <br/>
                                <address>
                                    <strong><?php echo $student['firstname'] . " " . $student['lastname']; ?></strong><br>

                                    Father Name: <?php echo $student['guardian_name']; ?><br>
                                    <?php echo $this->lang->line('class'); ?>: <?php echo $student['class'] . " (" . $student['section'] . ")" ?>
                                </address>
                            </div>
                            <div class="col-xs-6 text-right">
                                <br/>
                                <address>
                                    <strong>Date: <?php echo date('d-m-Y'); ?></strong><br/>
                                    <strong>Receipt no: <?php echo $receipt_no; ?></strong>

                                </address>                               
                            </div>
                        </div>
                        <hr style="margin-top: 0px;margin-bottom: 0px;" />
                        <div class="row">
                            <?php
                            if (!empty($monthly_record)) {
                                ?>
                                <table class="table table-striped table-bordered table-hover example" style="font-size: 8pt;">
                                    <thead>
                                        <tr>
                                            <th><?php echo $this->lang->line('payment_id'); ?></th>
                                            <th><?php echo $this->lang->line('date'); ?></th>
                                            <th><?php echo $this->lang->line('fees_type'); ?></th>
                                            <th><?php echo $this->lang->line('mode'); ?></th>
                                            <th><?php echo $this->lang->line('status'); ?></th>
                                            <th class="center"><?php echo $this->lang->line('amount'); ?></th>
                                            <th class="right"><?php echo $this->lang->line('fine'); ?></th>
                                            <th class="right"><?php echo $this->lang->line('discount'); ?></th>
                                            <th class="right"><?php echo $this->lang->line('total'); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $target_amount = "0";
                                        $deposite_amount = "0";
                                        $fine_amount = "0";
                                        $discount_amount = "0";
                                        $total_paid_amount = "0";
                                        foreach ($monthly_record as $key => $fee) {
                                            $target_amount = $target_amount + $fee['amount'];
                                            $cls = "";
                                            $total_row = "xxx";
                                            $payment_status = $this->lang->line('paid');
                                            if ($fee['date'] == "xxx") {
                                                $cls = "text-red";
                                                $payment_status = $this->lang->line('unpaid');
                                            } else {
                                                $fine_amount = $fine_amount + $fee['fine'];
                                                $discount_amount = $discount_amount + $fee['discount'];
                                                $total_row = number_format(($fee['amount'] - $fee['discount']) + $fee['fine'], 2, '.'
                                                        , '');
                                                $total_paid_amount = $total_paid_amount + $total_row;
                                            }
                                            ?>
                                            <tr>
                                                <td>
                                                    <a href="#" class="<?php echo $cls; ?>"><?php echo $fee['invoiceno']; ?></a></td>
                                                <td class="<?php echo $cls; ?>" style="width:100px"><?php
                                                    if ($fee['date'] == "xxx") {
                                                        echo "xxx";
                                                    } else {
                                                        echo date('d-m-Y', $this->customlib->dateyyyymmddTodateformat($fee['date']));
                                                    }
                                                    ?></td>
                                                <td><?php echo $fee['type']; ?></td>
                                                <td><?php echo $fee['payment_mode']; ?></td>
                                                <td><?php echo $payment_status; ?></td>
                                                <td><?php echo $currency_symbol . $fee['amount']; ?></td>
                                                <td class="<?php echo $cls; ?>"><?php echo $currency_symbol . $fee['fine']; ?></td>
                                                <td class="<?php echo $cls; ?>"><?php echo $currency_symbol . $fee['discount']; ?></td>
                                                <td class="<?php echo $cls; ?>"><?php echo $currency_symbol . $total_row; ?></td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                        <tr>
                                            <td colspan="5" class="text-right"><?php echo $this->lang->line('total'); ?>: </td>
                                            <td>
                                                <?php echo $currency_symbol . $ttm = number_format($target_amount, 2, '.', ''); ?>
                                            </td>
                                            <td>
                                                <?php echo $currency_symbol . $fm = number_format($fine_amount, 2, '.', ''); ?>
                                            </td>
                                            <td>
                                                <?php echo $currency_symbol . $dm = number_format($discount_amount, 2, '.', ''); ?>
                                            </td>
                                            <td>
                                                <?php echo $currency_symbol . $tpa = number_format($total_paid_amount, 2, '.', ''); ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <?php
                            }
                            ?>
                            <?php
                            if (!empty($transport_record)) {
                                ?>
                                <table class="table table-striped table-bordered table-hover example2" style="font-size: 8pt;">
                                    <thead>
                                        <tr>
                                            <th><?php echo $this->lang->line('payment_id'); ?></th>
                                            <th><?php echo $this->lang->line('date'); ?></th>
                                            <th><?php echo $this->lang->line('fees_type'); ?></th>
                                            <th><?php echo $this->lang->line('mode'); ?></th>
                                            <th class="center"><?php echo $this->lang->line('amount'); ?></th>
                                            <th class="right"><?php echo $this->lang->line('fine'); ?></th>
                                            <th class="right"><?php echo $this->lang->line('total'); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $cls = "";
                                        $transport_target_amount = "0";
                                        $transport_deposite_amount = "0";
                                        $transport_fine_amount = "0";
                                        $transport_discount_amount = "0";
                                        $transport_total_paid_amount = "0";
                                        $transport_total_paid_amount = "0";
                                        foreach ($transport_record as $key => $fee) {
                                            $transport_target_amount = $transport_target_amount + $fee['amount'];
                                            $transport_fine_amount = $transport_fine_amount + $fee['amount_fine'];
                                            $transport_discount_amount = $transport_discount_amount + $fee['amount_discount'];
                                            $transport_total_row = number_format(($fee['amount'] - $fee['amount_discount']) + $fee['amount_fine'], 2, '.', '');
                                            $transport_total_paid_amount = $transport_total_paid_amount + $transport_total_row;
                                            ?>
                                            <tr>
                                                <td>
                                                    <a href="#" class="<?php echo $cls; ?>"><?php echo $fee['id']; ?></a></td>
                                                <td class="<?php echo $cls; ?>" style="width:100px"><?php echo date('d-m-Y', $this->customlib->dateyyyymmddTodateformat($fee['date'])); ?></td>
                                                <td>Transport</td>
                                                <td><?php echo $fee['payment_mode']; ?></td>
                                                <td><?php echo $currency_symbol . $fee['amount']; ?></td>
                                                <td class="<?php echo $cls; ?>"><?php echo $currency_symbol . $fee['amount_fine']; ?></td>
                                                <td class="<?php echo $cls; ?>"><?php echo $currency_symbol . $transport_total_row; ?></td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                        <tr>
                                            <td colspan="4" class="text-right"><?php echo $this->lang->line('total'); ?>: </td>
                                            <td>
                                                <?php
                                                $ttm = number_format($transport_target_amount, 2, '.', '');
                                                echo $currency_symbol . $ttm;
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                $nf = number_format($transport_fine_amount, 2, '.', '');
                                                echo $currency_symbol . $nf;
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                $ttpa = number_format($transport_total_paid_amount, 2, '.', '');
                                                echo $currency_symbol . $ttpa;
                                                ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div> 
            </div>
        </div>
        <div class="clearfix"></div>
        <footer>
        </footer>
    </body>
</html>