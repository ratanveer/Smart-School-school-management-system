<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Exam extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('file');
        $this->lang->load('message', 'english');
        $this->load->library('auth');
        $this->auth->is_logged_in_teacher();
    }

    public function examclasses($id) {
        $this->session->set_userdata('top_menu', 'Examinations');
        $this->session->set_userdata('sub_menu', 'exam/index');
        $data['title'] = 'list of  Alloted';
        $exam = $this->exam_model->get($id);
        $data['exam'] = $exam;
        $classsectionList = $this->examschedule_model->getclassandsectionbyexam($id);
        $array = array();
        foreach ($classsectionList as $key => $value) {
            $s = array();
            $exam_id = $value['exam_id'];
            $class_id = $value['class_id'];
            $section_id = $value['section_id'];
            $result_prepare = $this->examresult_model->checkexamresultpreparebyexam($exam_id, $class_id, $section_id);
            $s['exam_id'] = $exam_id;
            $s['class_id'] = $class_id;
            $s['section_id'] = $section_id;
            $s['class'] = $value['class'];
            $s['section'] = $value['section'];
            if ($result_prepare) {
                $s['result_prepare'] = "yes";
            } else {
                $s['result_prepare'] = "no";
            }
            $array[] = $s;
        }
        $data['classsectionList'] = $array;
        $this->load->view('layout/teacher/header');
        $this->load->view('teacher/exam/examClasses', $data);
        $this->load->view('layout/teacher/footer');
    }

    function index() {
        $this->session->set_userdata('top_menu', 'Examinations');
        $this->session->set_userdata('sub_menu', 'exam/index');
        $data['title'] = 'Add Exam';
        $data['title_list'] = 'Exam List';
        $this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            
        } else {
            $data = array(
                'name' => $this->input->post('name'),
                'note' => $this->input->post('note'),
            );
            $this->exam_model->add($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">Exam added successfully</div>');
            redirect('teacher/exam/index');
        }
        $exam_result = $this->exam_model->get();
        $data['examlist'] = $exam_result;
        $this->load->view('layout/teacher/header', $data);
        $this->load->view('teacher/exam/examList', $data);
        $this->load->view('layout/teacher/footer', $data);
    }

    function view($id) {
        $data['title'] = 'Exam List';
        $exam = $this->exam_model->get($id);
        $data['exam'] = $exam;
        $this->load->view('layout/teacher/header', $data);
        $this->load->view('teacher/exam/examShow', $data);
        $this->load->view('layout/teacher/footer', $data);
    }

    function getByFeecategory() {
        $feecategory_id = $this->input->get('feecategory_id');
        $data = $this->feetype_model->getTypeByFeecategory($feecategory_id);
        echo json_encode($data);
    }

    function getStudentCategoryFee() {
        $type = $this->input->post('type');
        $class_id = $this->input->post('class_id');
        $data = $this->exam_model->getTypeByFeecategory($type, $class_id);
        if (empty($data)) {
            $status = 'fail';
        } else {
            $status = 'success';
        }
        $array = array('status' => $status, 'data' => $data);
        echo json_encode($array);
    }

    function delete($id) {
        $data['title'] = 'Exam List';
        $this->exam_model->remove($id);
        redirect('teacher/exam/index');
    }

    function create() {
        $data['title'] = 'Add Exam';
        $this->form_validation->set_rules('exam', 'Exam', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/teacher/header', $data);
            $this->load->view('teacherexamCreate', $data);
            $this->load->view('layout/teacher/footer', $data);
        } else {
            $data = array(
                'exam' => $this->input->post('exam'),
                'note' => $this->input->post('note'),
            );
            $this->exam_model->add($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">Exam added successfully</div>');
            redirect('teacher/exam/index');
        }
    }

    function edit($id) {
        $data['title'] = 'Edit Exam';
        $data['id'] = $id;
        $exam = $this->exam_model->get($id);
        $data['exam'] = $exam;
        $data['title_list'] = 'Exam List';
        $exam_result = $this->exam_model->get();
        $data['examlist'] = $exam_result;
        $this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/teacher/header', $data);
            $this->load->view('teacher/exam/examEdit', $data);
            $this->load->view('layout/teacher/footer', $data);
        } else {
            $data = array(
                'id' => $id,
                'name' => $this->input->post('name'),
                'note' => $this->input->post('note'),
            );
            $this->exam_model->add($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">Exam update successfully</div>');
            redirect('teacher/exam/index');
        }
    }

    function examSearch() {
        $data['title'] = 'Search exam';
        if ($this->input->server('REQUEST_METHOD') == "POST") {
            $search = $this->input->post('search');
            if ($search == "search_filter") {
                $data['exp_title'] = 'exam Result From ' . $this->input->post('date_from') . " To " . $this->input->post('date_to');
                $date_from = date('Y-m-d', $this->customlib->datetostrtotime($this->input->post('date_from')));
                $date_to = date('Y-m-d', $this->customlib->datetostrtotime($this->input->post('date_to')));
                $resultList = $this->exam_model->search("", $date_from, $date_to);
                $data['resultList'] = $resultList;
            } else {
                $data['exp_title'] = 'exam Result';
                $search_text = $this->input->post('search_text');
                $resultList = $this->exam_model->search($search_text, "", "");
                $data['resultList'] = $resultList;
            }
            $this->load->view('layout/teacher/header', $data);
            $this->load->view('teacher/exam/examSearch', $data);
            $this->load->view('layout/teacher/footer', $data);
        } else {
            $this->load->view('layout/teacher/header', $data);
            $this->load->view('teacher/exam/examSearch', $data);
            $this->load->view('layout/teacher/footer', $data);
        }
    }

}

?>