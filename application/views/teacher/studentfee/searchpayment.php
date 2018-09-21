<?php
$currency_symbol = $this->customlib->getSchoolCurrencyFormat();
?>
<div class="content-wrapper" style="min-height: 946px;">    
    <section class="content-header">
        <h1>
            <i class="fa fa-money"></i> <?php echo $this->lang->line('fees_collection'); ?></h1>
    </section>  
    <section class="content">
        <div class="row">
            <div class="col-md-12"> 
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-search"></i>                           
                            <?php echo $this->lang->line('search'); ?>
                            <?php echo $this->lang->line('fees'); ?>
                            <?php echo $this->lang->line('payment'); ?>
                        </h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <form role="form" action="<?php echo site_url('teacher/studentfee/searchpayment') ?>" method="post" class="form-inline">
                                    <?php echo $this->customlib->getCSRF(); ?>
                                    <div class="form-group">
                                        <div class="col-sm-">
                                            <label><?php echo $this->lang->line('payment_id'); ?>
                                            </label>
                                            <input autofocus="" id="paymentid" name="paymentid" placeholder="" type="text" class="form-control date"  value="<?php echo set_value('paymentid'); ?>"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-3">
                                            <button type="submit" name="search" value="search_filter" class="btn btn-primary btn-sm checkbox-toggle"><i class="fa fa-search"></i> <?php echo $this->lang->line('search'); ?></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div> 
                </div>
                <?php if (isset($expenseList) || isset($feeList)) {
                    ?>
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-money"></i> <?php echo $this->lang->line('payment_id_detail'); ?></h3>
                            <div class="box-tools pull-right">
                            </div>
                        </div>
                        <div class="box-body table-responsive">
                            <h4 class="text text-left"><b><?php echo $this->lang->line('class_fees_detail'); ?>  </b></h4><hr/>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('payment_id'); ?></th>
                                        <th><?php echo $this->lang->line('date'); ?></th>
                                        <th><?php echo $this->lang->line('name'); ?></th>
                                        <th><?php echo $this->lang->line('class'); ?></th>
                                        <th><?php echo $this->lang->line('fee_type'); ?></th>
                                        <th><?php echo $this->lang->line('mode'); ?></th>
                                        <th class="text text-right"><?php echo $this->lang->line('fees'); ?></th>
                                        <th class="text text-right"><?php echo $this->lang->line('discount'); ?></th>
                                        <th class="text text-right"><?php echo $this->lang->line('fine'); ?></th>
                                        <th class="text text-right"><?php echo $this->lang->line('amount'); ?></th>
                                        <th class="pull-right"><?php echo $this->lang->line('action'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $amount = 0;
                                    $discount = 0;
                                    $fine = 0;
                                    $total = 0;
                                    $grd_total = 0;
                                    if (empty($feeList)) {
                                        ?>
                                        <tr>
                                            <td colspan="11" class="text-danger text-center">
                                                <?php echo $this->lang->line('no_transaction_found'); ?>
                                            </td>
                                        </tr>
                                        <?php
                                    } else {
                                        $count = 1;
                                        foreach ($feeList as $key => $value) {
                                            $amount = $amount + $value['amount'];
                                            $discount = $discount + $value['amount_discount'];
                                            $fine = $fine + $value['amount_fine'];
                                            $total = ($amount + $fine) - $discount;
                                            ?>
                                            <tr>
                                                <td>
                                                    <?php echo $value['student_fee_id']; ?>
                                                </td>
                                                <td>
                                                    <?php echo date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($value['date'])); ?>
                                                </td>
                                                <td>
                                                    <?php echo $value['firstname'] . " " . $value['lastname']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $value['class'] . " (" . $value['section'] . ")"; ?>
                                                </td>
                                                <td> <?php echo $value['type']; ?>    </td>
                                                <td> <?php echo $value['payment_mode']; ?>    </td>
                                                <td class="text text-right">
                                                    <?php echo ($currency_symbol . $value['amount']); ?>
                                                </td>
                                                <td class="text text-right">
                                                    <?php echo ($currency_symbol . $value['amount_discount']); ?>
                                                </td>
                                                <td class="text text-right">
                                                    <?php echo ($currency_symbol . $value['amount_fine']); ?>
                                                </td>
                                                <td class="text text-right">
                                                    <?php
                                                    $t = ($value['amount'] + $value['amount_fine']) - $value['amount_discount'];
                                                    $tm = number_format($t, 2, '.', '');
                                                    echo $currency_symbol . $tm;
                                                    ?>
                                                </td>
                                                <td class="pull-right">
                                                    <a href="<?php echo base_url() ?>teacher/studentfee/addfee/<?php echo $value['id'] ?>" class="btn btn-primary btn-xs" data-toggle="tooltip" title="<?php echo $this->lang->line('view'); ?>" data-original-title="<?php echo $this->lang->line('view'); ?>">
                                                        <i class="fa fa-list-alt"></i> <?php echo $this->lang->line('view'); ?>
                                                    </a>
                                                </td>
                                            </tr>
                                            <?php
                                            $count++;
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <h4 class="text text-left"><b><?php echo $this->lang->line('transport_fees_details'); ?></b></h4><hr/>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('payment_id'); ?></th>
                                        <th><?php echo $this->lang->line('date'); ?></th>
                                        <th><?php echo $this->lang->line('name'); ?></th>
                                        <th><?php echo $this->lang->line('class'); ?></th>
                                        <th><?php echo $this->lang->line('fee_type'); ?></th>
                                        <th><?php echo $this->lang->line('mode'); ?></th>
                                        <th class="text text-right"><?php echo $this->lang->line('fees'); ?></th>
                                        <th class="text text-right"><?php echo $this->lang->line('discount'); ?></th>
                                        <th class="text text-right"><?php echo $this->lang->line('fine'); ?></th>
                                        <th class="text text-right"><?php echo $this->lang->line('amount'); ?></th>
                                        <th class="pull-right"><?php echo $this->lang->line('action'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $count = 1;
                                    $grand_total = 0;
                                    if (empty($expenseList)) {
                                        ?>
                                        <tr>
                                            <td colspan="11" class="text-danger text-center"><?php echo $this->lang->line('no_transaction_found'); ?></td>
                                        </tr>
                                        <?php
                                    } else {
                                        $grand_total = $grand_total + ($expenseList['amount'] + $expenseList['amount_fine']);
                                        ?>
                                        <tr>
                                            <td> <?php echo $expenseList['payment_id']; ?>     </td>
                                            <td>
                                                <?php echo date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($expenseList['date'])); ?>
                                            </td>

                                            <td>
                                                <?php echo $expenseList['firstname'] . " " . $expenseList['lastname']; ?>
                                            </td>
                                            <td>
                                                <?php echo $expenseList['class'] . " (" . $expenseList['section'] . ")"; ?>
                                            </td>

                                            <td>
                                                <?php echo $this->lang->line('Transport'); ?>
                                            </td>

                                            <td> <?php echo $expenseList['payment_mode']; ?>     </td>
                                            <td class="text text-right">
                                                <?php echo ($currency_symbol . $expenseList['amount']); ?>
                                            </td>

                                            <td class="text text-right">
                                                <?php echo ($currency_symbol . $expenseList['amount_discount']); ?>
                                            </td>
                                            <td class="text text-right">
                                                <?php echo ($currency_symbol . $expenseList['amount_fine']); ?>
                                            </td>
                                            <td class="text text-right">
                                                <?php
                                                $t = ($expenseList['amount'] + $expenseList['amount_fine']) - $expenseList['amount_discount'];
                                                $tm = number_format($t, 2, '.', '');
                                                echo $currency_symbol . $tm;
                                                ?>
                                            </td>
                                            <td class="pull-right">
                                                <a href="<?php echo base_url() ?>teacher/studentfee/addfee/<?php echo $expenseList['id'] ?>" class="btn btn-primary btn-xs" data-toggle="tooltip" title="" data-original-title="<?php echo $this->lang->line('cancel'); ?>">
                                                    <i class="fa fa-list-alt"></i> <?php echo $this->lang->line('view'); ?>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php
                                        $count++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="box-footer">
                            <div class="mailbox-controls">                             
                                <div class="pull-right">
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </section>
</div>