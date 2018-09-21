<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class expensehead extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('file');
        $this->lang->load('message', 'english');
    }

    function index() {
        $this->session->set_userdata('top_menu', 'Expenses');
        $this->session->set_userdata('sub_menu', 'expenseshead/index');
        $data['title'] = 'Expense Head List';
        $category_result = $this->expensehead_model->get();
        $data['categorylist'] = $category_result;
        $this->load->view('layout/header', $data);
        $this->load->view('admin/expensehead/expenseheadList', $data);
        $this->load->view('layout/footer', $data);
    }

    function view($id) {
        $data['title'] = 'Expense Head List';
        $category = $this->expensehead_model->get($id);
        $data['category'] = $category;
        $this->load->view('layout/header', $data);
        $this->load->view('admin/expensehead/expenseheadShow', $data);
        $this->load->view('layout/footer', $data);
    }

    function delete($id) {
        $data['title'] = 'Expense Head List';
        $this->expensehead_model->remove($id);
        redirect('admin/expensehead/index');
    }

    function create() {
        $data['title'] = 'Add Expense Head';
        $category_result = $this->expensehead_model->get();
        $data['categorylist'] = $category_result;
        $this->form_validation->set_rules('expensehead', 'Expense Head', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/header', $data);
            $this->load->view('admin/expensehead/expenseheadList', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $data = array(
                'exp_category' => $this->input->post('expensehead'),
                'description' => $this->input->post('description'),
            );
            $this->expensehead_model->add($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">Expense Head added successfully</div>');
            redirect('admin/expensehead/index');
        }
    }

    function edit($id) {
        $data['title'] = 'Edit Expense Head';
        $category_result = $this->expensehead_model->get();
        $data['categorylist'] = $category_result;
        $data['id'] = $id;
        $category = $this->expensehead_model->get($id);
        $data['expensehead'] = $category;
        $this->form_validation->set_rules('expensehead', 'Expense Head', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/header', $data);
            $this->load->view('admin/expensehead/expenseheadEdit', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $data = array(
                'id' => $id,
                'exp_category' => $this->input->post('expensehead'),
                'description' => $this->input->post('description'),
            );
            $this->expensehead_model->add($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success">Expense Head updated successfully</div>');
            redirect('admin/expensehead/index');
        }
    }

}

?>