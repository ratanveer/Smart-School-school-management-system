<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Timetable extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->helper('file');
        $this->lang->load('message', 'english');
        $this->load->library('auth');
        $this->auth->is_logged_in_user();
    }

    function index() {
        $this->session->set_userdata('top_menu', 'Time_table');
        $student_id = $this->customlib->getStudentSessionUserID();
        $student = $this->student_model->get($student_id);
        $class_id = $student['class_id'];
        $section_id = $student['section_id'];
        $data['title'] = 'Exam Marks';
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
        $this->load->view('layout/student/header', $data);
        $this->load->view('user/timetable/timetableList', $data);
        $this->load->view('layout/student/footer', $data);
    }

}

?>