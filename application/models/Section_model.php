<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Section_model extends CI_Model {

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
        $this->db->select()->from('sections');
        if ($id != null) {
            $this->db->where('id', $id);
        } else {
            $this->db->order_by('id');
        }
        $query = $this->db->get();
        if ($id != null) {
            return $query->row_array(); // single row
        } else {
            return $query->result_array(); // array of result
        }
    }

    /**
     * This function will delete the record based on the id
     * @param $id
     */
    public function remove($id) {
        $this->db->where('id', $id);
        $this->db->delete('sections');
    }

    public function getClassBySection($classid) {
        $this->db->select('class_sections.id,class_sections.section_id,sections.section');
        $this->db->from('class_sections');
        $this->db->join('sections', 'sections.id = class_sections.section_id');
        $this->db->where('class_sections.class_id', $classid);
        $this->db->order_by('class_sections.id');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getClassNameBySection($classid, $sectionid) {
        $this->db->select('class_sections.id,class_sections.section_id,sections.section,classes.class');
        $this->db->from('class_sections');
        $this->db->join('sections', 'sections.id = class_sections.section_id');
        $this->db->join('classes', 'classes.id = class_sections.class_id');
        $this->db->where('class_sections.class_id', $classid);
        $this->db->where('class_sections.section_id', $sectionid);
        $this->db->order_by('class_sections.id');
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
            $this->db->update('sections', $data);
        } else {
            $this->db->insert('sections', $data);
        }
    }

}
