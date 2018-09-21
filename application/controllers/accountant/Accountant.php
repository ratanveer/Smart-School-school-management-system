<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Accountant extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('file');
        $this->lang->load('message', 'english');
        $this->role;
        $this->load->library('auth');
        $this->auth->is_logged_in_accountant();
        $this->load->library('customlib');
    }

    function dashboard() {
        $this->session->set_userdata('top_menu', 'dashboard');

              $input = $this->setting_model->getCurrentSessionName();;
            list($a, $b) = explode('-', $input);
            $Current_year=$a;
            if(strlen($b) == 2){
            $Next_year=substr($a,0,2).$b;
            }else{
            $Next_year=$b;
            }		
		
        //========================== Current Attendence ==========================
        $current_date = date('Y-m-d');
        $data['title'] = 'Dashboard';
        $Current_start_date = date('01');
        $Current_date = date('d');
        $Current_month = date('m');
        //$Current_year = date('Y');
        //$Next_year = date('Y', strtotime('+1 year'));
        $month_collection = 0;
        $month_expense = 0;
        $total_students = 0;
        $total_teachers = 0;
        $ar = $this->startmonthandend();
        $year_str_month = $Current_year . '-' . $ar[0] . '-01';
        $year_end_month = $Next_year . '-' . $ar[1] . '-01';
        $getDepositeAmount = $this->studentfeemaster_model->getDepositAmountBetweenDate($year_str_month, $year_end_month);


        //======================Current Month Collection ==============================
        $first_day_this_month = date('Y-m-01');

        $month_collection = $this->whatever($getDepositeAmount, $first_day_this_month, $current_date);


        $expense = $this->expense_model->getTotalExpenseBwdate($first_day_this_month, $current_date);
        if (!empty($expense))
            $month_expense = $month_expense + $expense->amount;

        $data['month_collection'] = $month_collection;
        $data['month_expense'] = $month_expense;

        $tot_students = $this->studentsession_model->getTotalStudentBySession();
        if (!empty($tot_students))
            $total_students = $tot_students->total_student;
        $data['total_students'] = $total_students;

        $tot_teacher = $this->teacher_model->getTotalteacher();
        if (!empty($tot_teacher))
            $total_teachers = $tot_teacher->total_teacher;
        $data['total_teachers'] = $total_teachers;

        //======================== get collection by month ==========================

        $start_month = strtotime($year_str_month);
        $start = strtotime($year_str_month);
        $end = strtotime($year_end_month);
        $coll_month = array();
        $s = array();
        $total_month = array();
        while ($start_month <= $end) {
            $total_month[] = date('M', $start_month);
            $month_start = date('Y-m-d', $start_month);
            $month_end = date("Y-m-t", $start_month);
            $return = $this->whatever($getDepositeAmount, $month_start, $month_end);
            if ($return) {
                $s[] = $return;
            } else {
                $s[] = "0.00";
            }

            $start_month = strtotime("+1 month", $start_month);
        }


        //======================== getexpense by month ==============================
        $ex = array();
        $start_session_month = strtotime($year_str_month);
        while ($start_session_month <= $end) {


            $month_start = date('Y-m-d', $start_session_month);
            $month_end = date("Y-m-t", $start_session_month);

            $expense_monthly = $this->expense_model->getTotalExpenseBwdate($month_start, $month_end);

            if (!empty($expense_monthly)) {
                $amt = 0;
                $ex[] = $amt + $expense_monthly->amount;
            }

            $start_session_month = strtotime("+1 month", $start_session_month);
        }


        $data['yearly_collection'] = $s;
        $data['yearly_expense'] = $ex;
        $data['total_month'] = $total_month;

        //======================= current month collection /expense ===================
        // hardcoded '01' for first day
        $startdate = date('m/01/Y');
        $enddate = date('m/t/Y');
        $start = strtotime($startdate);
        $end = strtotime($enddate);
        $currentdate = $start;
        $month_days = array();
        $days_collection = array();
        while ($currentdate <= $end) {
            $cur_date = date('Y-m-d', $currentdate);
            $month_days[] = date('d', $currentdate);
            $coll_amt = $this->whatever($getDepositeAmount, $cur_date, $cur_date);
            $days_collection[] = $coll_amt;
            $currentdate = strtotime('+1 day', $currentdate);
        }
        $data['current_month_days'] = $month_days;
        $data['days_collection'] = $days_collection;
        //======================= current month /expense ==============================
        // hardcoded '01' for first day
        $startdate = date('m/01/Y');
        $enddate = date('m/t/Y');
        $start = strtotime($startdate);
        $end = strtotime($enddate);
        $currentdate = $start;
        $days_expense = array();
        while ($currentdate <= $end) {
            $cur_date = date('Y-m-d', $currentdate);
            $month_days[] = date('d', $currentdate);
            $currentdate = strtotime('+1 day', $currentdate);
            $ct = $this->getExpensebyday($cur_date);
            $days_expense[] = $ct;
        }


//..............................................................
        // $data = array();
        $accountant_id = $this->session->userdata['student']['accountant_id'];
        $data['title'] = 'Accountant';
        $accountant = $this->accountant_model->get($accountant_id);
        $data['accountant'] = $accountant;
        $data['days_expense'] = $days_expense;
        $student_fee_history = $this->studentfee_model->getTodayStudentFees();
        $data['student_fee_history'] = $student_fee_history;

        $this->load->view('layout/accountant/header', $data);
        $this->load->view('accountant/dashboard', $data);
        $this->load->view('layout/accountant/footer', $data);
    }

    function whatever($feecollection_array, $start_month_date, $end_month_date) {
        $return_amount = 0;
        $st_date = strtotime($start_month_date);
        $ed_date = strtotime($end_month_date);
        if (!empty($feecollection_array)) {
            while ($st_date <= $ed_date) {
                $date = date('Y-m-d', $st_date);
                foreach ($feecollection_array as $key => $value) {

                    if ($value['date'] == $date) {


                        $return_amount = $return_amount + $value['amount'] + $value['amount_fine'];
                    }
                }
                $st_date = $st_date + 86400;
            }
        } else {
            
        }

        return $return_amount;
    }

    function startmonthandend() {
        $startmonth = $this->setting_model->getStartMonth();
        if ($startmonth == 1) {
            $endmonth = 12;
        } else {
            $endmonth = $startmonth - 1;
        }
        return array($startmonth, $endmonth);
    }

    function getCollectionbymonth() {
        $result = $this->admin_model->getMonthlyCollection();
        return $result;
    }

    function getCollectionbyday($date) {
        $result = $this->admin_model->getCollectionbyDay($date);
        if ($result[0]['amount'] == "") {
            $return = 0;
        } else {
            $return = $result[0]['amount'];
        }
        return $return;
    }

    function getExpensebyday($date) {
        $result = $this->admin_model->getExpensebyDay($date);
        if ($result[0]['amount'] == "") {
            $return = 0;
        } else {
            $return = $result[0]['amount'];
        }
        return $return;
    }

    function handle_upload() {
        if (isset($_FILES["file"]) && !empty($_FILES['file']['name'])) {
            $allowedExts = array('jpg', 'jpeg', 'png');
            $temp = explode(".", $_FILES["file"]["name"]);
            $extension = end($temp);
            if ($_FILES["file"]["error"] > 0) {
                $error .= "Error opening the file<br />";
            }
            if ($_FILES["file"]["type"] != 'image/gif' &&
                    $_FILES["file"]["type"] != 'image/jpeg' &&
                    $_FILES["file"]["type"] != 'image/png') {

                $this->form_validation->set_message('handle_upload', 'File type not allowed');
                return false;
            }
            if (!in_array($extension, $allowedExts)) {
                $this->form_validation->set_message('handle_upload', 'Extension not allowed');
                return false;
            }
            if ($_FILES["file"]["size"] > 10240000) {
                $this->form_validation->set_message('handle_upload', 'File size shoud be less than 100 kB');
                return false;
            }
            if ($error == "") {
                return true;
            }
        } else {
            return true;
        }
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
            $this->load->view('layout/accountant/header', $data);
            $this->load->view('accountant/change_password', $data);
            $this->load->view('layout/accountant/footer', $data);
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
                    $this->load->view('layout/accountant/header', $data);
                    $this->load->view('accountant/change_password', $data);
                    $this->load->view('layout/accountant/footer', $data);
                }
            } else {

                $this->session->set_flashdata('error_msg', 'Invalid current password');
                $this->load->view('layout/accountant/header', $data);
                $this->load->view('accountant/change_password', $data);
                $this->load->view('layout/accountant/footer', $data);
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
                        redirect('accountant/accountant/changeusername');
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
        $this->load->view('layout/accountant/header', $data);
        $this->load->view('accountant/change_username', $data);
        $this->load->view('layout/accountant/footer', $data);
    }

}

?>