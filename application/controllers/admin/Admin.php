<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class admin extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('file');
        $this->lang->load('message', 'english');
        $this->load->library('customlib');
    }

    //index function
    function dashboard() {
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

        $data['days_expense'] = $days_expense;
        $student_fee_history = $this->studentfee_model->getTodayStudentFees();
        $data['student_fee_history'] = $student_fee_history;
        $this->load->view('layout/header', $data);
        $this->load->view('admin/dashboard', $data);
        $this->load->view('layout/footer', $data);
    }	

    function getSession() {
        $session = $this->session_model->getAllSession();
        $data = array();
        $session_array = $this->session->has_userdata('session_array');
        $data['sessionData'] = array('session_id' => 0);
        if ($session_array) {
            $data['sessionData'] = $this->session->userdata('session_array');
        } else {
            $setting = $this->setting_model->get();
          
            $data['sessionData'] = array('session_id' => $setting[0]['session_id']);
        }
        $data['sessionList'] = $session;
        $this->load->view('admin/partial/_session', $data);
    }

    function updateSession() {
        $session = $this->input->post('popup_session');
        $session_array = $this->session->has_userdata('session_array');
        if ($session_array) {
            $this->session->unset_userdata('session_array');
        }
        $session = $this->session_model->get($session);
        $session_array = array('session_id' => $session['id'], 'session' => $session['session']);
        $this->session->set_userdata('session_array', $session_array);

        echo json_encode(array('status' => 1, 'message' => 'Session changed successfully'));
    }

    function backup() {
        $this->session->set_userdata('top_menu', 'System Settings');
        $this->session->set_userdata('sub_menu', 'admin/backup');
        $data['title'] = 'Backup History';
        if ($this->input->server('REQUEST_METHOD') == "POST") {
            if ($this->input->post('backup') == "upload") {
                $this->form_validation->set_rules('file', 'Image', 'callback_handle_upload');
                if ($this->form_validation->run() == FALSE) {
                    
                } else {
                    if (isset($_FILES["file"]) && !empty($_FILES['file']['name'])) {
                        $fileInfo = pathinfo($_FILES["file"]["name"]);
                        $file_name = "db-" . date("Y-m-d_H-i-s") . ".sql";
                        move_uploaded_file($_FILES["file"]["tmp_name"], "./backup/temp_uploaded/" . $file_name);
                        $folder_name = 'temp_uploaded';
                        $path = './backup/';
                        $file_restore = $this->load->file($path . $folder_name . '/' . $file_name, true);
                        $file_array = explode(';', $file_restore);
                        foreach ($file_array as $query) {
                            $trimQuery1 = trim($query);
                            if (!empty($trimQuery1)) {
                                $this->db->query("SET FOREIGN_KEY_CHECKS = 0");
                                $this->db->query($query);
                                $this->db->query("SET FOREIGN_KEY_CHECKS = 1");
                            }
                        }
                        $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">Backup restored successfully!</div>');
                        redirect('admin/admin/backup');
                    }
                }
            }
            if ($this->input->post('backup') == "backup") {
                $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">Backup created successfully!</div>');
                $this->load->helper('download');
                $this->load->dbutil();
                $filename = "db-" . date("Y-m-d_H-i-s") . ".sql";
                $prefs = array(
                    'ignore' => array(),
                    'format' => 'txt',
                    'filename' => 'mybackup.sql',
                    'add_drop' => TRUE,
                    'add_insert' => TRUE,
                    'newline' => "\n"
                );
                $backup = $this->dbutil->backup($prefs);
                $this->load->helper('file');
                write_file('./backup/database_backup/' . $filename, $backup);
                redirect('admin/admin/backup');
                force_download($filename, $backup);
                $this->session->set_flashdata('feedback', 'Success message for client to see');
                redirect('admin/admin/backup');
            } else if ($this->input->post('backup') == "restore") {
                $folder_name = 'database_backup';
                $file_name = $this->input->post('filename');
                $path = './backup/';
                $file_restore = $this->load->file($path . $folder_name . '/' . $file_name, true);
                $file_array = explode(';', $file_restore);
                foreach ($file_array as $query) {
                    $trimQuery1 = trim($query);
                    if (!empty($trimQuery1)) {
                        $this->db->query("SET FOREIGN_KEY_CHECKS = 0");
                        $this->db->query($query);
                        $this->db->query("SET FOREIGN_KEY_CHECKS = 1");
                    }
                }
                $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">Backup restored successfully!</div>');
                redirect('admin/admin/backup');
            }
        }
        $dir = "./backup/database_backup/";
        $result = array();
        $cdir = scandir($dir);
        foreach ($cdir as $key => $value) {
            if (!in_array($value, array(".", ".."))) {
                if (is_dir($dir . DIRECTORY_SEPARATOR . $value)) {
                    $result[$value] = dirToArray($dir . DIRECTORY_SEPARATOR . $value);
                } else {
                    $result[] = $value;
                }
            }
        }
        $data['dbfileList'] = $result;
        $this->load->view('layout/header', $data);
        $this->load->view('admin/backup', $data);
        $this->load->view('layout/footer', $data);
    }

    function changepass() {
        $this->session->set_userdata('top_menu', 'System Settings');
        $this->session->set_userdata('sub_menu', 'changepass/index');
        $data['title'] = 'Change Password';
        $this->form_validation->set_rules('current_pass', 'Current password', 'trim|required|xss_clean');
        $this->form_validation->set_rules('new_pass', 'New password', 'trim|required|xss_clean|matches[confirm_pass]');
        $this->form_validation->set_rules('confirm_pass', 'Confirm password', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $sessionData = $this->session->userdata('loggedIn');
            $this->data['id'] = $sessionData['id'];
            $this->data['username'] = $sessionData['username'];
            $this->load->view('layout/header', $data);
            $this->load->view('admin/change_password', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $sessionData = $this->session->userdata('admin');
            $data_array = array(
                'current_pass' => md5($this->input->post('current_pass')),
                'new_pass' => md5($this->input->post('new_pass')),
                'user_id' => $sessionData['id'],
                'user_email' => $sessionData['email'],
                'user_name' => $sessionData['username']
            );
            $newdata = array(
                'id' => $sessionData['id'],
                'password' => md5($this->input->post('new_pass'))
            );
            $query1 = $this->admin_model->checkOldPass($data_array);
            if ($query1) {
                $query2 = $this->admin_model->saveNewPass($newdata);
                if ($query2) {
                    $data ['error_message'] = "<div class='alert alert-success'>Password changed successfully</div>";
                    $this->load->view('layout/header', $data);
                    $this->load->view('admin/change_password', $data);
                    $this->load->view('layout/footer', $data);
                }
            } else {
                $data ['error_message'] = "<div class='alert alert-danger'>Invalid current password</div>";
                $this->load->view('layout/header', $data);
                $this->load->view('admin/change_password', $data);
                $this->load->view('layout/footer', $data);
            }
        }
    }

    public function pdf_report() {
        $data = array();
        $html = $this->load->view('reports/students_detail', $data, true);
        $pdfFilePath = "output_pdf_name.pdf";
        $this->load->library('m_pdf');
        $this->m_pdf->pdf->WriteHTML($html);
        $this->m_pdf->pdf->Output($pdfFilePath, "D");
    }

    public function downloadbackup($file) {
        $this->load->helper('download');
        $filepath = "./backup/database_backup/" . $file;
        $data = file_get_contents($filepath);
        $name = $file;
        force_download($name, $data);
    }

    public function dropbackup($file) {
        unlink('./backup/database_backup/' . $file);
        redirect('admin/admin/backup');
    }

    function search() {
        $data['title'] = 'Search';
        $search_text = $this->input->post('search_text');
        $data['search_text'] = trim($this->input->post('search_text'));
        $resultlist = $this->student_model->searchFullText($search_text);
        $data['resultlist'] = $resultlist;
        $this->load->view('layout/header', $data);
        $this->load->view('admin/search', $data);
        $this->load->view('layout/footer', $data);
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

    function getExpensebymonth() {
        $result = $this->admin_model->getMonthlyExpense();
        return $result;
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

    function handle_upload() {
        if (isset($_FILES["file"]) && !empty($_FILES['file']['name'])) {
            $allowedExts = array('sql');
            $temp = explode(".", $_FILES["file"]["name"]);
            $extension = end($temp);
            if ($_FILES["file"]["error"] > 0) {
                $error .= "Error opening the file<br />";
            }
            if ($_FILES["file"]["type"] != 'application/octet-stream') {

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
            return true;
        } else {
            $this->form_validation->set_message('handle_upload', 'File field is required');
            return false;
        }
    }

}

?>