<?php
$currency_symbol = $this->customlib->getSchoolCurrencyFormat();
?>
<div class="content-wrapper">  
    <section class="content-header">
        <h1>
            <i class="fa fa-money"></i> <?php echo $this->lang->line('fees_collection'); ?> <small><?php echo $this->lang->line('student_fee'); ?></small>        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-4">               
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?php echo $this->lang->line('add_fees_master') . " : " . $this->setting_model->getCurrentSessionName(); ?></h3>
                    </div>
                    <form id="form1" action="<?php echo site_url('teacher/feemaster') ?>"  id="employeeform" name="employeeform" method="post" accept-charset="utf-8">
                        <div class="box-body">
                            <?php
                            if (isset($error_message)) {
                                echo "<div class='alert alert-danger'>" . $error_message . "</div>";
                            }
                            ?>
                            <?php if ($this->session->flashdata('msg')) { ?>
                                <?php echo $this->session->flashdata('msg') ?>
                            <?php } ?> 
                            <?php echo $this->customlib->getCSRF(); ?>
                            <div class="form-group">
                                <label for="exampleInputEmail1"><?php echo $this->lang->line('fee_category'); ?></label>
                                <select autofocus="" id="feecategory_id" name="feecategory_id" class="form-control" >
                                    <option value=""><?php echo $this->lang->line('select'); ?></option>
                                    <?php
                                    foreach ($feecategorylist as $feecatgory) {
                                        ?>
                                        <option value="<?php echo $feecatgory['id'] ?>"<?php if (set_value('feecategory_id') == $feecatgory['id']) echo "selected=selected" ?>><?php echo $feecatgory['category'] ?></option>
                                        <?php
                                        $count++;
                                    }
                                    ?>
                                </select>
                                <span class="text-danger"><?php echo form_error('feecategory_id'); ?></span>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1"><?php echo $this->lang->line('fee_type'); ?></label>
                                <select  id="feetype_id" name="feetype_id" class="form-control" >
                                    <option value="" ><?php echo $this->lang->line('select'); ?></option>
                                </select>
                                <span class="text-danger"><?php echo form_error('feetype_id'); ?></span>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1"><?php echo $this->lang->line('class'); ?></label>
                                <select  id="class_id" name="class_id" class="form-control" >
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
                            <div class="form-group">
                                <label for="exampleInputEmail1"><?php echo $this->lang->line('amount'); ?></label>
                                <input id="amount" name="amount" placeholder="" type="text" class="form-control"  value="<?php echo set_value('amount'); ?>" />
                                <span class="text-danger"><?php echo form_error('amount'); ?></span>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1"><?php echo $this->lang->line('description'); ?></label>
                                <textarea class="form-control" id="description" name="description" placeholder="" rows="3" placeholder="Enter ..."><?php echo set_value('description'); ?></textarea>
                                <span class="text-danger"><?php echo form_error('description'); ?></span>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="button" id="btnreset" class="btn btn-default"><?php echo $this->lang->line('reset'); ?></button>
                            <button type="submit" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-8">              
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?php echo $this->lang->line('fees_master_list') . " : " . $this->setting_model->getCurrentSessionName(); ?></h3>
                        <div class="box-tools pull-right">
                            <button type='button' class="btn btn-default btn-sm pull-right no-print" onclick="printDiv('#femaster');"><i class="fa fa-print"></i></button>
                        </div>
                    </div>
                    <div class="box-body"  id="femaster"> 
                        <div class="table-responsive mailbox-messages">
                            <table id="example1" class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('class'); ?>
                                        </th>
                                        <th><?php echo $this->lang->line('type'); ?>
                                        </th>
                                        <th><?php echo $this->lang->line('amount'); ?>
                                        </th>
                                        <th class="pull-right no-print"><?php echo $this->lang->line('action'); ?>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $count = 1;
                                    if (empty($feemasterlist)) {
                                        
                                    } else {
                                        foreach ($feemasterlist as $feemaster) {
                                            ?>
                                            <tr>
                                                <td class="mailbox-name">
                                                    <a href="#" data-toggle="popover" class="detail_popover"><?php echo $feemaster['class'] ?></a>
                                                    <div class="fee_detail_popover" style="display: none">
                                                        <?php
                                                        if ($feemaster['description'] == "") {
                                                            ?>
                                                            <p class="text text-danger"><?php echo $this->lang->line('no_description'); ?></p>
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <p class="text text-info"><?php echo $feemaster['description']; ?></p>
                                                            <?php
                                                        }
                                                        ?>
                                                    </div>
                                                </td>
                                                <td class="mailbox-name"> <?php echo $feemaster['type'] ?></td>
                                                <td class="mailbox-name"> <?php echo ($currency_symbol . $feemaster['amount']); ?></td>
                                                <td class="mailbox-date pull-right no-print">
                                                    <a href="<?php echo base_url(); ?>teacher/feemaster/edit/<?php echo $feemaster['id'] ?>" class="btn btn-default btn-xs"  data-toggle="tooltip" title="<?php echo $this->lang->line('edit'); ?>">
                                                        <i class="fa fa-pencil"></i>
                                                    </a>
                                                    <a href="<?php echo base_url(); ?>teacher/feemaster/delete/<?php echo $feemaster['id'] ?>"class="btn btn-default btn-xs"  data-toggle="tooltip" title="<?php echo $this->lang->line('delete'); ?>" onclick="return confirm('Are you sure you want to delete this item?');">
                                                        <i class="fa fa-remove"></i>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
</section>
</div>
<script src="<?php echo base_url(); ?>backend/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>backend/plugins/datatables/dataTables.bootstrap.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>backend/plugins/datatables/dataTables.bootstrap.css">
<script type="text/javascript">

                                                        function getSectionByClass(feecategory_id, feetype_id) {
                                                            if (feecategory_id != "" && feetype_id != "") {
                                                                $('#feetype_id').html("");
                                                                var base_url = '<?php echo base_url() ?>';
                                                                var div_data = '<option value=""><?php echo $this->lang->line('select'); ?></option>';
                                                                $.ajax({
                                                                    type: "GET",
                                                                    url: base_url + "teacher/feemaster/getByFeecategory",
                                                                    data: {'feecategory_id': feecategory_id},
                                                                    dataType: "json",
                                                                    success: function (data) {
                                                                        $.each(data, function (i, obj)
                                                                        {
                                                                            var sel = "";
                                                                            if (feetype_id == obj.id) {
                                                                                sel = "selected=selected";
                                                                            }
                                                                            div_data += "<option value=" + obj.id + " " + sel + ">" + obj.type + "</option>";
                                                                        });
                                                                        $('#feetype_id').append(div_data);
                                                                    }
                                                                });
                                                            }
                                                        }
                                                        $(document).ready(function () {
                                                            var feecategory_id = $('#feecategory_id').val();
                                                            var feetype_id = '<?php echo set_value('feetype_id') ?>';
                                                            getSectionByClass(feecategory_id, feetype_id);
                                                            $(document).on('change', '#feecategory_id', function (e) {
                                                                $('#feetype_id').html("");
                                                                var feecategory_id = $(this).val();
                                                                var base_url = '<?php echo base_url() ?>';
                                                                var div_data = '<option value=""><?php echo $this->lang->line('select'); ?></option>';
                                                                $.ajax({
                                                                    type: "GET",
                                                                    url: base_url + "teacher/feemaster/getByFeecategory",
                                                                    data: {'feecategory_id': feecategory_id},
                                                                    dataType: "json",
                                                                    success: function (data) {
                                                                        $.each(data, function (i, obj)
                                                                        {
                                                                            div_data += "<option value=" + obj.id + ">" + obj.type + "</option>";
                                                                        });
                                                                        $('#feetype_id').append(div_data);
                                                                    }
                                                                });
                                                            });
                                                            $("#btnreset").click(function () {
                                                                $("#form1")[0].reset();
                                                            });
                                                        });
</script>
<script>
    $(function () {
        $("#example1").DataTable();
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false
        });
    });
</script>
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
</script>
<script>
    $(document).ready(function () {
        $('.detail_popover').popover({
            placement: 'right',
            trigger: 'hover',
            container: 'body',
            html: true,
            content: function () {
                return $(this).closest('td').find('.fee_detail_popover').html();
            }
        });
    });
</script>