<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class librarian extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('file');
        $this->lang->load('message', 'english');
        $this->role;
        $this->load->library('auth');
        $this->auth->is_logged_in_librarian();
    }

    function dashboard() {
        $this->session->set_userdata('top_menu', 'dashboard');

        $data = array();
        $librarian_id = $this->session->userdata['student']['librarian_id'];
        $data['title'] = 'librarian';
        $librarian = $this->librarian_model->get($librarian_id);
        $data['librarian'] = $librarian;

        $this->load->view('layout/librarian/header', $data);
        $this->load->view('librarian/dashboard', $data);
        $this->load->view('layout/librarian/footer', $data);
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

    function changepass() {
        $data['title'] = 'Change Password';
        $this->form_validation->set_rules('current_pass', 'Current password', 'trim|required|xss_clean');
        $this->form_validation->set_rules('new_pass', 'New password', 'trim|required|xss_clean|matches[confirm_pass]');
        $this->form_validation->set_rules('confirm_pass', 'Confirm password', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $sessionData = $this->session->userdata('loggedIn');
            $this->data['id'] = $sessionData['id'];
            $this->data['username'] = $sessionData['username'];
            $this->load->view('layout/librarian/header', $data);
            $this->load->view('librarian/change_password', $data);
            $this->load->view('layout/librarian/footer', $data);
        } else {
            $sessionData = $this->session->userdata('student');
            $data_array = array(
                'current_pass' => ($this->input->post('current_pass')),
                'new_pass' => ($this->input->post('new_pass')),
                'user_id' => $sessionData['id'],
                'user_name' => $sessionData['username']
            );
            $newdata = array(
                'id' => $sessionData['id'],
                'password' => $this->input->post('new_pass')
            );
            $query1 = $this->user_model->checkOldPass($data_array);
            if ($query1) {
                $query2 = $this->user_model->saveNewPass($newdata);
                if ($query2) {

                    $this->session->set_flashdata('success_msg', 'Password changed successfully');
                    $this->load->view('layout/librarian/header', $data);
                    $this->load->view('librarian/change_password', $data);
                    $this->load->view('layout/librarian/footer', $data);
                }
            } else {

                $this->session->set_flashdata('error_msg', 'Invalid current password');
                $this->load->view('layout/librarian/header', $data);
                $this->load->view('librarian/change_password', $data);
                $this->load->view('layout/librarian/footer', $data);
            }
        }
    }

    function changeusername() {
        $sessionData = $this->customlib->getLoggedInUserData();

        $data['title'] = 'Change Username';
        $this->form_validation->set_rules('current_username', 'Current username', 'trim|required|xss_clean');
        $this->form_validation->set_rules('new_username', 'New username', 'trim|required|xss_clean|matches[confirm_username]');
        $this->form_validation->set_rules('confirm_username', 'Confirm username', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            
        } else {

            $data_array = array(
                'username' => $this->input->post('current_username'),
                'new_username' => $this->input->post('new_username'),
                'role' => $sessionData['role'],
                'user_id' => $sessionData['id'],
            );
            $newdata = array(
                'id' => $sessionData['id'],
                'username' => $this->input->post('new_username')
            );
            $is_valid = $this->user_model->checkOldUsername($data_array);

            if ($is_valid) {
                $is_exists = $this->user_model->checkUserNameExist($data_array);
                if (!$is_exists) {
                    $is_updated = $this->user_model->saveNewUsername($newdata);
                    if ($is_updated) {
                        $this->session->set_flashdata('success_msg', 'Username changed successfully');
                        redirect('librarian/librarian/changeusername');
                    }
                } else {
                    $this->session->set_flashdata('error_msg', 'Username Already Exists, Please choose other');
                }
            } else {
                $this->session->set_flashdata('error_msg', 'Invalid current username');
            }
        }
        $this->data['id'] = $sessionData['id'];
        $this->data['username'] = $sessionData['username'];
        $this->load->view('layout/librarian/header', $data);
        $this->load->view('librarian/change_username', $data);
        $this->load->view('layout/librarian/footer', $data);
    }

}

?>