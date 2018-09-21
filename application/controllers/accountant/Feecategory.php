<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Feecategory extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('file');
        $this->lang->load('message', 'english');
        $this->load->library('auth');
        $this->auth->is_logged_in_accountant();
    }

    function delete($id) {
        $data['title'] = 'feecategory List';
        $this->feecategory_model->remove($id);
        $this->session->set_flashdata('success_msg', 'Record deleted successfully');
        redirect('accountant/feecategory');
    }

    function index() {
        $this->session->set_userdata('top_menu', 'Fees Collection');
        $this->session->set_userdata('sub_menu', 'feecategory/index');
        $feecategory_result = $this->feecategory_model->get();
        $data['feecategorylist'] = $feecategory_result;
        $this->form_validation->set_rules('name', 'Category', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/accountant/header', $data);
            $this->load->view('accountant/feecategory/feecategoryList', $data);
            $this->load->view('layout/accountant/footer', $data);
        } else {
            $data = array(
                'category' => $this->input->post('name'),
            );
            $this->feecategory_model->add($data);

            $this->session->set_flashdata('success_msg', 'Fees Category added succesfully');
            redirect('accountant/feecategory');
        }
    }

    function edit($id) {
        $this->session->set_userdata('top_menu', 'Fees Collection');
        $this->session->set_userdata('sub_menu', 'feecategory/index');
        $feecategory_result = $this->feecategory_model->get();
        $data['feecategorylist'] = $feecategory_result;
        $data['title'] = 'Edit feecategory';
        $data['id'] = $id;

        $feecategory = $this->feecategory_model->get($id);
        $data['feecategory'] = $feecategory;
        $this->form_validation->set_rules('name', 'category', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/accountant/header', $data);
            $this->load->view('accountant/feecategory/feecategoryEdit', $data);
            $this->load->view('layout/accountant/footer', $data);
        } else {
            $data = array(
                'id' => $id,
                'category' => $this->input->post('name'),
            );
            $this->feecategory_model->add($data);
            $this->session->set_flashdata('success_msg', 'Fees Category updated  successfully');
            redirect('accountant/feecategory');
        }
    }

}

?>