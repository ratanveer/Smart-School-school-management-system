<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class expensehead extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('file');
        $this->lang->load('message', 'english');
        $this->load->library('auth');
        $this->auth->is_logged_in_teacher();
    }

    function index() {
        $this->session->set_userdata('top_menu', 'Expenses');
        $this->session->set_userdata('sub_menu', 'expenseshead/index');
        $data['title'] = 'Expense Head List';
        $category_result = $this->expensehead_model->get();
        $data['categorylist'] = $category_result;
        $this->load->view('layout/teacher/header', $data);
        $this->load->view('teacher/expensehead/expenseheadList', $data);
        $this->load->view('layout/teacher/footer', $data);
    }

    function view($id) {
        $data['title'] = 'Expense Head List';
        $category = $this->expensehead_model->get($id);
        $data['category'] = $category;
        $this->load->view('layout/teacher/header', $data);
        $this->load->view('teacher/expensehead/expenseheadShow', $data);
        $this->load->view('layout/teacher/footer', $data);
    }

    function delete($id) {
        $data['title'] = 'Expense Head List';
        $this->expensehead_model->remove($id);
        redirect('teacher/expensehead/index');
    }

    function create() {
        $data['title'] = 'Add Expense Head';
        $category_result = $this->expensehead_model->get();
        $data['categorylist'] = $category_result;
        $this->form_validation->set_rules('expensehead', 'Expense Head', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/teacher/header', $data);
            $this->load->view('teacher/expensehead/expenseheadList', $data);
            $this->load->view('layout/teacher/footer', $data);
        } else {
            $data = array(
                'exp_category' => $this->input->post('expensehead'),
            );
            $this->expensehead_model->add($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">Expense Head added successfully</div>');
            redirect('teacher/expensehead/index');
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
            $this->load->view('layout/teacher/header', $data);
            $this->load->view('teacher/expensehead/expenseheadEdit', $data);
            $this->load->view('layout/teacher/footer', $data);
        } else {
            $data = array(
                'id' => $id,
                'exp_category' => $this->input->post('expensehead'),
            );
            $this->expensehead_model->add($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success">Expense Head updated successfully</div>');
            redirect('teacher/expensehead/index');
        }
    }

}

?>