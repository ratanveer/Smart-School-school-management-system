<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Studentfee extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('smsgateway');
        $this->load->library('mailsmsconf');
        $this->load->helper('file');
        $this->lang->load('message', 'english');
        $this->load->library('auth');
        $this->auth->is_logged_in_accountant();
    }

    function index() {
        $this->session->set_userdata('top_menu', 'Fees Collection');
        $this->session->set_userdata('sub_menu', 'studentfee/index');
        $data['title'] = 'student fees';
        $class = $this->class_model->get();
        $data['classlist'] = $class;
        $this->load->view('layout/accountant/header', $data);
        $this->load->view('accountant/studentfee/studentfeeSearch', $data);
        $this->load->view('layout/accountant/footer', $data);
    }

    function pdf() {
        $this->load->helper('pdf_helper');
    }

    function printFeesByGroupArray() {
        $setting_result = $this->setting_model->get();
        $data['settinglist'] = $setting_result;
        $record = $this->input->post('data');
        $record_array = json_decode($record);
        $fees_array = array();
        foreach ($record_array as $key => $value) {
            $fee_groups_feetype_id = $value->fee_groups_feetype_id;
            $fee_master_id = $value->fee_master_id;
            $fee_session_group_id = $value->fee_session_group_id;
            $feeList = $this->studentfeemaster_model->getDueFeeByFeeSessionGroupFeetype($fee_session_group_id, $fee_master_id, $fee_groups_feetype_id);
            $fees_array[] = $feeList;
        }
        $data['feearray'] = $fees_array;
        $this->load->view('print/printFeesByGroupArray', $data);
    }

    function deleteStudentDiscount() {

        $discount_id = $this->input->post('discount_id');
        if (!empty($discount_id)) {
            $data = array('id' => $discount_id, 'status' => 'assigned', 'payment_id' => "");
            $this->feediscount_model->updateStudentDiscount($data);
        }
        $array = array('status' => 'success', 'result' => 'success');
        echo json_encode($array);
    }

    function search() {
        $data['title'] = 'Student Search';
        $class = $this->class_model->get();
        $data['classlist'] = $class;
        $button = $this->input->post('search');
        if ($this->input->server('REQUEST_METHOD') == "GET") {
            $this->load->view('layout/accountant/header', $data);
            $this->load->view('accountant/studentfee/studentfeeSearch', $data);
            $this->load->view('layout/accountant/footer', $data);
        } else {
            $class = $this->input->post('class_id');
            $section = $this->input->post('section_id');
            $search = $this->input->post('search');
            $search_text = $this->input->post('search_text');
            if (isset($search)) {
                if ($search == 'search_filter') {
                    $this->form_validation->set_rules('class_id', 'Class', 'trim|required|xss_clean');
                    if ($this->form_validation->run() == FALSE) {
                        
                    } else {
                        $resultlist = $this->student_model->searchByClassSection($class, $section);
                        $data['resultlist'] = $resultlist;
                    }
                } else if ($search == 'search_full') {
                    $resultlist = $this->student_model->searchFullText($search_text);
                    $data['resultlist'] = $resultlist;
                }
                $this->load->view('layout/accountant/header', $data);
                $this->load->view('accountant/studentfee/studentfeeSearch', $data);
                $this->load->view('layout/accountant/footer', $data);
            }
        }
    }

    function feesearch() {
        $this->session->set_userdata('top_menu', 'Fees Collection');
        $this->session->set_userdata('sub_menu', 'studentfee/feesearch');
        $data['title'] = 'student fees';
        $class = $this->class_model->get();
        $data['classlist'] = $class;
        $feesessiongroup = $this->feesessiongroup_model->getFeesByGroup();

        $data['feesessiongrouplist'] = $feesessiongroup;
        $this->form_validation->set_rules('feegroup_id', 'Fee Group', 'trim|required|xss_clean');

        $this->form_validation->set_rules('class_id', 'Class', 'trim|required|xss_clean');
        $this->form_validation->set_rules('section_id', 'Section', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/accountant/header', $data);
            $this->load->view('accountant/studentfee/studentSearchFee', $data);
            $this->load->view('layout/accountant/footer', $data);
        } else {
            $data['student_due_fee'] = array();
            $feegroup_id = $this->input->post('feegroup_id');
            $feegroup = explode("-", $feegroup_id);
            $feegroup_id = $feegroup[0];
            $fee_groups_feetype_id = $feegroup[1];
            $class_id = $this->input->post('class_id');
            $section_id = $this->input->post('section_id');
            $student_due_fee = $this->studentfee_model->getDueStudentFees($feegroup_id, $fee_groups_feetype_id, $class_id, $section_id);
            if (!empty($student_due_fee)) {
                foreach ($student_due_fee as $student_due_fee_key => $student_due_fee_value) {
                    $amt_due = $student_due_fee_value['amount'];
                    $a = json_decode($student_due_fee_value['amount_detail']);
                    if (!empty($a)) {
                        $amount = 0;
                        foreach ($a as $a_key => $a_value) {
                            $amount = $amount + $a_value->amount;
                        }
                        if ($amt_due <= $amount) {
                            unset($student_due_fee[$student_due_fee_key]);
                        } else {

                            $student_due_fee[$student_due_fee_key]['amount_detail'] = $amount;
                        }
                    }
                }
            }

            $data['student_due_fee'] = $student_due_fee;
            $this->load->view('layout/accountant/header', $data);
            $this->load->view('accountant/studentfee/studentSearchFee', $data);
            $this->load->view('layout/accountant/footer', $data);
        }
    }

    function reportbyname() {
        $this->session->set_userdata('top_menu', 'Fees Collection');
        $this->session->set_userdata('sub_menu', 'studentfee/reportbyname');
        $data['title'] = 'student fees';
        $data['title'] = 'student fees';
        $class = $this->class_model->get();
        $data['classlist'] = $class;
        if ($this->input->server('REQUEST_METHOD') == "GET") {
            $this->load->view('layout/accountant/header', $data);
            $this->load->view('accountant/studentfee/reportByName', $data);
            $this->load->view('layout/accountant/footer', $data);
        } else {
            $this->form_validation->set_rules('section_id', 'Section', 'trim|required|xss_clean');
            $this->form_validation->set_rules('class_id', 'Class', 'trim|required|xss_clean');
            $this->form_validation->set_rules('student_id', 'Student', 'trim|required|xss_clean');
            if ($this->form_validation->run() == FALSE) {
                $this->load->view('layout/accountant/header', $data);
                $this->load->view('accountant/studentfee/reportByName', $data);
                $this->load->view('layout/accountant/footer', $data);
            } else {
                $data['student_due_fee'] = array();
                $class_id = $this->input->post('class_id');
                $section_id = $this->input->post('section_id');
                $student_id = $this->input->post('student_id');
                $student = $this->student_model->get($student_id);
                $data['student'] = $student;

                $student_due_fee = $this->studentfeemaster_model->getStudentFees($student['student_session_id']);

                $student_discount_fee = $this->feediscount_model->getStudentFeesDiscount($student['student_session_id']);
                $data['student_discount_fee'] = $student_discount_fee;
                $data['student_due_fee'] = $student_due_fee;

                $data['class_id'] = $class_id;
                $data['section_id'] = $section_id;
                $data['student_id'] = $student_id;
                $category = $this->category_model->get();
                $data['categorylist'] = $category;
                $this->load->view('layout/accountant/header', $data);
                $this->load->view('accountant/studentfee/reportByName', $data);
                $this->load->view('layout/accountant/footer', $data);
            }
        }
    }

    function reportbyclass() {
        $data['title'] = 'student fees';
        $data['title'] = 'student fees';
        $class = $this->class_model->get();
        $data['classlist'] = $class;
        if ($this->input->server('REQUEST_METHOD') == "GET") {
            $this->load->view('layout/accountant/header', $data);
            $this->load->view('accountant/studentfee/reportByClass', $data);
            $this->load->view('layout/accountant/footer', $data);
        } else {
            $student_fees_array = array();
            $class_id = $this->input->post('class_id');
            $section_id = $this->input->post('section_id');
            $student_result = $this->student_model->searchByClassSection($class_id, $section_id);
            $data['student_due_fee'] = array();
            if (!empty($student_result)) {
                foreach ($student_result as $key => $student) {
                    $student_array = array();
                    $student_array['student_detail'] = $student;
                    $student_session_id = $student['student_session_id'];
                    $student_id = $student['id'];
                    $student_due_fee = $this->studentfee_model->getDueFeeBystudentSection($class_id, $section_id, $student_session_id);
                    $student_array['fee_detail'] = $student_due_fee;
                    $student_fees_array[$student['id']] = $student_array;
                }
            }
            $data['class_id'] = $class_id;
            $data['section_id'] = $section_id;
            $data['student_fees_array'] = $student_fees_array;
            $this->load->view('layout/accountant/header', $data);
            $this->load->view('accountant/studentfee/reportByClass', $data);
            $this->load->view('layout/accountant/footer', $data);
        }
    }

    function view($id) {
        $data['title'] = 'studentfee List';
        $studentfee = $this->studentfee_model->get($id);
        $data['studentfee'] = $studentfee;
        $this->load->view('layout/accountant/header', $data);
        $this->load->view('accountant/studentfee/studentfeeShow', $data);
        $this->load->view('layout/accountant/footer', $data);
    }

    function addfee($id) {
        $data['title'] = 'Student Detail';
        $student = $this->student_model->get($id);
        $data['student'] = $student;
        $student_due_fee = $this->studentfeemaster_model->getStudentFees($student['student_session_id']);
        $student_discount_fee = $this->feediscount_model->getStudentFeesDiscount($student['student_session_id']);


        $data['student_discount_fee'] = $student_discount_fee;
        $data['student_due_fee'] = $student_due_fee;
        $category = $this->category_model->get();
        $data['categorylist'] = $category;
        $this->load->view('layout/accountant/header', $data);
        $this->load->view('accountant/studentfee/studentAddfee', $data);
        $this->load->view('layout/accountant/footer', $data);
    }

    function geBalanceFee() {
        $this->form_validation->set_rules('fee_groups_feetype_id', 'fee_groups_feetype_id', 'required|trim|xss_clean');
        $this->form_validation->set_rules('student_fees_master_id', 'student_fees_master_id', 'required|trim|xss_clean');

        if ($this->form_validation->run() == false) {
            $data = array(
                'fee_groups_feetype_id' => form_error('fee_groups_feetype_id'),
                'student_fees_master_id' => form_error('student_fees_master_id'),
            );
            $array = array('status' => 'fail', 'error' => $data);
            echo json_encode($array);
        } else {
            $data = array();
            $data['fee_groups_feetype_id'] = $this->input->post('fee_groups_feetype_id');
            $data['student_fees_master_id'] = $this->input->post('student_fees_master_id');

            $result = $this->studentfeemaster_model->studentDeposit($data);
            $amount_balance = 0;
            $amount = 0;
            $amount_fine = 0;
            $amount_discount = 0;
            $amount_detail = json_decode($result->amount_detail);

            if (is_object($amount_detail)) {

                foreach ($amount_detail as $amount_detail_key => $amount_detail_value) {
                    $amount = $amount + $amount_detail_value->amount;
                    $amount_discount = $amount_discount + $amount_detail_value->amount_discount;
                    $amount_fine = $amount_fine + $amount_detail_value->amount_fine;
                }
            }

            $amount_balance = $result->amount - ($amount + $amount_discount);
            $array = array('status' => 'success', 'error' => '', 'balance' => $amount_balance);
            echo json_encode($array);
        }
    }

    function addstudentfee() {
        $this->form_validation->set_rules('student_fees_master_id', 'Fee Master', 'required|trim|xss_clean');
        $this->form_validation->set_rules('fee_groups_feetype_id', 'Student', 'required|trim|xss_clean');
        $this->form_validation->set_rules('amount', 'Amount', 'required|trim|xss_clean');
        $this->form_validation->set_rules('amount_discount', 'Discount', 'required|trim|xss_clean');
        $this->form_validation->set_rules('amount_fine', 'Fine', 'required|trim|xss_clean');
        $this->form_validation->set_rules('payment_mode', 'Payment Mode', 'required|trim|xss_clean');
        if ($this->form_validation->run() == false) {
            $data = array(
                'amount' => form_error('amount'),
                'student_fees_master_id' => form_error('student_fees_master_id'),
                'fee_groups_feetype_id' => form_error('fee_groups_feetype_id'),
                'amount_discount' => form_error('amount_discount'),
                'amount_fine' => form_error('amount_fine'),
                'payment_mode' => form_error('payment_mode'),
            );
            $array = array('status' => 'fail', 'error' => $data);
            echo json_encode($array);
        } else {
            $collected_by = " Collected By: " . $this->customlib->getStudentSessionUserName();
            $json_array = array(
                'amount' => $this->input->post('amount'),
                'date' => date('Y-m-d', $this->customlib->datetostrtotime($this->input->post('date'))),
                'amount_discount' => $this->input->post('amount_discount'),
                'amount_fine' => $this->input->post('amount_fine'),
                'description' => $this->input->post('description') . $collected_by,
                'payment_mode' => $this->input->post('payment_mode')
            );
            $data = array(
                'student_fees_master_id' => $this->input->post('student_fees_master_id'),
                'fee_groups_feetype_id' => $this->input->post('fee_groups_feetype_id'),
                'amount_detail' => $json_array
            );

            $send_to = $this->input->post('guardian_phone');
            $email = $this->input->post('guardian_email');

            $inserted_id = $this->studentfeemaster_model->fee_deposit($data, $send_to);

            $sender_details = array('invoice' => $inserted_id, 'contact_no' => $send_to, 'email' => $email);
            $this->mailsmsconf->mailsms('fee_submission', $sender_details);

            $array = array('status' => 'success', 'error' => '');
            echo json_encode($array);
        }
    }

    function printFeesByGroup() {
        $fee_groups_feetype_id = $this->input->post('fee_groups_feetype_id');
        $fee_master_id = $this->input->post('fee_master_id');
        $fee_session_group_id = $this->input->post('fee_session_group_id');
        $setting_result = $this->setting_model->get();
        $data['settinglist'] = $setting_result;
        $data['feeList'] = $this->studentfeemaster_model->getDueFeeByFeeSessionGroupFeetype($fee_session_group_id, $fee_master_id, $fee_groups_feetype_id);

        $this->load->view('print/printFeesByGroup', $data);
    }

    function deleteTransportFee() {
        $id = $this->input->post('feeid');
        $this->studenttransportfee_model->remove($id);
        $array = array('status' => 'success', 'result' => 'success');
        echo json_encode($array);
    }

    function delete($id) {
        $data['title'] = 'studentfee List';
        $this->studentfee_model->remove($id);
        $this->session->set_flashdata('success_msg', 'Record deleted successfully');
        redirect('studentfee/index');
    }

    function add_Ajaxfee() {
        $this->form_validation->set_rules('fee_master_id', 'Fee Master', 'required|trim|xss_clean');
        $this->form_validation->set_rules('student_session_id', 'Student', 'required|trim|xss_clean');
        $this->form_validation->set_rules('amount', 'Amount', 'required|trim|xss_clean');
        $this->form_validation->set_rules('amount_discount', 'Discount', 'required|trim|xss_clean');
        $this->form_validation->set_rules('amount_fine', 'Fine', 'required|trim|xss_clean');
        $this->form_validation->set_rules('payment_mode', 'Payment Mode', 'required|trim|xss_clean');
        if ($this->form_validation->run() == false) {
            $data = array(
                'amount' => form_error('amount'),
                'fee_master_id' => form_error('fee_master_id'),
                'student_session_id' => form_error('student_session_id'),
                'amount_discount' => form_error('amount_discount'),
                'amount_fine' => form_error('amount_fine'),
                'payment_mode' => form_error('payment_mode'),
            );
            $array = array('status' => 'fail', 'error' => $data);
            echo json_encode($array);
        } else {
            $data = array(
                'amount' => $this->input->post('amount'),
                'date' => date('Y-m-d', $this->customlib->datetostrtotime($this->input->post('date'))),
                'student_session_id' => $this->input->post('student_session_id'),
                'amount_discount' => $this->input->post('amount_discount'),
                'amount_fine' => $this->input->post('amount_fine'),
                'description' => $this->input->post('description'),
                'feemaster_id' => $this->input->post('fee_master_id'),
                'payment_mode' => $this->input->post('payment_mode'),
            );
            $inserted_id = $this->studentfee_model->add($data);
            $send_to = $this->input->post('guardian_phone');
            $result = $this->smsgateway->sentAddFeeSMS($inserted_id, $send_to);
            $array = array('status' => 'success', 'error' => '');
            echo json_encode($array);
        }
    }

    function add_AjaxTransportfee() {
        $this->form_validation->set_rules('student_session_id', 'Student', 'required|trim|xss_clean');
        $this->form_validation->set_rules('amount', 'Amount', 'required|trim|xss_clean');
        $this->form_validation->set_rules('payment_mode_transport', 'Payment Mode', 'required|trim|xss_clean');
        $this->form_validation->set_rules('amount_fine', 'Fine', 'required|trim|xss_clean');
        if ($this->form_validation->run() == false) {
            $data = array(
                'transport_amount' => form_error('amount'),
                'transport_student_session_id' => form_error('student_session_id'),
                'transport_amount_discount' => form_error('amount_discount'),
                'transport_amount_fine' => form_error('amount_fine'),
                'payment_mode_transport' => form_error('payment_mode_transport')
            );
            $array = array('status' => 'fail', 'error' => $data);
            echo json_encode($array);
        } else {
            $data = array(
                'amount' => $this->input->post('amount'),
                'date' => date('Y-m-d', $this->customlib->datetostrtotime($this->input->post('date'))),
                'student_session_id' => $this->input->post('student_session_id'),
                'amount_discount' => "",
                'amount_fine' => $this->input->post('amount_fine'),
                'description' => $this->input->post('description'),
                'payment_mode' => $this->input->post('payment_mode_transport')
            );
            $inserted_id = $this->studenttransportfee_model->add($data);
            $array = array('status' => 'success', 'error' => '');
            echo json_encode($array);
        }
    }

    function printFeesByName() {
        $data = array('payment' => "0");

        $record = $this->input->post('data');
        $invoice_id = $this->input->post('main_invoice');
        $sub_invoice_id = $this->input->post('sub_invoice');
        $student_session_id = $this->input->post('student_session_id');
        $setting_result = $this->setting_model->get();
        $data['settinglist'] = $setting_result;
        $student = $this->studentsession_model->searchStudentsBySession($student_session_id);

        $fee_record = $this->studentfeemaster_model->getFeeByInvoice($invoice_id, $sub_invoice_id);
        $data['student'] = $student;
        $data['sub_invoice_id'] = $sub_invoice_id;
        $data['feeList'] = $fee_record;
        $this->load->view('print/printFeesByName', $data);
    }

    function deleteFee() {

        $invoice_id = $this->input->post('main_invoice');
        $sub_invoice = $this->input->post('sub_invoice');
        if (!empty($invoice_id)) {
            $this->studentfee_model->remove($invoice_id, $sub_invoice);
        }
        $array = array('status' => 'success', 'result' => 'success');
        echo json_encode($array);
    }

    function searchpayment() {
        $this->session->set_userdata('top_menu', 'Fees Collection');
        $this->session->set_userdata('sub_menu', 'studentfee/searchpayment');
        $data['title'] = 'Edit studentfees';


        $this->form_validation->set_rules('paymentid', 'Payment ID', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            
        } else {
            $paymentid = $this->input->post('paymentid');
            $invoice = explode("/", $paymentid);

            if (array_key_exists(0, $invoice) && array_key_exists(1, $invoice)) {
                $invoice_id = $invoice[0];
                $sub_invoice_id = $invoice[1];
                $feeList = $this->studentfeemaster_model->getFeeByInvoice($invoice_id, $sub_invoice_id);
                $data['feeList'] = $feeList;
                $data['sub_invoice_id'] = $sub_invoice_id;
            } else {
                $data['feeList'] = array();
            }
        }
        $this->load->view('layout/accountant/header', $data);
        $this->load->view('accountant/studentfee/searchpayment', $data);
        $this->load->view('layout/accountant/footer', $data);
    }

    function addfeegroup() {
        $this->form_validation->set_rules('fee_session_groups', 'Fee Group', 'required|trim|xss_clean');
        $this->form_validation->set_rules('student_session_id[]', 'Student', 'required|trim|xss_clean');

        if ($this->form_validation->run() == false) {
            $data = array(
                'fee_session_groups' => form_error('fee_session_groups'),
                'student_session_id[]' => form_error('student_session_id[]'),
            );
            $array = array('status' => 'fail', 'error' => $data);
            echo json_encode($array);
        } else {
            $fee_session_groups = $this->input->post('fee_session_groups');
            $student_sesssion_array = $this->input->post('student_session_id');
            $student_ids = $this->input->post('student_ids');
            $delete_student = array_diff($student_ids, $student_sesssion_array);

            $preserve_record = array();
            foreach ($student_sesssion_array as $key => $value) {

                $insert_array = array(
                    'student_session_id' => $value,
                    'fee_session_group_id' => $fee_session_groups,
                );
                $inserted_id = $this->studentfeemaster_model->add($insert_array);

                $preserve_record[] = $inserted_id;
            }
            if (!empty($delete_student)) {
                $this->studentfeemaster_model->delete($fee_session_groups, $delete_student);
            }

            $array = array('status' => 'success', 'error' => '', 'message' => 'Record Saved Successfully');
            echo json_encode($array);
        }
    }

}

?>