<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Studentsession_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->current_session = $this->setting_model->getCurrentSession();
    }

    public function searchStudents($class_id = null, $section_id = null, $key = null) {
        $this->db->select('student_session.id,student_session.student_id,classes.class,sections.section,
            students.firstname,students.lastname,students.admission_no,students.roll_no,students.dob,students.guardian_name,
            ')->from('student_session');
        $this->db->join('classes', 'student_session.class_id = classes.id');
        $this->db->join('sections', 'sections.id = student_session.section_id');
        $this->db->join('students', 'students.id = student_session.student_id');
        $this->db->where('student_session.class_id', $class_id);
        $this->db->where('student_session.section_id', $section_id);
        $this->db->order_by('student_session.id');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function searchStudentsBySession($student_session_id = null) {
        $this->db->select('students.admission_no,students.roll_no,student_session.session_id, student_session.class_id, student_session.section_id,student_session.id,student_session.student_id,classes.class,sections.section,
            students.firstname,students.lastname,students.admission_no,students.roll_no,students.dob,students.guardian_name,students.father_name')->from('student_session');
        $this->db->join('classes', 'student_session.class_id = classes.id');
        $this->db->join('sections', 'sections.id = student_session.section_id');
        $this->db->join('students', 'students.id = student_session.student_id');
        $this->db->where('student_session.id', $student_session_id);
        $this->db->order_by('id');
        $query = $this->db->get();
        return $query->row_array();
    }

    public function getStudentClass($id) {
        $this->db->select('students.admission_no,students.roll_no,student_session.session_id, student_session.class_id, student_session.section_id,student_session.id,student_session.student_id,classes.class,sections.section,
            students.firstname,students.lastname,students.admission_no,students.roll_no,students.dob,students.guardian_name,
            ')->from('student_session');
        $this->db->join('classes', 'student_session.class_id = classes.id');
        $this->db->join('sections', 'sections.id = student_session.section_id');
        $this->db->join('students', 'students.id = student_session.student_id');
        $this->db->where('student_id', $id);
        $this->db->where('session_id', $this->current_session);
        $this->db->order_by('id');
        $query = $this->db->get();
        return $query->row_array();
    }

    public function getStudentByStudentId($id) {
        $this->db->select()->from('student_session');
        $this->db->where('student_id', $id);
        $this->db->where('session_id', $this->current_session);
        $this->db->order_by('id');
        $query = $this->db->get();
        return $query->row_array();
    }

    public function getTotalStudentBySession() {
        $query = "SELECT count(*) as `total_student` FROM `student_session` INNER JOIN students on students.id=student_session.student_id where student_session.session_id=" . $this->db->escape($this->current_session);
        $query = $this->db->query($query);
        return $query->row();
    }

}
