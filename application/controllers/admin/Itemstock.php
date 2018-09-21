<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Itemstock extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('file');
        $this->load->helper('form');
        $this->lang->load('message', 'english');
        $this->load->library('Customlib');
    }

    function index() {
        $this->session->set_userdata('top_menu', 'Inventory');
        $this->session->set_userdata('sub_menu', 'Itemstock/index');
        $data['title'] = 'Add Item';
        $data['title_list'] = 'Recent Items';

        $this->form_validation->set_rules('item_id', 'Item', 'trim|required|xss_clean');
        $this->form_validation->set_rules('quantity', 'Quantity', 'trim|required|xss_clean');
        $this->form_validation->set_rules('item_category_id', 'Item Category', 'trim|required|xss_clean');


        if ($this->form_validation->run() == FALSE) {
            
        } else {
            $store_id = ($this->input->post('store_id')) ? $this->input->post('store_id') : NULL;
            $data = array(
                'item_id' => $this->input->post('item_id'),
                'symbol' => $this->input->post('symbol'),
                'supplier_id' => $this->input->post('supplier_id'),
                'store_id' => $store_id,
                'quantity' => $this->input->post('symbol') . $this->input->post('quantity'),
                'date' => date('Y-m-d', $this->customlib->datetostrtotime($this->input->post('date'))),
                'description' => $this->input->post('description'),
            );
            $insert_id = $this->itemstock_model->add($data);
            if (isset($_FILES["item_photo"]) && !empty($_FILES['item_photo']['name'])) {
                $fileInfo = pathinfo($_FILES["item_photo"]["name"]);
                $img_name = $insert_id . '.' . $fileInfo['extension'];
                move_uploaded_file($_FILES["item_photo"]["tmp_name"], "./uploads/inventory_items/" . $img_name);
                $data_img = array('id' => $insert_id, 'attachment' => 'uploads/inventory_items/' . $img_name);
                $this->itemstock_model->add($data_img);
            }

            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">Item added successfully</div>');
            redirect('admin/itemstock/index');
        }
        $item_result = $this->itemstock_model->get();
        $data['itemlist'] = $item_result;
        $itemcategory = $this->itemcategory_model->get();
        $data['itemcatlist'] = $itemcategory;
        $itemsupplier = $this->itemsupplier_model->get();
        $data['itemsupplier'] = $itemsupplier;
        $itemstore = $this->itemstore_model->get();
        $data['itemstore'] = $itemstore;
        $this->load->view('layout/header', $data);
        $this->load->view('admin/itemstock/itemList', $data);
        $this->load->view('layout/footer', $data);
    }

    public function download($file) {
        $this->load->helper('download');
        $filepath = "./uploads/inventory_items/" . $this->uri->segment(6);
        $data = file_get_contents($filepath);
        $name = $this->uri->segment(6);
        force_download($name, $data);
    }

    function getItemByCategory() {
        $item_category_id = $this->input->get('item_category_id');
        $data = $this->item_model->getItemByCategory($item_category_id);
        echo json_encode($data);
    }

    function delete($id) {
        $data['title'] = 'Fees Master List';
        $this->itemstock_model->remove($id);
        redirect('admin/itemstock/index');
    }

    function handle_upload() {
        if (isset($_FILES["file"]) && !empty($_FILES['file']['name'])) {
            $allowedExts = array('jpg', 'jpeg', 'png');
            $temp = explode(".", $_FILES["file"]["name"]);
            $extension = end($temp);
            if ($_FILES["file"]["error"] > 0) {
                $error .= "Error opening the file<br />";
            }
            if ($_FILES["file"]["type"] != 'image/gif' &&
                    $_FILES["file"]["type"] != 'image/jpeg' &&
                    $_FILES["file"]["type"] != 'image/png') {

                $this->form_validation->set_message('handle_upload', 'File type not allowed');
                return false;
            }
            if (!in_array($extension, $allowedExts)) {

                $this->form_validation->set_message('handle_upload', 'Extension not allowed');
                return false;
            }
            if ($_FILES["file"]["size"] > 10240000) {

                $this->form_validation->set_message('handle_upload', 'File size shoud be less than 100 kB');
                return false;
            }
            if ($error == "") {
                return true;
            }
        } else {
            return true;
        }
    }

    function edit($id) {
        $data['title'] = 'Edit Fees Master';
        $data['id'] = $id;
        $item = $this->itemstock_model->get($id);
        $data['item'] = $item;
        $data['title_list'] = 'Fees Master List';
        $item_result = $this->itemstock_model->get();
        $data['itemlist'] = $item_result;
        $itemcategory = $this->itemcategory_model->get();
        $data['itemcatlist'] = $itemcategory;
        $itemsupplier = $this->itemsupplier_model->get();
        $data['itemsupplier'] = $itemsupplier;
        $itemstore = $this->itemstore_model->get();
        $data['itemstore'] = $itemstore;


        $this->form_validation->set_rules('item_id', 'Item', 'trim|required|xss_clean');
        $this->form_validation->set_rules('item_category_id', 'Item Category', 'trim|required|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/header', $data);
            $this->load->view('admin/itemstock/itemEdit', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $store_id = ($this->input->post('store_id')) ? $this->input->post('store_id') : NULL;
            $data = array(
                'id' => $id,
                'item_id' => $this->input->post('item_id'),
                'symbol' => $this->input->post('symbol'),
                'supplier_id' => $this->input->post('supplier_id'),
                'store_id' => $store_id,
                'quantity' => $this->input->post('symbol') . $this->input->post('quantity'),
                'date' => date('Y-m-d', $this->customlib->datetostrtotime($this->input->post('date'))),
                'description' => $this->input->post('description'),
            );
            
          $this->itemstock_model->add($data);


            if (isset($_FILES["item_photo"]) && !empty($_FILES['item_photo']['name'])) {
                $fileInfo = pathinfo($_FILES["item_photo"]["name"]);
                $img_name = $id . '.' . $fileInfo['extension'];
                move_uploaded_file($_FILES["item_photo"]["tmp_name"], "./uploads/inventory_items/" . $img_name);
                $data_img = array('id' => $id, 'attachment' => 'uploads/inventory_items/' . $img_name);
   
                $this->itemstock_model->add($data_img);
            }
          
            // $this->itemstock_model->add($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">Item stock updated successfully</div>');
            redirect('admin/itemstock/index');
        }
    }

}

?>