<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Report extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('file');
        $this->time = strtotime(date('d-m-Y H:i:s'));
        $this->lang->load('message', 'english');
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
        $html = $this->load->view('reports/students_detail', $data, true);
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

    function pdfByInvoiceNo() {
        $data = [];
        $invoice_id = $this->uri->segment(3);
        $setting_result = $this->setting_model->get();
        $data['settinglist'] = $setting_result;
        $student_due_fee = $this->studentfee_model->getFeeByInvoice($invoice_id);
        $data['student_due_fee'] = $student_due_fee;
        $html = $this->load->view('reports/pdfinvoiceno', $data, true);
        $pdfFilePath = $this->time . ".pdf";
        $this->load->library('m_pdf');
        $this->m_pdf->pdf->WriteHTML($html);
        $this->m_pdf->pdf->Output($pdfFilePath, "D");
    }

    function pdfDepositeFeeByStudent($id) {
        $data = [];
        $data['title'] = 'Student Detail';
        $student = $this->student_model->get($id);
        $setting_result = $this->setting_model->get();
        $data['settinglist'] = $setting_result;
        $student_fee_history = $this->studentfee_model->getStudentFees($id);
        $data['student_fee_history'] = $student_fee_history;
        $data['student'] = $student;
        $array = array();
        $feecategory = $this->feecategory_model->get();
        foreach ($feecategory as $key => $value) {
            $dataarray = array();
            $value_id = $value['id'];
            $dataarray[$value_id] = $value['category'];
            $category = $value['category'];
            $datatype = array();
            $data_fee_type = array();
            $feetype = $this->feetype_model->getFeetypeByCategory($value['id']);
            foreach ($feetype as $feekey => $feevalue) {
                $ftype = $feevalue['id'];
                $datatype[$ftype] = $feevalue['type'];
            }
            $data_fee_type[] = $datatype;
            $dataarray[$category] = $datatype;
            $array[] = $dataarray;
        }
        $data['category_array'] = $array;
        $data['feecategory'] = $feecategory;
        $html = $this->load->view('reports/pdfStudentDeposite', $data, true);
        $pdfFilePath = $this->time . ".pdf";
        $this->load->library('m_pdf');
        $this->m_pdf->pdf->WriteHTML($html);
        $this->m_pdf->pdf->Output($pdfFilePath, "D");
    }

    function pdfStudentListByText() {
        $data = [];
        $search_text = $this->uri->segment(3);
        $setting_result = $this->setting_model->get();
        $data['settinglist'] = $setting_result;
        $resultlist = $this->student_model->searchFullText($search_text);
        $data['resultlist'] = $resultlist;
        $html = $this->load->view('reports/pdfStudentListByText', $data, true);
        $pdfFilePath = $this->time . ".pdf";
        $this->load->library('m_pdf');
        $this->m_pdf->pdf->WriteHTML($html);
        $this->m_pdf->pdf->Output($pdfFilePath, "D");
    }

    function marksreport() {
        $setting_result = $this->setting_model->get();
        $data['settinglist'] = $setting_result;
        $exam_id = $this->uri->segment(3);
        $class_id = $this->uri->segment(4);
        $section_id = $this->uri->segment(5);
        $data['exam_id'] = $exam_id;
        $data['class_id'] = $class_id;
        $data['section_id'] = $section_id;
        $exam_arrylist = $this->exam_model->get($exam_id);
        $data['exam_arrylist'] = $exam_arrylist;
        $section = $this->section_model->getClassNameBySection($class_id, $section_id);
        $data['class'] = $section;
        $examSchedule = $this->examschedule_model->getDetailbyClsandSection($class_id, $section_id, $exam_id);
        $studentList = $this->student_model->searchByClassSection($class_id, $section_id);
        $data['examSchedule'] = array();
        if (!empty($examSchedule)) {
            $new_array = array();
            $data['examSchedule']['status'] = "yes";
            foreach ($studentList as $stu_key => $stu_value) {
                $array = array();
                $array['student_id'] = $stu_value['id'];
                $array['roll_no'] = $stu_value['roll_no'];
                $array['firstname'] = $stu_value['firstname'];
                $array['lastname'] = $stu_value['lastname'];
                $array['admission_no'] = $stu_value['admission_no'];
                $array['dob'] = $stu_value['dob'];
                $array['father_name'] = $stu_value['father_name'];
                $x = array();
                foreach ($examSchedule as $ex_key => $ex_value) {
                    $exam_array = array();
                    $exam_array['exam_schedule_id'] = $ex_value['id'];
                    $exam_array['exam_id'] = $ex_value['exam_id'];
                    $exam_array['full_marks'] = $ex_value['full_marks'];
                    $exam_array['passing_marks'] = $ex_value['passing_marks'];
                    $exam_array['exam_name'] = $ex_value['name'];
                    $exam_array['exam_type'] = $ex_value['type'];
                    $student_exam_result = $this->examresult_model->get_result($ex_value['id'], $stu_value['id']);
                    if (empty($student_exam_result)) {
                        $data['examSchedule']['status'] = "no";
                    } else {
                        $exam_array['attendence'] = $student_exam_result->attendence;
                        $exam_array['get_marks'] = $student_exam_result->get_marks;
                    }
                    $x[] = $exam_array;
                }
                $array['exam_array'] = $x;
                $new_array[] = $array;
            }
            $data['examSchedule']['result'] = $new_array;
        } else {
            $s = array('status' => 'no');
            $data['examSchedule'] = $s;
        }
        $html = $this->load->view('reports/marksreport', $data, true);
        $pdfFilePath = $this->time . ".pdf";
        $this->load->library('m_pdf');
        $this->m_pdf->pdf->WriteHTML($html);
        $this->m_pdf->pdf->Output($pdfFilePath, "D");
        $this->load->view('reports/marksreport', $data);
    }

    function pdfStudentListByClassSection() {
        $data = [];
        $class_id = $this->uri->segment(3);
        $section_id = $this->uri->segment(4);
        $setting_result = $this->setting_model->get();
        $section = $this->section_model->getClassNameBySection($class_id, $section_id);
        $data['class'] = $section;
        $data['settinglist'] = $setting_result;
        $resultlist = $this->student_model->searchByClassSection($class_id, $section_id);
        $data['resultlist'] = $resultlist;
        $html = $this->load->view('reports/pdfStudentListByClassSection', $data, true);
        $pdfFilePath = $this->time . ".pdf";
        $this->load->library('m_pdf');
        $this->m_pdf->pdf->WriteHTML($html);
        $this->m_pdf->pdf->Output($pdfFilePath, "D");
    }

    function pdfStudentListDifferentCriteria() {
        $data = [];
        $class_id = $this->input->get('class_id');
        $section_id = $this->input->get('section_id');
        $category_id = $this->input->get('category_id');
        $gender = $this->input->get('gender');
        $rte = $this->input->get('rte');
        $setting_result = $this->setting_model->get();
        $class = $this->class_model->get($class_id);
        $data['class'] = $class;
        if ($section_id != "") {
            $section = $this->section_model->getClassNameBySection($class_id, $section_id);
            $data['section'] = $section;
        }
        if ($gender != "") {
            $data['gender'] = $gender;
        }
        if ($rte != "") {
            $data['rte'] = $rte;
        }
        if ($category_id != "") {
            $category = $this->category_model->get($category_id);
            $data['category'] = $category;
        }
        $data['settinglist'] = $setting_result;
        $resultlist = $this->student_model->searchByClassSectionCategoryGenderRte($class_id, $section_id, $category_id, $gender, $rte);
        $data['resultlist'] = $resultlist;
        $html = $this->load->view('reports/pdfStudentListDifferentCriteria', $data, true);
        $pdfFilePath = $this->time . ".pdf";
        $this->load->library('m_pdf');
        $this->m_pdf->pdf->WriteHTML($html);
        $this->m_pdf->pdf->Output($pdfFilePath, "D");
    }

    function pdfStudentListByClass() {
        $data = [];
        $class_id = $this->uri->segment(3);
        $section_id = "";
        $setting_result = $this->setting_model->get();
        $section = $this->class_model->get($class_id);
        $data['class'] = $section;
        $data['settinglist'] = $setting_result;
        $resultlist = $this->student_model->searchByClassSection($class_id, $section_id);
        $data['resultlist'] = $resultlist;
        $html = $this->load->view('reports/pdfStudentListByClass', $data, true);
        $pdfFilePath = $this->time . ".pdf";
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
        $html = $this->load->view('reports/transactionSearch', $data, true);
        $pdfFilePath = $this->time . ".pdf";
        $this->load->library('m_pdf');
        $this->m_pdf->pdf->WriteHTML($html);
        $this->m_pdf->pdf->Output($pdfFilePath, "D");
    }

    function pdfExamschdule() {
        $data = [];
        $setting_result = $this->setting_model->get();
        $data['settinglist'] = $setting_result;
        $exam_id = $this->uri->segment(3);
        $section_id = $this->uri->segment(4);
        $class_id = $this->uri->segment(5);
        $class = $this->class_model->get($class_id);
        $data['class'] = $class;
        $examSchedule = $this->examschedule_model->getDetailbyClsandSection($class_id, $section_id, $exam_id);
        $section = $this->section_model->getClassNameBySection($class_id, $section_id);
        $data['section'] = $section;
        $data['examSchedule'] = $examSchedule;
        $exam = $this->exam_model->get($exam_id);
        $data['exam'] = $exam;
        $html = $this->load->view('reports/examSchedule', $data, true);
        $pdfFilePath = $this->time . ".pdf";
        $this->load->library('m_pdf');
        $this->m_pdf->pdf->WriteHTML($html);
        $this->m_pdf->pdf->Output($pdfFilePath, "D");
    }

}

?>