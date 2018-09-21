<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Vehroute extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('file');
        $this->lang->load('message', 'english');
        $this->load->library('auth');
        $this->auth->is_logged_in_teacher();
    }

    function index() {
        $this->session->set_userdata('top_menu', 'Transport');
        $this->session->set_userdata('sub_menu', 'vehroute/index');
        $data['title'] = 'Add Vehicle Route';
        $data['title_list'] = 'Recent Vehicle Routes';

        $this->form_validation->set_rules(
                'route_id', 'Route', array(
            'required',
            array('route_exists', array($this->vehroute_model, 'route_exists'))
                )
        );
        $this->form_validation->set_rules('vehicle[]', 'Vehicle', 'trim|required|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            
        } else {


            $vehicle = $this->input->post('vehicle');
            $route_id = $this->input->post('route_id');
            $vehicle_batch_array = array();
            foreach ($vehicle as $vec_key => $vec_value) {

                $vehicle_array = array(
                    'route_id' => $route_id,
                    'vehicle_id' => $vec_value,
                );

                $vehicle_batch_array[] = $vehicle_array;
            }


            $this->vehroute_model->add($vehicle_batch_array);
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">Vehicle Route added successfully</div>');
            redirect('teacher/vehroute/index');
        }
        $vehicle_result = $this->vehicle_model->get();
        $data['vehiclelist'] = $vehicle_result;
        $routeList = $this->route_model->get();
        $data['routelist'] = $routeList;
        $vehroute_result = $this->vehroute_model->get();
        $data['vehroutelist'] = $vehroute_result;

        $this->load->view('layout/teacher/header', $data);
        $this->load->view('teacher/vehroute/vehrouteList', $data);
        $this->load->view('layout/teacher/footer', $data);
    }

    function delete($id) {
        $data['title'] = 'Fees Master List';
        $this->expense_model->remove($id);
        redirect('teacher/vehroute/index');
    }

    function edit($id) {
        $data['title'] = 'Edit Fees Master';
        $data['id'] = $id;
        $vehroute = $this->vehroute_model->get($id);
        $data['vehroute'] = $vehroute;
        $data['title_list'] = 'Fees Master List';

        $this->form_validation->set_rules(
                'route_id', 'Route', array(
            'required',
            array('route_exists', array($this->vehroute_model, 'route_exists'))
                )
        );
        $this->form_validation->set_rules('vehicle[]', 'Vehicle', 'trim|required|xss_clean');


        if ($this->form_validation->run() == FALSE) {
            $vehicle_result = $this->vehicle_model->get();
            $data['vehiclelist'] = $vehicle_result;
            $routeList = $this->route_model->get();
            $data['routelist'] = $routeList;
            $vehroute_result = $this->vehroute_model->get();
            $data['vehroutelist'] = $vehroute_result;
            $this->load->view('layout/teacher/header', $data);
            $this->load->view('teacher/vehroute/vehrouteEdit', $data);
            $this->load->view('layout/teacher/footer', $data);
        } else {

            $vehicle = $this->input->post('vehicle');
            $prev_vec_route = $this->input->post('prev_vec_route');
            $pre_route_id = $this->input->post('pre_route_id');
            $route_id = $this->input->post('route_id');

            $add_result = array_diff($vehicle, $prev_vec_route);
            $delete_result = array_diff($prev_vec_route, $vehicle);


            if ($pre_route_id != $route_id) {
                $this->vehroute_model->removeByroute($pre_route_id);
                $vehicle_batch_array = array();
                foreach ($vehicle as $vec_key => $vec_value) {

                    $vehicle_array = array(
                        'route_id' => $route_id,
                        'vehicle_id' => $vec_value,
                    );

                    $vehicle_batch_array[] = $vehicle_array;
                }


                $this->vehroute_model->add($vehicle_batch_array);
            } else {

                if (!empty($add_result)) {
                    $vehicle_batch_array = array();
                    foreach ($add_result as $vec_add_key => $vec_add_value) {

                        $vehicle_array = array(
                            'route_id' => $pre_route_id,
                            'vehicle_id' => $vec_add_value,
                        );

                        $vehicle_batch_array[] = $vehicle_array;
                    }
                    $this->vehroute_model->add($vehicle_batch_array);
                }

                if (!empty($delete_result)) {
                    $vehicle_delete_array = array();
                    foreach ($delete_result as $vec_delete_key => $vec_delete_value) {

                        $vehicle_delete_array[] = $vec_delete_value;
                    }

                    $this->vehroute_model->remove($pre_route_id, $vehicle_delete_array);
                }
            }



            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">Vehicle Route updated successfully</div>');
            redirect('teacher/vehroute/index');
        }
    }

}

?>