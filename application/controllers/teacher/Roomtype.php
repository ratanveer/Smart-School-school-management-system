<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Roomtype extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->lang->load('message', 'english');
        $this->load->library('Customlib');
        $this->load->library('auth');
        $this->auth->is_logged_in_teacher();
    }

    public function index() {
        $roomtypelist = $this->roomtype_model->get();
        $data['roomtypelist'] = $roomtypelist;
        $this->session->set_userdata('top_menu', 'Hostel');
        $this->session->set_userdata('sub_menu', 'teacher/roomtype/index');
        $listroomtype = $this->roomtype_model->lists();
        $data['listroomtype'] = $listroomtype;
        $ght = $this->customlib->getHostaltype();
        $data['ght'] = $ght;
        $this->load->view('layout/teacher/header');
        $this->load->view('teacher/roomtype/create', $data);
        $this->load->view('layout/teacher/footer');
    }

    function create() {
        $data['title'] = 'Add Library';
        $this->form_validation->set_rules('room_type', 'Room Type', 'trim|required|xss_clean');
        $roomtypelist = $this->roomtype_model->get();
        $data['roomtypelist'] = $roomtypelist;
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/teacher/header');
            $this->load->view('teacher/roomtype/create', $data);
            $this->load->view('layout/teacher/footer');
        } else {
            $data = array(
                'room_type' => $this->input->post('room_type'),
                'description' => $this->input->post('description')
            );
            $this->roomtype_model->add($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">Room Type added successfully</div>');
            redirect('teacher/roomtype/index');
        }
    }

    function edit($id) {
        $data['title'] = 'Add Hostel';
        $data['id'] = $id;
        $roomtype = $this->roomtype_model->get($id);
        $data['roomtype'] = $this->roomtype_model->get($id);
        $roomtypelist = $this->roomtype_model->get();
        $data['roomtypelist'] = $roomtypelist;
        $this->form_validation->set_rules('room_type', 'Room Type', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/teacher/header');
            $this->load->view('teacher/roomtype/edit', $data);
            $this->load->view('layout/teacher/footer');
        } else {
            $data = array(
                'id' => $this->input->post('id'),
                'room_type' => $this->input->post('room_type'),
                'description' => $this->input->post('description')
            );

            $this->roomtype_model->add($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">Room Type updated successfully</div>');
            redirect('teacher/roomtype/index');
        }
    }

    function delete($id) {
        $data['title'] = 'Fees Master List';
        $this->roomtype_model->remove($id);
        redirect('teacher/roomtype/index');
    }

}

?>