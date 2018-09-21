<?php
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=exceldata.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
<table border='1'>
    <tr>
        <td><?php echo $this->lang->line('id'); ?> </td>
        <td><?php echo $this->lang->line('first_name'); ?> </td>
        <td><?php echo $this->lang->line('last_name'); ?> </td>
        <td><?php echo $this->lang->line('important_info'); ?> </td>
    </tr>
    <tr>
        <td><?php echo $this->lang->line('john'); ?> </td>
        <td><?php echo $this->lang->line('doe'); ?> </td>
        <td><?php echo $this->lang->line('nothing_really'); ?> </td>
    </tr>
</table>