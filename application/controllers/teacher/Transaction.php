<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Transaction extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('file');
        $this->lang->load('message', 'english');
        $this->load->library('auth');
        $this->auth->is_logged_in_teacher();
    }

    function searchtransaction_1() {
        $this->session->set_userdata('top_menu', 'Reports');
        $this->session->set_userdata('sub_menu', 'transaction/searchtransaction');
        $data['title'] = 'Search Expense';
        if ($this->input->server('REQUEST_METHOD') == "POST") {
            $search = $this->input->post('search');
            if ($search == "search_filter") {
                $data['exp_title'] = 'Transaction From ' . $this->input->post('date_from') . " To " . $this->input->post('date_to');
                $date_from = date('Y-m-d', $this->customlib->datetostrtotime($this->input->post('date_from')));
                $date_to = date('Y-m-d', $this->customlib->datetostrtotime($this->input->post('date_to')));
                $expenseList = $this->expense_model->search("", $date_from, $date_to);
                $feeList = $this->studentfee_model->getFeeBetweenDate($date_from, $date_to);
                $data['expenseList'] = $expenseList;
                $data['feeList'] = $feeList;
            }
            $this->load->view('layout/teacher/header', $data);
            $this->load->view('teacher/transaction/searchtransaction', $data);
            $this->load->view('layout/teacher/footer', $data);
        } else {
            $this->load->view('layout/teacher/header', $data);
            $this->load->view('teacher/transaction/searchtransaction', $data);
            $this->load->view('layout/teacher/footer', $data);
        }
    }

    function studentacademicreport() {
        $this->session->set_userdata('top_menu', 'Fees Collection');
        $this->session->set_userdata('sub_menu', 'transaction/studentacademicreport');
        $data['title'] = 'student fee';
        $data['title'] = 'student fee';
        $class = $this->class_model->get();
        $data['classlist'] = $class;
        $feetype = $this->feetype_model->getFeetype();
        $data['feetypelist'] = $feetype;
        if ($this->input->server('REQUEST_METHOD') == "GET") {
            $this->load->view('layout/teacher/header', $data);
            $this->load->view('teacher/transaction/studentacademicreport', $data);
            $this->load->view('layout/teacher/footer', $data);
        } else {
            $this->form_validation->set_rules('section_id', 'Section', 'required');
            $this->form_validation->set_rules('class_id', 'Class', 'required');
            if ($this->form_validation->run() == FALSE) {
                $this->load->view('layout/teacher/header', $data);
                $this->load->view('teacher/transaction/studentacademicreport', $data);
                $this->load->view('layout/teacher/footer', $data);
            } else {
                $class_id = $this->input->post('class_id');
                $section_id = $this->input->post('section_id');
                $feetype = $this->input->post('feetype');
                $feetype_arr = $this->input->post('feetype_arr');
                $student_Array = array();
                $studentlist = $this->student_model->searchByClassSection($class_id, $section_id);
                if (!empty($studentlist)) {
                    foreach ($studentlist as $key => $eachstudent) {
                        $obj = new stdClass();
                        $obj->name = $eachstudent['firstname'] . " " . $eachstudent['lastname'];
                        $obj->class = $eachstudent['class'];
                        $obj->section = $eachstudent['section'];
                        $obj->admission_no = $eachstudent['admission_no'];
                        $obj->roll_no = $eachstudent['roll_no'];
                        $obj->father_name = $eachstudent['father_name'];
                        $student_session_id = $eachstudent['student_session_id'];
                        $student_total_fees = $this->studentfee_model->getStudentTotalFee($class_id, $student_session_id);
                        $obj->totalfee = $student_total_fees->totalfee;
                        $obj->payment_mode = $student_total_fees->payment_mode;
                        $obj->deposit = $student_total_fees->fee_deposit;
                        $obj->balance = ($student_total_fees->totalfee - $student_total_fees->fee_deposit);
                        $student_Array[] = $obj;
                    }
                }
                $data['student_due_fee'] = $student_Array;
                $data['class_id'] = $class_id;
                $data['section_id'] = $section_id;
                $data['feetype'] = $feetype;
                $data['feetype_arr'] = $feetype_arr;
                $this->load->view('layout/teacher/header', $data);
                $this->load->view('teacher/transaction/studentacademicreport', $data);
                $this->load->view('layout/teacher/footer', $data);
            }
        }
    }

}

?>