<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class itemsupplier extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('file');
        $this->load->helper('url');
        $this->lang->load('message', 'english');
    }

    function index() {
        $this->session->set_userdata('top_menu', 'Inventory');
        $this->session->set_userdata('sub_menu', 'itemsupplier/index');
        $data['title'] = 'Item Supplier List';
        $itemsupplier_result = $this->itemsupplier_model->get();
        $data['itemsupplierlist'] = $itemsupplier_result;
        $this->load->view('layout/header', $data);
        $this->load->view('admin/itemsupplier/itemsupplierList', $data);
        $this->load->view('layout/footer', $data);
    }

    // function view($id) {
    //     $data['title'] = 'Item Supplier List';
    //     $store = $this->itemsupplier_model->get($id);
    //     $data['store'] = $store;
    //     $this->load->view('layout/header', $data);
    //     $this->load->view('admin/incomehead/incomeheadShow', $data);
    //     $this->load->view('layout/footer', $data);
    // }

    function delete($id) {
        $data['title'] = 'Item Supplier List';
        $this->itemsupplier_model->remove($id);
        redirect('admin/itemsupplier/index');
    }

    function create() {
        $data['title'] = 'Add Item supplier';
        $itemsupplier_result = $this->itemsupplier_model->get();
        $data['itemsupplierlist'] = $itemsupplier_result;

        $this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('phone', 'Phone', 'trim|numeric|xss_clean');
        $this->form_validation->set_rules('email', 'Email', 'trim|xss_clean|valid_email');
        $this->form_validation->set_rules('contact_person_phone', 'Phone', 'trim|numeric|xss_clean');
        $this->form_validation->set_rules('contact_person_email', 'Email', 'trim|xss_clean|valid_email');


        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/header', $data);
            $this->load->view('admin/itemsupplier/itemsupplierList', $data);
            $this->load->view('layout/footer', $data);
        } else {
            
             
            $data = array(
                'phone' => $this->input->post('phone'),
                'contact_person_phone' => $this->input->post('contact_person_phone'),
                'item_supplier' => $this->input->post('name'),
                'email' => $this->input->post('email'),
                'address' => $this->input->post('address'),
                'contact_person_name' => $this->input->post('contact_person_name'),
                'contact_person_email' => $this->input->post('contact_person_email'),
                'description' => $this->input->post('description'),
            );
            $this->itemsupplier_model->add($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">Item Supplier added successfully</div>');
            redirect('admin/itemsupplier/index');
        }
    }

    function edit($id) {
        $data['title'] = 'Edit Item Supplier';
        $itemsupplier_result = $this->itemsupplier_model->get();
        $data['itemsupplierlist'] = $itemsupplier_result;
        $data['id'] = $id;
        $store = $this->itemsupplier_model->get($id);
        $data['itemsupplier'] = $store;

        $this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('phone', 'Phone', 'trim|numeric|xss_clean');
        $this->form_validation->set_rules('email', 'Email', 'trim|xss_clean|valid_email');
        $this->form_validation->set_rules('contact_person_phone', 'Phone', 'trim|numeric|xss_clean');
        $this->form_validation->set_rules('contact_person_email', 'Email', 'trim|xss_clean|valid_email');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/header', $data);
            $this->load->view('admin/itemsupplier/itemsupplierEdit', $data);
            $this->load->view('layout/footer', $data);
        } else {
         
                 
            $data = array(
                'id' => $id,
                'item_supplier' => $this->input->post('name'),
                    'phone' => $this->input->post('phone'),
                'contact_person_phone' => $this->input->post('contact_person_phone'),
                'email' => $this->input->post('email'),
                'address' => $this->input->post('address'),
                'contact_person_name' => $this->input->post('contact_person_name'),
              
                'contact_person_email' => $this->input->post('contact_person_email'),
                'description' => $this->input->post('description'),
            );
            $this->itemsupplier_model->add($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success">Item Supplier updated successfully</div>');
            redirect('admin/itemsupplier/index');
        }
    }

}

?>