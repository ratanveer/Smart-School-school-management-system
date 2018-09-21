<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Stuattendence extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('file');
        $this->lang->load('message', 'english');
        $this->config->load("mailsms");
        $this->load->library('mailsmsconf');
        $this->config_attendance = $this->config->item('attendence');
    }

    function index() {

        $this->session->set_userdata('top_menu', 'Attendance');
        $this->session->set_userdata('sub_menu', 'stuattendence/index');
        $data['title'] = 'Add Fees Type';
        $data['title_list'] = 'Fees Type List';
        $class = $this->class_model->get();
        $data['classlist'] = $class;
        $data['class_id'] = "";
        $data['section_id'] = "";
        $data['date'] = "";
        $this->form_validation->set_rules('class_id', 'Class', 'trim|required|xss_clean');
        $this->form_validation->set_rules('section_id', 'Section', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/header', $data);
            $this->load->view('admin/stuattendence/attendenceList', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $class = $this->input->post('class_id');
            $section = $this->input->post('section_id');
            $date = $this->input->post('date');
            $student_list = $this->stuattendence_model->get();
            $data['studentlist'] = $student_list;
            $data['class_id'] = $class;
            $data['section_id'] = $section;
            $data['date'] = $date;
            $search = $this->input->post('search');
            $holiday = $this->input->post('holiday');
            if ($search == "saveattendence") {
                $session_ary = $this->input->post('student_session');
                $absent_student_list = array();
                foreach ($session_ary as $key => $value) {
                    $checkForUpdate = $this->input->post('attendendence_id' . $value);
                    if ($checkForUpdate != 0) {
                        if (isset($holiday)) {
                            $arr = array(
                                'id' => $checkForUpdate,
                                'student_session_id' => $value,
                                'attendence_type_id' => 5,
                                'date' => date('Y-m-d', $this->customlib->datetostrtotime($date))
                            );
                        } else {
                            $arr = array(
                                'id' => $checkForUpdate,
                                'student_session_id' => $value,
                                'attendence_type_id' => $this->input->post('attendencetype' . $value),
                                'date' => date('Y-m-d', $this->customlib->datetostrtotime($date))
                            );
                        }
                        $insert_id = $this->stuattendence_model->add($arr);
                    } else {
                        if (isset($holiday)) {
                            $arr = array(
                                'student_session_id' => $value,
                                'attendence_type_id' => 5,
                                'date' => date('Y-m-d', $this->customlib->datetostrtotime($date))
                            );
                        } else {


                            $arr = array(
                                'student_session_id' => $value,
                                'attendence_type_id' => $this->input->post('attendencetype' . $value),
                                'date' => date('Y-m-d', $this->customlib->datetostrtotime($date))
                            );
                        }
                        $insert_id = $this->stuattendence_model->add($arr);
                        $absent_config = $this->config_attendance['absent'];
                        if ($arr['attendence_type_id'] == $absent_config) {
                            $absent_student_list[] = $value;
                        }
                    }
                }
                $absent_config = $this->config_attendance['absent'];
                if (!empty($absent_student_list)) {

                    $this->mailsmsconf->mailsms('absent_attendence', $absent_student_list, $date);
                }

                $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">Attendance Saved Successfully</div>');
                redirect('admin/stuattendence/index');
            }
            $attendencetypes = $this->attendencetype_model->get();
            $data['attendencetypeslist'] = $attendencetypes;
            $resultlist = $this->stuattendence_model->searchAttendenceClassSection($class, $section, date('Y-m-d', $this->customlib->datetostrtotime($date)));
            $data['resultlist'] = $resultlist;
            $this->load->view('layout/header', $data);
            $this->load->view('admin/stuattendence/attendenceList', $data);
            $this->load->view('layout/footer', $data);
        }
    }

    function attendencereport() {
        $this->session->set_userdata('top_menu', 'Attendance');
        $this->session->set_userdata('sub_menu', 'stuattendence/attendenceReport');
        $data['title'] = 'Add Fees Type';
        $data['title_list'] = 'Fees Type List';
        $class = $this->class_model->get();
        $data['classlist'] = $class;
        $data['class_id'] = "";
        $data['section_id'] = "";
        $data['date'] = "";
        $this->form_validation->set_rules('class_id', 'Class', 'trim|required|xss_clean');
        $this->form_validation->set_rules('section_id', 'Section', 'trim|required|xss_clean');
        $this->form_validation->set_rules('date', 'Date', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/header', $data);
            $this->load->view('admin/stuattendence/attendencereport', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $class = $this->input->post('class_id');
            $section = $this->input->post('section_id');
            $date = $this->input->post('date');
            $student_list = $this->stuattendence_model->get();
            $data['studentlist'] = $student_list;
            $data['class_id'] = $class;
            $data['section_id'] = $section;
            $data['date'] = $date;
            $search = $this->input->post('search');
            if ($search == "saveattendence") {
                $session_ary = $this->input->post('student_session');
                foreach ($session_ary as $key => $value) {
                    $checkForUpdate = $this->input->post('attendendence_id' . $value);
                    if ($checkForUpdate != 0) {
                        $arr = array(
                            'id' => $checkForUpdate,
                            'student_session_id' => $value,
                            'attendence_type_id' => $this->input->post('attendencetype' . $value),
                            'date' => date('Y-m-d', $this->customlib->datetostrtotime($date))
                        );
                        $insert_id = $this->stuattendence_model->add($arr);
                    } else {
                        $arr = array(
                            'student_session_id' => $value,
                            'attendence_type_id' => $this->input->post('attendencetype' . $value),
                            'date' => date('Y-m-d', $this->customlib->datetostrtotime($date))
                        );
                        $insert_id = $this->stuattendence_model->add($arr);
                    }
                }
            }
            $attendencetypes = $this->attendencetype_model->get();
            $data['attendencetypeslist'] = $attendencetypes;
            $resultlist = $this->stuattendence_model->searchAttendenceClassSectionPrepare($class, $section, date('Y-m-d', $this->customlib->datetostrtotime($date)));
            $data['resultlist'] = $resultlist;
            $this->load->view('layout/header', $data);
            $this->load->view('admin/stuattendence/attendencereport', $data);
            $this->load->view('layout/footer', $data);
        }
    }

    function classattendencereport() {
        $this->session->set_userdata('top_menu', 'Attendance');
        $this->session->set_userdata('sub_menu', 'stuattendence/classattendencereport');
        $attendencetypes = $this->attendencetype_model->get();
        $data['attendencetypeslist'] = $attendencetypes;
        $data['title'] = 'Add Fees Type';
        $data['title_list'] = 'Fees Type List';
        $class = $this->class_model->get();
        $data['classlist'] = $class;
        $data['monthlist'] = $this->customlib->getMonthDropdown();
        $data['class_id'] = "";
        $data['section_id'] = "";
        $data['date'] = "";
        $data['month_selected'] = "";
        $this->form_validation->set_rules('class_id', 'Class', 'trim|required|xss_clean');
        $this->form_validation->set_rules('section_id', 'Section', 'trim|required|xss_clean');
        $this->form_validation->set_rules('month', 'Month', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/header', $data);
            $this->load->view('admin/stuattendence/classattendencereport', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $resultlist = array();
            $class = $this->input->post('class_id');
            $section = $this->input->post('section_id');
            $month = $this->input->post('month');
            $data['class_id'] = $class;
            $data['section_id'] = $section;
            $data['month_selected'] = $month;
            $studentlist = $this->student_model->searchByClassSection($class, $section);
            $session_current = $this->setting_model->getCurrentSessionName();
            $startMonth = $this->setting_model->getStartMonth();
            $centenary = substr($session_current, 0, 2); //2017-18 to 2017
            $year_first_substring = substr($session_current, 2, 2); //2017-18 to 2017
            $year_second_substring = substr($session_current, 5, 2); //2017-18 to 18
            $month_number = date("m", strtotime($month));

            if ($month_number >= $startMonth && $month_number <= 12) {
                $year = $centenary . $year_first_substring;
            } else {
                $year = $centenary . $year_second_substring;
            }
            $num_of_days = cal_days_in_month(CAL_GREGORIAN, $month_number, $year);
            $attr_result = array();
            $attendence_array = array();
            $student_result = array();
            $data['no_of_days'] = $num_of_days;
            $date_result = array();
            for ($i = 1; $i <= $num_of_days; $i++) {
                $att_date = $year . "-" . $month_number . "-" . sprintf("%02d", $i);
                $attendence_array[] = $att_date;

                $res = $this->stuattendence_model->searchAttendenceClassSection($class, $section, $att_date);
                $student_result = $res;
                $s = array();
                foreach ($res as $result_k => $result_v) {
                    $s[$result_v['student_session_id']] = $result_v;
                }
                $date_result[$att_date] = $s;
            }
            $data['resultlist'] = $date_result;
            $data['attendence_array'] = $attendence_array;
            $data['student_array'] = $student_result;
            $this->load->view('layout/header', $data);
            $this->load->view('admin/stuattendence/classattendencereport', $data);
            $this->load->view('layout/footer', $data);
        }
    }

}

?>