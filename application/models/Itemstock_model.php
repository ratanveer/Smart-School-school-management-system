<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Itemstock_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->current_session = $this->setting_model->getCurrentSession();
    }

    public function get($id = null) {
        $this->db->select('`item_stock`.*, `item`.`name`, `item`.`item_category_id`, `item`.`description`, `item_category`.`item_category`, `item_supplier`.`item_supplier`, `item_store`.`item_store`')->from('item_stock');
        $this->db->join('item ', 'item.id = item_stock.item_id');
        $this->db->join('item_category', 'item.item_category_id = item_category.id');
        $this->db->join('item_supplier', 'item_stock.supplier_id = item_supplier.id');
        $this->db->join('item_store', 'item_store.id = item_stock.store_id','left outer');
        if ($id != null) {
            $this->db->where('item_stock.id', $id);
        } else {
            $this->db->order_by('item_stock.id', 'DESC');
        }
        $this->db->limit('20');
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
        $this->db->where('id', $id);
        $this->db->delete('item_stock');
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
            $this->db->update('item_stock', $data);
        } else {
            $this->db->insert('item_stock', $data);
            return $this->db->insert_id();
        }
    }

}
