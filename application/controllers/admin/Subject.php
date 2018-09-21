<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class subject extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('file');
        $this->lang->load('message', 'english');
    }

    function index() {
        $this->session->set_userdata('top_menu', 'Academics');
        $this->session->set_userdata('sub_menu', 'subject/index');
        $data['title'] = 'Add Subject';
        $subject_result = $this->subject_model->get();
        $data['subjectlist'] = $subject_result;
        $this->load->view('layout/header', $data);
        $this->load->view('admin/subject/subjectList', $data);
        $this->load->view('layout/footer', $data);
    }

    function view($id) {
        $data['title'] = 'Subject List';
        $subject = $this->subject_model->get($id);
        $data['subject'] = $subject;
        $this->load->view('layout/header', $data);
        $this->load->view('admin/subject/subjectShow', $data);
        $this->load->view('layout/footer', $data);
    }

    function delete($id) {
        $data['title'] = 'Subject List';
        $this->subject_model->remove($id);
        redirect('admin/subject/index');
    }

    function create() {
        $data['title'] = 'Add subject';
        $subject_result = $this->subject_model->get();
        $data['subjectlist'] = $subject_result;
        $this->form_validation->set_rules('name', 'Subject Name', 'trim|required|xss_clean|callback__check_name_exists');
        if ($this->input->post('code')) {
            $this->form_validation->set_rules('code', 'Code', 'trim|required|callback__check_code_exists');
        }
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/header', $data);
            $this->load->view('admin/subject/subjectList', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $data = array(
                'name' => $this->input->post('name'),
                'code' => $this->input->post('code'),
                'type' => $this->input->post('type'),
            );
            $this->subject_model->add($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">Subject added successfully</div>');
            redirect('admin/subject/index');
        }
    }

    function _check_name_exists() {
        $data['name'] = $this->security->xss_clean($this->input->post('name'));
        if ($this->subject_model->check_data_exists($data)) {
            $this->form_validation->set_message('_check_name_exists', 'Name already exists');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function _check_code_exists() {
        $data['code'] = $this->security->xss_clean($this->input->post('code'));
        if ($this->subject_model->check_code_exists($data)) {
            $this->form_validation->set_message('_check_code_exists', 'Code already exists');
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
            $this->load->view('layout/header', $data);
            $this->load->view('admin/subject/subjectEdit', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $data = array(
                'id' => $id,
                'name' => $this->input->post('name'),
                'code' => $this->input->post('code'),
                'type' => $this->input->post('type'),
            );
            $this->subject_model->add($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">Subject updated successfully</div>');
            redirect('admin/subject/index');
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