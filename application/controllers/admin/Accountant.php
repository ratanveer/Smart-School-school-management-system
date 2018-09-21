<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Accountant extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('file');
        $this->load->library('mailsmsconf');
        $this->lang->load('message', 'english');
        $this->role;
    }

    function delete($id) {
        $data['title'] = 'Accountant List';
        $this->accountant_model->remove($id);
        redirect('admin/accountant/index');
    }

    function index() {
        $this->session->set_userdata('top_menu', 'Fees Collection');
        $this->session->set_userdata('sub_menu', 'accountant/index');
        $data['title'] = 'Add Accountant';
        $genderList = $this->customlib->getGender();
        $data['genderList'] = $genderList;
        $this->form_validation->set_rules('name', 'Accountant', 'trim|required|xss_clean');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean');
        $this->form_validation->set_rules('gender', 'Gender', 'trim|required|xss_clean');
        $this->form_validation->set_rules('dob', 'Date of Birth', 'trim|required|xss_clean');
        $this->form_validation->set_rules('phone', 'Phone', 'trim|required|xss_clean');
        $this->form_validation->set_rules('file', 'Image', 'callback_handle_upload');
        if ($this->form_validation->run() == FALSE) {
            $librarian_result = $this->accountant_model->get();
            $data['librarianlist'] = $librarian_result;
            $genderList = $this->customlib->getGender();
            $data['genderList'] = $genderList;
            $this->load->view('layout/header', $data);
            $this->load->view('admin/accountant/accountantList', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $data = array(
                'name' => $this->input->post('name'),
                'email' => $this->input->post('email'),
                'password' => $this->input->post('password'),
                'sex' => $this->input->post('gender'),
                'dob' => date('Y-m-d', $this->customlib->datetostrtotime($this->input->post('dob'))),
                'address' => $this->input->post('address'),
                'phone' => $this->input->post('phone'),
                'image' => 'uploads/student_images/no_image.png',
            );
            $insert_id = $this->accountant_model->add($data);
            $user_password = $this->role->get_random_password($chars_min = 6, $chars_max = 6, $use_upper_case = false, $include_numbers = true, $include_special_chars = false);
            $data_student_login = array(
                'username' => $this->accountant_login_prefix . $insert_id,
                'password' => $user_password,
                'user_id' => $insert_id,
                'role' => 'accountant'
            );
            $this->user_model->add($data_student_login);
            if (isset($_FILES["file"]) && !empty($_FILES['file']['name'])) {
                $fileInfo = pathinfo($_FILES["file"]["name"]);
                $img_name = $insert_id . '.' . $fileInfo['extension'];
                move_uploaded_file($_FILES["file"]["tmp_name"], "./uploads/accountant_images/" . $img_name);
                $data_img = array('id' => $insert_id, 'image' => 'uploads/accountant_images/' . $img_name);
                $this->accountant_model->add($data_img);
            }

            $accountant_login_detail = array('id' => $insert_id, 'credential_for' => 'accountant', 'username' => $this->accountant_login_prefix . $insert_id, 'password' => $user_password, 'contact_no' => $this->input->post('phone'));

            $this->mailsmsconf->mailsms('login_credential', $accountant_login_detail);

            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">Accountant added successfully</div>');
            redirect('admin/accountant/index');
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
        $this->session->set_userdata('top_menu', 'Fees Collection');
        $this->session->set_userdata('sub_menu', 'accountant/index');
        $data['title'] = 'Edit Accountant';
        $data['id'] = $id;
        $genderList = $this->customlib->getGender();
        $data['genderList'] = $genderList;
        $librarian = $this->accountant_model->get($id);
        $data['librarian'] = $librarian;
        $this->form_validation->set_rules('name', 'Accountant', 'trim|required|xss_clean');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean');
        $this->form_validation->set_rules('gender', 'Gender', 'trim|required|xss_clean');
        $this->form_validation->set_rules('dob', 'Date of Birth', 'trim|required|xss_clean');
        $this->form_validation->set_rules('phone', 'Phone', 'trim|required|xss_clean');
        $this->form_validation->set_rules('file', 'Image', 'callback_handle_upload');
        if ($this->form_validation->run() == FALSE) {
            $librarian_result = $this->accountant_model->get();
            $data['librarianlist'] = $librarian_result;
            $this->load->view('layout/header', $data);
            $this->load->view('admin/accountant/accountantEdit', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $data = array(
                'id' => $id,
                'name' => $this->input->post('name'),
                'email' => $this->input->post('email'),
                'password' => $this->input->post('password'),
                'sex' => $this->input->post('gender'),
                'dob' => date('Y-m-d', $this->customlib->datetostrtotime($this->input->post('dob'))),
                'address' => $this->input->post('address'),
                'phone' => $this->input->post('phone')
            );
            $insert_id = $this->accountant_model->add($data);
            if (isset($_FILES["file"]) && !empty($_FILES['file']['name'])) {
                $fileInfo = pathinfo($_FILES["file"]["name"]);
                $img_name = $id . '.' . $fileInfo['extension'];
                move_uploaded_file($_FILES["file"]["tmp_name"], "./uploads/accountant_images/" . $img_name);
                $data_img = array('id' => $id, 'image' => 'uploads/accountant_images/' . $img_name);
                $this->accountant_model->add($data_img);
            }
            $this->session->set_flashdata('msg', '<div class="alert alert-success">Accountant updated successfully</div>');
            redirect('admin/accountant/index');
        }
    }

    function view($id) {
        $data['title'] = 'Librarian List';
        $accountant = $this->accountant_model->get($id);

        $data['accountant'] = $accountant;

        $this->load->view('layout/header', $data);
        $this->load->view('admin/accountant/accountantShow', $data);
        $this->load->view('layout/footer', $data);
    }

    function getlogindetail() {
        $accountant_id = $this->input->post('accountant_id');
        $examSchedule = $this->user_model->getAccountantLoginDetails($accountant_id);
        echo json_encode($examSchedule);
    }

}

?>