<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Grade extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('file');
        $this->lang->load('message', 'english');
        $this->load->library('auth');
        $this->auth->is_logged_in_teacher();
    }

    public function index() {
        $this->session->set_userdata('top_menu', 'Examinations');
        $this->session->set_userdata('sub_menu', 'grade/index');
        $data['title'] = 'Add Grade';
        $data['title_list'] = 'Grade Details';
        $listgrade = $this->grade_model->get();
        $data['listgrade'] = $listgrade;
        $this->load->view('layout/teacher/header');
        $this->load->view('teacher/grade/creategrade', $data);
        $this->load->view('layout/teacher/footer');
    }

    function create() {
        $data['title'] = 'Add Arade';
        $data['title_list'] = 'Grade Details';
        $this->form_validation->set_rules('name', 'Grade', 'required');
        $this->form_validation->set_rules('mark_from', 'Percentage From', 'trim|required|xss_clean');
        $this->form_validation->set_rules('mark_upto', 'Percentage Upto', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $listgrade = $this->grade_model->get();
            $data['listgrade'] = $listgrade;
            $this->load->view('layout/teacher/header');
            $this->load->view('teacher/grade/creategrade', $data);
            $this->load->view('layout/teacher/footer');
        } else {
            $data = array(
                'name' => $this->input->post('name'),
                'mark_from' => $this->input->post('mark_from'),
                'mark_upto' => $this->input->post('mark_upto'),
                'point' => $this->input->post('point'),
                'description' => $this->input->post('description')
            );
            $this->grade_model->add($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">Grade added successfully</div>');
            redirect('teacher/grade/index');
        }
    }

    function edit($id) {
        $data['title'] = 'Edit Grade';
        $data['title_list'] = 'Grade Details';
        $data['id'] = $id;
        $editgrade = $this->grade_model->get($id);
        $data['editgrade'] = $editgrade;
        $this->form_validation->set_rules('name', 'Grade', 'required');
        $this->form_validation->set_rules('mark_from', 'Percentage from', 'trim|required|xss_clean');
        $this->form_validation->set_rules('mark_upto', 'Percentage upto', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $listgrade = $this->grade_model->get();
            $data['listgrade'] = $listgrade;
            $this->load->view('layout/teacher/header');
            $this->load->view('teacher/grade/editgrade', $data);
            $this->load->view('layout/teacher/footer');
        } else {
            $data = array(
                'id' => $this->input->post('id'),
                'name' => $this->input->post('name'),
                'mark_from' => $this->input->post('mark_from'),
                'mark_upto' => $this->input->post('mark_upto'),
                'point' => $this->input->post('point'),
                'description' => $this->input->post('description')
            );
            $this->grade_model->add($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">Grade updated successfully</div>');
            redirect('teacher/grade/index');
        }
    }

    function delete($id) {
        $data['title'] = 'Fees Master List';
        $this->grade_model->remove($id);
        redirect('teacher/grade/index');
    }

}

?>