<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Parents extends CI_Controller {

   public $payment_method;
    function __construct() {
        parent::__construct();
        $this->load->library('auth');
        $this->lang->load('message', 'english');
        $this->load->library('auth');
        $this->auth->is_logged_in_parent();
          $this->payment_method =  $this->paymentsetting_model->getActiveMethod();
    }

    function dashboard() {
        $this->session->set_userdata('top_menu', 'My Children');
        $this->session->set_userdata('sub_menu', 'parent/parents/dashboard');
        $student_id = $this->customlib->getStudentSessionUserID();
        $array_childs = array();
        $ch = $this->session->userdata('parent_childs');
        foreach ($ch as $key_ch => $value_ch) {
            $array_childs[] = $this->student_model->get($value_ch['student_id']);
        }
        $data['student_list'] = $array_childs;
        $this->load->view('layout/parent/header', $data);
        $this->load->view('parent/dashboard', $data);
        $this->load->view('layout/parent/footer', $data);
    }

    public function download($student_id, $doc) {
        $this->load->helper('download');
        $filepath = "./uploads/student_documents/$student_id/" . $this->uri->segment(5);
        $data = file_get_contents($filepath);
        $name = $this->uri->segment(6);
        force_download($name, $data);
    }

    function changepass() {
        $data['title'] = 'Change Password';
        $this->form_validation->set_rules('current_pass', 'Current password', 'trim|required|xss_clean');
        $this->form_validation->set_rules('new_pass', 'New password', 'trim|required|xss_clean|matches[confirm_pass]');
        $this->form_validation->set_rules('confirm_pass', 'Confirm password', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $sessionData = $this->session->userdata('loggedIn');
            $this->data['id'] = $sessionData['id'];
            $this->data['username'] = $sessionData['username'];
            $this->load->view('layout/parent/header', $data);
            $this->load->view('parent/change_password', $data);
            $this->load->view('layout/parent/footer', $data);
        } else {
            $sessionData = $this->session->userdata('student');
            $data_array = array(
                'current_pass' => ($this->input->post('current_pass')),
                'new_pass' => ($this->input->post('new_pass')),
                'user_id' => $sessionData['id'],
                'user_name' => $sessionData['username']
            );
            $newdata = array(
                'id' => $sessionData['id'],
                'password' => $this->input->post('new_pass')
            );
            $query1 = $this->user_model->checkOldPass($data_array);
            if ($query1) {
                $query2 = $this->user_model->saveNewPass($newdata);
                if ($query2) {

                    $this->session->set_flashdata('success_msg', 'Password changed successfully');
                    $this->load->view('layout/parent/header', $data);
                    $this->load->view('parent/change_password', $data);
                    $this->load->view('layout/parent/footer', $data);
                }
            } else {

                $this->session->set_flashdata('error_msg', 'Invalid current password');
                $this->load->view('layout/parent/header', $data);
                $this->load->view('parent/change_password', $data);
                $this->load->view('layout/parent/footer', $data);
            }
        }
    }

    function changeusername() {
        $sessionData = $this->customlib->getLoggedInUserData();

        $data['title'] = 'Change Username';
        $this->form_validation->set_rules('current_username', 'Current username', 'trim|required|xss_clean');
        $this->form_validation->set_rules('new_username', 'New username', 'trim|required|xss_clean|matches[confirm_username]');
        $this->form_validation->set_rules('confirm_username', 'Confirm username', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            
        } else {

            $data_array = array(
                'username' => $this->input->post('current_username'),
                'new_username' => $this->input->post('new_username'),
                'role' => $sessionData['role'],
                'user_id' => $sessionData['id'],
            );
            $newdata = array(
                'id' => $sessionData['id'],
                'username' => $this->input->post('new_username')
            );
            $is_valid = $this->user_model->checkOldUsername($data_array);

            if ($is_valid) {
                $is_exists = $this->user_model->checkUserNameExist($data_array);
                if (!$is_exists) {
                    $is_updated = $this->user_model->saveNewUsername($newdata);
                    if ($is_updated) {
                        $this->session->set_flashdata('success_msg', 'Username changed successfully');
                        redirect('parent/parents/changeusername');
                    }
                } else {
                    $this->session->set_flashdata('error_msg', 'Username Already Exists, Please choose other');
                }
            } else {
                $this->session->set_flashdata('error_msg', 'Invalid current username');
            }
        }
        $this->data['id'] = $sessionData['id'];
        $this->data['username'] = $sessionData['username'];
        $this->load->view('layout/parent/header', $data);
        $this->load->view('parent/change_username', $data);
        $this->load->view('layout/parent/footer', $data);
    }

    function getstudent($id = NULL) {
        $this->session->set_userdata('top_menu', 'My Children');
        $this->session->set_userdata('sub_menu', 'parent/parents/getStudent');

        $this->auth->validate_child($id);

        $student_id = $id;
        $payment_setting = $this->paymentsetting_model->get();
        $data['payment_setting'] = $payment_setting;
        $category = $this->category_model->get();
        $data['category_list'] = $category;
        $student = $this->student_model->get($student_id);
        $gradeList = $this->grade_model->get();
        $data['gradeList'] = $gradeList;
        $class_id = $student['class_id'];
        $section_id = $student['section_id'];
        $data['title'] = 'Student Details';
        $student_session_id = $student['student_session_id'];
        $student_due_fee = $this->studentfeemaster_model->getStudentFees($student_session_id);
        $student_discount_fee = $this->feediscount_model->getStudentFeesDiscount($student_session_id);
        $data['student_discount_fee'] = $student_discount_fee;
        $data['student_due_fee'] = $student_due_fee;
        $examList = $this->examschedule_model->getExamByClassandSection($student['class_id'], $student['section_id']);
        $data['examSchedule'] = array();
        if (!empty($examList)) {
            $new_array = array();
            foreach ($examList as $ex_key => $ex_value) {
                $array = array();
                $x = array();
                $exam_id = $ex_value['exam_id'];
                $exam_subjects = $this->examschedule_model->getresultByStudentandExam($exam_id, $student['id']);
                foreach ($exam_subjects as $key => $value) {
                    $exam_array = array();
                    $exam_array['exam_schedule_id'] = $value['exam_schedule_id'];
                    $exam_array['exam_id'] = $value['exam_id'];
                    $exam_array['full_marks'] = $value['full_marks'];
                    $exam_array['passing_marks'] = $value['passing_marks'];
                    $exam_array['exam_name'] = $value['name'];
                    $exam_array['exam_type'] = $value['type'];
                    $exam_array['attendence'] = $value['attendence'];
                    $exam_array['get_marks'] = $value['get_marks'];
                    $x[] = $exam_array;
                }
                $array['exam_name'] = $ex_value['name'];
                $array['exam_result'] = $x;
                $new_array[] = $array;
            }
            $data['examSchedule'] = $new_array;
        }
        $data['student'] = $student;
        $this->load->view('layout/parent/header', $data);
        $this->load->view('parent/student/getstudent', $data);
        $this->load->view('layout/parent/footer', $data);
    }

    function getfees($id = NULL) {
        $this->auth->validate_child($id);
        $this->session->set_userdata('top_menu', 'Fees');
        $this->session->set_userdata('sub_menu', 'parent/parents/getFees');
        $paymentoption = $this->customlib->checkPaypalDisplay();
        $data['paymentoption'] = $paymentoption;
        $data['payment_method'] = false;
        if (!empty($this->payment_method)) {
        $data['payment_method'] = true;

        }
        $student_id = $id;
        $student = $this->student_model->get($student_id);
        $class_id = $student['class_id'];
        $section_id = $student['section_id'];
        $data['title'] = 'Student Details';
        $student_due_fee = $this->studentfeemaster_model->getStudentFees($student['student_session_id']);
        $student_discount_fee = $this->feediscount_model->getStudentFeesDiscount($student['student_session_id']);
        $data['student_discount_fee'] = $student_discount_fee;
        $data['student_due_fee'] = $student_due_fee;
        $data['student'] = $student;
        $this->load->view('layout/parent/header', $data);
        $this->load->view('parent/student/getfees', $data);
        $this->load->view('layout/parent/footer', $data);
    }

    function gettimetable($id = NULL) {
        $this->auth->validate_child($id);
        $this->session->set_userdata('top_menu', 'Time Table');
        $this->session->set_userdata('sub_menu', 'parent/parents/gettimetable');
        $student_id = $id;
        $student = $this->student_model->get($student_id);
        $class_id = $student['class_id'];
        $section_id = $student['section_id'];
        $data['title'] = 'Student Details';
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
        $data['student'] = $student;
        $this->load->view('layout/parent/header', $data);
        $this->load->view('parent/student/gettimetable', $data);
        $this->load->view('layout/parent/footer', $data);
    }

    function getsubject($id = NULL) {
        $this->auth->validate_child($id);
        $this->session->set_userdata('top_menu', 'Subjects');
        $this->session->set_userdata('sub_menu', 'parent/parents/getsubject');
        $student_id = $id;
        $student = $this->student_model->get($student_id);
        $data['student'] = $student;
        $class_id = $student['class_id'];
        $section_id = $student['section_id'];
        $data['title'] = 'Student Details';
        $subject_list = $this->teachersubject_model->getSubjectByClsandSection($class_id, $section_id);
        $data['result_array'] = $subject_list;
        $this->load->view('layout/parent/header', $data);
        $this->load->view('parent/student/getsubject', $data);
        $this->load->view('layout/parent/footer', $data);
    }

    function getattendence($id = NULL) {
        $this->auth->validate_child($id);
        $this->session->set_userdata('top_menu', 'Attendance');
        $this->session->set_userdata('sub_menu', 'parent/parents/getattendence');
        $student_id = $id;
        $student = $this->student_model->get($student_id);
        $data['student'] = $student;
        $this->load->view('layout/parent/header', $data);
        $this->load->view('parent/student/getattendence', $data);
        $this->load->view('layout/parent/footer', $data);
    }

    public function getAjaxAttendence() {
        $year = $this->input->get('year');
        $month = $this->input->get('month');
        $student_session_id = $this->input->get('student_session');
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
                $s['body'] = "Information for this date<\/p>You can add html<\/strong> in this block<\/p>";
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

    function getexams($id = NULL) {
        $this->auth->validate_child($id);
        $this->session->set_userdata('top_menu', 'Examination');
        $this->session->set_userdata('sub_menu', 'parent/parents/getexams');
        $student_id = $id;
        $student = $this->student_model->get($student_id);
        $class_id = $student['class_id'];
        $section_id = $student['section_id'];
        $data['title'] = 'Student Details';
        $gradeList = $this->grade_model->get();
        $data['gradeList'] = $gradeList;
        $examList = $this->examschedule_model->getExamByClassandSection($student['class_id'], $student['section_id']);
        $data['examSchedule'] = array();
        if (!empty($examList)) {
            $new_array = array();
            foreach ($examList as $ex_key => $ex_value) {
                $array = array();
                $x = array();
                $exam_id = $ex_value['exam_id'];
                $exam_subjects = $this->examschedule_model->getresultByStudentandExam($exam_id, $student['id']);
                foreach ($exam_subjects as $key => $value) {
                    $exam_array = array();
                    $exam_array['exam_schedule_id'] = $value['exam_schedule_id'];
                    $exam_array['exam_id'] = $value['exam_id'];
                    $exam_array['full_marks'] = $value['full_marks'];
                    $exam_array['passing_marks'] = $value['passing_marks'];
                    $exam_array['exam_name'] = $value['name'];
                    $exam_array['exam_type'] = $value['type'];
                    $exam_array['attendence'] = $value['attendence'];
                    $exam_array['get_marks'] = $value['get_marks'];
                    $x[] = $exam_array;
                }
                $array['exam_name'] = $ex_value['name'];
                $array['exam_result'] = $x;
                $new_array[] = $array;
            }
            $data['examSchedule'] = $new_array;
        }
        $data['student'] = $student;
        $this->load->view('layout/parent/header', $data);
        $this->load->view('parent/student/getexams', $data);
        $this->load->view('layout/parent/footer', $data);
    }

    function getexamresult() {
        $student_id = $this->uri->segment('4');
        $exam_id = $this->uri->segment('5');
        $student = $this->student_model->get($student_id);
        $class_id = $student['class_id'];
        $section_id = $student['section_id'];
        $data['title'] = 'Exam Result';
        $data['student'] = $student;
        $new_array = array();
        $array = array();
        $x = array();
        $exam_detail_array = $this->exam_model->get($exam_id);
        $exam_subjects = $this->examschedule_model->getresultByStudentandExam($exam_id, $student_id);
        foreach ($exam_subjects as $key => $value) {
            $exam_array = array();
            $exam_array['exam_schedule_id'] = $value['exam_schedule_id'];
            $exam_array['exam_id'] = $value['exam_id'];
            $exam_array['full_marks'] = $value['full_marks'];
            $exam_array['passing_marks'] = $value['passing_marks'];
            $exam_array['exam_name'] = $value['name'];
            $exam_array['exam_type'] = $value['type'];
            $exam_array['attendence'] = $value['attendence'];
            $exam_array['get_marks'] = $value['get_marks'];
            $x[] = $exam_array;
        }
        $array['exam_name'] = $exam_detail_array['name'];
        $array['exam_result'] = $x;
        $new_array[] = $array;
        $data['examSchedule'] = $new_array;
        $this->load->view('layout/parent/header', $data);
        $this->load->view('parent/student/examresult', $data);
        $this->load->view('layout/parent/footer', $data);
    }

    function getexamtimetable() {
        $data['title'] = 'Student Details';
        $class_id = $this->uri->segment('4');
        $section_id = $this->uri->segment('5');
        $exam_id = $this->uri->segment('6');
        $examSchedule = $this->examschedule_model->getDetailbyClsandSection($class_id, $section_id, $exam_id);
        $data['examSchedule'] = $examSchedule;
        $exam_detail_array = $this->exam_model->get($exam_id);
        $data['exam_name'] = $exam_detail_array['name'];
        $this->load->view('layout/parent/header', $data);
        $this->load->view('parent/student/examtimetable', $data);
        $this->load->view('layout/parent/footer', $data);
    }

}

?>