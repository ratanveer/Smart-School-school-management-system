<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Itemissue_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->current_session = $this->setting_model->getCurrentSession();
    }

    public function get($id = null) {
        $sql = 'SELECT item_issue.*,item.name as `item_name`,item.item_category_id,item_category.item_category FROM `item_issue` INNER JOIN item on item.id=item_issue.item_id INNER JOIN item_category on item_category.id=item.item_category_id';
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    /**
     * This function will delete the record based on the id
     * @param $id
     */
    public function remove($id) {
        $this->db->where('id', $id);
        $this->db->delete('item_issue');
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
            $this->db->update('item_issue', $data);
        } else {
            $this->db->insert('item_issue', $data);
            return $this->db->insert_id();
        }
    }

}
