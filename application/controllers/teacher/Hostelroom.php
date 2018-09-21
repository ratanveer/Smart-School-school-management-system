<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Hostelroom extends CI_Controller {

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
        $hostellist = $this->hostel_model->get();
        $data['hostellist'] = $hostellist;
        $this->session->set_userdata('top_menu', 'Hostel');
        $this->session->set_userdata('sub_menu', 'teacher/hostelroom/index');
        $hostelroomlist = $this->hostelroom_model->lists();
        $data['hostelroomlist'] = $hostelroomlist;
        $this->load->view('layout/teacher/header');
        $this->load->view('teacher/hostelroom/create', $data);
        $this->load->view('layout/teacher/footer');
    }

    function create() {
        $roomtypelist = $this->roomtype_model->get();
        $data['roomtypelist'] = $roomtypelist;
        $hostellist = $this->hostel_model->get();
        $data['hostellist'] = $hostellist;
        $data['title'] = 'Add Library';
        $hostelroomlist = $this->hostelroom_model->lists();
        $data['hostelroomlist'] = $hostelroomlist;
        $this->form_validation->set_rules('hostel_id', 'Hostel', 'trim|required|xss_clean');
        $this->form_validation->set_rules('room_type_id', 'Room Type', 'trim|required|xss_clean');
        $this->form_validation->set_rules('room_no', 'Room No', 'trim|required|xss_clean');
        $this->form_validation->set_rules('no_of_bed', 'No of Bed', 'trim|required|xss_clean');
        $this->form_validation->set_rules('cost_per_bed', 'Cost Per Bed', 'trim|required|xss_clean');
        $hostellist = $this->hostel_model->get();
        $data['hostellist'] = $hostellist;
        $roomtypelist = $this->roomtype_model->get();
        $data['roomtypelist'] = $roomtypelist;
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/teacher/header');
            $this->load->view('teacher/hostelroom/create', $data);
            $this->load->view('layout/teacher/footer');
        } else {
            $data = array(
                'hostel_id' => $this->input->post('hostel_id'),
                'room_type_id' => $this->input->post('room_type_id'),
                'room_no' => $this->input->post('room_no'),
                'no_of_bed' => $this->input->post('no_of_bed'),
                'cost_per_bed' => $this->input->post('cost_per_bed'),
                'description' => $this->input->post('description'),
            );
            $this->hostelroom_model->add($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">Hostel Room added successfully</div>');
            redirect('teacher/hostelroom/index');
        }
    }

    function edit($id) {
        $data['title'] = 'Add Hostel';
        $data['id'] = $id;
        $hostellist = $this->hostel_model->get();
        $data['hostellist'] = $hostellist;
        $roomtypelist = $this->roomtype_model->get();
        $data['roomtypelist'] = $roomtypelist;
        $hostelroom = $this->hostelroom_model->get($id);
        $data['hostelroom'] = $hostelroom;
        $hostelroomlist = $this->hostelroom_model->lists();
        $data['hostelroomlist'] = $hostelroomlist;
        $this->form_validation->set_rules('hostel_id', 'Hostel', 'trim|required|xss_clean');
        $this->form_validation->set_rules('room_type_id', 'Room Type', 'trim|required|xss_clean');
        $this->form_validation->set_rules('room_no', 'Room No', 'trim|required|xss_clean');
        $this->form_validation->set_rules('no_of_bed', 'No of Bed', 'trim|required|xss_clean');
        $this->form_validation->set_rules('cost_per_bed', 'Cost Per Bed', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/teacher/header');
            $this->load->view('teacher/hostelroom/edit', $data);
            $this->load->view('layout/teacher/footer');
        } else {
            $data = array(
                'id' => $this->input->post('id'),
                'hostel_id' => $this->input->post('hostel_id'),
                'room_type_id' => $this->input->post('room_type_id'),
                'room_no' => $this->input->post('room_no'),
                'no_of_bed' => $this->input->post('no_of_bed'),
                'cost_per_bed' => $this->input->post('cost_per_bed'),
                'description' => $this->input->post('description'),
            );
            $this->hostelroom_model->add($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">Hostel Room updated successfully</div>');
            redirect('teacher/hostelroom/index');
        }
    }

    function delete($id) {
        $data['title'] = 'Fees Master List';
        $this->hostelroom_model->remove($id);
        redirect('teacher/hostelroom/index');
    }

}

?>