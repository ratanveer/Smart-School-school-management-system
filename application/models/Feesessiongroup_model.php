<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Feesessiongroup_model extends CI_Model {

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
    public function add($data) {
        $this->db->trans_start();
        $this->db->trans_strict(FALSE);
        $parentid = $this->group_exists($data['fee_groups_id']);
        $data['fee_session_group_id'] = $parentid;
        $this->db->insert('fee_groups_feetype', $data);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function getFeesByGroup($id = null) {
        $this->db->select('fee_session_groups.*,fee_groups.name as `group_name`');
        $this->db->from('fee_session_groups');
        $this->db->join('fee_groups', 'fee_groups.id = fee_session_groups.fee_groups_id');
        $this->db->where('fee_session_groups.session_id', $this->current_session);
        if ($id != null) {
            $this->db->where('fee_session_groups.id', $id);
        }
        $query = $this->db->get();

        $result = $query->result();
        foreach ($result as $key => $value) {
            $value->feetypes = $this->getfeeTypeByGroup($value->fee_groups_id, $value->id);
        }
        return $result;
    }

    public function getfeeTypeByGroup($id = null, $fee_session_group_id) {
        $this->db->select('fee_groups_feetype.*,feetype.type,feetype.code');
        $this->db->from('fee_groups_feetype');
        $this->db->join('feetype', 'feetype.id=fee_groups_feetype.feetype_id');
        $this->db->where('fee_groups_feetype.fee_groups_id', $id);
        $this->db->where('fee_groups_feetype.fee_session_group_id', $fee_session_group_id);
        $this->db->order_by('fee_groups_feetype.id', 'asc');
        $query = $this->db->get();
        return $query->result();
    }

    function group_exists($fee_groups_id) {
        $this->db->where('fee_groups_id', $fee_groups_id);
        $this->db->where('session_id', $this->current_session);
        $query = $this->db->get('fee_session_groups');
        if ($query->num_rows() > 0) {
            return $query->row()->id;
        } else {
            $data = array('fee_groups_id' => $fee_groups_id, 'session_id' => $this->current_session);
            $this->db->insert('fee_session_groups', $data);
            return $this->db->insert_id();
        }
    }

    public function remove($id) {
        $this->db->trans_begin();


        $sql = "delete fee_groups_feetype.* FROM fee_groups_feetype JOIN fee_session_groups ON fee_session_groups.id = fee_groups_feetype.fee_session_group_id WHERE fee_session_groups.id = ?";
        $this->db->query($sql, array($id));

        $this->db->where('id', $id);
        $this->db->delete('fee_session_groups');

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }
    }

}
