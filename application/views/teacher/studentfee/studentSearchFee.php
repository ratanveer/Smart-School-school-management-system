<style type="text/css">
    @media print
    {
        .no-print, .no-print *
        {
            display: none !important;
        }
        .print, .print *
        {
            display: block;
        }
    }
    .print, .print *
    {
        display: none;
    }
</style>
<?php
$currency_symbol = $this->customlib->getSchoolCurrencyFormat();
?>
<div class="content-wrapper" style="min-height: 946px;">  
    <section class="content-header">
        <h1>
            <i class="fa fa-money"></i> <?php echo $this->lang->line('fees_collection'); ?> <small><?php echo $this->lang->line('student_fees'); ?></small>        </h1>
    </section>   
    <section class="content">
        <div class="row">
            <div class="col-md-12"> 
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-search"></i> <?php echo $this->lang->line('select_criteria'); ?></h3>
                    </div>
                    <form action="<?php echo site_url('teacher/studentfee/feesearch') ?>"  method="post" accept-charset="utf-8">
                        <div class="box-body">
                            <?php echo $this->customlib->getCSRF(); ?>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><?php echo $this->lang->line('fee_category'); ?></label>
                                        <select autofocus="" id="feecategory_id" name="feecategory_id" class="form-control" >
                                            <option value=""><?php echo $this->lang->line('select'); ?></option>
                                            <?php
                                            foreach ($feecategorylist as $feecategory) {
                                                ?>
                                                <option value="<?php echo $feecategory['id'] ?>"<?php if (set_value('feecategory_id') == $feecategory['id']) echo"selected=selected"; ?>><?php echo $feecategory['category'] ?></option>
                                                <?php
                                                $count++;
                                            }
                                            ?>
                                        </select>
                                        <span class="text-danger"><?php echo form_error('feecategory_id'); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('fee_type'); ?></label>

                                        <select  id="feetype_id" name="feetype_id" class="form-control" >
                                            <option value=""><?php echo $this->lang->line('select'); ?></option>
                                        </select>
                                        <span class="text-danger"><?php echo form_error('feetype_id'); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
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
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><?php echo $this->lang->line('section'); ?></label>
                                        <select  id="section_id" name="section_id" class="form-control" >
                                            <option value=""><?php echo $this->lang->line('select'); ?></option>
                                        </select>
                                        <span class="text-danger"><?php echo form_error('section_id'); ?></span>
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
                <?php
                if (isset($student_due_fee)) {
                    ?>
                    <div class="box box-info" id="duefee">
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-users"></i> <?php echo $this->lang->line('student_lists'); ?></h3>
                            <div class="box-tools pull-right">
                                <button type='button' class="btn btn-default btn-sm pull-right no-print" onclick="printDiv('#duefee');"><i class="fa fa-print"></i></button>
                            </div>
                        </div>
                        <div class="box-body table-responsive">
                            <div class="row print" >
                                <div class="col-md-12">
                                    <div class="col-md-4">
                                        <b><?php echo $this->lang->line('class'); ?>: </b> <span class="cls"></span>
                                    </div>
                                    <div class="col-md-4">
                                        <b><?php echo $this->lang->line('fees_category'); ?>: </b><span class="fcat"></span>
                                    </div><div class="col-md-4">
                                        <b><?php echo $this->lang->line('fees_type'); ?>: </b> <span class="ftype"></span>
                                    </div>
                                </div>
                            </div><br/>
                            <table class="table table-striped">
                                <tbody><tr>
                                        <th style="width: 10px"> </th>
                                        <th><?php echo $this->lang->line('admission_no'); ?></th>
                                        <th><?php echo $this->lang->line('roll_no'); ?></th>
                                        <th><?php echo $this->lang->line('student'); ?> <?php echo $this->lang->line('name'); ?> </th>
                                        <th><?php echo $this->lang->line('date_of_birth'); ?></th>
                                        <th><?php echo $this->lang->line('class'); ?></th>
                                        <th><?php echo $this->lang->line('section'); ?></th>
                                        <th class="pull-right no-print"><?php echo $this->lang->line('action'); ?></th>
                                    </tr>
                                    <?php if (empty($student_due_fee)) {
                                        ?>
                                        <tr>
                                            <td colspan="12" class="text-danger text-center"><?php echo $this->lang->line('no_record_found'); ?></td>
                                        </tr>
                                        <?php
                                    } else {
                                        $count = 1;
                                        foreach ($student_due_fee as $student) {
                                            ?>
                                            <tr>
                                                <td></td>
                                                <td><?php echo $student['admission_no']; ?></td>
                                                <td><?php echo $student['roll_no']; ?></td>
                                                <td><?php echo $student['firstname'] . " " . $student['lastname']; ?></td>
                                                <td><?php echo date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($student['dob'])); ?></td>
                                                <td><?php echo $student['class']; ?></td>
                                                <td><?php echo $student['section']; ?></td>
                                                <td class="pull-right no-print"><a href="<?php echo base_url(); ?>teacher/studentfee/addfee/<?php echo $student['id'] ?>" class="btn btn-info btn-xs" >
                                                        <?php echo $currency_symbol; ?> <?php echo $this->lang->line('add_fees'); ?>
                                                    </a></td>
                                            </tr>
                                            <?php
                                        }
                                        $count++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div> 
            <?php
        } else {
            
        }
        ?>
    </section>
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
                            sel = "selected=selected";
                        }
                        div_data += "<option value=" + obj.section_id + " " + sel + ">" + obj.section + "</option>";
                    });
                    $('#section_id').append(div_data);
                }
            });
        }
    }

    $(document).ready(function () {
        var class_id = $('#class_id').val();
        var section_id = '<?php echo set_value('section_id') ?>';
        getSectionByClass(class_id, section_id);
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
        var date_format = '<?php echo $result = strtr($this->customlib->getSchoolDateFormat(), ['d' => 'dd', 'm' => 'mm', 'Y' => 'yyyy',]) ?>';

        $('#dob,#admission_date').datepicker({
            format: date_format,
            autoclose: true
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function () {
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
    });
</script>

<script type="text/javascript">
    var base_url = '<?php echo base_url() ?>';
    function printDiv(elem) {
        var fcat = $("#feecategory_id option:selected").text();
        var ftype = $("#feetype_id option:selected").text();
        var cls = $("#class_id option:selected").text();
        var sec = $("#section_id option:selected").text();
        $('.fcat').html(fcat);
        $('.ftype').html(ftype);
        $('.cls').html(cls + '(' + sec + ')');
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