<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class site extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->check_installation();
        if ($this->config->item('installed') == true) {
            $this->db->reconnect();
        }
        $this->load->library('Auth');
        $this->load->library('Enc_lib');

        $this->load->helper('file');
        $this->lang->load('message', 'english');
        $this->load->library('mailer');
        $this->mailer;
    }

    private function check_installation() {
        if ($this->uri->segment(1) !== 'install') {
            $this->load->config('migration');
            if ($this->config->item('installed') == false && $this->config->item('migration_enabled') == false) {
                redirect(base_url() . 'install/start');
            } else {
                if (is_dir(APPPATH . 'controllers/install')) {
                    echo '<h3>Delete the install folder from application/controllers/install</h3>';
                    die;
                }
            }
        }
    }

    function login() {
        $data['title'] = 'Login';
        $this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('admin/login', $data);
        } else {
            $data = array(
                'username' => $this->input->post('username'),
                'password' => $this->input->post('password')
            );
            $result = $this->admin_model->checkLogin($data);
            if ($result == TRUE) {
                $username = $this->input->post('username');
                $admin_details = $this->admin_model->read_user_information($username);
                if ($admin_details != false) {
                    $setting_result = $this->setting_model->get();
                    $session_data = array(
                        'id' => $admin_details[0]->id,
                        'username' => $admin_details[0]->username,
                        'email' => $admin_details[0]->email,
                        'date_format' => $setting_result[0]['date_format'],
                        'currency_symbol' => $setting_result[0]['currency_symbol'],
                        'start_month' => $setting_result[0]['start_month'],
                        'school_name' => $setting_result[0]['name'],
                        'timezone' => $setting_result[0]['timezone'],
                        'sch_name' => $setting_result[0]['name'],
                        'language' => array('lang_id' => $setting_result[0]['lang_id'], 'language' => $setting_result[0]['language']),
                        'is_rtl' => $setting_result[0]['is_rtl'],
                        'theme' => $setting_result[0]['theme'],
                    );
                    $this->session->set_userdata('admin', $session_data);
                    $this->customlib->setUserLog($username, 'admin');
                    redirect('admin/admin/dashboard');
                }
            } else {
                $data = array(
                    'error_message' => 'Invalid Username or Password'
                );
                $this->load->view('admin/login', $data);
            }
        }
    }

    function logout() {
        $admin_session = $this->session->userdata('admin');
        $student_session = $this->session->userdata('student');
        $this->auth->logout();
        if ($admin_session) {
            redirect('site/login');
        } else if ($student_session) {
            redirect('site/userlogin');
        } else {
            redirect('site/userlogin');
        }
    }

    function forgotpassword() {
        $this->form_validation->set_rules('email', 'Email', 'trim|valid_email|required|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('admin/forgotpassword');
        } else {
            $email = $this->input->post('email');


            $result = $this->admin_model->readByEmail($email);


            if ($result && $result->email != "") {

                $verification_code = $this->enc_lib->encrypt(uniqid(mt_rand()));
                $update_record = array('id' => $result->id, 'verification_code' => $verification_code);
                $this->admin_model->updateVerCode($update_record);

                $name = $result->username;

                $resetPassLink = site_url('admin/resetpassword') . "/" . $verification_code;

                $body = $this->forgotPasswordBody($name, $resetPassLink);
                $body_array = json_decode($body);

                if (!empty($this->mail_config)) {
                    $result = $this->mailer->send_mail($result->email, $body_array->subject, $body_array->body);
                }

                $this->session->set_flashdata('message', "Please check your email to recover your password");
                redirect('site/login', 'refresh');
            } else {
                $data = array(
                    'error_message' => 'Invalid Email'
                );
            }
            $this->load->view('admin/forgotpassword', $data);
        }
    }

    //reset password - final step for forgotten password
    public function admin_resetpassword($verification_code = null) {
        if (!$verification_code) {
            show_404();
        }

        $user = $this->admin_model->getAdminByCode($verification_code);

        if ($user) {
            //if the code is valid then display the password reset form
            $this->form_validation->set_rules('password', 'Password', 'required');
            $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');
            if ($this->form_validation->run() == false) {


                $data['verification_code'] = $verification_code;
                //render
                $this->load->view('admin/admin_resetpassword', $data);
            } else {

                // finally change the password

                $update_record = array(
                    'id' => $user->id,
                    'password' => md5($this->input->post('password')),
                    'verification_code' => ""
                );

                $change = $this->admin_model->saveNewPass($update_record);
                if ($change) {
                    //if the password was successfully changed
                    $this->session->set_flashdata('message', "Password Reset successfully");
                    redirect('site/login', 'refresh');
                } else {
                    $this->session->set_flashdata('message', "Something went wrong");
                    redirect('admin_resetpassword/' . $verification_code, 'refresh');
                }
            }
        } else {
            //if the code is invalid then send them back to the forgot password page
            $this->session->set_flashdata('message', 'Invalid Link');
            redirect("site/forgotpassword", 'refresh');
        }
    }

    //reset password - final step for forgotten password
    public function resetpassword($role = null, $verification_code = null) {
        if (!$role || !$verification_code) {
            show_404();
        }

        $user = $this->user_model->getUserByCodeUsertype($role, $verification_code);

        if ($user) {
            //if the code is valid then display the password reset form
            $this->form_validation->set_rules('password', 'Password', 'required');
            $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');
            if ($this->form_validation->run() == false) {

                $data['role'] = $role;
                $data['verification_code'] = $verification_code;
                //render
                $this->load->view('resetpassword', $data);
            } else {

                // finally change the password

                $update_record = array(
                    'id' => $user->user_tbl_id,
                    'password' => $this->input->post('password'),
                    'verification_code' => ""
                );

                $change = $this->user_model->saveNewPass($update_record);
                if ($change) {
                    //if the password was successfully changed
                    $this->session->set_flashdata('message', "Password Reset successfully");
                    redirect('site/userlogin', 'refresh');
                } else {
                    $this->session->set_flashdata('message', "Something went wrong");
                    redirect('user/resetpassword/' . $role . '/' . $verification_code, 'refresh');
                }
            }
        } else {
            //if the code is invalid then send them back to the forgot password page
            $this->session->set_flashdata('message', 'Invalid Link');
            redirect("site/ufpassword", 'refresh');
        }
    }

    function ufpassword() {
        $this->form_validation->set_rules('username', 'Email', 'trim|required|xss_clean');
        $this->form_validation->set_rules('user[]', 'User Type', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('ufpassword');
        } else {
            $email = $this->input->post('username');
            $usertype = $this->input->post('user[]');

            $result = $this->user_model->forgotPassword($usertype[0], $email);

            if ($result && $result->email != "") {

                $verification_code = $this->enc_lib->encrypt(uniqid(mt_rand()));
                $update_record = array('id' => $result->user_tbl_id, 'verification_code' => $verification_code);
                $this->user_model->updateVerCode($update_record);
                if ($usertype[0] == "student") {
                    $name = $result->firstname . " " . $result->lastname;
                } else {
                    $name = $result->name;
                }
                $resetPassLink = site_url('user/resetpassword') . '/' . $usertype[0] . "/" . $verification_code;

                $body = $this->forgotPasswordBody($name, $resetPassLink);
                $body_array = json_decode($body);

                if (!empty($this->mail_config)) {
                    $result = $this->mailer->send_mail($result->email, $body_array->subject, $body_array->body);
                }

                $this->session->set_flashdata('message', "Please check your email to recover your password");
                redirect('site/userlogin', 'refresh');
            } else {
                $data = array(
                    'error_message' => 'Invalid Email or User Type'
                );
            }
            $this->load->view('ufpassword', $data);
        }
    }

    function forgotPasswordBody($name, $resetPassLink) {
        //===============
        $subject = "Password Update Request";
        $body = 'Dear ' . $name . ', 
                <br/>Recently a request was submitted to reset password for your account. If you didn\'t make the request, just ignore this email. Otherwise you can reset your password using this link <a href="' . $resetPassLink . '"><button>Click here to reset your password</button></a>';
        $body .= '<br/><hr/>if you\'re having trouble clicking the password reset button, copy and paste the URL below into your web browser';
        $body .= '<br/>' . $resetPassLink;
        $body .= '<br/><br/>Regards,
                <br/>' . $this->customlib->getSchoolName();

        //======================
        return json_encode(array('subject' => $subject, 'body' => $body));
    }

    function userlogin() {
    
        $data['title'] = 'Login';
        $this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('userlogin', $data);
        } else {
            $data = array(
                'username' => $this->input->post('username'),
                'password' => $this->input->post('password')
            );
            $result = $this->user_model->checkLogin($data);

            if ($result) {
                if ($result[0]->is_active == "yes") {
                    $username = $this->input->post('username');
                    if ($result[0]->role == "student") {
                        $result = $this->user_model->read_user_information($username);
                    } else if ($result[0]->role == "parent") {
                        $result = $this->user_model->read_user_information($username);
                    } else if ($result[0]->role == "teacher") {
                        $result = $this->user_model->read_teacher_information($username);
                    } else if ($result[0]->role == "accountant") {
                        $result = $this->user_model->read_accountant_information($username);
                    } else if ($result[0]->role == "librarian") {
                        $result = $this->user_model->read_librarian_information($username);
                    }

                    if ($result != false) {
                        $setting_result = $this->setting_model->get();

                        if ($result[0]->role == "student") {
                            $session_data = array(
                                'id' => $result[0]->id,
                                'student_id' => $result[0]->user_id,
                                'role' => $result[0]->role,
                                'username' => $result[0]->firstname . " " . $result[0]->lastname,
                                'date_format' => $setting_result[0]['date_format'],
                                'currency_symbol' => $setting_result[0]['currency_symbol'],
                                'timezone' => $setting_result[0]['timezone'],
                                'sch_name' => $setting_result[0]['name'],
                                'language' => array('lang_id' => $setting_result[0]['lang_id'], 'language' => $setting_result[0]['language']),
                                'is_rtl' => $setting_result[0]['is_rtl'],
                                'theme' => $setting_result[0]['theme'],
                            );
                            $this->session->set_userdata('student', $session_data);
                            $this->customlib->setUserLog($username, $result[0]->role);
                            redirect('user/user/dashboard');
                        } else if ($result[0]->role == "parent") {
                            $session_data = array(
                                'id' => $result[0]->id,
                                'student_id' => $result[0]->user_id,
                                'role' => $result[0]->role,
                                'username' => $result[0]->guardian_name,
                                'date_format' => $setting_result[0]['date_format'],
                                'timezone' => $setting_result[0]['timezone'],
                                'sch_name' => $setting_result[0]['name'],
                                'currency_symbol' => $setting_result[0]['currency_symbol'],
                                'language' => array('lang_id' => $setting_result[0]['lang_id'], 'language' => $setting_result[0]['language']),
                                'is_rtl' => $setting_result[0]['is_rtl'],
                                'theme' => $setting_result[0]['theme'],
                            );
                            $this->session->set_userdata('student', $session_data);
                            $s = array();
                            $childs_ids = ($result[0]->childs);
                            $students_array = $this->student_model->read_siblings_students($childs_ids);
                            foreach ($students_array as $key => $each) {
                                $d = array(
                                    'student_id' => $each['id'],
                                    'name' => $each['firstname'] . " " . $each['lastname']
                                );
                                $s[] = $d;
                            }
                            $this->session->set_userdata('parent_childs', $s);
                            $this->customlib->setUserLog($username, $result[0]->role);
                            redirect('parent/parents/dashboard');
                        } else if ($result[0]->role == "teacher") {
                            $session_data = array(
                                'id' => $result[0]->id,
                                'teacher_id' => $result[0]->user_id,
                                'role' => $result[0]->role,
                                'username' => $result[0]->name,
                                'date_format' => $setting_result[0]['date_format'],
                                'timezone' => $setting_result[0]['timezone'],
                                'sch_name' => $setting_result[0]['name'],
                                'currency_symbol' => $setting_result[0]['currency_symbol'],
                                'language' => array('lang_id' => $setting_result[0]['lang_id'], 'language' => $setting_result[0]['language']),
                                'is_rtl' => $setting_result[0]['is_rtl'],
                                'theme' => $setting_result[0]['theme'],
                            );
                            $this->session->set_userdata('student', $session_data);
                            $this->customlib->setUserLog($username, $result[0]->role);
                            redirect('teacher/teacher/dashboard');
                        } else if ($result[0]->role == "accountant") {
                            $session_data = array(
                                'id' => $result[0]->id,
                                'accountant_id' => $result[0]->user_id,
                                'role' => $result[0]->role,
                                'username' => $result[0]->name,
                                'date_format' => $setting_result[0]['date_format'],
                                'timezone' => $setting_result[0]['timezone'],
                                'sch_name' => $setting_result[0]['name'],
                                'currency_symbol' => $setting_result[0]['currency_symbol'],
                                'language' => array('lang_id' => $setting_result[0]['lang_id'], 'language' => $setting_result[0]['language']),
                                'is_rtl' => $setting_result[0]['is_rtl'],
                                'theme' => $setting_result[0]['theme'],
                            );

                            $this->session->set_userdata('student', $session_data);
                            $this->customlib->setUserLog($username, $result[0]->role);
                            redirect('accountant/accountant/dashboard');
                        } else if ($result[0]->role == "librarian") {


                            $session_data = array(
                                'id' => $result[0]->id,
                                'librarian_id' => $result[0]->user_id,
                                'role' => $result[0]->role,
                                'username' => $result[0]->name,
                                'date_format' => $setting_result[0]['date_format'],
                                'timezone' => $setting_result[0]['timezone'],
                                'sch_name' => $setting_result[0]['name'],
                                'currency_symbol' => $setting_result[0]['currency_symbol'],
                                'language' => array('lang_id' => $setting_result[0]['lang_id'], 'language' => $setting_result[0]['language']),
                                'is_rtl' => $setting_result[0]['is_rtl'],
                            );

                            $this->session->set_userdata('student', $session_data);
                            $this->customlib->setUserLog($username, $result[0]->role);
                            redirect('librarian/librarian/dashboard');
                        }
                    } else {
                        $data = array(
                            'error_message' => 'Account Suspended'
                        );
                        $this->load->view('userlogin', $data);
                    }
                } else {
                    $data = array(
                        'error_message' => 'Your account is disabled please contact to administrator'
                    );
                    $this->load->view('userlogin', $data);
                }
            } else {
                $data = array(
                    'error_message' => 'Invalid Username or Password'
                );
                $this->load->view('userlogin', $data);
            }
        }
    }

}

?>