<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

 class Admin_model extends CI_Model{
     
     public $table = 'admin';
     public $id_admin = 'id_admin';
     public $username = 'username';
     public $password = 'password';
     
     public function __construct() {
         parent::__construct();
     }
     
     public function get_user_info($username) {
         $this->db->where($this->username, $username);
         $this->db->limit(1);
         $query = $this->db->get($this->table);
         return ($query->num_rows() > 0) ? $query->row() : false;
     }
     
     public function add_admin($username, $password) {
         $rows = array();
         $rowset = array('id_admin' => 1,
                         'username' => $username,
                         'password' => $password);
         $rows[] = $rowset;
         if($this->db->insert_batch($this->table, $rows)){
             return true;
         } else return false;
     }
     
     public function set_password_admin($username, $password) {
         $data = array('password' => $password);
         $this->db->where($this->username, $username);
         return $this->db->update($this->table, $data);
     }

}