<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Book extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('file');
        $this->lang->load('message', 'english');
        $this->role;
        $this->load->library('auth');
        $this->auth->is_logged_in_librarian();
    }

    public function index() {
        $this->session->set_userdata('top_menu', 'Library');
        $this->session->set_userdata('sub_menu', 'book/index');
        $data['title'] = 'Add Book';
        $data['title_list'] = 'Book Details';
        $listbook = $this->book_model->listbook();
        $data['listbook'] = $listbook;
        $this->load->view('layout/librarian/header');
        $this->load->view('librarian/book/createbook', $data);
        $this->load->view('layout/librarian/footer');
    }

    public function getall() {
        $this->session->set_userdata('top_menu', 'Library');
        $this->session->set_userdata('sub_menu', 'book/getall');
        $data['title'] = 'Add Book';
        $data['title_list'] = 'Book Details';
        $listbook = $this->book_model->get();
        $data['listbook'] = $listbook;
        $this->load->view('layout/librarian/header');
        $this->load->view('librarian/book/getall', $data);
        $this->load->view('layout/librarian/footer');
    }

    function create() {
        $data['title'] = 'Add Book';
        $data['title_list'] = 'Book Details';
        $this->form_validation->set_rules('book_title', 'Book Title', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $listbook = $this->book_model->listbook();
            $data['listbook'] = $listbook;
            $this->load->view('layout/librarian/header');
            $this->load->view('librarian/book/createbook', $data);
            $this->load->view('layout/librarian/footer');
        } else {
            $data = array(
                'book_title' => $this->input->post('book_title'),
                'book_no' => $this->input->post('book_no'),
                'isbn_no' => $this->input->post('isbn_no'),
                'subject' => $this->input->post('subject'),
                'rack_no' => $this->input->post('rack_no'),
                'publish' => $this->input->post('publish'),
                'author' => $this->input->post('author'),
                'qty' => $this->input->post('qty'),
                'perunitcost' => $this->input->post('perunitcost'),
                'postdate' => date('Y-m-d', $this->customlib->datetostrtotime($this->input->post('postdate'))),
                'description' => $this->input->post('description')
            );
            $this->book_model->addbooks($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">Book added successfully</div>');
            redirect('librarian/book/index');
        }
    }

    function edit($id) {
        $data['title'] = 'Edit Book';
        $data['title_list'] = 'Book Details';
        $data['id'] = $id;
        $editbook = $this->book_model->get($id);
        $data['editbook'] = $editbook;
        $this->form_validation->set_rules('book_title', 'Book Title', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $listbook = $this->book_model->listbook();
            $data['listbook'] = $listbook;
            $this->load->view('layout/librarian/header');
            $this->load->view('librarian/book/editbook', $data);
            $this->load->view('layout/librarian/footer');
        } else {
            $data = array(
                'id' => $this->input->post('id'),
                'book_title' => $this->input->post('book_title'),
                'book_no' => $this->input->post('book_no'),
                'isbn_no' => $this->input->post('isbn_no'),
                'subject' => $this->input->post('subject'),
                'rack_no' => $this->input->post('rack_no'),
                'publish' => $this->input->post('publish'),
                'author' => $this->input->post('author'),
                'qty' => $this->input->post('qty'),
                'perunitcost' => $this->input->post('perunitcost'),
                'postdate' => date('Y-m-d', $this->customlib->datetostrtotime($this->input->post('postdate'))),
                'description' => $this->input->post('description')
            );
            $this->book_model->addbooks($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">Book updated successfully</div>');
            redirect('librarian/book/index');
        }
    }

    function delete($id) {
        $data['title'] = 'Fees Master List';
        $this->book_model->remove($id);
        redirect('librarian/book/getall');
    }

    function issue() {
        $this->session->set_userdata('top_menu', 'dashboard');

        $data = array();
        $librarian_id = $this->session->userdata['student']['librarian_id'];
        $data['title'] = 'librarian';
        $librarian = $this->librarian_model->get($librarian_id);
        $data['librarian'] = $librarian;

        $this->load->view('layout/librarian/header', $data);
        $this->load->view('librarian/book/issue', $data);
        $this->load->view('layout/librarian/footer', $data);
    }

    function getuserlist() {
        $result = array();
        $userlist = $this->input->post('userlist');
        if ($userlist == "students") {
            $students = $this->student_model->searchCurrentSessionStudents();
            $result = array('type' => 'student', 'result' => $students);
        }
        echo json_encode($result);
    }

}

?>