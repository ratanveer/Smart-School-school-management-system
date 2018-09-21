<?php
$currency_symbol = $this->customlib->getSchoolCurrencyFormat();
?>
<div class="content-wrapper" style="min-height: 946px;">  
    <section class="content-header">
        <h1>
            <i class="fa fa-line-chart"></i> <?php echo $this->lang->line('reports'); ?> <small> </small>        </h1>
    </section>   
    <section class="content">
        <div class="row"> 
            <div class="col-md-12">  
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-search"></i> <?php echo $this->lang->line('search_transaction'); ?></h3>
                    </div>
                    <div class="box-body">
                        <div class="">
                            <div class="col-md-12">
                                <form role="form" action="<?php echo site_url('teacher/transaction/searchtransaction') ?>" method="post" class="form-horizontal">
                                    <?php echo $this->customlib->getCSRF(); ?>
                                    <div class="form-group">
                                        <div class="col-sm-6">
                                            <label><?php echo $this->lang->line('date_from'); ?></label>
                                            <input autofocus="" id="datefrom"  name="date_from" placeholder="" type="text" class="form-control date"  value="<?php echo set_value('date_from', date($this->customlib->getSchoolDateFormat())); ?>" readonly="readonly"/>
                                            <span class="text-danger"><?php echo form_error('class_id'); ?></span>
                                        </div>
                                        <div class="col-sm-6">
                                            <label><?php echo $this->lang->line('date_to'); ?></label>
                                            <input id="dateto" name="date_to" placeholder="" type="text" class="form-control date"  value="<?php echo set_value('date_to', date($this->customlib->getSchoolDateFormat())); ?>" readonly="readonly"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <button type="submit" name="search" value="search_filter" class="btn btn-primary btn-sm checkbox-toggle pull-right"><i class="fa fa-search"></i><?php echo $this->lang->line('search'); ?></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if (isset($expenseList) && isset($feeList)) {
                    ?>
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-money"></i> <?php echo $exp_title; ?></h3>
                            <div class="box-tools pull-right">
                                <a href="<?php echo base_url(); ?>report/transactionSearch?datefrom=<?php echo set_value('date_from', date($this->customlib->getSchoolDateFormat())); ?>&dateto=<?php echo set_value('date_to', date($this->customlib->getSchoolDateFormat())) ?>" class="btn bg-orange pull-right" style="margin-right: 5px;"><i class="fa fa-download"></i> <?php echo $this->lang->line('download_pdf'); ?></a></div>
                        </div>
                        <div class="box-body table-responsive">
                            <h4 class="text text-left"><b><?php echo $this->lang->line('fees_collection_details'); ?></b></h4><hr/>

                            <table class="table no-margin">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('payment_id'); ?></th>
                                        <th><?php echo $this->lang->line('date'); ?></th>
                                        <th><?php echo $this->lang->line('name'); ?></th>
                                        <th><?php echo $this->lang->line('class'); ?></th>
                                        <th><?php echo $this->lang->line('fee_type'); ?></th>
                                        <th class="text text-right"><?php echo $this->lang->line('fees'); ?></th>
                                        <th class="text text-right"><?php echo $this->lang->line('discount'); ?></th>
                                        <th class="text text-right"><?php echo $this->lang->line('fine'); ?></th>
                                        <th class="text text-right"><?php echo $this->lang->line('amount'); ?></th>
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
                                            <td colspan="11" class="text-danger text-center"><?php echo $this->lang->line('no_transaction_found'); ?></td>
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
                                                    <?php echo $value['id']; ?>
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
                                                <td>
                                                    <?php echo $value['type']; ?>
                                                </td>
                                                <td class="text text-right">
                                                    <?php echo ($currency_symbol . $value['amount']); ?>
                                                </td>
                                                <td class="text text-right">
                                                    <?php echo $value['amount_discount']; ?>
                                                </td>
                                                <td class="text text-right">
                                                    <?php echo ($currency_symbol . $value['amount_fine']); ?>
                                                </td>
                                                <td class="text text-right">
                                                    <?php
                                                    $t = ($value['amount'] + $value['amount_fine']) - $value['amount_discount'];
                                                    echo ($currency_symbol . number_format($t, 2, '.', ''))
                                                    ?>
                                                </td>
                                            </tr>
                                            <?php
                                            $count++;
                                        }
                                    }
                                    ?>
                                    <tr ><th colspan="5" class="text-right"><?php echo $this->lang->line('grand_total'); ?> </th>
                                        <th class="text text-right"><?php echo ($currency_symbol . number_format($amount, 2, '.', '')); ?></th>
                                        <th class="text text-right"><?php echo ($currency_symbol . number_format($discount, 2, '.', '')); ?></th>
                                        <th class="text text-right"><?php echo ($currency_symbol . number_format($fine, 2, '.', '')); ?></th>
                                        <th class="text text-right"><?php echo ($currency_symbol . number_format($total, 2, '.', '')); ?></th></tr>
                                </tbody>
                            </table>
                            <h4 class="text text-left"><b><?php echo $this->lang->line('expense_detail'); ?></b></h4><hr/>
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('expense_id'); ?></th>
                                        <th><?php echo $this->lang->line('date'); ?></th>
                                        <th><?php echo $this->lang->line('expense_head'); ?></th>
                                        <th><?php echo $this->lang->line('name'); ?></th>
                                        <th class="text text-right"><?php echo $this->lang->line('amount'); ?></th>
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
                                        foreach ($expenseList as $key => $value) {

                                            $grand_total = $grand_total + $value['amount'];
                                            ?>
                                            <tr>
                                                <td>
                                                    <?php echo $value['id']; ?>
                                                </td>
                                                <td>
                                                    <?php echo date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($value['date'])); ?>
                                                </td>
                                                <td>
                                                    <?php echo $value['exp_category']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $value['name']; ?>
                                                </td>

                                                <td class="text text-right">

                                                    <?php echo ($currency_symbol . $value['amount']); ?>
                                                </td>
                                            </tr>
                                            <?php
                                            $count++;
                                        }
                                    }
                                    ?>
                                    <tr>
                                        <th colspan="4" class="text-right"><?php echo $this->lang->line('grand_total'); ?></th>
                                        <th class="text text-right">
                                            <?php echo ($currency_symbol . number_format($grand_total, 2, '.', '')); ?>
                                        </th>
                                    </tr>
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

<script type="text/javascript">
    $(document).ready(function () {
        var date_format = '<?php echo $result = strtr($this->customlib->getSchoolDateFormat(), ['d' => 'dd', 'm' => 'mm', 'Y' => 'yyyy',]) ?>';
        $(".date").datepicker({
            format: date_format,
            autoclose: true,
            todayHighlight: true
        });
    });
</script>