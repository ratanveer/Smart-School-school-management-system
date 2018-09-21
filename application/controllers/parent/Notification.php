<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Notification extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('file');
        $this->lang->load('message', 'english');
        $this->load->library('auth');
        $this->auth->is_logged_in_parent();
    }

    function index() {
        $this->session->set_userdata('top_menu', 'Notification');
        $data['title'] = 'Notifications';
        $student_id = $this->customlib->getParentSessionUserID();
        $notifications = $this->notification_model->getNotificationForParent($student_id);
        $data['notificationlist'] = $notifications;
        $this->load->view('layout/parent/header', $data);
        $this->load->view('parent/notification/notificationList', $data);
        $this->load->view('layout/parent/footer', $data);
    }

    function updatestatus() {
        $notification_id = $this->input->post('notification_id');
        $student_id = $this->customlib->getParentSessionUserID();
        $data = $this->notification_model->updateStatusforParent($notification_id, $student_id);
        $array = array('status' => "success", 'data' => $data);
        echo json_encode($array);
    }

}

?>