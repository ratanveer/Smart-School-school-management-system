<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class subject extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('file');
        $this->lang->load('message', 'english');
        $this->load->library('auth');
        $this->auth->is_logged_in_teacher();
    }

    function index() {
        $this->session->set_userdata('top_menu', 'Academics');
        $this->session->set_userdata('sub_menu', 'subject/index');
        $data['title'] = 'Add Subject';
        $subject_result = $this->subject_model->get();
        $data['subjectlist'] = $subject_result;
        $this->load->view('layout/teacher/header', $data);
        $this->load->view('teacher/subject/subjectList', $data);
        $this->load->view('layout/teacher/footer', $data);
    }

    function view($id) {
        $data['title'] = 'Subject List';
        $subject = $this->subject_model->get($id);
        $data['subject'] = $subject;
        $this->load->view('layout/teacher/header', $data);
        $this->load->view('teacher/subject/subjectList', $data);
        $this->load->view('layout/teacher/footer', $data);
    }

    function delete($id) {
        $data['title'] = 'Subject List';
        $this->subject_model->remove($id);
        redirect('teacher/subject/index');
    }

    function create() {
        $data['title'] = 'Add subject';
        $subject_result = $this->subject_model->get();
        $data['subjectlist'] = $subject_result;
        $this->form_validation->set_rules('name', 'First Name', 'trim|required|callback__check_name_exists');
        if ($this->input->post('code')) {
            $this->form_validation->set_rules('code', 'Code', 'trim|is_unique[subjects.code]');
            $this->form_validation->set_message('is_unique', '%s is already exists');
        }
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/teacher/header', $data);
            $this->load->view('teacher/subject/subjectList', $data);
            $this->load->view('layout/teacher/footer', $data);
        } else {
            $data = array(
                'name' => $this->input->post('name'),
                'code' => $this->input->post('code'),
                'type' => $this->input->post('type'),
            );
            $this->subject_model->add($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">Subject added successfully</div>');
            redirect('teacher/subject/index');
        }
    }

    function _check_name_exists() {
        $data['name'] = $this->security->xss_clean($this->input->post('name'));
        $data['type'] = $this->security->xss_clean($this->input->post('type'));
        if ($this->subject_model->check_data_exists($data)) {
            $this->form_validation->set_message('_check_name_exists', 'Record already exists');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function edit($id) {
        $subject_result = $this->subject_model->get();
        $data['subjectlist'] = $subject_result;
        $data['title'] = 'Edit Subject';
        $data['id'] = $id;
        $subject = $this->subject_model->get($id);
        $data['subject'] = $subject;
        $this->form_validation->set_rules('name', 'Subject', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/teacher/header', $data);
            $this->load->view('teacher/subject/subjectEdit', $data);
            $this->load->view('layout/teacher/footer', $data);
        } else {
            $data = array(
                'id' => $id,
                'name' => $this->input->post('name'),
                'code' => $this->input->post('code'),
                'type' => $this->input->post('type'),
            );
            $this->subject_model->add($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">Subject updated successfully</div>');
            redirect('teacher/subject/index');
        }
    }

    function getSubjctByClassandSection() {
        $class_id = $this->input->post('class_id');
        $section_id = $this->input->post('section_id');
        $date = $this->teachersubject_model->getSubjectByClsandSection($class_id, $section_id);
        echo json_encode($data);
    }

}

?>