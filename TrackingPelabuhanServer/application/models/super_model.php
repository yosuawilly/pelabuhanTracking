<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of super_model
 *
 * @author LenovoDwidasa
 */
class Super_model extends CI_Model{
    
    public $table = '';
    
    public function __construct() {
        parent::__construct();
        $this->table = $this->get_table_name();
    }
    
    public function findAll() {
        $query = $this->db->get($this->table);
        return ($query->num_rows() > 0) ? $query->result() : false;
    }
    
    public function findBy($colum, $value) {
        $this->db->where($colum, $value);
        $this->db->limit(1);
        $query = $this->db->get($this->table);
        return ($query->num_rows() > 0) ? $query->row() : false;
    }
    
    public function save($data) {
        $result = array();
        $this->db->insert($this->table, $data);
        if($this->db->_error_message()){
            $result['error'] = $this->db->_error_message();
        } else $result['error'] = '';
        $result['result'] = $this->db->insert_id();
        return $result;
    }
    
    public function update_by_colum($colum, $valueColum, $data) {
        $this->db->where($colum, $valueColum);
        $this->db->update($this->table, $data);
        return $this->db->affected_rows();
    }
    
    public function update($valuePrimary, $data) {
        return $this->update_by_colum($this->get_primary_column(), $valuePrimary, $data);
    }
    
    public function delete($colum, $valueColum) {
        $this->db->where($colum, $valueColum);
        return $this->db->delete($this->table);
    }
    
    public function get_primary_column(){
        //MUST BE OVERIDE
    }
    
    public function get_table_name(){
        //MUST BE OVERIDE
    }
    
}