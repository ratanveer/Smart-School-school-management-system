<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Feemaster extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('file');
        $this->lang->load('message', 'english');
        $this->load->library('auth');
        $this->auth->is_logged_in_accountant();
    }

    function index() {
        $this->session->set_userdata('top_menu', 'Fees Collection');
        $this->session->set_userdata('sub_menu', 'feemaster/index');
        $data['title'] = 'Feemaster List';
        $feegroup = $this->feegroup_model->get();
        $data['feegroupList'] = $feegroup;
        $feetype = $this->feetype_model->get();
        $data['feetypeList'] = $feetype;

        $feegroup_result = $this->feesessiongroup_model->getFeesByGroup();
        $data['feemasterList'] = $feegroup_result;


        $this->form_validation->set_rules('fee_groups_id', 'FeeGroup', 'required');
        $this->form_validation->set_rules('feetype_id', 'FeeType', 'required');
        $this->form_validation->set_rules('amount', 'Amount', 'required');

        if ($this->form_validation->run() == FALSE) {
            
        } else {


            $insert_array = array(
                'fee_groups_id' => $this->input->post('fee_groups_id'),
                'feetype_id' => $this->input->post('feetype_id'),
                'amount' => $this->input->post('amount'),
                'due_date' => date('Y-m-d', $this->customlib->datetostrtotime($this->input->post('due_date'))),
                'session_id' => $this->setting_model->getCurrentSession()
            );
            $feegroup_result = $this->feesessiongroup_model->add($insert_array);



            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">Fees Master added successfully</div>');
            redirect('accountant/feemaster/index');
        }

        $this->load->view('layout/accountant/header', $data);
        $this->load->view('accountant/feemaster/feemasterList', $data);
        $this->load->view('layout/accountant/footer', $data);
    }

    function delete($id) {
        $data['title'] = 'Fees Master List';
        $this->feegrouptype_model->remove($id);
        redirect('accountant/feemaster/index');
    }

    function deletegrp($id) {
        $data['title'] = 'Fees Master List';
        $this->feesessiongroup_model->remove($id);
        redirect('admin/feemaster');
    }

    function edit($id) {
        $this->session->set_userdata('top_menu', 'Fees Collection');
        $this->session->set_userdata('sub_menu', 'feemaster/index');
        $data['id'] = $id;
        $feegroup_type = $this->feegrouptype_model->get($id);
        $data['feegroup_type'] = $feegroup_type;

        $feegroup = $this->feegroup_model->get();
        $data['feegroupList'] = $feegroup;
        $feetype = $this->feetype_model->get();
        $data['feetypeList'] = $feetype;
        $feegroup_result = $this->feesessiongroup_model->getFeesByGroup();
        $data['feemasterList'] = $feegroup_result;

        $this->form_validation->set_rules('fee_groups_id', 'FeeGroup', 'required');
        $this->form_validation->set_rules('feetype_id', 'FeeType', 'required');
        $this->form_validation->set_rules('amount', 'Amount', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/accountant/header', $data);
            $this->load->view('accountant/feemaster/feemasterEdit', $data);
            $this->load->view('layout/accountant/footer', $data);
        } else {
            $insert_array = array(
                'id' => $this->input->post('id'),
                'feetype_id' => $this->input->post('feetype_id'),
                'due_date' => date('Y-m-d', $this->customlib->datetostrtotime($this->input->post('due_date'))),
                'amount' => $this->input->post('amount')
            );
            $feegroup_result = $this->feegrouptype_model->add($insert_array);

            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">Fees Master updated successfully</div>');
            redirect('accountant/feemaster/index');
        }
    }

    function assign($id) {
        $this->session->set_userdata('top_menu', 'Fees Collection');
        $this->session->set_userdata('sub_menu', 'feemaster/index');
        $data['id'] = $id;
        $data['title'] = 'student fees';
        $class = $this->class_model->get();
        $data['classlist'] = $class;
        $feegroup_result = $this->feesessiongroup_model->getFeesByGroup($id);
        $data['feegroupList'] = $feegroup_result;


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

            $resultlist = $this->studentfeemaster_model->searchAssignFeeByClassSection($data['class_id'], $data['section_id'], $id, $data['category_id'], $data['gender'], $data['rte_status']);
            $data['resultlist'] = $resultlist;
        }
        $this->load->view('layout/accountant/header', $data);
        $this->load->view('accountant/feemaster/assign', $data);
        $this->load->view('layout/accountant/footer', $data);
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