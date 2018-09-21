<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Auth {

    var $CI;

    //this is the expiration for a non-remember session
    //var $session_expire	= 600;
 
    function __construct() {
        $this->CI = & get_instance();
        $this->set_timezone();
        $this->CI->load->database();
        $this->CI->load->library('encrypt');
          
    }

    /*
      this checks to see if the admin is logged in
      we can provide a link to redirect to, and for the login page, we have $default_redirect,
      this way we can check if they are already logged in, but we won't get stuck in an infinite loop if it returns false.
     */

      function is_logged_in($redirect = false, $default_redirect = true) {

        //var_dump($this->CI->session->userdata('session_id'));
        //$redirect allows us to choose where a customer will get redirected to after they login
        //$default_redirect points is to the login page, if you do not want this, you can set it to false and then redirect wherever you wish.

        $admin = $this->CI->session->userdata('admin');

        if (!$admin) {
            if ($default_redirect) {
                redirect('site/login');
            }

            return false;
        } else {

            return true;
        }
    }

    /*
      this function does the logging in.
     */


    /*
      this function does the logging out
     */

      function logout() {
        $this->CI->session->unset_userdata('admin');
        $this->CI->session->sess_destroy();
    }

    function set_timezone() {

        if ($this->CI->customlib->getTimeZone()) {
            date_default_timezone_set($this->CI->customlib->getTimeZone());
        }
        else {
            return date_default_timezone_set('UTC');
        }
    }

    /*
      This function resets the admins password and emails them a copy
     */

      function reset_password($email) {
        $admin = $this->get_admin_by_email($email);
        if ($admin) {
            $this->CI->load->helper('string');
            $this->CI->load->library('email');

            $new_password = random_string('alnum', 8);
            $admin['password'] = sha1($new_password);
            $this->save_admin($admin);

            $this->CI->email->from($this->CI->config->item('email'), $this->CI->config->item('site_name'));
            $this->CI->email->to($email);
            $this->CI->email->subject($this->CI->config->item('site_name') . ': Admin Password Reset');
            $this->CI->email->message('Your password has been reset to ' . $new_password . '.');
            $this->CI->email->send();
            return true;
        } else {
            return false;
        }
    }

    /*
      This function gets the admin by their email address and returns the values in an array
      it is not intended to be called outside this class
     */

      private function get_admin_by_email($email) {
        $this->CI->db->select('*');
        $this->CI->db->where('email', $email);
        $this->CI->db->limit(1);
        $result = $this->CI->db->get('admin');
        $result = $result->row_array();

        if (sizeof($result) > 0) {
            return $result;
        } else {
            return false;
        }
    }

    /*
      This function takes admin array and inserts/updates it to the database
     */

      function save($admin) {
        if ($admin['id']) {
            $this->CI->db->where('id', $admin['id']);
            $this->CI->db->update('admin', $admin);
        } else {
            $this->CI->db->insert('admin', $admin);
        }
    }

    /*
      This function gets a complete list of all admin
     */

      function get_admin_list() {
        $this->CI->db->select('*');
        $this->CI->db->order_by('lastname', 'ASC');
        $this->CI->db->order_by('firstname', 'ASC');
        $this->CI->db->order_by('email', 'ASC');
        $result = $this->CI->db->get('admin');
        $result = $result->result();

        return $result;
    }

    /*
      This function gets an individual admin
     */

      function get_admin($id) {
        $this->CI->db->select('*');
        $this->CI->db->where('id', $id);
        $result = $this->CI->db->get('admin');
        $result = $result->row();

        return $result;
    }

    function check_id($str) {
        $this->CI->db->select('id');
        $this->CI->db->from('admin');
        $this->CI->db->where('id', $str);
        $count = $this->CI->db->count_all_results();

        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }

    function check_email($str, $id = false) {
        $this->CI->db->select('email');
        $this->CI->db->from('admin');
        $this->CI->db->where('email', $str);
        if ($id) {
            $this->CI->db->where('id !=', $id);
        }
        $count = $this->CI->db->count_all_results();

        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }

    function delete($id) {
        if ($this->check_id($id)) {
            $admin = $this->get_admin($id);
            $this->CI->db->where('id', $id);
            $this->CI->db->limit(1);
            $this->CI->db->delete('admin');

            return $admin->firstname . ' ' . $admin->lastname . ' has been removed.';
        } else {
            return 'The admin could not be found.';
        }
    }

    function is_logged_in_teacher($redirect = false, $default_redirect = true) {


        $teacher = $this->CI->session->userdata('student');

        if (!$teacher) {
            if ($default_redirect) {
                redirect('site/userlogin');
            }

            return false;
        } else {
            if ($teacher['role'] != "teacher") {

                redirect('site/userlogin');
            }

            return true;
        }
    }

function validate_child($id= NULL){
    $parent=$this->CI->session->userdata('student');
   $parent_id=$parent['id'];


     if($id){

            $this->CI->db->select('*')->from('users');
            $this->CI->db->where('users.id', $parent_id);
            $query = $this->CI->db->get();
            $prent_childs= $query->row(); 
            $childs=explode(',', $prent_childs->childs);
                       if(!in_array($id, $childs)){
                            header("HTTP/1.1 404 Not Found");
           show_404();
           return false;
            }
    else
    {
       return true;
    }
       
     
  
}

}

    function is_logged_in_parent($redirect = false, $default_redirect = true) {


        $parent = $this->CI->session->userdata('student');

        if (!$parent) {
            if ($default_redirect) {
                redirect('site/userlogin');
            }

            return false;
        } else {
            if ($parent['role'] != "parent") {

                redirect('site/userlogin');
            }

            return true;
        }
    }

    function is_logged_in_user($redirect = false, $default_redirect = true) {


        $student = $this->CI->session->userdata('student');

        if (!$student) {
            if ($default_redirect) {
                redirect('site/userlogin');
            }

            return false;
        } else {
            if ($student['role'] != "student") {

                redirect('site/userlogin');
            }

            return true;
        }
    }

    function is_logged_in_accountant($redirect = false, $default_redirect = true) {


        $student = $this->CI->session->userdata('student');
        
        if (!$student) {
            if ($default_redirect) {
                redirect('site/userlogin');
            }

            return false;
        } else {
            if ($student['role'] != "accountant") {

                redirect('site/userlogin');
            }

            return true;
        }
    }

    function is_logged_in_librarian($redirect = false, $default_redirect = true) {


        $student = $this->CI->session->userdata('student');
        
        if (!$student) {
            if ($default_redirect) {
                redirect('site/userlogin');
            }

            return false;
        } else {
            if ($student['role'] != "librarian") {

                redirect('site/userlogin');
            }

            return true;
        }
    }

}
