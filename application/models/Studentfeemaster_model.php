<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Studentfeemaster_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->current_session = $this->setting_model->getCurrentSession();
    }

    public function searchAssignFeeByClassSection($class_id = null, $section_id = null, $fee_session_group_id = null, $category = null, $gender = null, $rte = null) {
        $sql = "SELECT IFNULL(`student_fees_master`.`id`, '0') as `student_fees_master_id`,`classes`.`id` AS `class_id`,"
                . " `student_session`.`id` as `student_session_id`, `students`.`id`, "
                . "`classes`.`class`, `sections`.`id` AS `section_id`, `sections`.`section`, "
                . "`students`.`id`, `students`.`admission_no`, `students`.`roll_no`,"
                . " `students`.`admission_date`, `students`.`firstname`, `students`.`lastname`,"
                . " `students`.`image`, `students`.`mobileno`, `students`.`email`, `students`.`state`,"
                . " `students`.`city`, `students`.`pincode`, `students`.`religion`, `students`.`dob`, "
                . "`students`.`current_address`, `students`.`permanent_address`,"
                . " IFNULL(students.category_id, 0) as `category_id`,"
                . " IFNULL(categories.category, '') as `category`,"
                . " `students`.`adhar_no`, `students`.`samagra_id`,"
                . " `students`.`bank_account_no`, `students`.`bank_name`, `students`.`ifsc_code`,"
                . " `students`.`guardian_name`, `students`.`guardian_relation`, `students`.`guardian_phone`,"
                . " `students`.`guardian_address`, `students`.`is_active`, `students`.`created_at`,"
                . " `students`.`updated_at`, `students`.`father_name`, `students`.`rte`,"
                . " `students`.`gender` FROM `students` JOIN `student_session` "
                . "ON `student_session`.`student_id` = `students`.`id` JOIN `classes` "
                . "ON `student_session`.`class_id` = `classes`.`id` JOIN `sections` "
                . "ON `sections`.`id` = `student_session`.`section_id` LEFT JOIN `categories` "
                . "ON `students`.`category_id` = `categories`.`id` LEFT JOIN student_fees_master on"
                . " student_fees_master.student_session_id=student_session.id"
                . "  AND student_fees_master.fee_session_group_id=" . $this->db->escape($fee_session_group_id)
                . "WHERE `student_session`.`session_id` =  " . $this->current_session;

        if ($class_id != null) {
            $sql .= " AND `student_session`.`class_id` = " . $this->db->escape($class_id);
        }
        if ($section_id != null) {
            $sql .= " AND `student_session`.`section_id` =" . $this->db->escape($section_id);
        }
        if ($category != null) {
            $sql .= " AND `students`.`category_id` =" . $this->db->escape($category);
        }
        if ($gender != null) {
            $sql .= " AND `students`.`gender` =" . $this->db->escape($gender);
        }
        if ($rte != null) {
            $sql .= " AND `students`.`rte` =" . $this->db->escape($rte);
        }
        $sql .= " ORDER BY `students`.`id`";

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function add($data) {

        $this->db->where('student_session_id', $data['student_session_id']);
        $this->db->where('fee_session_group_id', $data['fee_session_group_id']);
        $q = $this->db->get('student_fees_master');

        if ($q->num_rows() > 0) {
            return $q->row()->id;
        } else {
            $this->db->insert('student_fees_master', $data);
            return $this->db->insert_id();
        }
    }

    public function delete($fee_session_groups, $array) {

        $this->db->where('fee_session_group_id', $fee_session_groups);
        $this->db->where_in('student_session_id', $array);
        $this->db->delete('student_fees_master');
    }

    public function getStudentFees($student_session_id) {
        $sql = "SELECT `student_fees_master`.*,fee_groups.name FROM `student_fees_master` INNER JOIN fee_session_groups on student_fees_master.fee_session_group_id=fee_session_groups.id INNER JOIN fee_groups on fee_groups.id=fee_session_groups.fee_groups_id  WHERE `student_session_id` = " . $student_session_id . " ORDER BY `student_fees_master`.`id`";
        $query = $this->db->query($sql);
        $result = $query->result();
        if (!empty($result)) {
            foreach ($result as $result_key => $result_value) {
                $fee_session_group_id = $result_value->fee_session_group_id;
                $student_fees_master_id = $result_value->id;
                $result_value->fees = $this->getDueFeeByFeeSessionGroup($fee_session_group_id, $student_fees_master_id);
            }
        }

        return $result;
    }

    public function getDueFeeByFeeSessionGroup($fee_session_groups_id, $student_fees_master_id) {
        $sql = "SELECT student_fees_master.*,fee_groups_feetype.id as `fee_groups_feetype_id`,fee_groups_feetype.amount,fee_groups_feetype.due_date,fee_groups_feetype.fee_groups_id,fee_groups.name,fee_groups_feetype.feetype_id,feetype.code,feetype.type, IFNULL(student_fees_deposite.id,0) as `student_fees_deposite_id`, IFNULL(student_fees_deposite.amount_detail,0) as `amount_detail` FROM `student_fees_master` INNER JOIN fee_session_groups on fee_session_groups.id = student_fees_master.fee_session_group_id INNER JOIN fee_groups_feetype on  fee_groups_feetype.fee_session_group_id = fee_session_groups.id  INNER JOIN fee_groups on fee_groups.id=fee_groups_feetype.fee_groups_id INNER JOIN feetype on feetype.id=fee_groups_feetype.feetype_id LEFT JOIN student_fees_deposite on student_fees_deposite.student_fees_master_id=student_fees_master.id and student_fees_deposite.fee_groups_feetype_id=fee_groups_feetype.id WHERE student_fees_master.fee_session_group_id =" . $fee_session_groups_id . " and student_fees_master.id=" . $student_fees_master_id . " order by fee_groups_feetype.due_date asc";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function getDueFeeByFeeSessionGroupFeetype($fee_session_groups_id, $student_fees_master_id, $fee_groups_feetype_id) {

        $sql = "SELECT student_fees_master.*,fee_groups_feetype.id as `fee_groups_feetype_id`,students.firstname,students.lastname,student_session.class_id,classes.class,sections.section,students.guardian_name,students.father_name,student_session.section_id,student_session.student_id,fee_groups_feetype.amount,fee_groups_feetype.due_date,fee_groups_feetype.fee_groups_id,fee_groups.name,fee_groups_feetype.feetype_id,feetype.code,feetype.type, IFNULL(student_fees_deposite.id,0) as `student_fees_deposite_id`, IFNULL(student_fees_deposite.amount_detail,0) as `amount_detail` FROM `student_fees_master` INNER JOIN fee_session_groups on fee_session_groups.id = student_fees_master.fee_session_group_id INNER JOIN fee_groups_feetype on  fee_groups_feetype.fee_session_group_id = fee_session_groups.id  INNER JOIN fee_groups on fee_groups.id=fee_groups_feetype.fee_groups_id INNER JOIN feetype on feetype.id=fee_groups_feetype.feetype_id LEFT JOIN student_fees_deposite on student_fees_deposite.student_fees_master_id=student_fees_master.id and student_fees_deposite.fee_groups_feetype_id=fee_groups_feetype.id INNER JOIN student_session on student_session.id= student_fees_master.student_session_id INNER JOIN classes on classes.id= student_session.class_id INNER JOIN sections on sections.id= student_session.section_id INNER JOIN students on students.id=student_session.student_id  WHERE student_fees_master.fee_session_group_id =" . $fee_session_groups_id . " and student_fees_master.id=" . $student_fees_master_id . " and fee_groups_feetype.id= " . $fee_groups_feetype_id;

        $query = $this->db->query($sql);
        return $query->row();
    }

    public function fee_deposit($data, $send_to) {

        $this->db->where('student_fees_master_id', $data['student_fees_master_id']);
        $this->db->where('fee_groups_feetype_id', $data['fee_groups_feetype_id']);
        $q = $this->db->get('student_fees_deposite');

        if ($q->num_rows() > 0) {
            $row = $q->row();
            $this->db->where('id', $row->id);
            $a = json_decode($row->amount_detail, true);
            $inv_no = max(array_keys($a)) + 1;
            $data['amount_detail']['inv_no'] = $inv_no;
            $a[$inv_no] = $data['amount_detail'];
            $data['amount_detail'] = json_encode($a);
            $this->db->update('student_fees_deposite', $data);

            return json_encode(array('invoice_id' => $row->id, 'sub_invoice_id' => $inv_no));
        } else {
            $data['amount_detail']['inv_no'] = 1;
            $data['amount_detail'] = json_encode(array('1' => $data['amount_detail']));
            $this->db->insert('student_fees_deposite', $data);
            $inserted_id = $this->db->insert_id();

            return json_encode(array('invoice_id' => $inserted_id, 'sub_invoice_id' => 1));
        }
    }

    public function getFeeBetweenDate($start_date, $end_date) {
        $this->db->select('`student_fees_deposite`.*,students.firstname,students.lastname,student_session.class_id,classes.class,sections.section,student_session.section_id,student_session.student_id,`fee_groups`.`name`, `feetype`.`type`, `feetype`.`code`,student_fees_master.student_session_id')->from('student_fees_deposite');
        $this->db->join('fee_groups_feetype', 'fee_groups_feetype.id = student_fees_deposite.fee_groups_feetype_id');

        $this->db->join('fee_groups', 'fee_groups.id = fee_groups_feetype.fee_groups_id');
        $this->db->join('feetype', 'feetype.id = fee_groups_feetype.feetype_id');
        $this->db->join('student_fees_master', 'student_fees_master.id=student_fees_deposite.student_fees_master_id');
        $this->db->join('student_session', 'student_session.id= student_fees_master.student_session_id');
        $this->db->join('classes', 'classes.id= student_session.class_id');

        $this->db->join('sections', 'sections.id= student_session.section_id');
        $this->db->join('students', 'students.id=student_session.student_id');
        $this->db->order_by('student_fees_deposite.id');
        $query = $this->db->get();
        $result_value = $query->result();
        $return_array = array();
        if (!empty($result_value)) {
            $st_date = strtotime($start_date);
            $ed_date = strtotime($end_date);
            foreach ($result_value as $key => $value) {
                $return = $this->findObjectById($value, $st_date, $ed_date);
                if (!empty($return)) {
                    foreach ($return as $r_key => $r_value) {
                        $a['id'] = $value->id;
                        $a['student_fees_master_id'] = $value->student_fees_master_id;
                        $a['fee_groups_feetype_id'] = $value->fee_groups_feetype_id;
                        $a['firstname'] = $value->firstname;
                        $a['lastname'] = $value->lastname;
                        $a['class_id'] = $value->class_id;
                        $a['class'] = $value->class;
                        $a['section'] = $value->section;
                        $a['section_id'] = $value->section_id;
                        $a['student_id'] = $value->student_id;
                        $a['name'] = $value->name;
                        $a['type'] = $value->type;
                        $a['code'] = $value->code;
                        $a['student_session_id'] = $value->student_session_id;
                        $a['amount'] = $r_value->amount;
                        $a['date'] = $r_value->date;
                        $a['amount_discount'] = $r_value->amount_discount;
                        $a['amount_fine'] = $r_value->amount_fine;
                        $a['description'] = $r_value->description;
                        $a['payment_mode'] = $r_value->payment_mode;
                        $a['inv_no'] = $r_value->inv_no;
                        $return_array[] = $a;
                    }
                }
            }
        }

        return $return_array;
    }

    public function getDepositAmountBetweenDate($start_date, $end_date) {

        $this->db->select('`student_fees_deposite`.*')->from('student_fees_deposite');
        $this->db->order_by('student_fees_deposite.id');
        $query = $this->db->get();
        $result_value = $query->result();

        $return_array = array();
        if (!empty($result_value)) {
            $st_date = strtotime($start_date);
            $ed_date = strtotime($end_date);
            foreach ($result_value as $key => $value) {
                $return = $this->findObjectById($value, $st_date, $ed_date);

                if (!empty($return)) {
                    foreach ($return as $r_key => $r_value) {
                        $a = array();
                        $a['amount'] = $r_value->amount;
                        $a['date'] = $r_value->date;
                        $a['amount_discount'] = $r_value->amount_discount;
                        $a['amount_fine'] = $r_value->amount_fine;
                        $a['description'] = $r_value->description;
                        $a['payment_mode'] = $r_value->payment_mode;
                        $a['inv_no'] = $r_value->inv_no;
                        $return_array[] = $a;
                    }
                }
            }
        }

        return $return_array;
    }

    function findObjectAmount($array, $st_date, $ed_date) {

        $ar = json_decode($array->amount_detail);
        $array = array();
        $amount = 0;
        for ($i = $st_date; $i <= $ed_date; $i += 86400) {
            $find = date('Y-m-d', $i);
            foreach ($ar as $row_key => $row_value) {
                if ($row_value->date == $find) {

                    $array[] = $row_value;
                }
            }
        }
        return $array;
    }

    function findObjectById($array, $st_date, $ed_date) {

        $ar = json_decode($array->amount_detail);
        $array = array();
        for ($i = $st_date; $i <= $ed_date; $i += 86400) {
            $find = date('Y-m-d', $i);
            foreach ($ar as $row_key => $row_value) {
                if ($row_value->date == $find) {
                    $array[] = $row_value;
                }
            }
        }
        return $array;
    }

    public function getFeeByInvoice($invoice_id, $sub_invoice_id) {
        $this->db->select('`student_fees_deposite`.*,students.firstname,students.lastname,student_session.class_id,classes.class,sections.section,student_session.section_id,student_session.student_id,`fee_groups`.`name`, `feetype`.`type`, `feetype`.`code`,student_fees_master.student_session_id')->from('student_fees_deposite');
        $this->db->join('fee_groups_feetype', 'fee_groups_feetype.id = student_fees_deposite.fee_groups_feetype_id');

        $this->db->join('fee_groups', 'fee_groups.id = fee_groups_feetype.fee_groups_id');
        $this->db->join('feetype', 'feetype.id = fee_groups_feetype.feetype_id');
        $this->db->join('student_fees_master', 'student_fees_master.id=student_fees_deposite.student_fees_master_id');
        $this->db->join('student_session', 'student_session.id= student_fees_master.student_session_id');
        $this->db->join('classes', 'classes.id= student_session.class_id');

        $this->db->join('sections', 'sections.id= student_session.section_id');
        $this->db->join('students', 'students.id=student_session.student_id');
        $this->db->where('student_fees_deposite.id', $invoice_id);
        $q = $this->db->get();


        if ($q->num_rows() > 0) {
            $result = $q->row();
            $res = json_decode($result->amount_detail);
            $a = (array) $res;

            foreach ($a as $key => $value) {
                if ($key == $sub_invoice_id) {

                    return $result;
                }
            }
        }


        return false;
    }

    public function studentDeposit($data) {
        $sql = "SELECT fee_groups.name as `fee_group_name`,feetype.code as `fee_type_code`,fee_groups_feetype.amount,IFNULL(student_fees_deposite.amount_detail,0) as `amount_detail` from student_fees_master 
               INNER JOIN fee_session_groups on fee_session_groups.id=student_fees_master.fee_session_group_id 
              INNER JOIN fee_groups_feetype on fee_groups_feetype.fee_groups_id=fee_session_groups.fee_groups_id
              INNER JOIN fee_groups on fee_groups_feetype.fee_groups_id=fee_groups.id
              INNER JOIN feetype on fee_groups_feetype.feetype_id=feetype.id
         LEFT JOIN student_fees_deposite on student_fees_deposite.student_fees_master_id=student_fees_master.id and student_fees_deposite.fee_groups_feetype_id=fee_groups_feetype.id WHERE student_fees_master.id =" . $data['student_fees_master_id'] . " and fee_groups_feetype.id =" . $data['fee_groups_feetype_id'];
        $query = $this->db->query($sql);
        return $query->row();
    }

}
