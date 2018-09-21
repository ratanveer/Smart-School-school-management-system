<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Notification_model extends CI_Model {

    public $current_session;

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
        $this->db->select()->from('send_notification');
        if ($id != null) {
            $this->db->where('id', $id);
        } else {
            $this->db->order_by('publish_date', 'desc');
        }
        $query = $this->db->get();
        if ($id != null) {
            return $query->row_array();
        } else {
            return $query->result_array();
        }
    }

    public function getNotificationForStudent($studentid = null) {
        $date = date('Y-m-d');
        $query = $this->db->query("SELECT
send_notification.id,send_notification.title,send_notification.publish_date,send_notification.date,send_notification.message,
IF (read_notification.id IS NULL,'unread','read') as notification_id
FROM send_notification
LEFT JOIN read_notification ON send_notification.id = read_notification.notification_id and read_notification.student_id=" . $this->db->escape($studentid) . " where send_notification.visible_student='Yes' order by send_notification.publish_date desc");
        return $query->result_array();
    }

    public function getNotificationForParent($parentid = null) {
        $date = date('Y-m-d');
        $query = $this->db->query("SELECT
send_notification.id,send_notification.title,send_notification.publish_date,send_notification.date,send_notification.message,
IF (read_notification.id IS NULL,'unread','read') as notification_id
FROM send_notification
LEFT JOIN read_notification ON send_notification.id = read_notification.notification_id and read_notification.parent_id=" . $this->db->escape($parentid) . " where send_notification.visible_parent='Yes' order by send_notification.publish_date desc");
        return $query->result_array();
    }

    public function countUnreadNotificationStudent($studentid = null) {
        $date = date('Y-m-d');
        $query = $this->db->query("select * from (SELECT  IF (read_notification.id IS NULL,'unread','read') as notification_id FROM send_notification LEFT JOIN read_notification ON send_notification.id = read_notification.notification_id and read_notification.student_id=" . $this->db->escape($studentid) . " where  send_notification.visible_student='Yes') final where notification_id ='unread'");
        return $query->num_rows();
    }

    public function countUnreadNotificationParent($parentid = null) {
        $date = date('Y-m-d');
        $query = $this->db->query("select * from (SELECT  IF (read_notification.id IS NULL,'unread','read') as notification_id FROM send_notification LEFT JOIN read_notification ON send_notification.id = read_notification.notification_id and read_notification.parent_id=" . $this->db->escape($parentid) . " where  send_notification.visible_parent='Yes') final where notification_id ='unread'");
        return $query->num_rows();
    }

    /**
     * This function will delete the record based on the id
     * @param $id
     */
    public function remove($id) {
        $this->db->where('id', $id);
        $this->db->delete('send_notification');
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
            $this->db->update('send_notification', $data);
        } else {
            $this->db->insert('send_notification', $data);
            return $this->db->insert_id();
        }
    }

    public function updateStatus($notification_id, $studentid) {
        $this->db->where('notification_id', $notification_id);
        $this->db->where('student_id', $studentid);
        $q = $this->db->get('read_notification');
        if ($q->num_rows() > 0) {
            return true;
        } else {
            $data = array(
                'notification_id' => $notification_id,
                'student_id' => $studentid
            );
            $this->db->insert('read_notification', $data);
        }
    }

    public function updateStatusforParent($notification_id, $parentid) {
        $this->db->where('notification_id', $notification_id);
        $this->db->where('parent_id', $parentid);
        $q = $this->db->get('read_notification');
        if ($q->num_rows() > 0) {
            return true;
        } else {
            $data = array(
                'notification_id' => $notification_id,
                'parent_id' => $parentid
            );
            $this->db->insert('read_notification', $data);
        }
    }

    function add_exam_schedule($data) {
        $this->db->where('exam_id', $data['exam_id']);
        $this->db->where('teacher_subject_id', $data['teacher_subject_id']);
        $q = $this->db->get('exam_schedules');
        if ($q->num_rows() > 0) {
            $result = $q->row_array();
            $this->db->where('id', $result['id']);
            $this->db->update('exam_schedules', $data);
        } else {
            $this->db->insert('exam_schedules', $data);
        }
    }

}
