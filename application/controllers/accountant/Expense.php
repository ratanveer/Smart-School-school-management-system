<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Expense extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('file');
        $this->lang->load('message', 'english');
        $this->load->library('auth');
        $this->auth->is_logged_in_accountant();
    }

    function index() {
        $this->session->set_userdata('top_menu', 'Expenses');
        $this->session->set_userdata('sub_menu', 'expense/index');
        $data['title'] = 'Add Expense';
        $data['title_list'] = 'Recent Expenses';
        $this->form_validation->set_rules('exp_head_id', 'Expense Head', 'trim|required|xss_clean');
        $this->form_validation->set_rules('amount', 'Amount', 'trim|required|xss_clean');
        $this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('date', 'Date', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            
        } else {
              $data = array(
                'exp_head_id' => $this->input->post('exp_head_id'),
                'name' => $this->input->post('name'),
                'date' => date('Y-m-d', $this->customlib->datetostrtotime($this->input->post('date'))),
                'amount' => $this->input->post('amount'),
                'note' => $this->input->post('description'),
                'documents' => $this->input->post('documents')
            );
            $insert_id = $this->expense_model->add($data);
            if (isset($_FILES["documents"]) && !empty($_FILES['documents']['name'])) {
                $fileInfo = pathinfo($_FILES["documents"]["name"]);
                $img_name = $insert_id . '.' . $fileInfo['extension'];
                move_uploaded_file($_FILES["documents"]["tmp_name"], "./uploads/school_expense/" . $img_name);
                $data_img = array('id' => $insert_id, 'documents' => 'uploads/school_expense/' . $img_name);
                $this->expense_model->add($data_img);
            }
         

            $this->session->set_flashdata('success_msg', 'Expense added successfully');
            redirect('accountant/expense/index');
        }
        $expense_result = $this->expense_model->get();
        $data['expenselist'] = $expense_result;
        $expnseHead = $this->expensehead_model->get();
        $data['expheadlist'] = $expnseHead;
        $this->load->view('layout/accountant/header', $data);
        $this->load->view('accountant/expense/expenseList', $data);
        $this->load->view('layout/accountant/footer', $data);
    }

    function view($id) {
        $data['title'] = 'Fees Master List';
        $expense = $this->expense_model->get($id);
        $data['expense'] = $expense;
        $this->load->view('layout/accountant/header', $data);
        $this->load->view('expense/expenseShow', $data);
        $this->load->view('layout/accountant/footer', $data);
    }

    function getByFeecategory() {
        $feecategory_id = $this->input->get('feecategory_id');
        $data = $this->feetype_model->getTypeByFeecategory($feecategory_id);
        echo json_encode($data);
    }

    function getStudentCategoryFee() {
        $type = $this->input->post('type');
        $class_id = $this->input->post('class_id');
        $data = $this->expense_model->getTypeByFeecategory($type, $class_id);
        if (empty($data)) {
            $status = 'fail';
        } else {
            $status = 'success';
        }
        $array = array('status' => $status, 'data' => $data);
        echo json_encode($array);
    }

    function delete($id) {
        $data['title'] = 'Fees Master List';
        $this->expense_model->remove($id);
        $this->session->set_flashdata('success_msg', 'Record deleted successfully');
        redirect('accountant/expense/index');
    }

    function edit($id) {
        $data['title'] = 'Edit Fees Master';
        $data['id'] = $id;
        $expense = $this->expense_model->get($id);
        $data['expense'] = $expense;
        $data['title_list'] = 'Fees Master List';
        $expense_result = $this->expense_model->get();
        $data['expenselist'] = $expense_result;
        $expnseHead = $this->expensehead_model->get();
        $data['expheadlist'] = $expnseHead;
        $this->form_validation->set_rules('exp_head_id', 'Expense Head', 'trim|required|xss_clean');
        $this->form_validation->set_rules('amount', 'Amount', 'trim|required|xss_clean');
        $this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('date', 'Date', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/accountant/header', $data);
            $this->load->view('accountant/expense/expenseEdit', $data);
            $this->load->view('layout/accountant/footer', $data);
        } else {
            $data = array(
                'id' => $id,
                'exp_head_id' => $this->input->post('exp_head_id'),
                'name' => $this->input->post('name'),
                'date' => date('Y-m-d', $this->customlib->datetostrtotime($this->input->post('date'))),
                'amount' => $this->input->post('amount'),
                'note' => $this->input->post('description'),
            );
            $insert_id = $this->expense_model->add($data);
            if (isset($_FILES["documents"]) && !empty($_FILES['documents']['name'])) {
                $fileInfo = pathinfo($_FILES["documents"]["name"]);
                $img_name = $id . '.' . $fileInfo['extension'];
                move_uploaded_file($_FILES["documents"]["tmp_name"], "./uploads/school_expense/" . $img_name);
                $data_img = array('id' => $id, 'documents' => 'uploads/school_expense/' . $img_name);
                $this->expense_model->add($data_img);
            }

            $this->session->set_flashdata('success_msg', 'Expense updated successfully');
            redirect('accountant/expense/index');
        }
    }


   public function download($documents) {
        $this->load->helper('download');
        $filepath = "./uploads/school_expense/" . $this->uri->segment(6);
        $data = file_get_contents($filepath);
        $name = $this->uri->segment(6);
        force_download($name, $data);
    }

    function expenseSearch() {
        $this->session->set_userdata('top_menu', 'Expenses');
        $this->session->set_userdata('sub_menu', 'expense/expensesearch');
        $data['title'] = 'Search Expense';
        if ($this->input->server('REQUEST_METHOD') == "POST") {
            $search = $this->input->post('search');
            if ($search == "search_filter") {
                $data['exp_title'] = 'Expense Result From ' . $this->input->post('date_from') . " To " . $this->input->post('date_to');
                $date_from = date('Y-m-d', $this->customlib->datetostrtotime($this->input->post('date_from')));
                $date_to = date('Y-m-d', $this->customlib->datetostrtotime($this->input->post('date_to')));
                $resultList = $this->expense_model->search("", $date_from, $date_to);
                $data['resultList'] = $resultList;
            } else {
                $data['exp_title'] = 'Expense Result';
                $search_text = $this->input->post('search_text');
                $resultList = $this->expense_model->search($search_text, "", "");
                $data['resultList'] = $resultList;
            }
            $this->load->view('layout/accountant/header', $data);
            $this->load->view('accountant/expense/expenseSearch', $data);
            $this->load->view('layout/accountant/footer', $data);
        } else {
            $this->load->view('layout/accountant/header', $data);
            $this->load->view('accountant/expense/expenseSearch', $data);
            $this->load->view('layout/accountant/footer', $data);
        }
    }

}

?>