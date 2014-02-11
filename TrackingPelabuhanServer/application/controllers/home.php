<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of home
 *
 * @author LenovoDwidasa
 */
class Home extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
    }
    
    public function index() {
        if(!$this->my_auth->logged_in()) redirect ('auth/login', 'refresh');
        
        $this->user_data['title'] = "Home Pelabuhan Server";
        $this->user_data['home'] = true;
        
        $this->load->view('home', $this->user_data);
    }
    
    public function kapal() {
        
    }
    
    public function lokasiKapal() {
        
    }
    
}