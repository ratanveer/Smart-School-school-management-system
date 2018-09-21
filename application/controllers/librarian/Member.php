<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Member extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('file');
        $this->lang->load('message', 'english');
        $this->role;
        $this->load->library('auth');
        $this->auth->is_logged_in_librarian();
    }

    public function index() {
        $this->session->set_userdata('top_menu', 'Member');
        $this->session->set_userdata('sub_menu', 'member/index');
        $data['title'] = 'Member';
        $data['title_list'] = 'Members';
        $memberList = $this->librarymember_model->get();
        $data['memberList'] = $memberList;
        $this->load->view('layout/librarian/header');
        $this->load->view('librarian/member/index', $data);
        $this->load->view('layout/librarian/footer');
    }

    public function issue($id) {
        $this->session->set_userdata('top_menu', 'Member');
        $this->session->set_userdata('sub_menu', 'member/index');
        $data['title'] = 'Member';
        $data['title_list'] = 'Members';
        $memberList = $this->librarymember_model->getByMemberID($id);
        $data['memberList'] = $memberList;
        $issued_books = $this->bookissue_model->getMemberBooks($id);
        $data['issued_books'] = $issued_books;
        $bookList = $this->book_model->get();
        $data['bookList'] = $bookList;
        $this->form_validation->set_rules('book_id', 'Book', 'trim|required|xss_clean');
        $this->form_validation->set_rules('return_date', 'Return Date', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            
        } else {
            $member_id = $this->input->post('member_id');
            $data = array(
                'book_id' => $this->input->post('book_id'),
                'return_date' => date('Y-m-d', $this->customlib->datetostrtotime($this->input->post('return_date'))),
                'issue_date' => date('Y-m-d'),
                'member_id' => $this->input->post('member_id'),
            );
            $this->bookissue_model->add($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">Book issued successfully.</div>');
            redirect('librarian/member/issue/' . $member_id);
        }

        $this->load->view('layout/librarian/header');
        $this->load->view('librarian/member/issue', $data);
        $this->load->view('layout/librarian/footer');
    }

    public function bookreturn($id, $member_id) {
        $data = array(
            'id' => $id,
            'is_returned' => 1
        );
        $this->bookissue_model->update($data);
        redirect('librarian/member/issue/' . $member_id);
    }

    public function surrender() {

        $this->form_validation->set_rules('member_id', 'Book', 'trim|required|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            
        } else {


            $member_id = $this->input->post('member_id');
            $this->librarymember_model->surrender($member_id);
            $array = array('status' => 'success', 'error' => '', 'message' => 'Membership surrender successfully');
            echo json_encode($array);
        }
    }

}

?>