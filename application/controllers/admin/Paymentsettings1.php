<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Paymentsettings extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('file');
        $this->lang->load('message', 'english');
    }

    function index() {
        $this->session->set_userdata('top_menu', 'System Settings');
        $this->session->set_userdata('sub_menu', 'admin/paymentsettings');
        $data['title'] = 'Language List';
        $payment_setting = $this->paymentsetting_model->get();
        $data['payment_setting'] = $payment_setting;
        if (!empty($payment_setting)) {
            $data['record'] = $payment_setting;
        } else {
            $obj = new stdClass();
            $obj->id = "0";
            $obj->api_username = "";
            $obj->api_password = "";
            $obj->api_signature = "";
            $obj->api_email = "";
            $obj->paypal_demo = "";
            $obj->is_active = "no";
            $data['record'] = $obj;
        }
        $this->form_validation->set_rules('paypal_username', 'Username', 'trim|required|xss_clean');
        $this->form_validation->set_rules('paypal_password', 'Password', 'trim|required|xss_clean');
        $this->form_validation->set_rules('paypal_signature', 'Signature', 'trim|required|xss_clean');
        $this->form_validation->set_rules('paypal_email', 'Email', 'trim|required|xss_clean');
        $this->form_validation->set_rules('is_active', 'Active', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/header', $data);
            $this->load->view('admin/payment_setting/notificationAdd', $data);
            $this->load->view('layout/footer', $data);
        } else {
            if ($this->input->post('id') == 0) {
                $data = array(
                    'api_username' => $this->input->post('paypal_username'),
                    'api_password' => $this->input->post('paypal_password'),
                    'api_signature' => $this->input->post('paypal_signature'),
                    'api_email' => $this->input->post('paypal_email'),
                    'paypal_demo' => 'TRUE',
                    'is_active' => $this->input->post('is_active')
                );
            } else {
                $data = array(
                    'id' => $this->input->post('id'),
                    'api_username' => $this->input->post('paypal_username'),
                    'api_password' => $this->input->post('paypal_password'),
                    'api_signature' => $this->input->post('paypal_signature'),
                    'api_email' => $this->input->post('paypal_email'),
                    'paypal_demo' => 'TRUE',
                    'is_active' => $this->input->post('is_active')
                );
            }
            $this->paymentsetting_model->add($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success">Record Updated Successfully</div>');
            redirect('admin/paymentsettings');
        }
    }

}

?>