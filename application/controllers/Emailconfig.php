<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Emailconfig extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('file');
        $this->lang->load('message', 'english');
    }

    function index() {

        $data = array();
        $data['title'] = 'Email Config List';
        $data['mailMethods'] = $this->customlib->getMailMethod();
        $emaillist = $this->emailconfig_model->get();

        if (empty($emaillist)) {
            $emaillist = new stdClass();
            $emaillist->email_type = "";
            $emaillist->smtp_server = "";
            $emaillist->smtp_port = "";
            $emaillist->smtp_username = "";
            $emaillist->smtp_password = "";
            $emaillist->ssl_tls = "";
        }
        $data['emaillist'] = $emaillist;
        $this->session->set_userdata('top_menu', 'System Settings');
        $this->session->set_userdata('sub_menu', 'emailconfig/index');
        $this->form_validation->set_rules('email_type', 'Email Type', 'required');
        if ($this->input->post('email_type') == "smtp") {
            $this->form_validation->set_rules('smtp_username', 'SMTP Username', 'required');
            $this->form_validation->set_rules('smtp_password', 'SMTP Password', 'required');
            $this->form_validation->set_rules('smtp_server', 'SMTP Server', 'required');
            $this->form_validation->set_rules('smtp_port', 'SMTP Port', 'required');
            $this->form_validation->set_rules('smtp_security', 'SMTP Security ', 'required');
        }

        if ($this->form_validation->run() === FALSE) {
            $data['title'] = 'Email Config List';
            $this->load->view('layout/header', $data);
            $this->load->view('emailconfig/emailIndex', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $data['title'] = 'Email Config List';
            $data_insert = array(
                'email_type' => $this->input->post('email_type'),
                'smtp_username' => $this->input->post('smtp_username'),
                'smtp_password' => $this->input->post('smtp_password'),
                'smtp_server' => $this->input->post('smtp_server'),
                'smtp_port' => $this->input->post('smtp_port'),
                'ssl_tls' => $this->input->post('smtp_security'),
                'is_active' => 'yes',
            );
            $this->emailconfig_model->add($data_insert);
            $this->session->set_flashdata('msg', '<div class="alert alert-success">Record Updated Successfully</div>');
            redirect('emailconfig');
        }
    }

}

?>