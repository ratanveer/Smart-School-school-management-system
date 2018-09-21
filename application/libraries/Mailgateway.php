<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mailgateway {

    private $_CI;
   

    function __construct() {
        $this->_CI = & get_instance();
        $this->_CI->load->model('setting_model');       
        $this->_CI->load->model('studentfeemaster_model');
        $this->_CI->load->model('student_model');
        $this->_CI->load->model('teacher_model');
        $this->_CI->load->model('librarian_model');
        $this->_CI->load->model('accountant_model');
        $this->_CI->load->library('mailer');
        $this->_CI->mailer;
        $this->sch_setting=$this->_CI->setting_model->get();
    }

    function sentRegisterMail($id, $send_to) {

     
        if(!empty($this->_CI->mail_config) && $send_to != ""){
         $subject="Admission Confirm";
         $msg = $this->getStudentRegistrationContent($id);
         $this->_CI->mailer->send_mail($send_to,$subject,$msg);
           
        }
       
    }

      function sendLoginCredential($chk_mail_sms, $sender_details) { 
        $msg = $this->getLoginCredentialContent($sender_details['credential_for'],$sender_details);
        $send_to = $sender_details['email'];
         if(!empty($this->_CI->mail_config) && $send_to != ""){
         $subject="Login Credential";
         $this->_CI->mailer->send_mail($send_to,$subject,$msg);
        }
      }

  function sentAddFeeMail($invoice_id, $sub_invoice_id, $send_to) {
       
        $msg = $this->getAddFeeContent($invoice_id, $sub_invoice_id);
         if(!empty($this->_CI->mail_config) && $send_to != ""){
         $subject="Fees Received";
         $this->_CI->mailer->send_mail($send_to,$subject,$msg);
        }
    }
       function sentExamResultMail($detail) {
        
        $msg = $this->getStudentResultContent($detail);
        $send_to = $detail['email'];
         if(!empty($this->_CI->mail_config) && $send_to != ""){
         $subject="Exam Result";
         $this->_CI->mailer->send_mail($send_to,$subject,$msg);
        }

    }

  function sentAbsentStudentMail($detail) { 
   
         $send_to = $detail['email'];
         $msg = $this->getAbsentStudentContent($detail);
         if(!empty($this->_CI->mail_config) && $send_to != ""){
         $subject="Absent Notice";
         $this->_CI->mailer->send_mail($send_to,$subject,$msg);
        }              
            }

 public function getAddFeeContent($invoice_id, $sub_invoice_id) {
        $currency_symbol=$this->sch_setting[0]['currency_symbol'];
        $school_name=$this->sch_setting[0]['name'];

        $fee = $this->_CI->studentfeemaster_model->getFeeByInvoice($invoice_id, $sub_invoice_id);
        $a = json_decode($fee->amount_detail);
        $record = $a->{$sub_invoice_id};
        $fee_amount = number_format((($record->amount + $record->amount_fine) - $record->amount_discount), 2, '.', ',');
          $msg="Fees received for " . $fee->firstname . " " . $fee->lastname . ". Fees Amount " .$currency_symbol . $fee_amount . "/- Received by ".$school_name;
          
     return $msg;
    }


   public function getAbsentStudentContent($student_detail) {
        $school_name = $this->_CI->setting_model->getCurrentSchoolName();
        $student_name = $student_detail['student_name'];
        $msg ="Absent Notice :".$student_name . " was absent on date " . $student_detail['date'] . " from " . $school_name;
        return $msg;
    }

 
 public function getStudentRegistrationContent($id) {
        $session_name = $this->_CI->setting_model->getCurrentSessionName();
        $student = $this->_CI->student_model->get($id);
        $msg = "Dear " . $student['firstname'] . " " . $student['lastname'] .
                ", your admission is confirm in Class: " . $student['class'] .
                ", Section: " . $student['section'] . " for Session: " . $session_name . ", for more detail contact System Admin.";
        return $msg;
    }

  public function getLoginCredentialContent($credential_for,$sender_details) {
     if ($credential_for == "student") {
          $student = $this->_CI->student_model->get($sender_details['id']);
              $msg = "Hello " . $student['firstname'] . " " . $student['lastname'] .
                ", your login details for Url: ".site_url('site/userlogin')." Username: " .$sender_details['username']. "\n Password: ".$sender_details['password'];
     }elseif ($credential_for == "parent") {
              $parent = $this->_CI->student_model->get($sender_details['id']);
              $msg = "Hello " . $parent['guardian_name'] . ", your login details for Url: ".site_url('site/userlogin')." Username: " .$sender_details['username']. "\n Password: ".$sender_details['password'];
     }elseif ($credential_for == "teacher") {
              $teacher = $this->_CI->teacher_model->get($sender_details['id']);
              $msg = "Hello " . $teacher['name'] . ", your login details for Url: ".site_url('site/userlogin')." Username: " .$sender_details['username']. "\n Password: ".$sender_details['password'];
     }elseif ($credential_for == "librarian") {
              $librarian = $this->_CI->librarian_model->get($sender_details['id']);
              $msg = "Hello " . $librarian['name'] . ", your login details for Url: ".site_url('site/userlogin')." Username: " .$sender_details['username']. "\n Password: ".$sender_details['password'];
     }elseif ($credential_for == "accountant") {
              $accountant = $this->_CI->accountant_model->get($sender_details['id']);
              $msg = "Hello " . $accountant['name'] . ", your login details for Url: ".site_url('site/userlogin')." Username: " .$sender_details['username']. "\n Password: ".$sender_details['password'];
     }
        return $msg;

    }

    public function getStudentResultContent($student_result_detail) {
    
        $school_name = $this->_CI->setting_model->getCurrentSchoolName();
        $student_name= $student_result_detail['student_name'];
 
        $msg=$student_name." is ".$student_result_detail['result'] . " in ".$student_result_detail['exam_name']." with total marks ".$student_result_detail['achive_marks']." out of ".$student_result_detail['total_marks'].".";
        return $msg;
    }

}

?>