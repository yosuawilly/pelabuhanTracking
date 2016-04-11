<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of My_auth
 *
 * @author LenovoDwidasa
 */
class My_auth {
    
    private $error;

    public function __construct() {
        $this->CI =& get_instance();
        $this->CI->load->library('session');
        $this->CI->load->helper('cookie');
        $this->CI->load->model('admin_model');
    }
    
    public function logged_in(){
        return ($this->CI->session->userdata('username') !== false) ? true : false;
    }
    
    public function login($username, $password) {
        $result = $this->CI->admin_model->get_user_info($username);
        
        if($result){
            if($password === $result->password){
                $this->CI->session->set_userdata('username', $result->username);
                return true;
            } else {
                $this->error = 'Password invalid';
                return false;
            }
        } else {
            $this->error = 'Username not found on this server';
            return false;
        }
    }
    
    public function logout() {
        $this->CI->session->unset_userdata('username');
        $this->CI->session->sess_destroy();
        $this->CI->session->sess_create();
    }
    
    public function get_error() {
        return $this->error;
    }
    
}