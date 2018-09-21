<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class feetype extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('file');
        $this->lang->load('message', 'english');
        $this->load->library('auth');
        $this->auth->is_logged_in_teacher();
    }

    function index() {
        $this->session->set_userdata('top_menu', 'Fees Collection');
        $this->session->set_userdata('sub_menu', 'feetype/index');
        $data['title'] = 'Add Fees Type';
        $data['title_list'] = 'Fees Type List';
        $feetype_result = $this->feetype_model->get();
        $data['feetypelist'] = $feetype_result;
        $feecategory = $this->feecategory_model->getbyasc();
        $data['feecategorylist'] = $feecategory;
        $array = array();
        $feecategory = $this->feecategory_model->get();
        foreach ($feecategory as $key => $value) {
            $dataarray = array();
            $value_id = $value['id'];
            $dataarray[$value_id] = $value['category'];
            $category = $value['category'];
            $datatype = array();
            $data_fee_type = array();
            $feetype = $this->feetype_model->getFeetypeByCategory($value['id']);
            foreach ($feetype as $feekey => $feevalue) {
                $ftype = $feevalue['id'];
                $datatype[$ftype] = $feevalue['type'];
            }
            $data_fee_type[] = $datatype;
            $dataarray[$category] = $datatype;
            $array[] = $dataarray;
        }
        $data['category_array'] = $array;
        $data['feecategory'] = $feecategory;
        $this->form_validation->set_rules('feecategory_id', 'Fee Category', 'trim|required|xss_clean');
        $this->form_validation->set_rules('type', 'Fee Type', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/teacher/header', $data);
            $this->load->view('teacher/feetype/feetypeList', $data);
            $this->load->view('layout/teacher/footer', $data);
        } else {
            $data = array(
                'feecategory_id' => $this->input->post('feecategory_id'),
                'type' => $this->input->post('type'),
            );
            $this->feetype_model->add($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">Fees Type added successfully</div>');
            redirect('teacher/feetype/index');
        }
    }

    function view($id) {
        $data['title'] = 'Fees Type List';
        $feetype = $this->feetype_model->get($id);
        $data['feetype'] = $feetype;
        $this->load->view('layout/teacher/header', $data);
        $this->load->view('teacher/feetype/feetypeShow', $data);
        $this->load->view('layout/teacher/footer', $data);
    }

    function delete($id) {
        $data['title'] = 'Fees Type List';
        $this->feetype_model->remove($id);
        redirect('teacher/feetype/index');
    }

    function create() {
        $data['title'] = 'Add Fees Type';
        $this->form_validation->set_rules('feetype', 'Fees Type', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/teacher/header', $data);
            $this->load->view('teacher/feetype/feetypeCreate', $data);
            $this->load->view('layout/teacher/footer', $data);
        } else {
            $data = array(
                'feetype' => $this->input->post('feetype'),
            );
            $this->feetype_model->add($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">Fees Type details added successfully!!!</div>');
            redirect('teacher/feetype/index');
        }
    }

    function edit($id) {
        $data['title'] = 'Add Fees Type';
        $data['title_list'] = 'Fees Type List';
        $feetype_result = $this->feetype_model->get();
        $data['feetypelist'] = $feetype_result;
        $feecategory = $this->feecategory_model->get();
        $data['feecategorylist'] = $feecategory;
        $array = array();
        $feecategory = $this->feecategory_model->get();
        foreach ($feecategory as $key => $value) {
            $dataarray = array();
            $value_id = $value['id'];
            $dataarray[$value_id] = $value['category'];
            $category = $value['category'];
            $datatype = array();
            $data_fee_type = array();
            $feetype = $this->feetype_model->getFeetypeByCategory($value['id']);
            foreach ($feetype as $feekey => $feevalue) {
                $ftype = $feevalue['id'];
                $datatype[$ftype] = $feevalue['type'];
            }
            $data_fee_type[] = $datatype;
            $dataarray[$category] = $datatype;
            $array[] = $dataarray;
        }
        $data['category_array'] = $array;
        $data['feecategory'] = $feecategory;
        $data['title'] = 'Edit Fees Type';
        $data['id'] = $id;
        $feetype = $this->feetype_model->get($id);
        $data['feetype'] = $feetype;
        $data['title_list'] = 'Fees Type List';
        $feetype_result = $this->feetype_model->get();
        $data['feetypelist'] = $feetype_result;
        $feecategory = $this->feecategory_model->get();
        $data['feecategorylist'] = $feecategory;
        $this->form_validation->set_rules('feecategory_id', 'Fee Category', 'trim|required|xss_clean');
        $this->form_validation->set_rules('type', 'Fee Type', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/teacher/header', $data);
            $this->load->view('teacher/feetype/feetypeEdit', $data);
            $this->load->view('layout/teacher/footer', $data);
        } else {
            $data = array(
                'id' => $id,
                'feecategory_id' => $this->input->post('feecategory_id'),
                'type' => $this->input->post('type'),
            );
            $this->feetype_model->add($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">Fees Type updated successfully</div>');
            redirect('teacher/feetype/index');
        }
    }

}

?>