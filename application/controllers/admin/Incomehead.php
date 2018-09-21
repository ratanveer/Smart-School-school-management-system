<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class incomehead extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('file');
        $this->load->helper('url');
        $this->lang->load('message', 'english');
    }

    function index() {
        $this->session->set_userdata('top_menu', 'Income');
        $this->session->set_userdata('sub_menu', 'incomeshead/index');
        $data['title'] = 'Income Head List';
        $category_result = $this->incomehead_model->get();
        $data['categorylist'] = $category_result;
        $this->load->view('layout/header', $data);
        $this->load->view('admin/incomehead/incomeheadList', $data);
        $this->load->view('layout/footer', $data);
    }

    function view($id) {
        $data['title'] = 'Income Head List';
        $category = $this->incomehead_model->get($id);
        $data['category'] = $category;
        $this->load->view('layout/header', $data);
        $this->load->view('admin/incomehead/incomeheadShow', $data);
        $this->load->view('layout/footer', $data);
    }

    function delete($id) {
        $data['title'] = 'Income Head List';
        $this->incomehead_model->remove($id);
        redirect('admin/incomehead/index');
    }

    function create() {
        $data['title'] = 'Add Income Head';
        $category_result = $this->incomehead_model->get();
        $data['categorylist'] = $category_result;
        $this->form_validation->set_rules('incomehead', 'Income Head', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/header', $data);
            $this->load->view('admin/incomehead/incomeheadList', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $data = array(
                'income_category' => $this->input->post('incomehead'),
                'description' => $this->input->post('description'),
            );
            $this->incomehead_model->add($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">Income Head added successfully</div>');
            redirect('admin/incomehead/index');
        }
    }

    function edit($id) {
        $data['title'] = 'Edit Income Head';
        $category_result = $this->incomehead_model->get();
        $data['categorylist'] = $category_result;
        $data['id'] = $id;
        $category = $this->incomehead_model->get($id);
        $data['incomehead'] = $category;
        $this->form_validation->set_rules('incomehead', 'Income Head', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/header', $data);
            $this->load->view('admin/incomehead/incomeheadEdit', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $data = array(
                'id' => $id,
                'income_category' => $this->input->post('incomehead'),
                'description' => $this->input->post('description'),
            );
            $this->incomehead_model->add($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success">Income Head updated successfully</div>');
            redirect('admin/incomehead/index');
        }
    }

}

?>