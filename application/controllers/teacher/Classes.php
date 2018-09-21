<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class classes extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('file');
        $this->lang->load('message', 'english');
        $this->load->library('auth');
        $this->auth->is_logged_in_teacher();
    }

    function index() {
        $this->session->set_userdata('top_menu', 'Academics');
        $this->session->set_userdata('sub_menu', 'classes/index');
        $data['title'] = 'Add Class';
        $data['title_list'] = 'Class List';

        $this->form_validation->set_rules(
                'class', 'Class', array(
            'required',
            array('class_exists', array($this->class_model, 'class_exists'))
                )
        );
        $this->form_validation->set_rules('sections[]', 'Section', 'trim|required|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            
        } else {
            $class = $this->input->post('class');
            $class_array = array(
                'class' => $this->input->post('class')
            );
            $sections = $this->input->post('sections');
            $this->classsection_model->add($class_array, $sections);
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">Class added successfully</div>');
            redirect('teacher/classes');
        }
        $vehicle_result = $this->section_model->get();
        $data['vehiclelist'] = $vehicle_result;

        $vehroute_result = $this->classsection_model->getByID();

        $data['vehroutelist'] = $vehroute_result;
        $this->load->view('layout/teacher/header', $data);
        $this->load->view('teacher/class/classList', $data);
        $this->load->view('layout/teacher/footer', $data);
    }

    function view($id) {
        $data['title'] = 'Class List';
        $class = $this->class_model->get($id);
        $data['class'] = $class;
        $this->load->view('layout/teacher/header', $data);
        $this->load->view('teacher/class/classShow', $data);
        $this->load->view('layout/teacher/footer', $data);
    }

    function delete($id) {
        $data['title'] = 'Class List';
        $this->class_model->remove($id);
        redirect('teacher/classes/index');
    }

    function edit($id) {
        $this->session->set_userdata('top_menu', 'Academics');
        $this->session->set_userdata('sub_menu', 'classes/index');
        $data['title'] = 'Edit Class';
        $data['id'] = $id;
        $vehroute = $this->classsection_model->getByID($id);
        $data['vehroute'] = $vehroute;
        $data['title_list'] = 'Fees Master List';

        $this->form_validation->set_rules(
                'class', 'Class', array(
            'required',
            array('class_exists', array($this->class_model, 'class_exists'))
                )
        );
        $this->form_validation->set_rules('sections[]', 'Sections', 'trim|required|xss_clean');


        if ($this->form_validation->run() == FALSE) {
            $vehicle_result = $this->section_model->get();
            $data['vehiclelist'] = $vehicle_result;
            $routeList = $this->route_model->get();
            $data['routelist'] = $routeList;
            $vehroute_result = $this->classsection_model->getByID();

            $data['vehroutelist'] = $vehroute_result;
            $this->load->view('layout/teacher/header', $data);
            $this->load->view('teacher/class/classEdit', $data);
            $this->load->view('layout/teacher/footer', $data);
        } else {

            $sections = $this->input->post('sections');
            $prev_sections = $this->input->post('prev_sections');
            $route_id = $this->input->post('route_id');
            $class_id = $this->input->post('pre_class_id');
            if (!isset($prev_sections)) {
                $prev_sections = array();
            }
            $add_result = array_diff($sections, $prev_sections);
            $delete_result = array_diff($prev_sections, $sections);

            if (!empty($add_result)) {
                $vehicle_batch_array = array();
                $class_array = array(
                    'id' => $class_id,
                    'class' => $this->input->post('class')
                );
                foreach ($add_result as $vec_add_key => $vec_add_value) {

                    $vehicle_batch_array[] = $vec_add_value;
                }
                $this->classsection_model->add($class_array, $vehicle_batch_array);
            } else {
                $class_array = array(
                    'id' => $class_id,
                    'class' => $this->input->post('class')
                );
                $this->classsection_model->update($class_array);
            }

            if (!empty($delete_result)) {
                $classsection_delete_array = array();
                foreach ($delete_result as $vec_delete_key => $vec_delete_value) {

                    $classsection_delete_array[] = $vec_delete_value;
                }

                $this->classsection_model->remove($class_id, $classsection_delete_array);
            }
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">Class updated successfully</div>');
            redirect('teacher/classes');
        }
    }

}

?>