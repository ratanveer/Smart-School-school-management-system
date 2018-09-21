<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Income extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('file');
        $this->load->helper('form');
        $this->lang->load('message', 'english');
        $this->load->library('Customlib');
        $this->load->model('income_model');
        $this->load->model('incomehead_model');
        $this->load->library('auth');
        $this->auth->is_logged_in_accountant();
    }

    function index() {
        $this->session->set_userdata('top_menu', 'Income');
        $this->session->set_userdata('sub_menu', 'income/index');
        $data['title'] = 'Add Income';
        $data['title_list'] = 'Recent Incomes';
        $this->form_validation->set_rules('inc_head_id[]', 'Income Head', 'trim|required|xss_clean');
        $this->form_validation->set_rules('amount', 'Amount', 'trim|required|xss_clean');
        $this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('date', 'Date', 'trim|required|xss_clean');
        $this->form_validation->set_rules('documents', 'Documents', 'callback_handle_upload');
        if ($this->form_validation->run() == FALSE) {
            
        } else {
            $data = array(
                'inc_head_id' => $this->input->post('inc_head_id'),
                'name' => $this->input->post('name'),
                'date' => date('Y-m-d', $this->customlib->datetostrtotime($this->input->post('date'))),
                'amount' => $this->input->post('amount'),
                'note' => $this->input->post('description'),
                'documents' => $this->input->post('documents'),
            );
            $insert_id = $this->income_model->add($data);
            if (isset($_FILES["documents"]) && !empty($_FILES['documents']['name'])) {
                $fileInfo = pathinfo($_FILES["documents"]["name"]);
                $img_name = $insert_id . '.' . $fileInfo['extension'];
                move_uploaded_file($_FILES["documents"]["tmp_name"], "./uploads/school_income/" . $img_name);
                $data_img = array('id' => $insert_id, 'documents' => 'uploads/school_income/' . $img_name);
                $this->income_model->add($data_img);
            }
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">Income added successfully</div>');
            redirect('accountant/income/index');
        }
        $income_result = $this->income_model->get();
        $data['incomelist'] = $income_result;
        $incomeHead = $this->incomehead_model->get();
        $data['incheadlist'] = $incomeHead;
        $this->load->view('layout/accountant/header', $data);
        $this->load->view('accountant/income/incomeList', $data);
        $this->load->view('layout/accountant/footer', $data);
    }

    public function download($documents) {
        $this->load->helper('download');
        $filepath = "./uploads/school_income/" . $this->uri->segment(6);
        $data = file_get_contents($filepath);
        $name = $this->uri->segment(6);
        force_download($name, $data);
    }

    function view($id) {
        $data['title'] = 'Fees Master List';
        $income = $this->income_model->get($id);
        $data['income'] = $income;
        $this->load->view('layout/accountant/header', $data);
        $this->load->view('income/incomeShow', $data);
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
        $data = $this->income_model->getTypeByFeecategory($type, $class_id);
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
        $this->income_model->remove($id);
        redirect('accountant/income/index');
    }

    function create() {
        $data['title'] = 'Add Fees Master';
        $this->form_validation->set_rules('income', 'Fees Master', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/accountant/header', $data);
            $this->load->view('income/incomeCreate', $data);
            $this->load->view('layout/accountant/footer', $data);
        } else {
            $data = array(
                'income' => $this->input->post('income'),
            );
            $this->income_model->add($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">income added successfully</div>');
            redirect('income/index');
        }
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
        $income = $this->income_model->get($id);
        $data['income'] = $income;
        $data['title_list'] = 'Fees Master List';
        $income_result = $this->income_model->get();
        $data['incomelist'] = $income_result;
        $expnseHead = $this->incomehead_model->get();
        $data['incheadlist'] = $expnseHead;
        $this->form_validation->set_rules('inc_head_id', 'Income Head', 'trim|required|xss_clean');
        $this->form_validation->set_rules('amount', 'Amount', 'trim|required|xss_clean');
        $this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('date', 'Date', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/accountant/header', $data);
            $this->load->view('accountant/income/incomeEdit', $data);
            $this->load->view('layout/accountant/footer', $data);
        } else {
            $data = array(
                'id' => $id,
                'inc_head_id' => $this->input->post('inc_head_id'),
                'name' => $this->input->post('name'),
                'date' => date('Y-m-d', $this->customlib->datetostrtotime($this->input->post('date'))),
                'amount' => $this->input->post('amount'),
                'note' => $this->input->post('description')
            );
            $insert_id = $this->income_model->add($data);
            if (isset($_FILES["documents"]) && !empty($_FILES['documents']['name'])) {
                $fileInfo = pathinfo($_FILES["documents"]["name"]);
                $img_name = $id . '.' . $fileInfo['extension'];
                move_uploaded_file($_FILES["documents"]["tmp_name"], "./uploads/school_income/" . $img_name);
                $data_img = array('id' => $id, 'documents' => 'uploads/school_income/' . $img_name);
                $this->income_model->add($data_img);
            }

            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">Income updated successfully</div>');
            redirect('accountant/income/index');
        }
    }

    function incomeSearch() {
        $this->session->set_userdata('top_menu', 'Income');
        $this->session->set_userdata('sub_menu', 'income/incomesearch');
        $data['title'] = 'Search Income';
        if ($this->input->server('REQUEST_METHOD') == "POST") {
            $search = $this->input->post('search');
            if ($search == "search_filter") {
                $data['inc_title'] = 'Income Result From ' . $this->input->post('date_from') . " To " . $this->input->post('date_to');
                $date_from = date('Y-m-d', $this->customlib->datetostrtotime($this->input->post('date_from')));
                $date_to = date('Y-m-d', $this->customlib->datetostrtotime($this->input->post('date_to')));
                $resultList = $this->income_model->search("", $date_from, $date_to);
                $data['resultList'] = $resultList;
            } else {
                $data['inc_title'] = 'Income Result';
                $search_text = $this->input->post('search_text');
                $resultList = $this->income_model->search($search_text, "", "");
                $data['resultList'] = $resultList;
            }
            $this->load->view('layout/accountant/header', $data);
            $this->load->view('accountant/income/incomeSearch', $data);
            $this->load->view('layout/accountant/footer', $data);
        } else {
            $this->load->view('layout/accountant/header', $data);
            $this->load->view('accountant/income/incomeSearch', $data);
            $this->load->view('layout/accountant/footer', $data);
        }
    }

}

?>