<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Expensehead extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('file');
        $this->lang->load('message', 'english');
        $this->load->library('auth');
        $this->auth->is_logged_in_accountant();
    }

    function view($id) {
        $this->session->set_userdata('top_menu', 'Expenses');
        $this->session->set_userdata('sub_menu', 'expenseshead/index');
        $data['title'] = 'Expense Head List';
        $category = $this->expensehead_model->get($id);
        $data['category'] = $category;
        $this->load->view('layout/accountant/header', $data);
        $this->load->view('accountant/expensehead/expenseheadShow', $data);
        $this->load->view('layout/accountant/footer', $data);
    }

    function index() {
        $this->session->set_userdata('top_menu', 'Expenses');
        $this->session->set_userdata('sub_menu', 'expenseshead/index');
        $data['title'] = 'Add Expense Head';
        $category_result = $this->expensehead_model->get();
        $data['categorylist'] = $category_result;
        $this->form_validation->set_rules('expensehead', 'Expense Head', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/accountant/header', $data);
            $this->load->view('accountant/expensehead/expenseheadList', $data);
            $this->load->view('layout/accountant/footer', $data);
        } else {
            $data = array(
                'exp_category' => $this->input->post('expensehead'),
                'description' => $this->input->post('description'),
            );
            $this->expensehead_model->add($data);

            $this->session->set_flashdata('success_msg', 'Expense Head added successfully');
            redirect('accountant/expensehead/index');
        }
    }

    function edit($id) {
        $this->session->set_userdata('top_menu', 'Expenses');
        $this->session->set_userdata('sub_menu', 'expenseshead/index');
        $data['title'] = 'Edit Expense Head';
        $category_result = $this->expensehead_model->get();
        $data['categorylist'] = $category_result;
        $data['id'] = $id;
        $category = $this->expensehead_model->get($id);
        $data['expensehead'] = $category;
        $this->form_validation->set_rules('expensehead', 'Expense Head', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/accountant/header', $data);
            $this->load->view('accountant/expensehead/expenseheadEdit', $data);
            $this->load->view('layout/accountant/footer', $data);
        } else {
            $data = array(
                'id' => $id,
                'exp_category' => $this->input->post('expensehead'),
                'description' => $this->input->post('description'),
            );
            $this->expensehead_model->add($data);

            $this->session->set_flashdata('success_msg', 'Expense Head updated successfully');
            redirect('accountant/expensehead/index');
        }
    }

    function delete($id) {
        $this->session->set_userdata('top_menu', 'Expenses');
        $this->session->set_userdata('sub_menu', 'expenseshead/index');
        $data['title'] = 'Expense Head List';
        $this->expensehead_model->remove($id);
        $this->session->set_flashdata('success_msg', 'Record deleted successfully');
        redirect('accountant/expensehead/index');
    }

}

?>