<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Teacher extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('file');
        $this->lang->load('message', 'english');
        $this->role;
        $this->load->library('auth');
        $this->auth->is_logged_in_teacher();
    }

    function index() {
        $this->session->set_userdata('top_menu', 'Academics');
        $this->session->set_userdata('sub_menu', 'teacher/index');
        $data['title'] = 'Add Teacher';
        $teacher_result = $this->teacher_model->get();
        $data['teacherlist'] = $teacher_result;
        $genderList = $this->customlib->getGender();
        $data['genderList'] = $genderList;
        $this->load->view('layout/teacher/header', $data);
        $this->load->view('teacher/teacher/teacherList', $data);
        $this->load->view('layout/teacher/footer', $data);
    }

    function dashboard() {
        $data = array();
        $teacher_id = $this->session->userdata['student']['teacher_id'];
        $teacher_result = $this->teacher_model->get($teacher_id);
        $data['title'] = 'Teacher List';
        $teacher = $this->teacher_model->get($teacher_id);
        $teachersubject = $this->teachersubject_model->getTeacherClassSubjects($teacher_id);
        $data['teacher'] = $teacher;
        $data['teachersubject'] = $teachersubject;
        $this->load->view('layout/teacher/header', $data);
        $this->load->view('teacher/dashboard', $data);
        $this->load->view('layout/teacher/footer', $data);
    }

    function getSubjctByClassandSection() {
        $class_id = $this->input->post('class_id');
        $section_id = $this->input->post('section_id');
        $data = $this->teachersubject_model->getSubjectByClsandSection($class_id, $section_id);
        echo json_encode($data);
    }

    function assign_Teacher() {
        $this->session->set_userdata('top_menu', 'Academics');
        $this->session->set_userdata('sub_menu', 'teacher/assignTeacher');
        $data['title'] = 'Assign Teacher with Class and Subject wise';
        $teacher = $this->teacher_model->get();
        $data['teacherlist'] = $teacher;
        $subject = $this->subject_model->get();
        $data['subjectlist'] = $subject;
        $class = $this->class_model->get();
        $data['classlist'] = $class;
        $this->load->view('layout/teacher/header', $data);
        $this->load->view('teacher/teacher/assignTeacher', $data);
        $this->load->view('layout/teacher/footer', $data);
        if ($this->input->server('REQUEST_METHOD') == "POST") {
            $loop = $this->input->post('i');
            $array = array();
            foreach ($loop as $key => $value) {
                $s = array();
                $s['session_id'] = $this->setting_model->getCurrentSession();
                $class_id = $this->input->post('class_id');
                $section_id = $this->input->post('section_id');
                $dt = $this->classsection_model->getDetailbyClassSection($class_id, $section_id);
                $s['class_section_id'] = $dt['id'];
                $s['teacher_id'] = $this->input->post('teacher_id_' . $value);
                $s['subject_id'] = $this->input->post('subject_id_' . $value);
                $row_id = $this->input->post('row_id_' . $value);
                if ($row_id == 0) {
                    $insert_id = $this->teachersubject_model->add($s);
                    $array[] = $insert_id;
                } else {
                    $s['id'] = $row_id;
                    $array[] = $row_id;
                    $this->teachersubject_model->add($s);
                }
            }
            $ids = implode(",", $array);
            $this->teachersubject_model->deleteBatch($ids);
            $this->session->set_flashdata('msg', '<div class="alert alert-success">Record Updated Successfully!!!</div>');
            redirect('teacher/teacher/assignTeacher');
        }
    }

    function getSubjectTeachers() {
        $class_id = $this->input->post('class_id');
        $section_id = $this->input->post('section_id');
        $dt = $this->classsection_model->getDetailbyClassSection($class_id, $section_id);
        $data = $this->teachersubject_model->getDetailByclassAndSection($dt['id']);
        echo json_encode($data);
    }

    function views($id) {
        $data['title'] = 'Teacher List';
        $teacher = $this->teacher_model->get($id);
        $teachersubject = $this->teachersubject_model->getTeacherClassSubjects($id);
        $data['teacher'] = $teacher;
        $data['teachersubject'] = $teachersubject;
        $this->load->view('layout/teacher/header', $data);
        $this->load->view('teacher/teacher/teacherShow', $data);
        $this->load->view('layout/teacher/footer', $data);
    }

    function deletes($id) {
        $data['title'] = 'Teacher List';
        $this->teacher_model->remove($id);
        redirect('teacher/teacher/index');
    }

    function creates() {
        $data['title'] = 'Add teacher';
        $genderList = $this->customlib->getGender();
        $data['genderList'] = $genderList;
        $this->form_validation->set_rules('name', 'Teacher', 'trim|required|xss_clean');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean');
        $this->form_validation->set_rules('gender', 'Gender', 'trim|required|xss_clean');
        $this->form_validation->set_rules('dob', 'Date of Birth', 'trim|required|xss_clean');
        $this->form_validation->set_rules('phone', 'Phone', 'trim|required|xss_clean');
        $this->form_validation->set_rules('file', 'Image', 'callback_handle_upload');
        if ($this->form_validation->run() == FALSE) {
            $teacher_result = $this->teacher_model->get();
            $data['teacherlist'] = $teacher_result;
            $genderList = $this->customlib->getGender();
            $data['genderList'] = $genderList;
            $this->load->view('layout/teacher/header', $data);
            $this->load->view('teacher/teacher/teacherCreate', $data);
            $this->load->view('layout/teacher/footer', $data);
        } else {
            $data = array(
                'name' => $this->input->post('name'),
                'email' => $this->input->post('email'),
                'password' => $this->input->post('password'),
                'sex' => $this->input->post('gender'),
                'dob' => date('Y-m-d', $this->customlib->datetostrtotime($this->input->post('dob'))),
                'address' => $this->input->post('address'),
                'phone' => $this->input->post('phone'),
                'image' => 'uploads/student_images/no_image.png',
            );
            $insert_id = $this->teacher_model->add($data);
            $user_password = $this->role->get_random_password($chars_min = 6, $chars_max = 6, $use_upper_case = false, $include_numbers = true, $include_special_chars = false);
            $data_student_login = array(
                'username' => $this->teacher_login_prefix . $insert_id,
                'password' => $user_password,
                'user_id' => $insert_id,
                'role' => 'teacher'
            );
            $this->user_model->add($data_student_login);
            if (isset($_FILES["file"]) && !empty($_FILES['file']['name'])) {
                $fileInfo = pathinfo($_FILES["file"]["name"]);
                $img_name = $insert_id . '.' . $fileInfo['extension'];
                move_uploaded_file($_FILES["file"]["tmp_name"], "./uploads/teacher_images/" . $img_name);
                $data_img = array('id' => $insert_id, 'image' => 'uploads/teacher_images/' . $img_name);
                $this->teacher_model->add($data_img);
            }
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">Teacher added successfully</div>');
            redirect('teacher/teacher/index');
        }
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

    function edit($id) {
        $data['title'] = 'Edit Teacher';
        $data['id'] = $id;
        $genderList = $this->customlib->getGender();
        $data['genderList'] = $genderList;
        $teacher = $this->teacher_model->get($id);
        $data['teacher'] = $teacher;
        $this->form_validation->set_rules('name', 'Teacher', 'trim|required|xss_clean');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean');
        $this->form_validation->set_rules('gender', 'Gender', 'trim|required|xss_clean');
        $this->form_validation->set_rules('dob', 'Date of Birth', 'trim|required|xss_clean');
        $this->form_validation->set_rules('phone', 'Phone', 'trim|required|xss_clean');
        $this->form_validation->set_rules('file', 'Image', 'callback_handle_upload');
        if ($this->form_validation->run() == FALSE) {
            $teacher_result = $this->teacher_model->get();
            $data['teacherlist'] = $teacher_result;
            $this->load->view('layout/teacher/header', $data);
            $this->load->view('teacher/teacher/teacherEdit', $data);
            $this->load->view('layout/teacher/footer', $data);
        } else {
            $data = array(
                'id' => $id,
                'name' => $this->input->post('name'),
                'email' => $this->input->post('email'),
                'password' => $this->input->post('password'),
                'sex' => $this->input->post('gender'),
                'dob' => date('Y-m-d', $this->customlib->datetostrtotime($this->input->post('dob'))),
                'address' => $this->input->post('address'),
                'phone' => $this->input->post('phone')
            );
            $insert_id = $this->teacher_model->add($data);
            if (isset($_FILES["file"]) && !empty($_FILES['file']['name'])) {
                $fileInfo = pathinfo($_FILES["file"]["name"]);
                $img_name = $id . '.' . $fileInfo['extension'];
                move_uploaded_file($_FILES["file"]["tmp_name"], "./uploads/teacher_images/" . $img_name);
                $data_img = array('id' => $id, 'image' => 'uploads/teacher_images/' . $img_name);
                $this->teacher_model->add($data_img);
            }
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Teacher updated successfully</div>');
            redirect('teacher/teacher/index');
        }
    }

    function getlogindetail() {
        $teacher_id = $this->input->post('teacher_id');
        $examSchedule = $this->user_model->getTeacherLoginDetails($teacher_id);
        echo json_encode($examSchedule);
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
            $this->load->view('layout/teacher/header', $data);
            $this->load->view('teacher/change_password', $data);
            $this->load->view('layout/teacher/footer', $data);
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
                    $this->load->view('layout/teacher/header', $data);
                    $this->load->view('teacher/change_password', $data);
                    $this->load->view('layout/teacher/footer', $data);
                }
            } else {

                $this->session->set_flashdata('error_msg', 'Invalid current password');
                $this->load->view('layout/teacher/header', $data);
                $this->load->view('teacher/change_password', $data);
                $this->load->view('layout/teacher/footer', $data);
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
                        redirect('teacher/teacher/changeusername');
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
        $this->load->view('layout/teacher/header', $data);
        $this->load->view('teacher/change_username', $data);
        $this->load->view('layout/teacher/footer', $data);
    }

}

?>