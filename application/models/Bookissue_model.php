<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Bookissue_model extends CI_Model {

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
        $this->db->select()->from('book_issues');
        if ($id != null) {
            $this->db->where('book_issues.id', $id);
        } else {
            $this->db->order_by('book_issues.id');
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
        $this->db->where('id', $id);
        $this->db->delete('book_issues');
    }

    public function add($data) {

        $this->db->insert('book_issues', $data);
        return $this->db->insert_id();
    }

    /**
     * This funtion takes id as a parameter and will fetch the record.
     * If id is not provided, then it will fetch all the records form the table.
     * @param int $id
     * @return mixed
     */
    public function getMemberBooks($member_id) {
        $this->db->select('book_issues.id,book_issues.return_date,book_issues.issue_date,book_issues.is_returned,books.book_title,books.book_no,books.author')->from('book_issues');
        $this->db->join('books', 'books.id = book_issues.book_id', 'left');
        if ($member_id != null) {
            $this->db->where('book_issues.member_id', $member_id);
            $this->db->order_by("book_issues.is_returned", "asc");
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    public function update($data) {
        if (isset($data['id'])) {
            $this->db->where('id', $data['id']);
            $this->db->update('book_issues', $data);
        }
    }

    function book_issuedByMemberID($member_id) {
        $this->db->select('book_issues.return_date,books.book_no,book_issues.issue_date,book_issues.is_returned,books.book_title,books.author')
                ->from('book_issues')
                ->join('libarary_members', 'libarary_members.id = book_issues.member_id', 'left')
                ->join('books', 'books.id = book_issues.book_id', 'left')
                ->where('libarary_members.id', $member_id)
                ->order_by('book_issues.is_returned', 'asc');
        $result = $this->db->get();
        return $result->result_array();
    }

}
