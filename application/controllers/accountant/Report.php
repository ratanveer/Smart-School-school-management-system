<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Report extends CI_Controller {

    function __construct() {

        parent::__construct();
        $this->load->helper('file');
        $this->time = strtotime(date('d-m-Y H:i:s'));
        $this->lang->load('message', 'english');
        $this->load->library('auth');
        $this->auth->is_logged_in_accountant();
    }

    function pdfStudentFeeRecord() {
        $data = [];
        $class_id = $this->uri->segment(3);
        $section_id = $this->uri->segment(4);
        $student_id = $this->uri->segment(5);
        $student = $this->student_model->get($student_id);
        $setting_result = $this->setting_model->get();
        $data['settinglist'] = $setting_result;
        $data['student'] = $student;
        $student_due_fee = $this->studentfee_model->getDueFeeBystudent($class_id, $section_id, $student_id);
        $data['student_due_fee'] = $student_due_fee;
        $html = $this->load->view('accountant/reports/students_detail', $data, true);
        $pdfFilePath = $this->time . ".pdf";
        $this->fontdata = array(
            "opensans" => array(
                'R' => "OpenSans-Regular.ttf",
                'B' => "OpenSans-Bold.ttf",
                'I' => "OpenSans-Italic.ttf",
                'BI' => "OpenSans-BoldItalic.ttf",
            ),
        );
        $this->load->library('m_pdf');
        $this->m_pdf->pdf->WriteHTML($html);
        $this->m_pdf->pdf->Output($pdfFilePath, "D");
    }

    function transactionSearch() {
        $data = [];
        $date_from = $this->input->get('datefrom');
        $date_to = $this->input->get('dateto');
        $setting_result = $this->setting_model->get();
        $data['exp_title'] = 'Transaction From ' . $date_from . " To " . $date_to;
        $date_from = date('Y-m-d', $this->customlib->datetostrtotime($date_from));
        $date_to = date('Y-m-d', $this->customlib->datetostrtotime($date_to));
        $expenseList = $this->expense_model->search("", $date_from, $date_to);
        $feeList = $this->studentfee_model->getFeeBetweenDate($date_from, $date_to);
        $data['expenseList'] = $expenseList;
        $data['feeList'] = $feeList;
        $data['settinglist'] = $setting_result;
        $html = $this->load->view('accountant/reports/transactionSearch', $data, true);
        $pdfFilePath = $this->time . ".pdf";
        $this->load->library('m_pdf');
        $this->m_pdf->pdf->WriteHTML($html);
        $this->m_pdf->pdf->Output($pdfFilePath, "D");
    }

}

?>