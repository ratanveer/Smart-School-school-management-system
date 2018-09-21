<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Teacher extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('file');
        $this->lang->load('message', 'english');
        $this->role;
        $this->load->library('auth');
        $this->auth->is_logged_in_librarian();
    }

    function index() {
        $this->session->set_userdata('top_menu', 'Member');
        $this->session->set_userdata('sub_menu', 'teacher/index');
        $data['title'] = 'Add Teacher';
        $teacher_result = $this->teacher_model->getLibraryTeacher();
        $data['teacherlist'] = $teacher_result;
        $genderList = $this->customlib->getGender();
        $data['genderList'] = $genderList;
        $this->load->view('layout/librarian/header', $data);
        $this->load->view('librarian/teacher/index', $data);
        $this->load->view('layout/librarian/footer', $data);
    }

    function add() {
        if ($this->input->post('library_card_no') != "") {

            $this->form_validation->set_rules('library_card_no', 'library Card No', 'required|trim|xss_clean|callback_check_cardno_exists');
            if ($this->form_validation->run() == false) {
                $data = array(
                    'library_card_no' => form_error('library_card_no'),
                );
                $array = array('status' => 'fail', 'error' => $data);
                echo json_encode($array);
            } else {
                $library_card_no = $this->input->post('library_card_no');
                $student = $this->input->post('member_id');
                $data = array(
                    'member_type' => 'teacher',
                    'member_id' => $student,
                    'library_card_no' => $library_card_no
                );

                $inserted_id = $this->librarymanagement_model->add($data);
                $array = array('status' => 'success', 'error' => '', 'message' => 'Member added successfully', 'inserted_id' => $inserted_id, 'library_card_no' => $library_card_no);
                echo json_encode($array);
            }
        } else {
            $library_card_no = $this->input->post('library_card_no');
            $student = $this->input->post('member_id');
            $data = array(
                'member_type' => 'teacher',
                'member_id' => $student,
                'library_card_no' => $library_card_no
            );

            $inserted_id = $this->librarymanagement_model->add($data);
            $array = array('status' => 'success', 'error' => '', 'message' => 'Member added successfully', 'inserted_id' => $inserted_id, 'library_card_no' => $library_card_no);
            echo json_encode($array);
        }
    }

    function check_cardno_exists() {
        $data['library_card_no'] = $this->security->xss_clean($this->input->post('library_card_no'));

        if ($this->librarymanagement_model->check_data_exists($data)) {
            $this->form_validation->set_message('check_cardno_exists', 'Card no already exists');
            return FALSE;
        } else {
            return TRUE;
        }
    }

}

?>