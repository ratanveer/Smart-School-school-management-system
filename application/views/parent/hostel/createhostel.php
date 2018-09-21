<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-building-o"></i> <?php echo $this->lang->line('hostel'); ?></h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-4">
            </div>           
            <div class="col-md-12">              
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="table-responsive mailbox-messages">
						<div class="download_label"><?php echo $this->lang->line('hostel'); ?></div>
                            <table class="table table-striped table-bordered table-hover example">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('hostel_name'); ?>
                                        </th  >
                                        <th><?php echo $this->lang->line('type'); ?>
                                        </th>
                                        <th><?php echo $this->lang->line('address'); ?>
                                        </th>
                                        <th class="text-right"><?php echo $this->lang->line('intake'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($listhostel)) {
                                        ?>
                                        <tr>
                                            <td colspan="12" class="text-danger text-center"><?php echo $this->lang->line('no_record_found'); ?></td>
                                        </tr>
                                        <?php
                                    } else {
                                        $count = 1;
                                        foreach ($listhostel as $hostel) {
                                            ?>
                                            <tr>
                                                <td class="mailbox-name"> <?php echo $hostel['hostel_name'] ?></td>
                                                <td class="mailbox-name"> <?php echo $hostel['type'] ?></td>
                                                <td class="mailbox-name"> <?php echo $hostel['address'] ?></td>
                                                <td class="mailbox-name text-right"> <?php echo $hostel['intake'] ?></td>
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
        </div>
        <div class="row">         
            <div class="col-md-12">
            </div>
        </div> 
    </section>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('#postdate').datepicker({
            format: "dd-mm-yyyy",
            autoclose: true
        });
        $("#btnreset").click(function () {
            $("#form1")[0].reset();
        });
    });
</script>