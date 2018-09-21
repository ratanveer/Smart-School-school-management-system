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
<style type="text/css">
    .open>.type_dropdown {
        display: block;
        height: 150px;
        overflow: auto;
        position: absolute;
    }
</style>
<div class="content-wrapper" style="min-height: 946px;">   
    <section class="content-header">
        <h1>
            <i class="fa fa-money"></i> <?php echo $this->lang->line('fees_collection'); ?> <small> <?php echo $this->lang->line('filter_by_name1'); ?></small>        </h1>
    </section>  
    <section class="content">
        <div class="row"> 
            <div class="col-md-12"> 
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-search"></i> <?php echo $this->lang->line('select_criteria'); ?></h3>
                    </div>
                    <form action="<?php echo site_url('teacher/transaction/studentacademicreport') ?>"  method="post" accept-charset="utf-8">
                        <div class="box-body">
                            <?php echo $this->customlib->getCSRF(); ?>
                            <div class="row">
                                <div class="col-md-6">
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
                                <div class="col-md-6">
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
                            <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-search"></i> <?php echo $this->lang->line('search'); ?></button>   </div>
                    </form>
                </div>
                <?php
                if (isset($student_due_fee)) {
                    ?>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-info" id="transfee">
                                <div class="box-header">
                                    <h3 class="box-title"><i class="fa fa-users"></i> <?php echo $this->lang->line('student_fees_report'); ?></h3>
                                    <div class="box-tools pull-right">
                                        <button type='button' class="btn btn-default btn-sm pull-right no-print" onclick="printDiv('#transfee');"><i class="fa fa-print"></i></button>
                                    </div>
                                </div>                              
                                <div class="box-body table-responsive">
                                    <div class="row print" >
                                        <div class="col-md-12">
                                            <div class="col-md-4">
                                                <b><?php echo $this->lang->line('class'); ?>: </b> <span class="cls"></span>
                                            </div>
                                        </div>
                                    </div><br/>
                                    <table class="table table-hover table-striped">
                                        <tbody>
                                            <tr>
                                                <th class="text text-left"><?php echo $this->lang->line('student_name'); ?></th>
                                                <th class="text text-left"><?php echo $this->lang->line('admission_no'); ?></th>
                                                <th class="text text-left"><?php echo $this->lang->line('roll_no'); ?></th>
                                                <th class="text text-left"><?php echo $this->lang->line('father_name'); ?></th>
                                                <th></th>
                                                <th class="text text-right"><?php echo $this->lang->line('total_fees'); ?></th>
                                                <th class="text text-right"><?php echo $this->lang->line('paid_fees'); ?></th>
                                                <th class="pull-right"><?php echo $this->lang->line('balance'); ?></th>
                                            </tr>
                                            <?php
                                            $grd_total = 0;
                                            $grd_paid = 0;
                                            if (!empty($student_due_fee)) {
                                                foreach ($student_due_fee as $key => $student) {
                                                    $grd_total = $grd_total + $student->totalfee;
                                                    $grd_paid = $grd_paid + $student->deposit;
                                                    ?>
                                                    <tr>
                                                        <td>    <?php echo $student->name; ?>   </td>
                                                        <td>    <?php echo $student->admission_no; ?>   </td>
                                                        <td>    <?php echo $student->roll_no; ?>   </td>
                                                        <td>    <?php echo $student->father_name; ?>   </td>
                                                        <td></td>
                                                        <td class="text text-right"><b>
                                                                <?php echo ($currency_symbol . $student->totalfee); ?></b>
                                                        </td>
                                                        <td class="text text-right">
                                                            <b><?php echo ($currency_symbol . $student->deposit); ?></b>
                                                        </td>
                                                        <td class="pull-right">
                                                            <b><?php echo ($currency_symbol . number_format($student->balance, 2, '.', '')); ?></b>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                            } else {
                                                ?>
                                                <tr>
                                                    <td colspan="8" class="text-danger text-center">
                                                        <span class="input input-danger"><?php echo $this->lang->line('no_record_found'); ?></span>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                            <tr class="box box-solid bg-light-blue-gradient">
                                                <td colspan="5" class="text text-right">
                                                    <b><?php echo $this->lang->line('grand_total'); ?> : </b>
                                                </td>
                                                <td colspan="" class="text text-right">
                                                    <b><?php echo ($currency_symbol . number_format($grd_total, 2, '.', '') ); ?></b>
                                                </td>
                                                <td class="text text-right">
                                                    <b><?php echo ($currency_symbol . number_format($grd_paid, 2, '.', '') ); ?></b>
                                                </td>
                                                <td class="text text-right">
                                                    <b><?php echo ($currency_symbol . number_format(($grd_total - $grd_paid), 2, '.', '')); ?></b>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>                              
                            </div>                           
                        </div>
                    </div>
                    <?php
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
                });
                function getStudentsByClassAndSection() {
                    $('#student_id').html("");
                    var class_id = $('#class_id').val();
                    var section_id = $('#section_id').val();
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
                                div_data += "<option value=" + obj.id + ">" + obj.firstname + " " + obj.lastname + "</option>";
                            });
                            $('#student_id').append(div_data);
                        }
                    });
                }
                $(document).ready(function () {
                    $("ul.type_dropdown input[type=checkbox]").each(function () {
                        $(this).change(function () {
                            var line = "";
                            $("ul.type_dropdown input[type=checkbox]").each(function () {
                                if ($(this).is(":checked")) {
                                    line += $("+ span", this).text() + ";";
                                }
                            });
                            $("input.form-control").val(line);
                        });
                    });
                });
            </script>

            <script type="text/javascript">
                var base_url = '<?php echo base_url() ?>';
                function printDiv(elem) {
                    var cls = $("#class_id option:selected").text();
                    var sec = $("#section_id option:selected").text();
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