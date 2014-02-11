<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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
        if(!$this->my_auth->logged_in()) redirect ('auth/login', 'refresh');
        
        $this->load->model('kapal_model', 'kapal');
    }
    
    public function index() {
        $this->user_data['title'] = "Home Pelabuhan Server";
        $this->user_data['home'] = true;
        
        $this->load->view('home', $this->user_data);
    }
    
    public function kapal() {
        $data = array('kode_kapal'=>'K001', 'lat'=>'5', 'lng'=>'6');
        $result = $this->kapal->save_lokasi($data);
        if($result) {
            echo json_encode($result);
        }
//        $kapals = $this->kapal->get_lokasi('K001');
//        echo json_encode($kapals);
    }
    
    public function lokasiKapal() {
        
    }
    
}