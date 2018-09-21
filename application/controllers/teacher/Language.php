<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class language extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->lang->load('message', 'english');
        $this->load->library('auth');
        $this->auth->is_logged_in_teacher();
    }

    function index() {
        $this->session->set_userdata('top_menu', 'System Settings');
        $this->session->set_userdata('sub_menu', 'language/index');
        $data['title'] = 'Language List';
        $language_result = $this->language_model->get();
        $data['languagelist'] = $language_result;
        $this->load->view('layout/teacher/teacher/teacher/header', $data);
        $this->load->view('teacher/language/languageList', $data);
        $this->load->view('layout/teacher/teacher/teacher/footer', $data);
    }

    function view($id) {
        $data['title'] = 'Language List';
        $language = $this->language_model->get($id);
        $data['language'] = $language;
        $this->load->view('layout/teacher/teacher/header', $data);
        $this->load->view('teacher/language/sectionShow', $data);
        $this->load->view('layout/teacher/teacher/footer', $data);
    }

    function delete($id) {
        $data['title'] = 'Language List';
        $this->language_model->remove($id);
        redirect('teacher/sections/index');
    }

    function create() {
        $data['title'] = 'Add Language';
        $this->form_validation->set_rules('language', 'Language', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/teacher/header', $data);
            $this->load->view('teacher/language/languageCreate', $data);
            $this->load->view('layout/teacher/footer', $data);
        } else {
            $data = array(
                'language' => $this->input->post('language'),
            );
            $this->language_model->add($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Language added </div>');
            redirect('teacher/language/index');
        }
    }

    function addPharses($id) {
        $language = $this->language_model->get($id);
        $data['title'] = 'Edit Pharses for ' . $language['language'];
        $data['lang1'] = $language['language'];
        $language_pharses = $this->langpharses_model->get($id);
        $data['language_pharses'] = $language_pharses;
        $data['id'] = $id;
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $ar = $this->input->post('i[]');
            foreach ($ar as $key => $a) {
                $pharsesid = $this->input->post('pharsesid' . $a);
                $pharses_value = $this->input->post('pharses' . $a);
                $languageid = $this->input->post('languageid');
                if ($pharsesid == 0 && $pharses_value == "") {
                    
                } else if ($pharsesid > 0) {
                    $d = array('id' => $pharsesid, 'pharses' => $pharses_value, 'lang_id' => $languageid);
                    $this->langpharses_model->add($d);
                } else if ($pharsesid == 0 && $pharses_value != "") {
                    $d = array('key_id' => $a, 'pharses' => $pharses_value, 'lang_id' => $languageid);
                    $this->langpharses_model->add($d);
                }
            }
            redirect('teacher/language/addPharses/' . $languageid);
        } else {
            $this->load->view('layout/teacher/header', $data);
            $this->load->view('teacher/language/addPharse', $data);
            $this->load->view('layout/teacher/footer', $data);
        }
    }

    function edit($id) {
        $data['title'] = 'Edit Language';
        $data['id'] = $id;
        $section = $this->language_model->get($id);
        $data['section'] = $section;
        $this->form_validation->set_rules('section', 'Language', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/teacher/header', $data);
            $this->load->view('teacher/language/sectionEdit', $data);
            $this->load->view('layout/teacher/footer', $data);
        } else {
            $data = array(
                'id' => $id,
                'section' => $this->input->post('section'),
            );
            $this->language_model->add($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Language updated successfully</div>');
            redirect('teacher/sections/index');
        }
    }

}

?>