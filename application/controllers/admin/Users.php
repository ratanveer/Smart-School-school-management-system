<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Users extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('file');
        $this->lang->load('message', 'english');
    }

    function index() {
        $this->session->set_userdata('top_menu', 'System Settings');
        $this->session->set_userdata('sub_menu', 'users/index');
        $studentList = $this->student_model->getStudents();
        $teacherList = $this->teacher_model->getTeacher();
        $parentList = $this->parent_model->get();
        $accountantList = $this->accountant_model->get();

        $librarianList = $this->librarian_model->get();
        $data['teacherList'] = $teacherList;
        $data['studentList'] = $studentList;
        $data['parentList'] = $parentList;
        $data['accountantList'] = $accountantList;
        $data['librarianList'] = $librarianList;
        $this->load->view('layout/header', $data);
        $this->load->view('admin/users/userList', $data);
        $this->load->view('layout/footer', $data);
    }

    function changeStatus() {
        $id = $this->input->post('id');
        $status = $this->input->post('status');
        $data = array('id' => $id, 'is_active' => $status);
        $result = $this->user_model->changeStatus($data);
        if ($result) {
            $response = array('status' => 1, 'msg' => 'Status change successfully');
            echo json_encode($response);
        }
    }

}

?>