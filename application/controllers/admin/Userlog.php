<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Userlog extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('file');
        $this->lang->load('message', 'english');
    }

    function index() {
        $this->session->set_userdata('top_menu', 'Reports');
        $this->session->set_userdata('sub_menu', 'userlog/index');
        $userlogList = $this->userlog_model->get();
        $data['userlogList'] = $userlogList;
        $data['userlogAdminList'] = $this->userlog_model->getByRole('admin');
        $data['userlogAccountantList'] = $this->userlog_model->getByRole('accountant');
        $data['userlogTeacherList'] = $this->userlog_model->getByRole('teacher');
        $data['userlogLibrarianList'] = $this->userlog_model->getByRole('librarian');
        $data['userlogStudentList'] = $this->userlog_model->getByRole('student');
        $data['userlogParentList'] = $this->userlog_model->getByRole('parent');
        $this->load->view('layout/header', $data);
        $this->load->view('admin/userlog/userlogList', $data);
        $this->load->view('layout/footer', $data);
    }

}

?>