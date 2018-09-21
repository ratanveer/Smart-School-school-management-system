<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class itemcategory extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('file');
        $this->load->helper('url');
        $this->lang->load('message', 'english');
    }

    function index() {
        $this->session->set_userdata('top_menu', 'Inventory');
        $this->session->set_userdata('sub_menu', 'itemcategory/index');
        $data['title'] = 'Item Categorey List';
        $category_result = $this->itemcategory_model->get();
        $data['categorylist'] = $category_result;
        $this->load->view('layout/header', $data);
        $this->load->view('admin/itemcategory/itemcategoryList', $data);
        $this->load->view('layout/footer', $data);
    }

    function delete($id) {
        $data['title'] = 'Item Categorey List';
        $this->itemcategory_model->remove($id);
        redirect('admin/itemcategory/index');
    }

    function create() {
        $data['title'] = 'Add Item category';
        $category_result = $this->itemcategory_model->get();
        $data['categorylist'] = $category_result;
        $this->form_validation->set_rules('itemcategory', 'Item Categorey', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/header', $data);
            $this->load->view('admin/itemcategory/itemcategoryList', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $data = array(
                'item_category' => $this->input->post('itemcategory'),
                'description' => $this->input->post('description'),
            );
            $this->itemcategory_model->add($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">Item Categorey added successfully</div>');
            redirect('admin/itemcategory/index');
        }
    }

    function edit($id) {
        $data['title'] = 'Edit Item Categorey';
        $category_result = $this->itemcategory_model->get();
        $data['categorylist'] = $category_result;
        $data['id'] = $id;
        $category = $this->itemcategory_model->get($id);
        $data['itemcategory'] = $category;
        $this->form_validation->set_rules('itemcategory', 'Item Categorey', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/header', $data);
            $this->load->view('admin/itemcategory/itemcategoryEdit', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $data = array(
                'id' => $id,
                'item_category' => $this->input->post('itemcategory'),
                'description' => $this->input->post('description'),
            );
            $this->itemcategory_model->add($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success">Item Categorey updated successfully</div>');
            redirect('admin/itemcategory/index');
        }
    }

}

?>