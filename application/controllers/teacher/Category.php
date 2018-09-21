<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class category extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('file');
        $this->lang->load('message', 'english');
        $this->load->library('auth');
        $this->auth->is_logged_in_teacher();
    }

    function index() {
        $this->session->set_userdata('top_menu', 'Student Information');
        $this->session->set_userdata('sub_menu', 'category/index');
        $data['title'] = 'Category List';
        $category_result = $this->category_model->get();
        $data['categorylist'] = $category_result;
        $this->load->view('layout/teacher/header', $data);
        $this->load->view('teacher/category/categoryList', $data);
        $this->load->view('layout/teacher/footer', $data);
    }

    function view($id) {
        $data['title'] = 'Category List';
        $category = $this->category_model->get($id);
        $data['category'] = $category;
        $this->load->view('layout/teacher/header', $data);
        $this->load->view('teacher/category/categoryShow', $data);
        $this->load->view('layout/teacher/footer', $data);
    }

    function delete($id) {
        $data['title'] = 'Category List';
        $this->category_model->remove($id);
        redirect('teacher/category/index');
    }

    function create() {
        $data['title'] = 'Add Category';
        $category_result = $this->category_model->get();
        $data['categorylist'] = $category_result;
        $this->form_validation->set_rules('category', 'Category', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/teacher/header', $data);
            $this->load->view('teacher/category/categoryList', $data);
            $this->load->view('layout/teacher/footer', $data);
        } else {
            $data = array(
                'category' => $this->input->post('category'),
            );
            $this->category_model->add($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">Category added successfully</div>');
            redirect('teacher/category/index');
        }
    }

    function edit($id) {
        $data['title'] = 'Edit Category';
        $category_result = $this->category_model->get();
        $data['categorylist'] = $category_result;
        $data['id'] = $id;
        $category = $this->category_model->get($id);
        $data['category'] = $category;
        $this->form_validation->set_rules('category', 'Category', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/teacher/header', $data);
            $this->load->view('teacher/category/categoryEdit', $data);
            $this->load->view('layout/teacher/footer', $data);
        } else {
            $data = array(
                'id' => $id,
                'category' => $this->input->post('category'),
            );
            $this->category_model->add($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">Category updated successfully</div>');
            redirect('teacher/category/index');
        }
    }

}

?>