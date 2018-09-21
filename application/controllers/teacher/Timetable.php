<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Timetable extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('file');
        $this->lang->load('message', 'english');
        $this->load->library('auth');
        $this->auth->is_logged_in_teacher();
    }

    function index() {
        $this->session->set_userdata('top_menu', 'Academics');
        $this->session->set_userdata('sub_menu', 'timetable/index');
        $session = $this->setting_model->getCurrentSession();
        $data['title'] = 'Exam Marks';
        $data['exam_id'] = "";
        $data['class_id'] = "";
        $data['section_id'] = "";
        $exam = $this->exam_model->get();
        $class = $this->class_model->get();
        $data['examlist'] = $exam;
        $data['classlist'] = $class;
        $feecategory = $this->feecategory_model->get();
        $data['feecategorylist'] = $feecategory;
        $this->form_validation->set_rules('class_id', 'Class', 'trim|required|xss_clean');
        $this->form_validation->set_rules('section_id', 'Section', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/teacher/header', $data);
            $this->load->view('teacher/timetable/timetableList', $data);
            $this->load->view('layout/teacher/footer', $data);
        } else {
            $class_id = $this->input->post('class_id');
            $section_id = $this->input->post('section_id');
            $data['class_id'] = $class_id;
            $data['section_id'] = $section_id;
            $result_subjects = $this->teachersubject_model->getSubjectByClsandSection($class_id, $section_id);
            $getDaysnameList = $this->customlib->getDaysname();
            $data['getDaysnameList'] = $getDaysnameList;
            $final_array = array();
            if (!empty($result_subjects)) {
                foreach ($result_subjects as $subject_k => $subject_v) {
                    $result_array = array();
                    foreach ($getDaysnameList as $day_key => $day_value) {
                        $where_array = array(
                            'teacher_subject_id' => $subject_v['id'],
                            'day_name' => $day_value
                        );
                        $result = $this->timetable_model->get($where_array);
                        if (!empty($result)) {
                            $obj = new stdClass();
                            $obj->status = "Yes";
                            $obj->start_time = $result[0]['start_time'];
                            $obj->end_time = $result[0]['end_time'];
                            $obj->room_no = $result[0]['room_no'];
                            $result_array[$day_value] = $obj;
                        } else {
                            $obj = new stdClass();
                            $obj->status = "No";
                            $obj->start_time = "N/A";
                            $obj->end_time = "N/A";
                            $obj->room_no = "N/A";
                            $result_array[$day_value] = $obj;
                        }
                    }
                    $final_array[$subject_v['name']] = $result_array;
                }
            }
            $data['result_array'] = $final_array;
            $this->load->view('layout/teacher/header', $data);
            $this->load->view('teacher/timetable/timetableList', $data);
            $this->load->view('layout/teacher/footer', $data);
        }
    }

    function view($id) {
        $data['title'] = 'Mark List';
        $mark = $this->mark_model->get($id);
        $data['mark'] = $mark;
        $this->load->view('layout/teacher/header', $data);
        $this->load->view('teacher/timetablteacher/e/timetableShow', $data);
        $this->load->view('layout/teacher/footer', $data);
    }

    function delete($id) {
        $data['title'] = 'Mark List';
        $this->mark_model->remove($id);
        redirect('teacher/timetable/index');
    }

    function create() {
        $session = $this->setting_model->getCurrentSession();
        $data['title'] = 'Exam Schedule';
        $data['subject_id'] = "";
        $data['class_id'] = "";
        $data['section_id'] = "";
        $exam = $this->exam_model->get();
        $class = $this->class_model->get();
        $data['examlist'] = $exam;
        $data['classlist'] = $class;
        $feecategory = $this->feecategory_model->get();
        $data['feecategorylist'] = $feecategory;
        $this->form_validation->set_rules('subject_id', 'Subject', 'trim|required|xss_clean');
        $this->form_validation->set_rules('class_id', 'Class', 'trim|required|xss_clean');
        $this->form_validation->set_rules('section_id', 'Section', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/teacher/header', $data);
            $this->load->view('teacher/timetable/timetableCreate', $data);
            $this->load->view('layout/teacher/footer', $data);
        } else {
            $feecategory_id = $this->input->post('feecategory_id');
            $subject_id = $this->input->post('subject_id');
            $class_id = $this->input->post('class_id');
            $section_id = $this->input->post('section_id');
            $data['subject_id'] = $subject_id;
            $data['class_id'] = $class_id;
            $data['section_id'] = $section_id;
            $getDaysnameList = $this->customlib->getDaysname();
            $data['getDaysnameList'] = $getDaysnameList;
            $array = array();
            $data['timetableSchedule'] = array();
            foreach ($getDaysnameList as $key => $value) {
                $where_array = array(
                    'teacher_subject_id' => $subject_id,
                    'day_name' => $value
                );
                $result = $this->timetable_model->get($where_array);
                if (empty($result)) {
                    $obj = new stdClass();
                    $obj->starting_time = "";
                    $obj->post_id = 0;
                    $obj->ending_time = "";
                    $obj->room_no = "";
                } else {
                    $obj = new stdClass();
                    $obj->starting_time = $result[0]['start_time'];
                    $obj->post_id = $result[0]['id'];
                    $obj->ending_time = $result[0]['end_time'];
                    $obj->room_no = $result[0]['room_no'];
                }
                $array[$value] = $obj;
            }
            $data['timetableSchedule'] = $array;
            if ($this->input->post('save_exam') == "save_exam") {
                $loop = $this->input->post('i');
                foreach ($loop as $key => $value) {
                    $data = array(
                        'day_name' => $value,
                        'teacher_subject_id' => $this->input->post('subject_id'),
                        'start_time' => $this->input->post('stime_' . $value),
                        'end_time' => $this->input->post('etime_' . $value),
                        'room_no' => $this->input->post('room_' . $value),
                        'id' => $this->input->post('edit_' . $value),
                    );
                    $this->timetable_model->add($data);
                }
                redirect('admin/timetable');
            }
            $this->load->view('layout/teacher/header', $data);
            $this->load->view('teacher/timetable/timetableCreate', $data);
            $this->load->view('layout/teacher/footer', $data);
        }
    }

    function edit($id) {
        $data['title'] = 'Edit Mark';
        $data['id'] = $id;
        $mark = $this->mark_model->get($id);
        $data['mark'] = $mark;
        $this->form_validation->set_rules('name', 'Mark', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/teacher/header', $data);
            $this->load->view('teacher/timetable/timetableEdit', $data);
            $this->load->view('layout/teacher/footer', $data);
        } else {
            $data = array(
                'id' => $id,
                'name' => $this->input->post('name'),
                'note' => $this->input->post('note'),
            );
            $this->mark_model->add($data);
            $this->session->set_flashdata('msg', '<div mark="alert alert-success text-center">Employee added successfully</div>');
            redirect('teacher/timetable/index');
        }
    }

}

?>