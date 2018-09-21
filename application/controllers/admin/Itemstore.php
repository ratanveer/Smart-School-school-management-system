<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class itemstore extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('file');
        $this->load->helper('url');
        $this->lang->load('message', 'english');
    }

    function index() {
        $this->session->set_userdata('top_menu', 'Inventory');
        $this->session->set_userdata('sub_menu', 'itemstore/index');
        $data['title'] = 'Item Store List';
        $itemstore_result = $this->itemstore_model->get();
        $data['itemstorelist'] = $itemstore_result;
        $this->load->view('layout/header', $data);
        $this->load->view('admin/itemstore/itemstoreList', $data);
        $this->load->view('layout/footer', $data);
    }

  

    function delete($id) {
        $data['title'] = 'Item Store List';
        $this->itemstore_model->remove($id);
        redirect('admin/itemstore/index');
    }

    function create() {
        $data['title'] = 'Add Item store';
        $itemstore_result = $this->itemstore_model->get();
        $data['itemstorelist'] = $itemstore_result;

        $this->form_validation->set_rules('name', 'Item Store', 'trim|required|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/header', $data);
            $this->load->view('admin/itemstore/itemstoreList', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $data = array(
                'item_store' => $this->input->post('name'),
                'code' => $this->input->post('code'),
                'description' => $this->input->post('description'),
            );
            $this->itemstore_model->add($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">Item Store added successfully</div>');
            redirect('admin/itemstore/index');
        }
    }

    function edit($id) {
        $data['title'] = 'Edit Item Store';
        $itemstore_result = $this->itemstore_model->get();
        $data['itemstorelist'] = $itemstore_result;
        $data['id'] = $id;
        $store = $this->itemstore_model->get($id);
        $data['itemstore'] = $store;

        $this->form_validation->set_rules('name', 'Item Store name', 'trim|required|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/header', $data);
            $this->load->view('admin/itemstore/itemstoreEdit', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $data = array(
                'id' => $id,
                'item_store' => $this->input->post('name'),
                'code' => $this->input->post('code'),
                'description' => $this->input->post('description'),
            );
            $this->itemstore_model->add($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success">Item Store updated successfully</div>');
            redirect('admin/itemstore/index');
        }
    }

}

?>