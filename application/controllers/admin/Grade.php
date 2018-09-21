<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Grade extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('file');
        $this->lang->load('message', 'english');
    }

    public function index() {
        $this->session->set_userdata('top_menu', 'Examinations');
        $this->session->set_userdata('sub_menu', 'grade/index');
        $data['title'] = 'Add Grade';
        $data['title_list'] = 'Grade Details';
        $listgrade = $this->grade_model->get();
        $data['listgrade'] = $listgrade;
        $this->load->view('layout/header');
        $this->load->view('admin/grade/creategrade', $data);
        $this->load->view('layout/footer');
    }

    function create() {
        $data['title'] = 'Add Arade';
        $data['title_list'] = 'Grade Details';
        $this->form_validation->set_rules('name', 'Grade', 'trim|required|xss_clean');
        $this->form_validation->set_rules('mark_from', 'Percentage From', 'trim|required|xss_clean');
        $this->form_validation->set_rules('mark_upto', 'Percentage Upto', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $listgrade = $this->grade_model->get();
            $data['listgrade'] = $listgrade;
            $this->load->view('layout/header');
            $this->load->view('admin/grade/creategrade', $data);
            $this->load->view('layout/footer');
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
            redirect('admin/grade/index');
        }
    }

    function edit($id) {
        $data['title'] = 'Edit Grade';
        $data['title_list'] = 'Grade Details';
        $data['id'] = $id;
        $editgrade = $this->grade_model->get($id);
        $data['editgrade'] = $editgrade;
        $this->form_validation->set_rules('name', 'Grade', 'trim|required|xss_clean');
        $this->form_validation->set_rules('mark_from', 'Percentage from', 'trim|required|xss_clean');
        $this->form_validation->set_rules('mark_upto', 'Percentage upto', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $listgrade = $this->grade_model->get();
            $data['listgrade'] = $listgrade;
            $this->load->view('layout/header');
            $this->load->view('admin/grade/editgrade', $data);
            $this->load->view('layout/footer');
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
            redirect('admin/grade/index');
        }
    }

    function delete($id) {
        $data['title'] = 'Fees Master List';
        $this->grade_model->remove($id);
        redirect('admin/grade/index');
    }

}

?>