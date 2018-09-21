<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('file');
        $this->lang->load('message', 'english');
        $this->load->library('customlib');
        $this->load->library('auth');
        $this->auth->is_logged_in_teacher();
    }

    //index function
    function dashboard() {

        //==========================End current Attendence===================
        $data['title'] = 'Dashboard';
        $Current_start_date = date('01');
        $Current_date = date('d');
        $Current_month = date('m');
        $Current_year = date('Y');
        $month_collection = 0;
        $month_expense = 0;
        $total_students = 0;
        $total_teachers = 0;
        //======================Monthly Collection==============================
        for ($i = 1; $i <= $Current_date; $i++) {
            //================collection==========
            $date_new = date($Current_year . "-" . $Current_month . "-" . $i);
            $feecollection = $this->studentfee_model->getTotalCollectionBydate($date_new);
            if (!empty($feecollection))
                $month_collection = $month_collection + ($feecollection->amount + $feecollection->amount_fine) - $feecollection->amount_discount;
            //expense====================
            $date_new_expense = date($Current_year . "-" . $Current_month . "-" . $i);
            $expense = $this->expense_model->getTotalExpenseBydate($date_new_expense);
            if (!empty($expense))
                $month_expense = $month_expense + $expense->amount;
        }


        $data['month_collection'] = $month_collection;
        $data['month_expense'] = $month_expense;

        //======================End Monthly Expense==============================
//total_students========================

        $tot_students = $this->studentsession_model->getTotalStudentBySession();
        if (!empty($tot_students))
            $total_students = $tot_students->total_student;
        $data['total_students'] = $total_students;

//=======================================================================================
//total_teacher========================

        $tot_teacher = $this->teacher_model->getTotalteacher();
        if (!empty($tot_teacher))
            $total_teachers = $tot_teacher->total_teacher;
        $data['total_teachers'] = $total_teachers;


        //========================gecollection by month===================================================

        $montly_collection = $this->getCollectionbymonth();

        $ar = $this->startmonthandend();
        $str_month = '2000-' . $ar[0] . '-01';
        $end_month = '2001-' . $ar[1] . '-01';
        $start = $month = strtotime($str_month);
        $end = strtotime($end_month);
        $coll_month = array();
        $s = array();
        $total_month = array();

        while ($month <= $end) {
            $amt = 0;
            $total_month[] = date('M', $month);
            $m = date('m', $month);

            $key = "month";
            $return = $this->whatever($montly_collection, $key, $m);
            if ($return) {
                $s[] = $return;
            } else {
                $s[] = "0.00";
            }
            $month = strtotime("+1 month", $month);
        }

        //========================getexpense by month===================================================
        $ex = array();
        $montly_expense = $this->getExpensebymonth();
        $start = $month = strtotime($str_month);
        $end = strtotime($end_month);
        while ($month <= $end) {
            $amt = 0;
            $m = date('m', $month);

            $key = "month";
            $return = $this->whatever($montly_expense, $key, $m);
            if ($return) {
                $ex[] = $return;
            } else {
                $ex[] = "0.00";
            }
            $month = strtotime("+1 month", $month);
        }

        $data['yearly_collection'] = $s;
        $data['yearly_expense'] = $ex;
        $data['total_month'] = $total_month;


//=======================current month collection /expense================================================


        $startdate = date('m/01/Y'); // hard/coded '01' for first day
        $enddate = date('m/t/Y');


        $start = strtotime($startdate);
        $end = strtotime($enddate);

        $currentdate = $start;
        $month_days = array();
        $days_collection = array();
        while ($currentdate <= $end) {
            $cur_date = date('Y-m-d', $currentdate);
            $month_days[] = date('d', $currentdate);
            $currentdate = strtotime('+1 day', $currentdate);
            $ct = $this->getCollectionbyDay($cur_date);
            $days_collection[] = $ct;
        }
        $data['current_month_days'] = $month_days;
        $data['days_collection'] = $days_collection;




//====================================================================================
//=======================current month /expense================================================


        $startdate = date('m/01/Y'); // hard/coded '01' for first day
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




//====================================================================================

        $student_fee_history = $this->studentfee_model->getTodayStudentFees();

        $data['student_fee_history'] = $student_fee_history;


        $this->load->view('layout/teacher/header', $data);
        $this->load->view('teacher/admin/dashboard', $data);
        $this->load->view('layout/teacher/footer', $data);
    }

    function backup() {
        $this->session->set_userdata('top_menu', 'System Settings');
        $this->session->set_userdata('sub_menu', 'admin/backup');


        //fetch data from department and designation tables
        $data['title'] = 'Backup History';



        if ($this->input->server('REQUEST_METHOD') == "POST") {
            if ($this->input->post('backup') == "upload") {

                //===================================


                $this->form_validation->set_rules('file', 'Image', 'callback_handle_upload');

                if ($this->form_validation->run() == FALSE) {
                    
                } else {

                    if (isset($_FILES["file"]) && !empty($_FILES['file']['name'])) {
                        //================

                        $fileInfo = pathinfo($_FILES["file"]["name"]);
                        $file_name = "db-" . date("Y-m-d_H-i-s") . ".sql";
                        move_uploaded_file($_FILES["file"]["tmp_name"], "./backup/temp_uploaded/" . $file_name);

//==================
                        $folder_name = 'temp_uploaded';


                        $path = './backup/'; // Codeigniter application /assets
                        $file_restore = $this->load->file($path . $folder_name . '/' . $file_name, true);
                        $file_array = explode(';', $file_restore);
                        foreach ($file_array as $query) {
                            //  if (!empty(trim($query))){

                            $trimQuery1 = trim($query);
                            if (!empty($trimQuery1)) {
                                $this->db->query("SET FOREIGN_KEY_CHECKS = 0");
                                $this->db->query($query);
                                $this->db->query("SET FOREIGN_KEY_CHECKS = 1");
                            }
                        }
//=====================

                        $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">Backup restored successfully!</div>');
                        redirect('teacher/admin/admin/backup');
                        //======================  
                    }
                }

                //===================================
            }

            if ($this->input->post('backup') == "backup") {
                $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">Backup created successfully!</div>');
                $this->load->helper('download');
                $this->load->dbutil();
                $filename = "db-" . date("Y-m-d_H-i-s") . ".sql";
// Backup your entire database and assign it to a variable
                $prefs = array(
                    // 'tables'      => array('table1', 'table2'),  // Array of tables to backup.
                    'ignore' => array(), // List of tables to omit from the backup
                    'format' => 'txt', // gzip, zip, txt
                    'filename' => 'mybackup.sql', // File name - NEEDED ONLY WITH ZIP FILES
                    'add_drop' => TRUE, // Whether to add DROP TABLE statements to backup file
                    'add_insert' => TRUE, // Whether to add INSERT data to backup file
                    'newline' => "\n"               // Newline character used in backup file
                );
                $backup = & $this->dbutil->backup($prefs);

// Load the file helper and write the file to your server
                $this->load->helper('file');
// write_file('/path/to/mybackup.gz', $backup); 
                write_file('./backup/database_backup/' . $filename, $backup);
                redirect('teacher/admin/admin/backup');
// Load the download helper and send the file to your desktop
                force_download($filename, $backup);
                $this->session->set_flashdata('feedback', 'Success message for client to see');
                redirect('admin/admin/backup');
            } else if ($this->input->post('backup') == "restore") {

                $folder_name = 'database_backup';

                $file_name = $this->input->post('filename');
                $path = './backup/'; // Codeigniter application /assets
                $file_restore = $this->load->file($path . $folder_name . '/' . $file_name, true);
                $file_array = explode(';', $file_restore);
                foreach ($file_array as $query) {
                    //  if (!empty(trim($query))){

                    $trimQuery1 = trim($query);
                    if (!empty($trimQuery1)) {
                        $this->db->query("SET FOREIGN_KEY_CHECKS = 0");
                        $this->db->query($query);
                        $this->db->query("SET FOREIGN_KEY_CHECKS = 1");
                    }
                }
                $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">Backup restored successfully!</div>');
                redirect('teacher/admin/admin/backup');
            }
        }

        //=================
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

        //==================


        $this->load->view('layout/teacher/header', $data);
        $this->load->view('teacher/admin/backup', $data);
        $this->load->view('layout/teacher/footer', $data);
    }

    function changepass() {
        $this->session->set_userdata('top_menu', 'System Settings');
        $this->session->set_userdata('sub_menu', 'admin/changepass');


        //fetch data from department and designation tables
        $data['title'] = 'Change Password';

        $this->form_validation->set_rules('current_pass', 'Current password', 'trim|required|xss_clean');
        $this->form_validation->set_rules('new_pass', 'New password', 'trim|required|xss_clean|matches[confirm_pass]');
        $this->form_validation->set_rules('confirm_pass', 'Confirm password', 'trim|required|xss_clean');

        if ($this->form_validation->run() == FALSE) {

            $sessionData = $this->session->userdata('loggedIn');
            $this->data['id'] = $sessionData['id'];
            $this->data['username'] = $sessionData['username'];

            //fail validation
            $this->load->view('layout/teacher/header', $data);
            $this->load->view('teacher/admin/change_password', $data);
            $this->load->view('layout/teacher/footer', $data);
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
                    //display success message
                    $data ['error_message'] = "<div class='alert alert-success'>Password changed successfully</div>";
                    $this->load->view('layout/teacher/header', $data);
                    $this->load->view('teacher/admin/change_password', $data);
                    $this->load->view('layout/teacher/footer', $data);
                }
            } else {

                $data ['error_message'] = "<div class='alert alert-danger'>Invalid current password</div>";
                $this->load->view('layout/teacher/header', $data);
                $this->load->view('teacher/admin/change_password', $data);
                $this->load->view('layout/teacher/footer', $data);
            }
        }
    }

    public function pdf_report() {
        $data = array();
        //load the view and saved it into $html variable
        $html = $this->load->view('teacher/reports/students_detail', $data, true);

        //this the the PDF filename that user will get to download
        $pdfFilePath = "output_pdf_name.pdf";

        //load mPDF library
        $this->load->library('m_pdf');

        //generate the PDF from the given html
        $this->m_pdf->pdf->WriteHTML($html);

        //download it.
        $this->m_pdf->pdf->Output($pdfFilePath, "D");
    }

    public function downloadbackup($file) {
        $this->load->helper('download');
        $filepath = "./backup/database_backup/" . $file;
        $data = file_get_contents($filepath); // Read the file's contents
        $name = $file;

        force_download($name, $data);
    }

    public function dropbackup($file) {
        unlink('./backup/database_backup/' . $file);
        redirect('teacher/admin/admin/backup');
    }

    // ========================//


    function search() {
        //fetch data from department and designation tables
        $data['title'] = 'Search';


        $search_text = $this->input->post('search_text');

        $data['search_text'] = trim($this->input->post('search_text'));
        $resultlist = $this->student_model->searchFullText($search_text);
        $data['resultlist'] = $resultlist;
        $this->load->view('layout/teacher/header', $data);
        $this->load->view('teacher/search', $data);
        $this->load->view('layout/teacher/footer', $data);


        //$data['student'] = $student;
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
        // print_r($result);
        return $result;
    }

    function whatever($array, $key, $val) {
        foreach ($array as $item)
            if (isset($item[$key]) && $item[$key] == $val)
                return $item['amount'];
        return false;
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