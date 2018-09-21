<style type="text/css">
    #div_avail{
        display: none;
    }
</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1><i class="fa fa-building-o"></i> <?php echo $this->lang->line('inventory'); ?></h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- Horizontal Form -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?php echo $this->lang->line('issue_item'); ?></h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->

                    <form  action="<?php echo site_url('admin/issueitem/add') ?>"  id="issueitem" name="employeeform" method="post" accept-charset="utf-8">
                        <div class="box-body">
                            <div class="row">
                                <?php if ($this->session->flashdata('msg')) { ?>
                                    <?php echo $this->session->flashdata('msg') ?>
                                <?php } ?>
                                <?php
                                if (isset($error_message)) {
                                    echo "<div class='alert alert-danger'>" . $error_message . "</div>";
                                }
                                ?>      
                                <?php echo $this->customlib->getCSRF(); ?>                     
                                <div class="form-group col-md-4 col-sm-12">

                                    <label for="input-type"><?php echo $this->lang->line('user_type'); ?></label>
                                    <div id="input-type" class="row">
                                        <div class="col-md-3 col-sm-3 col-xs-6">
                                            <label class="radio-inline">
                                                <input autofocus="" name="account_type" class="ac_type" id="input-type-student" value="teacher" type="radio" /><?php echo $this->lang->line('teacher'); ?>
                                            </label>
                                        </div>
                                        <div class="col-md-3 col-sm-3 col-xs-6">
                                            <label class="radio-inline">
                                                <input  name="account_type" class="ac_type" id="input-type-student" value="librarian" type="radio" /><?php echo $this->lang->line('librarian'); ?>
                                            </label>
                                        </div>
                                        <div class="col-md-3 col-sm-3 col-xs-6">
                                            <label class="radio-inline">
                                                <input name="account_type" class="ac_type" id="input-type-student" value="accountant" type="radio" /><?php echo $this->lang->line('accountant'); ?>
                                            </label>
                                        </div>
                                        <div class="col-md-3 col-sm-3 col-xs-6">
                                            <label class="radio-inline">
                                                <input name="account_type" class="ac_type" id="input-type-tutor" value="admin" type="radio" /><?php echo $this->lang->line('admin'); ?>
                                            </label>
                                        </div>
                                    </div>

                                </div>
                                <div class="form-group col-md-4 col-sm-4">
                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('issue_to'); ?></label>

                                    <select  id="issue_to" name="issue_to" class="form-control">
                                        <option value=""><?php echo $this->lang->line('select'); ?></option>
                                    </select>
                                    <span class="text-danger"><?php echo form_error('Items'); ?></span>

                                </div>
                                <!-- <div class="clearfix"></div> -->
                                <div class="form-group col-md-4 col-sm-4">
                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('issue_by'); ?></label>
                                    <input id="issue_by" name="issue_by" placeholder="" type="text" class="form-control"  value="<?php echo set_value('issue_by'); ?>" />
                                    <span class="text-danger"><?php echo form_error('issue_by'); ?></span>

                                </div>



                                <div class="form-group col-md-4 col-sm-4">
                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('issue_date'); ?></label>
                                    <input id="issue_date" name="issue_date" placeholder="" type="text" class="form-control date"  value="<?php echo set_value('issue_date'); ?>" readonly />
                                    <span class="text-danger"><?php echo form_error('issue_date'); ?></span>
                                </div>
                                <!-- <div class="clearfix"></div> -->
                                <div class="form-group col-md-4 col-sm-4">
                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('return_date'); ?></label>
                                    <input id="return_date" name="return_date" placeholder="" type="text" class="form-control date"  value="<?php echo set_value('return_date'); ?>" readonly/>
                                    <span class="text-danger"><?php echo form_error('return_date'); ?></span>
                                </div>

                                <div class="form-group col-md-4 col-sm-4">
                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('note'); ?></label>
                                    <textarea name="note" class="form-control" id="note"/><?php echo set_value('note'); ?></textarea>
                                    <span class="text-danger"><?php echo form_error('note'); ?></span>
                                </div>
                                <div class="clearfix"></div>



                                <hr>

                                <div class="col-md-12">
                                    <div class="row">



                                        <div class="form-group col-sm-4">
                                            <label for="exampleInputEmail1"><?php echo $this->lang->line('item_category'); ?></label>

                                            <select  id="item_category_id" name="item_category_id" class="form-control" >
                                                <option value=""><?php echo $this->lang->line('select'); ?></option>
                                                <?php
                                                foreach ($itemcatlist as $item_category) {
                                                    ?>
                                                    <option value="<?php echo $item_category['id'] ?>"<?php
                                                    if (set_value('item_category_id') == $item_category['id']) {
                                                        echo "selected = selected";
                                                    }
                                                    ?>><?php echo $item_category['item_category'] ?></option>

                                                    <?php
                                                }
                                                ?>
                                            </select>
                                            <span class="text-danger"><?php echo form_error('item_category_id'); ?></span>
                                        </div>
                                        <div class="form-group col-sm-4">
                                            <label for="exampleInputEmail1"><?php echo $this->lang->line('item'); ?></label>

                                            <select  id="item_id" name="item_id" class="form-control" >
                                                <option value=""><?php echo $this->lang->line('select'); ?></option>

                                            </select>
                                            <span class="text-danger"><?php echo form_error('item_id'); ?></span>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="exampleInputEmail1"><?php echo $this->lang->line('quantity'); ?></label>
                                            <input  class="form-control" name="quantity"/>
                                            <div id="div_avail">
                                                <span>Available Quantity : </span>
                                                <span id="item_available_quantity">0</span>
                                            </div>
                                        </div>
                                    </div>
                                </div> 



                            </div>       
                        </div><!-- /.box-body -->

                        <div class="box-footer">

                            <button type="submit" class="allot-fees btn btn-primary btn-sm pull-right" id="load" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Please Wait.."><?php echo $this->lang->line('submit'); ?>
                            </button>
                        </div>
                    </form>
                </div>

            </div><!--/.col (right) -->
        </div>
        <div class="row">
            <div class="col-md-12">
            </div><!--/.col (right) -->
        </div>   <!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->


