<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-download"></i> <?php echo $this->lang->line('download_center'); ?>         </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">               
                <div class="box box-primary">
                    <div class="box-header ptbnull">
                        <h3 class="box-title titlefix"><?php echo $this->lang->line('syllabus_list'); ?></h3>
                    </div> 
                </div>               
                <div class="col-md-0">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title"></h3>
                            <div class="box-tools pull-right">
                            </div>
                        </div>
                        <div class="box-body no-padding">
                            <div class="mailbox-controls">                               
                                <div class="pull-right">
                                </div>
                            </div>
                            <div class="table-responsive mailbox-messages">
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <td>
                                            </td>
                                            <td><?php echo $this->lang->line('hostel_name'); ?>
                                            </td>
                                            <td><?php echo $this->lang->line('content_title'); ?>
                                            </td>
                                            <td><?php echo $this->lang->line('content_type'); ?>
                                            </td>
                                            <td><?php echo $this->lang->line('file_uploaded'); ?></td>
                                            <td><?php echo $this->lang->line('upload_date'); ?></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $count = 1;
                                        if (empty($contentlist)) {
                                            echo"<div class='alert alert-danger'>No Record Founded</div>";
                                        } else {
                                            foreach ($contentlist as $data) {
                                                ?>
                                                <tr>
                                                    <td></td>
                                                    <td class="mailbox-name"> <?php echo $data['content_title'] ?></td>
                                                    <td class="mailbox-name"> <?php echo $data['content_type'] ?></td>
                                                    <td class="mailbox-name"> <?php echo $data['file_uploaded'] ?></td>
                                                    <td class="mailbox-name"> <?php echo $data['upload_date'] ?></td>
                                                    <td><a class="btn btn-outline-inverse btn-lg" ><?php echo $this->lang->line('download'); ?></a></td>
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
            <div class="row">               
                <div class="col-md-12">
                </div>
            </div>
    </section>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        var date_format = '<?php echo $result = strtr($this->customlib->getSchoolDateFormat(), ['d' => 'dd', 'm' => 'mm', 'Y' => 'yyyy',]) ?>';
        $('#upload_date').datepicker({
            format: date_format,
            autoclose: true
        });
        $("#btnreset").click(function () {
            $("#form1")[0].reset();
        });
    });
</script>