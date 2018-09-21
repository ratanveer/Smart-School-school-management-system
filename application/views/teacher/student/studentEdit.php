<?php
$currency_symbol = $this->customlib->getSchoolCurrencyFormat();
?>
<div class="content-wrapper">  
    <section class="content-header">
        <h1>
            <i class="fa fa-user-plus"></i> <?php echo $this->lang->line('student_information'); ?> <small><?php echo $this->lang->line('student1'); ?></small>       </h1>
    </section>   
    <section class="content">
        <div class="row">           
            <div class="col-md-12">                
                <div class="box box-primary">

                    <form action="<?php echo site_url("teacher/student/edit/" . $id) ?>"  id="employeeform" name="employeeform" method="post" accept-charset="utf-8" enctype="multipart/form-data">                    
                        <div class="box-body">
                            <div class="tshadow mb25 bozero">
                                <h3 class="pagetitleh2"> <?php echo $this->lang->line('edit'); ?> <?php echo $this->lang->line('student'); ?></h3>
                                <?php if ($this->session->flashdata('msg')) { ?>
                                    <?php echo $this->session->flashdata('msg') ?>
                                <?php } ?>
                                <?php echo $this->customlib->getCSRF(); ?>
                                <div class="around10">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1"><?php echo $this->lang->line('admission_no'); ?></label>
                                                <input autofocus="" id="admission_no" name="admission_no" placeholder="" type="text" class="form-control"  value="<?php echo set_value('admission_no', $student['admission_no']); ?>" />
                                                <span class="text-danger"><?php echo form_error('admission_no'); ?></span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1"><?php echo $this->lang->line('roll_no'); ?></label>
                                                <input id="roll_no" name="roll_no" placeholder="" type="text" class="form-control"  value="<?php echo set_value('roll_no', $student['roll_no']); ?>" />
                                                <span class="text-danger"><?php echo form_error('roll_no'); ?></span>
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
                                                        <option value="<?php echo $class['id'] ?>" <?php
                                                        if ($student['class_id'] == $class['id']) {
                                                            echo "selected =selected";
                                                        }
                                                        ?>><?php echo $class['class'] ?></option>
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
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1"><?php echo $this->lang->line('first_name'); ?></label>
                                                <input id="firstname" name="firstname" placeholder="" type="text" class="form-control"  value="<?php echo set_value('firstname', $student['firstname']); ?>" />
                                                <span class="text-danger"><?php echo form_error('first_name'); ?></span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1"><?php echo $this->lang->line('last_name'); ?></label>
                                                <input id="lastname" name="lastname" placeholder="" type="text" class="form-control"  value="<?php echo set_value('lastname', $student['lastname']); ?>" />
                                                <span class="text-danger"><?php echo form_error('lastname'); ?></span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="exampleInputFile"> <?php echo $this->lang->line('gender'); ?> &nbsp;&nbsp;</label>
                                                <select class="form-control" name="gender">
                                                    <option value=""><?php echo $this->lang->line('select'); ?></option>
                                                    <?php
                                                    foreach ($genderList as $key => $value) {
                                                        ?>
                                                        <option  value="<?php echo $key; ?>" <?php if ($student['gender'] == $value) echo "selected"; ?>><?php echo $value; ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                                <span class="text-danger"><?php echo form_error('gender'); ?></span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1"><?php echo $this->lang->line('date_of_birth'); ?></label>
                                                <input id="dob" name="dob" placeholder="" type="text" class="form-control"  value="<?php echo set_value('dob', date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($student['dob']))); ?>" readonly="readonly"/>
                                                <span class="text-danger"><?php echo form_error('dob'); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1"><?php echo $this->lang->line('category'); ?></label>
                                                <select  id="category_id" name="category_id" class="form-control" >
                                                    <option value=""><?php echo $this->lang->line('select'); ?></option>
                                                    <?php
                                                    foreach ($categorylist as $category) {
                                                        ?>
                                                        <option value="<?php echo $category['id'] ?>" <?php if ($student['category_id'] == $category['id']) echo "selected =selected" ?>><?php echo $category['category']; ?></option>

                                                        <?php
                                                        $count++;
                                                    }
                                                    ?>
                                                </select>
                                                <span class="text-danger"><?php echo form_error('category_id'); ?></span>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1"><?php echo $this->lang->line('cast'); ?></label>
                                                <input id="cast" name="cast" placeholder="" type="text" class="form-control"  value="<?php echo set_value('cast', $student['cast']); ?>" />
                                                <span class="text-danger"><?php echo form_error('cast'); ?></span>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1"><?php echo $this->lang->line('religion'); ?></label>
                                                <input id="religion" name="religion" placeholder="" type="text" class="form-control"  value="<?php echo set_value('religion', $student['religion']); ?>" />
                                                <span class="text-danger"><?php echo form_error('religion'); ?></span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1"><?php echo $this->lang->line('mobile_no'); ?></label>
                                                <input id="mobileno" name="mobileno" placeholder="" type="text" class="form-control"  value="<?php echo set_value('mobileno', $student['mobileno']); ?>" />
                                                <span class="text-danger"><?php echo form_error('mobileno'); ?></span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1"><?php echo $this->lang->line('email'); ?></label>
                                                <input id="email" name="email" placeholder="" type="text" class="form-control"  value="<?php echo set_value('email', $student['email']); ?>" />
                                                <span class="text-danger"><?php echo form_error('email'); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1"><?php echo $this->lang->line('admission_date'); ?></label>
                                                <input id="admission_date" name="admission_date" placeholder="" type="text" class="form-control"  value="<?php echo set_value('admission_date', date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($student['admission_date']))); ?>" readonly="readonly" />
                                                <span class="text-danger"><?php echo form_error('admission_date'); ?></span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="exampleInputFile"><?php echo $this->lang->line('select_image'); ?></label>
                                                <div><input class="filestyle form-control" type='file' name='file' id="file" size='20' /></div>
                                            </div>
                                            <span class="text-danger"><?php echo form_error('file'); ?></span>
                                        </div>
                                        <div class="col-md-3 col-xs-12">
                                            <label><?php echo $this->lang->line('rte'); ?></label>
                                            <div class="radio" style="margin-top: 2px;">
                                                <label><input class="radio-inline" type="radio" name="rte" value="Yes"  <?php
                                                    echo set_value('rte', $student['rte']) == "Yes" ? "checked" : "";
                                                    ?>  ><?php echo $this->lang->line('yes'); ?></label>
                                                <label><input class="radio-inline" type="radio" name="rte" value="No" <?php
                                                    echo set_value('rte', $student['rte']) == "No" ? "checked" : "";
                                                    ?>  ><?php echo $this->lang->line('no'); ?></label>
                                            </div>
                                            <span class="text-danger"><?php echo form_error('rte'); ?></span>
                                        </div>                               

                                    </div>
                                </div>
                            </div>     
                            <div class="tshadow mb25 bozero"> 
                                <h3 class="pagetitleh2">
                                    <?php echo $this->lang->line('transport') . " " . $this->lang->line('details'); ?>
                                </h3>
                                <div class="around10">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">
                                                    <?php echo $this->lang->line('route_list'); ?>
                                                </label>
                                                <select class="form-control" name="vehroute_id" id="vehroute_id" >


                                                    <option value=""><?php echo $this->lang->line('select'); ?></option>
                                                    <?php
                                                    foreach ($vehroutelist as $vehroute) {
                                                        ?>
                                                        <optgroup label=" <?php echo $vehroute->route_title; ?>">
                                                            <?php
                                                            $vehicles = $vehroute->vehicles;
                                                            if (!empty($vehicles)) {
                                                                foreach ($vehicles as $key => $value) {

                                                                    $st = set_value('vehroute_id', $student['vehroute_id']) == $value->vec_route_id ? TRUE : FALSE;
                                                                    ?>

                                                                    <option value="<?php echo $value->vec_route_id ?>" <?php echo set_select('vehroute_id', $value->vec_route_id, $st); ?> data-fee="<?php echo $vehroute->fare; ?>" ><?php echo $value->vehicle_no ?> </option>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                        </optgroup>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                                <span class="text-danger"><?php echo form_error('transport_fees'); ?></span>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>   
                            <div class="tshadow mb25 bozero"> 
                                <h4 class="pagetitleh2"><?php echo $this->lang->line('parent_guardian_detail'); ?></h4>
                                <div class="around10">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1"><?php echo $this->lang->line('father_name'); ?></label>
                                                <input id="father_name" name="father_name" placeholder="" type="text" class="form-control"  value="<?php echo set_value('father_name', $student['father_name']); ?>" />
                                                <span class="text-danger"><?php echo form_error('father_name'); ?></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1"><?php echo $this->lang->line('phone'); ?> <?php echo $this->lang->line('no'); ?></label>
                                                <input id="father_phone" name="father_phone" placeholder="" type="text" class="form-control"  value="<?php echo set_value('father_phone', $student['father_phone']); ?>" />
                                                <span class="text-danger"><?php echo form_error('father_phone'); ?></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1"><?php echo $this->lang->line('father_occupation'); ?></label>
                                                <input id="father_occupation" name="father_occupation" placeholder="" type="text" class="form-control"  value="<?php echo set_value('father_occupation', $student['father_occupation']); ?>" />
                                                <span class="text-danger"><?php echo form_error('father_occupation'); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1"><?php echo $this->lang->line('mother_name'); ?></label>
                                                <input id="mother_name" name="mother_name" placeholder="" type="text" class="form-control"  value="<?php echo set_value('mother_name', $student['mother_name']); ?>" />
                                                <span class="text-danger"><?php echo form_error('mother_name'); ?></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1"><?php echo $this->lang->line('mother_phone'); ?></label>
                                                <input id="mother_phone" name="mother_phone" placeholder="" type="text" class="form-control"  value="<?php echo set_value('mother_phone', $student['mother_phone']); ?>" />
                                                <span class="text-danger"><?php echo form_error('mother_phone'); ?></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1"><?php echo $this->lang->line('mother_occupation'); ?></label>
                                                <input id="mother_occupation" name="mother_occupation" placeholder="" type="text" class="form-control"  value="<?php echo set_value('mother_occupation', $student['mother_occupation']); ?>" />
                                                <span class="text-danger"><?php echo form_error('mother_occupation'); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label><?php echo $this->lang->line('if_guardian_is'); ?>&nbsp;&nbsp;&nbsp;</label>
                                            <label class="radio-inline">
                                                <input type="radio" name="guardian_is"  <?php if ($student['guardian_is'] == "father") echo "checked"; ?> value="father" > <?php echo $this->lang->line('father'); ?>
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="guardian_is" <?php if ($student['guardian_is'] == "mother") echo "checked"; ?> value="mother"> <?php echo $this->lang->line('mother'); ?>
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="guardian_is" <?php if ($student['guardian_is'] == "other") echo "checked"; ?> value="other"> <?php echo $this->lang->line('other'); ?>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1"><?php echo $this->lang->line('guardian_name'); ?></label>
                                                        <input id="guardian_name" name="guardian_name" placeholder="" type="text" class="form-control"  value="<?php echo set_value('guardian_name', $student['guardian_name']); ?>" />
                                                        <span class="text-danger"><?php echo form_error('guardian_name'); ?></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1"><?php echo $this->lang->line('guardian_relation'); ?></label>
                                                        <input id="guardian_relation" name="guardian_relation" placeholder="" type="text" class="form-control"  value="<?php echo set_value('guardian_relation', $student['guardian_relation']); ?>" />
                                                        <span class="text-danger"><?php echo form_error('guardian_relation'); ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1"><?php echo $this->lang->line('guardian_phone'); ?></label>
                                                        <input id="guardian_phone" name="guardian_phone" placeholder="" type="text" class="form-control"  value="<?php echo set_value('guardian_phone', $student['guardian_phone']); ?>" />
                                                        <span class="text-danger"><?php echo form_error('guardian_phone'); ?></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1"><?php echo $this->lang->line('guardian_occupation'); ?></label>
                                                        <input id="guardian_occupation" name="guardian_occupation" placeholder="" type="text" class="form-control"  value="<?php echo set_value('guardian_occupation', $student['guardian_occupation']); ?>" />
                                                        <span class="text-danger"><?php echo form_error('guardian_occupation'); ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                 <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1"><?php echo $this->lang->line('guardian_email'); ?></label>
                                                <input id="guardian_email" name="guardian_email" placeholder="" type="text" class="form-control"  value="<?php echo set_value('guardian_email', $student['guardian_email']); ?>" />
                                                <span class="text-danger"><?php echo form_error('guardian_email'); ?></span>
                                            </div>
                                                   <div class="form-group">
                                                <label for="exampleInputEmail1"><?php echo $this->lang->line('guardian_address'); ?></label>
                                                <textarea id="guardian_address" name="guardian_address" placeholder="" class="form-control" rows="4"><?php echo set_value('guardian_address', $student['guardian_address']); ?></textarea>
                                                <span class="text-danger"><?php echo form_error('guardian_address'); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>    
                            <div class="tshadow mb25 bozero"> 
                                <h3 class="pagetitleh2"><?php echo $this->lang->line('address_details'); ?></h3>
                                <div class="around10">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>
                                                <input type="checkbox" id="autofill_current_address" onclick="return auto_fill_guardian_address();">
                                                <?php echo $this->lang->line('if_guardian_address_is_current_address'); ?>
                                            </label>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1"><?php echo $this->lang->line('current_address'); ?></label>
                                                <textarea id="current_address" name="current_address" placeholder=""  class="form-control" ><?php echo set_value('current_address', $student['current_address']); ?></textarea>
                                                <span class="text-danger"><?php echo form_error('current_address'); ?></span>
                                            </div>
                                            <div class="checkbox">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label>
                                                <input type="checkbox" id="autofill_address"onclick="return auto_fill_address();">
                                                <?php echo $this->lang->line('if_permanent_address_is_current_address'); ?>
                                            </label>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1"><?php echo $this->lang->line('permanent_address'); ?></label>
                                                <textarea id="permanent_address" name="permanent_address" placeholder="" class="form-control"><?php echo set_value('permanent_address', $student['permanent_address']) ?></textarea>
                                                <span class="text-danger"><?php echo form_error('permanent_address', $student['permanent_address']); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                            <div class="tshadow bozero"> 
                                <h3 class="pagetitleh2"><?php echo $this->lang->line('miscellaneous_details'); ?></h3>
                                <div class="around10">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1"><?php echo $this->lang->line('bank_account_no'); ?></label>
                                                <input id="bank_account_no" name="bank_account_no" placeholder="" type="text" class="form-control"  value="<?php echo set_value('bank_account_no', $student['bank_account_no']); ?>" />
                                                <span class="text-danger"><?php echo form_error('bank_account_no'); ?></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1"><?php echo $this->lang->line('bank_name'); ?></label>
                                                <input id="bank_name" name="bank_name" placeholder="" type="text" class="form-control"  value="<?php echo set_value('bank_name', $student['bank_name']); ?>" />
                                                <span class="text-danger"><?php echo form_error('bank_name'); ?></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1"><?php echo $this->lang->line('ifsc_code'); ?></label>
                                                <input id="ifsc_code" name="ifsc_code" placeholder="" type="text" class="form-control"  value="<?php echo set_value('ifsc_code', $student['ifsc_code']); ?>" />
                                                <span class="text-danger"><?php echo form_error('ifsc_code'); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">
                                                    <?php echo $this->lang->line('national_identification_no'); ?>
                                                </label>
                                                <input id="adhar_no" name="adhar_no" placeholder="" type="text" class="form-control"  value="<?php echo set_value('adhar_no', $student['adhar_no']); ?>" />
                                                <span class="text-danger"><?php echo form_error('adhar_no'); ?></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">
                                                    <?php echo $this->lang->line('local_identification_no'); ?>

                                                </label>
                                                <input id="samagra_id" name="samagra_id" placeholder="" type="text" class="form-control"  value="<?php echo set_value('samagra_id', $student['samagra_id']); ?>" />
                                                <span class="text-danger"><?php echo form_error('samagra_id'); ?></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1"><?php echo $this->lang->line('previous_school_details'); ?></label>
                                                <textarea class="form-control" rows="3" placeholder="" name="previous_school"><?php echo set_value('previous_school', $student['previous_school']); ?></textarea>
                                                <span class="text-danger"><?php echo form_error('previous_school'); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>    

                            <div class="box-footer">
                                <button type="submit" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>
                            </div>
                    </form>
                </div> 
            </div>
        </div> 
</div>
</section>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        var section_id_post = '<?php echo $student['section_id']; ?>';
        var class_id_post = '<?php echo $student['class_id']; ?>';
        populateSection(section_id_post, class_id_post);
        function populateSection(section_id_post, class_id_post) {
            $('#section_id').html("");
            var base_url = '<?php echo base_url() ?>';
            var div_data = '<option value=""><?php echo $this->lang->line('select'); ?></option>';
            $.ajax({
                type: "GET",
                url: base_url + "teacher/sections/getByClass",
                data: {'class_id': class_id_post},
                dataType: "json",
                success: function (data) {
                    $.each(data, function (i, obj)
                    {
                        var select = "";
                        if (section_id_post == obj.section_id) {
                            var select = "selected=selected";
                        }
                        div_data += "<option value=" + obj.section_id + " " + select + ">" + obj.section + "</option>";
                    });
                    $('#section_id').append(div_data);
                }
            });
        }

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

    function auto_fill_guardian_address() {
        if ($("#autofill_current_address").is(':checked'))
        {
            $('#current_address').val($('#guardian_address').val());
        }
    }
    function auto_fill_address() {
        if ($("#autofill_address").is(':checked'))
        {
            $('#permanent_address').val($('#current_address').val());
        }
    }
    $('input:radio[name="guardian_is"]').change(
            function () {
                if ($(this).is(':checked')) {
                    var value = $(this).val();
                    if (value == "father") {
                        $('#guardian_name').val($('#father_name').val());
                        $('#guardian_phone').val($('#father_phone').val());
                        $('#guardian_occupation').val($('#father_occupation').val());
                        $('#guardian_relation').val("Father")
                    } else if (value == "mother") {
                        $('#guardian_name').val($('#mother_name').val());
                        $('#guardian_phone').val($('#mother_phone').val());
                        $('#guardian_occupation').val($('#mother_occupation').val());
                        $('#guardian_relation').val("Mother")
                    } else {
                        $('#guardian_name').val("");
                        $('#guardian_phone').val("");
                        $('#guardian_occupation').val("");
                        $('#guardian_relation').val("")
                    }
                }
            });

</script>