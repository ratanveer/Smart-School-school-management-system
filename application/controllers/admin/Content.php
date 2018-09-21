<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Content extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->lang->load('message', 'english');
        $this->load->library('Customlib');
    }

    public function index() {
        $this->session->set_userdata('top_menu', 'Download Center');
        $this->session->set_userdata('sub_menu', 'content/index');
        $data['title'] = 'Upload Content';
        $data['title_list'] = 'Upload Content List';
        $list = $this->content_model->get();
        $data['list'] = $list;
        $ght = $this->customlib->getcontenttype();
        $data['ght'] = $ght;
        $class = $this->class_model->get();
        $data['classlist'] = $class;
        $this->load->view('layout/header');
        $this->load->view('admin/content/createcontent', $data);
        $this->load->view('layout/footer');
    }

    function createcontent() {
        $data['title'] = 'Upload Content';
        $data['title_list'] = 'Upload Content List';
        $this->form_validation->set_rules('content_title', 'Content Title', 'trim|required|xss_clean');
        $this->form_validation->set_rules('content_type', 'Content Type', 'trim|required|xss_clean');
        $this->form_validation->set_rules('file', 'Image', 'callback_handle_upload');
        if ($this->form_validation->run() == FALSE) {
            $list = $this->content_model->get();
            $data['list'] = $list;
            $class = $this->class_model->get();
            $data['classlist'] = $class;
            $ght = $this->customlib->getcontenttype();
            $data['ght'] = $ght;
            $this->load->view('layout/header');
            $this->load->view('admin/content/createcontent', $data);
            $this->load->view('layout/footer');
        } else {
            $visibility = "No";
            $classes = $this->input->post('class_id');
            $vs = $this->input->post('visibility');
            if (isset($vs)) {
                $visibility = $this->input->post('visibility');
                $classes = "";
            }
            $data = array(
                'title' => $this->input->post('content_title'),
                'type' => $this->input->post('content_type'),
                'note' => $this->input->post('note'),
                'class_id' => $classes,
                'date' => date('Y-m-d', $this->customlib->datetostrtotime($this->input->post('upload_date'))),
                'file' => $this->input->post('file'),
                'is_public' => $visibility
            );
            $insert_id = $this->content_model->add($data);
            if (isset($_FILES["file"]) && !empty($_FILES['file']['name'])) {
                $fileInfo = pathinfo($_FILES["file"]["name"]);
                $img_name = $insert_id . '.' . $fileInfo['extension'];
                move_uploaded_file($_FILES["file"]["tmp_name"], "./uploads/school_content/material/" . $img_name);
                $data_img = array('id' => $insert_id, 'file' => 'uploads/school_content/material/' . $img_name);
                $this->content_model->add($data_img);
            }
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">Content added successfully</div>');
            redirect('admin/content');
        }
    }

    function handle_upload() {
        if (isset($_FILES["file"]) && !empty($_FILES['file']['name'])) {
            $allowedExts = array('jpg', 'jpeg', 'png', "pdf", "doc", "docx", "rar", "zip");
            $temp = explode(".", $_FILES["file"]["name"]);
            $extension = end($temp);
            if ($_FILES["file"]["error"] > 0) {
                $error .= "Error opening the file<br />";
            }
            if (($_FILES["file"]["type"] != "application/pdf") && ($_FILES["file"]["type"] != "image/gif") && ($_FILES["file"]["type"] != "image/jpeg") && ($_FILES["file"]["type"] != "image/jpg") && ($_FILES["file"]["type"] != "application/vnd.openxmlformats-officedocument.wordprocessingml.document") && ($_FILES["file"]["type"] != "application/vnd.openxmlformats-officedocument.wordprocessingml.document") && ($_FILES["file"]["type"] != "image/pjpeg") && ($_FILES["file"]["type"] != "image/x-png") && ($_FILES["file"]["type"] != "application/x-rar-compressed") && ($_FILES["file"]["type"] != "application/octet-stream") && ($_FILES["file"]["type"] != "application/zip") && ($_FILES["file"]["type"] != "application/octet-stream") && ($_FILES["file"]["type"] != "image/png")) {
                $this->form_validation->set_message('handle_upload', 'File type not allowed');
                return false;
            }
            if (!in_array($extension, $allowedExts)) {
                $this->form_validation->set_message('handle_upload', 'Extension not allowed');
                return false;
            }
            return true;
        } else {
            $this->form_validation->set_message('handle_upload', 'The File field is required.');
            return false;
        }
    }

    public function download($file) {
        $this->load->helper('download');
        $filepath = "./uploads/school_content/material/" . $this->uri->segment(7);
        $data = file_get_contents($filepath);
        $name = $this->uri->segment(7);
        force_download($name, $data);
    }

    function edit($id) {
        $data['title'] = 'Add Content';
        $data['id'] = $id;
        $editpost = $this->content_model->get($id);
        $data['editpost'] = $editpost;
        $ght = $this->customlib->getcontenttype();
        $data['ght'] = $ght;
        $class = $this->class_model->get();
        $data['classlist'] = $class;
        $this->form_validation->set_rules('content_title', 'Content Title', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $listpost = $this->content_model->get();
            $data['listpost'] = $listpost;
            $this->load->view('layout/header');
            $this->load->view('admin/content/editpost', $data);
            $this->load->view('layout/footer');
        } else {
            $data = array(
                'id' => $this->input->post('id'),
                'content_title' => $this->input->post('content_title'),
                'content_type' => $this->input->post('content_type'),
                'class_id' => $this->input->post('class_id'),
                'date' => date('Y-m-d', $this->customlib->datetostrtotime($this->input->post('upload_date'))),
                'file_uploaded' => $this->input->file['file']['name']
            );
            $this->content_model->addcontentpost($data);
            if (isset($_FILES["file"]) && !empty($_FILES['file']['name'])) {
                $fileInfo = pathinfo($_FILES["file"]["name"]);
                $img_name = $id . '.' . $fileInfo['extension'];
                move_uploaded_file($_FILES["file"]["tmp_name"], "./uploads/student_images/" . $img_name);
                $data_img = array('id' => $id, 'file_uploaded' => 'uploads/student_images/' . $img_name);
                $this->content_model->addcontentpost($data_img);
            }
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Content details added to Database!!!</div>');
            redirect('admin/content/createcontent/index');
        }
    }

    function search() {
        $text = $_GET['content'];
        $data['title'] = 'Fees Master List';
        $contentlist = $this->content_model->search_by_content_type($text);
        $data['contentlist'] = $contentlist;
        $this->load->view('layout/header');
        $this->load->view('admin/content/search', $data);
        $this->load->view('layout/footer');
    }

    function delete($id) {
        $data = $this->content_model->get($id);
        $file = $data['file'];
        unlink($file);
        $this->content_model->remove($id);
        redirect('admin/content');
    }

    function deleteassignment($id) {
        $this->content_model->remove($id);
        $data['title_list'] = 'Assignment List';
        $list = $this->content_model->getListByCategory("Assignments");
        $data['list'] = $list;
        $this->load->view('layout/header');
        $this->load->view('admin/content/assignment', $data);
        $this->load->view('layout/footer');
    }

    public function assignment() {
        $this->session->set_userdata('top_menu', 'Download Center');
        $this->session->set_userdata('sub_menu', 'content/assignment');
        $data['title_list'] = 'Assignment List';
        $list = $this->content_model->getListByCategory("Assignments");
        $data['list'] = $list;
        $this->load->view('layout/header');
        $this->load->view('admin/content/assignment', $data);
        $this->load->view('layout/footer');
    }

    public function studymaterial() {
        $this->session->set_userdata('top_menu', 'Download Center');
        $this->session->set_userdata('sub_menu', 'content/studymaterial');
        $data['title_list'] = 'Study Material List';
        $list = $this->content_model->getListByCategory("Study Material");
        $data['list'] = $list;
        $this->load->view('layout/header');
        $this->load->view('admin/content/studymaterial', $data);
        $this->load->view('layout/footer');
    }

    public function syllabus() {
        $this->session->set_userdata('top_menu', 'Download Center');
        $this->session->set_userdata('sub_menu', 'content/syllabus');
        $data['title_list'] = 'Syllabus List';
        $list = $this->content_model->getListByCategory("Syllabus");
        $data['list'] = $list;
        $this->load->view('layout/header');
        $this->load->view('admin/content/syllabus', $data);
        $this->load->view('layout/footer');
    }

    public function other() {
        $this->session->set_userdata('top_menu', 'Download Center');
        $this->session->set_userdata('sub_menu', 'content/other');
        $data['title_list'] = 'Other Download List';
        $list = $this->content_model->getListByCategory("Other Download");
        $data['list'] = $list;
        $this->load->view('layout/header');
        $this->load->view('admin/content/other', $data);
        $this->load->view('layout/footer');
    }

}

?>