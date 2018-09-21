<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Attendence extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('file');
        $this->lang->load('message', 'english');
        $this->load->library('auth');
        $this->auth->is_logged_in_user();
    }

    public function index() {
        $this->session->set_userdata('top_menu', 'Attendence');
        $this->session->set_userdata('sub_menu', 'book/index');
        $data['title'] = 'Attendence List';
        $result = array();
        $data['resultList'] = $result;
        $this->load->view('layout/student/header');
        $this->load->view('user/attendence/attendenceIndex', $data);
        $this->load->view('layout/student/footer');
    }

    public function getAttendence() {
        $year = $this->input->get('year');
        $month = $this->input->get('month');
        $student_id = $this->customlib->getStudentSessionUserID();
        $student = $this->student_model->get($student_id);
        $student_session_id = $student['student_session_id'];
        $result = array();
        $new_date = "01-" . $month . "-" . $year;
        $totalDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $first_day_this_month = date('01-m-Y');
        $fst_day_str = strtotime(date($new_date));
        $array = array();
        for ($day = 2; $day <= $totalDays; $day++) {
            $fst_day_str = ($fst_day_str + 86400);
            $date = date('Y-m-d', $fst_day_str);
            $student_attendence = $this->attendencetype_model->getStudentAttendence($date, $student_session_id);
            if (!empty($student_attendence)) {
                $s = array();
                $s['date'] = $date;
                $s['badge'] = false;
                $s['footer'] = "Extra information";
                $type = $student_attendence->type;
                $s['title'] = $type;
                if ($type == 'Present') {
                    $s['classname'] = "grade-4";
                } else if ($type == 'Absent') {
                    $s['classname'] = "grade-1";
                } else if ($type == 'Late') {
                    $s['classname'] = "grade-3";
                } else if ($type == 'Late with excuse') {
                    $s['classname'] = "grade-2";
                } else if ($type == 'Holiday') {
                    $s['classname'] = "grade-5";
                }
                $array[] = $s;
            }
        }
        if (!empty($array)) {
            echo json_encode($array);
        } else {
            echo false;
        }
    }

}

?>