<script type="text/javascript">

    $(document).ready(function () {
        var date_format = '<?php echo $result = strtr($this->customlib->getSchoolDateFormat(), ['d' => 'dd', 'm' => 'mm', 'Y' => 'yyyy',]) ?>';


        $('.date').datepicker({
            format: date_format,
            autoclose: true
        });
    });
    var base_url = '<?php echo base_url() ?>';
    function populateItem(item_id_post, item_category_id_post) {
        if (item_category_id_post != "") {
            $('#item_id').html("");
            var div_data = '<option value=""><?php echo $this->lang->line('select'); ?></option>';
            $.ajax({
                type: "GET",
                url: base_url + "admin/itemstock/getItemByCategory",
                data: {'item_category_id': item_category_id_post},
                dataType: "json",
                success: function (data) {
                    $.each(data, function (i, obj)
                    {
                        var select = "";
                        if (item_id_post == obj.id) {
                            var select = "selected=selected";
                        }
                        div_data += "<option value=" + obj.id + " " + select + ">" + obj.name + "</option>";
                    });
                    $('#item_id').append(div_data);
                }

            });
        }
    }


    $(document).on('change', '#item_category_id', function (e) {
        $('#item_id').html("");
        var item_category_id = $(this).val();
        populateItem(0, item_category_id);
    });
    $(document).on('change', '#item_id', function (e) {
        $('#div_avail').hide();
        var item_id = $(this).val();
        availableQuantity(item_id);

    });

    function availableQuantity(item_id) {
        if (item_id != "") {
            $('#item_available_quantity').html("");
            var div_data = '';
            $.ajax({
                type: "GET",
                url: base_url + "admin/item/getAvailQuantity",
                data: {'item_id': item_id},
                dataType: "json",
                success: function (data) {

                    $('#item_available_quantity').html(data.available);
                    $('#div_avail').show();
                }

            });
        }
    }

    $("input[name=account_type]:radio").change(function () {
        var user = $('input[name=account_type]:checked').val();
        getIssueUser(user);



    });
    function getIssueUser(usertype) {
        $('#issue_to').html("");
        var div_data = "";
        $.ajax({
            type: "POST",
            url: base_url + "admin/issueitem/getUser",
            data: {'usertype': usertype},
            dataType: "json",
            success: function (data) {

                $.each(data.result, function (i, obj)
                {
                    if (data.usertype == "admin") {
                        name = obj.username;
                    } else {
                        name = obj.name;

                    }
                    div_data += "<option value=" + obj.id + ">" + name + "</option>";
                });
                $('#issue_to').append(div_data);
            }

        });
    }

    $("#issueitem").submit(function (e)
    {
        var data = $(this).serializeArray();
        var issue_to = $('#issue_to option:selected').text();
        data.push({name: 'issue_to_name', value: issue_to});

        var $this = $('.allot-fees');
        $this.button('loading');
        e.preventDefault();
        var postData = data;
        var formURL = $(this).attr("action");
        $.ajax(
                {
                    url: formURL,
                    type: "POST",
                    data: postData,
                    dataType: 'Json',
                    success: function (data, textStatus, jqXHR)
                    {
                        if (data.status == "fail") {
                            var message = "";
                            $.each(data.error, function (index, value) {

                                message += value;
                            });
                            errorMsg(message);
                        } else {
                            $('#item_available_quantity').html("");
                            $('#div_avail').css('display','none');
                            document.getElementById("issueitem").reset();
                            successMsg(data.message);
                        }

                        $this.button('reset');
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        $this.button('reset');
                    }
                });

    });
</script>
<script type="text/javascript" src="<?php echo base_url(); ?>backend/dist/js/savemode.js"></script>
