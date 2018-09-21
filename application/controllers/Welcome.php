<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

    public function index() {
        $this->load->view('welcome_message');
    }

    public function show_404() {
        $this->load->view('errors/error_message');
    }

}
