<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Librarian extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->load->helper('file');
        $this->load->library('mailsmsconf');
        $this->lang->load('message', 'english');
        $this->role;
    }

    function view($id) {
        $data['title'] = 'Librarian List';
        $librarian = $this->librarian_model->get($id);

        $data['librarian'] = $librarian;

        $this->load->view('layout/header', $data);
        $this->load->view('admin/librarian/librarianShow', $data);
        $this->load->view('layout/footer', $data);
    }

    function delete($id) {
        $data['title'] = 'Librarian List';
        $this->librarian_model->remove($id);
        redirect('admin/librarian/index');
    }

    function index() {
        $this->session->set_userdata('top_menu', 'Library');
        $this->session->set_userdata('sub_menu', 'librarian/index');
        $data['title'] = 'Add Librarian';
        $genderList = $this->customlib->getGender();
        $data['genderList'] = $genderList;
        $this->form_validation->set_rules('name', 'Librarian', 'trim|required|xss_clean');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean');
        $this->form_validation->set_rules('gender', 'Gender', 'trim|required|xss_clean');
        $this->form_validation->set_rules('dob', 'Date of Birth', 'trim|required|xss_clean');
        $this->form_validation->set_rules('phone', 'Phone', 'trim|required|xss_clean');
        $this->form_validation->set_rules('file', 'Image', 'callback_handle_upload');
        if ($this->form_validation->run() == FALSE) {
            $librarian_result = $this->librarian_model->get();
            $data['librarianlist'] = $librarian_result;
            $genderList = $this->customlib->getGender();
            $data['genderList'] = $genderList;
            $this->load->view('layout/header', $data);
            $this->load->view('admin/librarian/librarianList', $data);
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
            $insert_id = $this->librarian_model->add($data);
            $user_password = $this->role->get_random_password($chars_min = 6, $chars_max = 6, $use_upper_case = false, $include_numbers = true, $include_special_chars = false);
            $data_student_login = array(
                'username' => $this->librarian_login_prefix . $insert_id,
                'password' => $user_password,
                'user_id' => $insert_id,
                'role' => 'librarian'
            );
            $this->user_model->add($data_student_login);
            if (isset($_FILES["file"]) && !empty($_FILES['file']['name'])) {
                $fileInfo = pathinfo($_FILES["file"]["name"]);
                $img_name = $insert_id . '.' . $fileInfo['extension'];
                move_uploaded_file($_FILES["file"]["tmp_name"], "./uploads/librarian_images/" . $img_name);
                $data_img = array('id' => $insert_id, 'image' => 'uploads/librarian_images/' . $img_name);
                $this->librarian_model->add($data_img);
            }

            $librarian_login_detail = array('id' => $insert_id, 'credential_for' => 'librarian', 'username' => $this->librarian_login_prefix . $insert_id, 'password' => $user_password, 'contact_no' => $this->input->post('phone'));

            $this->mailsmsconf->mailsms('login_credential', $librarian_login_detail);

            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">Librarian added successfully</div>');
            redirect('admin/librarian/index');
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
        $this->session->set_userdata('top_menu', 'Library');
        $this->session->set_userdata('sub_menu', 'librarian/index');
        $data['title'] = 'Edit Librarian';
        $data['id'] = $id;
        $genderList = $this->customlib->getGender();
        $data['genderList'] = $genderList;
        $librarian = $this->librarian_model->get($id);
        $data['librarian'] = $librarian;
        $this->form_validation->set_rules('name', 'Librarian', 'trim|required|xss_clean');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean');
        $this->form_validation->set_rules('gender', 'Gender', 'trim|required|xss_clean');
        $this->form_validation->set_rules('dob', 'Date of Birth', 'trim|required|xss_clean');
        $this->form_validation->set_rules('phone', 'Phone', 'trim|required|xss_clean');
        $this->form_validation->set_rules('file', 'Image', 'callback_handle_upload');
        if ($this->form_validation->run() == FALSE) {
            $librarian_result = $this->librarian_model->get();
            $data['librarianlist'] = $librarian_result;
            $this->load->view('layout/header', $data);
            $this->load->view('admin/librarian/librarianEdit', $data);
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
            $insert_id = $this->librarian_model->add($data);
            if (isset($_FILES["file"]) && !empty($_FILES['file']['name'])) {
                $fileInfo = pathinfo($_FILES["file"]["name"]);
                $img_name = $id . '.' . $fileInfo['extension'];
                move_uploaded_file($_FILES["file"]["tmp_name"], "./uploads/librarian_images/" . $img_name);
                $data_img = array('id' => $id, 'image' => 'uploads/librarian_images/' . $img_name);
                $this->librarian_model->add($data_img);
            }
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Librarian updated successfully</div>');
            redirect('admin/librarian/index');
        }
    }

    function getlogindetail() {
        $librarian_id = $this->input->post('librarian_id');
        $examSchedule = $this->user_model->getLibrarianLoginDetails($librarian_id);
        echo json_encode($examSchedule);
    }

}

?>