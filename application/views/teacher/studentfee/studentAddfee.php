<?php
$currency_symbol = $this->customlib->getSchoolCurrencyFormat();
?>
<div class="content-wrapper">   
    <section class="content-header">
        <h1>
            <i class="fa fa-money"></i> <?php echo $this->lang->line('fees_collection'); ?><small><?php echo $this->lang->line('student_fee'); ?></small>        </h1>
    </section>   
    <section class="content">
        <div class="row">          
            <div class="col-md-12">              
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">  <?php echo $currency_symbol; ?> <?php echo $this->lang->line('add_fees'); ?></h3>
                        <div class="box-tools pull-right">
                            <div class="btn-group">
                                <a href="<?php echo base_url() ?>teacher/studentfee" type="button" class="btn btn-primary btn-xs">
                                    <i class="fa fa-arrow-left"></i> <?php echo $this->lang->line('back'); ?></a>
                            </div>
                        </div>
                        <div class="box-body">
                            <br/>
                            <div class="col-md-2">
                                <img width="115" height="115" class="img-thumbnail" src="<?php echo base_url() . $student['image'] ?>" alt="No Image">
                            </div>
                            <div class="col-md-10">
                                <table class="table table-striped">
                                    <tbody>
                                        <tr>
                                            <th><?php echo $this->lang->line('name'); ?></th>
                                            <td><?php echo $student['firstname'] . " " . $student['lastname'] ?></td>
                                    <div class="col-md-5">
                                        <th><?php echo $this->lang->line('class_section'); ?></th>
                                        <td><?php echo $student['class'] . " (" . $student['section'] . ")" ?> </td>
                                        </tr>
                                        <tr>
                                            <th><?php echo $this->lang->line('father_name'); ?></th>
                                            <td><?php echo $student['father_name']; ?></td>

                                            <th><?php echo $this->lang->line('admission_no'); ?></th>
                                            <td><?php echo $student['admission_no']; ?></td>
                                        </tr>
                                        <tr>
                                            <th><?php echo $this->lang->line('mobile_no'); ?></th>
                                            <td><?php echo $student['mobileno']; ?></td>

                                            <th><?php echo $this->lang->line('roll_no'); ?></th>
                                            <td> <?php echo $student['roll_no']; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th><?php echo $this->lang->line('category'); ?></th>
                                            <td>
                                                <?php
                                                foreach ($categorylist as $value) {
                                                    if ($student['category_id'] == $value['id']) {
                                                        echo $value['category'];
                                                    }
                                                }
                                                ?> 
                                            </td>
                                            <th><?php echo $this->lang->line('rte'); ?></th>
                                            <td><b class="text-danger"> <?php echo $student['rte']; ?> </b>
                                            </td>
                                        </tr>
                                        <tr>
                                        </tr>
                                        <tr>
                                        </tr>
                                        <tr>
                                        </tr>
                                        </tbody>
                                </table>
                            </div>
                            <div class="col-md-5">
                                <table class="table table-striped table-hover" style="display: none">
                                    <tbody>
                                        <tr>
                                            <th><?php echo $this->lang->line('gross_fees'); ?></th>
                                            <td><?php echo $student['admission_no']; ?></td>
                                        </tr>
                                        <tr>
                                            <th><?php echo $this->lang->line('admission_discount'); ?></th>
                                            <td><?php echo $student['fees_discount']; ?> </td>
                                        </tr>
                                        <tr>
                                            <th><?php echo $this->lang->line('paid_fees'); ?></th>
                                            <td><?php echo $student['roll_no']; ?></td>
                                        </tr>
                                        <tr>
                                            <th><span class="text text-danger"><?php echo $this->lang->line('balance_fees'); ?></span></th>
                                            <td><span class="text text-danger"><?php echo $student['class'] . " (" . $student['section'] . ")" ?></span> </td>
                                        </tr>

                                    </tbody></table>
                            </div>
                        </div>
                    </div> 
                </div>
            </div>
    </section>
    <div class="col-md-12">       
        <div class="box box-info">
            <section style="margin: 10px 15px;">               
                <div class="row no-print">
                    <div class="col-xs-12">
                        <a href="#"  class="btn btn-xs btn-info printDoc"><i class="fa fa-print"></i> <?php echo $this->lang->line('print_selected'); ?> </a>
                        <span class="pull-right"><?php echo $this->lang->line('date'); ?>: <?php echo date($this->customlib->getSchoolDateFormat()); ?></span>
                    </div>
                </div>               
                <div class="row">
                    <div class="col-xs-12 table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th><?php echo $this->lang->line('payment_id'); ?></th>
                                    <th><?php echo $this->lang->line('date'); ?></th>
                                    <th><?php echo $this->lang->line('category'); ?></th>
                                    <th><?php echo $this->lang->line('type'); ?></th>
                                    <th class="text text-center"><?php echo $this->lang->line('mode'); ?></th>
                                    <th class="text text-center"><?php echo $this->lang->line('status'); ?></th>
                                    <th  class="text text-right"><?php echo $this->lang->line('amount'); ?></th>
                                    <th  class="text text-right"><?php echo $this->lang->line('fine'); ?></th>
                                    <th class="text text-right" ><?php echo $this->lang->line('discount'); ?></th>
                                    <th class="text text-right" ><?php echo $this->lang->line('total'); ?></th>
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
                                        <td >
                                            <label><input class="checkbox" type="checkbox" name="fee_checkbox" value="<?php echo $fee['feemastersid']; ?>" data-category="fees"></label>
                                        </td>

                                        <td>
                                            <?php
                                            if ($fee['invoiceno'] == "xxx") {
                                                ?>
                                                <a href="#" class="<?php echo $cls; ?>"><?php echo $fee['invoiceno']; ?></a>
                                                <?php
                                            } else {
                                                ?>
                                                <a href="#" data-toggle="popover" class="detail_popover" ><?php echo $fee['invoiceno'] ?></a>
                                                <div class="fee_detail_popover" style="display: none">
                                                    <?php
                                                    if ($fee['description'] == "") {
                                                        ?>
                                                        <p class="text text-danger"><?php echo $this->lang->line('no_description'); ?></p>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <p class="text text-info"><?php echo $fee['description']; ?></p>
                                                        <?php
                                                    }
                                                    ?>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </td>
                                        <td class="<?php echo $cls; ?>"><?php
                                            if ($fee['date'] != "xxx") {
                                                echo date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($fee['date']));
                                            } else {
                                                echo $fee['date'];
                                            }
                                            ?></td>
                                        <td><?php echo $fee['category']; ?></td>
                                        <td><?php echo $fee['type']; ?></td>
                                        <td  class="<?php echo $cls; ?> text text-center"><?php echo $fee['payment_mode']; ?></td>
                                        <td class="text text-center"><?php echo $payment_status; ?></td>
                                        <td class="text text-right"><?php echo ($currency_symbol . $fee['amount']); ?></td>
                                        <td class="<?php echo $cls; ?> text text-right"><?php echo ($currency_symbol . $fee['fine']); ?></td>
                                        <td class="<?php echo $cls; ?> text text-right"><?php echo ($currency_symbol . $fee['discount']); ?></td>
                                        <td class="<?php echo $cls; ?> text text-right"><?php echo ($currency_symbol . $total_row); ?></td>
                                        <td class="<?php echo $cls; ?> text text-right"><?php
                                            if ($fee['date'] == "xxx") {
                                                ?>
                                                <button type="button" data-student-session-id="<?php echo $student['student_session_id'] ?>" data-amount="<?php echo $fee['amount'] ?>" data-type="<?php echo $fee['type'] ?>" data-category="<?php echo $fee['category']; ?>" data-feemasterid="<?php echo $fee['feemastersid']; ?>" class="btn btn-xs btn-primary pull-right myCollectFeeBtn"><i class="fa fa-plus-circle"></i>  <?php echo $this->lang->line('add_fees'); ?></button>
                                                <?php
                                            } else {
                                                ?>
                                                <button type="button" data-student-session-id="<?php echo $student['student_session_id'] ?>" data-feepaymentid="<?php echo $fee['invoiceno']; ?>"   class="btn btn-xs btn-warning pull-right revert-fee"> <i class="fa fa-undo"> </i>  <?php echo $this->lang->line('revert'); ?> </button>
                                                <?php
                                            }
                                            ?></td>
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
                                        <th><?php echo $this->lang->line('total_paid_fees'); ?> :</th>
                                        <td><?php echo ($currency_symbol . number_format($deposite_amount, 2, '.', '')); ?></td>
                                    </tr>                  
                                    <tr>
                                        <th><?php echo $this->lang->line('total_balance'); ?> :</th>
                                        <td><?php echo $currency_symbol . number_format(($target_amount - $deposite_amount), 2, '.', ''); ?></td>
                                    </tr>
                                </tbody></table>
                        </div>
                    </div>
                </div>              
                <?php
                $total_fee_remain = $student['transport_fees'];
                if ($total_fee_remain != '0.00' || $total_fee_remain != '0') {
                    ?>
                    <div class="row">
                        <div class="col-xs-12 table-responsive">
                            <h4 class="">
                                <i class="fa fa-bus"></i> <?php echo $this->lang->line('transport_fees'); ?>
                                <button type="button" data-student-session-id="<?php echo $student['student_session_id'] ?>" class="btn btn-xs btn-primary pull-right myTransportFeeBtn"><i class="fa fa-plus-circle"></i>  <?php echo $this->lang->line('collect_transport_fees'); ?> </button>
                            </h4>
                            <br/>
                            <br/>
                            <?php
                            $tot_trans_fee = 0;
                            if (empty($transport_fee)) {
                                ?>
                                <div class="alert alert-danger">
                                    <?php echo $this->lang->line('no_transport_fees_found'); ?>
                                </div>
                                <?php
                            } else {
                                ?>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th><?php echo $this->lang->line('payment_id'); ?></th>
                                            <th><?php echo $this->lang->line('date'); ?></th>
                                            <th class="text text-center"><?php echo $this->lang->line('mode'); ?></th>
                                            <th class="text text-right"><?php echo $this->lang->line('amount'); ?></th>
                                            <th class="text text-right"><?php echo $this->lang->line('fine'); ?></th>
                                            <th class="text text-right"><?php echo $this->lang->line('total'); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $count = 1;
                                        foreach ($transport_fee as $key => $value) {
                                            $tot_trans_fee = $tot_trans_fee + $value['amount'];
                                            ?>
                                            <tr>
                                                <td>
                                                    <label><input data-category="transport" class="checkbox" type="checkbox" name="fee_checkbox" value="<?php echo $value['id'] ?>"></label>
                                                </td>
                                                <td>
                                                    <?php
                                                    if ($value['id'] == "xxx") {
                                                        echo $value['id'];
                                                    } else {
                                                        ?>
                                                        <a href="#" data-toggle="popover" class="detail_popover"><?php echo $value['id'] ?></a>

                                                        <div class="fee_detail_popover" style="display: none">
                                                            <?php
                                                            if ($value['description'] == "") {
                                                                ?>
                                                                <p class="text text-danger"><?php echo $this->lang->line('no_description'); ?></p>
                                                                <?php
                                                            } else {
                                                                ?>
                                                                <p class="text text-info"><?php echo $value['description']; ?></p>
                                                                <?php
                                                            }
                                                            ?>
                                                        </div>
                                                        <?php
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php echo date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($value['date'])); ?>
                                                </td> <td class="text text-center">
                                                    <?php echo $value['payment_mode']; ?>
                                                </td>
                                                <td class="text text-right">
                                                    <?php echo ($currency_symbol . $value['amount']); ?>
                                                </td>
                                                <td class="text text-right">
                                                    <?php echo ($currency_symbol . $value['amount_fine']); ?>
                                                </td>
                                                <td class="text text-right">
                                                    <?php echo $currency_symbol . $total_row = number_format(($value['amount'] + $value['amount_fine']), 2, '.', ''); ?>
                                                </td>
                                                <td>
                                                    <button type="button" data-student-session-id="<?php echo $student['student_session_id'] ?>" data-feepaymentid="<?php echo $value['id']; ?>"  class="btn btn-xs btn-warning pull-right revert-transportfee"><i class="fa fa-undo"></i> <?php echo $this->lang->line('revert'); ?> </button>
                                                </td>
                                            </tr>
                                            <?php
                                            $count++;
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                    <div class="row">                     
                        <div class="col-xs-6">
                        </div>
                        <div class="col-md-6">
                            <p class="lead"><?php echo $this->lang->line('balance_description1'); ?><?php echo $this->lang->line('balance_total'); ?></p>
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th style="width:50%"><?php echo $this->lang->line('total_transport_fees'); ?> :</th>
                                            <td><?php echo $currency_symbol . number_format($student['transport_fees'], 2, '.', ''); ?></td>
                                        </tr>
                                        <tr>
                                            <th><?php echo $this->lang->line('total_paid_fees'); ?> :</th>
                                            <td><?php echo $currency_symbol . number_format($tot_trans_fee, 2, '.', ''); ?></td>
                                        </tr>
                                        <tr>
                                            <th><?php echo $this->lang->line('total_balance'); ?> :</th>
                                            <td><?php echo $currency_symbol . number_format(($student['transport_fees'] - $tot_trans_fee), 2, '.', ''); ?></td>
                                        </tr>
                                    </tbody></table>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </section>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $("#selecctall").change(function () {
            $(".checkbox").prop('checked', $(this).prop("checked"));
        });
    });
    $(document).ready(function () {
        $(".date").datepicker({
            format: date_format,
            autoclose: true,
            todayHighlight: true
        });
    });
</script>
<script type="text/javascript">
    $(".myCollectFeeBtn").click(function () {
        $("span[id$='_error']").html("");
        $('.fees_title').html("");
        $('#amount').val("");
        $('#amount_discount').val("0");
        $('#amount_fine').val("0");
        var type = $(this).data("type");
        var amount = $(this).data("amount");
        var category = $(this).data("category");
        var feemaster = $(this).data("feemasterid");
        var student_session_id = $(this).data("student-session-id");
        $('.fees_title').html("<b>" + category + ":</b> " + type);
        $('.modal_amount').val(amount);
        $('#fee_master_id').val(feemaster);
        $('#student_session_id').val(student_session_id);
        $('#myFeesModal').modal({
            backdrop: 'static',
            keyboard: false,
            show: true
        });
    });

</script>
<div class="modal fade" id="myFeesModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title title text-center fees_title"></h4>
            </div>
            <div class="modal-body">
                <div class="form-horizontal">
                    <div class="box-body">
                        <input  type="hidden" class="form-control" id="guardian_phone"  value="<?php echo $student['guardian_phone'] ?>" readonly="readonly"/>
                        <input  type="hidden" class="form-control" id="fee_master_id"  value="0" readonly="readonly"/>
                        <input  type="hidden" class="form-control" id="student_session_id"  value="0" readonly="readonly"/>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('date'); ?></label>
                            <div class="col-sm-10">
                                <input id="date" name="admission_date" placeholder="" type="text" class="form-control date"  value="<?php echo date($this->customlib->getSchoolDateFormat()); ?>" readonly="readonly"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label"><?php echo $this->lang->line('amount'); ?> </label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <input type="text" class="form-control modal_amount" id="amount" value="0"  readonly="readonly">
                                    <span class="input-group-addon">.00</span>
                                </div>
                                <span class="text-danger" id="amount_error"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label"><?php echo $this->lang->line('discount'); ?></label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="amount_discount" value="0">
                                    <span class="input-group-addon">.00</span>
                                </div>
                                <span class="text-danger" id="amount_discount_error"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label"><?php echo $this->lang->line('fine'); ?></label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="amount_fine" value="0">
                                    <span class="input-group-addon">.00</span>
                                </div>
                                <span class="text-danger" id="amount_fine_error"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label"><?php echo $this->lang->line('payment'); ?> <?php echo $this->lang->line('mode'); ?></label>
                            <div class="col-sm-10">
                                <label class="radio-inline">
                                    <input type="radio" name="payment_mode_fee" value="Cash" checked="checked"><?php echo $this->lang->line('cash'); ?>
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="payment_mode_fee" value="Cheque"><?php echo $this->lang->line('cheque'); ?>
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="payment_mode_fee" value="DD"><?php echo $this->lang->line('dd'); ?>
                                </label>
                                <span class="text-danger" id="payment_mode_error"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label"><?php echo $this->lang->line('note'); ?></label>
                            <div class="col-sm-10">
                                <textarea class="form-control" rows="3" id="description" placeholder=""></textarea>
                            </div>
                        </div>
                    </div>                   
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><?php echo $this->lang->line('cancel'); ?></button>
                <button type="button" class="btn btn-primary save_button" id="load" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Processing"> <?php echo $currency_symbol; ?> <?php echo $this->lang->line('collect_fees'); ?> </button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="myTransportFeesModal" role="dialog">
    <div class="modal-dialog">       
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title title text-center transport_fees_title"></h4>
            </div>
            <div class="modal-body">
                <div class="form-horizontal">
                    <div class="box-body">
                        <input  type="hidden" class="form-control" id="transport_student_session_id"  value="0" readonly="readonly"/>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('date'); ?></label>
                            <div class="col-sm-10">
                                <input id="transport_date" name="admission_date" placeholder="" type="text" class="form-control date"  value="<?php echo date($this->customlib->getSchoolDateFormat()); ?>" readonly="readonly"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label"><?php echo $this->lang->line('amount'); ?></label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <input type="text" class="form-control transport_modal_amount" id="transport_amount" value=""  >
                                    <span class="input-group-addon">.00</span>
                                </div>
                                <span class="text-danger" id="transport_amount_error"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label"><?php echo $this->lang->line('fine'); ?></label>

                            <div class="col-sm-10">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="transport_amount_fine" value="">
                                    <span class="input-group-addon">.00</span>
                                </div>
                                <span class="text-danger" id="transport_amount_fine_error"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label"><?php echo $this->lang->line('payment'); ?> <?php echo $this->lang->line('mode'); ?></label>
                            <div class="col-sm-10">
                                <label class="radio-inline">
                                    <input type="radio" name="payment_mode_transport" value="Cash" checked="checked"><?php echo $this->lang->line('cash'); ?>
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="payment_mode_transport" value="Cheque"><?php echo $this->lang->line('cheque'); ?>
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="payment_mode_transport" value="DD"><?php echo $this->lang->line('dd'); ?>
                                </label>
                                <span class="text-danger" id="payment_mode_transport_error"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">Note</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" rows="3" id="description_transport" placeholder=""></textarea>
                            </div>
                        </div>
                    </div>                   
                </div>        
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><?php echo $this->lang->line('cancel'); ?></button>
                <button type="button" class="btn btn-primary transport_save_button" id="load" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Processing"><?php echo $currency_symbol; ?> <?php echo $this->lang->line('collect_transport_fees'); ?></button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var date_format = '<?php echo $result = strtr($this->customlib->getSchoolDateFormat(), ['d' => 'dd', 'm' => 'mm', 'Y' => 'yyyy',]) ?>';
    $(".myTransportFeeBtn").click(function () {
        $("span[id$='_error']").html("");
        $('#transport_amount').val("");
        $('#transport_amount_discount').val("0");
        $('#transport_amount_fine').val("0");
        var student_session_id = $(this).data("student-session-id");
        $('.transport_fees_title').html("<b>Collect Transport Fees</b>");
        $('#transport_student_session_id').val(student_session_id);
        $('#myTransportFeesModal').modal({
            backdrop: 'static',
            keyboard: false,
            show: true
        });
    });

</script>
<script type="text/javascript">
    $(document).on('click', '.save_button', function (e) {
        var $this = $(this);
        $this.button('loading');
        var form = $(this).attr('frm');
        var feetype = $('#feetype_').val();
        var date = $('#date').val();
        var amount = $('#amount').val();
        var guardian_phone = $('#guardian_phone').val();
        var amount_discount = $('#amount_discount').val();
        var amount_fine = $('#amount_fine').val();
        var description = $('#description').val();
        var fee_master_id = $('#fee_master_id').val();
        var student_session_id = $('#student_session_id').val();
        var payment_mode = $('input[name="payment_mode_fee"]:checked').val();
        $.ajax({
            url: '<?php echo site_url("teacher/studentfee/add_Ajaxfee") ?>',
            type: 'post',
            data: {date: date, type: feetype, amount: amount, amount_discount: amount_discount, amount_fine: amount_fine, description: description, fee_master_id: fee_master_id, student_session_id: student_session_id, payment_mode: payment_mode, guardian_phone: guardian_phone},
            dataType: 'json',
            success: function (response) {
                $this.button('reset');
                if (response.status == "success") {
                    location.reload(true);
                } else if (response.status == "fail") {
                    $.each(response.error, function (index, value) {
                        var errorDiv = '#' + index + '_error';
                        $(errorDiv).empty().append(value);
                    });
                }
            }
        });
    });
</script>

<script type="text/javascript">
    $(document).on('click', '.transport_save_button', function (e) {
        var $this = $(this);
        $this.button('loading');
        var transport_date = $('#transport_date').val();
        var transport_amount = $('#transport_amount').val();
        var transport_amount_discount = $('#transport_amount_discount').val();
        var transport_amount_fine = $('#transport_amount_fine').val();
        var description = $('#description_transport').val();
        var payment_mode = $('input[name="payment_mode_transport"]:checked').val();
        var student_session_id = $('#transport_student_session_id').val();
        $.ajax({
            url: '<?php echo site_url("teacher/studentfee/add_AjaxTransportfee") ?>',
            type: 'post',
            data: {date: transport_date, amount: transport_amount, amount_discount: transport_amount_discount, amount_fine: transport_amount_fine, description: description, student_session_id: student_session_id, payment_mode_transport: payment_mode},
            dataType: 'json',
            success: function (response) {
                $this.button('reset');
                if (response.status == "success") {
                    location.reload(true);
                } else if (response.status == "fail") {
                    $.each(response.error, function (index, value) {
                        var errorDiv = '#' + index + '_error';
                        $(errorDiv).empty().append(value);
                    });
                }
            }
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function () {
        $(document).on('click', '.printDoc', function () {
            var array_to_print = [];
            $.each($("input[name='fee_checkbox']:checked"), function () {
                var cat = $(this).data('category');
                item = {}
                item ["category"] = cat;
                item ["row_id"] = $(this).val();
                array_to_print.push(item);
            });
            if (array_to_print.length == 0) {
                alert("no record selected");
            } else {
                var student_session_id = '<?php echo $student['student_session_id'] ?>';
                $.ajax({
                    url: '<?php echo site_url("teacher/studentfee/printFeesByName") ?>',
                    type: 'post',
                    data: {'student_session_id': student_session_id, 'data': JSON.stringify(array_to_print)},
                    success: function (response) {
                        Popup(response);
                    }
                });
            }
        });
    });
</script>

<script type="text/javascript">
    var base_url = '<?php echo base_url() ?>';
    function Popup(data)
    {

        var frame1 = $('<iframe />');
        frame1[0].name = "frame1";
        frame1.css({"position": "absolute", "top": "-1000000px"});
        $("body").append(frame1);
        var frameDoc = frame1[0].contentWindow ? frame1[0].contentWindow : frame1[0].contentDocument.document ? frame1[0].contentDocument.document : frame1[0].contentDocument;
        frameDoc.document.open();
        //Create a new HTML document.
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

    $(document).ready(function () {
        $(document).on('click', '.revert-fee', function () {
            var payment_id = $(this).data("feepaymentid");
            swal({
                title: "Are you sure?",
                text: "Are you sure want to revert this fees?",
                type: "warning",
                showCancelButton: true,
                closeOnConfirm: false,
                confirmButtonText: "Yes, revert it!",
                cancelButtonText: "No!",
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
            }, function () {
                $.ajax(
                        {
                            type: "post",
                            url: '<?php echo site_url("teacher/studentfee/deleteFee") ?>',
                            data: "feeid=" + payment_id,
                            success: function (data) {
                            }
                        }
                )
                        .done(function (data) {
                            swal("Canceled!", "Your fee was successfully revert!", "success");
                            location.reload(true);
                        })
                        .error(function (data) {
                            swal("Oops", "We couldn't connect to the server!", "error");
                        });
            });
        });
        $(document).on('click', '.revert-transportfee', function () {
            var payment_id = $(this).data("feepaymentid");
            swal({
                title: "Are you sure?",
                text: "Are you sure want to revert this fee?",
                type: "warning",
                showCancelButton: true,
                closeOnConfirm: false,
                confirmButtonText: "Yes, revert it!",
                cancelButtonText: "No!",
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
            }, function () {
                $.ajax(
                        {
                            type: "post",
                            url: '<?php echo site_url("teacher/studentfee/deleteTransportFee") ?>',
                            data: "feeid=" + payment_id,
                            success: function (data) {
                            }
                        }
                )
                        .done(function (data) {
                            swal("Canceled!", "Your fee was successfully revert!", "success");
                            location.reload(true);
                        })
                        .error(function (data) {
                            swal("Oops", "We couldn't connect to the server!", "error");
                        });
            });
        });
    });
</script>

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