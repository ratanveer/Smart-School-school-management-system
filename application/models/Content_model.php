<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Content_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->current_session = $this->setting_model->getCurrentSession();
    }

    /**
     * This funtion takes id as a parameter and will fetch the record.
     * If id is not provided, then it will fetch all the records form the table.
     * @param int $id
     * @return mixed
     */
    public function get($id = null) {
        $this->db->select('contents.*,classes.class')->from('contents');
        $this->db->join('classes', 'contents.class_id = classes.id', 'left outer');
        if ($id != null) {
            $this->db->where('contents.id', $id);
        }
        $this->db->order_by('contents.id', "desc");
        $this->db->limit(10);
        $query = $this->db->get();
        if ($id != null) {
            return $query->row_array();
        } else {
            return $query->result_array();
        }
    }

    public function getListByCategory($category) {
        $this->db->select('contents.*,classes.class')->from('contents');
        $this->db->join('classes', 'contents.class_id = classes.id', 'left outer');
        $this->db->where('contents.type', $category);
        $this->db->order_by('contents.id');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getListByCategoryforUser($class_id, $category) {
        $query = "SELECT * FROM `contents` WHERE (class_id =$class_id and type='$category') or (is_public='yes' and type='$category')";
        $query = $this->db->query($query);
        return $query->result_array();
    }

    /**
     * This function will delete the record based on the id
     * @param $id
     */
    public function remove($id) {
        $this->db->where('id', $id);
        $this->db->delete('contents');
    }

    public function search_by_content_type($text) {
        $this->db->select()->from('contents');
        $this->db->or_like('contents.content_type', $text);
        $query = $this->db->get();
        return $query->result_array();
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
            $this->db->update('contents', $data);
        } else {
            $this->db->insert('contents', $data);
            return $this->db->insert_id();
        }
    }

}
