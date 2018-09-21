<?php ?>
<script src="<?php echo base_url(); ?>backend/dist/js/moment.min.js"></script>
<footer class="main-footer">
    &copy;  <?php echo date('Y'); ?> 
    <?php echo $this->customlib->getAppName(); ?> <?php echo $this->customlib->getAppVersion(); ?>
</footer>
<div class="control-sidebar-bg"></div>
</div>
<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>

<link href="<?php echo base_url(); ?>backend/toast-alert/toastr.css" rel="stylesheet"/>
<script src="<?php echo base_url(); ?>backend/toast-alert/toastr.js"></script>
<script src="<?php echo base_url(); ?>backend/bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>backend/plugins/select2/select2.full.min.js"></script>
<script src="<?php echo base_url(); ?>backend/plugins/input-mask/jquery.inputmask.js"></script>
<script src="<?php echo base_url(); ?>backend/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="<?php echo base_url(); ?>backend/plugins/input-mask/jquery.inputmask.extensions.js"></script>
<script src="<?php echo base_url(); ?>backend/dist/js/moment.min.js"></script>
<script src="<?php echo base_url(); ?>backend/plugins/daterangepicker/daterangepicker.js"></script>
<script src="<?php echo base_url(); ?>backend/plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
<script src="<?php echo base_url(); ?>backend/plugins/timepicker/bootstrap-timepicker.min.js"></script>
<script src="<?php echo base_url(); ?>backend/plugins/slimScroll/jquery.slimscroll.min.js"></script>


<script src="<?php echo base_url(); ?>backend/plugins/iCheck/icheck.min.js"></script>
<script src="<?php echo base_url(); ?>backend/plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url(); ?>backend/plugins/fastclick/fastclick.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>backend/dist/js/bootstrap-filestyle.min.js"></script>
<script src="<?php echo base_url(); ?>backend/dist/js/app.min.js"></script>



<script type="text/javascript" src="<?php echo base_url(); ?>backend/dist/datatables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>backend/dist/datatables/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>backend/dist/datatables/js/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>backend/dist/datatables/js/pdfmake.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>backend/dist/datatables/js/vfs_fonts.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>backend/dist/datatables/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>backend/dist/datatables/js/buttons.print.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>backend/dist/datatables/js/buttons.colVis.min.js" ></script>
<script type="text/javascript" src="<?php echo base_url(); ?>backend/dist/datatables/js/ss.custom.js" ></script>

</body>
</html>


<script type="text/javascript">

    $(document).ready(function () {

<?php
if ($this->session->flashdata('success_msg')) {
    ?>
            successMsg("<?php echo $this->session->flashdata('success_msg'); ?>");
    <?php
} else if ($this->session->flashdata('error_msg')) {
    ?>
            errorMsg("<?php echo $this->session->flashdata('error_msg'); ?>");
    <?php
} else if ($this->session->flashdata('warning_msg')) {
    ?>
            infoMsg("<?php echo $this->session->flashdata('warning_msg'); ?>");
    <?php
} else if ($this->session->flashdata('info_msg')) {
    ?>
            warningMsg("<?php echo $this->session->flashdata('info_msg'); ?>");
    <?php
}
?>
    });
</script>



<!-- Button trigger modal -->
<!-- Modal -->
<div class="row">
    <div class="modal fade" id="sessionModal" tabindex="-1" role="dialog" aria-labelledby="sessionModalLabel">
        <form action="<?php echo site_url('admin/admin/activeSession') ?>" id="form_modal_session" class="form-horizontal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="sessionModalLabel"><?php echo $this->lang->line('session'); ?></h4>
                    </div>
                    <div class="modal-body sessionmodal_body pb0">

                    </div>
                    <div class="modal-footer">
This quick session change will be valid for only current Admin login
                        <button type="button" class="btn btn-primary submit_session" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Please wait.."><?php echo $this->lang->line('save'); ?></button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
