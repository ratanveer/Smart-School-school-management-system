<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Teacher_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * This funtion takes id as a parameter and will fetch the record.
     * If id is not provided, then it will fetch all the records form the table.
     * @param int $id
     * @return mixed
     */
    public function get($id = null) {
        $this->db->select()->from('teachers');
        if ($id != null) {
            $this->db->where('id', $id);
        } else {
            $this->db->order_by('id');
        }
        $query = $this->db->get();
        if ($id != null) {
            return $query->row_array();
        } else {
            return $query->result_array();
        }
    }

    public function getTeacher($id = null) {
        $this->db->select('teachers.*,users.id as `user_tbl_id`,users.username,users.password as `user_tbl_password`,users.is_active as `user_tbl_active`');
        $this->db->from('teachers');
        $this->db->join('users', 'users.user_id = teachers.id', 'left');
        $this->db->where('users.role', 'teacher');
        $query = $this->db->get();
        if ($id != null) {
            return $query->row_array();
        } else {
            return $query->result_array();
        }
    }

    public function getTeacherByEmail($email = null) {
        $this->db->select('teachers.*,users.id as `user_tbl_id`,users.username,users.password as `user_tbl_password`,users.is_active as `user_tbl_active`');
        $this->db->from('teachers');
        $this->db->join('users', 'users.user_id = teachers.id', 'left');
        $this->db->where('users.role', 'teacher');
        $this->db->where('teachers.email', $email);
        $query = $this->db->get();
        if ($email != null) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function getLibraryTeacher() {
        $this->db->select('teachers.*, IFNULL(libarary_members.id,0) as `libarary_member_id`, IFNULL(libarary_members.library_card_no,0) as `library_card_no`')->from('teachers');

        $this->db->join('libarary_members', 'libarary_members.member_id = teachers.id and libarary_members.member_type = "teacher"', 'left');

        $this->db->order_by('teachers.id');

        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * This function will delete the record based on the id
     * @param $id
     */
    public function remove($id) {
        $this->db->where('id', $id);
        $this->db->delete('teachers');
    }

    /**
     * This function will take the post data passed from the controller
     * If id is present, then it will do an update
     * else an insert. One function doing both add and edit.
     * @param $data
     */
    public function add($data) {
        if (isset($data['id'])) {
            $this->db->where('id', $data['id']);
            $this->db->update('teachers', $data);
        } else {
            $this->db->insert('teachers', $data);
            return $this->db->insert_id();
        }
    }

    public function getTotalTeacher() {
        $sql = "SELECT count(*) as `total_teacher` FROM `teachers`";
        $query = $this->db->query($sql);
        return $query->row();
    }

    public function searchNameLike($searchterm) {
        $this->db->select('teachers.*')->from('teachers');
        $this->db->group_start();
        $this->db->like('teachers.name', $searchterm);
        $this->db->group_end();
        $this->db->order_by('teachers.id');

        $query = $this->db->get();
        return $query->result_array();
    }

}
