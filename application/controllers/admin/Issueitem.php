<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Issueitem extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('file');
        $this->load->helper('form');
        $this->lang->load('message', 'english');
        $this->load->library('Customlib');
    }

    public function index() {
        $this->session->set_userdata('top_menu', 'Inventory');
        $this->session->set_userdata('sub_menu', 'issueitem/index');
        $data['title'] = 'Add Issue item';
        $data['title_list'] = 'Recent Issue items';
        $itemcategory = $this->itemissue_model->get();
        $data['itemissueList'] = $itemcategory;
        $this->load->view('layout/header', $data);
        $this->load->view('admin/issueitem/issueitemList', $data);
        $this->load->view('layout/footer', $data);
    }

    public function create() {
        $this->session->set_userdata('top_menu', 'Inventory');
        $this->session->set_userdata('sub_menu', 'issueitem/index');
        $data['title'] = 'Add Issue item';
        $data['title_list'] = 'Recent Issue items';
        $itemcategory = $this->itemcategory_model->get();
        $data['itemcatlist'] = $itemcategory;
        $this->load->view('layout/header', $data);
        $this->load->view('admin/issueitem/issueitemCreate', $data);
        $this->load->view('layout/footer', $data);
    }

    function add() {
        $this->form_validation->set_rules('account_type', 'Account Type', 'required|trim|xss_clean');
        $this->form_validation->set_rules('issue_to', 'Issue To', 'required|trim|xss_clean');
        $this->form_validation->set_rules('issue_by', 'Issue By', 'required|trim|xss_clean');
        $this->form_validation->set_rules('issue_date', 'Issue Date', 'required|trim|xss_clean');
        $this->form_validation->set_rules('note', 'Note', 'required|trim|xss_clean');
        $this->form_validation->set_rules('quantity', 'Quantity', 'required|trim|xss_clean');
        $this->form_validation->set_rules('item_category_id', 'Item Category', 'required|trim|xss_clean');
        $this->form_validation->set_rules('item_id', 'Item', 'required|trim|xss_clean');

        if ($this->form_validation->run() == false) {
            $data = array(
                'account_type' => form_error('account_type'),
                'issue_to' => form_error('issue_to'),
                'issue_by' => form_error('issue_by'),
                'issue_date' => form_error('issue_date'),
                'return_date' => form_error('return_date'),
                'item_category_id' => form_error('item_category_id'),
                'item_id' => form_error('item_id'),
                'quantity' => form_error('quantity'),
            );
            $array = array('status' => 'fail', 'error' => $data);
            echo json_encode($array);
        } else {
            $return_date = "";
            if (($this->input->post('return_date')) != "") {

                $return_date = date('Y-m-d', $this->customlib->datetostrtotime($this->input->post('return_date')));
            }
            $data = array(
                'issue_to' => $this->input->post('issue_to_name'),
                'issue_by' => $this->input->post('issue_by'),
                'issue_date' => date('Y-m-d', $this->customlib->datetostrtotime($this->input->post('issue_date'))),
                'return_date' => $return_date,
                'note' => $this->input->post('note'),
                'quantity' => $this->input->post('quantity'),
                'issue_type' => $this->input->post('account_type'),
                'item_category_id' => $this->input->post('item_category_id'),
                'item_id' => $this->input->post('item_id'),
            );
            $this->itemissue_model->add($data);
            $array = array('status' => 'success', 'error' => '', 'message' => 'Record Saved successfully');
            echo json_encode($array);
        }
    }

    function delete($id) {
        $data['title'] = 'Delete';
        $this->itemissue_model->remove($id);
        redirect('admin/issueitem');
    }

    public function getUser() {

        $usertype = $this->input->post('usertype');
        $result_final = array();
        $result = array();
        if ($usertype != "") {
            if ($usertype == "admin") {
                $result = $this->admin_model->get();
            } elseif ($usertype == "teacher") {
                $result = $this->teacher_model->get();
            } elseif ($usertype == "accountant") {
                $result = $this->accountant_model->get();
            } elseif ($usertype == "librarian") {
                $result = $this->librarian_model->get();
            } else {
                
            }
        }

        $result_final = array('usertype' => $usertype, 'result' => $result);
        echo json_encode($result_final);
    }

    public function returnItem() {

        $issue_id = $this->input->post('item_issue_id');

        if ($issue_id != "") {
            $data = array(
                'id' => $issue_id,
                'is_returned' => 0,
                'return_date' => date('Y-m-d')
            );
            $this->itemissue_model->add($data);
        }

        $result_final = array('status' => 'pass', 'message' => "Item retrun successfully");
        echo json_encode($result_final);
    }

}
