<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Feediscount extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('file');
        $this->lang->load('message', 'english');
    }

    function delete($id) {
        $data['title'] = 'feecategory List';
        $this->feediscount_model->remove($id);
        redirect('admin/feediscount/index');
    }

    function index() {
        $this->session->set_userdata('top_menu', 'Fees Collection');
        $this->session->set_userdata('sub_menu', 'admin/feediscount');
        $feesdiscount_result = $this->feediscount_model->get();
        $data['feediscountList'] = $feesdiscount_result;
        $this->form_validation->set_rules('code', 'Discount Code', 'trim|required|xss_clean');
        $this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('amount', 'Amount', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/header', $data);
            $this->load->view('admin/feediscount/feediscountList', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $data = array(
                'name' => $this->input->post('name'),
                'code' => $this->input->post('code'),
                'amount' => $this->input->post('amount')
            );
            $this->feediscount_model->add($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success">Fees Discount added succesfully</div>');
            redirect('admin/feediscount');
        }
    }

    function edit($id) {
        $this->session->set_userdata('top_menu', 'Fees Collection');
        $this->session->set_userdata('sub_menu', 'admin/feediscount');
        $feesdiscount_result = $this->feediscount_model->get();
        $data['feediscountList'] = $feesdiscount_result;
        $data['title'] = 'Edit feecategory';
        $data['id'] = $id;

        $feediscount = $this->feediscount_model->get($id);
        $data['feediscount'] = $feediscount;
        $this->form_validation->set_rules('name', 'category', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/header', $data);
            $this->load->view('admin/feediscount/feediscountEdit', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $data = array(
                'id' => $id,
                'name' => $this->input->post('name'),
                'code' => $this->input->post('code')
            );
            $this->feediscount_model->add($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success">Fees Discount updated succesfully</div>');
            redirect('admin/feediscount/index');
        }
    }

    function assign($id) {
        $this->session->set_userdata('top_menu', 'Fees Collection');
        $this->session->set_userdata('sub_menu', 'admin/feediscount');
        $data['id'] = $id;
        $data['title'] = 'student fees';
        $class = $this->class_model->get();
        $data['classlist'] = $class;
        $feediscount_result = $this->feediscount_model->get($id);
        $data['feediscountList'] = $feediscount_result;

        $genderList = $this->customlib->getGender();
        $data['genderList'] = $genderList;
        $RTEstatusList = $this->customlib->getRteStatus();
        $data['RTEstatusList'] = $RTEstatusList;
        $category = $this->category_model->get();
        $data['categorylist'] = $category;

        if ($this->input->server('REQUEST_METHOD') == 'POST') {

            $data['category_id'] = $this->input->post('category_id');
            $data['gender'] = $this->input->post('gender');
            $data['rte_status'] = $this->input->post('rte');
            $data['class_id'] = $this->input->post('class_id');
            $data['section_id'] = $this->input->post('section_id');

            $resultlist = $this->feediscount_model->searchAssignFeeByClassSection($data['class_id'], $data['section_id'], $id, $data['category_id'], $data['gender'], $data['rte_status']);
            $data['resultlist'] = $resultlist;
        }
        $this->load->view('layout/header', $data);
        $this->load->view('admin/feediscount/assign', $data);
        $this->load->view('layout/footer', $data);
    }

    function studentdiscount() {
        $this->session->set_userdata('top_menu', 'Fees Collection');
        $this->session->set_userdata('sub_menu', 'admin/feediscount');
        $this->form_validation->set_rules('feediscount_id', 'Fee Discount', 'required|trim|xss_clean');
        // $this->form_validation->set_rules('student_session_id[]', 'Student', 'required|trim|xss_clean');

        if ($this->form_validation->run() == false) {
            $data = array(
                'feediscount_id' => form_error('feediscount_id'),
                    // 'student_session_id[]' => form_error('student_session_id[]'),
            );
            $array = array('status' => 'fail', 'error' => $data);
            echo json_encode($array);
        } else {

            $student_list = $this->input->post('student_list');
            $feediscount_id = $this->input->post('feediscount_id');
            $student_sesssion_array = $this->input->post('student_session_id');
            if (!isset($student_sesssion_array)) {
                $student_sesssion_array = array();
            }
            $diff_aray = array_diff($student_list, $student_sesssion_array);
            $preserve_record = array();
            foreach ($student_sesssion_array as $key => $value) {

                $insert_array = array(
                    'student_session_id' => $value,
                    'fees_discount_id' => $feediscount_id,
                );
                $inserted_id = $this->feediscount_model->allotdiscount($insert_array);

                $preserve_record[] = $inserted_id;
            }
            if (!empty($diff_aray)) {
                $this->feediscount_model->deletedisstd($feediscount_id, $diff_aray);
            }

            $array = array('status' => 'success', 'error' => '', 'message' => 'Record Saved Successfully');
            echo json_encode($array);
        }
    }

    function applydiscount() {
        $this->form_validation->set_rules('discount_payment_id', 'Fees Payment Id', 'required|trim|xss_clean');
        $this->form_validation->set_rules('student_fees_discount_id', 'Fees Discount Id', 'required|trim|xss_clean');

        if ($this->form_validation->run() == false) {
            $data = array(
                'amount' => form_error('amount'),
                'discount_payment_id' => form_error('discount_payment_id'),
            );
            $array = array('status' => 'fail', 'error' => $data);
            echo json_encode($array);
        } else {

            $data = array(
                'id' => $this->input->post('student_fees_discount_id'),
                'payment_id' => $this->input->post('discount_payment_id'),
                'description' => $this->input->post('dis_description'),
                'status' => 'applied'
            );

            $this->feediscount_model->updateStudentDiscount($data);
            $array = array('status' => 'success', 'error' => '');
            echo json_encode($array);
        }
    }

}

?>