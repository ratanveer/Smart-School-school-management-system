<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sections extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('file');
        $this->lang->load('message', 'english');
        $this->load->library('auth');
        $this->auth->is_logged_in_accountant();
    }

    function getByClass() {
        $class_id = $this->input->get('class_id');
        $data = $this->section_model->getClassBySection($class_id);
        echo json_encode($data);
    }

}

?>