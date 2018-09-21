<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Class_model extends CI_Model {

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
        $this->db->select()->from('classes');
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

    /**
     * This function will delete the record based on the id
     * @param $id
     */
    public function remove($id) {
        $this->db->trans_begin();
        $this->db->where('id', $id);
        $this->db->delete('classes'); //class record delete.

        $this->db->where('class_id', $id);
        $this->db->delete('class_sections'); //class_sections record delete.

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }
        return TRUE;
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
            $this->db->update('classes', $data);
        } else {
            $this->db->insert('classes', $data);
        }
    }

    function check_data_exists($data) {
        $this->db->where('class', $data);

        $query = $this->db->get('classes');
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return FALSE;
        }
    }

    public function class_exists($str) {

        $class = $this->security->xss_clean($str);
        $res = $this->check_data_exists($class);

        if ($res) {
            $pre_class_id = $this->input->post('pre_class_id');
            if (isset($pre_class_id)) {
                if ($res->id == $pre_class_id) {
                    return TRUE;
                }
            }
            $this->form_validation->set_message('class_exists', 'Record already exists');
            return FALSE;
        } else {
            return TRUE;
        }
    }

}
