<div class="content-wrapper" style="min-height: 946px;">   
    <section class="content-header">
        <h1>
            <i class="fa fa-book"></i>  <?php echo $this->lang->line('library'); ?>
        </h1>
    </section>  
    <section class="content">
        <div class="row">         
            <div class="col-md-3">
                <?php
                if ($memberList->member_type == "student") {
                    $this->load->view('admin/librarian/_student');
                } else {
                    $this->load->view('admin/librarian/_teacher');
                }
                ?>       
            </div>
            <div class="col-md-9">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?php echo $this->lang->line('issue_book'); ?></h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->

                    <form id="form1" action="<?php echo site_url('admin/member/issue/' . $memberList->lib_member_id) ?>"  id="employeeform" name="employeeform" method="post" accept-charset="utf-8">

                        <div class="box-body">                            
                            <?php
                            if ($this->session->flashdata('msg')) {
                                echo $this->session->flashdata('msg');
                            }
                            ?>

                            <?php echo $this->customlib->getCSRF(); ?>

                            <input id="member_id" name="member_id"  type="hidden" class="form-control date"  value="<?php echo $memberList->lib_member_id; ?>" />

                            <div class="form-group">
                                <label for="exampleInputEmail1"><?php echo $this->lang->line('books'); ?></label>
                                <select  autofocus="" id="book_id" name="book_id" class="form-control" >
                                    <option value=""><?php echo $this->lang->line('select'); ?></option>
                                    <?php
                                    foreach ($bookList as $book) {
                                        ?>
                                        <option value="<?php echo $book['id'] ?>"<?php
                                        if (set_value('book_id') == $book['id']) {
                                            echo "selected =selected";
                                        }
                                        ?>><?php echo $book['book_title'] ?></option>
                                                <?php
                                                $count++;
                                            }
                                            ?>
                                </select>
                                <span class="text-danger"><?php echo form_error('book_id'); ?></span>
                            </div>
                            <div class="form-group">
                                <label><?php echo $this->lang->line('return_date'); ?></label>
                                <input id="dateto" name="return_date"  type="text" class="form-control date"  value="<?php echo set_value('return_date', date($this->customlib->getSchoolDateFormat())); ?>" />
                            </div>
                        </div><!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>
                        </div>
                    </form>
                </div> 
                <div class="box box-primary">
                    <div class="box-header ptbnull">
                        <h3 class="box-title titlefix"><?php echo $this->lang->line('book_issued'); ?></h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->

                    <div class="box-body">                            
                        <div class="table-responsive mailbox-messages">
						<div class="download_label"><?php echo $this->lang->line('book_issued'); ?></div>
                            <table class="table table-striped table-bordered table-hover example">
                                <thead>
                                    <tr>

                                        <th><?php echo $this->lang->line('book_title'); ?></th>
                                        <th><?php echo $this->lang->line('book_no'); ?></th>
                                        <th><?php echo $this->lang->line('issue_date'); ?></th>
                                        <th><?php echo $this->lang->line('return_date'); ?></th>
                                        <th class="text-right"><?php echo $this->lang->line('action'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (empty($issued_books)) {
                                        ?>

                                        <?php
                                    } else {
                                        $count = 1;
                                        foreach ($issued_books as $book) {
                                            ?>
                                            <tr>
                                                <td class="mailbox-name">
                                                    <?php echo $book['book_title'] ?>
                                                </td>
                                                <td class="mailbox-name">
                                                    <?php echo $book['book_no'] ?>
                                                </td>
                                                <td class="mailbox-name">
                                                    <?php echo date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($book['issue_date'])) ?></td>
                                                <td class="mailbox-name">
                                                    <?php echo date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($book['return_date'])) ?></td>
                                                <td class="mailbox-date pull-right">
                                                    <?php if ($book['is_returned'] == 0) {
                                                        ?>
                                                        <a href="<?php echo base_url(); ?>admin/member/bookreturn/<?php echo $book['id'] . "/" . $memberList->lib_member_id; ?>" class="btn btn-default btn-xs"  data-toggle="tooltip" title="Return" onclick="return confirm('Are you sure you want to return this book?')">
                                                            <i class="fa fa-mail-reply"></i>
                                                        </a>

                                                        <?php
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                            <?php
                                            $count++;
                                        }
                                    }
                                    ?>

                                </tbody>
                            </table><!-- /.table -->
                        </div><!-- /.mail-box-messages -->

                    </div><!-- /.box-body -->

                    </form>
                </div> 
            </div>
        </div>
    </section>
</div>


<script type="text/javascript">
    $(document).ready(function () {
        var date_format = '<?php echo $result = strtr($this->customlib->getSchoolDateFormat(), ['d' => 'dd', 'm' => 'mm', 'Y' => 'yyyy',]) ?>';
        $(".date").datepicker({
            // format: "dd-mm-yyyy",
            format: date_format,
            autoclose: true,
            todayHighlight: true

        });
    });
</script>