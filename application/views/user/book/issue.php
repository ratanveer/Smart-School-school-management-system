<?php
$currency_symbol = $this->customlib->getSchoolCurrencyFormat();
?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-book"></i> <?php echo $this->lang->line('library_book'); ?> <small></small>        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <?php if ($isCheck == 0) {
                            ?>
                            <div class="alert alert-warning"><?php echo $this->lang->line('no_record_found'); ?></div>
                            <?php
                        } else {
                            if (isset($bookList)) {
                                ?>
                                <div class="table-responsive mailbox-messages">
								<div class="download_label"><?php echo $this->lang->line('library_book'); ?></div>
                                    <table class="table table-striped table-bordered table-hover example">
                                        <thead>
                                            <tr>
                                                <th><?php echo $this->lang->line('book_title'); ?></th>
                                                <th><?php echo $this->lang->line('book_no'); ?></th>
                                                <th><?php echo $this->lang->line('author'); ?></th>
                                                <th><?php echo $this->lang->line('issue_date'); ?></th>


                                                <th class="text text-right"><?php echo $this->lang->line('return_date'); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (empty($bookList)) {
                                                ?>
                                                <tr>
                                                    <td colspan="12" class="text-danger text-center"><?php echo $this->lang->line('no_record_found'); ?></td>
                                                </tr>
                                                <?php
                                            } else {
                                                $count = 1;
                                                foreach ($bookList as $book) {
                                                    $cls = "";
                                                    if ($book['is_returned'] == 1) {
                                                        $cls = "success";
                                                    }
                                                    ?>
                                                    <tr class="<?php echo $cls; ?>">

                                                        <td class="mailbox-name"> <?php echo $book['book_title'] ?></td>
                                                        <td class="mailbox-name"> <?php echo $book['author'] ?></td>
                                                        <td class="mailbox-name"> <?php echo $book['book_no'] ?></td>
                                                        <td class="mailbox-name"> 

                                                            <?php echo date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($book['issue_date'])) ?>
                                                        </td>
                                                        <td class="text-right">

                                                            <?php echo date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($book['return_date'])) ?>   
                                                        </td>

                                                    </tr>
                                                    <?php
                                                }
                                                $count++;
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <?php
                            }
                        }
                        ?>  

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