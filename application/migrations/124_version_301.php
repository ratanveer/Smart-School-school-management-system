<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Version_301 extends CI_Migration {

    function __construct() {
        parent::__construct();
    }

    public function up() {

        //===================add fee_groups table=========


   $this->db->query("DROP TABLE IF EXISTS `payment_settings`;");
   $this->db->query("CREATE TABLE `payment_settings` (
            `id` int primary key auto_increment,
            `payment_type` varchar(200) NOT NULL,
            `api_username` varchar(200) DEFAULT NULL,
            `api_secret_key` varchar(200) NOT NULL,
            `salt` varchar(200) NOT NULL,
            `api_publishable_key` varchar(200) NOT NULL,
            `api_password` varchar(200) DEFAULT NULL,
            `api_signature` varchar(200) DEFAULT NULL,
            `api_email` varchar(200) DEFAULT NULL,
            `paypal_demo` varchar(100) NOT NULL,
            `account_no` varchar(200) NOT NULL,
            `is_active` varchar(255) DEFAULT 'no',
            `created_at` timestamp
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");


        $this->db->query("CREATE TABLE `income_head` (
 `id` int primary key auto_increment,
  `income_category` varchar(255),
  `description` text,
  `is_active` varchar(10) DEFAULT 'yes',
  `is_deleted` varchar(10) DEFAULT 'no',
  `created_at` timestamp
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

        $this->db->query("CREATE TABLE `income` (
  `id` int primary key auto_increment,
  `inc_head_id` int,
  `name` varchar(50),
  `date` date,
  `amount` float,
  `note` text,
  `is_active` varchar(10) DEFAULT 'yes',
  `is_deleted` varchar(10) DEFAULT 'no',
  `documents` varchar(255),
  `created_at` timestamp ,
   FOREIGN KEY (inc_head_id) REFERENCES income_head (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
        $this->db->query("CREATE TABLE `item_category` (
 `id` int primary key auto_increment,
  `item_category` varchar(50),
  `is_active` varchar(10) DEFAULT 'yes',
  `description` varchar(50),
  `created_at` timestamp 
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
        $this->db->query("CREATE TABLE `item_store` (
  `id` int primary key auto_increment,
  `item_store` varchar(50),
  `code` varchar(50),
  `description` text,
  `is_active` varchar(10) DEFAULT 'yes'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
        $this->db->query("CREATE TABLE `item_supplier` (
  `id` int primary key auto_increment,
  `item_supplier` varchar(255),
  `phone` varchar(50),
  `email` varchar(50),
  `address` varchar(50),
  `contact_person_name` varchar(50),
  `contact_person_phone` varchar(50),
  `contact_person_email` varchar(50),
  `description` text,
  `is_active` varchar(10) DEFAULT 'yes'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
        $this->db->query("CREATE TABLE `item_stock` (
  `id` int primary key auto_increment,
  `item_id` int,
  `supplier_id` int,
  `symbol` varchar(10) DEFAULT '+',
  `store_id` int,
  `quantity` int,
  `date` date,
  `attachment` varchar(250),
  `description` text,
  `is_active` varchar(10) DEFAULT 'yes',
  `created_at` timestamp,
  FOREIGN KEY (supplier_id) REFERENCES item_supplier (id) ON DELETE CASCADE, 
  FOREIGN KEY (store_id) REFERENCES item_store (id) ON DELETE CASCADE 
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
        $this->db->query("CREATE TABLE `item` (
  `id` int primary key auto_increment,
  `item_category_id` int,
  `name` varchar(255),
  `item_store_id` int NULL,
  `item_supplier_id` int NULL,
  `item_photo` varchar(255),
  `description` text,
  `created_at` timestamp,
  `quantity` int,
  `date` date,
  `is_active` varchar(10) DEFAULT 'yes',
  FOREIGN KEY (item_category_id) REFERENCES item_category (id) ON DELETE CASCADE, 
  FOREIGN KEY (item_supplier_id) REFERENCES item_supplier (id) ON DELETE CASCADE, 
  FOREIGN KEY (item_store_id) REFERENCES item_store (id) ON DELETE CASCADE 
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
        $this->db->query("CREATE TABLE `item_issue` (
  `id` int primary key auto_increment,
  `item_category_id` int,
  `item_id` int,
  `issue_type` varchar(50),
  `issue_to` varchar(100),
  `issue_by` varchar(100),
  `issue_date` date,
  `return_date` date,
  `quantity` int,
  `note` text,
  `is_returned` int(2) DEFAULT '1',
  `created_at` timestamp ,
  `is_active` varchar(10) DEFAULT 'yes',
  FOREIGN KEY (item_category_id) REFERENCES item_category (id) ON DELETE CASCADE,
  FOREIGN KEY (item_id) REFERENCES item (id) ON DELETE CASCADE 
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
        $this->db->query("CREATE TABLE `userlog` (
  `id` int primary key auto_increment,
  `user` varchar(100),
  `role` varchar(100),
  `ipaddress` varchar(100),
  `user_agent` varchar(500),
  `login_datetime` timestamp
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
        $this->db->query("CREATE TABLE `messages` (
  `id` int primary key auto_increment,
  `title` varchar(200),
  `message` text,
  `send_mail` varchar(10) DEFAULT '0',
  `send_sms` varchar(10) DEFAULT '0',
  `is_group` varchar(10) DEFAULT '0',
  `is_individual` varchar(10) DEFAULT '0',
  `is_class` int(10) DEFAULT '0',
  `group_list` text,
  `user_list` text,
  `created_at` timestamp
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
        $this->db->query("CREATE TABLE `notification_setting` (
  `id` int primary key auto_increment,
  `type` varchar(100),
  `is_mail` varchar(10) DEFAULT '0',
  `is_sms` varchar(10) DEFAULT '0',
  `created_at` timestamp
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
//        === === === === === Add Colomn in feetype === === === === === === === === =
        $fields = array(
            'authkey' => array(
                'type' => 'VARCHAR',
                'constraint' => '200',
                'null' => true,
                'after' => 'api_id'
            ),
            'senderid' => array(
                'type' => 'VARCHAR',
                'constraint' => '200',
                'null' => true,
                'after' => 'authkey'
            )
        );
        $this->dbforge->add_column('sms_config', $fields);
        $fields = array(
            'guardian_email' => array(
                'type' => 'VARCHAR',
                'constraint' => '200',
                'null' => true,
                'after' => 'guardian_address'
            )
        );
        $this->dbforge->add_column('students', $fields);
        $fields = array(
            'verification_code' => array(
                'type' => 'VARCHAR',
                'constraint' => '200',
                'null' => true,
                'after' => 'role'
            )
        );
        $this->dbforge->add_column('users', $fields);
        $fields = array(
            'verification_code' => array(
                'type' => 'VARCHAR',
                'constraint' => '200',
                'null' => true,
                'after' => 'role'
            )
        );
        $this->dbforge->add_column('admin', $fields);
        $fields = array(
            'theme' => array(
                'type' => 'VARCHAR',
                'constraint' => '200',
                'null' => true,
                'after' => 'image'
            )
        );
        $this->dbforge->add_column('sch_settings', $fields);
        $fields = array(
            'documents' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
                'after' => 'amount'
            )
        );
        $this->dbforge->add_column('expenses', $fields);	


//=========add notification_setting values======
        $data = array(
            array('type' => 'student_admission'),
            array('type' => 'exam_result'),
            array('type' => 'fee_submission'),		
			array('type' => 'absent_attendence'),	
			array('type' => 'login_credential')
		);
        $this->db->insert_batch('notification_setting', $data);			
//=========add keys==========

        $data = array(
            array('key' => 'accountant'),
            array('key' => 'add_income'),
            array('key' => 'add_item_store'),
            array('key' => 'admin'),
            array('key' => 'attach_document'),
            array('key' => 'confirm_return'),
            array('key' => 'contact_person_email'),
            array('key' => 'contact_person_name'),
            array('key' => 'edit_income_head'),
            array('key' => 'edit_item_store'),
            array('key' => 'edit_item_category'),
            array('key' => 'group'),
            array('key' => 'guardians'),
            array('key' => 'income_head_list'),
            array('key' => 'income_head'),
            array('key' => 'income'),
            array('key' => 'individual'),
            array('key' => 'inventory'),
            array('key' => 'issue_by'),
            array('key' => 'issue_to'),
            array('key' => 'issue_item'),
            array('key' => 'item_store'),
            array('key' => 'item_category'),
            array('key' => 'item'),
            array('key' => 'item_stock_list'),
            array('key' => 'item_store_code'),
            array('key' => 'item_store_name'),
            array('key' => 'item_supplier_list'),
            array('key' => 'librarian'),
            array('key' => 'quantity'),
            array('key' => 'reset_password'),
            array('key' => 'return'),
            array('key' => 'returned'),
            array('key' => 'search_income'),
            array('key' => 'sms'),
            array('key' => 'store'),
            array('key' => 'supplier'),
            array('key' => 'add_item_category'),
            array('key' => 'add_item'),
            array('key' => 'add_item_stock'),
            array('key' => 'add_item_supplier'),
            array('key' => 'available_quantity'),
            array('key' => 'contact_person_phone'),
            array('key' => 'edit_item_supplier'),
            array('key' => 'edit_item'),
            array('key' => 'edit_income'),
            array('key' => 'expense_details'),
            array('key' => 'income_details'),
            array('key' => 'income_id'),
            array('key' => 'income_result'),
            array('key' => 'issued_by'),
            array('key' => 'item_category_list'),
            array('key' => 'item_list'),
            array('key' => 'item_store_list'),
            array('key' => 'item_supplier'),
            array('key' => 'contact_person'),
            array('key' => 'send_through'),
            array('key' => 'auth_Key'),
            array('key' => 'current_theme'),
            array('key' => 'guardian_email'),
            array('key' => 'hash_key'),
            array('key' => 'income_list'),
            array('key' => 'income_result'),
            array('key' => 'income_search'),
            array('key' => 'MSG_91'),
            array('key' => 'notification_setting'),
            array('key' => 'sender_id'),
            array('key' => 'SMS_country'),
            array('key' => 'Text_Local'),
            array('key' => 'user_log'),
            array('key' => 'send_email_/_sms'),
            array('key' => 'email_/_sms'),
            array('key' => 'email_/_sms_log'),
            array('key' => 'payment_methods'),
            array('key' => 'all_users'),
            array('key' => 'stripe_api_secret_key'),
            array('key' => 'stripe_publishable_key'),
            array('key' => 'payu_money_key'),
            array('key' => 'payu_money_salt'),
            array('key' => 'merchant_id'),
            array('key' => 'working_key'),
            array('key' => 'select_payment_gateway'),
            array('key' => 'exam_result'),
            array('key' => 'fees_submission'),
            array('key' => 'absent_student'),
            array('key' => 'login_credential'),
            array('key' => 'role'),
            array('key' => 'ip_address'),
            array('key' => 'login_time'),
            array('key' => 'user_agent'),
            array('key' => 'click_to_return')
        );
        $this->db->insert_batch('lang_keys', $data);
		
		$this->db->query("DROP TABLE IF EXISTS `route_vehicles`;");
    }	

    public function down() {
        
    }

}
?>