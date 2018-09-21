<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Notification extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('file');
        $this->lang->load('message', 'english');
        $this->load->library('auth');
        $this->auth->is_logged_in_teacher();
    }

    function index() {
        $this->session->set_userdata('top_menu', 'Communicate');
        $this->session->set_userdata('sub_menu', 'notification/index');
        $data['title'] = 'Notifications';
        $notifications = $this->notification_model->get();
        $data['notificationlist'] = $notifications;
        $this->load->view('layout/teacher/header', $data);
        $this->load->view('teacher/notification/notificationList', $data);
        $this->load->view('layout/teacher/footer', $data);
    }

    function add() {
        $this->session->set_userdata('top_menu', 'Communicate');
        $this->session->set_userdata('sub_menu', 'notification/add');
        $data['title'] = 'Add Notification';
        $data['title_list'] = 'Notification List';
        $this->form_validation->set_rules('title', 'Title', 'trim|required|xss_clean');
        $this->form_validation->set_rules('message', 'Message', 'trim|required|xss_clean');
        $this->form_validation->set_rules('date', 'Notice Date', 'trim|required|xss_clean');
        $this->form_validation->set_rules('publish_date', 'Publish Date', 'trim|required|xss_clean');
        $this->form_validation->set_rules('visible[]', 'Message To', 'required');
        if ($this->form_validation->run() == FALSE) {
            
        } else {
            $student = "No";
            $teacher = "No";
            $parent = "No";
            $visible = $this->input->post('visible');
            foreach ($visible as $key => $value) {
                if ($value == "student") {
                    $student = "Yes";
                } else if ($value == "teacher") {
                    $teacher = "Yes";
                } else if ($value == "parent") {
                    $parent = "Yes";
                }
            }
            $data = array(
                'message' => $this->input->post('message'),
                'title' => $this->input->post('title'),
                'date' => date('Y-m-d', $this->customlib->datetostrtotime($this->input->post('date'))),
                'created_by' => 'admin',
                'created_id' => 1,
                'visible_student' => $student,
                'visible_teacher' => $teacher,
                'visible_parent' => $parent,
                'publish_date' => date('Y-m-d', $this->customlib->datetostrtotime($this->input->post('publish_date'))),
            );
            $this->notification_model->add($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success">Notification added successfully!</div>');
            redirect('teacher/notification');
        }
        $exam_result = $this->exam_model->get();
        $data['examlist'] = $exam_result;
        $this->load->view('layout/teacher/header', $data);
        $this->load->view('teacher/notification/notificationAdd', $data);
        $this->load->view('layout/teacher/footer', $data);
    }

    function edit($id) {
        $data['id'] = $id;
        $notification = $this->notification_model->get($id);
        $data['notification'] = $notification;
        $data['title'] = 'Edit Notification';
        $data['title_list'] = 'Notification List';
        $this->form_validation->set_rules('title', 'Title', 'trim|required|xss_clean');
        $this->form_validation->set_rules('message', 'Message', 'trim|required|xss_clean');
        $this->form_validation->set_rules('date', 'Notice Date', 'trim|required|xss_clean');
        $this->form_validation->set_rules('publish_date', 'Publish Date', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            
        } else {
            $student = $this->input->post('visible_to_std');
            $teacher = $this->input->post('visible_to_tea');
            $parent = $this->input->post('visible_to_par');
            $data = array(
                'id' => $id,
                'message' => $this->input->post('message'),
                'title' => $this->input->post('title'),
                'date' => date('Y-m-d', $this->customlib->datetostrtotime($this->input->post('date'))),
                'created_by' => 'admin',
                'created_id' => 1,
                'visible_student' => isset($student) ? "Yes" : 'No',
                'visible_teacher' => isset($teacher) ? "Yes" : 'No',
                'visible_parent' => isset($parent) ? "Yes" : 'No',
                'publish_date' => date('Y-m-d', $this->customlib->datetostrtotime($this->input->post('publish_date'))),
            );
            $this->notification_model->add($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success">Notification added successfully!</div>');
            redirect('teacher/notification/index');
        }
        $exam_result = $this->exam_model->get();
        $data['examlist'] = $exam_result;
        $this->load->view('layout/teacher/header', $data);
        $this->load->view('teacher/notification/notificationEdit', $data);
        $this->load->view('layout/teacher/footer', $data);
    }

    function delete($id) {
        $this->notification_model->remove($id);
        redirect('teacher/notification');
    }

}

?>