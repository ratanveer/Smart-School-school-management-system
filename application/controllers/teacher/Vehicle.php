<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Vehicle extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('file');
        $this->lang->load('message', 'english');
        $this->load->library('auth');
        $this->auth->is_logged_in_teacher();
    }

    public function index() {
        $this->session->set_userdata('top_menu', 'Transport');
        $this->session->set_userdata('sub_menu', 'vehicle/index');
        $data['title'] = 'Add Vehicle';
        $listVehicle = $this->vehicle_model->get();
        $data['listVehicle'] = $listVehicle;
        $this->form_validation->set_rules('vehicle_no', 'Vehicle No', 'trim|required|xss_clean');

        if ($this->form_validation->run() == FALSE) {

            $this->load->view('layout/teacher/header');
            $this->load->view('teacher/vehicle/index', $data);
            $this->load->view('layout/teacher/footer');
        } else {
            $manufacture_year = $this->input->post('manufacture_year');


            $data = array(
                'vehicle_no' => $this->input->post('vehicle_no'),
                'vehicle_model' => $this->input->post('vehicle_model'),
                'driver_name' => $this->input->post('driver_name'),
                'driver_licence' => $this->input->post('driver_licence'),
                'driver_contact' => $this->input->post('driver_contact'),
                'note' => $this->input->post('note'),
            );

            ($manufacture_year != "") ? $data['manufacture_year'] = $manufacture_year : '';
            $this->vehicle_model->add($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">Vehicle added successfully</div>');
            redirect('teacher/vehicle/index');
        }
    }

    function edit($id) {
        $data['title'] = 'Add Vehicle';
        $data['id'] = $id;
        $editvehicle = $this->vehicle_model->get($id);

        $data['editvehicle'] = $editvehicle;
        $listVehicle = $this->vehicle_model->get();
        $data['listVehicle'] = $listVehicle;
        $this->form_validation->set_rules('vehicle_no', 'Vehicle No', 'trim|required|xss_clean');

        if ($this->form_validation->run() == FALSE) {

            $this->load->view('layout/teacher/header');
            $this->load->view('teacher/vehicle/edit', $data);
            $this->load->view('layout/teacher/footer');
        } else {
            $manufacture_year = $this->input->post('manufacture_year');
            $data = array(
                'id' => $this->input->post('id'),
                'vehicle_no' => $this->input->post('vehicle_no'),
                'vehicle_model' => $this->input->post('vehicle_model'),
                'driver_name' => $this->input->post('driver_name'),
                'driver_licence' => $this->input->post('driver_licence'),
                'driver_contact' => $this->input->post('driver_contact'),
                'note' => $this->input->post('note'),
            );
            ($manufacture_year != "") ? $data['manufacture_year'] = $manufacture_year : '';
            $this->vehicle_model->add($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">Transport updated successfully</div>');
            redirect('teacher/vehicle/index');
        }
    }

    function delete($id) {
        $data['title'] = 'Fees Master List';
        $this->vehicle_model->remove($id);
        redirect('teacher/vehicle/index');
    }

}

?>